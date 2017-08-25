<?php

/**
 * @param $atts
 * @param null $content
 *
 * [ssc-member email="example@example.com" ]Mr Example[/ssc-member]
 * 
 * @return string
 */
function ssc_members_name_email_shortcode( $args, $content = null ) {

	if(!is_user_logged_in()){
		return sprintf('%s %s', esc_html($content), esc_html__('(email hidden)'));
	}

	$atts =  shortcode_atts( array(
		'email' => null,
	), $args );

	$email = $atts['email'];

	if(!empty($email) && !is_email($email)){
		return sprintf('%s <span style="color: red">%s</span>', esc_html($content), esc_html__('[invalid mail address])'));
	} else {
		$email = esc_html($email);
		return sprintf('%s (<a href="mailto:%s" target="_top">%s</a>)', esc_html($content), $email, $email);
	}
}
add_shortcode('ssc-member', 'ssc_members_name_email_shortcode');
