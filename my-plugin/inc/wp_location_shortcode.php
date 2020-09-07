<?php
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );

//defines the functionality for the location shortcode
class wp_location_shortcode{
    //on initialize
public function __construct(){
    add_action('init', array($this,'register_location_shortcodes')); //shortcodes
}
public function register_location_shortcodes(){
    add_shortcode('wp_locations', array($this,'location_shortcode_output'));
}
//shortcode display
public function location_shortcode_output($atts, $content = '', $tag){

    //get the global wp_simple_locations class
    global $wp_simple_locations;
    $obj = new wp_simple_location();

    //build default arguments
    $arguments = shortcode_atts(array(
        'location_id' => '',
        'number_of_locations' => -1)
    ,$atts,$tag);

    //uses the main output function of the location class
    $html = $obj->get_locations_output($arguments);

    return $html;
}
}

$wp_location_shortcode = new wp_location_shortcode;