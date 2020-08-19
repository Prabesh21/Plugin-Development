<?php
add_action( 'add_meta_boxes', 'add_post_meta_boxes_page' );
add_action( 'save_post', 'save_movie_details_page');
/* Create one or more meta boxes to be displayed on the post editor screen. */
function add_post_meta_boxes_page() {

  add_meta_box(
    'post-class',      // Unique ID
    esc_html__( 'Post Class', 'example' ),    // Title
    'post_class_meta_box_page',   // Callback function
    'page',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
}
function post_class_meta_box_page( $post ) {
  $var = get_post_meta( $post->ID, 'my_meta_details_page');
  wp_nonce_field( plugin_basename( __FILE__ ), 'movie_content_nonce' );
 echo '<label for="my_textbox_page"></label>';
 echo '<input type="text" id="my_textbox_page" value="'. $var['0']['my_textbox_page'] .'" name="my_textbox_page" placeholder="enter text" />';
 echo '<textarea  id="my_textarea_page" value="" name="my_textarea_page" >'. $var['0']['my_textarea_page'] .'</textarea>';
 $options = array(
  'male' => 'Male',
  'female' => 'Femalee',
);
printf( '<select id="my_select_page" name="my_select_page">' );
printf( '<option> -- Select -- </option>' );
foreach ( $options as $option_value => $option_label ) {
  printf(
      '<option value="%s" %s >%s</option>',
      $option_value,
      $var['0']['my_select_page'] === $option_value ? 'selected' : '',
      $option_label
  );
}
printf( '</select>' );
}
function save_movie_details_page( $post_id ) {
  $movie_details = array(
    'my_textbox_page'=> isset($_POST['my_textbox_page']) ? sanitize_text_field($_POST['my_textbox_page']): "Default",
    'my_textarea_page'=> isset($_POST['my_textarea_page']) ? sanitize_text_field($_POST['my_textarea_page']): "Default",
    'my_select_page'=> isset($_POST['my_select_page']) ? sanitize_text_field($_POST['my_select_page']): "Default",
    );
  update_post_meta( $post_id, 'my_meta_details_page', $movie_details );
}
