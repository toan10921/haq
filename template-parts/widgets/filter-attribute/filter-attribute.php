<?php
extract($data);
if (!defined('ABSPATH')) exit;

if (empty($attribute)) return;

$taxonomy = 'pa_' . $attribute;
$terms = get_terms([
    'taxonomy'   => $taxonomy,
    'hide_empty' => false,
]);

if (!empty($terms) && !is_wp_error($terms)) :
    $selected_taxonomies = [];
    foreach ($_GET as $key => $value) {
        if (strpos($key, 'pa_') === 0) {
            $selected_taxonomies[$key] = explode(',', sanitize_text_field($value));
        }
    }

    ?>

    <div class="custom-filter-attribute filter-<?php echo esc_attr($attribute); ?>">
        <h5 class="widget-title"><?php echo esc_html($title); ?></h5>
        <ul class="<?php echo esc_attr($attribute === 'color' ? 'filter-color-list' : 'filter-default-list'); ?>">
            <?php foreach ($terms as $term) :
                $term_slug = $term->slug;
                $selected_values = $selected_taxonomies[$taxonomy] ?? [];
                $is_selected = in_array($term_slug, $selected_values);

                $updated_values = $selected_values;
                if ($is_selected) {
                    $updated_values = array_diff($updated_values, [$term_slug]);
                } else {
                    $updated_values[] = $term_slug; 
                }

                $updated_taxonomies = $selected_taxonomies;
                if (!empty($updated_values)) {
                    $updated_taxonomies[$taxonomy] = $updated_values;
                } else {
                    unset($updated_taxonomies[$taxonomy]);
                }

                $query_args = [];
                foreach ($updated_taxonomies as $k => $v) {
                    $query_args[$k] = implode(',', array_unique($v));
                }

                $filter_url = add_query_arg($query_args, $current_url);
                ?>

                <li data-param_key="pa_<?php echo esc_attr($attribute); ?>" data-param_value="<?php echo esc_attr($term->slug); ?>" class="<?php echo esc_attr( $attribute === 'color' ? 'filter-color-item' : 'filter-default-item' ); ?> <?php echo esc_attr($is_selected ? 'selected' : ''); ?>">
                    <a href="<?php echo esc_url($filter_url); ?>" 
                       <?php if ($attribute === 'color') : ?>
                            class="color-swatch"
                            style="background-color: <?php echo esc_attr(get_term_meta($term->term_id, 'color', true) ?: '#cccccc'); ?>"
                       <?php endif; ?>>
                        <?php if ($attribute !== 'color') : ?>
                            <?php echo esc_html($term->name); ?>
                            <span>(<?php echo esc_html($term->count); ?>)</span>
                        <?php else : ?>
                            <?php if ($is_selected) : ?>
                                <i class="las la-angle-up icon-selected"></i>
                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </li>

            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
