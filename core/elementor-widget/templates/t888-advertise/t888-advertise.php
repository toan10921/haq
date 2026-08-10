<?php if (!empty($heading)) : ?>
    <span class="t888-advertise-title"><?php echo esc_html($heading); ?></span>
<?php endif; ?>

<div class="t888-advertise-grid">
    <?php foreach ($items as $item) : ?>
        <div class="t888-advertise-item box-hero">
            <a href="<?php echo esc_url($item['link']['url']); ?>"
               <?php echo esc_attr(isset($item['link']['is_external']) ? 'target="_blank"' : ''); ?>
               <?php echo esc_attr(isset($item['link']['nofollow']) ? 'rel="nofollow"' : ''); ?>>
                <img src="<?php echo esc_url($item['image']['url']); ?>" alt="<?php echo esc_attr( !empty($heading) ?  $heading  :  __('Advertise Image', 'nebon') ); ?>">
            </a>
        </div>
    <?php endforeach; ?>
</div>
