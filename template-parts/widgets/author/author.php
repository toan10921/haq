<?php
$size = array(270, 320);
$author_image = isset($data['author_image']) ? $data['author_image'] : '';
$author_name = isset($data['author_name']) ? $data['author_name'] : '';
$author_description = isset($data['author_description']) ? $data['author_description'] : '';
$title = isset($data['title']) ? $data['title'] : '';
?>

<div class="author-widget">
    <?php if (!empty($title)) : ?>
        <h5 class="widget-title"><?php echo esc_html($title); ?></h5>
    <?php endif; ?>
    <div class="author-avatar overflow-hidden">
        <?php
        if (!empty($link)) {
            echo '<a href="' . esc_url($link) . '">';
        }
        ?>
        <?php if (!empty($author_image)) : ?>
            <?php
            $author_image_id = attachment_url_to_postid($author_image);
            if ($author_image_id) {
                echo wp_get_attachment_image($author_image_id, $size, false, array('alt' => esc_attr($author_name), 'class' => 'd-block'));
            } else {
                echo '<img src="' . esc_url($author_image) . '" alt="' . esc_attr($author_name) . '" width="' . esc_attr($size[0]) . '" height="' . esc_attr($size[1]) . '">';
            }
            ?>
        <?php
        else:
            echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/270x320.svg') . '" alt="' . esc_attr($author_name) . '" width="' . esc_attr($size[0]) . '" height="' . esc_attr($size[1]) . '">';
        endif;
        if (!empty($link)) {
            echo '</a>';
        }
        ?>
    </div>
    <?php if (!empty($author_name)) : ?>
        <h3 class="title author-title fw-bold font-monsterrat title13 text-uppercase primary"><?php echo esc_html($author_name); ?></h3>
    <?php endif; ?>
    <?php if (!empty($author_description)) : ?>
        <p class="description title14 m-0"><?php echo esc_html($author_description); ?></p>
    <?php endif; ?>
</div>