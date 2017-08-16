<?php

// @todo remove generic user access if user role changes from subscriber

/**
 * option clean up
 *
 * @param $user_id int
 */
function ssc_member_delete_generic_user( $user_id ) {
	$user = get_option( 'ssc_member_generic_user', 0 );
	if ( $user_id == $user ) {
		delete_option( 'ssc_member_generic_user' );
	}
}

add_action( 'delete_user', 'ssc_member_delete_generic_user' );


/**
 * @param $allow bool
 * @param $user_id int
 *
 * @return bool
 */
function ssc_member_section_deny_password_reset( $allow, $user_id ) {

	// WP_User object
	// @var $user WP_User
	$user = get_user_by( 'id', $user_id );

	if ( $user->ID == get_option( 'ssc_member_generic_user', 0 ) ) {
		$allow = false;
	}

	return $allow;
}

add_filter( 'allow_password_reset', 'ssc_member_section_deny_password_reset', 10, 2 );


/**
 *
 * @return string|void
 */
function ssc_member_get_non_admin_users_select_options_html() {

	$users = get_users(
		array(
			'exclude'  => array( 1 ),
			'role__in' => array( 'subscriber' ),
		)
	);

	$out = '<option value="-1">none</option>';

	if ( ! is_array( $users ) || empty( $users ) ) {
		return $out;
	}

	$option = get_option( 'ssc_member_generic_user', 0 );

	foreach ( $users as $obj ) {
		$out .= sprintf( '<option value="%d" %s>%s</option>',
			$obj->ID,
			$option == $obj->ID ? 'selected' : '',
			$obj->user_login );
	}

	return $out;
}


if ( ! empty( $_GET['mbo'] ) && 1 === (int) $_GET['mbo'] ) {

	function custom_login_message() {
		$message = '<p class="message">You will need to login to see this content</p>';

		return $message;
	}

	add_filter( 'login_message', 'custom_login_message' );
}