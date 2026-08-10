<?php
if (!defined('ABSPATH')) exit;

$title = $title ?? '';
$icons = $icons ?? [];
?>

<div class="social-footer style2">
    <?php if (!empty($title)) : ?>
        <span class="social-footer-title"><?php echo esc_html($title); ?></span>
    <?php endif; ?>

    <ul class="social-list-icon list-none">
        <?php if (!empty($icons) && is_array($icons)) : ?>
            <?php foreach ($icons as $icon) : ?>
                <?php
                $url         = $icon['link']['url'] ?? '#';
                $is_external = !empty($icon['link']['is_external']);
                $nofollow    = !empty($icon['link']['nofollow']) ? 'rel="nofollow noopener noreferrer"' : 'rel="noopener noreferrer"';
                $target      = $is_external ? 'target="_blank"' : '';
                $icon_class  = $icon['icon']['value'] ?? '';
                ?>
                <li class="social-item">
                    <a 
                        href="<?php echo esc_url($url); ?>" 
                        class="social-link"
                        <?php echo esc_attr($target . ' ' . $nofollow); ?>
                    >
                        <i class="<?php echo esc_attr($icon_class); ?>"></i>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>
