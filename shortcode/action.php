<?php
class Check{
    public static function fn_form(){
        if(isset($_POST['my_submit'])){
            if ( ! isset( $_POST['djie3duhb3edub3u'] ) 
                || ! wp_verify_nonce( $_POST['djie3duhb3edub3u'], 'create_user_form_submit'));
            else{
                $username = $_POST['username'];    
                $email = $_POST['email'];
                $password = $_POST['psw'];
                $displayname = $_POST['displayname'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $role = $_POST['role'];
                $user_id = username_exists( $username );
                if ( !$user_id and email_exists($email) == false ) { 
                    $new_user_id = wp_insert_user(array(
                        'user_login'		=> $username,
                        'user_pass'	 		=> $password,
                        'user_email'		=> $email,
                        'first_name'		=> $firstname,
                        'last_name'			=> $lastname,
                        'user_registered'	=> date('Y-m-d H:i:s'),
                        'role'				=> $role,
                    )
                );
                 $content_post = get_post(get_the_ID());
                $content = $content_post->post_content;
                if ( ( has_shortcode( $content, 'my_registration_form' ))){
                   $var=  preg_match( '/' . get_shortcode_regex() . '/s', $content, $matches );
                   // Remove all html tags.
                     $escaped_atts_string = preg_replace( '/<[\/]{0,1}[^<>]*>/', '', $matches[3] );
                     $attributes   = shortcode_parse_atts( $escaped_atts_string );
                     $redirect_url = isset( $attributes['redirect_after_registration'] ) ? $attributes['redirect_after_registration'] : '';
                     $redirect_url = trim( $redirect_url, ']' );
                     $redirect_url = trim( $redirect_url, '"' );
                     $redirect_url = trim( $redirect_url, "'" );
                     error_log($redirect_url);
                    if (! empty( $redirect_url ) ) {
                        wp_safe_redirect($_SERVER['HTTP_HOST'].'/'. $redirect_url );
                        exit();
                    }
                }

            }
                    else {
                     return false; //username exists already
                 }
                }
            }
        }
    }
    

if (class_exists('Check'))
    Check::fn_form();
