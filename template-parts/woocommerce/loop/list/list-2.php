<?php
$product = wc_get_product(get_the_ID());
$attachment_id = $product->get_image_id();
$size = 'product-list-default';

$product_id = $product->get_id();
$product_post_date = get_the_date('Y-m-d', $product->get_id());
$new_days = absint(get_theme_mod('product_new_in_days_general', 30));
$is_new = (strtotime($product_post_date) >= strtotime("-{$new_days} days"));
$is_hot = $product->is_featured();
$product_price = $product->get_price();
$has_price = !empty($product_price);
$hover_image_ids = get_post_meta(get_the_ID(), 'product_thumnail_hover', true);
$animation_class = get_theme_mod('thumbnail_animation_general', '');
?>

<div class="list-product-item style2">
    <div class="product-thumbnail <?php echo esc_attr($animation_class); ?>">
        <a href="<?php the_permalink(); ?>" class="product-link">
            <?php
            if ($attachment_id) {
                echo wp_get_attachment_image($attachment_id, $size, false, array(
                    'class' => 'primary-img',
                    'alt' => get_the_title()
                ));
            } else {
                $default_image = get_template_directory_uri() . '/assets/images/328x480.png';
                echo '<img class="primary-img" src="' . esc_url($default_image) . '" alt="' . esc_attr(get_the_title()) . '">';
            }
            ?>
            <?php
            if (!empty($hover_image_ids)) {
                echo wp_get_attachment_image($hover_image_ids, $size, false, array(
                    'class' => 'hover-img',
                    'alt' => get_the_title()
                ));
            } else {
                $default_image = get_template_directory_uri() . '/assets/images/328x480.png';
                echo '<img class="hover-img" src="' . esc_url($default_image) . '" alt="' . esc_attr(get_the_title()) . '">';
            }
            ?>
        </a>

        <?php t888f_get_template('woocommerce/product-structure/product-badge-list', 'list', array(
            'is_new' => $is_new,
            'is_hot' => $is_hot,
            'product' => $product
        ), true); ?>
    </div>

    <div class="product-details">
        <h6 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h6>
        <div class="product-price">
            <?php
            if ($product->is_type('grouped')) {
                $child_products = $product->get_children();
                $prices = [];
                foreach ($child_products as $child_id) {
                    $child_product = wc_get_product($child_id);
                    if ($child_product) {
                        $prices[] = floatval($child_product->get_price());
                    }
                }
                if (!empty($prices)) {
                    $min_price = min($prices);
                    $max_price = max($prices);

                    if ($min_price == $max_price) {
                        $display_price = wc_price($min_price);
                    } else {
                        $display_price = wc_price($min_price) . ' - ' . wc_price($max_price);
                    }
                } else {
                    $display_price = __('Contact for price', 'nebon');
                }

                echo '<span class="grouped-product-price">' . $display_price . '</span>';
            } elseif ($product->is_type('variable')) {
                $available_variations = $product->get_available_variations();
                $variation_prices = [];

                foreach ($available_variations as $variation) {
                    $variation_obj = wc_get_product($variation['variation_id']);
                    if ($variation_obj && $variation_obj->get_price() !== '') {
                        $variation_prices[] = floatval($variation_obj->get_price());
                    }
                }

                if (!empty($variation_prices)) {
                    $min_price = min($variation_prices);
                    $max_price = max($variation_prices);

                    if ($min_price == $max_price) {
                        echo '<span class="variable-product-price">' . wc_price($min_price) . '</span>';
                    } else {
                        echo '<span class="variable-product-price">' . wc_price($min_price) . ' - ' . wc_price($max_price) . '</span>';
                    }
                } else {
                    echo '<span class="contact-price">' . esc_html__('Contact', 'nebon') . '</span>';
                }
            } else {
                if ($has_price):
                    if ($product->is_on_sale()):
            ?>
                        <span class="regular-price" style="text-decoration: line-through; opacity: 0.6;">
                            <?php echo wc_price($product->get_regular_price()); ?>
                        </span>
                        <span class="sale-price"><?php echo wc_price($product->get_sale_price()); ?></span>
                    <?php
                    else:
                        echo wc_price($product_price);
                    endif;
                else:
                    ?>
                    <span class="contact-price"><?php esc_html_e('Contact', 'nebon'); ?></span>
            <?php endif;
            }
            ?>
        </div>
        <?php if ($product->is_type('variable')): ?>
            <?php
            $available_variations = $product->get_available_variations();
            $variations_json = wp_json_encode($available_variations);
            $variation_attributes = $product->get_attributes();
            ?>
            <div class="variations_form from-cart loop-product-variations"
                data-product_id="<?php echo esc_attr($product->get_id()); ?>"
                data-product_variations='<?php echo esc_attr($variations_json); ?>'>

                <?php foreach ($variation_attributes as $attribute_name => $attribute): ?>
                    <?php
                    if (!$attribute->get_variation()) continue;

                    $taxonomy = wc_sanitize_taxonomy_name($attribute_name);
                    $all_terms = wc_get_product_terms($product->get_id(), $taxonomy, ['fields' => 'all']);

                    $used_slugs = [];
                    foreach ($available_variations as $variation) {
                        $key = 'attribute_' . $taxonomy;
                        if (!empty($variation['attributes'][$key])) {
                            $used_slugs[] = $variation['attributes'][$key];
                        }
                    }
                    $used_slugs = array_unique($used_slugs);

                    if (empty($used_slugs)) continue;

                    $terms = array_filter($all_terms, function ($term) use ($used_slugs) {
                        return in_array($term->slug, $used_slugs);
                    });

                    $default = $product->get_variation_default_attribute($attribute_name);
                    $attr_label = wc_attribute_label($attribute_name);
                    ?>

                    <div class="detail-attr attr-<?php echo esc_attr($taxonomy); ?>">
                        <select name="attribute_<?php echo esc_attr($taxonomy); ?>" data-attribute_name="attribute_<?php echo esc_attr($taxonomy); ?>" style="display:none;">
                            <option value=""><?php echo esc_html__('Select', 'nebon'); ?></option>
                            <?php foreach ($terms as $term): ?>
                                <option value="<?php echo esc_attr($term->slug); ?>" <?php selected($default, $term->slug); ?>>
                                    <?php echo esc_html(apply_filters('woocommerce_variation_option_name', $term->name)); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="variation-buttons">
                            <?php foreach ($terms as $term):
                                $slug = $term->slug;
                                $is_color = $taxonomy === 'pa_color';
                                $color = $is_color ? get_term_meta($term->term_id, 'color', true) : '';
                                $selected_class = $slug === $default ? ' selected' : '';
                            ?>
                                <?php if ($is_color && $color): ?>
                                    <div class="variation-color-item">
                                        <button type="button"
                                            class="variation-button color-swatch<?php echo esc_attr($selected_class); ?>"
                                            data-value="<?php echo esc_attr($slug); ?>"
                                            title="<?php echo esc_attr($term->name); ?>"
                                            style="background-color: <?php echo esc_attr($color); ?>;">
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <button type="button"
                                        class="variation-button btn-variation<?php echo esc_attr($selected_class); ?>"
                                        data-value="<?php echo esc_attr($slug); ?>"
                                        title="<?php echo esc_attr($term->name); ?>">
                                        <?php echo esc_html($term->name); ?>
                                    </button>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="variation-price-display" id="price-display-<?php echo esc_attr($product->get_id()); ?>"></div>
            </div>
        <?php endif; ?>


        <div class="product-meta">
            <span class="product-rating">
                <?php
                $rating = $product->get_average_rating();
                $rating_html = wc_get_rating_html($rating, 5);

                if (!$rating_html) {
                    $rating_html = '<div class="star-rating" role="img" aria-label="Rated 0 out of 5">
        <span style="width:0%">0</span>
    </div>';
                }

                echo wp_kses_post($rating_html);
                ?>

            </span>
        </div>
        <div class="product-description">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </div>
        <div class="product-actions">
            <?php if ($has_price): ?>
                <?php woocommerce_template_loop_add_to_cart(); ?>
            <?php endif; ?>
            <?php t888f_get_template('woocommerce/product-structure/product-wishlist-compare', 'list', array(), true); ?>
        </div>
    </div>
</div>