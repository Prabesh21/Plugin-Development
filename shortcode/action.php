<?php
class Check{
    public static function fn_form($link){
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
                error_log($link);
                wp_redirect($link);
                exit(); 
                    } 
                    else {
                     return false; //username exists already
                 }
                }
            }
        }
    }
    

if (class_exists('Check'))
    Check::fn_form($link);
