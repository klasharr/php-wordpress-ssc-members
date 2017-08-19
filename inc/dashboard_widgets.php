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

	$i = get_option( 'ssc_member_generic_user', 0 );

	if ( 0 === (int) $i ) {
		echo sprintf( "No generic user set yet please set one <a href='%s'>here</a>",
			admin_url( 'options-general.php' ) );
	} else {

		/** @var WP_User $user */
		$user = get_userdata( $i );
		echo sprintf( esc_html__("Generic user is %s ",'ssc-members'), sprintf('<strong>%s</strong>', $user->user_login )) ;
		echo sprintf( "<a href='%s'>%s</a>",
			admin_url( 'options-general.php' ),
			esc_html__('edit')
		);

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
}