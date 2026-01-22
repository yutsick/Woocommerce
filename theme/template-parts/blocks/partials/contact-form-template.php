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
if ( ! isset( $title ) ) {
	$title = get_sub_field( 'title' ) ?: 'Contact form';
}
if ( ! isset( $subtitle ) ) {
	$subtitle = get_sub_field( 'subtitle' ) ?: 'We want to hear from you';
}
if ( ! isset( $form_shortcode ) ) {
	$form_shortcode = get_sub_field( 'form_shortcode' ) ?: '[contact-form-7 id="REPLACE_WITH_REAL_ID"]';
}
?>

<!-- Form Header -->
<div class="mb-8">
	<h2 class="text-3xl lg:text-4xl font-bold text-[#2a2a2a] mb-3">
		<?php echo esc_html( $title ); ?>
	</h2>
	<p class="text-gray-500 text-lg">
		<?php echo esc_html( $subtitle ); ?>
	</p>
</div>

<!-- Contact Form 7 -->
<div class="contact-form-wrapper">
	<?php echo do_shortcode( $form_shortcode ); ?>
</div>

<!--
===========================================
EXAMPLE CONTACT FORM 7 MARKUP
===========================================

Replace the shortcode above with this when creating the real form in CF7 admin:

<div class="form-field">
	<label>
		[text* your-name placeholder "Name"]
	</label>
</div>

<div class="form-field">
	<label>
		[tel your-phone placeholder "Phone"]
	</label>
</div>

<div class="form-field">
	<label>
		[textarea your-message placeholder "Please type your message here..."]
	</label>
</div>

<div class="form-checkbox">
	<label>
		[acceptance acceptance-terms]
		<span>I agree to the personal data processing</span>
	</label>
</div>

<div class="form-submit">
	[submit "Send"]
</div>

===========================================
-->
