<?php
/**
 * Custom Thank You / Order Received Page
 *
 * This template overrides the default WooCommerce thankyou.php
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<!-- Breadcrumbs -->
<section class="breadcrumbs-section bg-white">
	<div class="container mx-auto px-4">
		<div class="h-16 lg:h-20 flex items-center">
			<nav class="breadcrumbs text-sm text-[#626262]">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#3a3a3a] transition-colors">
					<?php esc_html_e( 'Almighty Victory', 'allmighty' ); ?>
				</a>
				<span class="mx-2">/</span>
				<span><?php esc_html_e( 'Order Complete', 'allmighty' ); ?></span>
			</nav>
		</div>
	</div>
</section>

<!-- Success Content -->
<section class="success-page py-16 lg:py-24 bg-white">
	<div class="container mx-auto px-4">
		<div class="max-w-2xl mx-auto text-center">

			<?php if ( $order ) : ?>

				<?php if ( $order->has_status( 'failed' ) ) : ?>
					<!-- Order Failed -->
					<div class="failed-icon w-24 h-24 mx-auto mb-6 text-red-500">
						<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
						</svg>
					</div>

					<h1 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
						<?php esc_html_e( 'Payment Failed', 'allmighty' ); ?>
					</h1>

					<p class="text-gray-600 text-lg mb-8">
						<?php esc_html_e( 'Unfortunately, your order could not be processed. Please try again or contact us for assistance.', 'allmighty' ); ?>
					</p>

					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
						   class="inline-block px-8 py-4 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
							<?php esc_html_e( 'Try Again', 'allmighty' ); ?>
						</a>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
						   class="inline-block px-8 py-4 bg-gray-100 text-[#3a3a3a] font-medium rounded-lg hover:bg-gray-200 transition-colors">
							<?php esc_html_e( 'Return Home', 'allmighty' ); ?>
						</a>
					</div>

				<?php else : ?>
					<!-- Order Success -->
					<div class="success-icon">
						<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
						</svg>
					</div>

					<h1 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
						<?php esc_html_e( 'Thank You!', 'allmighty' ); ?>
					</h1>

					<p class="text-gray-600 text-lg mb-2">
						<?php esc_html_e( 'Your order has been successfully placed.', 'allmighty' ); ?>
					</p>

					<p class="text-gray-500 mb-8">
						<?php
						printf(
							/* translators: %s: order number */
							esc_html__( 'Order number: %s', 'allmighty' ),
							'<strong class="text-[#3a3a3a]">' . $order->get_order_number() . '</strong>'
						);
						?>
					</p>

					<!-- Order Details Summary -->
					<div class="order-details bg-gray-50 rounded-2xl p-6 lg:p-8 text-left mb-8">
						<h2 class="text-lg font-bold text-[#3a3a3a] mb-4">
							<?php esc_html_e( 'Order Details', 'allmighty' ); ?>
						</h2>

						<div class="space-y-3 text-sm">
							<div class="flex justify-between">
								<span class="text-gray-500"><?php esc_html_e( 'Date:', 'allmighty' ); ?></span>
								<span class="text-[#3a3a3a]"><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></span>
							</div>

							<?php if ( $order->get_billing_email() ) : ?>
								<div class="flex justify-between">
									<span class="text-gray-500"><?php esc_html_e( 'Email:', 'allmighty' ); ?></span>
									<span class="text-[#3a3a3a]"><?php echo esc_html( $order->get_billing_email() ); ?></span>
								</div>
							<?php endif; ?>

							<div class="flex justify-between">
								<span class="text-gray-500"><?php esc_html_e( 'Total:', 'allmighty' ); ?></span>
								<span class="text-[#3a3a3a] font-bold"><?php echo wp_kses_post( $order->get_formatted_order_total() ); ?></span>
							</div>

							<div class="flex justify-between">
								<span class="text-gray-500"><?php esc_html_e( 'Payment method:', 'allmighty' ); ?></span>
								<span class="text-[#3a3a3a]"><?php echo esc_html( $order->get_payment_method_title() ); ?></span>
							</div>
						</div>

						<!-- Order Items -->
						<div class="mt-6 pt-6 border-t border-gray-200">
							<h3 class="font-medium text-[#3a3a3a] mb-4">
								<?php esc_html_e( 'Items:', 'allmighty' ); ?>
							</h3>

							<div class="space-y-3">
								<?php foreach ( $order->get_items() as $item_id => $item ) :
									$product = $item->get_product();
									?>
									<div class="flex justify-between items-center">
										<div class="flex items-center gap-3">
											<?php if ( $product && $product->get_image_id() ) : ?>
												<div class="w-12 h-12 bg-white rounded overflow-hidden flex-shrink-0">
													<?php echo wp_kses_post( $product->get_image( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ) ); ?>
												</div>
											<?php endif; ?>
											<div>
												<span class="text-[#3a3a3a]"><?php echo esc_html( $item->get_name() ); ?></span>
												<span class="text-gray-500 text-xs block">× <?php echo esc_html( $item->get_quantity() ); ?></span>
											</div>
										</div>
										<span class="text-[#3a3a3a]"><?php echo wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?></span>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<!-- Action Buttons -->
					<div class="flex flex-col sm:flex-row gap-4 justify-center">
						<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"
						   class="inline-block px-8 py-4 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
							<?php esc_html_e( 'Continue Shopping', 'allmighty' ); ?>
						</a>
						<?php if ( is_user_logged_in() ) : ?>
							<a href="<?php echo esc_url( wc_get_account_endpoint_url( 'orders' ) ); ?>"
							   class="inline-block px-8 py-4 bg-gray-100 text-[#3a3a3a] font-medium rounded-lg hover:bg-gray-200 transition-colors">
								<?php esc_html_e( 'View Orders', 'allmighty' ); ?>
							</a>
						<?php endif; ?>
					</div>

					<!-- Contact Info -->
					<div class="mt-12 text-gray-500 text-sm">
						<p><?php esc_html_e( 'A confirmation email has been sent to your email address.', 'allmighty' ); ?></p>
						<p class="mt-2">
							<?php
							printf(
								/* translators: %s: support email or phone */
								esc_html__( 'Questions? Contact us at %s', 'allmighty' ),
								'<a href="mailto:support@almightyvictory.com" class="text-[#3a3a3a] hover:underline">support@almightyvictory.com</a>'
							);
							?>
						</p>
					</div>

				<?php endif; ?>

			<?php else : ?>
				<!-- No Order Found -->
				<div class="text-gray-500 mb-8">
					<svg class="w-24 h-24 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
					</svg>
				</div>

				<h1 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
					<?php esc_html_e( 'Order Not Found', 'allmighty' ); ?>
				</h1>

				<p class="text-gray-600 text-lg mb-8">
					<?php esc_html_e( "We couldn't find the order you're looking for.", 'allmighty' ); ?>
				</p>

				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   class="inline-block px-8 py-4 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
					<?php esc_html_e( 'Return Home', 'allmighty' ); ?>
				</a>

			<?php endif; ?>

		</div>
	</div>
</section>

<?php
get_footer( 'form' );
