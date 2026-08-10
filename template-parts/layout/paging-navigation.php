<?php if ($links) :
    // Custom icon/text
    $links['prev_text'] = '';
    $links['next_text'] = '';
    ?>
    <div class="pagi-nav text-center <?php echo esc_attr($style)?>">
        <div class="pagi-link-wrap">
        <?php echo apply_filters('tech888f_output_content',paginate_links($links)); ?>
        </div>
    </div>
<?php endif;?>