<?php
// Silence is golden.
get_header();
$img_404 =  get_template_directory_uri() . '/assets/images/404.png';
?>

<section id="main-content" class="main-page-default">
    <div class="container">
        <div class="row">

            <div class="col-12">
                <?php
                ?>
                <div class="container">
                    <div class="content-default-404">
                        <div class="row">
                            <div class="col-12">
                                <div class="info-404 text-center">
                                    <div class="img-404">
                                    <img src="<?php echo esc_url($img_404); ?>" alt="404" />
                                    </div>
                                    <span class="oops"><?php esc_html_e("Oops! That Page Can't Be Found.", "nebon") ?></span>
                                    <p class="sorry"><?php esc_html_e("Sorry for the inconvenience. Go to our homepage or check out our latest collections.", "nebon") ?></p>
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="text-uppercase button"><?php esc_html_e("Back to Homepage", "nebon") ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<?php do_action('t888f_after_main_content'); ?>
<?php
get_footer();
