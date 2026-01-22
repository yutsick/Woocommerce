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
});
