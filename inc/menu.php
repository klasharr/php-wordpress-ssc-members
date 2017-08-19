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

	if($args['theme_location'] != 'primary'){
		return;
	}

	//print_r(wp_get_nav_menu_object('primary'));

	//$menus = get_registered_nav_menus();
	//if(!empty($menus) && is_array($menus)){
	//	$primary_menu_name = $menus['primary'];
	//}

	if ( is_user_logged_in() ) {
		$args['menu'] = 'top-logged-in';
	} else {
		$args['menu'] = 'top-logged-out';
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
			$items .= '<li class="right"><a href="' . wp_logout_url() . '">' . esc_html__( "Log Out" ) . '</a></li>';
		} else {
			$items .= '<li class="right"><a href="' . wp_login_url( get_permalink() ) . '">' . esc_html__( "Log In" ) . '</a></li>';
		}
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'ssc_member_loginout_menu_link', 10, 2 );