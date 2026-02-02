<?php
/**
 * Size Guide Modal Template
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

// Get Size Guide data from ACF options
$size_guide_title    = get_field( 'size_guide_title', 'option' ) ?: 'Size guide';
$size_guide_subtitle = get_field( 'size_guide_subtitle', 'option' ) ?: 'Choose size';
$size_guide_image    = get_field( 'size_guide_image', 'option' );
$size_guide_sizes    = get_field( 'size_guide_sizes', 'option' );

// Default sizes if not set
if ( empty( $size_guide_sizes ) ) {
	$size_guide_sizes = array(
		array(
			'size_name' => 'S',
			'measurements' => array(
				array( 'label' => 'A', 'name' => 'Height', 'value' => '165-170 cm' ),
				array( 'label' => 'B', 'name' => 'Chest circumference', 'value' => '82-86 cm' ),
				array( 'label' => 'C', 'name' => 'Waist circumference', 'value' => '70-75 cm' ),
				array( 'label' => 'D', 'name' => 'Hip circumference', 'value' => '84-88 cm' ),
			),
		),
		array(
			'size_name' => 'M',
			'measurements' => array(
				array( 'label' => 'A', 'name' => 'Height', 'value' => '170-174 cm' ),
				array( 'label' => 'B', 'name' => 'Chest circumference', 'value' => '86-92 cm' ),
				array( 'label' => 'C', 'name' => 'Waist circumference', 'value' => '75-80 cm' ),
				array( 'label' => 'D', 'name' => 'Hip circumference', 'value' => '87-91 cm' ),
			),
		),
		array(
			'size_name' => 'L',
			'measurements' => array(
				array( 'label' => 'A', 'name' => 'Height', 'value' => '174-178 cm' ),
				array( 'label' => 'B', 'name' => 'Chest circumference', 'value' => '92-98 cm' ),
				array( 'label' => 'C', 'name' => 'Waist circumference', 'value' => '80-85 cm' ),
				array( 'label' => 'D', 'name' => 'Hip circumference', 'value' => '91-95 cm' ),
			),
		),
		array(
			'size_name' => 'XL',
			'measurements' => array(
				array( 'label' => 'A', 'name' => 'Height', 'value' => '178-182 cm' ),
				array( 'label' => 'B', 'name' => 'Chest circumference', 'value' => '98-104 cm' ),
				array( 'label' => 'C', 'name' => 'Waist circumference', 'value' => '85-90 cm' ),
				array( 'label' => 'D', 'name' => 'Hip circumference', 'value' => '95-99 cm' ),
			),
		),
	);
}

// Prepare sizes data for JS
$sizes_json = wp_json_encode( $size_guide_sizes );
?>

<!-- Size Guide Overlay -->
<div id="size-guide-overlay" class="fixed inset-0 bg-black/50 z-[60] hidden"></div>

<!-- Size Guide Modal -->
<div id="size-guide-modal" class="fixed top-0 right-0 h-full w-full max-w-md bg-white z-[70] shadow-2xl translate-x-full transition-transform duration-300">
	<div class="flex flex-col h-full">
		<!-- Header -->
		<div class="flex items-center justify-between p-6">
			<h2 class="text-2xl font-bold text-[#3a3a3a]"><?php echo esc_html( $size_guide_title ); ?></h2>
			<button id="size-guide-close" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" aria-label="<?php esc_attr_e( 'Close', 'allmighty' ); ?>">
				<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>
		</div>

		<!-- Content -->
		<div class="flex-1 overflow-y-auto px-6 pb-6">
			<!-- Size Selector -->
			<div class="mb-6">
				<p class="text-[#6b7280] mb-3"><?php echo esc_html( $size_guide_subtitle ); ?></p>
				<div class="flex gap-2" id="size-guide-buttons">
					<?php foreach ( $size_guide_sizes as $index => $size ) : ?>
						<button type="button"
						        class="size-guide-btn px-5 py-2 border-2 border-[#3a3a3a] rounded-lg text-[#3a3a3a] font-medium transition-colors hover:bg-gray-100 <?php echo $index === 1 ? 'bg-[#3a3a3a] text-white' : ''; ?>"
						        data-size-index="<?php echo esc_attr( $index ); ?>">
							<?php echo esc_html( $size['size_name'] ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- Measurements Table -->
			<div class="mb-6" id="size-guide-measurements">
				<?php
				// Default to second size (M)
				$default_size = isset( $size_guide_sizes[1] ) ? $size_guide_sizes[1] : $size_guide_sizes[0];
				if ( ! empty( $default_size['measurements'] ) ) :
					foreach ( $default_size['measurements'] as $measurement ) :
				?>
					<div class="flex items-center py-4 border-b border-gray-200">
						<span class="w-8 font-bold text-[#3a3a3a]"><?php echo esc_html( $measurement['label'] ); ?></span>
						<span class="flex-1 text-[#3a3a3a]"><?php echo esc_html( $measurement['name'] ); ?></span>
						<span class="text-[#3a3a3a]"><?php echo esc_html( $measurement['value'] ); ?></span>
					</div>
				<?php
					endforeach;
				endif;
				?>
			</div>

			<!-- Size Guide Image -->
			<?php if ( $size_guide_image ) : ?>
				<div class="bg-gray-100 rounded-lg overflow-hidden">
					<img src="<?php echo esc_url( $size_guide_image['url'] ); ?>"
					     alt="<?php echo esc_attr( $size_guide_image['alt'] ?? 'Size guide' ); ?>"
					     class="w-full h-auto">
				</div>
			<?php else : ?>
				<div class="bg-gray-100 rounded-lg p-8 text-center">
					<svg class="w-32 h-32 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
					</svg>
					<p class="text-gray-400 mt-2 text-sm"><?php esc_html_e( 'Size guide image', 'allmighty' ); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>

<script>
(function() {
	var sizesData = <?php echo $sizes_json; ?>;
	var overlay = document.getElementById('size-guide-overlay');
	var modal = document.getElementById('size-guide-modal');
	var closeBtn = document.getElementById('size-guide-close');
	var buttons = document.querySelectorAll('.size-guide-btn');
	var measurementsContainer = document.getElementById('size-guide-measurements');

	// Open modal
	document.addEventListener('click', function(e) {
		if (e.target.closest('#size-guide-trigger')) {
			e.preventDefault();
			overlay.classList.remove('hidden');
			modal.classList.remove('translate-x-full');
			document.body.style.overflow = 'hidden';
		}
	});

	// Close modal
	function closeModal() {
		overlay.classList.add('hidden');
		modal.classList.add('translate-x-full');
		document.body.style.overflow = '';
	}

	closeBtn.addEventListener('click', closeModal);
	overlay.addEventListener('click', closeModal);

	// Size button click
	buttons.forEach(function(btn) {
		btn.addEventListener('click', function() {
			var index = parseInt(this.dataset.sizeIndex);

			// Update active state
			buttons.forEach(function(b) {
				b.classList.remove('bg-[#3a3a3a]', 'text-white');
			});
			this.classList.add('bg-[#3a3a3a]', 'text-white');

			// Update measurements
			var size = sizesData[index];
			if (size && size.measurements) {
				var html = '';
				size.measurements.forEach(function(m) {
					html += '<div class="flex items-center py-4 border-b border-gray-200">';
					html += '<span class="w-8 font-bold text-[#3a3a3a]">' + escapeHtml(m.label) + '</span>';
					html += '<span class="flex-1 text-[#3a3a3a]">' + escapeHtml(m.name) + '</span>';
					html += '<span class="text-[#3a3a3a]">' + escapeHtml(m.value) + '</span>';
					html += '</div>';
				});
				measurementsContainer.innerHTML = html;
			}
		});
	});

	function escapeHtml(text) {
		var div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}
})();
</script>
