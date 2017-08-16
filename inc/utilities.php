<?php

/**
 * @return bool
 */
function is_generic_member_user() {
	return get_current_user_id() == get_option( 'ssc_member_generic_user', 0 );
}

/**
 * @param WP_Post $post
 *
 * @return bool
 */
function ssc_member_is_private_post( WP_Post $post ) {

	$privacy_term_id = get_option( 'ssc_member_privacy_term', 0 );

	return has_term( $privacy_term_id, SSC_MEMBERS_PRIVACY_TAXONOMY, $post );
}


function ssc_member_is_debug_mode(){
	return get_option( 'ssc_member_debug_mode', false );
}

