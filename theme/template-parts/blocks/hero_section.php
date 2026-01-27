<?php
/**
 * Block: Hero Section
 *
 * Full-width hero section with background image, heading, subtitle, and CTA button.
 *
 * ACF Fields:
 * - background_image (Image) - Main hero background image
 * - secondary_image (Image) - Secondary image for mobile (optional)
 * - title (Text) - Main hero heading
 * - subtitle (Text) - Hero subtitle/description
 * - button_text (Text) - CTA button text
 * - button_link (Link) - CTA button URL
 */

// Get ACF fields
$background_image = get_sub_field( 'background_image' );
$secondary_image  = get_sub_field( 'secondary_image' );
$title            = get_sub_field( 'title' );
$subtitle         = get_sub_field( 'subtitle' );
$button_text      = get_sub_field( 'button_text' );
$button_link      = get_sub_field( 'button_link' );

// Default values
$bg_url         = $background_image ? esc_url( $background_image['url'] ) : 'https://placehold.co/1920x800/cccccc/666666?text=Hero+Image';
$secondary_url  = $secondary_image ? esc_url( $secondary_image['url'] ) : '';
$title          = $title ?: 'GLORIFY GOD';
$subtitle       = $subtitle ?: 'Honor Body Temple with our clothing';
$button_text    = $button_text ?: 'See all products';
$button_link    = $button_link ?: '#';
?>

<section class="hero-section relative w-full overflow-hidden">
	<!-- Desktop Version -->
	<div class="hidden lg:block">
		<!-- Background Image -->
		<div class="relative w-full h-[600px] bg-cover bg-center" style="background-image: url('<?php echo $bg_url; ?>');">
			<div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20"></div>
		</div>

		<!-- Content Section (Below Image) -->
		<div class="bg-white py-16">
			<div class="container mx-auto px-4 text-center">
				<h1 class="text-6xl lg:text-7xl font-bold text-[#2a2a2a] mb-6 tracking-tight">
					<?php echo esc_html( $title ); ?>
				</h1>
				<p class="text-xl lg:text-2xl text-[#4a4a4a] mb-8 max-w-3xl mx-auto">
					<?php echo esc_html( $subtitle ); ?>
				</p>
				<a href="<?php echo esc_url( $button_link ); ?>"
				   class="inline-block bg-[#3a3a3a] text-white px-12 py-4 rounded-lg text-lg font-medium hover:bg-[#2a2a2a] transition-colors">
					<?php echo esc_html( $button_text ); ?>
				</a>
			</div>
		</div>
	</div>

	<!-- Mobile Version -->
	<div class="lg:hidden relative min-h-[600px] bg-cover bg-center" style="background-image: url('<?php echo $bg_url; ?>');">
		<!-- Overlay -->
		<div class="absolute inset-0 bg-black/40"></div>

		<!-- Content Container -->
		<div class="relative z-10 min-h-[600px] flex items-center">
			<div class="container mx-auto px-4">
				<div class="flex flex-col items-center justify-center text-center">
					<!-- Text Content -->
					<div class="max-w-xl">
						<h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 tracking-tight drop-shadow-lg">
							<?php echo esc_html( $title ); ?>
						</h1>
						<p class="text-lg sm:text-xl text-white mb-8 drop-shadow-lg">
							<?php echo esc_html( $subtitle ); ?>
						</p>
						<a href="<?php echo esc_url( $button_link ); ?>"
						   class="inline-block bg-white text-[#3a3a3a] px-10 py-4 rounded-lg text-base font-medium hover:bg-gray-100 transition-colors shadow-lg">
							<?php echo esc_html( $button_text ); ?>
						</a>
					</div>

					<!-- Secondary Image (if provided) -->
					<?php if ( $secondary_url ) : ?>
						<div class="mt-8">
							<img src="<?php echo $secondary_url; ?>"
							     alt="Product"
							     class="w-48 h-auto object-contain drop-shadow-2xl">
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
