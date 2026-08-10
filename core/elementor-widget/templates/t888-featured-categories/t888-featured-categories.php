<?php


$section_link  = $section_link['url'] ?? '#';

$categories = [];
for ($i = 1; $i <= 3; $i++) {
    $image = $data["category_{$i}_image"]['url'] ?? '';
    $hover = $data["category_{$i}_image_hover"]['url'] ?? '';
    $term_id = $data["category_{$i}_select"] ?? '';
    $term = get_term_by('id', $term_id, 'product_cat');
    if ($term && !is_wp_error($term)) {
        $link = get_term_link($term);
        $count = $term->count;
        $categories[] = [
            'image' => $image,
            'hover' => $hover,
            'name'  => $term->name,
            'count' => $count,
            'link'  => $link,
        ];
    }
}
?>

<div class="t888-featured-categories-wrapper">
    <?php if ($section_title): ?>
        <div class="t888-featured-header">
            <a class="view-all-link" href="<?php echo esc_url($section_link); ?>">
                <?php echo esc_html($section_title); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="t888-featured-grid">
        <?php foreach ($categories as $cat): ?>
            <div class="t888-featured-box">
                <a href="<?php echo esc_url($cat['link']); ?>" class="t888-featured-link">
                    <div class="t888-featured-thumb">
                        <img class="thumb-default" src="<?php echo esc_url($cat['image']); ?>" alt="<?php echo esc_attr($cat['name']); ?>" />
                    </div>

                    <div class="t888-featured-info">
                        <div class="t888-featured-title"><?php echo esc_html($cat['name']); ?></div>
                        <div class="t888-featured-count"><?php echo esc_html($cat['count']) . ' ' . esc_html__('Items', 'nebon'); ?></div>
                        
                    </div>
                    <div class="t888-featured-icon">
                            <i class="las la-angle-right"></i>
                        </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>