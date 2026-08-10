<?php
$tips = $tips_list;
?>

<div class="t888-tips-wrapper">
    <ul class="t888-tips-list">
        <?php foreach ($tips as $index => $tip): ?>
            <li class="t888-tip-item style-<?php echo esc_attr($number_style); ?>">
                <span class="tip-number"><?php echo esc_html( $index + 1 ); ?></span>
                <div class="tip-content">
                    <strong><?php echo esc_html($tip['tip_title']); ?></strong>
                    <?php echo esc_html($tip['tip_description']); ?>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
