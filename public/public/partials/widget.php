<?php
/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://dipcode.com
 * @since      1.0.0
 *
 * @package    IPMA_Widget
 * @subpackage IPMA_Widget/public/partials
 */

$id = isset( $args['id'] ) ? $args['id'] : 'ipma-widget-0';
$forecast_depth = isset( $args['forecast_depth'] ) ? $args['forecast_depth'] : 3;
$title_data_attr = 'data-ipma-forecast-title';
$widget_title = isset( $args['title'] ) ? $args['title'] : $args['widget_name'];
$img_src = isset( $args['img_src'] ) ? $args['img_src'] : dirname( plugin_dir_url( __FILE__ ) ) . '/img/logo.png';
$display_mode = isset( $args['horizontal'] ) ? 'horizontal' : 'vertical';
$today = new DateTime();

?>
<section data-ipma-widget id="<?php echo esc_attr( $id ); ?>" class="widget widget_ipma ipma-widget-wrapper ipma-widget-<?php echo esc_attr( $display_mode ); ?>">
	<figure class="ipma-widget-logo">
		<a href="//www.ipma.pt/" title="<?php esc_attr_e( 'IPMA - The Portuguese Institute for Sea and Atmosphere', 'ipma-widget' ); ?>" target="_blank">
			<img alt="<?php esc_attr_e( 'IPMA - The Portuguese Institute for Sea and Atmosphere', 'ipma-widget' ); ?>" src="<?php echo esc_url( $img_src ); ?>"/>
		</a>
	</figure>
	<div class="ipma-widget-header">
		<div data-ipma-widget-title class="ipma-widget-title">
			<?php echo esc_html( $widget_title ); ?>
		</div>
		<select data-ipma-widget-select data-ipma-widget-district class="ipma-widget-select ipma-widget-select-district">
			<option data-ipma-widget-placeholder><?php esc_html_e( 'Select a district','ipma-widget' ); ?></option>
		</select>
		<select data-ipma-widget-select data-ipma-widget-location class="ipma-widget-select ipma-widget-select-location">
			<option data-ipma-widget-placeholder><?php esc_html_e( 'Select a location','ipma-widget' ); ?></option>
		</select>
	</div>
	<div data-ipma-widget-unavailabe class="ipma-widget-unavailable hidden">
		<h5><?php echo esc_html_e( 'Forecast temporarily unavailable', 'ipma-widget' ); ?></h5>
	</div>
	<div data-ipma-widget-forecasts class="ipma-widget-forecasts hidden">
		<?php for ( $i = 0; $i < $forecast_depth; $i++ ) : ?>
			<?php
			/* Increment the day */
			if ( $i > 0 ) {
				$today->modify( '+1 days' );
			}
			$date_format = $today->format( 'Y-m-d' );

			/* Default: Weekday */
			$date_string = date_i18n( 'l', $today->format( 'U' ) );
			/* Today */
			$date_string = (0 == $i) ? __( 'Today','ipma-widget' ) : $date_string;
			/* Tomorrow */
			$date_string = (1 == $i) ? __( 'Tomorrow','ipma-widget' ) : $date_string;


			?>
			<div data-ipma-forecast="<?php echo esc_attr( $date_format ); ?>" class="ipma-widget-forecast">
				<div class="ipma-widget-forecast-text">
					<div data-ipma-forecast-verbose class="ipma-widget-forecast-title"><?php echo esc_html( $date_string ); ?></div>
					<div data-ipma-forecast-date class="ipma-widget-forecast-date"><?php echo esc_html( date_i18n( 'd F' , $today->format( 'U' ) ) ); ?></div>
				</div>
				<figure class="ipma-widget-forecast-icon disabled">
					<img data-ipma-forecast-icon alt=""/>
				</figure>
				<span title="<?php esc_attr_e( 'Minimum', 'ipma-widget' ); ?>" class="ipma-widget-forecast-value ipma-widget-forecast-minimum-temperature"><span data-ipma-forecast-mintemp>0</span>º</span>
				<span title="<?php esc_attr_e( 'Maximum', 'ipma-widget' ); ?>" class="ipma-widget-forecast-value ipma-widget-forecast-maximum-temperature"><span data-ipma-forecast-maxtemp>0</span>º</span>
				<span title="<?php esc_attr_e( 'Precipitation', 'ipma-widget' ); ?>" class="ipma-widget-forecast-value ipma-widget-forecast-precipitation"><span data-ipma-forecast-precip>0</span><sup>%</sup></span>
			</div>
		<?php endfor; ?>
	</div>
</div>
