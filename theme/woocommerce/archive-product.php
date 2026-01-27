<?php
/**
 * The Template for displaying product archives, including the main shop page.
 *
 * This template overrides WooCommerce's default archive-product.php
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Get current category
$current_category = get_queried_object();
$is_shop          = is_shop();
$is_category      = is_product_category();

// Get all product categories for the filter
$product_categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
) );

// Get product attributes for filters
$size_attribute  = wc_get_attribute_taxonomy_id( 'size' );
$color_attribute = wc_get_attribute_taxonomy_id( 'color' );

// Get sizes
$sizes = get_terms( array(
	'taxonomy'   => 'pa_size',
	'hide_empty' => true,
) );

// Get colors
$colors = get_terms( array(
	'taxonomy'   => 'pa_color',
	'hide_empty' => true,
) );

// Current filters from URL
$current_sort     = isset( $_GET['orderby'] ) ? sanitize_text_field( $_GET['orderby'] ) : 'date';
$current_category_filter = isset( $_GET['product_cat'] ) ? sanitize_text_field( $_GET['product_cat'] ) : '';
$current_sizes    = isset( $_GET['filter_size'] ) ? array_map( 'sanitize_text_field', (array) $_GET['filter_size'] ) : array();
$current_colors   = isset( $_GET['filter_color'] ) ? array_map( 'sanitize_text_field', (array) $_GET['filter_color'] ) : array();

// Sort options
$sort_options = array(
	'date'       => __( 'New arrivals', 'allmighty' ),
	'price-desc' => __( 'Price from higher', 'allmighty' ),
	'price'      => __( 'Price from lower', 'allmighty' ),
);
?>

<!-- Breadcrumbs -->
<section class="breadcrumbs-section bg-white">
	<div class="container mx-auto px-4">
		<div class="h-16 lg:h-20 flex items-center">
			<?php if ( function_exists( 'yoast_breadcrumb' ) ) : ?>
				<?php yoast_breadcrumb( '<nav class="breadcrumbs text-sm text-[#626262]">', '</nav>' ); ?>
			<?php else : ?>
				<nav class="breadcrumbs text-sm text-[#626262]">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#3a3a3a] transition-colors">
						<?php esc_html_e( 'Almighty Victory', 'allmighty' ); ?>
					</a>
					<span class="mx-2">/</span>
					<?php if ( $is_category && $current_category ) : ?>
						<span><?php echo esc_html( $current_category->name ); ?></span>
					<?php else : ?>
						<span><?php esc_html_e( 'Shop', 'allmighty' ); ?></span>
					<?php endif; ?>
				</nav>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Hero Section -->
<section class="catalog-hero relative overflow-hidden">
	<?php
	// Get hero image from ACF (category or shop page)
	$hero_image_mobile  = '';
	$hero_image_desktop = '';
	$hero_text          = __( 'Each piece carries a quiet prayer — unseen, but deeply felt.', 'allmighty' );

	if ( $is_category && $current_category ) {
		$hero_image_mobile  = get_field( 'category_hero_mobile', 'product_cat_' . $current_category->term_id );
		$hero_image_desktop = get_field( 'category_hero_desktop', 'product_cat_' . $current_category->term_id );
		$custom_hero_text   = get_field( 'category_hero_text', 'product_cat_' . $current_category->term_id );
		if ( $custom_hero_text ) {
			$hero_text = $custom_hero_text;
		}
	} else {
		// Shop page - get from ACF options or use defaults
		$hero_image_mobile  = get_field( 'shop_hero_mobile', 'option' );
		$hero_image_desktop = get_field( 'shop_hero_desktop', 'option' );
		$custom_hero_text   = get_field( 'shop_hero_text', 'option' );
		if ( $custom_hero_text ) {
			$hero_text = $custom_hero_text;
		}
	}

	// Fallback images
	$hero_image_mobile  = $hero_image_mobile ?: 'https://placehold.co/768x200/3a3a3a/ffffff?text=Hero+Mobile';
	$hero_image_desktop = $hero_image_desktop ?: 'https://placehold.co/1920x300/3a3a3a/ffffff?text=Hero+Desktop';
	?>

	<!-- Mobile Hero -->
	<div class="lg:hidden relative">
		<img src="<?php echo esc_url( $hero_image_mobile ); ?>"
		     alt="<?php echo esc_attr( $hero_text ); ?>"
		     class="w-full h-auto object-cover">
		<div class="absolute inset-0 flex items-center justify-center bg-black/30">
			<p class="text-white text-center text-lg italic px-8 max-w-md">
				<?php echo esc_html( $hero_text ); ?>
			</p>
		</div>
	</div>

	<!-- Desktop Hero -->
	<div class="hidden lg:block relative">
		<img src="<?php echo esc_url( $hero_image_desktop ); ?>"
		     alt="<?php echo esc_attr( $hero_text ); ?>"
		     class="w-full h-auto object-cover">
		<div class="absolute inset-0 flex items-center justify-center">
			<p class="text-white text-center text-2xl italic max-w-2xl">
				<?php echo esc_html( $hero_text ); ?>
			</p>
		</div>
	</div>
</section>

<!-- Categories Section -->
<section class="categories-section bg-[#3a3a3a] py-8">
	<div class="container mx-auto px-4">
		<h2 class="text-white text-2xl lg:text-3xl font-light text-center mb-6">
			<?php esc_html_e( 'Categories', 'allmighty' ); ?>
		</h2>

		<?php if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) : ?>
			<div class="flex flex-wrap justify-center gap-4">
				<?php foreach ( $product_categories as $cat ) :
					$cat_count = $cat->count;
					$is_active = ( $is_category && $current_category && $current_category->term_id === $cat->term_id );
				?>
					<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"
					   class="category-card flex items-center justify-between min-w-[200px] px-6 py-4 rounded-lg border-2 transition-all <?php echo $is_active ? 'bg-white text-[#3a3a3a] border-white' : 'bg-transparent text-white border-white/30 hover:border-white'; ?>">
						<span class="font-medium"><?php echo esc_html( $cat->name ); ?></span>
						<span class="ml-4 w-8 h-8 flex items-center justify-center rounded-full <?php echo $is_active ? 'bg-[#3a3a3a] text-white' : 'bg-white/20 text-white'; ?> text-sm font-bold">
							<?php echo esc_html( $cat_count ); ?>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<!-- Toolbar Section -->
<section class="toolbar-section bg-[#3a3a3a] pb-8">
	<div class="container mx-auto px-4">
		<div class="flex items-center justify-between">
			<!-- Filters Button -->
			<button id="filters-toggle"
			        class="flex items-center gap-2 px-6 py-3 bg-[#4a4a4a] text-white rounded-lg hover:bg-[#5a5a5a] transition-colors">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
				</svg>
				<span><?php esc_html_e( 'Filters', 'allmighty' ); ?></span>
			</button>

			<!-- Sort Dropdown -->
			<div class="relative">
				<button id="sort-toggle"
				        class="flex items-center gap-2 px-6 py-3 bg-transparent text-white border border-white/30 rounded-lg hover:border-white transition-colors">
					<span id="sort-label"><?php echo esc_html( $sort_options[ $current_sort ] ?? $sort_options['date'] ); ?></span>
					<svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
					</svg>
				</button>

				<!-- Sort Dropdown Menu -->
				<div id="sort-dropdown"
				     class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl z-20 hidden">
					<?php foreach ( $sort_options as $value => $label ) : ?>
						<a href="<?php echo esc_url( add_query_arg( 'orderby', $value ) ); ?>"
						   class="block px-4 py-3 text-[#3a3a3a] hover:bg-gray-100 transition-colors <?php echo $current_sort === $value ? 'font-bold' : ''; ?> <?php echo $value === 'date' ? 'rounded-t-lg' : ''; ?> <?php echo $value === 'price' ? 'rounded-b-lg' : ''; ?>">
							<?php echo esc_html( $label ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Filter Modal (Mobile Fullscreen) -->
<div id="filter-modal" class="fixed inset-0 bg-gray-50 z-50 lg:hidden overflow-y-auto">
	<div class="min-h-full flex flex-col">
		<!-- Header -->
		<div class="flex items-center justify-between p-6 border-b border-gray-200">
			<h2 class="text-2xl font-bold text-[#3a3a3a]"><?php esc_html_e( 'Filter', 'allmighty' ); ?></h2>
			<button id="filter-close" class="p-2 hover:bg-gray-200 rounded-lg transition-colors">
				<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>
		</div>

		<!-- Filter Content -->
		<form id="filter-form" class="flex-1 p-6 space-y-8">
			<!-- Type (Categories) -->
			<div class="filter-group">
				<h3 class="text-lg font-semibold text-[#3a3a3a] mb-4"><?php esc_html_e( 'Type', 'allmighty' ); ?></h3>
				<div class="space-y-3">
					<?php foreach ( $product_categories as $cat ) : ?>
						<label class="flex items-center gap-3 cursor-pointer">
							<input type="checkbox"
							       name="product_cat[]"
							       value="<?php echo esc_attr( $cat->slug ); ?>"
							       <?php checked( in_array( $cat->slug, (array) $current_category_filter, true ) ); ?>
							       class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]">
							<span class="text-[#3a3a3a]"><?php echo esc_html( $cat->name ); ?></span>
						</label>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Size -->
			<?php if ( ! empty( $sizes ) && ! is_wp_error( $sizes ) ) : ?>
				<div class="filter-group">
					<h3 class="text-lg font-semibold text-[#3a3a3a] mb-4"><?php esc_html_e( 'Size', 'allmighty' ); ?></h3>
					<div class="space-y-3">
						<?php foreach ( $sizes as $size ) : ?>
							<label class="flex items-center gap-3 cursor-pointer">
								<input type="checkbox"
								       name="filter_size[]"
								       value="<?php echo esc_attr( $size->slug ); ?>"
								       <?php checked( in_array( $size->slug, $current_sizes, true ) ); ?>
								       class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]">
								<span class="text-[#3a3a3a]"><?php echo esc_html( $size->name ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Color -->
			<?php if ( ! empty( $colors ) && ! is_wp_error( $colors ) ) : ?>
				<div class="filter-group">
					<h3 class="text-lg font-semibold text-[#3a3a3a] mb-4"><?php esc_html_e( 'Main color', 'allmighty' ); ?></h3>
					<div class="space-y-3">
						<?php foreach ( $colors as $color ) : ?>
							<label class="flex items-center gap-3 cursor-pointer">
								<input type="checkbox"
								       name="filter_color[]"
								       value="<?php echo esc_attr( $color->slug ); ?>"
								       <?php checked( in_array( $color->slug, $current_colors, true ) ); ?>
								       class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]">
								<span class="text-[#3a3a3a]"><?php echo esc_html( $color->name ); ?></span>
							</label>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</form>

		<!-- Apply Button -->
		<div class="p-6 border-t border-gray-200">
			<button type="submit"
			        form="filter-form"
			        class="w-full py-4 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
				<?php esc_html_e( 'Apply', 'allmighty' ); ?>
			</button>
		</div>
	</div>
</div>

<!-- Products Grid Section -->
<section class="products-section bg-white py-8 lg:py-12">
	<div class="container mx-auto px-4">
		<?php if ( woocommerce_product_loop() ) : ?>
			<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
				<?php
				while ( have_posts() ) :
					the_post();
					global $product;

					// Get product data
					$product_id    = $product->get_id();
					$product_name  = $product->get_name();
					$product_link  = get_permalink( $product_id );
					$product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'woocommerce_thumbnail' );
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
								     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
							</div>

							<!-- Product Title -->
							<h3 class="text-center text-[#3a3a3a] font-medium">
								<?php echo esc_html( $product_name ); ?>
							</h3>
						</a>
					</article>
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<nav class="pagination-nav mt-12 flex items-center justify-center gap-2">
				<?php
				$total_pages = wc_get_loop_prop( 'total_pages' );
				$current_page = max( 1, get_query_var( 'paged' ) );

				if ( $total_pages > 1 ) :
					// Previous arrow
					if ( $current_page > 1 ) :
						?>
						<a href="<?php echo esc_url( get_pagenum_link( $current_page - 1 ) ); ?>"
						   class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-[#3a3a3a] transition-colors">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
							</svg>
						</a>
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
							<a href="<?php echo esc_url( get_pagenum_link( $i ) ); ?>"
							   class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-[#3a3a3a] transition-colors">
								<?php echo esc_html( $i ); ?>
							</a>
							<?php
						endif;
					endfor;

					// Next arrow
					if ( $current_page < $total_pages ) :
						?>
						<a href="<?php echo esc_url( get_pagenum_link( $current_page + 1 ) ); ?>"
						   class="w-10 h-10 flex items-center justify-center text-gray-400 hover:text-[#3a3a3a] transition-colors">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
							</svg>
						</a>
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
				endif;
				?>
			</nav>

		<?php else : ?>
			<div class="text-center py-16">
				<p class="text-gray-500 text-lg"><?php esc_html_e( 'No products found.', 'allmighty' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php
// SEO Text Block (ACF)
// This can be added via ACF to the Shop page or Category pages
$seo_title   = '';
$seo_content = '';

if ( $is_category && $current_category ) {
	$seo_title   = get_field( 'seo_title', 'product_cat_' . $current_category->term_id );
	$seo_content = get_field( 'seo_content', 'product_cat_' . $current_category->term_id );
} else {
	$seo_title   = get_field( 'seo_title', 'option' );
	$seo_content = get_field( 'seo_content', 'option' );
}

if ( $seo_content ) :
	$show_more_text = __( 'Show more', 'allmighty' );
	$show_less_text = __( 'Show less', 'allmighty' );
	$preview_lines  = 4;
	$block_id       = 'seo-text-catalog';
	?>
	<section class="seo-text-block py-16 bg-white">
		<div class="container mx-auto px-4">
			<?php if ( $seo_title ) : ?>
				<h2 class="text-3xl lg:text-4xl font-bold text-gray-600 mb-6">
					<?php echo esc_html( $seo_title ); ?>
				</h2>
			<?php endif; ?>

			<div class="seo-content-wrapper relative">
				<div id="<?php echo esc_attr( $block_id ); ?>"
				     class="seo-text-content overflow-hidden transition-all duration-500 ease-in-out"
				     style="max-height: <?php echo esc_attr( $preview_lines * 1.75 ); ?>rem;"
				     data-collapsed="true">
					<div class="text-gray-600 text-base lg:text-lg leading-relaxed prose prose-lg max-w-none">
						<?php echo wp_kses_post( wpautop( $seo_content ) ); ?>
					</div>
				</div>

				<div id="<?php echo esc_attr( $block_id ); ?>-overlay"
				     class="fade-overlay absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent pointer-events-none transition-opacity duration-500">
				</div>

				<button id="<?php echo esc_attr( $block_id ); ?>-button"
				        class="mt-6 bg-gray-100 text-gray-600 px-8 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors"
				        data-show-more="<?php echo esc_attr( $show_more_text ); ?>"
				        data-show-less="<?php echo esc_attr( $show_less_text ); ?>">
					<?php echo esc_html( $show_more_text ); ?>
				</button>
			</div>
		</div>
	</section>

	<script>
	(function() {
		const content = document.getElementById('<?php echo esc_js( $block_id ); ?>');
		const button = document.getElementById('<?php echo esc_js( $block_id ); ?>-button');
		const overlay = document.getElementById('<?php echo esc_js( $block_id ); ?>-overlay');

		if (content && button) {
			button.addEventListener('click', function() {
				const isCollapsed = content.getAttribute('data-collapsed') === 'true';

				if (isCollapsed) {
					content.style.maxHeight = content.scrollHeight + 'px';
					content.setAttribute('data-collapsed', 'false');
					button.textContent = button.getAttribute('data-show-less');
					if (overlay) overlay.style.opacity = '0';
				} else {
					content.style.maxHeight = '<?php echo esc_js( $preview_lines * 1.75 ); ?>rem';
					content.setAttribute('data-collapsed', 'true');
					button.textContent = button.getAttribute('data-show-more');
					if (overlay) overlay.style.opacity = '1';
				}
			});
		}
	})();
	</script>
<?php endif; ?>

<?php
// Use footer-form.php (without logo)
get_footer( 'form' );
