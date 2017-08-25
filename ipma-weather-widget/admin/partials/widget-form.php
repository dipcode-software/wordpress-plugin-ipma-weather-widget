<?php
/**
 * Provide a admin area view for the plugin
 *
 * Allows the widget title to be edited
 *
 * @link       http://dipcode.com
 * @since      1.0.4
 *
 * @package    IPMA_Widget
 * @subpackage IPMA_Widget/admin/partials
 */

?>
<p>
<label for="<?php echo esc_attr( $title_id ); ?>"><?php esc_attr_e( 'Title', 'ipma-widget' ); ?>:</label> 
<input class="widefat" id="<?php echo esc_attr( $title_id ); ?>" name="<?php echo esc_attr( $title_field ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
</p>
