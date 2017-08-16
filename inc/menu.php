<?php

/**
 * Allow logged in and out variants of the primary navigation menu.
 *
 * @todo make the menu options come from settings
 *
 * @param string $args
 *
 * @return string
 */
function ssc_member_section_primary_nav_menu( $args = '' ) {
	if ( is_user_logged_in() && $args['id'] == 'top-logged-out' ) {
		$args['menu'] = 'top-logged-in';
	}

	return $args;
}

add_filter( 'wp_nav_menu_args', 'ssc_member_section_primary_nav_menu' );


/**
 * Append either a Login or Logout link to the primary navigation menu depending on session status
 *
 * @param $items
 * @param $args
 *
 * @return string
 */
function ssc_member_loginout_menu_link( $items, $args ) {
	if ( $args->theme_location == 'primary' ) {
		if ( is_user_logged_in() ) {
			$items .= '<li class="right"><a href="' . wp_logout_url() . '">' . __( "Log Out" ) . '</a></li>';
		} else {
			$items .= '<li class="right"><a href="' . wp_login_url( get_permalink() ) . '">' . __( "Log In" ) . '</a></li>';
		}
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'ssc_member_loginout_menu_link', 10, 2 );