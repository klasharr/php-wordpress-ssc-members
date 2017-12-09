<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * If a logged in primary menu is specified, use that.
 *
 * @param string $args
 *
 * @return string
 */
function ssc_member_section_primary_nav_menu( $args = '' ) {

	$menu_option = get_option( 'ssc_member_logged_in_menu', false );

	if ( !is_user_logged_in() || false === $menu_option ||  'primary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['menu'] = $menu_option;
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
	if ( 'primary' === $args->theme_location ) {
		if ( is_user_logged_in() ) {
			$items .= '<li class="right"><a href="' . wp_logout_url() . '">' . esc_html__( "Log Out" ) . '</a></li>';
		} else {
			$items .= '<li class="right"><a href="' . wp_login_url( get_permalink() ) . '">' . esc_html__( "Log In" ) . '</a></li>';
		}
	}

	return $items;
}

add_filter( 'wp_nav_menu_items', 'ssc_member_loginout_menu_link', 10, 2 );