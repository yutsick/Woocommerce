<?php
/**
 * Block: Categories
 *
 * Displays WooCommerce product categories with product count.
 * Empty categories are automatically excluded.
 *
 * ACF Fields:
 * - section_title (Text) - Section heading
 * - categories_order (Select) - Sort order: name / count / menu_order
 * - exclude_categories (Taxonomy) - Categories to exclude (optional)
 */

// Get ACF fields
$section_title       = get_sub_field( 'section_title' );
$categories_order    = get_sub_field( 'categories_order' );
$exclude_categories  = get_sub_field( 'exclude_categories' );

// Default values
$section_title    = $section_title ?: 'Categories';
$categories_order = $categories_order ?: 'name';

// Build exclude array
$exclude_ids = array();
if ( ! empty( $exclude_categories ) && is_array( $exclude_categories ) ) {
	foreach ( $exclude_categories as $cat ) {
		if ( is_object( $cat ) ) {
			$exclude_ids[] = $cat->term_id;
		} elseif ( is_numeric( $cat ) ) {
			$exclude_ids[] = $cat;
		}
	}
}

// Get product categories
$args = array(
	'taxonomy'   => 'product_cat',
	'orderby'    => $categories_order,
	'order'      => 'count' === $categories_order ? 'DESC' : 'ASC',
	'hide_empty' => true, // Only show categories with products
	'exclude'    => $exclude_ids,
);

$categories = get_terms( $args );

// If no categories, return early
if ( empty( $categories ) || is_wp_error( $categories ) ) {
	return;
}
?>

<section class="categories-section py-16 bg-white">
	<div class="container mx-auto px-4">
		<!-- Section Title -->
		<h2 class="text-4xl lg:text-5xl font-bold text-[#2a2a2a] text-center mb-12">
			<?php echo esc_html( $section_title ); ?>
		</h2>

		<!-- Desktop Grid (3 columns) -->
		<div class="hidden lg:grid lg:grid-cols-3 gap-6">
			<?php foreach ( $categories as $category ) : ?>
				<?php
				$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
				$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : 'https://placehold.co/600x400/f0f0f0/666666?text=' . urlencode( $category->name );
				?>
				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"
				   class="category-card group block relative overflow-hidden rounded-lg">
					<!-- Category Image -->
					<div class="relative aspect-[4/3] overflow-hidden">
						<img src="<?php echo esc_url( $image_url ); ?>"
						     alt="<?php echo esc_attr( $category->name ); ?>"
						     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

						<!-- Overlay -->
						<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

						<!-- Product Count Badge -->
						<div class="absolute top-4 right-4 bg-[#3a3a3a] text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg">
							<?php echo esc_html( $category->count ); ?>
						</div>
					</div>

					<!-- Category Name -->
					<div class="absolute bottom-0 left-0 right-0 p-6">
						<h3 class="text-2xl font-bold text-white group-hover:text-gray-200 transition-colors">
							<?php echo esc_html( $category->name ); ?>
						</h3>
					</div>
				</a>
			<?php endforeach; ?>
		</div>

		<!-- Mobile Layout (Vertical stack) -->
		<div class="lg:hidden space-y-4">
			<?php foreach ( $categories as $category ) : ?>
				<?php
				$thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
				$image_url    = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : 'https://placehold.co/600x400/f0f0f0/666666?text=' . urlencode( $category->name );
				?>
				<a href="<?php echo esc_url( get_term_link( $category ) ); ?>"
				   class="category-card block relative overflow-hidden rounded-lg">
					<!-- Category Image -->
					<div class="relative aspect-[16/9] overflow-hidden">
						<img src="<?php echo esc_url( $image_url ); ?>"
						     alt="<?php echo esc_attr( $category->name ); ?>"
						     class="w-full h-full object-cover">

						<!-- Overlay -->
						<div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>

						<!-- Product Count Badge -->
						<div class="absolute top-4 right-4 bg-[#3a3a3a] text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-lg">
							<?php echo esc_html( $category->count ); ?>
						</div>
					</div>

					<!-- Category Name -->
					<div class="absolute bottom-0 left-0 right-0 p-6">
						<h3 class="text-2xl font-bold text-white">
							<?php echo esc_html( $category->name ); ?>
						</h3>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
