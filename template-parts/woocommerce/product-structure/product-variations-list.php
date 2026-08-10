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