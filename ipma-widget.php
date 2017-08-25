<?php
/**
 * The plugin bootstrap file
 *
 * @link              https://www.eurotux.com
 * @since             1.0.0
 * @package           IPMA_Widget
 *
 * @wordpress-plugin
 * Plugin Name:       IPMA Weather Widget
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Provides a weather forecast widget (Portugal only) powered by ipma (https://www.ipma.pt)
 * Version:           1.0.0
 * Author:            Dipcode
 * Author URI:        https://www.eurotux.com/
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
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ipma-widget-activator.php';
	Plugin_Name_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_plugin_name() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ipma-widget-deactivator.php';
	Plugin_Name_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_plugin_name' );
register_deactivation_hook( __FILE__, 'deactivate_plugin_name' );

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
	$plugin_hander->run();

}
bootstrap_plugin();
