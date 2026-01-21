<?php
/**
 * Template part for displaying the header content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package allmighty
 */

$current_lang = allmighty_get_current_language();
$cart_count   = WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
?>

<header id="masthead" class="bg-[#3a3a3a] sticky top-0 z-50">
	<!-- Desktop Header -->
	<div class="hidden lg:block">
		<div class="container mx-auto px-4">
			<div class="flex items-center justify-between py-4">
				<!-- Left: Navigation Menu -->
				<nav class="flex-1" aria-label="<?php esc_attr_e( 'Main Navigation', 'allmighty' ); ?>">
					<?php
					wp_nav_menu(
						array(
							'theme_location' => 'menu-1',
							'menu_id'        => 'primary-menu',
							'container'      => false,
							'menu_class'     => 'flex items-center space-x-8',
							'fallback_cb'    => false,
						)
					);
					?>
				</nav>

				<!-- Center: Logo -->
				<div class="flex-shrink-0 mx-8">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block" rel="home">
						<img src="https://placehold.co/120x80/3a3a3a/ffffff?text=LOGO" alt="<?php bloginfo( 'name' ); ?>" class="h-16 w-auto">
					</a>
				</div>

				<!-- Right: Language, Cart, Phone -->
				<div class="flex-1 flex items-center justify-end space-x-4">
					<!-- Language Switcher -->
					<div class="flex items-center bg-[#4a4a4a] rounded-lg">
						<a href="<?php echo esc_url( allmighty_get_language_url( 'en' ) ); ?>"
						   class="px-4 py-2 text-sm font-medium <?php echo 'en' === $current_lang ? 'bg-white text-[#3a3a3a]' : 'text-white'; ?> rounded-lg transition-colors">
							EN
						</a>
						<a href="<?php echo esc_url( allmighty_get_language_url( 'uk' ) ); ?>"
						   class="px-4 py-2 text-sm font-medium <?php echo 'uk' === $current_lang ? 'bg-white text-[#3a3a3a]' : 'text-white'; ?> rounded-lg transition-colors">
							UA
						</a>
					</div>

					<!-- Cart Icon -->
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative p-3 bg-[#4a4a4a] rounded-lg hover:bg-[#5a5a5a] transition-colors">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
						</svg>
						<?php if ( $cart_count > 0 ) : ?>
							<span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
								<?php echo esc_html( $cart_count ); ?>
							</span>
						<?php endif; ?>
					</a>

					<!-- Phone Icon -->
					<a href="tel:+1234567890" class="p-3 bg-[#4a4a4a] rounded-lg hover:bg-[#5a5a5a] transition-colors">
						<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</div>

	<!-- Mobile Header -->
	<div class="lg:hidden">
		<div class="container mx-auto px-4">
			<div class="flex items-center justify-between py-4">
				<!-- Mobile Menu Toggle -->
				<button id="mobile-menu-toggle" class="p-3 bg-[#4a4a4a] rounded-lg hover:bg-[#5a5a5a] transition-colors" aria-label="<?php esc_attr_e( 'Toggle menu', 'allmighty' ); ?>">
					<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
					</svg>
				</button>

				<!-- Logo -->
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="block" rel="home">
					<img src="https://placehold.co/100x60/3a3a3a/ffffff?text=LOGO" alt="<?php bloginfo( 'name' ); ?>" class="h-12 w-auto">
				</a>

				<!-- Cart Icon -->
				<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="relative p-3 bg-[#4a4a4a] rounded-lg hover:bg-[#5a5a5a] transition-colors">
					<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
					</svg>
					<?php if ( $cart_count > 0 ) : ?>
						<span class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">
							<?php echo esc_html( $cart_count ); ?>
						</span>
					<?php endif; ?>
				</a>
			</div>
		</div>
	</div>

	<!-- Mobile Menu Overlay -->
	<div id="mobile-menu" class="fixed inset-0 bg-[#3a3a3a] z-50 hidden lg:hidden overflow-y-auto">
		<div class="min-h-full flex flex-col">
			<!-- Logo at top -->
			<div class="flex items-center justify-center py-8 border-b border-[#4a4a4a]">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img src="https://placehold.co/120x80/3a3a3a/ffffff?text=LOGO" alt="<?php bloginfo( 'name' ); ?>" class="h-16 w-auto">
				</a>
			</div>

			<!-- Menu Items -->
			<nav class="flex-1 flex flex-col items-center justify-center space-y-8 py-8">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'container'      => false,
						'menu_class'     => 'flex flex-col items-center space-y-8 text-center',
						'fallback_cb'    => false,
					)
				);
				?>
			</nav>

			<!-- Bottom Section: Language & Phone -->
			<div class="py-8 space-y-4 border-t border-[#4a4a4a]">
				<!-- Language Switcher -->
				<div class="flex items-center justify-center space-x-0">
					<a href="<?php echo esc_url( allmighty_get_language_url( 'en' ) ); ?>"
					   class="px-6 py-3 text-lg font-medium <?php echo 'en' === $current_lang ? 'bg-white text-[#3a3a3a]' : 'text-white bg-[#4a4a4a]'; ?> rounded-l-lg transition-colors">
						EN
					</a>
					<a href="<?php echo esc_url( allmighty_get_language_url( 'uk' ) ); ?>"
					   class="px-6 py-3 text-lg font-medium <?php echo 'uk' === $current_lang ? 'bg-white text-[#3a3a3a]' : 'text-white bg-[#4a4a4a]'; ?> rounded-r-lg transition-colors">
						UA
					</a>
				</div>

				<!-- Phone Button -->
				<div class="flex justify-center px-4">
					<a href="tel:+1234567890" class="flex items-center space-x-3 bg-white text-[#3a3a3a] px-8 py-4 rounded-xl font-medium text-lg hover:bg-gray-100 transition-colors">
						<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
						</svg>
						<span>(123) 456 - 789</span>
					</a>
				</div>
			</div>
		</div>
	</div>
</header><!-- #masthead -->
