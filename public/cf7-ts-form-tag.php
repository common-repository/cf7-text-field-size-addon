<?php
/**
 *  Contact form 7 text field size in front-end side form
 */

/**
 * Initialize function for front-end side
 *
 * @since    	1.0.0
 * @param      	string    $plugin_name       		Contact form 7 text field size.
 * @param      	string    $version    				1.0.0.
 */
add_action( 'wpcf7_init', 'cf7_ts_add_formtag_custom_text_field' );
function cf7_ts_add_formtag_custom_text_field() {
	wpcf7_add_form_tag(
		array( 'custom-text-field', 'custom-text-field*' ),
		'cf7_ts_custom_text_field_formtag_handler', true);
}

/**
 * To display text field size in form front-end side
 *
 * @since    	1.0.0
 * @param      	string    $plugin_name       		Contact form 7 text field size.
 * @param      	string    $version    				1.0.0.
 */
function cf7_ts_custom_text_field_formtag_handler ( $cf7_ts_tag ){
    
    $cf7_ts_tag = new WPCF7_FormTag( $cf7_ts_tag );

	if ( empty( $cf7_ts_tag->name ) ){
		return '';
	}
	
	$validation_error = wpcf7_get_validation_error( $cf7_ts_tag->name );

	$class = wpcf7_form_controls_class( $cf7_ts_tag->type, 'wpcf7-country-code' );

	if ( $validation_error )
		$class .= ' wpcf7-not-valid';

	$atts = array();
	
	$atts['class'] = $cf7_ts_tag->get_class_option( $class );
	$atts['id'] = $cf7_ts_tag->get_id_option();
	if ( $cf7_ts_tag->has_option( 'readonly' ) ):
		$atts['readonly'] = 'readonly';
	endif;
	if ( $cf7_ts_tag->is_required() ):
		$atts['aria-required'] = 'true';
	endif;
	$atts['aria-invalid'] = $validation_error ? 'true' : 'false';

	$value = (string) reset( $cf7_ts_tag->values );

	if ( $cf7_ts_tag->has_option( 'placeholder' ) || $cf7_ts_tag->has_option( 'watermark' ) ) {
		$atts['placeholder'] = $value;
		$value = '';
	}
	if ( $cf7_ts_tag->has_option( 'size' ) ):
		$atts['size'] = $cf7_ts_tag->get_option('size', '', true);
	endif;
	if ($cf7_ts_tag->has_option('initialCountry')) :
		$atts['data-initialcountry'] = $cf7_ts_tag->get_option('initialCountry', '', true);
	endif;
	if ( $cf7_ts_tag->has_option( 'preferredCountries' ) ):
		$atts['data-preferredcountries'] = $cf7_ts_tag->get_option('preferredCountries', '', true);
	endif;
	if ( $cf7_ts_tag->has_option( 'lookup-key' ) ):
		$atts['data-lookup-key'] = $cf7_ts_tag->get_option('lookup-key', '', true);
	endif;	

	$value = $cf7_ts_tag->get_default_option($value);
	$value = wpcf7_get_hangover( $cf7_ts_tag->name, $value );

	$atts['value'] = $value;
	$atts['type'] = 'tel';
	$atts['name'] = $cf7_ts_tag->name;

	$atts = wpcf7_format_atts( $atts );

	$html = sprintf(
		'<span class="wpcf7-form-control-wrap %1$s" data-name="'.$cf7_ts_tag->name.'"><input %2$s />%3$s</span>',
		sanitize_html_class( $cf7_ts_tag->name ), $atts, $validation_error );

	return $html;
}

/**
 * Filter for the text field size validation
 *
 * @since    	1.0.0
 * @param      	string    $plugin_name       		Contact form 7 text field size.
 * @param      	string    $version    				1.0.0.
 */
add_filter( 'wpcf7_validate_custom_text_field', 'cf7_ts_custom_text_field_validation_filter', 10, 2 );
add_filter( 'wpcf7_validate_custom_text_field*', 'cf7_ts_custom_text_field_validation_filter', 10, 2 );

function cf7_ts_custom_text_field_validation_filter( $result, $cf7_ts_tag ) {

	$cf7_ts_tag = new WPCF7_FormTag( $cf7_ts_tag );
	$name = $cf7_ts_tag->name;

	$customOptions = array();
	foreach($cf7_ts_tag->options as $option){
		$customoptn = explode(':',$option);
		$customOptions[$customoptn[0]] = $customoptn[1];
	}

	$_name = sanitize_text_field($_POST[$name]);

	$value = isset( $_name )? trim( wp_unslash( strtr( (string) $_name, "\n", " " ) ) ) : '';

	if ( $cf7_ts_tag->is_required() && '' == $value ) {
	    $result->invalidate( $cf7_ts_tag, wpcf7_get_message( 'invalid_required' ) );
	} elseif ( isset($customOptions['minlength']) && strlen( $value ) < $customOptions['minlength'] ) {
        $result->invalidate( $cf7_ts_tag, wpcf7_get_message( 'invalid_too_short' ) );
	} elseif ( isset($customOptions['maxlength']) && strlen( $value ) > $customOptions['maxlength'] ) {
        $result->invalidate( $cf7_ts_tag, wpcf7_get_message( 'invalid_too_long' ) );
	}
	
	return $result;
}
?>