<?php
$size = array(270, 320); 
$image = isset($data['image']) ? $data['image'] : '';
$description1 = isset($data['description1']) ? $data['description1'] : '';
$description2 = isset($data['description2']) ? $data['description2'] : '';
$description3 = isset($data['description3']) ? $data['description3'] : '';
$title = isset($data['title']) ? $data['title'] : '';
?>

<div class="image-text-widget">
    <?php if (!empty($title)) : ?>
        <h5 class="widget-title"><?php echo esc_html($title); ?></h5>
    <?php endif; ?>
    <div class="image-container">
        <?php 
            if(!empty($link)) {
                echo '<a href="'.esc_url($link).'">';
            }
        ?>
        <?php if (!empty($image)) : ?>
            <?php
            $image_id = attachment_url_to_postid($image);
            if ($image_id) {
                echo wp_get_attachment_image($image_id, $size, false, array('alt' => esc_attr($description1), 'class' => 'd-block'));
            } else {
                echo '<img src="' . esc_url($image) . '" alt="' . esc_attr($description1) . '" width="' . esc_attr($size[0]) . '" height="' . esc_attr($size[1]) . '">';
            }
            ?>
        <?php endif; ?>
        <?php if (!empty($description1)) : ?>
            <span class="description-image-text1"><?php echo esc_html($description1); ?></span>
        <?php endif; ?>
        <?php if (!empty($description2)) : ?>
            <span class="description-image-text2"><?php echo esc_html($description2); ?></span>
        <?php endif; ?>
        <?php if (!empty($description3)) : ?>
            <span class="description-image-text3"><?php echo esc_html($description3); ?></span>
        <?php endif; ?>
        <?php 
            if(!empty($link)) {
                echo '</a>';
            }
        ?>
    </div>
</div>
