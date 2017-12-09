<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Add a privacy setting to post pages
 *
 * @todo, make screen types configurable from a settings page
 */
function ssc_members_add_post_privacy_setting() {
	add_meta_box(
		'ssc_members_post_privacy', // id
		esc_html__( 'Members only' ), // title
		'ssc_members_render_post_privacy_box', // rendering callback
		'post', // which screen to display on
		'normal', // display context (normal, side, advanced)
		'default' // display priority (high, low, default)
	);
}

add_action( 'add_meta_boxes', 'ssc_members_add_post_privacy_setting' );

function ssc_members_render_post_privacy_box() {

	// @var WP_Post $post;
	global $post;

	$privacy_value = ssc_member_get_post_privacy_value( $post );

	wp_nonce_field( 'ssc_members_action', 'ssc_wpnonce' );
	?>
	<p>
		<input type="checkbox" id="ssc_members_post_privacy"
		       name="ssc_members_post_privacy" <?php echo checked( $privacy_value, 'on' ); ?> />
		<label for="ssc_members_post_privacy">Yes</label>
	</p>
	<?php
}


function ssc_members_meta_box_save( $post_id ) {

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	$retrieved_nonce = ! empty( $_POST['ssc_wpnonce'] ) ? $_POST['ssc_wpnonce'] : false;

	if ( ! wp_verify_nonce( $retrieved_nonce, 'ssc_members_action' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post' ) ) {
		return;
	}

	if ( ! empty( $_POST['ssc_members_post_privacy'] ) && $_POST['ssc_members_post_privacy'] !== 'on' ) {
		return;
	}
	$checkbox_value = ! empty( $_POST['ssc_members_post_privacy'] ) ? 'on' : false;

	if ( $checkbox_value ) {
		update_post_meta( $post_id, 'ssc_members_post_privacy', 'on' );
	} else {
		delete_post_meta( $post_id, 'ssc_members_post_privacy', 'on' ); // third arg could be removed.
	}
}

add_action( 'save_post', 'ssc_members_meta_box_save' );