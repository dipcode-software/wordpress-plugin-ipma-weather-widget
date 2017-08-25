<?php
/**
 * The plugin bootstrap file
 *
 * @link              http://dipcode.com
 * @since             1.0.0
 * @package           IPMA_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       IPMA Weather Widget
 * Description:       The Weather Forecast in Portugal, provided by the IPMA plugin, lets you display a real-time forecast for any location in Portugal (mainland and archipelagos) in a WordPress website.
 * Version:           1.0.4
 * Author:            Dipcode
 * Author URI:        http://dipcode.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ipma-widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ipma-widget-activator.php
 */
function activate_ipma_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ipma-widget-activator.php';
	IPMA_Widget_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ipma-widget-deactivator.php
 */
function deactivate_ipma_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ipma-widget-deactivator.php';
	IPMA_Widget_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ipma_widget' );
register_deactivation_hook( __FILE__, 'deactivate_ipma_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ipma-widget.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function bootstrap_plugin() {

	$plugin_handler = new IPMA_Widget();
	$plugin_handler->run();

}
bootstrap_plugin();
