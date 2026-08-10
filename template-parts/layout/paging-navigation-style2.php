<?php if ($links) :
    // Custom icon/text
    $links['prev_text'] = '<i class="las la-angle-left"></i>';
    $links['next_text'] = '<i class="las la-angle-right"></i>';
    $html = paginate_links( $links );
    ?>
    <div class="pagi-nav <?php echo esc_attr($style)?>">
        <div class="pagi-link-wrap d-flex justify-content-center align-items-center">
        <?php echo apply_filters('tech888f_output_content',$html); ?>
        </div>
    </div>
<?php endif;?>