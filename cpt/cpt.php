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
        'movie_info',
        __( 'Movie Info', 'myplugin_textdomain' ),
        'movie_info_cb',
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
  
  