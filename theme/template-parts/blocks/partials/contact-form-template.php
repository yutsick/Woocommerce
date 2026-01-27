<?php
/**
 * Partial: Contact Form Template
 *
 * This is the reusable contact form template.
 * Used in contact_form.php block.
 *
 * Variables available from parent:
 * - $title (string)
 * - $subtitle (string)
 * - $form_shortcode (string)
 */

// Get variables from parent scope or set defaults
$title    = !empty($args['title']) ? $args['title'] : 'Contact form';
$subtitle = !empty($args['subtitle']) ? $args['subtitle'] : 'We want to hear from you';

if ( ! isset( $form_shortcode ) ) {
	$form_shortcode = get_sub_field( 'form_shortcode' ) ?: '[contact-form-7 id="REPLACE_WITH_REAL_ID"]';
}
?>

<!-- Form Header -->
<div class="mb-8">
	<h2 class="text-3xl lg:text-4xl font-bold text-[#2a2a2a] mb-3">
		<?php echo esc_attr( $title ); ?>
	</h2>
	<p class="text-gray-500 text-lg">
		<?php echo esc_html( $subtitle ); ?>
	</p>
</div>

<!-- Contact Form 7 -->
<div class="contact-form-wrapper">
	<?php echo do_shortcode( $form_shortcode ); ?>
</div>

