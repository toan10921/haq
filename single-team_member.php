<?php
/**
 * Single Team Member template.
 *
 * @package nebon
 */

$team_member_css_path = get_template_directory() . '/assets/css/components/single-team-member.css';
if (file_exists($team_member_css_path)) {
    wp_enqueue_style(
        't888f-single-team-member',
        get_template_directory_uri() . '/assets/css/components/single-team-member.css',
        ['t888f-theme'],
        filemtime($team_member_css_path),
        'all'
    );
}

get_header();

if (function_exists('t888f_breadcrumb')) {
    t888f_breadcrumb(' <i class="las la-angle-right step-breadcrumb"></i> ');
}
?>

<?php while (have_posts()) : the_post(); ?>
    <?php
    $member_id = get_the_ID();
    $meta = static function ($key, $fallback = '') use ($member_id) {
        $value = get_post_meta($member_id, $key, true);
        return $value !== '' ? $value : $fallback;
    };

    $greeting = $meta('team_greeting', __('Hello i’m', 'nebon'));
    $position = $meta('team_position');
    $department = $meta('team_department');
    $experience = $meta('team_experience');
    $email = $meta('team_email');
    $phone = $meta('team_phone');
    $biography = trim((string) get_the_content());

    $social_links = [
        ['label' => 'Facebook', 'url' => $meta('team_facebook'), 'icon' => 'lab la-facebook-f'],
        ['label' => 'X', 'url' => $meta('team_twitter'), 'text' => 'X'],
        ['label' => 'Instagram', 'url' => $meta('team_instagram'), 'icon' => 'lab la-instagram'],
        ['label' => 'LinkedIn', 'url' => $meta('team_linkedin'), 'icon' => 'lab la-linkedin-in'],
    ];
    $social_links = array_values(array_filter($social_links, static function ($social) {
        return !empty($social['url']);
    }));

    $education_items = [];
    for ($education_index = 1; $education_index <= 4; $education_index++) {
        $education_title = $meta('team_education_' . $education_index . '_title');
        $education_description = $meta('team_education_' . $education_index . '_description');
        $education_logo_id = absint($meta('team_education_' . $education_index . '_logo'));

        if ($education_title === '' && $education_description === '' && !$education_logo_id) {
            continue;
        }

        $education_items[] = [
            'title' => $education_title,
            'description' => $education_description,
            'logo_url' => $education_logo_id ? wp_get_attachment_image_url($education_logo_id, 'thumbnail') : '',
        ];
    }

    $skills = [];
    for ($skill_index = 1; $skill_index <= 3; $skill_index++) {
        $skill_label = $meta('team_skill_' . $skill_index . '_label');
        if ($skill_label === '') {
            continue;
        }

        $skill_percentage = (int) $meta('team_skill_' . $skill_index . '_percentage', 0);
        $skills[] = [
            'label' => $skill_label,
            'percentage' => max(0, min(100, $skill_percentage)),
        ];
    }

    $skills_description = $meta('team_skills_description');
    $contact_title = $meta('team_contact_title', __("Let’s Get in Touch", 'nebon'));
    $contact_description = $meta(
        'team_contact_description',
        __('The point of using Lorem Ipsum is that it has more-or-less normal', 'nebon')
    );
    if ($contact_description === 'Send a message to discuss your project or request more information.') {
        $contact_description = __('The point of using Lorem Ipsum is that it has more-or-less normal', 'nebon');
    }
    $contact_shortcode = trim((string) $meta('team_contact_form_shortcode'));

    if ($contact_shortcode === '' && post_type_exists('wpcf7_contact_form')) {
        $contact_form_ids = get_posts([
            'post_type' => 'wpcf7_contact_form',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'fields' => 'ids',
            'orderby' => 'date',
            'order' => 'ASC',
        ]);

        if (!empty($contact_form_ids)) {
            $contact_shortcode = sprintf('[contact-form-7 id="%d"]', (int) $contact_form_ids[0]);
        }
    }

    $contact_form_html = '';
    if ($contact_shortcode !== '') {
        $contact_form_html = do_shortcode($contact_shortcode);
        $contact_placeholders = [
            'your-name' => __('Full Name', 'nebon'),
            'your-email' => __('Email Address', 'nebon'),
            'your-subject' => __('Your Inquiry', 'nebon'),
            'your-message' => __('Write Here...', 'nebon'),
        ];

        // Keep Contact Form 7 submission and validation intact while changing
        // the visible field copy for this profile design.
        $contact_form_html = preg_replace_callback(
            '/<(input|textarea)\b[^>]*>/i',
            static function ($field) use ($contact_placeholders) {
                $tag = $field[0];

                if (preg_match('/\bname=(["\'])([^"\']+)\1/i', $tag, $name_match)) {
                    $field_name = $name_match[2];
                    if (isset($contact_placeholders[$field_name])) {
                        $tag = preg_replace('/\splaceholder=(["\']).*?\1/i', '', $tag);
                        $placeholder = esc_attr($contact_placeholders[$field_name]);
                        $tag = preg_replace('/\s*\/>$/', ' placeholder="' . $placeholder . '" />', $tag);
                        if (strpos($tag, 'placeholder=') === false) {
                            $tag = preg_replace('/>$/', ' placeholder="' . $placeholder . '">', $tag);
                        }
                    }
                }

                if (stripos($tag, 'wpcf7-submit') !== false) {
                    $button_text = esc_attr__('Send Message', 'nebon');
                    $tag = preg_replace('/\svalue=(["\']).*?\1/i', '', $tag);
                    $tag = preg_replace('/\s*\/>$/', ' value="' . $button_text . '" />', $tag);
                    if (strpos($tag, 'value=') === false) {
                        $tag = preg_replace('/>$/', ' value="' . $button_text . '">', $tag);
                    }
                }

                return $tag;
            },
            $contact_form_html
        );
    }
    ?>

    <main class="team-profile">
        <div class="team-profile__container">
            <div class="team-profile__layout">
                <aside class="team-profile__sidebar">
                    <figure class="team-profile__portrait">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('large', ['class' => 'team-profile__portrait-image']); ?>
                        <?php else : ?>
                            <div class="team-profile__portrait-placeholder" aria-hidden="true">
                                <i class="las la-user"></i>
                            </div>
                        <?php endif; ?>
                    </figure>

                    <section class="team-profile__contact" aria-labelledby="team-contact-title">
                        <h2 id="team-contact-title"><?php echo esc_html($contact_title); ?></h2>
                        <?php if ($contact_description !== '') : ?>
                            <p class="team-profile__contact-description">
                                <?php echo esc_html($contact_description); ?>
                            </p>
                        <?php endif; ?>

                        <?php if ($contact_form_html !== '') : ?>
                            <div class="team-profile__contact-form">
                                <?php echo $contact_form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        <?php endif; ?>
                    </section>
                </aside>

                <article class="team-profile__main">
                    <header class="team-profile__header">
                        <p class="team-profile__greeting"><?php echo esc_html($greeting); ?></p>
                        <h1 class="team-profile__name"><?php the_title(); ?></h1>

                        <?php if ($position !== '') : ?>
                            <p class="team-profile__position"><?php echo esc_html($position); ?></p>
                        <?php endif; ?>

                        <dl class="team-profile__facts">
                            <?php if ($department !== '') : ?>
                                <div class="team-profile__fact">
                                    <dt><?php esc_html_e('Department:', 'nebon'); ?></dt>
                                    <dd><?php echo esc_html($department); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($experience !== '') : ?>
                                <div class="team-profile__fact">
                                    <dt><?php esc_html_e('Experience:', 'nebon'); ?></dt>
                                    <dd><?php echo esc_html($experience); ?></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($email !== '') : ?>
                                <div class="team-profile__fact">
                                    <dt><?php esc_html_e('Email:', 'nebon'); ?></dt>
                                    <dd><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></dd>
                                </div>
                            <?php endif; ?>

                            <?php if ($phone !== '') : ?>
                                <div class="team-profile__fact">
                                    <dt><?php esc_html_e('Phone:', 'nebon'); ?></dt>
                                    <dd>
                                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>">
                                            <?php echo esc_html($phone); ?>
                                        </a>
                                    </dd>
                                </div>
                            <?php endif; ?>
                        </dl>

                        <?php if ($social_links) : ?>
                            <nav class="team-profile__socials" aria-label="<?php esc_attr_e('Social profiles', 'nebon'); ?>">
                                <?php foreach ($social_links as $social) : ?>
                                    <a href="<?php echo esc_url($social['url']); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr($social['label']); ?>">
                                        <?php if (!empty($social['icon'])) : ?>
                                            <i class="<?php echo esc_attr($social['icon']); ?>" aria-hidden="true"></i>
                                        <?php else : ?>
                                            <span aria-hidden="true"><?php echo esc_html($social['text']); ?></span>
                                        <?php endif; ?>
                                    </a>
                                <?php endforeach; ?>
                            </nav>
                        <?php endif; ?>
                    </header>

                    <?php if ($biography !== '') : ?>
                        <section class="team-profile__section team-profile__biography">
                            <h2><?php esc_html_e('Biography', 'nebon'); ?></h2>
                            <div class="team-profile__rich-text">
                                <?php echo apply_filters('the_content', $biography); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if ($education_items) : ?>
                        <section class="team-profile__section">
                            <h2><?php esc_html_e('Education & Guidelines', 'nebon'); ?></h2>
                            <div class="team-profile__education-grid">
                                <?php foreach ($education_items as $education) : ?>
                                    <article class="team-profile__education-item">
                                        <div class="team-profile__education-logo">
                                            <?php if ($education['logo_url']) : ?>
                                                <img src="<?php echo esc_url($education['logo_url']); ?>" alt="">
                                            <?php else : ?>
                                                <i class="las la-graduation-cap" aria-hidden="true"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <?php if ($education['title'] !== '') : ?>
                                                <h3><?php echo esc_html($education['title']); ?></h3>
                                            <?php endif; ?>
                                            <?php if ($education['description'] !== '') : ?>
                                                <p><?php echo esc_html($education['description']); ?></p>
                                            <?php endif; ?>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>

                    <?php if ($skills || $skills_description !== '') : ?>
                        <section class="team-profile__section team-profile__skills">
                            <h2><?php esc_html_e('Professional Skills', 'nebon'); ?></h2>

                            <?php if ($skills_description !== '') : ?>
                                <p class="team-profile__skills-description"><?php echo esc_html($skills_description); ?></p>
                            <?php endif; ?>

                            <?php if ($skills) : ?>
                                <div class="team-profile__skill-list">
                                    <?php foreach ($skills as $skill) : ?>
                                        <div class="team-profile__skill">
                                            <div class="team-profile__skill-heading">
                                                <span><?php echo esc_html($skill['label']); ?></span>
                                                <strong><?php echo esc_html($skill['percentage']); ?>%</strong>
                                            </div>
                                            <div class="team-profile__skill-track" aria-hidden="true">
                                                <span style="width: <?php echo esc_attr($skill['percentage']); ?>%;"></span>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </section>
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </main>
<?php endwhile; ?>

<?php get_footer(); ?>
