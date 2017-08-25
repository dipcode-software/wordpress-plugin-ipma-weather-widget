<?php
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @link       http://dipcode.com/
 * @author     Dipcode <support@dipcode.com>
 * @since      1.0.1
 * @package    IPMA_Widget
 * @subpackage IPMA_Widget/includes
 */
class Meteo_IPMA extends WP_Widget {
	/**
	 * Widget identifier.
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * widget file.
	 *
	 * @since 1.0.1
	 *
	 * @var   string
	 */
	public static $widget_slug = 'meteo-ipma';

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {
		parent::__construct(
			$this->get_widget_slug(),
			__( 'Weather Forecast in Portugal', 'ipma-widget' ),
			array(
				'classname'  => 'ipma-widget-class',
				'description' => __( 'Provides a weather forecast for Portuguese regions', 'ipma-widget' ),
			)
		);
	}

	/**
	 * Return the widget slug.
	 *
	 * @since  1.0.1
	 *
	 * @return Plugin slug variable.
	 */
	public function get_widget_slug() {
		return self::get_static_widget_slug();
	}

	/**
	 * Return the widget slug.
	 *
	 * @since  1.0.1
	 *
	 * @return Plugin slug variable.
	 */
	public static function get_static_widget_slug() {
		return self::$widget_slug;
	}

	/**
	 * Outputs the content of the widget.
	 *
	 * @since 1.0.1
	 *
	 * @param array $args  The array containing form elements.
	 * @param array $instance The current widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		if ( isset( $instance['title'] ) ) {
			$args['title'] = $instance['title'];
		}
		include( plugin_dir_path( __DIR__ ) . 'public/partials/widget.php' );

	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @since 1.0.4
	 *
	 * @param array $new_instance The new instance of values to be generated via the update.
	 * @param array $old_instance The previous instance of values before the update.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @since 1.0.4
	 *
	 * @param array $instance The array of keys and values for the widget.
	 */
	public function form( $instance ) {

		$instance = wp_parse_args(
			(array) $instance
		);

		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'New title', 'text_domain' );
		$title_id = $this->get_field_id( 'title' );
		$title_field = $this->get_field_name( 'title' );
		include( plugin_dir_path( __DIR__ ) . 'admin/partials/widget-form.php' );
	}
}
