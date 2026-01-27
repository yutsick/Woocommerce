<?php
/**
 * Block: Accent Block
 *
 * Full-width content block with dark background, text, and optional CTA button.
 * Includes optional background/side image.
 *
 * ACF Fields:
 * - background_color (Color Picker) - Background color (default: #3a3a3a)
 * - title (Text) - Block heading
 * - content (WYSIWYG/Textarea) - Main text content
 * - button_text (Text) - CTA button text (optional)
 * - button_link (Link/URL) - CTA button URL (optional)
 * - image (Image) - Side/background image (optional)
 * - image_position (Select) - Image position: right / left / background (default: right)
 */

// Get ACF fields
$background_color = get_sub_field( 'background_color' );
$title            = get_sub_field( 'title' );
$content          = get_sub_field( 'content' );
$button_text      = get_sub_field( 'button_text' );
$button_link      = get_sub_field( 'button_link' );
$image            = get_sub_field( 'image' );
$image_position   = get_sub_field( 'image_position' );

// Default values
$background_color = $background_color ?: '#3a3a3a';
$title            = $title ?: 'Our mission';
$content          = $content ?: '';
$image_position   = $image_position ?: 'right';

// Show button only if both text and link are provided
$show_button = ! empty( $button_text ) && ! empty( $button_link );

// Get image URL
$image_url = '';
if ( $image ) {
	$image_url = is_array( $image ) ? $image['url'] : wp_get_attachment_url( $image );
}
?>

<section class="accent-block py-16 lg:py-0" style="background-color: <?php echo esc_attr( $background_color ); ?>;">
	<div class="container mx-auto px-4 lg:px-0">
		<!-- Desktop Layout -->
		<div class="hidden lg:flex lg:items-center <?php echo 'left' === $image_position ? 'lg:flex-row-reverse' : ''; ?>">
			<!-- Text Content -->
			<div class="lg:w-1/2 lg:py-24 <?php echo 'left' === $image_position ? 'lg:pr-16' : 'lg:pl-16'; ?>">
				<h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
					<?php echo esc_html( $title ); ?>
				</h2>

				<div class="text-white text-lg lg:text-xl leading-relaxed space-y-4 mb-8">
					<?php echo wpautop( $content ); ?>
				</div>

				<?php if ( $show_button ) : ?>
					<a href="<?php echo esc_url( $button_link ); ?>"
					   class="inline-block bg-white text-[#2a2a2a] px-12 py-4 rounded-lg text-lg font-medium hover:bg-gray-100 transition-colors">
						<?php echo esc_html( $button_text ); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Image -->
			<?php if ( $image_url ) : ?>
				<div class="lg:w-1/2 relative">
					<div class="aspect-[16/9] lg:aspect-auto lg:h-[500px]">
						<img src="<?php echo esc_url( $image_url ); ?>"
						     alt="<?php echo esc_attr( $title ); ?>"
						     class="w-full h-full object-cover">
					</div>
				</div>
			<?php endif; ?>
		</div>

		<!-- Mobile Layout -->
		<div class="lg:hidden">
			<!-- Text Content -->
			<div class="mb-8">
				<h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
					<?php echo esc_html( $title ); ?>
				</h2>

				<div class="text-white text-base leading-relaxed space-y-4">
					<?php echo wpautop( $content ); ?>
				</div>
			</div>

			<!-- Button (Mobile - Full Width) -->
			<?php if ( $show_button ) : ?>
				<a href="<?php echo esc_url( $button_link ); ?>"
				   class="block w-full text-center bg-white text-[#2a2a2a] px-8 py-4 rounded-lg text-base font-medium hover:bg-gray-100 transition-colors mb-8">
					<?php echo esc_html( $button_text ); ?>
				</a>
			<?php endif; ?>

			<!-- Image -->
			<?php if ( $image_url ) : ?>
				<div class="relative -mx-4">
					<div class="aspect-[4/3]">
						<img src="<?php echo esc_url( $image_url ); ?>"
						     alt="<?php echo esc_attr( $title ); ?>"
						     class="w-full h-full object-cover">
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
