<?php
/**
 * Template for Footer Links Group Widget (Multi-column)
 */
?>

<div class="footer-links-group">
    <?php for ($i = 1; $i <= 3; $i++):
    $title_key = 'title' . $i;
    $links_key = 'links' . $i;
    $title = isset($$title_key) ? $$title_key : '';
    $links = isset($$links_key) ? $$links_key : [];
    if (!empty($title) || !empty($links)): ?>
            <div class="footer-links-column">
                <?php if (!empty($title)): ?>
                    <h5 class="links-title"><?php echo esc_html($title); ?></h5>
                <?php
        endif; ?>

                <?php if (!empty($links)): ?>
                    <ul class="links-list">
                        <?php foreach ($links as $item):
                $url = !empty($item['link']['url']) ? $item['link']['url'] : '#';
                $target = isset($item['link']['is_external']) && $item['link']['is_external'] ? ' target="_blank"' : '';
                $nofollow = isset($item['link']['nofollow']) && $item['link']['nofollow'] ? ' rel="nofollow"' : '';
?>
                            <li>
                                <a href="<?php echo esc_url($url); ?>"<?php echo $target . $nofollow; ?>>
                                    <?php echo esc_html($item['text']); ?>
                                </a>
                            </li>
                        <?php
            endforeach; ?>
                    </ul>
                <?php
        endif; ?>
            </div>
        <?php
    endif; ?>
    <?php
endfor; ?>
</div>
