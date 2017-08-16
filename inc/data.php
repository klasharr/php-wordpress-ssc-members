<?php
/**
 * @todo change this to checking against existence of a meta value
 * @param $query
 */
function exclude_single_posts_home( $query ) {

	if ( is_user_logged_in() ) {
		return;
	}

	$privacy_term_id = get_option( 'ssc_member_privacy_term', 0 );
	if ( 0 == $privacy_term_id ) {
		return;
	}

	$query->set( 'tax_query',
		array(
			array(
				'taxonomy' => SSC_MEMBERS_PRIVACY_TAXONOMY,
				'field'    => 'id',
				'terms'    => array( $privacy_term_id ),
				'operator' => 'NOT IN'
			)
		)
	);
}

add_action( 'pre_get_posts', 'exclude_single_posts_home' );
