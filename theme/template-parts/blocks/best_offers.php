<?php
/**
 * Block: Best Offers
 *
 * Displays popular/featured products in a grid (desktop) or slider (mobile).
 *
 * ACF Fields:
 * - section_title (Text) - Section heading
 * - products_source (Select) - Popular Products / Featured Products / Manual Selection
 * - products_count (Number) - How many products to display (default: 6)
 * - products (Relationship) - Manual product selection (if source is Manual)
 */

// Get ACF fields
$section_title    = get_sub_field( 'section_title' );
$products_source  = get_sub_field( 'products_source' );
$products_count   = get_sub_field( 'products_count' );
$manual_products  = get_sub_field( 'products' );

// Default values
$section_title   = $section_title ?: 'Best offers';
$products_source = $products_source ?: 'popular';
$products_count  = $products_count ?: 6;

// Get products based on source
$products = array();

if ( 'manual' === $products_source && ! empty( $manual_products ) ) {
	// Manual selection
	$products = $manual_products;
} else {
	// Query WooCommerce products
	$args = array(
		'limit'   => $products_count,
		'status'  => 'publish',
		'orderby' => 'popularity' === $products_source ? 'popularity' : 'date',
	);

	// If featured products
	if ( 'featured' === $products_source ) {
		$args['featured'] = true;
	}

	$products = wc_get_products( $args );
}

// If no products, return early
if ( empty( $products ) ) {
	return;
}
?>

<section class="best-offers py-16 bg-white">
	<div class="container mx-auto px-4">
		<!-- Section Title -->
		<h2 class="text-4xl lg:text-5xl font-bold text-[#2a2a2a] text-center mb-12">
			<?php echo esc_html( $section_title ); ?>
		</h2>

		<!-- Desktop Grid -->
		<div class="hidden lg:grid lg:grid-cols-3 gap-8">

			<?php foreach ( $products as $product_item ) : ?>
				<?php

				$p_id = is_numeric( $product_item ) ? $product_item : $product_item->ID;

				$product = wc_get_product( $p_id );
				if ( ! is_a( $product, 'WC_Product' ) ) {
					continue;
				}
				?>
				<div class="product-card group">
					<!-- Product Image -->
					<div class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
						<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block h-full">
							<?php if ( $product->get_image_id() ) : ?>
								<?php echo wp_get_attachment_image( $product->get_image_id(), 'woocommerce_thumbnail', false, array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-300' ) ); ?>
							<?php else : ?>
								<img src="https://placehold.co/400x400/f0f0f0/666666?text=<?php echo urlencode( $product->get_name() ); ?>"
								     alt="<?php echo esc_attr( $product->get_name() ); ?>"
								     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
							<?php endif; ?>
						</a>

						<!-- Hover Overlay with Price & Button -->
						<div class="product-hover-overlay absolute inset-x-0 bottom-0 p-4 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
							<div class="flex items-center justify-between">
								<!-- Price -->
								<div class="text-xl font-bold text-white">
									<?php echo $product->get_price_html(); ?>
								</div>

								<!-- Add to Cart Button -->
								<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
								   data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
								   class="inline-block bg-white text-[#3a3a3a] px-6 py-2 rounded-lg font-medium hover:bg-gray-100 transition-colors ajax_add_to_cart add_to_cart_button"
								   data-quantity="1">
									<?php echo esc_html( $product->add_to_cart_text() ); ?>
								</a>
							</div>
						</div>
					</div>

					<!-- Product Name -->
					<div class="text-center">
						<h3 class="text-xl font-semibold text-[#2a2a2a]">
							<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="hover:text-[#4a4a4a] transition-colors">
								<?php echo esc_html( $product->get_name() ); ?>
							</a>
						</h3>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Mobile Slider -->
		<div class="lg:hidden">
			<div class="swiper best-offers-swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $products as $product_item ) : ?>
						<?php
					
							$p_id = is_numeric( $product_item ) ? $product_item : $product_item->ID;					

				$product = wc_get_product( $p_id );
						
						if ( ! is_a( $product, 'WC_Product' ) ) {
							continue;
						}
						?>
						<div class="swiper-slide">
							<div class="product-card">
								<!-- Product Image -->
								<div class="relative aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
									<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block">
										<?php if ( $product->get_image_id() ) : ?>
											<?php echo wp_get_attachment_image( $product->get_image_id(), 'woocommerce_thumbnail', false, array( 'class' => 'w-full h-full object-cover' ) ); ?>
										<?php else : ?>
											<img src="https://placehold.co/600x600/f0f0f0/666666?text=<?php echo urlencode( $product->get_name() ); ?>"
											     alt="<?php echo esc_attr( $product->get_name() ); ?>"
											     class="w-full h-full object-cover">
										<?php endif; ?>
									</a>

									<!-- Price Badge (Mobile) -->
									<div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm px-4 py-2 rounded-lg">
										<div class="text-xl font-bold text-[#3a3a3a]">
											<?php echo $product->get_price_html(); ?>
										</div>
									</div>

									<!-- Add to Cart Button (Mobile) -->
									<div class="absolute bottom-4 right-4">
										<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>"
										   data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
										   class="inline-block bg-[#3a3a3a] text-white px-6 py-3 rounded-lg font-medium hover:bg-[#2a2a2a] transition-colors ajax_add_to_cart add_to_cart_button"
										   data-quantity="1">
											<?php echo esc_html( $product->add_to_cart_text() ); ?>
										</a>
									</div>
								</div>

								<!-- Product Name -->
								<h3 class="text-2xl font-semibold text-[#2a2a2a] text-center">
									<a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="hover:text-[#4a4a4a] transition-colors">
										<?php echo esc_html( $product->get_name() ); ?>
									</a>
								</h3>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Navigation Arrows -->
				<div class="flex items-center justify-center gap-4 mt-8">
					<button class="swiper-button-prev-custom w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
						<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
						</svg>
					</button>
					<button class="swiper-button-next-custom w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
						<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
