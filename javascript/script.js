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
			filterModal.classList.add('active');
			document.body.classList.add('filter-open');
		});

		if (filterClose) {
			filterClose.addEventListener('click', function () {
				filterModal.classList.remove('active');
				document.body.classList.remove('filter-open');
			});
		}

		// Close on escape key
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && filterModal.classList.contains('active')) {
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

	// =====================
	// Checkout Page Functionality
	// =====================
	const checkoutForm = document.getElementById('checkout-form');

	if (checkoutForm) {
		// Quantity Controls
		const quantityMinusButtons = document.querySelectorAll('.quantity-minus');
		const quantityPlusButtons = document.querySelectorAll('.quantity-plus');
		const removeButtons = document.querySelectorAll('.remove-cart-item');

		// Update cart via AJAX
		async function updateCartItem(cartItemKey, quantity) {
			checkoutForm.classList.add('loading');

			try {
				const response = await fetch(window.allmightyAjax?.ajaxUrl || '/wp-admin/admin-ajax.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: new URLSearchParams({
						action: 'allmighty_update_cart_item',
						cart_item_key: cartItemKey,
						quantity: quantity,
						nonce: window.allmightyAjax?.nonce || '',
					}),
				});

				const data = await response.json();

				if (data.success) {
					// Update total
					const cartTotal = document.querySelector('.cart-total');
					if (cartTotal && data.data.total) {
						cartTotal.innerHTML = data.data.total;
					}

					// Remove item from DOM if quantity is 0
					if (quantity === 0) {
						const cartItem = document.querySelector(`[data-cart-item-key="${cartItemKey}"]`);
						if (cartItem) {
							cartItem.remove();
						}

						// Redirect to shop if cart is empty
						if (data.data.cart_empty) {
							window.location.href = data.data.shop_url || '/shop';
						}
					}
				} else {
					console.error('Error updating cart:', data.data?.message);
				}
			} catch (error) {
				console.error('AJAX error:', error);
			} finally {
				checkoutForm.classList.remove('loading');
			}
		}

		// Minus button click
		quantityMinusButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const cartItemKey = this.dataset.cartItemKey;
				const quantityEl = this.parentElement.querySelector('.quantity-value');
				let quantity = parseInt(quantityEl.textContent, 10);

				if (quantity > 1) {
					quantity--;
					quantityEl.textContent = quantity;
					updateCartItem(cartItemKey, quantity);
				}
			});
		});

		// Plus button click
		quantityPlusButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const cartItemKey = this.dataset.cartItemKey;
				const quantityEl = this.parentElement.querySelector('.quantity-value');
				let quantity = parseInt(quantityEl.textContent, 10);

				quantity++;
				quantityEl.textContent = quantity;
				updateCartItem(cartItemKey, quantity);
			});
		});

		// Remove button click
		removeButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const cartItemKey = this.dataset.cartItemKey;
				updateCartItem(cartItemKey, 0);
			});
		});

		// Payment method change - handle Monobank
		const paymentMethodSelect = document.getElementById('payment_method');
		if (paymentMethodSelect) {
			paymentMethodSelect.addEventListener('change', function () {
				const submitButtons = document.querySelectorAll('#place-order-mobile, #place-order-desktop');
				const isOnline = this.value === 'online';

				submitButtons.forEach((btn) => {
					btn.textContent = isOnline ? 'Pay now' : 'Place order';
				});
			});
		}
	}

	// =====================
	// Mini Cart Functionality
	// =====================
	const miniCartDrawer = document.getElementById('mini-cart-drawer');
	const miniCartOverlay = document.getElementById('mini-cart-overlay');
	const miniCartClose = document.getElementById('mini-cart-close');
	const miniCartToggles = document.querySelectorAll('.mini-cart-toggle');

	if (miniCartDrawer && miniCartOverlay) {
		// Open mini cart
		function openMiniCart() {
			miniCartDrawer.classList.add('active');
			miniCartOverlay.classList.remove('hidden');
			miniCartOverlay.classList.add('active');
			document.body.classList.add('mini-cart-open');
		}

		// Close mini cart
		function closeMiniCart() {
			miniCartDrawer.classList.remove('active');
			miniCartOverlay.classList.remove('active');
			setTimeout(() => {
				miniCartOverlay.classList.add('hidden');
			}, 300);
			document.body.classList.remove('mini-cart-open');
		}

		// Toggle buttons
		miniCartToggles.forEach((toggle) => {
			toggle.addEventListener('click', openMiniCart);
		});

		// Close button
		if (miniCartClose) {
			miniCartClose.addEventListener('click', closeMiniCart);
		}

		// Overlay click
		miniCartOverlay.addEventListener('click', closeMiniCart);

		// Escape key
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && miniCartDrawer.classList.contains('active')) {
				closeMiniCart();
			}
		});

		// Mini Cart AJAX Update
		async function updateMiniCartItem(cartItemKey, quantity) {
			miniCartDrawer.classList.add('loading');

			try {
				const response = await fetch(window.allmightyAjax?.ajaxUrl || '/wp-admin/admin-ajax.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: new URLSearchParams({
						action: 'allmighty_update_cart_item',
						cart_item_key: cartItemKey,
						quantity: quantity,
						nonce: window.allmightyAjax?.nonce || '',
					}),
				});

				const data = await response.json();

				if (data.success) {
					// Update cart count badges
					const cartCounts = document.querySelectorAll('.cart-count');
					cartCounts.forEach((badge) => {
						if (data.data.cart_count > 0) {
							badge.textContent = data.data.cart_count;
							badge.classList.remove('hidden');
							badge.classList.add('pulse');
							setTimeout(() => badge.classList.remove('pulse'), 300);
						} else {
							badge.classList.add('hidden');
						}
					});

					// Remove item from DOM if quantity is 0
					if (quantity === 0) {
						const cartItem = miniCartDrawer.querySelector(`[data-cart-item-key="${cartItemKey}"]`);
						if (cartItem) {
							cartItem.style.opacity = '0';
							cartItem.style.transform = 'translateX(100%)';
							setTimeout(() => cartItem.remove(), 300);
						}

						// Show empty cart message if cart is empty
						if (data.data.cart_empty) {
							setTimeout(() => {
								location.reload();
							}, 300);
						}
					}
				} else {
					console.error('Error updating cart:', data.data?.message);
				}
			} catch (error) {
				console.error('AJAX error:', error);
			} finally {
				miniCartDrawer.classList.remove('loading');
			}
		}

		// Mini Cart Quantity Controls
		const miniCartMinusButtons = miniCartDrawer.querySelectorAll('.mini-cart-minus');
		const miniCartPlusButtons = miniCartDrawer.querySelectorAll('.mini-cart-plus');
		const miniCartRemoveButtons = miniCartDrawer.querySelectorAll('.mini-cart-remove');

		miniCartMinusButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const cartItemKey = this.dataset.cartItemKey;
				const quantityEl = this.parentElement.querySelector('.mini-cart-qty-value');
				let quantity = parseInt(quantityEl.textContent, 10);

				if (quantity > 1) {
					quantity--;
					quantityEl.textContent = quantity;
					updateMiniCartItem(cartItemKey, quantity);
				}
			});
		});

		miniCartPlusButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const cartItemKey = this.dataset.cartItemKey;
				const quantityEl = this.parentElement.querySelector('.mini-cart-qty-value');
				let quantity = parseInt(quantityEl.textContent, 10);

				quantity++;
				quantityEl.textContent = quantity;
				updateMiniCartItem(cartItemKey, quantity);
			});
		});

		miniCartRemoveButtons.forEach((button) => {
			button.addEventListener('click', function () {
				const cartItemKey = this.dataset.cartItemKey;
				updateMiniCartItem(cartItemKey, 0);
			});
		});
	}
});
