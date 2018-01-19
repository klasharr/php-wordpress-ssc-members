<?php


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add a visual notification on the edit screen to tell users they are editing a members page or post.
 */
function ssc_member_edit_screen_message() {

	// @var WP_Screen $screen
	$screen = get_current_screen();

	if ( ssc_member_is_debug_mode() && ( 'member-page' === $screen->post_type || ssc_member_is_editing_private_post() ) ) {

		echo sprintf( "<div style='background-color: red; color: white; padding: 0.2em; text-align: center;'>%s</div>", esc_html__( 'Members only' ) );
	}
}

add_action( 'edit_form_after_title', 'ssc_member_edit_screen_message' );