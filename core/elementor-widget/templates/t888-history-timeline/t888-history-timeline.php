<?php
$items = $timeline_items ?? [];
?>

<div class="t888-history-wrapper">
    <?php if (!empty($heading)) : ?>
        <div class="t888-history-title"><?php echo esc_html($heading); ?></div>
    <?php endif; ?>

    <?php if (!empty($intro_text)) : ?>
        <div class="t888-history-intro">
            <?php echo nl2br(esc_html($intro_text)); ?>
        </div>
    <?php endif; ?>

    <?php foreach ($items as $item) : ?>
        <div class="t888-timeline-item">
            <div class="t888-timeline-year"><?php echo esc_html($item['year']); ?></div>
            <div class="t888-timeline-content">
                <h3 class="t888-timeline-title"><?php echo esc_html($item['title']); ?></h3>
                <div class="t888-timeline-description"><?php echo nl2br(esc_html($item['description'])); ?></div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
