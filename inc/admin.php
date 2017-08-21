<?php

/**
 * Stop our generic user accessing the admin pages, this will prevent viewing / managing the profile
 */
function admin_init_function() {

	// is_admin() is a check for accessing admin pages, not checking for the admin role
	if ( ssc_member_is_generic_member_user() && is_admin() ) {
		wp_redirect( get_home_url() );
	}
}

add_action( 'admin_init', 'admin_init_function' );


/**
 * Options for different notice displays are error, update-nag, notice
 */
function ssc_member_error_notice() {

	$user = get_option( 'ssc_member_generic_user', 0 );

	if ( 0 === (int) $user ) { ?>
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
		esc_html__( 'Member settings', 'ssc_member' ), // Title
		'ssc_member_setting_section_callback', // Callback to render descripton
		'general' // Menu page, matching menu slug
	);

	add_settings_field(
		'ssc_member_generic_user', // Field ID
		esc_html__( 'Generic User', 'ssc_member' ), // Title
		'ssc_member_setting_field_generic_user_callback', // Callback
		'general', // Page (menu slug)
		'ssc_member_user_settings_section' // Section ID of settings page in which to show the field
	);

	add_settings_field(
		'ssc_member_debug_mode', // Field ID
		esc_html__( 'Debug mode', 'ssc_member' ),// Title
		'ssc_member_setting_field_debug_callback', // Callback
		'general', // Page (menu slug)
		'ssc_member_user_settings_section' // Section ID of settings page in which to show the field
	);

	// $_POST handling automatically taken care of.
	register_setting( 'general', 'ssc_member_generic_user', 'ssc_member_setting_field_generic_user_validate' );
	register_setting( 'general', 'ssc_member_debug_mode', 'ssc_member_debug_mode_validate' );

}

add_action( 'admin_init', 'ssc_members_settings_api_init' );


function ssc_member_setting_section_callback() {
	//echo '<p>Intro text for our settings section</p>';
}

// ----- Callbacks -------

function ssc_member_setting_field_generic_user_callback() {

	//print_r(get_settings_errors());

	echo '<select name="ssc_member_generic_user" id="ssc_member_generic_user">';
	echo ssc_member_get_non_admin_users_select_options_html();
	echo '</select>';
	echo sprintf( '<p>%s</p>', esc_html__( 'Choose a user to be the generic member. Only subscriber roles are 
	allowed.', 'ssc_member' ) );
}

function ssc_member_setting_field_debug_callback() {
	echo sprintf( '<input name="ssc_member_debug_mode" id="ssc_member_debug_mode" type="checkbox" value="1" class="code" %s />',
		checked( 1, ssc_member_is_debug_mode(), false ) );
}


// ------------ Validation ------------

function ssc_member_setting_field_generic_user_validate( $user_id ) {

	if ( ! is_numeric( $user_id ) ) {
		return;
	}

	// If none was selected clean up the option and prevent saving of the new value
	if ( - 1 == $user_id ) {
		delete_option( 'ssc_member_generic_user' );

		return false;
	}

	// Do not set the admin up as a generic user
	if ( 1 == $user_id ) {
		add_settings_error( 'general', 'ssc_member_generic_user', esc_html__( 'Invalid action' ),
			'error' );

		return;
	}

	/** @var WP_User $user */
	$user = get_userdata( $user_id );
	if ( empty( $user ) ) {
		add_settings_error( 'general', 'ssc_member_generic_user', esc_html__( sprintf( 'User %d does not exist.', $user_id ) ), 'error' );

		return;
	}

	if ( !ssc_member_user_is_only_subscriber( $user ) ) {
		add_settings_error( 'general', 'ssc_member_generic_user',
			esc_html__( sprintf( 'User %s does not have exclusively a subscriber role.', $user->user_login ) ), 'error' );

		return;
	}

	return $user_id;
}


function ssc_member_debug_mode_validate( $input ) {
	if ( ! is_numeric( $input ) ) {
		return;
	}

	return $input;
}