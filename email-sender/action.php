<?php
class EmailUsingHook{
    public function __construct()
    {
        add_action("custom_action_for_sending_email", array($this, 'fn_to_send_email'), 10, 3);
        add_filter("custom_filter", array($this, "fn_to_filter"), 10, 1);
    }
     function fn_to_send_email($my_email, $my_subject, $my_message){
        
        wp_mail($my_email, $my_subject, $my_message);
    }
     function fn_to_filter($my_message){
        return $my_message .= "This is added by filter";
    }

}
new EmailUsingHook();