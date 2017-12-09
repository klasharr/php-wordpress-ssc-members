<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Set up our member only pages.
 *
 * @see exclude_single_posts_home()
 */
function ssc_member_pages_init() {
	$args = array(
		'label'             => esc_html__('Member pages'),
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => SSC_MEMBERS_SLUG_BASE_SEGMENT),
		'query_var'         => true,
		'menu_icon'         => 'dashicons-admin-page',
		'show_in_nav_menus' => true,
		'show_in_rest'      => false,
		'menu_position'     => 20,
		'supports'          => array(
			'title',
			'editor',
			'revisions',
			'thumbnail',
			'page-attributes',
		)
	);
	register_post_type( 'member-page', $args );
}

add_action( 'init', 'ssc_member_pages_init' );
