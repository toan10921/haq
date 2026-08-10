<div class="product-thumbnail <?php echo esc_attr($animation_class); ?>  <?php if (!empty($thumbnail_hover_id)) echo 'has-hover'; ?>">
    <a href="<?php the_permalink(); ?>" class="product-link">
        <?php echo wp_get_attachment_image($thumbnail_id, $size, false, array('class' => 'primary-img', 'alt' => get_the_title())); ?>
        <?php
        if (!empty($thumbnail_hover_id)) {
            echo wp_get_attachment_image($thumbnail_hover_id, $size, false, array('class' => 'hover-img', 'alt' => get_the_title()));
        }
        ?>
    </a>
</div>