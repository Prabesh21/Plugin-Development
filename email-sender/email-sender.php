<?php
/**
 * Plugin Name:       Email Sender
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            John Smith
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
class EmailSend{
    function __construct()
    {
      add_action('admin_menu', array($this, 'menu_adder'));
      add_action( 'admin_init', array($this, 'save_setting_details' ));
      add_action("init", array($this, "fn_to_include_file"));
    }
    function menu_adder(){
      add_menu_page('Menu Title', 'Mailsender', 'manage_options', 'send-mail', array($this, 'fn_cb'));
      add_submenu_page( 'send-mail', 'Send Mail', 'Settings menu label', 'manage_options', 'email-slug', array($this, 'mail_cb'));
    }
    function fn_cb(){
          
    }
    function mail_cb(){
      ?>
      <div class="wrap">
          <h1>My Settings</h1>
          <form method="post">
          Send Email To: <input type="email" id="my_email" name="my_email" /><br>
          Message: <input type="text" id="my_message" name="my_message"  /><br>
          Subject: <input type="text" id="my_subject" name="my_subject"  /><br>
          <input type="submit" name="my_submit_button" value="Save"/>
          </form>
      </div>
      <?php
    }
    function save_setting_details(){
      if(isset($_POST['my_submit_button'])){
          $my_email= $_POST['my_email'];
          $my_subject = $_POST['my_subject'];
          $my_message= isset($_POST['my_message'])?apply_filters("custom_filter", $_POST['my_message']): 'Default'; 
          do_action("custom_action_for_sending_email", $my_email, $my_subject, $my_message);
      }
  }
  public function fn_to_include_file(){
    include_once dirname(__FILE__).'/action.php';
  }
}
new EmailSend();

  
   
  
  