<?php
$title = $title ?? 'HOT DEALS:';
$sale_deadline = $sale_deadline ?? '';
$auto_loop = $auto_loop ?? '';
$auto_loop_days = (float) ($auto_loop_days ?? 5);
$auto_loop_hours = (float) ($auto_loop_hours ?? 0);

$deadline_timestamp = !empty($sale_deadline)
    ? strtotime($sale_deadline)
    : time() + 86400 * 9 + 3600 * 20 + 60 * 7 + 14;

$loop_ms = 0;
if ($auto_loop === 'yes') {
    $duration_seconds = ($auto_loop_days * 86400) + ($auto_loop_hours * 3600);
    if ($duration_seconds > 0) {
        $loop_ms = (int) ($duration_seconds * 1000);
    }
}
?>

<div class="t888-pet-hotdeals-countdown-wrap">
    <h3 class="t888-hotdeals-title"><?php echo esc_html($title); ?></h3>

    <div class="t888-hotdeals-countdown" data-deadline="<?php echo esc_attr((int) $deadline_timestamp * 1000); ?>" data-loop-ms="<?php echo esc_attr($loop_ms); ?>">
        <div class="t888-hotdeals-box">
            <span class="t888-hotdeals-number days">00</span>
            <span class="t888-hotdeals-label"><?php echo esc_html__('days', 'nebon'); ?></span>
        </div>
        <div class="t888-hotdeals-box">
            <span class="t888-hotdeals-number hours">00</span>
            <span class="t888-hotdeals-label"><?php echo esc_html__('hurs', 'nebon'); ?></span>
        </div>
        <div class="t888-hotdeals-box">
            <span class="t888-hotdeals-number mins">00</span>
            <span class="t888-hotdeals-label"><?php echo esc_html__('mins', 'nebon'); ?></span>
        </div>
        <div class="t888-hotdeals-box">
            <span class="t888-hotdeals-number secs">00</span>
            <span class="t888-hotdeals-label"><?php echo esc_html__('secs', 'nebon'); ?></span>
        </div>
    </div>
</div>

