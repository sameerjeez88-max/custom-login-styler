<?php
/**
 * Plugin Name:       Custom Login Styler
 * Plugin URI:        https://github.com/sameerjeez88-max/custom-login-styler
 * Description:       Beautify your WordPress login page with custom background colors, form styles, and your own logo.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * Author:            Rana Yasir
 * Author URI:        https://github.com/sameerjeez88-max
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-login-styler
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'CLS_VERSION', '1.0.0' );
define( 'CLS_PATH', plugin_dir_path( __FILE__ ) );
define( 'CLS_URL', plugin_dir_url( __FILE__ ) );

require_once CLS_PATH . 'includes/class-cls.php';
require_once CLS_PATH . 'includes/class-cls-admin.php';
require_once CLS_PATH . 'includes/class-cls-frontend.php';

function cls_init() {
    if ( is_admin() ) {
        new CLS_Admin();
    } else {
        new CLS_Frontend();
    }
}
add_action( 'plugins_loaded', 'cls_init' );

register_activation_hook( __FILE__, array( 'CLS', 'activate' ) );