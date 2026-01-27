<?php
/**
 * Template for Shop page (slug: shop)
 *
 * AJAX-powered products catalog page with filtering.
 *
 * @package allmighty
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Get all product categories
$categories = get_terms( array(
	'taxonomy'   => 'product_cat',
	'hide_empty' => true,
	'parent'     => 0,
) );

// Initial load - get all products
$initial_args = array(
	'post_type'      => 'product',
	'post_status'    => 'publish',
	'posts_per_page' => 12,
	'paged'          => 1,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

$products_query = new WP_Query( $initial_args );

// Get initial filters (all products) - DYNAMIC!
$initial_filters = allmighty_get_available_filters( 'all' );

// Count all products
$all_products_count = wp_count_posts( 'product' )->publish;
?>

<!-- Breadcrumbs -->
<section class="breadcrumbs-section bg-white">
	<div class="container mx-auto px-4">
		<div class="h-16 lg:h-20 flex items-center">
			<nav class="breadcrumbs text-sm text-[#626262]">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-[#3a3a3a] transition-colors">
					<?php esc_html_e( 'Almighty Victory', 'allmighty' ); ?>
				</a>
				<span class="mx-2">/</span>
				<span id="breadcrumb-current"><?php esc_html_e( 'All Products', 'allmighty' ); ?></span>
			</nav>
		</div>
	</div>
</section>

<!-- Categories Section -->
<section class="categories-section bg-white py-6 border-b border-gray-100">
	<div class="container mx-auto px-4">
		<div class="flex flex-wrap justify-center gap-3" id="categories-list">
			<!-- All Products Button -->
			<button type="button"
			        class="category-btn px-5 py-2.5 rounded-full border-2 transition-all font-medium active border-[#3a3a3a] bg-[#3a3a3a] text-white"
			        data-category="all">
				<?php esc_html_e( 'All Products', 'allmighty' ); ?>
				<span class="ml-1.5 text-sm opacity-75">(<?php echo esc_html( $all_products_count ); ?>)</span>
			</button>

			<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
				<?php foreach ( $categories as $cat ) : ?>
					<button type="button"
					        class="category-btn px-5 py-2.5 rounded-full border-2 transition-all font-medium border-gray-300 bg-white text-[#3a3a3a] hover:border-[#3a3a3a]"
					        data-category="<?php echo esc_attr( $cat->slug ); ?>">
						<?php echo esc_html( $cat->name ); ?>
						<span class="ml-1.5 text-sm opacity-75">(<?php echo esc_html( $cat->count ); ?>)</span>
					</button>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- Toolbar Section -->
<section class="toolbar-section py-6 bg-white">
	<div class="container mx-auto px-4">
		<div class="flex items-center justify-between">
			<!-- Filters Button -->
			<button id="filters-toggle"
			        class="flex items-center gap-2 px-6 py-3 bg-[#3a3a3a] text-white rounded-lg hover:bg-[#4a4a4a] transition-colors">
				<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
				</svg>
				<span><?php esc_html_e( 'Filters', 'allmighty' ); ?></span>
				<span id="active-filters-count" class="hidden ml-1 px-2 py-0.5 bg-white text-[#3a3a3a] text-xs font-bold rounded-full">0</span>
			</button>

			<!-- Sort Dropdown -->
			<div class="relative">
				<button id="sort-toggle"
				        class="flex items-center gap-2 px-6 py-3 bg-white text-[#3a3a3a] border border-gray-300 rounded-lg hover:border-[#3a3a3a] transition-colors">
					<span id="sort-label"><?php esc_html_e( 'New arrivals', 'allmighty' ); ?></span>
					<svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
					</svg>
				</button>

				<!-- Sort Dropdown Menu -->
				<div id="sort-dropdown"
				     class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl z-20 hidden border border-gray-100">
					<button type="button" class="sort-option block w-full text-left px-4 py-3 text-[#3a3a3a] hover:bg-gray-100 transition-colors rounded-t-lg font-bold" data-sort="date">
						<?php esc_html_e( 'New arrivals', 'allmighty' ); ?>
					</button>
					<button type="button" class="sort-option block w-full text-left px-4 py-3 text-[#3a3a3a] hover:bg-gray-100 transition-colors" data-sort="price-desc">
						<?php esc_html_e( 'Price: High to Low', 'allmighty' ); ?>
					</button>
					<button type="button" class="sort-option block w-full text-left px-4 py-3 text-[#3a3a3a] hover:bg-gray-100 transition-colors rounded-b-lg" data-sort="price">
						<?php esc_html_e( 'Price: Low to High', 'allmighty' ); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Filter Sidebar -->
<div id="filter-sidebar" class="fixed inset-y-0 left-0 w-80 bg-white shadow-2xl z-50 transform -translate-x-full transition-transform duration-300">
	<div class="h-full flex flex-col">
		<!-- Header -->
		<div class="flex items-center justify-between p-6 border-b border-gray-200">
			<h2 class="text-xl font-bold text-[#3a3a3a]"><?php esc_html_e( 'Filters', 'allmighty' ); ?></h2>
			<button id="filter-close" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
				<svg class="w-6 h-6 text-[#3a3a3a]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
				</svg>
			</button>
		</div>

		<!-- Filter Content - DYNAMIC -->
		<div class="flex-1 overflow-y-auto p-6" id="filter-content">
			<?php echo allmighty_render_filters_html( $initial_filters ); ?>
		</div>

		<!-- Footer Buttons -->
		<div id="filter-buttons" class="p-6 border-t border-gray-200 space-y-3 <?php echo empty( $initial_filters ) ? 'hidden' : ''; ?>">
			<button type="button" id="apply-filters"
			        class="w-full py-3 bg-[#3a3a3a] text-white font-medium rounded-lg hover:bg-[#4a4a4a] transition-colors">
				<?php esc_html_e( 'Apply Filters', 'allmighty' ); ?>
			</button>
			<button type="button" id="reset-filters"
			        class="w-full py-3 bg-white text-[#3a3a3a] font-medium rounded-lg border border-gray-300 hover:border-[#3a3a3a] transition-colors">
				<?php esc_html_e( 'Reset', 'allmighty' ); ?>
			</button>
		</div>
	</div>
</div>

<!-- Filter Overlay -->
<div id="filter-overlay" class="fixed inset-0 bg-black/50 z-40 hidden"></div>

<!-- Products Grid Section -->
<section class="products-section bg-gray-50 py-8 lg:py-12">
	<div class="container mx-auto px-4">
		<!-- Loading Indicator -->
		<div id="products-loading" class="hidden">
			<div class="flex items-center justify-center py-16">
				<div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#3a3a3a]"></div>
			</div>
		</div>

		<!-- Products Grid -->
		<div id="products-grid" class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
			<?php
			if ( $products_query->have_posts() ) :
				while ( $products_query->have_posts() ) :
					$products_query->the_post();
					global $product;
					$product = wc_get_product( get_the_ID() );

					allmighty_render_product_card( $product );
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="col-span-full text-center py-16">
					<p class="text-gray-500 text-lg"><?php esc_html_e( 'No products found.', 'allmighty' ); ?></p>
				</div>
				<?php
			endif;
			?>
		</div>

		<!-- Pagination -->
		<div id="pagination-container">
			<?php allmighty_render_pagination( $products_query, 1 ); ?>
		</div>
	</div>
</section>

<script>
(function() {
	'use strict';

	const ShopCatalog = {
		// State
		state: {
			category: 'all',
			filters: {}, // Dynamic: { 'pa_size': ['m', 'l'], 'pa_color': ['red'] }
			orderby: 'date',
			paged: 1
		},

		// DOM Elements
		elements: {},

		// Config
		config: {
			ajaxUrl: '<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>',
			nonce: '<?php echo wp_create_nonce( 'allmighty_shop_nonce' ); ?>',
			sortLabels: {
				'date': '<?php echo esc_js( __( 'New arrivals', 'allmighty' ) ); ?>',
				'price-desc': '<?php echo esc_js( __( 'Price: High to Low', 'allmighty' ) ); ?>',
				'price': '<?php echo esc_js( __( 'Price: Low to High', 'allmighty' ) ); ?>'
			},
			noFiltersText: '<?php echo esc_js( __( 'No filters available for these products.', 'allmighty' ) ); ?>',
			allProductsText: '<?php echo esc_js( __( 'All Products', 'allmighty' ) ); ?>'
		},

		init() {
			this.cacheElements();
			this.bindEvents();
		},

		cacheElements() {
			this.elements = {
				categoriesList: document.getElementById('categories-list'),
				productsGrid: document.getElementById('products-grid'),
				productsLoading: document.getElementById('products-loading'),
				paginationContainer: document.getElementById('pagination-container'),
				breadcrumbCurrent: document.getElementById('breadcrumb-current'),
				filterSidebar: document.getElementById('filter-sidebar'),
				filterOverlay: document.getElementById('filter-overlay'),
				filterContent: document.getElementById('filter-content'),
				filterButtons: document.getElementById('filter-buttons'),
				filtersToggle: document.getElementById('filters-toggle'),
				filterClose: document.getElementById('filter-close'),
				applyFilters: document.getElementById('apply-filters'),
				resetFilters: document.getElementById('reset-filters'),
				activeFiltersCount: document.getElementById('active-filters-count'),
				sortToggle: document.getElementById('sort-toggle'),
				sortDropdown: document.getElementById('sort-dropdown'),
				sortLabel: document.getElementById('sort-label')
			};
		},

		bindEvents() {
			// Category buttons
			this.elements.categoriesList.addEventListener('click', (e) => {
				const btn = e.target.closest('.category-btn');
				if (btn) {
					this.handleCategoryClick(btn);
				}
			});

			// Filter sidebar toggle
			this.elements.filtersToggle.addEventListener('click', () => this.openFilterSidebar());
			this.elements.filterClose.addEventListener('click', () => this.closeFilterSidebar());
			this.elements.filterOverlay.addEventListener('click', () => this.closeFilterSidebar());

			// Apply filters
			this.elements.applyFilters.addEventListener('click', () => {
				this.collectFilters();
				this.state.paged = 1;
				this.fetchProducts();
				this.closeFilterSidebar();
			});

			// Reset filters
			this.elements.resetFilters.addEventListener('click', () => {
				this.resetAllFilters();
			});

			// Sort dropdown toggle
			this.elements.sortToggle.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				const isHidden = this.elements.sortDropdown.classList.contains('hidden');
				if (isHidden) {
					this.elements.sortDropdown.classList.remove('hidden');
				} else {
					this.elements.sortDropdown.classList.add('hidden');
				}
			});

			// Sort options click (event delegation)
			this.elements.sortDropdown.addEventListener('click', (e) => {
				const btn = e.target.closest('.sort-option');
				if (btn) {
					this.handleSortChange(btn);
				}
			});

			// Close sort dropdown on outside click
			document.addEventListener('click', (e) => {
				const sortContainer = this.elements.sortToggle.parentElement;
				if (!sortContainer.contains(e.target)) {
					this.elements.sortDropdown.classList.add('hidden');
				}
			});

			// Pagination (event delegation)
			this.elements.paginationContainer.addEventListener('click', (e) => {
				const btn = e.target.closest('.pagination-btn');
				if (btn) {
					this.handlePaginationClick(btn);
				}
			});
		},

		handleCategoryClick(btn) {
			const category = btn.dataset.category;

			// Update active state
			document.querySelectorAll('.category-btn').forEach(b => {
				b.classList.remove('active', 'border-[#3a3a3a]', 'bg-[#3a3a3a]', 'text-white');
				b.classList.add('border-gray-300', 'bg-white', 'text-[#3a3a3a]');
			});
			btn.classList.add('active', 'border-[#3a3a3a]', 'bg-[#3a3a3a]', 'text-white');
			btn.classList.remove('border-gray-300', 'bg-white', 'text-[#3a3a3a]');

			// Update state and fetch
			this.state.category = category;
			this.state.filters = {}; // Reset filters on category change
			this.state.paged = 1;

			this.updateActiveFiltersCount();
			this.fetchProducts();
		},

		handleSortChange(btn) {
			const sortValue = btn.dataset.sort;

			// Update active state
			document.querySelectorAll('.sort-option').forEach(b => b.classList.remove('font-bold'));
			btn.classList.add('font-bold');

			// Update label
			this.elements.sortLabel.textContent = this.config.sortLabels[sortValue];

			// Update state and fetch
			this.state.orderby = sortValue;
			this.state.paged = 1;
			this.elements.sortDropdown.classList.add('hidden');

			this.fetchProducts();
		},

		handlePaginationClick(btn) {
			const page = parseInt(btn.dataset.page, 10);
			if (page && page !== this.state.paged) {
				this.state.paged = page;
				this.fetchProducts();

				// Scroll to products
				this.elements.productsGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
			}
		},

		openFilterSidebar() {
			this.elements.filterSidebar.classList.remove('-translate-x-full');
			this.elements.filterOverlay.classList.remove('hidden');
			document.body.style.overflow = 'hidden';
		},

		closeFilterSidebar() {
			this.elements.filterSidebar.classList.add('-translate-x-full');
			this.elements.filterOverlay.classList.add('hidden');
			document.body.style.overflow = '';
		},

		toggleSortDropdown() {
			this.elements.sortDropdown.classList.toggle('hidden');
		},

		collectFilters() {
			this.state.filters = {};

			// Get all checked checkboxes and group by taxonomy
			document.querySelectorAll('#filter-content .filter-checkbox:checked').forEach(cb => {
				const taxonomy = cb.dataset.taxonomy;
				if (!this.state.filters[taxonomy]) {
					this.state.filters[taxonomy] = [];
				}
				this.state.filters[taxonomy].push(cb.value);
			});

			this.updateActiveFiltersCount();
		},

		updateActiveFiltersCount() {
			let count = 0;
			for (const taxonomy in this.state.filters) {
				count += this.state.filters[taxonomy].length;
			}

			if (count > 0) {
				this.elements.activeFiltersCount.textContent = count;
				this.elements.activeFiltersCount.classList.remove('hidden');
			} else {
				this.elements.activeFiltersCount.classList.add('hidden');
			}
		},

		resetAllFilters() {
			this.state.filters = {};

			document.querySelectorAll('#filter-content .filter-checkbox').forEach(cb => cb.checked = false);
			this.updateActiveFiltersCount();

			this.state.paged = 1;
			this.fetchProducts();
			this.closeFilterSidebar();
		},

		async fetchProducts() {
			// Show loading
			this.elements.productsGrid.style.opacity = '0.5';
			this.elements.productsLoading.classList.remove('hidden');

			const formData = new FormData();
			formData.append('action', 'allmighty_get_products');
			formData.append('nonce', this.config.nonce);
			formData.append('category', this.state.category);
			formData.append('orderby', this.state.orderby);
			formData.append('paged', this.state.paged);

			// Add dynamic filters
			for (const taxonomy in this.state.filters) {
				this.state.filters[taxonomy].forEach(term => {
					formData.append(`filters[${taxonomy}][]`, term);
				});
			}

			try {
				const response = await fetch(this.config.ajaxUrl, {
					method: 'POST',
					body: formData
				});

				const data = await response.json();

				if (data.success) {
					// Update products
					this.elements.productsGrid.innerHTML = data.data.products;

					// Update pagination
					this.elements.paginationContainer.innerHTML = data.data.pagination;

					// Update breadcrumbs
					this.elements.breadcrumbCurrent.textContent = data.data.breadcrumb_category || this.config.allProductsText;

					// Update filters (dynamic)
					this.updateFilters(data.data.filters);
				}
			} catch (error) {
				console.error('Error fetching products:', error);
			} finally {
				// Hide loading
				this.elements.productsGrid.style.opacity = '1';
				this.elements.productsLoading.classList.add('hidden');
			}
		},

		updateFilters(filters) {
			if (!filters || filters.length === 0) {
				this.elements.filterContent.innerHTML = `<p class="text-gray-500 text-center py-8">${this.config.noFiltersText}</p>`;
				this.elements.filterButtons.classList.add('hidden');
				return;
			}

			// Show filter buttons
			this.elements.filterButtons.classList.remove('hidden');

			let html = '';

			filters.forEach(filter => {
				const selectedTerms = this.state.filters[filter.taxonomy] || [];

				html += `
					<div class="filter-group mb-8" data-taxonomy="${filter.taxonomy}">
						<h3 class="font-semibold mb-4 text-[#3a3a3a]">${filter.label}</h3>
						<div class="filter-terms">
				`;

				filter.terms.forEach(term => {
					const isChecked = selectedTerms.includes(term.slug) ? 'checked' : '';
					html += `
						<label class="flex items-center gap-3 mb-3 cursor-pointer hover:text-[#3a3a3a] transition-colors">
							<input type="checkbox"
							       name="${filter.taxonomy}[]"
							       value="${term.slug}"
							       ${isChecked}
							       class="filter-checkbox w-5 h-5 rounded border-gray-300 text-[#3a3a3a] focus:ring-[#3a3a3a]"
							       data-taxonomy="${filter.taxonomy}">
							<span>${term.name}</span>
						</label>
					`;
				});

				html += `
						</div>
					</div>
				`;
			});

			this.elements.filterContent.innerHTML = html;
		}
	};

	// Initialize on DOM ready
	document.addEventListener('DOMContentLoaded', () => ShopCatalog.init());
})();
</script>

<?php
get_footer();
