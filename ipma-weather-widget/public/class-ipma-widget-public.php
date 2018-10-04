<?php
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       http://dipcode.com
 * @since      1.0.0
 * @author     Dipcode <support@dipcode.com>
 * @package    IPMA_Widget
 * @subpackage IPMA_Widget/public
 */
class IPMA_Widget_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * The IPMA_Widget_Loader will then create the relationship
		 * to load all necessary styles to render the widget.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ipma-widget-public.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'select2', plugin_dir_url( __FILE__ ) . 'css/vendor/select2/select2.min.css', array(), '4.0.3', 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * The IPMA_Widget_Loader will then create the relationship
		 * to load all necessary scripts to use the widget.
		 *
		 * Also handles the i18n strings to be available in the
		 * JavaScript layer.
		 */

		wp_enqueue_script( 'select2', plugin_dir_url( __FILE__ ) . 'js/vendor/select2/select2.min.js', array( 'jquery' ), '4.0.3', true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ipma-widget-public.min.js', array( 'jquery' ), $this->version, false );

		$js_strings = $this->javascript_translations();
		wp_localize_script( $this->plugin_name, 'ipmaWidget_i18n', $js_strings );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.2
	 */
	public function javascript_translations() {

		/**
		 * List of all translatable strings to be rendered client-side.
		 */
		return array(
			'forecast00' => __( 'Not available', 'ipma-weather-widget' ),
			'forecast01' => __( 'Clear sky', 'ipma-weather-widget' ),
			'forecast02' => __( 'Partly cloudy', 'ipma-weather-widget' ),
			'forecast03' => __( 'Mostly partly cloudy', 'ipma-weather-widget' ),
			'forecast04' => __( 'Cloudy sky', 'ipma-weather-widget' ),
			'forecast05' => __( 'Cloudy (high clouds)', 'ipma-weather-widget' ),
			'forecast06' => __( 'Showers', 'ipma-weather-widget' ),
			'forecast07' => __( 'Light showers', 'ipma-weather-widget' ),
			'forecast08' => __( 'Heavy showers', 'ipma-weather-widget' ),
			'forecast19' => __( 'Rain', 'ipma-weather-widget' ),
			'forecast20' => __( 'Light rain', 'ipma-weather-widget' ),
			'forecast21' => __( 'Heavy rain', 'ipma-weather-widget' ),
			'forecast22' => __( 'Intermittent rain', 'ipma-weather-widget' ),
			'forecast23' => __( 'Light intermittent rain', 'ipma-weather-widget' ),
			'forecast24' => __( 'Heavy intermittent rain', 'ipma-weather-widget' ),
			'forecast25' => __( 'Drizzle', 'ipma-weather-widget' ),
			'forecast26' => __( 'Mist', 'ipma-weather-widget' ),
			'forecast27' => __( 'Fog and low clouds', 'ipma-weather-widget' ),
			'forecast28' => __( 'Snow', 'ipma-weather-widget' ),
			'forecast29' => __( 'Lightning', 'ipma-weather-widget' ),
			'forecast30' => __( 'Intermittent rain and lightning', 'ipma-weather-widget' ),
			'forecast31' => __( 'Hail', 'ipma-weather-widget' ),
			'forecast32' => __( 'Frost', 'ipma-weather-widget' ),
			'forecast33' => __( 'Heavy rain and lightning', 'ipma-weather-widget' ),
			'forecast34' => __( 'Convective clouds', 'ipma-weather-widget' ),
			'forecast35' => __( 'Cloudy sky', 'ipma-weather-widget' ),
			'forecast36' => __( 'Fog', 'ipma-weather-widget' ),
			'forecast37' => __( 'Cloudy sky', 'ipma-weather-widget' ),
		);
	}
}
