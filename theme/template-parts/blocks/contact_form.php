<?php
/**
 * Block: Contact Form
 *
 * Contact form block with image and Contact Form 7 integration.
 *
 * ACF Fields:
 * - image (Image) - Background/side image
 * - form_shortcode (Text) - Contact Form 7 shortcode (e.g., [contact-form-7 id="123"])
 * - title (Text) - Form heading
 * - subtitle (Text) - Form subtitle
 */

// Get ACF fields
$image          = get_sub_field( 'image' );
$form_shortcode = get_sub_field( 'form_shortcode' );
$title          = get_sub_field( 'title' );
$subtitle       = get_sub_field( 'subtitle' );

// Default values
$title          = $title ?: 'Contact form';
$subtitle       = $subtitle ?: 'We want to hear from you';
$form_shortcode = $form_shortcode ?: '[contact-form-7 id="REPLACE_WITH_REAL_ID"]';

// Get image URL
$image_url = '';
if ( $image ) {
	$image_url = is_array( $image ) ? $image['url'] : wp_get_attachment_url( $image );
} else {
	$image_url = 'https://placehold.co/1200x800/f0f0f0/666666?text=Contact+Image';
}
?>

<section class="contact-form-block py-16 lg:py-0 ">
	<div class="container mx-auto px-4 lg:px-0">
		<!-- Desktop Layout -->
		<div class="hidden lg:flex lg:items-stretch relative">
			<!-- Image (Left Side - 60%) -->
			<div class="lg:w-3/5 relative">
				<div class="h-full">
					<img src="<?php echo esc_url( $image_url ); ?>"
					     alt="<?php echo esc_attr( $title ); ?>"
					     class="w-full">
				</div>
			</div>

			<!-- Form (Right Side - 40%) -->
			<div class="lg:w-2/5 bg-gray-100 flex items-center absolute -top-16 right-0">
				<div class="w-full p-6 lg:p-12">
					<?php get_template_part( 'template-parts/blocks/partials/contact-form-template' ,null, 
					array(
						'title'    => $title,
						'subtitle' => $subtitle
					)); ?>
				</div>
			</div>
		</div>

		<!-- Mobile Layout -->
		<div class="lg:hidden">
			<!-- Image -->
			<div class="relative -mx-4 mb-0">
				<div class="aspect-video">
					<img src="<?php echo esc_url( $image_url ); ?>"
					     alt="<?php echo esc_attr( $title ); ?>"
					     class="w-full">
				</div>
			</div>

			<!-- Form Card -->
			<div class="bg-gray-100 rounded-t-3xl -mt-8 relative z-10 px-6 py-8">
				<?php get_template_part( 'template-parts/blocks/partials/contact-form-template',null, 
				array(
					'title'    => $title,
					'subtitle' => $subtitle
				) ); ?>
			</div>
		</div>
	</div>
</section>
