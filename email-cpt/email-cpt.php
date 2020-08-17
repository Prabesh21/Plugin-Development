<?php
/**
 * Plugin Name:       Email-CPT
 * Plugin URI:        https://google.com/
 * Description:       Sends email using cpt, action hook and filter hook
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Intern
 * Author URI:        https://wordpress.org/
 * License:           GPL v2 or later
 * License URI:       https://stackoverflow.com/
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */
defined('ABSPATH') or die();
class EmailCpt{
    function __construct()
    {
      include_once dirname( __FILE__ ) . '/hooks.php';
        add_filter( 'the_content', array($this, 'filter_the_content_in_the_main_loop'));
    }
    public function my_cpt() {
        $labels = array(
          'name'               => _x( 'Menu Test Email', 'post type general name' ),
          'singular_name'      => _x( 'Email', 'post type singular name' ),
          'add_new'            => _x( 'Add New', 'email' ),
          'add_new_item'       => __( 'Add New Email' ),
          'edit_item'          => __( 'Edit Email' ),
          'new_item'           => __( 'New Email' ),
          'all_items'          => __( 'All Emails' ),
          'view_item'          => __( 'View Email' ),
          'search_items'       => __( 'Search Emails' ),
          'not_found'          => __( 'No emails found' ),
          'not_found_in_trash' => __( 'No emails found in the Trash' ), 
          'menu_name'          => 'Menu Test Email'
        );
        $args = array(
          'labels'        => $labels,
          'description'   => 'Displays the detail about movies like release date, cast, director',
          'public'        => true,
          'menu_position' => 5,
          'supports'      => array( 'title', 'editor', 'excerpt'),
          'has_archive'   => true,
        );
        register_post_type( 'email', $args ); 
      }
      function save_movie_details( ) {
        global $wpdb;
        $post_id = get_the_ID();
        $email = $wpdb->get_var("SELECT post_title FROM $wpdb->posts WHERE post_status = 'publish'AND ID = $post_id AND post_type='email'");
        $message = $wpdb->get_var("SELECT post_content FROM $wpdb->posts WHERE post_status = 'publish'AND ID = $post_id AND post_type='email'");
        $subject = $wpdb->get_var("SELECT post_excerpt FROM $wpdb->posts WHERE post_status = 'publish'AND ID = $post_id AND post_type='email'");
       
        wp_mail( $email, $subject, $message );
      }
      function filter_the_content_in_the_main_loop( $content ) {
            return $content . 'Filter added';
    }
    
}
new EmailCpt();