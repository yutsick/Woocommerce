<?php
/**
 * AJAX Shop Handler
 *
 * Handles AJAX requests for product filtering on the products page.
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get products via AJAX.
 */
function allmighty_ajax_get_products() {
	// Verify nonce
	if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'allmighty_shop_nonce' ) ) {
		wp_send_json_error( array( 'message' => 'Invalid nonce' ) );
	}

	$category    = isset( $_POST['category'] ) ? sanitize_text_field( $_POST['category'] ) : '';
	$filters     = isset( $_POST['filters'] ) ? $_POST['filters'] : array();
	$orderby     = isset( $_POST['orderby'] ) ? sanitize_text_field( $_POST['orderby'] ) : 'date';
	$paged       = isset( $_POST['paged'] ) ? absint( $_POST['paged'] ) : 1;
	$per_page    = 12;

	// Sanitize filters
	$sanitized_filters = array();
	if ( is_array( $filters ) ) {
		foreach ( $filters as $taxonomy => $terms ) {
			$sanitized_taxonomy = sanitize_key( $taxonomy );
			if ( is_array( $terms ) ) {
				$sanitized_filters[ $sanitized_taxonomy ] = array_map( 'sanitize_text_field', $terms );
			}
		}
	}

	// Build query args
	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => $per_page,
		'paged'          => $paged,
	);

	// Orderby
	switch ( $orderby ) {
		case 'price':
			$args['meta_key'] = '_price';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'ASC';
			break;
		case 'price-desc':
			$args['meta_key'] = '_price';
			$args['orderby']  = 'meta_value_num';
			$args['order']    = 'DESC';
			break;
		case 'date':
		default:
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
			break;
	}

	// Tax query
	$tax_query = array();

	// Category filter
	if ( ! empty( $category ) && $category !== 'all' ) {
		$tax_query[] = array(
			'taxonomy' => 'product_cat',
			'field'    => 'slug',
			'terms'    => $category,
		);
	}

	// Dynamic attribute filters
	foreach ( $sanitized_filters as $taxonomy => $terms ) {
		if ( ! empty( $terms ) ) {
			$tax_query[] = array(
				'taxonomy' => $taxonomy,
				'field'    => 'slug',
				'terms'    => $terms,
				'operator' => 'IN',
			);
		}
	}

	if ( ! empty( $tax_query ) ) {
		$tax_query['relation'] = 'AND';
		$args['tax_query']     = $tax_query;
	}

	$query = new WP_Query( $args );

	// Get products HTML
	ob_start();
	if ( $query->have_posts() ) :
		while ( $query->have_posts() ) :
			$query->the_post();
			global $product;
			$product = wc_get_product( get_the_ID() );

			allmighty_render_product_card( $product );
		endwhile;
		wp_reset_postdata();
	else :
		?>
		<div class="col-span-full text-center py-16">
			<p class="text-gray-500 text-lg"><?php esc_html_e( 'No products found.', 'allmighty' ); ?></p>
		</div>
		<?php
	endif;
	$products_html = ob_get_clean();

	// Get pagination HTML
	ob_start();
	allmighty_render_pagination( $query, $paged );
	$pagination_html = ob_get_clean();

	// Get available filters for current category
	$available_filters = allmighty_get_available_filters( $category );

	// Get category info for breadcrumbs
	$breadcrumb_category = '';
	if ( ! empty( $category ) && $category !== 'all' ) {
		$term = get_term_by( 'slug', $category, 'product_cat' );
		if ( $term && ! is_wp_error( $term ) ) {
			$breadcrumb_category = $term->name;
		}
	}

	wp_send_json_success( array(
		'products'            => $products_html,
		'pagination'          => $pagination_html,
		'filters'             => $available_filters,
		'breadcrumb_category' => $breadcrumb_category,
		'found_posts'         => $query->found_posts,
		'max_pages'           => $query->max_num_pages,
	) );
}
add_action( 'wp_ajax_allmighty_get_products', 'allmighty_ajax_get_products' );
add_action( 'wp_ajax_nopriv_allmighty_get_products', 'allmighty_ajax_get_products' );

/**
 * Get available filters for a category.
 * Dynamically fetches ALL product attributes used by products in the category.
 *
 * @param string $category Category slug or 'all'.
 * @return array
 */
function allmighty_get_available_filters( $category = 'all' ) {
	$filters = array();

	// Get product IDs in the category
	$args = array(
		'post_type'      => 'product',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
	);

	if ( ! empty( $category ) && $category !== 'all' ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $category,
			),
		);
	}

	$product_ids = get_posts( $args );

	if ( empty( $product_ids ) ) {
		return $filters;
	}

	// Get all product attribute taxonomies
	$attribute_taxonomies = wc_get_attribute_taxonomies();

	if ( empty( $attribute_taxonomies ) ) {
		return $filters;
	}

	foreach ( $attribute_taxonomies as $attribute ) {
		$taxonomy_name = wc_attribute_taxonomy_name( $attribute->attribute_name );

		// Get terms used by these products
		$terms = wp_get_object_terms( $product_ids, $taxonomy_name, array(
			'orderby' => 'name',
			'order'   => 'ASC',
		) );

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			// Remove duplicates (same term can be on multiple products)
			$unique_terms = array();
			$seen_slugs   = array();

			foreach ( $terms as $term ) {
				if ( ! in_array( $term->slug, $seen_slugs, true ) ) {
					$unique_terms[] = array(
						'slug' => $term->slug,
						'name' => $term->name,
					);
					$seen_slugs[] = $term->slug;
				}
			}

			if ( ! empty( $unique_terms ) ) {
				$filters[] = array(
					'taxonomy' => $taxonomy_name,
					'label'    => $attribute->attribute_label,
					'terms'    => $unique_terms,
				);
			}
		}
	}

	return $filters;
}

/**
 * Render a product card.
 *
 * @param WC_Product $product The product object.
 */
function allmighty_render_product_card( $product ) {
	if ( ! $product ) {
		return;
	}

	$product_id        = $product->get_id();
	$product_name      = $product->get_name();
	$product_link      = get_permalink( $product_id );
	$product_image     = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'woocommerce_thumbnail' );
	$product_image_url = $product_image ? $product_image[0] : wc_placeholder_img_src( 'woocommerce_thumbnail' );

	// Check for badges
	$is_bestseller = has_term( 'bestseller', 'product_tag', $product_id ) || get_field( 'is_bestseller', $product_id );
	$is_on_sale    = $product->is_on_sale();
	?>
	<article class="product-card group">
		<a href="<?php echo esc_url( $product_link ); ?>" class="block">
			<!-- Image Container -->
			<div class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
				<!-- Badges -->
				<?php if ( $is_bestseller ) : ?>
					<span class="absolute top-3 left-3 px-3 py-1 bg-[#E5B94E] text-[#3a3a3a] text-xs font-bold rounded z-10">
						<?php esc_html_e( 'Bestseller', 'allmighty' ); ?>
					</span>
				<?php endif; ?>

				<?php if ( $is_on_sale ) : ?>
					<span class="absolute top-3 <?php echo $is_bestseller ? 'left-24' : 'left-3'; ?> px-3 py-1 bg-[#3a3a3a] text-white text-xs font-bold rounded z-10">
						<?php esc_html_e( 'Sale', 'allmighty' ); ?>
					</span>
				<?php endif; ?>

				<!-- Product Image -->
				<img src="<?php echo esc_url( $product_image_url ); ?>"
				     alt="<?php echo esc_attr( $product_name ); ?>"
				     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
				     loading="lazy">
			</div>

			<!-- Product Title -->
			<h3 class="text-center text-[#3a3a3a] font-medium">
				<?php echo esc_html( $product_name ); ?>
			</h3>
		</a>
	</article>
	<?php
}

/**
 * Render pagination.
 *
 * @param WP_Query $query       The query object.
 * @param int      $current_page Current page number.
 */
function allmighty_render_pagination( $query, $current_page = 1 ) {
	$total_pages = $query->max_num_pages;

	if ( $total_pages <= 1 ) {
		return;
	}
	?>
	<nav class="pagination-nav mt-12 flex items-center justify-center gap-2">
		<?php
		// Previous arrow
		if ( $current_page > 1 ) :
			?>
			<button type="button"
			        class="pagination-btn w-10 h-10 flex items-center justify-center text-gray-400 hover:text-[#3a3a3a] transition-colors"
			        data-page="<?php echo esc_attr( $current_page - 1 ); ?>">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
				</svg>
			</button>
			<?php
		else :
			?>
			<span class="w-10 h-10 flex items-center justify-center text-gray-300">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
				</svg>
			</span>
			<?php
		endif;

		// Page numbers
		for ( $i = 1; $i <= $total_pages; $i++ ) :
			if ( $i === $current_page ) :
				?>
				<span class="w-10 h-10 flex items-center justify-center text-[#3a3a3a] font-bold">
					<?php echo esc_html( $i ); ?>
				</span>
				<?php
			else :
				?>
				<button type="button"
				        class="pagination-btn w-10 h-10 flex items-center justify-center text-gray-400 hover:text-[#3a3a3a] transition-colors"
				        data-page="<?php echo esc_attr( $i ); ?>">
					<?php echo esc_html( $i ); ?>
				</button>
				<?php
			endif;
		endfor;

		// Next arrow
		if ( $current_page < $total_pages ) :
			?>
			<button type="button"
			        class="pagination-btn w-10 h-10 flex items-center justify-center text-gray-400 hover:text-[#3a3a3a] transition-colors"
			        data-page="<?php echo esc_attr( $current_page + 1 ); ?>">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
				</svg>
			</button>
			<?php
		else :
			?>
			<span class="w-10 h-10 flex items-center justify-center text-gray-300">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
				</svg>
			</span>
			<?php
		endif;
		?>
	</nav>
	<?php
}

/**
 * Render filters HTML.
 *
 * @param array $filters The filters array.
 * @param array $selected_filters Currently selected filters.
 * @return string
 */
function allmighty_render_filters_html( $filters, $selected_filters = array() ) {
	if ( empty( $filters ) ) {
		return '<p class="text-gray-500 text-center py-8">' . esc_html__( 'No filters available for these products.', 'allmighty' ) . '</p>';
	}

	ob_start();
	foreach ( $filters as $filter ) :
		$taxonomy = $filter['taxonomy'];
		$selected = isset( $selected_filters[ $taxonomy ] ) ? $selected_filters[ $taxonomy ] : array();
		?>
		<div class="filter-group mb-8" data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>">
			<h3 class="font-semibold mb-4 text-[#3a3a3a]"><?php echo esc_html( $filter['label'] ); ?></h3>
			<div class="filter-terms">
				<?php foreach ( $filter['terms'] as $term ) : ?>
					<label class="flex items-center gap-3 mb-3 cursor-pointer hover:text-[#3a3a3a] transition-colors">
						<input type="checkbox"
						       name="<?php echo esc_attr( $taxonomy ); ?>[]"
						       value="<?php echo esc_attr( $term['slug'] ); ?>"
						       <?php checked( in_array( $term['slug'], $selected, true ) ); ?>
						       class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]"
						       data-taxonomy="<?php echo esc_attr( $taxonomy ); ?>">
						<span><?php echo esc_html( $term['name'] ); ?></span>
					</label>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	endforeach;
	return ob_get_clean();
}
