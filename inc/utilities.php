<?php

/**
 * @return bool
 */
function is_generic_member_user() {
	return get_current_user_id() == (int) get_option( 'ssc_member_generic_user', 0 );
}

/**
 * @param WP_Post $post
 *
 * @return bool
 */
function ssc_member_is_private_post( WP_Post $post ) {

	return 'on' == get_metadata('post', $post->ID, 'ssc_members_post_privacy', true ) ? true : false;
	
}

/**
 * @return bool
 */
function ssc_member_is_debug_mode(){
	return (bool) get_option( 'ssc_member_debug_mode', false );
}

function ssc_member_is_editing_private_post() {

	// @var WP_Post $post;
	global $post;

	// @var WP_Screen $screen
	$screen = get_current_screen();

	if( $screen->post_type == 'post' && $screen->id == 'post' && ssc_member_is_private_post( $post ) ) {
		return true;
	}
}
