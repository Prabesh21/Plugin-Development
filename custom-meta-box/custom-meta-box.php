<?php
/**
 * Plugin Name:       Custom Meta Box
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       adds custom meta box.
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
add_action( 'add_meta_boxes', 'add_post_meta_boxes' );
add_action( 'save_post', 'save_movie_details');
add_action( 'comment_form_before', 'fn_template_for_metabox');
function fn_template_for_metabox(){
  $var = get_post_meta( get_the_ID(), 'my_meta_details');
  $textbox = isset($var['0']['my_textbox'])? $var['0']['my_textbox']:'';
  $select = isset($var['0']['my_select'])? $var['0']['my_select']:'';
  $textarea = isset($var['0']['my_textarea'])? $var['0']['my_textarea']:'';
  echo '<table>';
  echo '<tr>';
  echo '<td>Textbox</td>';
  echo '<td>'.$textbox.'</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>TextArea</td>';
  echo '<td>'.$textarea.'</td>';
  echo '</tr>';
  echo '<tr>';
  echo '<td>Select</td>';
  echo '<td>'.$select.'</td>';
  echo '</tr>';
  echo '</table>';

}
/* Create one or more meta boxes to be displayed on the post editor screen. */
function add_post_meta_boxes() {

  add_meta_box(
    'post-class',      // Unique ID
    esc_html__( 'Post Class', 'example' ),    // Title
    'post_class_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
}
function post_class_meta_box( $post ) {
  $var = get_post_meta( $post->ID, 'my_meta_details');
  wp_nonce_field( plugin_basename( __FILE__ ), 'movie_content_nonce' );
 echo '<label for="my_textbox"></label>';
 echo '<input type="text" id="my_textbox" value="'. $var['0']['my_textbox'] .'" name="my_textbox" placeholder="enter text" />';
 echo '<textarea  id="my_textarea" value="" name="my_textarea" >'. $var['0']['my_textarea'] .'</textarea>';
 $options = array(
  'male' => 'Male',
  'female' => 'Femalee',
);
printf( '<select id="my_select" name="my_select">' );
printf( '<option> -- Select -- </option>' );
foreach ( $options as $option_value => $option_label ) {
  printf(
      '<option value="%s" %s >%s</option>',
      $option_value,
      $var['0']['my_select'] === $option_value ? 'selected' : '',
      $option_label
  );
}
printf( '</select>' );
}
function save_movie_details( $post_id ) {
  $movie_details = array(
    'my_textbox'=> isset($_POST['my_textbox']) ? sanitize_text_field($_POST['my_textbox']): "Default",
    'my_textarea'=> isset($_POST['my_textarea']) ? sanitize_text_field($_POST['my_textarea']): "Default",
    'my_select'=> isset($_POST['my_select']) ? sanitize_text_field($_POST['my_select']): "Default",
    );
  update_post_meta( $post_id, 'my_meta_details', $movie_details );
}
include_once dirname(__FILE__).'/custom_meta_box_page.php';