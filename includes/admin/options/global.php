<?php
defined( 'ABSPATH' ) || exit;

$badge_up     = '<div class="disable-up-badge"><span class="disable-upcoming">' .__("Upcoming", "disabled-source-disabled-right-click-and-content-protection"). '</span></div>';

if( class_exists( 'CSF' ) ) {

  $prefix = 'jh_disabled_option';

  CSF::createOptions( $prefix, array(
    'framework_title'         =>   __( 'Disabled Settings <small>by <a style="color: #bfbfbf;text-decoration:none;" href="https://profiles.wordpress.org/jahidcse/" target="_blank">Jahid Hasan</a></small>', 'disabled-source-disabled-right-click-and-content-protection' ),
    'menu_title'              =>   __( 'Disabled Settings', 'disabled-source-disabled-right-click-and-content-protection' ),
    'menu_slug'               =>   'disabled-source-disabled-right-click-and-content-protection',
    'menu_icon'               =>   'dashicons-lock',
    'menu_position'           =>   25,
    'show_sub_menu'           =>   false,
    'theme'                   =>   'dark',   
    'footer_text'             => 'Thanks for Active our Plugin',
    'footer_credit'           =>   __( '<em>Enjoyed <strong>Disabled Source, Disabled Right Click and Content Protection</strong>? Please leave us a <a style="color:#e9570a;" href="https://wordpress.org/support/plugin/disabled-source-disabled-right-click-and-content-protection/reviews/?filter=5/#new-post" target="_blank">★★★★★</a> rating. We really appreciate your support!</em>', 'tourfic' ),  
  ) );

  // Images and Content Protection

  CSF::createSection( $prefix, array(
    'title'  => __( 'Images and Content', 'disabled-source-disabled-right-click-and-content-protection' ),
    'fields' => array(

    array(
      'id'    => 'disabled-content-select',
      'type'  => 'switcher',
      'title' => __( 'Disable Content Copy', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-right-click',
      'type'  => 'switcher',
      'title' => __( 'Disable Right Click', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-img-drag',
      'type'  => 'switcher',
      'title' => __( 'Disable Images Dragging', 'disabled-source-disabled-right-click-and-content-protection' )
    ),
    array(
      'id'    => 'disabled-ct-u',
      'type'  => 'switcher',
      'title' => __( 'Disable Source (CTRL+U)', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-ct-s',
      'type'  => 'switcher',
      'title' => __( 'Disable Save (CTRL+S)', 'disabled-source-disabled-right-click-and-content-protection' )
    ),
    array(
      'id'    => 'disabled-f12',
      'type'  => 'switcher',
      'title' => __( 'Disable F12', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-ct-st-i',
      'type'  => 'switcher',
      'title' => __( 'Disable Ctrl+Shift+I and Ctrl+I', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-ct-st-j',
      'type'  => 'switcher',
      'title' => __( 'Disable Ctrl+Shift+J and Ctrl+J', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-ct-st-c',
      'type'  => 'switcher',
      'title' => __( 'Disable Ctrl+Shift+C and Ctrl+C', 'disabled-source-disabled-right-click-and-content-protection' ),
      'default' => true,
    ),
    array(
      'id'    => 'disabled-comments',
      'type'  => 'switcher',
      'title' => __( 'Disable Comments', 'disabled-source-disabled-right-click-and-content-protection' ),
    ),

    )
  ) );

  // Disabled Notification

  CSF::createSection( $prefix, array(
    'title'  => __( 'Disable Notification', 'disabled-source-disabled-right-click-and-content-protection' ),
    'fields' => array(
      array(
        'id'    => 'disabled-notification-status',
        'type'  => 'switcher',
        'title' => __( 'Notification Status', 'disabled-source-disabled-right-click-and-content-protection' ),
        'default' => false,
      ),
      array(
        'id'         => 'disabled-notify-text',
        'type'       => 'text',
        'title'      => __( 'Notification Text', 'disabled-source-disabled-right-click-and-content-protection' ),
        'default'      => __( 'You cannot copy content of this Page', 'disabled-source-disabled-right-click-and-content-protection' ),
        'dependency' => array( 'disabled-notification-status', '==', 'true' ),
      )
    )
  ) );

  // Disabled IP Address

  CSF::createSection( $prefix, array(
    'id' => 'disabled_ip_address',
    'title'  => __( 'Block by IP Address', 'disabled-source-disabled-right-click-and-content-protection' ),
    'fields' => array(
      array(
        'id'     => 'disabled_ip_section',
        'type'   => 'repeater',
        'title'  => __( 'IP Address', 'disabled-source-disabled-right-click-and-content-protection' ),
        'subtitle' => __( "Never use your own IP Address. Then you can't access your Website.", 'disabled-source-disabled-right-click-and-content-protection' ),
        'fields' => array(
          array(
            'id'    => 'disabled_ip',
            'type'  => 'text'
          )
        )
      )
    )
  ) );

   // Disabled IP Address by Country

  CSF::createSection( $prefix, array(
    'id' => 'disabled_ip_country_address',
    'title'  => __( 'IP Block by Country', 'disabled-source-disabled-right-click-and-content-protection' ),
    'fields' => array(
      array(
        'id'     => 'disabled_ip_country',
        'type'   => 'text',
        'title'  => __( 'Block By Country', 'disabled-source-disabled-right-click-and-content-protection' ),
        'subtitle' => $badge_up,
        'attributes' => array(
          'readonly' => 'readonly',
        ),
      ),
    )
  ) );


}