<div class="custom-dropdown">
    <div class="custom-dropdown-toggle"><?php echo esc_html($orderby_options[$current_orderby]); ?></div>
    <ul class="custom-dropdown-menu">
        <?php foreach ($orderby_options as $key => $label) : ?>
            <?php 
                $li_class = $current_orderby === $key ? 'selected' : '';
                ?>
            <li data-value="<?php echo esc_attr($key); ?>" class="<?php echo esc_attr($li_class); ?>">
                <?php echo esc_html($label); ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <input type="hidden" name="orderby" id="custom-orderby-input" value="<?php echo esc_attr($current_orderby); ?>">
</div>