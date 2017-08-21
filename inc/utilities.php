<?php

/**
 * @return bool
 */
function ssc_member_is_generic_member_user() {
	return get_current_user_id() === (int) get_option( 'ssc_member_generic_user', 0 );
}

/**
 * @param WP_Post $post
 *
 * @todo, split out the member part
 *
 * @return bool
 */
function ssc_member_is_private_post( WP_Post $post ) {

	if ( 'member-page' === $post->post_type ) {
		return true;
	}

	if ( 'on' === get_metadata( 'post', $post->ID, 'ssc_members_post_privacy', true ) ) {
		return true;
	}
}


/**
 * @return bool
 */
function ssc_member_is_debug_mode() {
	return (bool) get_option( 'ssc_member_debug_mode', false );
}

/**
 * @return bool
 */
function ssc_member_is_editing_private_post() {

	// @var WP_Post $post;
	global $post;

	// @var WP_Screen $screen
	$screen = get_current_screen();

	if ( 'post' === $screen->post_type && 'post' === $screen->id && ssc_member_is_private_post( $post ) ) {
		return true;
	}
}

/**
 * @param WP_User $user
 *
 * @return bool
 */
function ssc_member_user_is_only_subscriber( WP_User $user ) {
	if ( 1 === count( $user->roles ) && in_array( 'subscriber', $user->roles, true ) ) {
		return true;
	}
}

function ssc_member_get_post_privacy_value( WP_Post $post ) {

	$post_meta_values = get_post_custom( $post->ID );

	if ( isset( $post_meta_values['ssc_members_post_privacy'] ) &&
	     is_array( $post_meta_values['ssc_members_post_privacy'] ) &&
	     ! empty( $post_meta_values['ssc_members_post_privacy'][0] )
	) {

		return esc_attr( $post_meta_values['ssc_members_post_privacy'][0] );
	}
}