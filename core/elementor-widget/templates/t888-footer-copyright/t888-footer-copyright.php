<?php
/**
 * Template for Footer Copyright Widget
 */
$copy_text = $copyright_text ?? '© 2025 - Nebon. All Rights Reserved.';
?>

<div class="footer-copyright">
    <div class="footer-copyright-inner">
        <p><?php echo wp_kses_post($copy_text); ?></p>
    </div>
</div>
