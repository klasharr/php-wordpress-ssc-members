<?php

/**
 * Add custom CSS to header
 */
function ssc_member_add_header_styles() {

	// @var WP_Post $post
	global $post;

	$privacy_term_id = get_option( 'ssc_member_privacy_term', 0 );

	if ( 0 == get_option( 'ssc_member_debug_mode', 0 ) || ! has_term( $privacy_term_id, SSC_MEMBERS_PRIVACY_TAXONOMY, $post ) ) {
		return;
	}

	echo sprintf( "<style type='text/css'>article#post-%d { border-top: 2px solid red; }</style>", $post->ID );

}

add_action( 'wp_head', 'ssc_member_add_header_styles' );