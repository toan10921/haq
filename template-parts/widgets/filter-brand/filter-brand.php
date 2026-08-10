<?php
extract($data);
if (!defined('ABSPATH')) exit;

$brands = get_terms(array(
    'taxonomy'   => 'product_brand',  
    'hide_empty' => false, 
));

$current_brands = isset($_GET['brand']) ? explode(',', sanitize_text_field($_GET['brand'])) : [];
?>
<div class="custom-brand-filter">
    <h5 class="widget-title"><?php echo esc_html($title); ?></h5>
    <ul class="brand-list">
        <?php if (!empty($brands) && !is_wp_error($brands)) : ?>
            <?php foreach ($brands as $brand) :
                $select_brand = array_merge($current_brands, [$brand->slug]);
                ?>
                <li>
                    <label>
                    <input type="checkbox" class="brand-filter-checkbox" value="<?php echo esc_attr($brand->slug); ?>"
                            <?php echo in_array($brand->slug, $current_brands) ? 'checked' : ''; ?>>

                        <a href="<?php echo esc_url(add_query_arg('brand', implode(',', $select_brand), $current_url)); ?>" class="brand-name-link">
                            <?php echo esc_html($brand->name); ?> <span>(<?php echo esc_html($brand->count); ?>)</span>
                        </a>
                    </label>
                </li>
            <?php endforeach; ?>
        <?php else : ?>
            <p><?php esc_html_e('No brands found', 'nebon'); ?></p>
        <?php endif; ?>
    </ul>
</div>
