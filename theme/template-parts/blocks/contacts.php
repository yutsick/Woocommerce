<?php
/**
 * Block: Contacts
 *
 * Three-column contact information block.
 *
 * ACF Fields:
 * - address_title (Text) - "Company Address"
 * - address_text (Textarea) - Address details
 * - service_title (Text) - "Customer Service:"
 * - phone (Text) - Phone number
 * - email (Email) - Email address
 * - hours_title (Text) - "Business Hours:"
 * - hours (Repeater) - Working hours
 *   - line (Text) - e.g., "MON - FRI 9:00 - 21:00"
 */

$address_title = get_sub_field( 'address_title' ) ?: 'Company Address';
$address_text  = get_sub_field( 'address_text' );
$service_title = get_sub_field( 'service_title' ) ?: 'Customer Service:';
$phone         = get_sub_field( 'phone' );
$email         = get_sub_field( 'email' );
$hours_title   = get_sub_field( 'hours_title' ) ?: 'Business Hours:';
$hours         = get_sub_field( 'hours' );
?>

<section class="contacts-section py-12 lg:py-16 bg-white">
	<div class="container mx-auto px-4">
		<div class="max-w-[91.666667%] mx-auto">

			<div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">

				<!-- Company Address -->
				<div>
					<h3 class="text-lg lg:text-xl font-bold text-[#1a1a1a] mb-4">
						<?php echo esc_html( $address_title ); ?>
					</h3>
					<?php if ( $address_text ) : ?>
						<p class="text-[#4a4a4a] text-base leading-relaxed">
							<?php echo nl2br( esc_html( $address_text ) ); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- Customer Service -->
				<div>
					<h3 class="text-lg lg:text-xl font-bold text-[#1a1a1a] mb-4">
						<?php echo esc_html( $service_title ); ?>
					</h3>
					<?php if ( $phone ) : ?>
						<p class="text-[#4a4a4a] text-base mb-2">
							Phone: <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="hover:text-[#1a1a1a] transition-colors"><?php echo esc_html( $phone ); ?></a>
						</p>
					<?php endif; ?>
					<?php if ( $email ) : ?>
						<p class="text-[#4a4a4a] text-base">
							Email: <a href="mailto:<?php echo esc_attr( $email ); ?>" class="hover:text-[#1a1a1a] transition-colors"><?php echo esc_html( $email ); ?></a>
						</p>
					<?php endif; ?>
				</div>

				<!-- Business Hours -->
				<div>
					<h3 class="text-lg lg:text-xl font-bold text-[#1a1a1a] mb-4">
						<?php echo esc_html( $hours_title ); ?>
					</h3>
					<?php if ( $hours ) : ?>
						<?php foreach ( $hours as $hour ) : ?>
							<p class="text-[#4a4a4a] text-base mb-1">
								<?php echo esc_html( $hour['line'] ); ?>
							</p>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>

			</div>

		</div>
	</div>
</section>
