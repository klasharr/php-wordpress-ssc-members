<?php

/*
 Plugin Name: SSC Member section
 Plugin URI: TBD
 Description: Work in progress for creating a members section
 Author: Klaus Harris
 Version: -1
 Author URI: https://klaus.blog
 Text Domain: ssc-members
 */


if ( ! defined( 'ABSPATH' ) ) exit;

define( 'SSC_MEMBERS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'SSC_MEMBERS_PLUGIN_FILE', __FILE__ );
define( 'SSC_MEMBERS_SLUG_BASE_SEGMENT', esc_html__( 'members' ) );

include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/admin.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/dashboard_widgets.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/edit_screen.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/scripts_styles.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/data.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/menu.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/users.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/post_types.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/utilities.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/post_meta_box.php' );
include_once( SSC_MEMBERS_PLUGIN_DIR . 'inc/shortcodes.php' );

/**
 * Redirect the user to a login screen if he/she tries to access member content.
 */
function ssc_member_handle_redirects() {

	if ( is_user_logged_in() || is_search() ) {
		return;
	}

	$permalink = get_permalink();


	$url_parts = explode( "/", wp_parse_url( $permalink, PHP_URL_PATH ) );

	/*
	 * If we exclude content at a query level, @post will be empty for non valid queries therefore
	 * this will only raise a warning
	 * // ( is_singular( $post ) && ssc_member_is_private_post( $post ) ) ||
	 *
	 * @todo tidy, check
	 */
	if ( !empty($url_parts[1]) && $url_parts[1] === SSC_MEMBERS_SLUG_BASE_SEGMENT ) {
		wp_safe_redirect( wp_login_url().'?mbo=1' );
		exit();
	}
}

add_action( 'wp', 'ssc_member_handle_redirects' );




function ssc_member_admin_bar_visibility() {

	if ( is_user_logged_in() && ssc_member_is_generic_member_user() ) {
		show_admin_bar( false );
	}
}

add_action( 'wp', 'ssc_member_admin_bar_visibility' );


/**
 * Adding for completeness
 *
 * @param $output
 *
 * @return string
 */
function ssc_members_robots_override( $output ) {
	$output .= sprintf( "Disallow: /%s/*\n", SSC_MEMBERS_SLUG_BASE_SEGMENT );

	return $output;
}

add_filter( 'robots_txt', 'ssc_members_robots_override', 0, 2 );


/**
 * Disable commenting for the generic user
 *
 * @param $open
 * @param $post_id
 *
 * @return bool
 */
function ssc_members_comments_open( $open, $post_id ) {

	if ( is_user_logged_in() && ssc_member_is_generic_member_user() ) {
		return false;
	}
}

add_filter( 'comments_open', 'ssc_members_comments_open', 10, 2 );



if ( ssc_member_is_redirect_to_login() ) {

	function custom_login_message() {
		return sprintf(
			'<p class="ssc_member_login_message">%s</p>',
			esc_html__( 'You will need to login to see this content' ) );

	}

	add_filter( 'login_message', 'custom_login_message' );

}

function ssc_footer() {}
add_action('wp_footer', 'ssc_footer');

function ssc_login_message( $message ) {

	if ( empty($message) ){
		return sprintf("<p style='center'>%s</p>",
			"Login here to the Swanage Sailing Club Website. <br/><br/>If you don't have the login details, please check the Members handbook or contact <a href='mailto:webmaster@swanagesailingclub.org.uk'>webmaster@swanagesailingclub.org.uk</a>"
		);
	} else {
		return $message;
	}
}

add_filter( 'login_message', 'ssc_login_message' );