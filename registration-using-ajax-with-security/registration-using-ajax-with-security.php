<?php
/**
 * Plugin Name:       Ajax
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       registration
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            intern
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 * 
 */
add_action('init','my_function_for_ajax');
  function my_function_for_ajax()
  {
    add_shortcode('ajax_form','registration_form');
    add_action('wp_enqueue_scripts', 'vb_register_user_scripts');
    add_action('wp_ajax_register_user_front_end', 'register_user_front_end_v');
    add_action('wp_ajax_nopriv_register_user_front_end', 'register_user_front_end_v');
  }
function registration_form(){
  ob_start();
    ?>
 <p class="register-message" style="display:none"></p>
    <form method="POST" name="register-form" class="register-form">
      <fieldset> 
          <label><i class="fa fa-file-text-o"></i> Register Form</label>
          <input type="text"  name="new_user_name" placeholder="Username" id="new-username">
          <input type="email"  name="new_user_email" placeholder="Email address" id="new-useremail">
          <input type="password"  name="new_user_password" placeholder="Password" id="new-userpassword">
          <?php wp_nonce_field('vb_new_user','vb_new_user_nonce', true, true ); ?>
          <input type="submit"  class="button" id="register-button" value="Register" >
      </fieldset>
    </form> 
<?php
return ob_get_clean();
}
function vb_register_user_scripts() {
    // Enqueue script
    wp_register_script('my_script', plugins_url() . '/registration-using-ajax-with-security/my.js', array('jquery'), '1.2.3', false);
    wp_enqueue_script('my_script');
     wp_localize_script( 'my_script', 'my_scripts', array(
           'my_ajax_url' => admin_url( 'admin-ajax.php' ),
         )
     );
    }
  function register_user_front_end_v() {
    // Verify nonce
    if( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'vb_new_user' ) )
      die( 'Ooops, something went wrong, please try again later.' );

    $new_user_name = sanitize_text_field(stripcslashes($_POST['new_user_name']));
    $new_user_email = sanitize_email(stripcslashes($_POST['new_user_email']));
    $new_user_password =sanitize_key($_POST['new_user_password']);
    $user_data = array(
        'user_login' => $new_user_name,
        'user_email' => $new_user_email,
        'user_pass' => $new_user_password,
        'role' => 'subscriber'
        );
        $result = array();
    $user_id = wp_insert_user($user_data);
        if (!is_wp_error($user_id)) {
          $result = array(
            'type' => 'success',
            'message'=> 'We have created an account',
          );
          wp_send_json_success($result);
        } else {
          if (isset($user_id->errors['empty_user_login'])) {
            $result = array(
              'type' => 'failure',
              'message' => 'username is empty!',
            );
            } elseif (isset($user_id->errors['existing_user_login'])) {
              $result = array(
                'type' => 'failure',
                'message' => 'username already exists!',
              );
            } else {
              $result = array(
                'type' => 'failure',
                'message' => 'error occured! ',
              );
            }
            wp_send_json_error($result);
        }
        error_log(print_r($result));
  

}