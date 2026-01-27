/**
 * Front-end JavaScript
 *
 * The JavaScript code you place here will be processed by esbuild. The output
 * file will be created at `../theme/js/script.min.js` and enqueued in
 * `../theme/functions.php`.
 *
 * For esbuild documentation, please see:
 * https://esbuild.github.io/
 */

// Import Swiper
import Swiper from 'swiper';
import { Navigation, Pagination, Autoplay } from 'swiper/modules';

// Mobile Menu Toggle
document.addEventListener('DOMContentLoaded', function () {
	// =====================
	// Catalog Page Functionality
	// =====================

	// Filter Modal Toggle
	const filtersToggle = document.getElementById('filters-toggle');
	const filterModal = document.getElementById('filter-modal');
	const filterClose = document.getElementById('filter-close');

	if (filtersToggle && filterModal) {
		filtersToggle.addEventListener('click', function () {
			filterModal.classList.remove('hidden');
			filterModal.classList.add('active');
			document.body.classList.add('filter-open');
		});

		if (filterClose) {
			filterClose.addEventListener('click', function () {
				filterModal.classList.add('hidden');
				filterModal.classList.remove('active');
				document.body.classList.remove('filter-open');
			});
		}

		// Close on escape key
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && filterModal.classList.contains('active')) {
				filterModal.classList.add('hidden');
				filterModal.classList.remove('active');
				document.body.classList.remove('filter-open');
			}
		});
	}

	// Sort Dropdown Toggle
	const sortToggle = document.getElementById('sort-toggle');
	const sortDropdown = document.getElementById('sort-dropdown');

	if (sortToggle && sortDropdown) {
		sortToggle.addEventListener('click', function (e) {
			e.stopPropagation();
			const isExpanded = sortToggle.getAttribute('aria-expanded') === 'true';
			sortToggle.setAttribute('aria-expanded', !isExpanded);
			sortDropdown.classList.toggle('hidden');
		});

		// Close dropdown when clicking outside
		document.addEventListener('click', function (e) {
			if (!sortToggle.contains(e.target) && !sortDropdown.contains(e.target)) {
				sortToggle.setAttribute('aria-expanded', 'false');
				sortDropdown.classList.add('hidden');
			}
		});
	}

	// Filter Form Submit
	const filterForm = document.getElementById('filter-form');
	if (filterForm) {
		filterForm.addEventListener('submit', function (e) {
			e.preventDefault();

			const formData = new FormData(filterForm);
			const params = new URLSearchParams(window.location.search);

			// Clear existing filter params
			params.delete('product_cat[]');
			params.delete('filter_size[]');
			params.delete('filter_color[]');

			// Add new filter params
			for (const [key, value] of formData.entries()) {
				if (value) {
					params.append(key, value);
				}
			}

			// Redirect with new params
			window.location.href = window.location.pathname + '?' + params.toString();
		});
	}

	// =====================
	// Mobile Menu Toggle
	// =====================
	const menuToggle = document.getElementById('mobile-menu-toggle');
	const mobileMenu = document.getElementById('mobile-menu');

	if (menuToggle && mobileMenu) {
		menuToggle.addEventListener('click', function () {
			mobileMenu.classList.toggle('hidden');
			document.body.classList.toggle('overflow-hidden');
		});

		// Close menu when clicking on a link
		const menuLinks = mobileMenu.querySelectorAll('a');
		menuLinks.forEach((link) => {
			link.addEventListener('click', function () {
				mobileMenu.classList.add('hidden');
				document.body.classList.remove('overflow-hidden');
			});
		});

		// Close menu on escape key
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
				mobileMenu.classList.add('hidden');
				document.body.classList.remove('overflow-hidden');
			}
		});
	}

	// Initialize Best Offers Swiper
	const bestOffersSwiper = document.querySelector('.best-offers-swiper');
	if (bestOffersSwiper) {
		new Swiper('.best-offers-swiper', {
			modules: [Navigation, Pagination, Autoplay],
			slidesPerView: 1,
			spaceBetween: 20,
			loop: true,
			autoplay: {
				delay: 5000,
				disableOnInteraction: false,
			},
			navigation: {
				nextEl: '.swiper-button-next-custom',
				prevEl: '.swiper-button-prev-custom',
			},
		});
	}

	// Initialize Testimonials Swiper
	const testimonialsSwiper = document.querySelector('.testimonials-swiper');
	if (testimonialsSwiper) {
		new Swiper('.testimonials-swiper', {
			modules: [Navigation, Autoplay],
			slidesPerView: 1,
			spaceBetween: 20,
			loop: true,
			autoplay: {
				delay: 6000,
				disableOnInteraction: false,
			},
			navigation: {
				nextEl: '.swiper-button-next-testimonials',
				prevEl: '.swiper-button-prev-testimonials',
			},
		});
	}
});
