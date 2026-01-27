<?php
/**
 * Block: SEO Text
 *
 * Expandable SEO text block with "Show more" / "Show less" button.
 * Displays truncated text by default, expands on button click.
 *
 * ACF Fields:
 * - title (Text) - Block heading
 * - content (WYSIWYG/Textarea) - SEO text content
 * - show_more_text (Text) - Button text for expand (default: "Show more")
 * - show_less_text (Text) - Button text for collapse (default: "Show less")
 * - preview_lines (Number) - Number of lines to show initially (default: 4)
 */

// Get ACF fields
$title          = get_sub_field( 'title' );
$content        = get_sub_field( 'content' );
$show_more_text = get_sub_field( 'show_more_text' );
$show_less_text = get_sub_field( 'show_less_text' );
$preview_lines  = get_sub_field( 'preview_lines' );

// Default values
$title          = $title ?: 'Christian clothes in Ukraine (SEO)';
$content        = $content ?: '';
$show_more_text = $show_more_text ?: 'Show more';
$show_less_text = $show_less_text ?: 'Show less';
$preview_lines  = $preview_lines ?: 4;

// Generate unique ID for this block instance
$block_id = 'seo-text-' . uniqid();
?>

<section class="seo-text-block py-16 bg-white">
	<div class="container mx-auto px-4">
		<!-- Title -->
		<h2 class="text-3xl lg:text-4xl font-bold text-gray-600 mb-6">
			<?php echo esc_html( $title ); ?>
		</h2>

		<!-- Content Container -->
		<div class="seo-content-wrapper relative">
			<!-- Text Content -->
			<div id="<?php echo esc_attr( $block_id ); ?>"
			     class="seo-text-content overflow-hidden transition-all duration-500 ease-in-out"
			     style="max-height: <?php echo esc_attr( $preview_lines * 1.75 ); ?>rem;"
			     data-collapsed="true">
				<div class="text-gray-600 text-base lg:text-lg leading-relaxed prose prose-lg max-w-none">
					<?php echo wpautop( $content ); ?>
				</div>
			</div>

			<!-- Fade Overlay (visible when collapsed) -->
			<div id="<?php echo esc_attr( $block_id ); ?>-overlay"
			     class="fade-overlay absolute bottom-0 left-0 right-0 h-20 bg-gradient-to-t from-white to-transparent pointer-events-none transition-opacity duration-500">
			</div>

			<!-- Show More/Less Button -->
			<button id="<?php echo esc_attr( $block_id ); ?>-button"
			        class="mt-6 bg-gray-100 text-gray-600 px-8 py-3 rounded-lg font-medium hover:bg-gray-200 transition-colors"
			        data-show-more="<?php echo esc_attr( $show_more_text ); ?>"
			        data-show-less="<?php echo esc_attr( $show_less_text ); ?>">
				<?php echo esc_html( $show_more_text ); ?>
			</button>
		</div>
	</div>
</section>

<script>
(function() {
	const content = document.getElementById('<?php echo esc_js( $block_id ); ?>');
	const button = document.getElementById('<?php echo esc_js( $block_id ); ?>-button');
	const overlay = document.getElementById('<?php echo esc_js( $block_id ); ?>-overlay');

	if (content && button) {
		button.addEventListener('click', function() {
			const isCollapsed = content.getAttribute('data-collapsed') === 'true';

			if (isCollapsed) {
				// Expand
				content.style.maxHeight = content.scrollHeight + 'px';
				content.setAttribute('data-collapsed', 'false');
				button.textContent = button.getAttribute('data-show-less');
				if (overlay) overlay.style.opacity = '0';
			} else {
				// Collapse
				content.style.maxHeight = '<?php echo esc_js( $preview_lines * 1.75 ); ?>rem';
				content.setAttribute('data-collapsed', 'true');
				button.textContent = button.getAttribute('data-show-more');
				if (overlay) overlay.style.opacity = '1';
			}
		});
	}
})();
</script>
