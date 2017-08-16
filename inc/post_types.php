<?php

/**
 * Set up our member only pages.
 *
 * @see exclude_single_posts_home()
 */
function ssc_member_pages_init() {
	$args = array(
		'label'             => 'Member pages',
		'public'            => true,
		'show_ui'           => true,
		'capability_type'   => 'post',
		'hierarchical'      => false,
		'rewrite'           => array( 'slug' => 'members' ),
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
	register_post_type( 'member-pages', $args );
}

add_action( 'init', 'ssc_member_pages_init' );
