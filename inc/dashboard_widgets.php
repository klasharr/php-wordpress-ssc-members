<?php

function ssc_members_dashboard_section() {

	wp_add_dashboard_widget(
		'ssc-members-section',         // Widget slug.
		'Members',         // Title.
		'ssc_members_section_callback' // Display function.
	);
}

add_action( 'wp_dashboard_setup', 'ssc_members_dashboard_section' );

/**
 * @todo add private posts count
 * /wp-admin/edit.php?privacy=members
 */
function ssc_members_section_callback() {

	$user_id = get_option( 'ssc_member_generic_user', 0 );

	if ( 0 === (int) $user_id ) {

		echo sprintf('<p>%s</p>', ssc_member_get_no_generic_member_set_message());

	} else {

		/** @var WP_User $user */
		$user = get_userdata( $user_id );
		if(empty($user)){
			echo sprintf('<p>%s %s</p>',
				esc_html__(sprintf('Error, user %d could not be found.', $user_id)),
				ssc_member_get_no_generic_member_set_message()
			);
		} else {

			$user_info =  sprintf( esc_html__("Generic user is %s.",'ssc-members'), sprintf('<strong>%s</strong>', $user->user_login ) );
			$edit = sprintf( "<a href='%s'>%s</a>", admin_url( 'options-general.php' ), esc_html__('edit', 'ssc-members') );

			echo sprintf('<p>%s %s</p>', $user_info, $edit );
		}
	}

	// @todo handle single vs plural text
	$count_posts = wp_count_posts( 'member-page' );
	if ( is_object( $count_posts ) && isset( $count_posts->publish ) ) {
		echo sprintf( '<p>%d %s <a href="%s">%s</a></p>',
			$count_posts->publish,
			esc_html__('published', 'ssc-members'),
			admin_url( 'edit.php?post_type=member-page' ),
			esc_html__('member pages', 'ssc-members')
		);
	}
}

function ssc_member_get_no_generic_member_set_message(){
	return sprintf( esc_html__("No generic user set, you can set this %s.", 'ssc-members' ),
		sprintf( '<a href="%s">%s</a>', admin_url( 'options-general.php' ), esc_html__('here', 'ssc-members') )
	);
}