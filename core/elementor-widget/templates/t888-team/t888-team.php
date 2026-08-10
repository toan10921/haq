<?php
$members = $team_list;
?>
<div class="t888-team">
    <div class="t888-team-slider swiper-container eltech888-swiper-slider"
        data-items="1"
        data-loop="true"
        data-speed="5000"
        data-autoplay="no"
        data-navigation="true"
        data-effect="slide">
        <div class="swiper-wrapper">
            <?php foreach ($members as $member): ?>
                <div class="swiper-slide team-member-item">
                    <div class="member-photo">
                        <img
                            src="<?php echo esc_url($member['image']['url']); ?>"
                            alt="<?php echo esc_attr($member['name']); ?>"
                            style="object-position: <?php echo esc_attr($member['image_position']); ?>;">

                    </div>
                    <h3 class="member-name"><?php echo esc_html($member['name']); ?></h3>
                    <p class="member-position"><?php echo esc_html($member['position']); ?></p>
                    <div class="member-socials">
                        <?php if (!empty($member['facebook']['url'])):
                            $url = $member['facebook']['url'];
                            $target = !empty($member['facebook']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['facebook']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Facebook"><i class="lab la-facebook-f"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['pinterest']['url'])):
                            $url = $member['pinterest']['url'];
                            $target = !empty($member['pinterest']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['pinterest']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Pinterest"><i class="lab la-pinterest-p"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['instagram']['url'])):
                            $url = $member['instagram']['url'];
                            $target = !empty($member['instagram']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['instagram']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Instagram"><i class="lab la-instagram"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['youtube']['url'])):
                            $url = $member['youtube']['url'];
                            $target = !empty($member['youtube']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['youtube']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="YouTube"><i class="lab la-youtube"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['twitter']['url'])):
                            $url = $member['twitter']['url'];
                            $target = !empty($member['twitter']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['twitter']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Twitter"><i class="lab la-twitter"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['linkedin']['url'])):
                            $url = $member['linkedin']['url'];
                            $target = !empty($member['linkedin']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['linkedin']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="LinkedIn"><i class="lab la-linkedin-in"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['skype']['url'])):
                            $url = $member['skype']['url'];
                            $target = !empty($member['skype']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['skype']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Skype"><i class="lab la-skype"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['whatsapp']['url'])):
                            $url = $member['whatsapp']['url'];
                            $target = !empty($member['whatsapp']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['whatsapp']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="WhatsApp"><i class="lab la-whatsapp"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['viber']['url'])):
                            $url = $member['viber']['url'];
                            $target = !empty($member['viber']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['viber']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Viber"><i class="lab la-viber"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['telegram']['url'])):
                            $url = $member['telegram']['url'];
                            $target = !empty($member['telegram']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['telegram']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Telegram"><i class="lab la-telegram"></i></a>
                        <?php endif; ?>

                        <?php if (!empty($member['snapchat']['url'])):
                            $url = $member['snapchat']['url'];
                            $target = !empty($member['snapchat']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($member['snapchat']['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                            <a href="<?php echo esc_url($url); ?>" <?php echo esc_attr($target . $rel); ?> aria-label="Snapchat"><i class="lab la-snapchat"></i></a>
                        <?php endif; ?>
                    </div>

                </div>
            <?php endforeach; ?>
        </div>

        <div class="swiper-button-prev"><i class="las la-angle-left"></i></div>
        <div class="swiper-button-next"><i class="las la-angle-right"></i></div>
    </div>
</div>