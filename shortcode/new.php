<?php
if ( ( has_shortcode( $post_content, 'user_registration_login' ) || has_shortcode( $post_content, 'user_registration_my_account' ) ) && is_user_logged_in() ) {
		preg_match( '/' . get_shortcode_regex() . '/s', $post_content, $matches );
		// Remove all html tags.
		$escaped_atts_string = preg_replace( '/<[\/]{0,1}[^<>]*>/', '', $matches[3] );
		$attributes   = shortcode_parse_atts( $escaped_atts_string );
		$redirect_url = isset( $attributes['redirect_url'] ) ? $attributes['redirect_url'] : '';
		$redirect_url = trim( $redirect_url, ']' );
		$redirect_url = trim( $redirect_url, '"' );
		$redirect_url = trim( $redirect_url, "'" );
		if ( ! is_elementor_editing_page() && ! empty( $redirect_url ) ) {
			wp_redirect( $redirect_url );
			exit();
		}
	}