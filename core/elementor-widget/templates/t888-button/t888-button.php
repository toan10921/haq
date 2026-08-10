<?php
$button_text = $button_text ?? 'Click Me';
$style       = $style ?? 'style1';

$url      = !empty($button_url['url']) ? $button_url['url'] : '#';
$target   = !empty($button_url['is_external']) ? ' target="_blank"' : '';
$rels     = [];
if (!empty($button_url['nofollow']))  $rels[] = 'nofollow';
if (!empty($button_url['is_external'])) $rels[] = 'noopener';
$rel_attr = $rels ? ' rel="' . esc_attr(implode(' ', $rels)) . '"' : '';
?>
<a href="<?php echo esc_url($url); ?>" <?php echo $target . $rel_attr; ?>
    class="t888-button button <?php echo esc_attr($style); ?>">
    <?php echo esc_html($button_text); ?>
</a>