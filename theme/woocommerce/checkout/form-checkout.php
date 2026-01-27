<?php
/**
 * Custom One-Page Checkout Template
 *
 * This template overrides the default WooCommerce checkout form.
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

// Get cart contents
$cart_items = WC()->cart->get_cart();
$cart_total = WC()->cart->get_total();

// Check if cart is empty
if ( empty( $cart_items ) ) {
	wc_print_notice( __( 'Your cart is empty.', 'allmighty' ), 'notice' );
	return;
}

// Get available shipping methods
$shipping_methods = array(
	'nova_post'   => __( 'Nova post', 'allmighty' ),
	'ukrposhta'   => __( 'Ukrposhta', 'allmighty' ),
	'self_pickup' => __( 'Self pickup', 'allmighty' ),
);

// Payment methods
$payment_methods = array(
	'online'          => __( 'Online payment', 'allmighty' ),
	'cash_on_delivery' => __( 'Cash on delivery', 'allmighty' ),
);

do_action( 'woocommerce_before_checkout_form', $checkout );
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
					<span><?php esc_html_e( 'Order', 'allmighty' ); ?></span>
				</nav>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Checkout Content -->
<section class="checkout-section py-8 lg:py-12 bg-white">
	<div class="container mx-auto px-4">
		<form id="checkout-form" class="checkout-form" method="post" action="<?php echo esc_url( wc_get_checkout_url() ); ?>">
			<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">

				<!-- Left Column - Checkout Form -->
				<div class="lg:col-span-7">
					<h1 class="text-2xl lg:text-3xl font-bold text-[#3a3a3a] mb-8">
						<?php esc_html_e( 'Delivery details', 'allmighty' ); ?>
					</h1>

					<!-- Contacts Section -->
					<div class="checkout-section-group mb-8">
						<h2 class="text-lg font-bold text-[#3a3a3a] mb-4">
							<?php esc_html_e( 'Contacts', 'allmighty' ); ?>
						</h2>

						<div class="space-y-4">
							<!-- Full Name -->
							<div class="form-group">
								<label for="billing_name" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'Your full name', 'allmighty' ); ?> <span class="text-red-500">*</span>
								</label>
								<input type="text"
								       id="billing_name"
								       name="billing_name"
								       required
								       placeholder="<?php esc_attr_e( 'Name', 'allmighty' ); ?>"
								       class="checkout-input w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] placeholder-gray-400 focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
							</div>

							<!-- Phone -->
							<div class="form-group">
								<label for="billing_phone" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'Phone number', 'allmighty' ); ?> <span class="text-red-500">*</span>
								</label>
								<input type="tel"
								       id="billing_phone"
								       name="billing_phone"
								       required
								       placeholder="<?php esc_attr_e( 'Phone', 'allmighty' ); ?>"
								       class="checkout-input w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] placeholder-gray-400 focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
							</div>

							<!-- Email -->
							<div class="form-group">
								<label for="billing_email" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'E-mail', 'allmighty' ); ?>
								</label>
								<input type="email"
								       id="billing_email"
								       name="billing_email"
								       placeholder="<?php esc_attr_e( 'E-mail', 'allmighty' ); ?>"
								       class="checkout-input w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] placeholder-gray-400 focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
							</div>
						</div>
					</div>

					<!-- Delivery Section -->
					<div class="checkout-section-group mb-8">
						<h2 class="text-lg font-bold text-[#3a3a3a] mb-4">
							<?php esc_html_e( 'Delivery', 'allmighty' ); ?>
						</h2>

						<div class="space-y-4">
							<!-- City -->
							<div class="form-group">
								<label for="shipping_city" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'Delivery city', 'allmighty' ); ?> <span class="text-red-500">*</span>
								</label>
								<input type="text"
								       id="shipping_city"
								       name="shipping_city"
								       required
								       placeholder="<?php esc_attr_e( 'City', 'allmighty' ); ?>"
								       class="checkout-input w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] placeholder-gray-400 focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
							</div>

							<!-- Delivery Service -->
							<div class="form-group">
								<label for="shipping_method" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'Delivery service', 'allmighty' ); ?> <span class="text-red-500">*</span>
								</label>
								<div class="relative">
									<select id="shipping_method"
									        name="shipping_method"
									        required
									        class="checkout-select w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] appearance-none cursor-pointer focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
										<?php foreach ( $shipping_methods as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>
									<svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
								</div>
							</div>

							<!-- Address -->
							<div class="form-group">
								<label for="shipping_address" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'Delivery address', 'allmighty' ); ?> <span class="text-red-500">*</span>
								</label>
								<input type="text"
								       id="shipping_address"
								       name="shipping_address"
								       required
								       placeholder="<?php esc_attr_e( 'Address', 'allmighty' ); ?>"
								       class="checkout-input w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] placeholder-gray-400 focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
							</div>
						</div>
					</div>

					<!-- Payment Method Section -->
					<div class="checkout-section-group mb-8">
						<h2 class="text-lg font-bold text-[#3a3a3a] mb-4">
							<?php esc_html_e( 'Payment method', 'allmighty' ); ?>
						</h2>

						<div class="space-y-4">
							<!-- Payment Method Select -->
							<div class="form-group">
								<label for="payment_method" class="block text-sm text-[#3a3a3a] mb-2">
									<?php esc_html_e( 'Payment method', 'allmighty' ); ?> <span class="text-red-500">*</span>
								</label>
								<div class="relative">
									<select id="payment_method"
									        name="payment_method"
									        required
									        class="checkout-select w-full px-4 py-3 bg-gray-100 border-0 rounded-lg text-[#3a3a3a] appearance-none cursor-pointer focus:ring-2 focus:ring-[#3a3a3a] focus:bg-white transition-all">
										<?php foreach ( $payment_methods as $value => $label ) : ?>
											<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
										<?php endforeach; ?>
									</select>
									<svg class="absolute right-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
									</svg>
								</div>
							</div>
						</div>
					</div>

					<!-- Checkboxes -->
					<div class="checkout-section-group mb-8">
						<div class="space-y-3">
							<!-- Don't call me -->
							<label class="flex items-start gap-3 cursor-pointer">
								<input type="checkbox"
								       name="no_callback"
								       value="1"
								       class="checkout-checkbox mt-0.5 w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]">
								<span class="text-sm text-gray-600">
									<?php esc_html_e( "Don't call me back to confirm order", 'allmighty' ); ?>
								</span>
							</label>

							<!-- Privacy agreement -->
							<label class="flex items-start gap-3 cursor-pointer">
								<input type="checkbox"
								       name="privacy_agreement"
								       value="1"
								       required
								       class="checkout-checkbox mt-0.5 w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]">
								<span class="text-sm text-gray-600">
									<?php esc_html_e( 'I agree to the personal data processing', 'allmighty' ); ?>
								</span>
							</label>
						</div>
					</div>

					<!-- Submit Button (Mobile) -->
					<div class="lg:hidden mt-8">
						<button type="submit"
						        id="place-order-mobile"
						        class="w-full py-4 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
							<?php esc_html_e( 'Place order', 'allmighty' ); ?>
						</button>
					</div>

					<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
				</div>

				<!-- Right Column - Order Summary -->
				<div class="lg:col-span-5">
					<div class="order-summary bg-gray-50 rounded-2xl p-6 lg:p-8 sticky top-4">
						<h2 class="text-xl lg:text-2xl font-medium text-[#3a3a3a] mb-6 italic">
							<?php esc_html_e( 'Your order', 'allmighty' ); ?>
						</h2>

						<!-- Cart Items -->
						<div class="cart-items space-y-6 mb-8">
							<?php foreach ( $cart_items as $cart_item_key => $cart_item ) :
								$product   = $cart_item['data'];
								$product_id = $cart_item['product_id'];
								$quantity  = $cart_item['quantity'];
								$price     = WC()->cart->get_product_price( $product );
								$thumbnail = get_the_post_thumbnail_url( $product_id, 'thumbnail' );

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
								<div class="cart-item flex gap-4" data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
									<!-- Product Image -->
									<div class="w-16 h-16 flex-shrink-0 bg-white rounded-lg overflow-hidden">
										<?php if ( $thumbnail ) : ?>
											<img src="<?php echo esc_url( $thumbnail ); ?>"
											     alt="<?php echo esc_attr( $product->get_name() ); ?>"
											     class="w-full h-full object-cover">
										<?php else : ?>
											<div class="w-full h-full bg-gray-200"></div>
										<?php endif; ?>
									</div>

									<!-- Product Details -->
									<div class="flex-1">
										<div class="flex justify-between items-start">
											<h3 class="font-medium text-[#3a3a3a]">
												"<?php echo esc_html( $product->get_name() ); ?>"
											</h3>
											<!-- Remove Button -->
											<button type="button"
											        class="remove-cart-item text-red-400 hover:text-red-600 transition-colors p-1"
											        data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>"
											        aria-label="<?php esc_attr_e( 'Remove item', 'allmighty' ); ?>">
												<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
												</svg>
											</button>
										</div>

										<div class="text-[#3a3a3a] font-medium mt-1">
											<?php echo wp_kses_post( $price ); ?>
										</div>

										<?php if ( ! empty( $variation_data ) ) : ?>
											<div class="text-sm text-gray-500 mt-1">
												<?php echo esc_html( implode( '   ', array_map( function( $k, $v ) { return "$k: $v"; }, array_keys( $variation_data ), $variation_data ) ) ); ?>
											</div>
										<?php endif; ?>

										<!-- Quantity Controls -->
										<div class="quantity-controls flex items-center gap-2 mt-3">
											<button type="button"
											        class="quantity-minus w-8 h-8 flex items-center justify-center border border-gray-300 rounded text-gray-500 hover:border-[#3a3a3a] hover:text-[#3a3a3a] transition-colors"
											        data-cart-item-key="<?php echo esc_attr( $cart_item_key ); ?>">
												<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
													<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
												</svg>
											</button>
											<span class="quantity-value w-8 text-center text-[#3a3a3a] font-medium">
												<?php echo esc_html( $quantity ); ?>
											</span>
											<button type="button"
											        class="quantity-plus w-8 h-8 flex items-center justify-center border border-gray-300 rounded text-gray-500 hover:border-[#3a3a3a] hover:text-[#3a3a3a] transition-colors"
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

						<!-- Order Total -->
						<div class="order-total border-t border-gray-200 pt-6 mb-6">
							<div class="flex justify-between items-center text-lg font-bold text-[#3a3a3a]">
								<span><?php esc_html_e( 'Total', 'allmighty' ); ?></span>
								<span class="cart-total"><?php echo wp_kses_post( $cart_total ); ?></span>
							</div>
						</div>

						<!-- Submit Button (Desktop) -->
						<div class="hidden lg:block">
							<button type="submit"
							        id="place-order-desktop"
							        class="w-full py-4 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
								<?php esc_html_e( 'Place order', 'allmighty' ); ?>
							</button>
						</div>

						<!-- Business Hours -->
						<div class="business-hours mt-8 pt-6 border-t border-gray-200">
							<h3 class="font-bold text-[#3a3a3a] mb-2">
								<?php esc_html_e( 'Business Hours:', 'allmighty' ); ?>
							</h3>
							<div class="text-sm text-gray-600 space-y-1">
								<p><?php esc_html_e( 'MON - FRI 9:00 - 21:00', 'allmighty' ); ?></p>
								<p><?php esc_html_e( 'SAT 9:00 - 18:00', 'allmighty' ); ?></p>
							</div>
						</div>
					</div>
				</div>

			</div>
		</form>
	</div>
</section>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>
