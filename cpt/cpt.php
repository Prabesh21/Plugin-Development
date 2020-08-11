<?php
/**
 * Plugin Name:       Custom Post Type
 * Plugin URI:        https://google.com/
 * Description:       Adds new CPT
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
function my_cpt() {
    $labels = array(
      'name'               => _x( 'Movies', 'post type general name' ),
      'singular_name'      => _x( 'Movie', 'post type singular name' ),
      'add_new'            => _x( 'Add New', 'movie' ),
      'add_new_item'       => __( 'Add New Movie' ),
      'edit_item'          => __( 'Edit Movie' ),
      'new_item'           => __( 'New Movie' ),
      'all_items'          => __( 'All Movies' ),
      'view_item'          => __( 'View Movie' ),
      'search_items'       => __( 'Search Movies' ),
      'not_found'          => __( 'No movies found' ),
      'not_found_in_trash' => __( 'No movies found in the Trash' ), 
      'menu_name'          => 'Movies'
    );
    $args = array(
      'labels'        => $labels,
      'description'   => 'Displays the detail about movies like release date, cast, director',
      'public'        => true,
      'menu_position' => 5,
      'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
      'has_archive'   => true,
    );
    register_post_type( 'movie', $args ); 
  }
  add_action( 'init', 'my_cpt' );
  add_action( 'add_meta_boxes', 'movie_metabox' );
function movie_metabox() {
    add_meta_box( 
        'movie_info', //Unique ID
        __( 'Movie Info', 'myplugin_textdomain' ),// Title
        'movie_info_cb',//Callback function
        'movie', //should be same as in register_post_type handle
        'side',
        'high'
    );
}
function movie_info_cb( $post ) {
    wp_nonce_field( plugin_basename( __FILE__ ), 'movie_content_nonce' );
    echo '<label for="movie_release_date"></label>';
    echo '<input type="date" id="movie_release_date" name="movie_release_date" placeholder="Movie Released Date" />';
    echo '<label for="movie_writer"></label>';
    echo '<input type="text" id="movie_writer" name="movie_writer" placeholder="Writer" />';
    echo '<label for="movie_cast"></label>';
    echo '<input type="text" id="movie_cast" name="movie_cast" placeholder="cast" />';
  }
  add_action( 'save_post', 'save_movie_details' );
function save_movie_details( $post_id ) {

  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
    return;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
    return;
  }
  $movie_details = array(
    'movie_writer'=> isset($_POST['movie_writer']) ? sanitize_text_field($_POST['movie_writer']): "Default",
    'movie_cast'=> isset($_POST['movie_cast']) ? sanitize_text_field($_POST['movie_cast']): "Default",
    'movie_release_date'=> isset($_POST['movie_release_date']) ? sanitize_text_field($_POST['movie_release_date']): "Default",
  );
  update_post_meta( $post_id, 'movie_writer', $movie_details );
}
  
  