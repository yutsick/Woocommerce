<?php
/**
 * Block: Team / About Us
 *
 * Two-section block with mission intro and team description.
 *
 * ACF Fields:
 * - icon (Image) - Mission icon (praying hands)
 * - intro_text (Textarea) - Primary mission text
 * - intro_text_secondary (Textarea) - Secondary mission text (quote)
 * - team_image (Image) - Team photo
 * - section_title (Text) - "Our People"
 * - section_subtitle (Text) - "We create clothing for those who:"
 * - bullet_points (Repeater) - List of values
 *   - icon (Image) - Bullet icon
 *   - text (Text) - Bullet text
 * - closing_text (Textarea) - Closing paragraph
 */

// Get ACF fields
$icon                  = get_sub_field( 'icon' );
$intro_text            = get_sub_field( 'intro_text' );
$intro_text_secondary  = get_sub_field( 'intro_text_secondary' );
$team_image            = get_sub_field( 'team_image' );
$section_title         = get_sub_field( 'section_title' );
$section_subtitle      = get_sub_field( 'section_subtitle' );
$bullet_points         = get_sub_field( 'bullet_points' );
$closing_text          = get_sub_field( 'closing_text' );

// Default values
$icon_url        = $icon ? esc_url( $icon['url'] ) : '';
$team_image_url  = $team_image ? esc_url( $team_image['url'] ) : 'https://placehold.co/600x500/cccccc/666666?text=Team+Photo';
$section_title   = $section_title ?: 'Our People';
$section_subtitle = $section_subtitle ?: 'We create clothing for those who:';
?>

<section class="team-section py-16 lg:py-24 bg-white">
	<div class="container mx-auto px-4">
		<div class="max-w-[91.666667%] mx-auto">

			<?php if ( $icon_url || $intro_text || $intro_text_secondary ) : ?>
			<!-- Mission Intro -->
			<div class="text-center mb-16 lg:mb-24">
				<?php if ( $icon_url ) : ?>
					<div class="mb-6">
						<img src="<?php echo $icon_url; ?>" alt="Mission icon" class="w-12 h-12 mx-auto">
					</div>
				<?php endif; ?>

				<?php if ( $intro_text ) : ?>
					<p class="text-[#4a4a4a] text-base lg:text-lg leading-relaxed max-w-3xl mx-auto mb-4">
						<?php echo esc_html( $intro_text ); ?>
					</p>
				<?php endif; ?>

				<?php if ( $intro_text_secondary ) : ?>
					<p class="text-[#4a4a4a] text-base lg:text-lg leading-relaxed max-w-3xl mx-auto">
						<?php echo esc_html( $intro_text_secondary ); ?>
					</p>
				<?php endif; ?>
			</div>
			<?php endif; ?>

			<!-- Our People Section -->
			<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
				<!-- Team Image -->
				<div class="order-1">
					<img src="<?php echo $team_image_url; ?>"
					     alt="<?php echo esc_attr( $section_title ); ?>"
					     class="w-full h-auto object-cover">
				</div>

				<!-- Content -->
				<div class="order-2">
					<h2 class="text-3xl lg:text-4xl font-bold text-[#3a3a3a] mb-4">
						<?php echo esc_html( $section_title ); ?>
					</h2>

					<?php if ( $section_subtitle ) : ?>
						<p class="text-[#4a4a4a] text-base lg:text-lg mb-6">
							<?php echo esc_html( $section_subtitle ); ?>
						</p>
					<?php endif; ?>

					<?php if ( $bullet_points ) : ?>
						<ul class="space-y-4 mb-6">
							<?php foreach ( $bullet_points as $point ) :
								$bullet_icon = $point['icon'] ? esc_url( $point['icon']['url'] ) : '';
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

		</div>
	</div>
</section>
