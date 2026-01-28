<?php
/**
 * Mini Cart Drawer Template
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

$cart_items = WC()->cart ? WC()->cart->get_cart() : array();
$cart_total = WC()->cart ? WC()->cart->get_total() : 0;
$cart_count = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>

<!-- Mini Cart Overlay -->
<div id="mini-cart-overlay" class="fixed inset-0 bg-black/50 z-[60]"></div>

<!-- Mini Cart Drawer -->
<div id="mini-cart-drawer" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-[70] shadow-2xl">
	<div class="flex flex-col h-full">
		<!-- Header -->
		<div class="flex items-center justify-between p-6 border-b border-gray-200">
			<h2 class="text-2xl font-bold text-[#3a3a3a]"><?php esc_html_e( 'Cart', 'allmighty' ); ?></h2>
			<button id="mini-cart-close" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" aria-label="<?php esc_attr_e( 'Close cart', 'allmighty' ); ?>">
				<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>
		</div>

		<!-- Cart Items -->
		<div id="mini-cart-items" class="flex-1 overflow-y-auto p-6">
			<?php if ( ! empty( $cart_items ) ) : ?>
				<div class="space-y-6">
					<?php foreach ( $cart_items as $cart_item_key => $cart_item ) :
						$product    = $cart_item['data'];
						$product_id = $cart_item['product_id'];
						$quantity   = $cart_item['quantity'];
						$price      = WC()->cart->get_product_price( $product );
						$thumbnail  = get_the_post_thumbnail_url( $product_id, 'thumbnail' );

						// Get variations
						$variation_data = array();
						if ( ! empty( $cart_item['variation'] ) ) {
							foreach ( $cart_item['variation'] as $attr => $value ) {
								$attr_name = str_replace( 'attribute_pa_', '', $attr );
								$attr_name = str_replace( 'attribute_', '', $attr_name );
								$variation_data[ ucfirst( $attr_name ) ] = ucfirst( $value );
							}
						}
					?>
						<div class="mini-cart-item flex gap-4" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
							<!-- Product Image -->
							<div class="w-24 h-24 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
								<?php if ( $thumbnail ) : ?>
									<img src="<?php echo esc_url( $thumbnail ); ?>"
									     alt="<?php echo esc_attr( $product->get_name() ); ?>"
									     class="w-full h-full object-cover">
								<?php else : ?>
									<div class="w-full h-full bg-gray-200 flex items-center justify-center">
										<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
										</svg>
									</div>
								<?php endif; ?>
							</div>

							<!-- Product Details -->
							<div class="flex-1">
								<div class="flex justify-between items-start">
									<h3 class="font-bold text-[#3a3a3a] leading-tight">
										"<?php echo esc_html( $product->get_name() ); ?>"
									</h3>
									<!-- Remove Button -->
									<button type="button"
									        class="mini-cart-remove text-red-400 hover:text-red-600 transition-colors p-1"
									        data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
									        aria-label="<?php esc_attr_e( 'Remove item', 'allmighty' ); ?>">
										<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
										</svg>
									</button>
								</div>

								<div class="text-[#3a3a3a] font-medium mt-1 mini-cart-item-price">
									<?php echo wp_kses_post( $price ); ?>
								</div>

								<?php if ( ! empty( $variation_data ) ) : ?>
									<div class="text-sm text-gray-500 mt-1">
										<?php
										$variation_strings = array();
										foreach ( $variation_data as $k => $v ) {
											$variation_strings[] = "$k: $v";
										}
										echo esc_html( implode( '   ', $variation_strings ) );
										?>
									</div>
								<?php endif; ?>

								<!-- Quantity Controls -->
								<div class="mini-cart-quantity flex items-center gap-1 mt-3">
									<button type="button"
									        class="mini-cart-minus w-10 h-10 flex items-center justify-center bg-gray-100 rounded-lg text-gray-600 hover:bg-gray-200 transition-colors"
									        data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
										</svg>
									</button>
									<span class="mini-cart-qty-value w-10 h-10 flex items-center justify-center bg-gray-100 text-[#3a3a3a] font-medium">
										<?php echo esc_html( $quantity ); ?>
									</span>
									<button type="button"
									        class="mini-cart-plus w-10 h-10 flex items-center justify-center bg-gray-100 rounded-lg text-gray-600 hover:bg-gray-200 transition-colors"
									        data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
										</svg>
									</button>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php else : ?>
				<div class="empty-cart text-center py-16">
					<svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
					</svg>
					<p class="text-gray-500"><?php esc_html_e( 'Your cart is empty', 'allmighty' ); ?></p>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
					   class="inline-block mt-4 px-6 py-3 bg-[#3a3a3a] text-white rounded-lg hover:bg-[#4a4a4a] transition-colors">
						<?php esc_html_e( 'Continue shopping', 'allmighty' ); ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<!-- Footer -->
		<?php if ( ! empty( $cart_items ) ) : ?>
			<div class="p-6 border-t border-gray-200">
				<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>"
				   class="block w-full py-4 bg-[#3a3a3a] text-white text-center font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
					<?php esc_html_e( 'Order', 'allmighty' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>
