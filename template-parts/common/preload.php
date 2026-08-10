 <div id="preloader" class="preloader <?php echo esc_attr($style); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>;">
     <div class="preloader-inner">
         <?php
            switch ($style) {
                case 'style2':
            ?>
                 <div class="t888-loader style2">
                     <span></span><span></span><span></span>
                 </div>
                 <?php
                    break;

                case 'style3':
                    if (!empty($preload_img)) {
                    ?>
                     <div class="t888-loader style3-image">
                         <img src="<?php echo esc_url($preload_img); ?>" alt="Preloader Image">
                     </div>
                 <?php
                    } else {
                    ?>
                     <div class="t888-loader style3">
                         <svg class="spinner" viewBox="0 0 50 50">
                             <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5" />
                         </svg>
                     </div>
                 <?php
                    }
                    break;

                case 'custom-image':
                    if (!empty($preload_img)) {
                    ?>
                     <div class="t888-loader custom-image">
                         <img src="<?php echo esc_url($preload_img); ?>" alt="Preloader">
                     </div>
                 <?php
                    }
                    break;

                case 'style1':
                default:
                    ?>
                 <div class="t888-loader style1"></div>
         <?php
                    break;
            }
            ?>
     </div>
 </div>