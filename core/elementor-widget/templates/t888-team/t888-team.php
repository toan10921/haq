<?php

$team_source = $team_source ?? 'manual';
$members = isset($team_list) && is_array($team_list)
    ? $team_list
    : [];

if ($team_source === 'dynamic') {
    $members = [];

    $team_query = new \WP_Query([
        'post_type'      => 'team_member',
        'post_status'    => 'publish',
        'posts_per_page' => isset($dynamic_posts_per_page)
            ? (int) $dynamic_posts_per_page
            : 12,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);

    while ($team_query->have_posts()) {
        $team_query->the_post();

        $member_id = get_the_ID();
        $image_url = get_the_post_thumbnail_url(
            $member_id,
            'large'
        );

        if (!$image_url) {
            $image_url = \Elementor\Utils::get_placeholder_image_src();
        }

        $members[] = [
            'image' => [
                'url' => $image_url,
            ],
            'image_position' => 'center top',
            'name' => get_the_title(),
            'position' => get_post_meta(
                $member_id,
                'team_position',
                true
            ),
            'profile_link' => [
                'url' => get_permalink($member_id),
                'is_external' => false,
                'nofollow' => false,
            ],
            'facebook' => [
                'url' => get_post_meta(
                    $member_id,
                    'team_facebook',
                    true
                ),
            ],
            'instagram' => [
                'url' => get_post_meta(
                    $member_id,
                    'team_instagram',
                    true
                ),
            ],
            'linkedin' => [
                'url' => get_post_meta(
                    $member_id,
                    'team_linkedin',
                    true
                ),
            ],
        ];
    }

    wp_reset_postdata();
}

?>
<div class="t888-team">
    <div class="t888-team-grid">
            <?php foreach ($members as $member): ?>
                <?php
                $profile_link = isset($member['profile_link']) && is_array($member['profile_link'])
                    ? $member['profile_link']
                    : [];
                $profile_url = !empty($profile_link['url']) ? $profile_link['url'] : '';
                $profile_target = !empty($profile_link['is_external']) ? '_blank' : '';
                $profile_rel = [];
                if (!empty($profile_link['nofollow'])) {
                    $profile_rel[] = 'nofollow';
                }
                if ($profile_target === '_blank') {
                    $profile_rel[] = 'noopener';
                }
                ?>
                <article class="team-member-item">
                    <?php if ($profile_url): ?>
                        <a
                            class="member-profile-link"
                            href="<?php echo esc_url($profile_url); ?>"
                            <?php if ($profile_target): ?>target="<?php echo esc_attr($profile_target); ?>"<?php endif; ?>
                            <?php if ($profile_rel): ?>rel="<?php echo esc_attr(implode(' ', array_unique($profile_rel))); ?>"<?php endif; ?>
                            aria-label="<?php echo esc_attr(sprintf(__('View profile: %s', 'nebon'), $member['name'])); ?>">
                    <?php endif; ?>
                    <div class="member-photo">
                        <img
                            src="<?php echo esc_url($member['image']['url']); ?>"
                            alt="<?php echo esc_attr($member['name']); ?>"
                            style="object-position: <?php echo esc_attr($member['image_position']); ?>;">

                    </div>
                    <h3 class="member-name"><?php echo esc_html($member['name']); ?></h3>
                    <p class="member-position"><?php echo esc_html($member['position']); ?></p>
                    <?php if ($profile_url): ?>
                        </a>
                    <?php endif; ?>
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

                </article>
            <?php endforeach; ?>
    </div>
</div>
