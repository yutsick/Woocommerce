<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package allmighty
 */

get_header();
?>

<section class="error-404-page min-h-[60vh] flex items-center justify-center py-16 lg:py-24 bg-white">
	<div class="container mx-auto px-4">
		<div class="text-center">

			<!-- Sad Face Icon -->
			<div class="w-20 h-20 mx-auto mb-6 text-[#3a3a3a]">
				<svg class="w-full h-full" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
					<circle cx="12" cy="12" r="10"/>
					<circle cx="9" cy="9" r="0.5" fill="currentColor" stroke="none"/>
					<circle cx="15" cy="9" r="0.5" fill="currentColor" stroke="none"/>
					<path d="M8 15c1.5-1.5 4.5-1.5 6 0" stroke-linecap="round"/>
				</svg>
			</div>

			<!-- 404 Title -->
			<h1 class="text-4xl lg:text-5xl font-bold text-[#3a3a3a] mb-2">
				404
			</h1>

			<!-- Subtitle -->
			<p class="text-lg lg:text-xl text-[#3a3a3a] mb-12">
				<?php esc_html_e( 'Page not found', 'allmighty' ); ?>
			</p>

			<!-- Back Button -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
			   class="inline-block bg-[#3a3a3a] text-white px-12 py-3.5 rounded-lg text-base font-medium hover:bg-[#2a2a2a] transition-colors">
				<?php esc_html_e( 'Return to main', 'allmighty' ); ?>
			</a>

		</div>
	</div>
</section>

<?php
get_footer();
