<?php
/**
 * Custom Thank You / Order Received Page
 *
 * Minimal design matching the brand style.
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="thank-you-page min-h-[60vh] flex items-center justify-center py-16 lg:py-24 bg-white">
	<div class="container mx-auto px-4">
		<div class="text-center">

			<?php if ( $order && ! $order->has_status( 'failed' ) ) : ?>

				<!-- Title -->
				<h1 class="text-3xl lg:text-4xl font-bold italic text-[#3a3a3a] mb-8">
					<?php esc_html_e( 'Thank you!', 'allmighty' ); ?>
				</h1>

				<!-- Success Checkmark Icon -->
				<div class="w-20 h-20 mx-auto mb-8 text-[#6b7280]">
					<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
						<circle cx="12" cy="12" r="10"/>
						<path d="M8 12l3 3 5-6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>

				<!-- Confirmation Text -->
				<p class="text-lg font-semibold text-[#3a3a3a] mb-12">
					<?php esc_html_e( 'Your order was confirmed successfully.', 'allmighty' ); ?>
				</p>

				<!-- Back Button -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   class="inline-block bg-[#3a3a3a] text-white px-12 py-3.5 rounded-lg text-base font-medium hover:bg-[#2a2a2a] transition-colors">
					<?php esc_html_e( 'Back', 'allmighty' ); ?>
				</a>

			<?php elseif ( $order && $order->has_status( 'failed' ) ) : ?>

				<!-- Failed Icon -->
				<div class="w-20 h-20 mx-auto mb-8 text-red-500">
					<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
						<circle cx="12" cy="12" r="10"/>
						<path d="M15 9l-6 6M9 9l6 6" stroke-linecap="round" stroke-linejoin="round"/>
					</svg>
				</div>

				<!-- Title -->
				<h1 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
					<?php esc_html_e( 'Payment Failed', 'allmighty' ); ?>
				</h1>

				<!-- Message -->
				<p class="text-lg text-[#6b7280] mb-12">
					<?php esc_html_e( 'Unfortunately, your order could not be processed.', 'allmighty' ); ?>
				</p>

				<!-- Buttons -->
				<div class="flex flex-col sm:flex-row gap-4 justify-center">
					<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"
					   class="inline-block bg-[#3a3a3a] text-white px-12 py-3.5 rounded-lg text-base font-medium hover:bg-[#2a2a2a] transition-colors">
						<?php esc_html_e( 'Try Again', 'allmighty' ); ?>
					</a>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
					   class="inline-block bg-gray-100 text-[#3a3a3a] px-12 py-3.5 rounded-lg text-base font-medium hover:bg-gray-200 transition-colors">
						<?php esc_html_e( 'Back', 'allmighty' ); ?>
					</a>
				</div>

			<?php else : ?>

				<!-- No Order - Sad Face -->
				<div class="w-20 h-20 mx-auto mb-6 text-[#3a3a3a]">
					<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
						<circle cx="12" cy="12" r="10"/>
						<circle cx="9" cy="9" r="0.5" fill="currentColor" stroke="none"/>
						<circle cx="15" cy="9" r="0.5" fill="currentColor" stroke="none"/>
						<path d="M8 15c1.5-1.5 4.5-1.5 6 0" stroke-linecap="round"/>
					</svg>
				</div>

				<!-- Title -->
				<h1 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
					<?php esc_html_e( 'Order Not Found', 'allmighty' ); ?>
				</h1>

				<!-- Back Button -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
				   class="inline-block bg-[#3a3a3a] text-white px-12 py-3.5 rounded-lg text-base font-medium hover:bg-[#2a2a2a] transition-colors mt-8">
					<?php esc_html_e( 'Back', 'allmighty' ); ?>
				</a>

			<?php endif; ?>

		</div>
	</div>
</section>

<?php
get_footer();
