<?php 

// Disabled Source Plugin Set Admin Notice Status
if(!function_exists('jh_review_activation_status')){

    function jh_review_activation_status(){ 
        $jh_installation_date = get_option('jh_installation_date'); 
        if( !isset($_COOKIE['jh_installation_date']) && empty($jh_installation_date) && $jh_installation_date == 0){
            setcookie('jh_installation_date', 1, time() + (86400 * 7), "/"); 
        }else{
            update_option( 'jh_installation_date', '1' );
        }
    }
    add_action('admin_init', 'jh_review_activation_status');
}

// Disabled Source Plugin Review Admin Notice
if(!function_exists('jh_review_notice')){
    
     function jh_review_notice(){ 
        $get_current_screen = get_current_screen();  
        if($get_current_screen->base == 'dashboard'){
            $current_user = wp_get_current_user();
        ?>
            <div class="notice notice-info jh_disable_review_notice"> 
               
                <?php echo sprintf( 
                        __( ' <p>Hey %1$s 👋, You have been using <b>%2$s</b> for quite a while. If you feel %2$s is helping your business to grow in any way, would you please help %2$s to grow by simply leaving a ★★★★★ review on the WordPress Forum?', 'disabled-source-disabled-right-click-and-content-protection' ),
                        $current_user->display_name,
                        'Disabled Source, Disabled Right Click and Content Protection'
                    ); ?> 
                
                <ul>
                    <li><a target="_blank" href="<?php echo esc_url('https://wordpress.org/support/plugin/disabled-source-disabled-right-click-and-content-protection/reviews/?filter=5/#new-post') ?>" class=""><span class="dashicons dashicons-external"></span><?php _e(' Ok, you deserve it!', 'disabled-source-disabled-right-click-and-content-protection' ) ?></a></li>
                    <li><a href="#" class="already_done" data-status="already"><span class="dashicons dashicons-smiley"></span> <?php _e('I already did', 'disabled-source-disabled-right-click-and-content-protection') ?></a></li>
                    <li><a href="#" class="later" data-status="later"><span class="dashicons dashicons-calendar-alt"></span> <?php _e('Maybe Later', 'disabled-source-disabled-right-click-and-content-protection') ?></a></li>
                    <li><a href="#" class="never" data-status="never"><span class="dashicons dashicons-dismiss"></span><?php _e('Never show again', 'disabled-source-disabled-right-click-and-content-protection') ?> </a></li> 
                </ul>
                <button type="button" class="notice-dismiss review_notice_dismiss"><span class="screen-reader-text"><?php _e('Dismiss this notice.', 'disabled-source-disabled-right-click-and-content-protection') ?></span></button>
            </div>

            <!--   Disabled Source Plugin Review Admin Notice Script -->
            <script>
                jQuery(document).ready(function($) {
                    $(document).on('click', '.already_done, .later, .never', function( event ) {
                        event.preventDefault();
                        var $this = $(this);
                        var status = $this.attr('data-status'); 
                        $this.closest('.jh_disable_review_notice').css('display', 'none')
                        data = {
                            action : 'jh_review_notice_callback',
                            status : status,
                        };

                        $.ajax({
                            url: ajaxurl,
                            type: 'post',
                            data: data,
                            success: function (data) { ;
                            },
                            error: function (data) { 
                            }
                        });
                    });

                    $(document).on('click', '.review_notice_dismiss', function( event ) {
                        event.preventDefault(); 
						var $this = $(this);
                        $this.closest('.jh_disable_review_notice').css('display', 'none')
                        
                    });
                });

            </script>
        <?php  
        }
     }
     $jh_review_notice_status = get_option('jh_review_notice_status'); 
     $jh_installation_date = get_option('jh_installation_date'); 
     if(isset($jh_review_notice_status) && $jh_review_notice_status <= 0 && $jh_installation_date == 1 && !isset($_COOKIE['jh_review_notice_status']) && !isset($_COOKIE['jh_installation_date'])){ 
        add_action( 'admin_notices', 'jh_review_notice' );  
     }
     
}

 
// Disabled Source Review Admin Notice Ajax Callback 
if(!function_exists('jh_review_notice_callback')){

    function jh_review_notice_callback(){
        $status = $_POST['status'];
        if( $status == 'already'){ 
            update_option( 'jh_review_notice_status', '1' );
        }else if($status == 'never'){ 
            update_option( 'jh_review_notice_status', '2' );
        }else if($status == 'later'){
            $cookie_name = "jh_review_notice_status";
            $cookie_value = "1";
            setcookie($cookie_name, $cookie_value, time() + (86400 * 7), "/"); 
            update_option( 'jh_review_notice_status', '0' ); 
        }  
        wp_die();
    }
    add_action( 'wp_ajax_jh_review_notice_callback', 'jh_review_notice_callback' );

}