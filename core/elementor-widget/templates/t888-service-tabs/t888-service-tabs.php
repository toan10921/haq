<?php
$service_items = isset($services) && is_array($services) ? $services : [];
$tabs_id = 't888-service-tabs-' . sanitize_html_class($widget_id ?? uniqid());
$service_tabs_style = ($style ?? 'style1') === 'style2' ? 'style2' : 'style1';
$is_history_style = $service_tabs_style === 'style2';
?>

<?php if (!empty($service_items)): ?>
    <section class="t888-service-tabs-section t888-service-tabs-section--<?php echo esc_attr($service_tabs_style); ?>">
        <div id="<?php echo esc_attr($tabs_id); ?>" class="t888-service-tabs t888-service-tabs--<?php echo esc_attr($service_tabs_style); ?>" data-t888-service-tabs>
        <div
            class="t888-service-tabs__nav"
            role="tablist"
            aria-label="<?php echo esc_attr($is_history_style ? __('Company history', 'nebon') : __('Services', 'nebon')); ?>"
            aria-orientation="<?php echo esc_attr($is_history_style ? 'horizontal' : 'vertical'); ?>"
        >
            <?php foreach ($service_items as $index => $item):
                $tab_id = $tabs_id . '-tab-' . $index;
                $panel_id = $tabs_id . '-panel-' . $index;
                $is_active = $index === 0;
            ?>
                <button
                    id="<?php echo esc_attr($tab_id); ?>"
                    class="t888-service-tabs__tab<?php echo $is_active ? ' is-active' : ''; ?>"
                    type="button"
                    role="tab"
                    aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>"
                    aria-controls="<?php echo esc_attr($panel_id); ?>"
                    tabindex="<?php echo $is_active ? '0' : '-1'; ?>"
                >
                    <span><?php echo esc_html($item['tab_title'] ?? ''); ?></span>
                    <span class="t888-service-tabs__arrow" aria-hidden="true">&#8594;</span>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="t888-service-tabs__panels">
            <?php foreach ($service_items as $index => $item):
                $tab_id = $tabs_id . '-tab-' . $index;
                $panel_id = $tabs_id . '-panel-' . $index;
                $is_active = $index === 0;
                $image_url = !empty($item['image']['url'])
                    ? $item['image']['url']
                    : \Elementor\Utils::get_placeholder_image_src();
                $features = array_values(array_filter(array_map(
                    'trim',
                    preg_split('/\r\n|\r|\n/', (string) ($item['feature_list'] ?? ''))
                )));
                $link = isset($item['link']) && is_array($item['link']) ? $item['link'] : [];
                $rel_values = [];
                if (!empty($link['nofollow'])) {
                    $rel_values[] = 'nofollow';
                }
                if (!empty($link['is_external'])) {
                    $rel_values[] = 'noopener';
                }
            ?>
                <section
                    id="<?php echo esc_attr($panel_id); ?>"
                    class="t888-service-tabs__panel<?php echo $is_active ? ' is-active' : ''; ?>"
                    role="tabpanel"
                    aria-labelledby="<?php echo esc_attr($tab_id); ?>"
                    <?php echo $is_active ? '' : 'hidden'; ?>
                >
                    <div class="t888-service-tabs__media">
                        <img
                            class="t888-service-tabs__image"
                            src="<?php echo esc_url($image_url); ?>"
                            alt="<?php echo esc_attr($item['tab_title'] ?? ''); ?>"
                            loading="lazy"
                        >
                    </div>

                    <div class="t888-service-tabs__content">
                        <?php if (!empty($item['content_title'])): ?>
                            <h3 class="t888-service-tabs__title"><?php echo esc_html($item['content_title']); ?></h3>
                        <?php endif; ?>

                        <?php if (!empty($item['description'])): ?>
                            <p class="t888-service-tabs__description"><?php echo esc_html($item['description']); ?></p>
                        <?php endif; ?>

                        <?php if (!empty($features)): ?>
                            <ul class="t888-service-tabs__features">
                                <?php foreach ($features as $feature): ?>
                                    <li>
                                        <span class="t888-service-tabs__check" aria-hidden="true"><?php echo $is_history_style ? '' : '&#10003;'; ?></span>
                                        <span><?php echo esc_html($feature); ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php if (!empty($item['link_text']) && !empty($link['url'])): ?>
                            <a
                                class="t888-service-tabs__link"
                                href="<?php echo esc_url($link['url']); ?>"
                                <?php echo !empty($link['is_external']) ? 'target="_blank"' : ''; ?>
                                <?php echo !empty($rel_values) ? 'rel="' . esc_attr(implode(' ', $rel_values)) . '"' : ''; ?>
                            >
                                <span><?php echo esc_html($item['link_text']); ?></span>
                                <span aria-hidden="true">&#8594;</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
        </div>
    </section>
<?php endif; ?>
