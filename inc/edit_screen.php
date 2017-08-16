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
	     has_term( $privacy_term_id, SSC_MEMBERS_PRIVACY_TAXONOMY, $post )
	) {

		echo "<div style='background-color: red; color: white; padding: 0.2em; text-align: center;'>Members only</div>";
	}
}

add_action( 'edit_form_after_title', 'ssc_member_edit_screen_message' );