<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CLS_Frontend {

    public function __construct() {
        add_action( 'login_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    public function enqueue_assets() {
        $s = CLS::get_settings();
        if ( '1' !== $s['enabled'] ) return;

        wp_enqueue_style( 'cls-frontend', CLS_URL . 'assets/css/frontend.css', array(), CLS_VERSION );
        
        $custom_css = "
            body.login { background-color: {$s['bg_color']} !important; }
            .login form { background-color: {$s['form_bg']} !important; }
            .wp-core-ui .button-primary { background-color: {$s['btn_color']} !important; border-color: {$s['btn_color']} !important; }
        ";
        wp_add_inline_style( 'cls-frontend', $custom_css );

        if ( ! empty( $s['logo_url'] ) ) {
            $logo_css = "
                #login h1 a, .login h1 a {
                    background-image: url({$s['logo_url']});
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                    width: 100%;
                    height: 80px;
                }
            ";
            wp_add_inline_style( 'cls-frontend', $logo_css );
        }
    }
}