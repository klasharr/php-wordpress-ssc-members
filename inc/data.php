<?php
/**
 * @see inc/post_meta_box.php
 *
 * @todo exclude member pages from search IF logged out.
 *
 * @param WP_Query $query
 */
function ssc_member_exclude_private_posts( $query ) {

	if ( is_user_logged_in() ) {
		return;
	}

	// @todo check for a more efficient way to do this
	$query->set( 'meta_query',
		array(
			array(
				'key'     => 'ssc_members_post_privacy',
				'compare' => 'NOT EXISTS',
			)
		)
	);
}

add_action( 'pre_get_posts', 'ssc_member_exclude_private_posts' );
