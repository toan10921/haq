<?php
$section_link    = $section_link['url'] ?? '#';
$category_list   = $category_list ?? [];
$style3_columns  = isset($style3_columns) ? intval($style3_columns) : 5; // mặc định 5 cột

if (empty($category_list)) return;
?>

<div class="t888-featured-categories-wrapper style3">
    <?php if (!empty($section_title)) : ?>
        <div class="t888-featured-header">
            <a class="view-all-link" href="<?php echo esc_url($section_link); ?>">
                <?php echo esc_html($section_title); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="t888-featured-grid-style3 columns-<?php echo esc_attr($style3_columns); ?>">
        <?php foreach ($category_list as $item):
            $image    = $item['category_image']['url'] ?? '';
            $term_id  = $item['category_select'] ?? '';
            $term     = get_term_by('id', $term_id, 'product_cat');

            if (!$term || is_wp_error($term)) {
                $link = '#';
                $count = 0;
                $name = esc_html__( 'Sample category', 'nebon' );

            } else {
                $link = get_term_link($term);
                $count = $term->count;
                $name = $term->name;
            }

        ?>
            <div class="t888-featured-box">
                <a href="<?php echo esc_url($link); ?>" class="t888-featured-link">
                    <div class="t888-featured-thumb-style3">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($name); ?>" />
                    </div>

                    <div class="t888-featured-info-style3">
                        <div class="t888-featured-title"><?php echo esc_html($name); ?></div>
                        <div class="t888-featured-count"><?php echo esc_html($count) . ' ' . esc_html__('Items', 'nebon'); ?></div>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>