<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CLS {

    public static function activate() {
        if ( ! get_option( 'cls_settings' ) ) {
            add_option( 'cls_settings', array(
                'bg_color'    => '#f1f1f1',
                'form_bg'     => '#ffffff',
                'btn_color'   => '#2271b1',
                'logo_url'    => '',
                'enabled'     => '1',
            ) );
        }
    }

    public static function get_settings() {
        return wp_parse_args(
            get_option( 'cls_settings', array() ),
            array(
                'bg_color'    => '#f1f1f1',
                'form_bg'     => '#ffffff',
                'btn_color'   => '#2271b1',
                'logo_url'    => '',
                'enabled'     => '0',
            )
        );
    }
}