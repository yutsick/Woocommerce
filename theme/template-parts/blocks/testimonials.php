<?php
/**
 * Block: Testimonials
 *
 * Displays customer testimonials/reviews with star ratings.
 * Desktop: 3-column grid, Mobile: Swiper slider.
 *
 * ACF Fields:
 * - section_title (Text) - Section heading
 * - testimonials (Repeater) - Array of testimonials
 *   - rating (Number/Range) - Star rating (1-5)
 *   - quote (Textarea) - Testimonial text
 *   - author_name (Text) - Customer name
 */

// Get ACF fields
$section_title = get_sub_field( 'section_title' );
$testimonials  = get_sub_field( 'testimonials' );

// Default values
$section_title = $section_title ?: 'What our clients say:';

// If no testimonials, return early
if ( empty( $testimonials ) ) {
	return;
}
?>

<section class="testimonials-section py-16 bg-white">
	<div class="container mx-auto px-4">
		<!-- Section Title -->
		<h2 class="text-4xl lg:text-5xl font-bold text-[#2a2a2a] text-center mb-12">
			<?php echo esc_html( $section_title ); ?>
		</h2>

		<!-- Desktop Grid -->
		<div class="hidden lg:grid lg:grid-cols-3 gap-8">
			<?php foreach ( $testimonials as $testimonial ) : ?>
				<?php
				$rating      = isset( $testimonial['rating'] ) ? absint( $testimonial['rating'] ) : 5;
				$quote       = isset( $testimonial['quote'] ) ? $testimonial['quote'] : '';
				$author_name = isset( $testimonial['author_name'] ) ? $testimonial['author_name'] : '';

				// Ensure rating is between 1-5
				$rating = max( 1, min( 5, $rating ) );
				?>
				<div class="testimonial-card bg-gray-50 rounded-lg p-8">
					<!-- Stars -->
					<div class="flex items-center gap-2 mb-6">
						<?php for ( $i = 0; $i < 5; $i++ ) : ?>
							<svg class="w-8 h-8 <?php echo $i < $rating ? 'text-[#D4AF37]' : 'text-gray-300'; ?>"
							     fill="currentColor" viewBox="0 0 20 20">
								<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
							</svg>
						<?php endfor; ?>
					</div>

					<!-- Quote -->
					<blockquote class="text-gray-600 text-lg mb-6 leading-relaxed">
						"<?php echo esc_html( $quote ); ?>"
					</blockquote>

					<!-- Author -->
					<div class="font-bold text-[#2a2a2a] text-xl">
						<?php echo esc_html( $author_name ); ?>
					</div>
				</div>
			<?php endforeach; ?>
		</div>

		<!-- Mobile Slider -->
		<div class="lg:hidden">
			<div class="swiper testimonials-swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $testimonials as $testimonial ) : ?>
						<?php
						$rating      = isset( $testimonial['rating'] ) ? absint( $testimonial['rating'] ) : 5;
						$quote       = isset( $testimonial['quote'] ) ? $testimonial['quote'] : '';
						$author_name = isset( $testimonial['author_name'] ) ? $testimonial['author_name'] : '';

						// Ensure rating is between 1-5
						$rating = max( 1, min( 5, $rating ) );
						?>
						<div class="swiper-slide">
							<div class="testimonial-card bg-gray-50 rounded-lg p-6">
								<!-- Stars -->
								<div class="flex items-center gap-2 mb-6">
									<?php for ( $i = 0; $i < 5; $i++ ) : ?>
										<svg class="w-8 h-8 <?php echo $i < $rating ? 'text-[#D4AF37]' : 'text-gray-300'; ?>"
										     fill="currentColor" viewBox="0 0 20 20">
											<path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
										</svg>
									<?php endfor; ?>
								</div>

								<!-- Quote -->
								<blockquote class="text-gray-600 text-base mb-6 leading-relaxed">
									"<?php echo esc_html( $quote ); ?>"
								</blockquote>

								<!-- Author -->
								<div class="font-bold text-[#2a2a2a] text-lg">
									<?php echo esc_html( $author_name ); ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<!-- Navigation Arrows -->
				<div class="flex items-center justify-center gap-4 mt-8">
					<button class="swiper-button-prev-testimonials w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
						<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
						</svg>
					</button>
					<button class="swiper-button-next-testimonials w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center hover:bg-gray-200 transition-colors">
						<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
						</svg>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
