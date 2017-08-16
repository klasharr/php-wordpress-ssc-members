<?php

/**
 * Stop our generic user accessing the admin pages, this will prevent viewing / managing the profile
 */
function admin_init_function() {

	// is_admin() is a check for accessing admin pages, not checking for the admin role
	if ( is_generic_member_user() && is_admin() ) {
		wp_redirect( get_home_url() );
	}
}

add_action( 'admin_init', 'admin_init_function' );


/**
 * Options for different notice displays are error, update-nag, notice
 */
function ssc_member_error_notice() {

	$user = get_option( 'ssc_member_generic_user', 0 );

	if ( $user == 0 ) { ?>
		<div class="update-nag notice">
			<p><?php _e( 'You do not have a generic user set up', 'ssc_member' ); ?></p>
		</div>
		<?php
	}
}

add_action( 'admin_notices', 'ssc_member_error_notice' );

// ------ Settings --------

function ssc_members_settings_api_init() {

	add_settings_section(
		'ssc_member_user_settings_section', // Section ID
		_e('Member settings', 'ssc_member' ), // Title
		'ssc_member_setting_section_callback', // Callback to render descripton
		'general' // Menu page, matching menu slug
	);

	add_settings_field(
		'ssc_member_generic_user', // Field ID
		_e('Generic User','ssc_member' ), // Title
		'ssc_member_setting_field_generic_user_callback', // Callback
		'general', // Page (menu slug)
		'ssc_member_user_settings_section' // Section ID of settings page in which to show the field
	);

	add_settings_field(
		'ssc_member_debug_mode', // Field ID
		_e('Debug mode', 'ssc_member' ),// Title
		'ssc_member_setting_field_debug_callback', // Callback
		'general', // Page (menu slug)
		'ssc_member_user_settings_section' // Section ID of settings page in which to show the field
	);

	add_settings_field(
		'ssc_member_privacy_term', // Field ID
		_e('Privacy term', 'ssc_member' ),// Title
		'ssc_member_setting_field_privacy_term_callback', // Callback
		'general', // Page (menu slug)
		'ssc_member_user_settings_section' // Section ID of settings page in which to show the field
	);

	// $_POST handling automatically taken care of.
	register_setting( 'general', 'ssc_member_generic_user', 'ssc_member_setting_field_generic_user_validate' );
	register_setting( 'general', 'ssc_member_debug_mode', 'ssc_member_debug_mode_validate' );
	register_setting( 'general', 'ssc_member_privacy_term', 'ssc_member_privacy_term_validate' );

}

add_action( 'admin_init', 'ssc_members_settings_api_init' );


function ssc_member_setting_section_callback() {
	//echo '<p>Intro text for our settings section</p>';
}

// ----- Callbacks -------

function ssc_member_setting_field_generic_user_callback() {

	echo '<select name="ssc_member_generic_user" id="ssc_member_generic_user">';
	echo ssc_member_get_non_admin_users_select_options_html();
	echo '</select>';
	echo sprint('<p>%s</p>', _e( 'Choose a user to be the generic member. Only subscriber roles are 
	allowed', 'ssc_member' ));
}

function ssc_member_setting_field_debug_callback() {
	echo sprintf('<input name="ssc_member_debug_mode" id="ssc_member_debug_mode" type="checkbox" value="1" class="code" %s />',
	checked( 1, ssc_member_is_debug_mode()));
}

function ssc_member_setting_field_privacy_term_callback() {

	$terms = get_terms( array(
		'taxonomy'   => 'post_tag',
		'hide_empty' => false,
	) );

	if ( ! is_array( $terms ) && empty( $terms ) ) {
		return array();
	}

	$option = get_option( 'ssc_member_privacy_term', 0 );

	echo '<select name="ssc_member_privacy_term" id="ssc_member_privacy_term">';
	echo '<option value="-1">none</option>';

	// @var WP_Term $wpto
	foreach ( $terms as $wpto ) {
		echo sprintf( '<option value="%d" %s>%s</option>',
			$wpto->term_id,
			$option == $wpto->term_id ? 'selected' : '',
			$wpto->name );
	}

	echo '</select>';
	echo '<p>Choose a tag to be the privacy identifier for post types that have the default tags taxonomy enabled.</p>';
	
}

// ------------ Validation ------------

function ssc_member_setting_field_generic_user_validate( $input ) {

	// If none was selected clean up the option and prevent saving of the new value
	if ( - 1 == $input ) {
		delete_option( 'ssc_member_generic_user' );

		return false;
	}

	// Do not set the admin up as a generic user
	if ( 1 == $input ) {
		add_settings_error( 'general', 'ssc_member_generic_user', 'Invalid action',
			'error' );

		return;
	}

	return $input;
}


function ssc_member_debug_mode_validate( $input ) {
	return $input;
}

function ssc_member_privacy_term_validate( $input ) {
	return $input;
}