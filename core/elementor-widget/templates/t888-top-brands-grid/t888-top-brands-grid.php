<?php
$brands = !empty($brands) && is_array($brands) ? $brands : [];
?>

<div class="t888-top-brands-grid">
    <?php if (!empty($title)) : ?>
        <div class="t888-top-brands-grid__header">
            <h3 class="t888-top-brands-grid__title"><?php echo esc_html($title); ?></h3>
        </div>
    <?php endif; ?>

    <?php if (!empty($brands)) : ?>
        <div class="t888-top-brands-grid__grid">
            <?php foreach ($brands as $brand) : ?>
                <?php
                $logo_url = !empty($brand['brand_logo']['url']) ? $brand['brand_logo']['url'] : '';
                $brand_name = !empty($brand['brand_name']) ? $brand['brand_name'] : __('Brand', 'nebon');
                $brand_link = !empty($brand['brand_link']['url']) ? $brand['brand_link']['url'] : '';
                $target = !empty($brand['brand_link']['is_external']) ? ' target="_blank"' : '';
                $nofollow = !empty($brand['brand_link']['nofollow']) ? ' rel="nofollow"' : '';

                if (!$logo_url) {
                    continue;
                }
                ?>
                <div class="t888-top-brands-grid__item">
                    <?php if ($brand_link) : ?>
                        <a class="t888-top-brands-grid__item-inner t888-top-brands-grid__logo" href="<?php echo esc_url($brand_link); ?>"<?php echo $target . $nofollow; ?>>
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($brand_name); ?>">
                        </a>
                    <?php else : ?>
                        <div class="t888-top-brands-grid__item-inner t888-top-brands-grid__logo">
                            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($brand_name); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
