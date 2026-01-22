<?php
/**
 * Template part for displaying the footer content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package allmighty
 */

// Get current year for copyright
$current_year = gmdate( 'Y' );
?>

<footer id="colophon" class="bg-[#3a3a3a] text-white">
	<!-- Main Footer Content -->
	<div class="container mx-auto px-4 py-12">
		<!-- Desktop Layout -->
		<div class="hidden lg:flex lg:items-center lg:justify-between">
			<!-- Left: Contact Info -->
			<div class="lg:w-1/3">
				<h3 class="text-2xl font-bold mb-6">Contact Us</h3>
				<div class="space-y-3">
					<a href="tel:+1234567890" class="block text-lg hover:text-gray-300 transition-colors">
						(123) 456 - 789
					</a>
					<a href="mailto:contact@company.com" class="block text-lg hover:text-gray-300 transition-colors">
						contact@company.com
					</a>
				</div>

				<!-- Social Icons -->
				<div class="flex items-center gap-4 mt-6">
					<a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
					   class="w-10 h-10 flex items-center justify-center hover:opacity-80 transition-opacity"
					   aria-label="Instagram">
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
							<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
						</svg>
					</a>
					<a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
					   class="w-10 h-10 flex items-center justify-center hover:opacity-80 transition-opacity"
					   aria-label="YouTube">
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
							<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
						</svg>
					</a>
					<a href="https://tiktok.com" target="_blank" rel="noopener noreferrer"
					   class="w-10 h-10 flex items-center justify-center hover:opacity-80 transition-opacity"
					   aria-label="TikTok">
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
							<path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
						</svg>
					</a>
				</div>
			</div>

			<!-- Center: Footer Menu -->
			<nav class="lg:w-1/3 flex justify-center" aria-label="<?php esc_attr_e( 'Footer Menu', 'allmighty' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'footer-menu',
						'container'      => false,
						'menu_class'     => 'flex items-center gap-8',
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>

			<!-- Right: Logo -->
			<div class="lg:w-1/3 flex justify-end">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="https://placehold.co/150x100/3a3a3a/ffffff?text=LOGO" alt="<?php bloginfo( 'name' ); ?>" class="h-20 w-auto">
				</a>
			</div>
		</div>

		<!-- Mobile Layout -->
		<div class="lg:hidden">
			<!-- Contact Info -->
			<div class="text-center mb-8">
				<h3 class="text-2xl font-bold mb-6">Contact Us</h3>
				<div class="space-y-3 mb-6">
					<a href="tel:+1234567890" class="block text-lg hover:text-gray-300 transition-colors">
						(123) 456 - 789
					</a>
					<a href="mailto:contact@company.com" class="block text-lg hover:text-gray-300 transition-colors">
						contact@company.com
					</a>
				</div>

				<!-- Social Icons -->
				<div class="flex items-center justify-center gap-4">
					<a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
					   class="w-10 h-10 flex items-center justify-center hover:opacity-80 transition-opacity"
					   aria-label="Instagram">
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
							<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
						</svg>
					</a>
					<a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
					   class="w-10 h-10 flex items-center justify-center hover:opacity-80 transition-opacity"
					   aria-label="YouTube">
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
							<path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
						</svg>
					</a>
					<a href="https://tiktok.com" target="_blank" rel="noopener noreferrer"
					   class="w-10 h-10 flex items-center justify-center hover:opacity-80 transition-opacity"
					   aria-label="TikTok">
						<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
							<path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
						</svg>
					</a>
				</div>
			</div>

			<!-- Mobile Menu -->
			<nav class="mb-8" aria-label="<?php esc_attr_e( 'Footer Menu', 'allmighty' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'footer-menu-mobile',
						'container'      => false,
						'menu_class'     => 'flex flex-col items-center gap-4 text-lg',
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>

			<!-- Logo -->
			<div class="flex justify-center mb-8">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="https://placehold.co/150x100/3a3a3a/ffffff?text=LOGO" alt="<?php bloginfo( 'name' ); ?>" class="h-20 w-auto">
				</a>
			</div>
		</div>
	</div>

	<!-- Bottom Bar -->
	<div class="bg-white py-6">
		<div class="container mx-auto px-4">
			<div class="flex flex-col lg:flex-row items-center justify-between gap-4 text-gray-600 text-sm">
				<!-- Copyright -->
				<div class="text-center lg:text-left">
					<p>Copyright © <?php echo esc_html( $current_year ); ?> Company</p>
					<p>All Rights Reserved</p>
				</div>

				<!-- Legal Links -->
				<div class="flex items-center gap-4">
					<a href="<?php echo esc_url( home_url( '/terms-and-conditions' ) ); ?>" class="hover:text-[#3a3a3a] transition-colors">
						Terms and Conditions
					</a>
					<span>|</span>
					<a href="<?php echo esc_url( home_url( '/privacy-policy' ) ); ?>" class="hover:text-[#3a3a3a] transition-colors">
						Privacy Policy
					</a>
				</div>
			</div>
		</div>
	</div>
</footer><!-- #colophon -->
