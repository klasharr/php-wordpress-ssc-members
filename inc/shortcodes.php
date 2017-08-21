<?php

/**
 * @param $atts
 * @param null $content
 *
 * [ssc-member email="example@example.com" ]Mr Example[/ssc-member]
 * 
 * @return string
 */
function ssc_members_name_email_shortcode( $atts, $content = null ) {

	extract( shortcode_atts( array(
		'email' => null,
	), $atts ) );

	if(!is_user_logged_in()){
		return sprintf('%s %s', $content, esc_html__('(email hidden)'));
	}

	if(!empty($email) && !is_email($email)){
		return sprintf('%s <span style="color: red">%s</span>', $content, esc_html__('[invalid mail address])'));
	} else {
		return sprintf('%s (<a href="mailto:%s" target="_top">%s</a>)', $content, $email, $email);
	}
}
add_shortcode('ssc-member', 'ssc_members_name_email_shortcode');
