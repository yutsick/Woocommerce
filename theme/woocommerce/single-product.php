<?php
/**
 * Single Product Body
 */
defined( 'ABSPATH' ) || exit;

get_header();

global $product;

if ( ! is_a( $product, 'WC_Product' ) ) {
	return;
}

$product_id = $product->get_id();
?>

<div class="single-product-container  min-h-screen">
    <section class="container mx-auto px-4 py-8 lg:py-12">
        <!-- Breadcrumbs -->
        <nav class="text-sm text-gray-400 mb-8">
            <a href="<?php echo esc_url( home_url('/') ); ?>" class="hover:text-black transition">Almighty Victory</a>
            <span class="mx-2">/</span>
            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="hover:text-black transition">Products</a>
            <span class="mx-2">/</span>
            <span class="text-gray-500"><?php the_title(); ?></span>
        </nav>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-16">
            
            <!-- Product Images -->
            <div class="w-full lg:w-1/2">
                <?php
                $attachment_ids = $product->get_gallery_image_ids();
                $main_image_id  = $product->get_image_id();
                ?>
                <div class="aspect-square bg-white rounded-xl overflow-hidden mb-4">
                    <?php echo wp_get_attachment_image( $main_image_id, 'full', false, array( 'class' => 'w-full h-full object-contain' ) ); ?>
                </div>
                <?php if ( $attachment_ids ) : ?>
                    <div class="grid grid-cols-3 gap-4">
                        <?php foreach ( $attachment_ids as $attachment_id ) : ?>
                            <div class="aspect-square bg-white rounded-xl overflow-hidden cursor-pointer hover:opacity-80 transition">
                                <?php echo wp_get_attachment_image( $attachment_id, 'medium', false, array( 'class' => 'w-full h-full object-cover' ) ); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="w-full lg:w-1/2 flex flex-col justify-start">
                <?php if ( $product->is_featured() || has_term( 'bestseller', 'product_tag', $product_id ) ) : ?>
                    <span class="inline-block bg-[#E5B94E] text-black px-4 py-2 text-xs font-bold rounded mb-6 uppercase tracking-wider w-fit">Bestseller</span>
                <?php endif; ?>

                <h1 class="text-4xl lg:text-5xl font-bold  mb-6"><?php the_title(); ?></h1>
                <p class="text-3xl lg:text-4xl font-light  mb-8"><?php echo $product->get_price_html(); ?></p>

                <!-- Custom Product Form -->
                <?php if ( $product->is_type( 'variable' ) ) : ?>
                    <form class="variations_form cart" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $product->get_available_variations() ) ) ?>">
                        
                        <?php 
                        $attributes = $product->get_variation_attributes();
                        
                        foreach ( $attributes as $attribute_name => $options ) :
                            $sanitized_name = sanitize_title( $attribute_name );
                            $attribute_label = wc_attribute_label( $attribute_name );
                        ?>
                            
                            <?php if ( strtolower( $attribute_label ) === 'color' ) : ?>
                                <!-- Color Selection -->
                                <div class="variation-selector mb-6">
                                    <label class="block text-xl font-semibold  mb-4">Color</label>
                                    <div class="flex gap-3" data-attribute="<?php echo esc_attr( $sanitized_name ); ?>">
                                        <?php foreach ( $options as $option ) : 
                                            $term = get_term_by( 'slug', $option, $attribute_name );
                                            $color_value = strtolower( $term ? $term->name : $option );
                                            $bg_color = $color_value === 'white' ? '#FFFFFF' : '#000000';
                                        ?>
                                            <button type="button" 
                                                    class="color-option w-16 h-16 rounded-full border-2 border-gray-600 hover:border-black transition cursor-pointer"
                                                    style="background-color: <?php echo esc_attr( $bg_color ); ?>;"
                                                    data-value="<?php echo esc_attr( $option ); ?>"
                                                    aria-label="<?php echo esc_attr( $color_value ); ?>">
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                    <select name="attribute_<?php echo esc_attr( $sanitized_name ); ?>" 
                                            id="attribute_<?php echo esc_attr( $sanitized_name ); ?>"
                                            class="hidden"
                                            data-attribute_name="attribute_<?php echo esc_attr( $sanitized_name ); ?>">
                                        <option value="">Choose an option</option>
                                        <?php foreach ( $options as $option ) : ?>
                                            <option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            
                            <?php elseif ( strtolower( $attribute_label ) === 'size' ) : ?>
                                <!-- Size Selection -->
                                <div class="variation-selector mb-6">
                                    <label class="block text-xl font-semibold e mb-4">Size</label>
                                    <div class="flex gap-3" data-attribute="<?php echo esc_attr( $sanitized_name ); ?>">
                                        <?php foreach ( $options as $option ) : ?>
                                            <button type="button" 
                                                    class="size-option bg-white text-black px-6 py-3 rounded-lg border-2  hover:bg-gray-100 transition cursor-pointer font-semibold text-lg min-w-[80px]"
                                                    data-value="<?php echo esc_attr( $option ); ?>">
                                                <?php echo esc_html( $option ); ?>
                                            </button>
                                        <?php endforeach; ?>
                                    </div>
                                    <select name="attribute_<?php echo esc_attr( $sanitized_name ); ?>" 
                                            id="attribute_<?php echo esc_attr( $sanitized_name ); ?>"
                                            class="hidden"
                                            data-attribute_name="attribute_<?php echo esc_attr( $sanitized_name ); ?>">
                                        <option value="">Choose an option</option>
                                        <?php foreach ( $options as $option ) : ?>
                                            <option value="<?php echo esc_attr( $option ); ?>"><?php echo esc_html( $option ); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            
                            <?php endif; ?>
                        
                        <?php endforeach; ?>
                        
                        <div class="single_variation_wrap mb-6">
                            <div class="woocommerce-variation single_variation"></div>
                            <div class="woocommerce-variation-add-to-cart variations_button">
                                <input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>">
                                <input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>">
                                <input type="hidden" name="variation_id" class="variation_id" value="0">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="single_add_to_cart_button bg-gray-300 text-black px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-500 transition disabled:opacity-50 disabled:cursor-not-allowed" disabled>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </form>
                
                <?php else : ?>
                    <!-- Simple Product -->
                    <form class="cart" method="post" enctype='multipart/form-data'>
                        <div class="flex items-center gap-4 mb-6">
                            <?php
                            woocommerce_quantity_input(
                                array(
                                    'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                    'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                    'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(),
                                )
                            );
                            ?>
                            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button  bg-gray-300 text-black px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-500 transition">
                                Add to cart
                            </button>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Description Section -->
    <section class="border-t border-gray-800 py-12 lg:py-20">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-24">
                <div>
                    <h2 class="text-2xl font-bold mb-6">Description</h2>
                    <div class="  max-w-none text-gray-600 leading-relaxed">
                        <?php the_content(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php
    $related_products = wc_get_related_products( $product_id, 4 );
    if ( $related_products ) :
    ?>
    <section class="related-section py-12 lg:py-20 border-t border-gray-800 overflow-hidden">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-bold mb-10">You may also like:</h2>
            
            <div class="swiper related-swiper overflow-visible lg:overflow-hidden">
                <div class="swiper-wrapper flex lg:grid lg:grid-cols-4 lg:gap-8">
                    <?php foreach ( $related_products as $related_id ) : 
                        $rel_product = wc_get_product( $related_id );
                    ?>
                        <div class="swiper-slide w-[80%] lg:w-full">
                            <a href="<?php echo get_permalink( $related_id ); ?>" class="group block text-center">
                                <div class="aspect-square bg-white rounded-xl overflow-hidden mb-4">
                                    <?php echo $rel_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-contain group-hover:scale-105 transition-transform duration-500' ) ); ?>
                                </div>
                                <h3 class=" font-medium group-hover:underline underline-offset-4">
                                    <?php echo get_the_title( $related_id ); ?>
                                </h3>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<style>
/* Hide Monobank */
[class*="monobank"], [id*="monobank"] {
    display: none !important;
}

/* Quantity input */
.single-product-container input.qty {
    background: #1a1a1a;
                        color: #333;
    border: 2px solid #333;
    padding: 1rem;
    border-radius: 0.5rem;
    width: 80px !important;
    text-align: center;
    font-weight: 600;
}

/* Color option active state */
.color-option.active {

    border-width: 3px;
}
button.active{
    border-width: 3px;
}

/* Hide variation availability message */
.woocommerce-variation-availability {
    display: none !important;
}

</style>

<script>
jQuery(function($) {
    var $form = $('.variations_form');

    // Initialize WooCommerce variations
    if ($form.length) {
        $form.wc_variation_form();
    }

    // Get variations data
    var variations = $form.data('product_variations');

    // Function to find matching variation
    function findMatchingVariation() {
        var selectedAttrs = {};
        $form.find('select').each(function() {
            var name = $(this).attr('name');
            var val = $(this).val();
            if (name && val) {
                selectedAttrs[name] = val;
            }
        });

        // Find matching variation
        for (var i = 0; i < variations.length; i++) {
            var variation = variations[i];
            var isMatch = true;

            for (var attrName in variation.attributes) {
                var attrVal = variation.attributes[attrName];
                var selectedVal = selectedAttrs[attrName] || '';

                // Empty means "any" - always matches
                if (attrVal !== '' && attrVal !== selectedVal) {
                    isMatch = false;
                    break;
                }
            }

            if (isMatch) {
                return variation;
            }
        }

        return null;
    }

    // Function to check if all options are selected
    function allOptionsSelected() {
        var allSelected = true;
        $form.find('select').each(function() {
            if (!$(this).val()) {
                allSelected = false;
                return false;
            }
        });
        return allSelected;
    }

    // Function to apply variation
    function applyVariation() {
        var variation = findMatchingVariation();
        var $button = $form.find('.single_add_to_cart_button');

        if (variation && allOptionsSelected()) {
            // Set variation_id
            $form.find('.variation_id').val(variation.variation_id);

            // Enable button
            $button.removeClass('disabled wc-variation-selection-needed');
            $button.removeAttr('disabled');
            $button.text('Add to cart');

            // Trigger WooCommerce event
            $form.trigger('found_variation', [variation]);
        } else {
            // Disable button
            $button.addClass('disabled wc-variation-selection-needed');
            $button.attr('disabled', 'disabled');

            $form.find('.variation_id').val(0);
        }
    }

    // Color selection
    $('.color-option').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $container = $this.closest('[data-attribute]');
        var attribute = $container.data('attribute');
        var value = $this.data('value');

        var $select = $form.find('select[name="attribute_' + attribute + '"]');

        // Remove active class from siblings
        $container.find('.color-option').removeClass('active');
        $this.addClass('active');

        // Update hidden select and trigger change for WooCommerce
        if ($select.length) {
            $select.val(value).trigger('change');
            applyVariation();
        }
    });

    // Size selection
    $('.size-option').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var $container = $this.closest('[data-attribute]');
        var attribute = $container.data('attribute');
        var value = $this.data('value');

        var $select = $form.find('select[name="attribute_' + attribute + '"]');

        // Remove active class from siblings
        $container.find('.size-option').removeClass('active');
        $this.addClass('active');

        // Update hidden select and trigger change for WooCommerce
        if ($select.length) {
            $select.val(value).trigger('change');
            applyVariation();
        }
    });

    // Listen for WooCommerce events
    $form.on('found_variation', function(event, variation) {
        $('.single_add_to_cart_button').removeClass('disabled').prop('disabled', false);
        $form.find('.variation_id').val(variation.variation_id);
    });

    $form.on('reset_data', function() {
        $('.single_add_to_cart_button').addClass('disabled').prop('disabled', true);
    });

    // Swiper for related products
    if (window.innerWidth < 1024 && typeof Swiper !== 'undefined') {
        new Swiper('.related-swiper', {
            slidesPerView: 1.2,
            spaceBetween: 20,
            centeredSlides: false,
        });
    }
});
</script>

<?php get_footer(); ?>