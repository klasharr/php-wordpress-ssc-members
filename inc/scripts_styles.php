<?php

/**
 * Add custom CSS to header
 */
function ssc_member_add_header_styles() {

	// @var WP_Post $post
	global $post;

	if ( 0 == get_option( 'ssc_member_debug_mode', 0 ) ){
	     return;
	}
	
	if( is_single() && ( ssc_member_is_private_post($post) || $post->post_type == 'member-page' ) ) {
		echo sprintf( "<style type='text/css'>article#post-%d { border-top: 2px solid red; }</style>", $post->ID );
	}

}

add_action( 'wp_head', 'ssc_member_add_header_styles' );