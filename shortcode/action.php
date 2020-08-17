<?php
class Check{
    public static function fn_form(){
        if(isset($_POST['my_submit'])){
        $email = $_POST['email'];
        $password = $_POST['psw'];
        $repeat_password = $_POST['repeat-psw'];
        if ($password === $repeat_password){
            wp_insert_user($userdata= array(
                'user_pass'=> $password,
                'user_email' => $email,
            ));
        }
        else
            echo("Password Mismatched");
        }
    }
    
}
if (class_exists('Check'))
    Check::fn_form();
