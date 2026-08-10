<?php
if (empty($locations)) return;
?>

<div class="t888-location-list">
    <?php foreach ($locations as $location): ?>
        <div class="t888-location-item">
            <h3 class="location-title">
                <i class="las la-rainbow"></i>
                <?php echo esc_html($location['title']); ?>
            </h3>
            <div class="location-details">
                <?php if (!empty($location['address'])): ?>
                    <p class="info-location">Add: <?php echo esc_html($location['address']); ?></p>
                <?php endif; ?>
                <?php if (!empty($location['phone'])): ?>
                    <p class="info-location">Tel: <?php echo esc_html($location['phone']); ?></p>
                <?php endif; ?>
                <?php if (!empty($location['email'])): ?>
                    <p class="info-location">Email: <?php echo esc_html($location['email']); ?></p>
                <?php endif; ?>
                </div>
                <div class="location-hours">
                <?php if (!empty($location['weekday_hours'])): ?>
                    <p class="time-open"><i class="las la-clock"></i><span> <?php echo esc_html($location['weekday_hours']); ?></span></p>
                <?php endif; ?>
                <?php if (!empty($location['saturday_hours'])): ?>
                    <p class="time-open"><i class="las la-clock"></i> <span><?php echo esc_html($location['saturday_hours']); ?></span></p>
                <?php endif; ?>
            </div>
            <?php if (!empty($location['map_link']['url'])): ?>
                <div class="location-map">
                    <a class="btn-map button" href="<?php echo esc_url($location['map_link']['url']); ?>" target="_blank">
                        <?php echo esc_html__('Open Map', 'nebon'); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
