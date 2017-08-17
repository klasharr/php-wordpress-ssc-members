<?php

/**
 * @todo various clean up
 */
function ssc_member_edit_screen_message() {

	// @var WP_Post $post;
	global $post;

	// @var WP_Screen $screen
	$screen = get_current_screen();

	$privacy_term_id = get_option( 'ssc_member_privacy_term', 0 );

	if ( $screen->post_type == 'post' &&
	     $screen->id == 'post' &&
	     ssc_member_is_private_post( $post )
	) {

		echo "<div style='background-color: red; color: white; padding: 0.2em; text-align: center;'>Members only</div>";
	}
}

add_action( 'edit_form_after_title', 'ssc_member_edit_screen_message' );