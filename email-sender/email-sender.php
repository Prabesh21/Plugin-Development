<?php
/**
 * Plugin Name:       Email Sender
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Prabesh Upreti
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       email-sender
 * Domain Path:       /languages
 */

interface EmailSending{
  public function fn_to_include_file();

}
class EmailSend implements EmailSending{
    function __construct()
    {
      add_action('admin_menu', array($this, 'menu_adder'));
      add_action( 'admin_init', array($this, 'save_setting_details' ));
      //add_action("init", array($this, "fn_to_include_file"));
    }
    function menu_adder(){
      add_menu_page(__('Menu Title','email-sender'), __('Mailsender','email-sender'), 'manage_options', 'send-mail', array($this, 'fn_cb'));
      add_submenu_page( 'send-mail', __('Send Mail','email-sender'), __('Settings menu label','email-sender'), 'manage_options', 'email-slug', array($this, 'mail_cb'));
    }
    function fn_cb(){
          
    }
    function mail_cb(){
      
      ?>
      <div class="wrap">
          <h1><?php esc_html_e('My Settings', 'email-seder') ?></h1>
          <form method="post">
          <?php esc_html_e('Send Email To', 'email-seder') ?>: <input type="email" id="my_email" name="my_email" /><br>
          <?php esc_html_e('Message:', 'email-seder') ?> <input type="text" id="my_message" name="my_message"  /><br>
          <?php esc_html_e('Subject:', 'email-seder') ?> <input type="text" id="my_subject" name="my_subject"  /><br>
          <input type="submit" name="my_submit_button" value="<?php esc_html_e('save', 'email-sender')?>"/>
          </form>
      </div>
      <?php
    }
    public function save_setting_details(){
      if(isset($_POST['my_submit_button'])){
          $my_email= sanitize_email($_POST['my_email']);
          $my_subject = sanitize_text_field($_POST['my_subject']);
          $my_message= isset($_POST['my_message'])?sanitize_text_field(apply_filters("custom_filter", $_POST['my_message'])): 'Default'; 
          do_action("custom_action_for_sending_email", $my_email, $my_subject, $my_message);
      }
  }
  public function fn_to_include_file(){
    include_once dirname(__FILE__).'/action.php';
  }
  
}
$obj = new EmailSend();
$obj->fn_to_include_file();



  
   
  
  