<?php
/**
 * Block: Our Features
 *
 * Flexible block with layout variants: header only, footer only, or both.
 *
 * ACF Fields:
 * - layout_variant (Select) - with_header / with_footer / both
 *
 * - Header Section:
 *   - header_icon (Image) - Mission icon
 *   - header_text (Textarea) - Primary intro text
 *   - header_text_secondary (Textarea) - Secondary intro text
 *
 * - Main Section:
 *   - image (Image) - Feature image
 *   - title (Text) - Section title
 *   - subtitle (Text) - Section subtitle
 *   - bullet_points (Repeater) - List of features
 *     - icon (Image) - Bullet icon
 *     - text (Text) - Bullet text
 *   - closing_text (Textarea) - Closing paragraph
 *
 * - Footer Section:
 *   - footer_text (Textarea) - Footer message
 *   - footer_button_text (Text) - CTA button text
 *   - footer_button_link (Link) - CTA button URL
 */

// Layout variant
$layout_variant = get_sub_field( 'layout_variant' ) ?: 'with_header';

// Header fields
$header_icon           = get_sub_field( 'header_icon' );
$header_text           = get_sub_field( 'header_text' );
$header_text_secondary = get_sub_field( 'header_text_secondary' );

// Main fields
$image          = get_sub_field( 'image' );
$title          = get_sub_field( 'title' );
$subtitle       = get_sub_field( 'subtitle' );
$bullet_points  = get_sub_field( 'bullet_points' );
$closing_text   = get_sub_field( 'closing_text' );

// Footer fields
$footer_text        = get_sub_field( 'footer_text' );
$footer_button_text = get_sub_field( 'footer_button_text' );
$footer_button_link = get_sub_field( 'footer_button_link' );

// Process values
$header_icon_url = $header_icon ? esc_url( $header_icon['url'] ) : '';
$image_url       = $image ? esc_url( $image['url'] ) : 'https://placehold.co/600x500/cccccc/666666?text=Feature+Image';
$title           = $title ?: '';
$subtitle        = $subtitle ?: '';

// Show header/footer based on variant
$show_header = in_array( $layout_variant, array( 'with_header', 'both' ), true );
$show_footer = in_array( $layout_variant, array( 'with_footer', 'both' ), true );
?>

<section class="our-features-section py-16 lg:py-24 bg-white">
	<div class="container mx-auto px-4">
		<div class="max-w-[91.666667%] mx-auto">

			<?php if ( $show_header ) : ?>
			<!-- Header Intro -->
			<div class="text-center mb-16 lg:mb-24">
				<?php if ( $header_icon_url ) : ?>
					<div class="mb-6">
						<img src="<?php echo $header_icon_url; ?>" alt="Mission icon" class="w-12 h-12 mx-auto">
					</div>
				<?php endif; ?>

				<?php if ( $header_text ) : ?>
					<p class="text-[#4a4a4a] text-base lg:text-lg leading-relaxed max-w-3xl mx-auto mb-4">
						<?php echo esc_html( $header_text ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $header_text_secondary ) : ?>
					<p class="text-[#4a4a4a] text-base lg:text-lg leading-relaxed max-w-3xl mx-auto">
						<?php echo esc_html( $header_text_secondary ); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<!-- Main Content -->
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
				<!-- Image -->
				<div class="order-1">
					<img src="<?php echo $image_url; ?>"
					     alt="<?php echo esc_attr( $title ); ?>"
					     class="w-full h-auto object-cover">
				</div>

				<!-- Content -->
				<div class="order-2">
					<?php if ( $title ) : ?>
						<h2 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
							<?php echo esc_html( $title ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( $subtitle ) : ?>
						<p class="text-[#4a4a4a] text-base lg:text-lg mb-6">
							<?php echo esc_html( $subtitle ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $bullet_points ) : ?>
						<ul class="space-y-4 mb-6">
							<?php foreach ( $bullet_points as $point ) :
								$bullet_icon = ! empty( $point['icon'] ) ? esc_url( $point['icon']['url'] ) : '';
								$bullet_text = $point['text'] ?? '';
							?>
								<li class="flex items-start gap-3">
									<?php if ( $bullet_icon ) : ?>
										<img src="<?php echo $bullet_icon; ?>" alt="" class="w-6 h-6 flex-shrink-0 mt-0.5">
									<?php else : ?>
										<svg class="w-6 h-6 flex-shrink-0 mt-0.5 text-[#6b7280]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
										</svg>
									<?php endif; ?>
									<span class="text-[#3a3a3a] font-medium text-base lg:text-lg"><?php echo esc_html( $bullet_text ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if ( $closing_text ) : ?>
						<p class="text-[#4a4a4a] text-base lg:text-lg leading-relaxed">
							<?php echo esc_html( $closing_text ); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>

			<?php if ( $show_footer ) : ?>
			<!-- Footer CTA -->
			<div class="text-center mt-16 lg:mt-24">
				<?php if ( $footer_text ) : ?>
					<p class="text-xl lg:text-2xl font-bold text-[#3a3a3a] leading-relaxed max-w-3xl mx-auto mb-8">
						<?php echo nl2br( esc_html( $footer_text ) ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $footer_button_text ) : ?>
					<a href="<?php echo esc_url( $footer_button_link ?: '/shop/' ); ?>"
					   class="inline-block bg-[#3a3a3a] text-white px-10 py-3 rounded-full text-base font-medium hover:bg-[#2a2a2a] transition-colors">
						<?php echo esc_html( $footer_button_text ); ?>
					</a>
				<?php endif; ?>
			</div>
			<?php endif; ?>

		</div>
	</div>
</section>
