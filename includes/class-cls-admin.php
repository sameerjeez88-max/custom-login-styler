<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class CLS_Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'add_menu' ) );
        add_action( 'admin_init', array( $this, 'register_settings' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
    }

    public function add_menu() {
        add_menu_page(
            __( 'Login Styler', 'custom-login-styler' ),
            __( 'Login Styler', 'custom-login-styler' ),
            'manage_options',
            'cls-settings',
            array( $this, 'render_page' ),
            'dashicons-admin-customizer',
            81
        );
    }

    public function register_settings() {
        register_setting( 'cls_settings_group', 'cls_settings', array(
            'sanitize_callback' => array( $this, 'sanitize' ),
        ) );
    }

    public function sanitize( $input ) {
        return array(
            'bg_color'    => sanitize_hex_color( $input['bg_color'] ?? '#f1f1f1' ),
            'form_bg'     => sanitize_hex_color( $input['form_bg'] ?? '#ffffff' ),
            'btn_color'   => sanitize_hex_color( $input['btn_color'] ?? '#2271b1' ),
            'logo_url'    => esc_url_raw( $input['logo_url'] ?? '' ),
            'enabled'     => ! empty( $input['enabled'] ) ? '1' : '0',
        );
    }

    public function enqueue_assets( $hook ) {
        if ( 'toplevel_page_cls-settings' !== $hook ) return;
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'cls-admin', CLS_URL . 'assets/css/admin.css', array(), CLS_VERSION );
        wp_enqueue_script( 'cls-admin', CLS_URL . 'assets/js/admin.js', array( 'jquery', 'wp-color-picker' ), CLS_VERSION, true );
    }

    public function render_page() {
        $s = CLS::get_settings();
        ?>
        <div class="wrap cls-wrap">
            <h1><?php esc_html_e( 'Custom Login Page Styler', 'custom-login-styler' ); ?></h1>
            <form method="post" action="options.php">
                <?php settings_fields( 'cls_settings_group' ); ?>
                <table class="form-table">
                    <tr>
                        <th><label for="cls-enabled"><?php esc_html_e( 'Enable Styler', 'custom-login-styler' ); ?></label></th>
                        <td>
                            <input type="checkbox" id="cls-enabled" name="cls_settings[enabled]" value="1" <?php checked( $s['enabled'], '1' ); ?> />
                        </td>
                    </tr>
                    <tr>
                        <th><label for="cls-bg"><?php esc_html_e( 'Background Color', 'custom-login-styler' ); ?></label></th>
                        <td><input type="text" id="cls-bg" class="cls-color-picker" name="cls_settings[bg_color]" value="<?php echo esc_attr( $s['bg_color'] ); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="cls-form-bg"><?php esc_html_e( 'Form Background', 'custom-login-styler' ); ?></label></th>
                        <td><input type="text" id="cls-form-bg" class="cls-color-picker" name="cls_settings[form_bg]" value="<?php echo esc_attr( $s['form_bg'] ); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="cls-btn"><?php esc_html_e( 'Button Color', 'custom-login-styler' ); ?></label></th>
                        <td><input type="text" id="cls-btn" class="cls-color-picker" name="cls_settings[btn_color]" value="<?php echo esc_attr( $s['btn_color'] ); ?>" /></td>
                    </tr>
                    <tr>
                        <th><label for="cls-logo"><?php esc_html_e( 'Logo Image URL', 'custom-login-styler' ); ?></label></th>
                        <td>
                            <input type="text" id="cls-logo" class="regular-text" name="cls_settings[logo_url]" value="<?php echo esc_attr( $s['logo_url'] ); ?>" placeholder="https://example.com/logo.png" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
}