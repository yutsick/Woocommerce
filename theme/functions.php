<?php
/**
 * allmighty functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package allmighty
 */

if ( ! defined( 'ALLMIGHTY_VERSION' ) ) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define( 'ALLMIGHTY_VERSION', '0.1.0' );
}

if ( ! defined( 'ALLMIGHTY_TYPOGRAPHY_CLASSES' ) ) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `allmighty_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'ALLMIGHTY_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if ( ! function_exists( 'allmighty_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function allmighty_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on allmighty, use a find and replace
		 * to change 'allmighty' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'allmighty', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __( 'Primary', 'allmighty' ),
				'menu-2' => __( 'Footer Menu', 'allmighty' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( 'style-editor.css' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true, 
        'flex-width'  => true,  
        'header-text' => array( 'site-title', 'site-description' ),
    ) );

		// Remove support for block templates.
		remove_theme_support( 'block-templates' );
	}
endif;
add_action( 'after_setup_theme', 'allmighty_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function allmighty_widgets_init() {
	register_sidebar(
		array(
			'name'          => __( 'Footer', 'allmighty' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your footer.', 'allmighty' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'allmighty_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function allmighty_scripts() {
	// Swiper CSS
	wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css', array(), '12.0.0' );

	// Theme styles
	wp_enqueue_style( 'allmighty-style', get_stylesheet_uri(), array( 'swiper' ), ALLMIGHTY_VERSION );

	// Theme scripts
	wp_enqueue_script( 'allmighty-script', get_template_directory_uri() . '/js/script.min.js', array(), ALLMIGHTY_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'allmighty_scripts' );

/**
 * Enqueue the block editor script.
 */
function allmighty_enqueue_block_editor_script() {
	$current_screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'allmighty-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			ALLMIGHTY_VERSION,
			true
		);
		wp_add_inline_script( 'allmighty-editor', "tailwindTypographyClasses = '" . esc_attr( ALLMIGHTY_TYPOGRAPHY_CLASSES ) . "'.split(' ');", 'before' );
	}
}
add_action( 'enqueue_block_assets', 'allmighty_enqueue_block_editor_script' );

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function allmighty_tinymce_add_class( $settings ) {
	$settings['body_class'] = ALLMIGHTY_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter( 'tiny_mce_before_init', 'allmighty_tinymce_add_class' );

/**
 * Limit the block editor to heading levels supported by Tailwind Typography.
 *
 * @param array  $args Array of arguments for registering a block type.
 * @param string $block_type Block type name including namespace.
 * @return array
 */
function allmighty_modify_heading_levels( $args, $block_type ) {
	if ( 'core/heading' !== $block_type ) {
		return $args;
	}

	// Remove <h1>, <h5> and <h6>.
	$args['attributes']['levelOptions']['default'] = array( 2, 3, 4 );

	return $args;
}
add_filter( 'register_block_type_args', 'allmighty_modify_heading_levels', 10, 2 );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * AJAX Shop Handler for products catalog.
 */
require get_template_directory() . '/inc/ajax-shop-handler.php';

/**
 * Add WooCommerce support.
 */
function allmighty_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'allmighty_add_woocommerce_support' );

/**
 * Use custom template for WooCommerce shop page.
 *
 * @param string $template The template path.
 * @return string
 */
function allmighty_custom_shop_template( $template ) {
	if ( is_shop() || is_product_category() ) {
		$custom_template = get_template_directory() . '/page-shop.php';
		if ( file_exists( $custom_template ) ) {
			return $custom_template;
		}
	}
	return $template;
}
add_filter( 'template_include', 'allmighty_custom_shop_template', 99 );

/**
 * Helper function to render ACF flexible content blocks.
 *
 * @param string $field_name The ACF flexible content field name.
 */
function allmighty_render_blocks( $field_name = 'content_blocks' ) {
	if ( ! function_exists( 'have_rows' ) ) {
		return;
	}

	if ( have_rows( $field_name ) ) :
		while ( have_rows( $field_name ) ) :
			the_row();
			$layout = get_row_layout();
			$template_file = get_template_directory() . '/template-parts/blocks/' . $layout . '.php';

			if ( file_exists( $template_file ) ) {
				include $template_file;
			}
		endwhile;
	endif;
}

/**
 * Get current language code (WPML/Polylang compatible).
 *
 * @return string Language code (e.g., 'en', 'uk').
 */
function allmighty_get_current_language() {
	// WPML support
	if ( function_exists( 'icl_get_current_language' ) ) {
		return icl_get_current_language();
	}

	// Polylang support
	if ( function_exists( 'pll_current_language' ) ) {
		return pll_current_language();
	}

	// Default to site language
	return substr( get_locale(), 0, 2 );
}

/**
 * Get language switcher URL (WPML/Polylang compatible).
 *
 * @param string $lang_code Language code to switch to.
 * @return string|false URL or false if not available.
 */
function allmighty_get_language_url( $lang_code ) {
	// WPML support
	if ( function_exists( 'icl_get_home_url' ) ) {
		return icl_get_home_url() . '/' . $lang_code . '/';
	}

	// Polylang support
	if ( function_exists( 'pll_home_url' ) ) {
		return pll_home_url( $lang_code );
	}

	return false;
}

/**
 * WooCommerce: Modify product query for custom filters.
 *
 * @param WP_Query $query The main query.
 */
function allmighty_filter_products_query( $query ) {
	if ( ! is_admin() && $query->is_main_query() && ( is_shop() || is_product_category() ) ) {
		$tax_query = $query->get( 'tax_query' ) ?: array();

		// Filter by product categories (custom filter, not the default product_cat)
		if ( ! empty( $_GET['product_categories'] ) ) {
			$categories = array_map( 'sanitize_text_field', (array) $_GET['product_categories'] );
			$tax_query[] = array(
				'taxonomy' => 'product_cat',
				'field'    => 'slug',
				'terms'    => $categories,
				'operator' => 'IN',
			);
		}

		// Filter by size attribute
		if ( ! empty( $_GET['filter_size'] ) ) {
			$sizes = array_map( 'sanitize_text_field', (array) $_GET['filter_size'] );
			$tax_query[] = array(
				'taxonomy' => 'pa_size',
				'field'    => 'slug',
				'terms'    => $sizes,
				'operator' => 'IN',
			);
		}

		// Filter by color attribute
		if ( ! empty( $_GET['filter_color'] ) ) {
			$colors = array_map( 'sanitize_text_field', (array) $_GET['filter_color'] );
			$tax_query[] = array(
				'taxonomy' => 'pa_color',
				'field'    => 'slug',
				'terms'    => $colors,
				'operator' => 'IN',
			);
		}

		if ( ! empty( $tax_query ) ) {
			$tax_query['relation'] = 'AND';
			$query->set( 'tax_query', $tax_query );
		}
	}
}
add_action( 'pre_get_posts', 'allmighty_filter_products_query' );

/**
 * WooCommerce: Set products per page.
 *
 * @param int $cols Number of products per page.
 * @return int
 */
function allmighty_products_per_page( $cols ) {
	return 12;
}
add_filter( 'loop_shop_per_page', 'allmighty_products_per_page' );

/**
 * Yoast SEO: Custom breadcrumb separator.
 *
 * @param string $separator The separator.
 * @return string
 */
function allmighty_yoast_breadcrumb_separator( $separator ) {
	return ' / ';
}
add_filter( 'wpseo_breadcrumb_separator', 'allmighty_yoast_breadcrumb_separator' );

/**
 * ACF: Add options page for shop settings.
 */
function allmighty_acf_options_page() {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title' => __( 'Shop Settings', 'allmighty' ),
			'menu_title' => __( 'Shop Settings', 'allmighty' ),
			'menu_slug'  => 'shop-settings',
			'capability' => 'edit_posts',
			'redirect'   => false,
			'icon_url'   => 'dashicons-cart',
			'position'   => 30,
		) );
	}
}
add_action( 'acf/init', 'allmighty_acf_options_page' );

/**
 * Fix product_cat array issue: WordPress expects a string, not an array.
 * This handles URLs with product_cat[] from old filter forms.
 *
 * @param array $query_vars The query variables.
 * @return array
 */
function allmighty_fix_product_cat_array( $query_vars ) {
	if ( isset( $query_vars['product_cat'] ) && is_array( $query_vars['product_cat'] ) ) {
		// Remove array value to prevent fatal error
		unset( $query_vars['product_cat'] );
	}
	return $query_vars;
}
add_filter( 'request', 'allmighty_fix_product_cat_array', 1 );

/**
 * Enqueue checkout scripts with AJAX data.
 */
function allmighty_checkout_scripts() {
	if ( is_checkout() ) {
		wp_localize_script( 'allmighty-script', 'allmightyAjax', array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'allmighty_checkout_nonce' ),
		) );
	}
}
add_action( 'wp_enqueue_scripts', 'allmighty_checkout_scripts', 20 );

/**
 * AJAX: Update cart item quantity.
 */
function allmighty_update_cart_item() {
	check_ajax_referer( 'allmighty_checkout_nonce', 'nonce' );

	$cart_item_key = isset( $_POST['cart_item_key'] ) ? sanitize_text_field( $_POST['cart_item_key'] ) : '';
	$quantity      = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 0;

	if ( empty( $cart_item_key ) ) {
		wp_send_json_error( array( 'message' => __( 'Invalid cart item.', 'allmighty' ) ) );
	}

	if ( $quantity === 0 ) {
		// Remove item
		WC()->cart->remove_cart_item( $cart_item_key );
	} else {
		// Update quantity
		WC()->cart->set_quantity( $cart_item_key, $quantity );
	}

	// Recalculate totals
	WC()->cart->calculate_totals();

	wp_send_json_success( array(
		'total'      => WC()->cart->get_total(),
		'cart_empty' => WC()->cart->is_empty(),
		'shop_url'   => wc_get_page_permalink( 'shop' ),
	) );
}
add_action( 'wp_ajax_allmighty_update_cart_item', 'allmighty_update_cart_item' );
add_action( 'wp_ajax_nopriv_allmighty_update_cart_item', 'allmighty_update_cart_item' );

/**
 * Custom checkout field processing.
 */
function allmighty_checkout_process() {
	// Validate required fields
	if ( empty( $_POST['billing_name'] ) ) {
		wc_add_notice( __( 'Please enter your full name.', 'allmighty' ), 'error' );
	}

	if ( empty( $_POST['billing_phone'] ) ) {
		wc_add_notice( __( 'Please enter your phone number.', 'allmighty' ), 'error' );
	}

	if ( empty( $_POST['shipping_city'] ) ) {
		wc_add_notice( __( 'Please enter your delivery city.', 'allmighty' ), 'error' );
	}

	if ( empty( $_POST['shipping_address'] ) ) {
		wc_add_notice( __( 'Please enter your delivery address.', 'allmighty' ), 'error' );
	}

	if ( empty( $_POST['privacy_agreement'] ) ) {
		wc_add_notice( __( 'Please agree to the personal data processing.', 'allmighty' ), 'error' );
	}
}
add_action( 'woocommerce_checkout_process', 'allmighty_checkout_process' );

/**
 * Save custom checkout fields to order.
 *
 * @param int $order_id The order ID.
 */
function allmighty_checkout_update_order_meta( $order_id ) {
	$order = wc_get_order( $order_id );

	if ( ! empty( $_POST['billing_name'] ) ) {
		$order->update_meta_data( '_billing_full_name', sanitize_text_field( $_POST['billing_name'] ) );
		// Split name for WooCommerce compatibility
		$name_parts = explode( ' ', sanitize_text_field( $_POST['billing_name'] ), 2 );
		$order->set_billing_first_name( $name_parts[0] );
		$order->set_billing_last_name( isset( $name_parts[1] ) ? $name_parts[1] : '' );
	}

	if ( ! empty( $_POST['billing_phone'] ) ) {
		$order->set_billing_phone( sanitize_text_field( $_POST['billing_phone'] ) );
	}

	if ( ! empty( $_POST['billing_email'] ) ) {
		$order->set_billing_email( sanitize_email( $_POST['billing_email'] ) );
	}

	if ( ! empty( $_POST['shipping_city'] ) ) {
		$order->set_shipping_city( sanitize_text_field( $_POST['shipping_city'] ) );
		$order->set_billing_city( sanitize_text_field( $_POST['shipping_city'] ) );
	}

	if ( ! empty( $_POST['shipping_method'] ) ) {
		$order->update_meta_data( '_shipping_method_custom', sanitize_text_field( $_POST['shipping_method'] ) );
	}

	if ( ! empty( $_POST['shipping_address'] ) ) {
		$order->set_shipping_address_1( sanitize_text_field( $_POST['shipping_address'] ) );
		$order->set_billing_address_1( sanitize_text_field( $_POST['shipping_address'] ) );
	}

	if ( ! empty( $_POST['no_callback'] ) ) {
		$order->update_meta_data( '_no_callback', 'yes' );
	}

	$order->save();
}
add_action( 'woocommerce_checkout_update_order_meta', 'allmighty_checkout_update_order_meta' );

/**
 * Redirect to Monobank payment if online payment selected.
 *
 * @param int    $order_id The order ID.
 * @param array  $posted_data Posted data.
 * @param object $order The order object.
 */
function allmighty_process_monobank_payment( $order_id, $posted_data, $order ) {
	$payment_method = isset( $_POST['payment_method'] ) ? sanitize_text_field( $_POST['payment_method'] ) : '';

	if ( $payment_method === 'online' ) {
		// Set payment method to Monobank if available
		if ( class_exists( 'WC_Gateway_Monobank' ) || in_array( 'monobank', array_keys( WC()->payment_gateways()->get_available_payment_gateways() ) ) ) {
			$order->set_payment_method( 'monobank' );
			$order->save();
		}
	}
}
add_action( 'woocommerce_checkout_order_processed', 'allmighty_process_monobank_payment', 10, 3 );
