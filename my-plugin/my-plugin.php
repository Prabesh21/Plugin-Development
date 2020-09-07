<?php
/*
Plugin Name: My Plugin
Plugin URI:  https://myplugin.com/
Description: Creates an interfaces to manage store / business locations on your website. Useful for showing location based information quickly. Includes both a widget and shortcode for ease of use.
Version:     1.0.0
Author:      Prabesh Upreti
Author URI:  http://pu.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

class wp_simple_location{
    //properties
private $wp_location_trading_hour_days = array();
//magic function (triggered on initialization)
public function __construct(){

    add_action('init', array($this,'set_location_trading_hour_days')); //sets the default trading hour days (used by the content type)
    add_action('init', array($this,'register_location_content_type')); //register location content type
    add_action('add_meta_boxes', array($this,'add_location_meta_boxes')); //add meta boxes
    add_action('save_post_wp_locations', array($this,'save_location')); //save location
    add_action('admin_enqueue_scripts', array($this,'enqueue_admin_scripts_and_styles')); //admin scripts and styles
    add_action('wp_enqueue_scripts', array($this,'enqueue_public_scripts_and_styles')); //public scripts and styles
    add_filter('the_content', array($this,'prepend_location_meta_to_content')); //gets our meta data and dispayed it before the content

    register_activation_hook(__FILE__, array($this,'plugin_activate')); //activate hook
    register_deactivation_hook(__FILE__, array($this,'plugin_deactivate')); //deactivate hook

}
//set the default trading hour days (used in our admin backend)
public function set_location_trading_hour_days(){

    //set the default days to use for the trading hours
    $this->wp_location_trading_hour_days = apply_filters('wp_location_trading_hours_days', 
        array('monday' => 'Monday',
              'tuesday' => 'Tuesday',
              'wednesday' => 'Wednesday',
              'thursday' => 'Thursday',
              'friday' => 'Friday',
              'saturday' => 'Saturday',
              'sunday' => 'Sunday',
        )
    );      
}
//register the location content type
public function register_location_content_type(){
    //Labels for post type
    $labels = array(
          'name'               => __('Location', 'my-plugin'),
          'singular_name'      => __('Location', 'my-plugin'),
          'menu_name'          => __('Locations','my-plugin'),
          'name_admin_bar'     => __('Location','my-plugin'),
          'add_new'            => __('Add New', 'my-plugin'),
          'add_new_item'       => __('Add New Location','my-plugin'),
          'new_item'           => __('New Location', 'my-plugin'),
          'edit_item'          => __('Edit Location','my-plugin'),
          'view_item'          => __('View Location','my-plugin'),
          'all_items'          => __('All Locations','my-plugin'),
          'search_items'       => __('Search Locations','my-plugin'),
          'parent_item_colon'  => __('Parent Location:', 'my-plugin'),
          'not_found'          => __('No Locations found.', 'my-plugin'),
          'not_found_in_trash' => __('No Locations found in Trash.','my-plugin'),
      );
      //arguments for post type
      $args = array(
          'labels'            => $labels,
          'public'            => true,
          'publicly_queryable'=> true,
          'show_ui'           => true,
          'show_in_nav'       => true,
          'query_var'         => true,
          'hierarchical'      => false,
          'supports'          => array('title','thumbnail','editor'),
          'has_archive'       => true,
          'menu_position'     => 20,
          'show_in_admin_bar' => true,
          'menu_icon'         => 'dashicons-location-alt',
          'rewrite'            => array('slug' => 'locations', 'with_front' => 'true')
      );
      //register post type
      register_post_type('wp_locations', $args);
}
//adding meta boxes for the location content type*/
public function add_location_meta_boxes(){

    add_meta_box(
        'wp_location_meta_box', //id
        __('Location Information','my-plugin'), //name
        array($this,'location_meta_box_display'), //display function
        'wp_locations', //post type
        'normal', //location
        'default' //priority
    );
}
//display function used for our custom location meta box*/
public function location_meta_box_display($post){

    //set nonce field
    wp_nonce_field('wp_location_nonce', 'wp_location_nonce_field');

    //collect variables
    $wp_location_phone = get_post_meta($post->ID,'wp_location_phone',true);
    $wp_location_email = get_post_meta($post->ID,'wp_location_email',true);
    $wp_location_address = get_post_meta($post->ID,'wp_location_address',true);

    ?>
    <p><?php esc_html_e('Enter additional information about your location', 'my-plugin') ?> </p>
    <div class="field-container">
        <?php 
        //before main form elementst hook
        do_action('wp_location_admin_form_start'); 
        ?>
        <div class="field">
            <label for="<?php esc_attr_e('wp_location_phone', 'my-plugin') ?>"><?php esc_html_e('Contact Phone', 'my-plugin') ?></label>
            <small><?php esc_html_e('main contact number', 'my-plugin') ?></small>
            <input type="tel" name="<?php esc_attr_e('wp_location_phone', 'my-plugin') ?>" id="<?php esc_attr_e('wp_location_phone', 'my-plugin') ?>" value="<?php  esc_html_e($wp_location_phone, 'my-plugin');?>"/>
        </div>
        <div class="field">
            <label for="<?php esc_attr_e('wp_location_email', 'my-plugin') ?>"><?php esc_html_e('Contact Email', 'my-plugin') ?></label>
            <small><?php esc_html_e('Email contact', 'my-plugin') ?></small>
            <input type="email" name="<?php esc_attr_e('wp_location_email', 'my-plugin') ?>" id="<?php esc_attr_e('wp_location_email', 'my-plugin') ?>" value="<?php esc_html_e($wp_location_email, 'my-plugin');?>"/>
        </div>
        <div class="field">
            <label for="<?php esc_attr_e('wp_location_address', 'my-plugin') ?>"><?php esc_html_e('Address', 'my-plugin') ?></label>
            <small><?php esc_html_e('Physical address of your location', 'my-plugin') ?></small>
            <textarea name="<?php esc_attr_e('wp_location_address', 'my-plugin') ?>" id="<?php esc_attr_e('wp_location_address', 'my-plugin') ?>"><?php esc_html_e($wp_location_address, 'my-plugin');?></textarea>
        </div>
        <?php
        //trading hours
        if(!empty($this->wp_location_trading_hour_days)){
            echo '<div class="field">';
                 '<label>'.esc_html_e('Trading Hours', 'my-plugin') .'</label>';
                 '<small>'.esc_html_e(' for the location (e.g 9am - 5pm) ', 'my-plugin') .'</small>';
                //go through all of our registered trading hour days
                foreach($this->wp_location_trading_hour_days as $day_key => $day_value){
                    //collect trading hour meta data
                    $wp_location_trading_hour_value =  get_post_meta($post->ID,'wp_location_trading_hours_' . $day_key, true);
                    //dsiplay label and input
                    
                    echo '<label for="'.sprintf( esc_attr__( 'wp_location_trading_hours_%s', 'my-plugin' ), $day_key ).'">' . esc_html_e($day_key, 'my-plugin') . '</label>';
                    echo '<input type="text" name="'.sprintf(esc_attr__('wp_location_trading_hours_%s', 'my-plugin'),$day_key ). '" id="'.sprintf(esc_attr__('wp_location_trading_hours_%s', 'my-plugin'), $day_key). '" value="' . esc_html__($wp_location_trading_hour_value, 'my-plugin') . '"/>';
                }
            echo '</div>';
        }       
        ?>
    <?php 
    //after main form elementst hook
    do_action('wp_location_admin_form_end'); 
    ?>
    </div>
    <?php

}
//triggered on activation of the plugin (called only once)
public function plugin_activate(){  
    //call our custom content type function
    $this->register_location_content_type();
    //flush permalinks
    flush_rewrite_rules();
}
//trigered on deactivation of the plugin (called only once)
public function plugin_deactivate(){
    //flush permalinks
    flush_rewrite_rules();
}
public function prepend_location_meta_to_content($content){

    global $post, $post_type;

    //display meta only on our locations (and if its a single location)
    if($post_type == 'wp_locations' && is_singular('wp_locations')){

        //collect variables
        $wp_location_id = $post->ID;
        $wp_location_phone = get_post_meta($post->ID,'wp_location_phone',true);
        $wp_location_email = get_post_meta($post->ID,'wp_location_email',true);
        $wp_location_address = get_post_meta($post->ID,'wp_location_address',true);

        //display
        $html = '';

        $html .= '<section class="meta-data">';

        //hook for outputting additional meta data (at the start of the form)
        do_action('wp_location_meta_data_output_start',$wp_location_id);

        $html .= '<p>';
        //phone
        if(!empty($wp_location_phone)){
            $html .= '<b>'.esc_html__('Location Phone', 'my-plugin').'</b> ' . esc_html__($wp_location_phone, 'my-plugin') . '</br>';
        }
        //email
        if(!empty($wp_location_email)){
            $html .= '<b>'.esc_html__('Location Email', 'my-plugin').'</b> ' . esc_html__($wp_location_email, 'my-plugin') . '</br>';
        }
        //address
        if(!empty($wp_location_address)){
            $html .= '<b>'.esc_html__('Location Address', 'my-plugin').'</b> ' .esc_html__( $wp_location_address, 'my-plugin') . '</br>';
        }
        $html .= '</p>';

        //location
        if(!empty($this->wp_location_trading_hour_days)){
            $html .= '<p>';
            $html .= '<b>'.esc_html__('Location Trading Hours', 'my-plugin').' </b></br>';
            foreach($this->wp_location_trading_hour_days as $day_key => $day_value){
                $trading_hours = get_post_meta($post->ID, 'wp_location_trading_hours_' . $day_key , true);
                $html .= '<span class="day">' .esc_html__(  $day_key, 'my-plugin')  . '</span><span class="hours">' . esc_html__( $trading_hours, 'my-plugin')  . '</span></br>';
            }
            $html .= '</p>';
        }

        //hook for outputting additional meta data (at the end of the form)
        do_action('wp_location_meta_data_output_end',$wp_location_id);

        $html .= '</section>';
        $html .= $content;

        return $html;  


    }else{
        return $content;
    }

}
//main function for displaying locations (used for our shortcodes and widgets)
public function get_locations_output($arguments = ""){

    //default args
    $default_args = array(
        'location_id'   => '',
        'number_of_locations'   => -1
    );

    //update default args if we passed in new args
    if(!empty($arguments) && is_array($arguments)){
        //go through each supplied argument
        foreach($arguments as $arg_key => $arg_val){
            //if this argument exists in our default argument, update its value
            if(array_key_exists($arg_key, $default_args)){
                $default_args[$arg_key] = $arg_val;
            }
        }
    }

    //find locations
    $location_args = array(
        'post_type'     => 'wp_locations',
        'posts_per_page'=> $default_args['number_of_locations'],
        'post_status'   => 'publish'
    );
    //if we passed in a single location to display
    if(!empty($default_args['location_id'])){
        $location_args['include'] = $default_args['location_id'];
    }

    //output
    $html = '';
    $locations = get_posts($location_args);
    //if we have locations 
    if($locations){
        $html .= '<article class="location_list cf">';
        //foreach location
        foreach($locations as $location){
            $html .= '<section class="location">';
                //collect location data
                $wp_location_id = $location->ID;
                $wp_location_title = get_the_title($wp_location_id);
                $wp_location_thumbnail = get_the_post_thumbnail($wp_location_id,'thumbnail');
                $wp_location_content = apply_filters('the_content', $location->post_content);
                if(!empty($wp_location_content)){
                    $wp_location_content = strip_shortcodes(wp_trim_words($wp_location_content, 40, '...'));
                }
                $wp_location_permalink = get_permalink($wp_location_id);
                $wp_location_phone = get_post_meta($wp_location_id,'wp_location_phone',true);
                $wp_location_email = get_post_meta($wp_location_id,'wp_location_email',true);

                //apply the filter before our main content starts 
                //(lets third parties hook into the HTML output to output data)
                $html = apply_filters('wp_location_before_main_content', $html);

                //title
                $html .= '<h2 class="title">';
                    $html .= '<a href="' . esc_html__($wp_location_permalink, 'my-plugin') . '" title="view location">';
                        $html .= esc_html__($wp_location_title, 'my-plugin');
                    $html .= '</a>';
                $html .= '</h2>';


                //image & content
                if(!empty($wp_location_thumbnail) || !empty($wp_location_content)){

                    $html .= '<p class="image_content">';
                    if(!empty($wp_location_thumbnail)){
                        $html .= esc_html__($wp_location_thumbnail, 'my-plugin');
                    }
                    if(!empty($wp_location_content)){
                        $html .= esc_html__( $wp_location_content, 'my-plugin');
                    }

                    $html .= '</p>';
                }

                //phone & email output
                if(!empty($wp_location_phone) || !empty($wp_location_email)){
                    $html .= '<p class="phone_email">';
                    if(!empty($wp_location_phone)){
                        $html .= '<b>Phone: </b>' .esc_html__( $wp_location_phone, 'my-plugin') . '</br>';
                    }
                    if(!empty($wp_location_email)){
                        $html .= '<b>Email: </b>' . esc_html__($wp_location_email, 'my-plugin');
                    }
                    $html .= '</p>';
                }

                //apply the filter after the main content, before it ends 
                //(lets third parties hook into the HTML output to output data)
                $html = apply_filters('wp_location_after_main_content', $html);

                //readmore
                $html .= '<a class="link" href="' . esc_html__($wp_location_permalink, 'my-plugin') . '" title="view location">View Location</a>';
            $html .= '</section>';
        }
        $html .= '</article>';
        $html .= '<div class="cf"></div>';
    }

    return $html;
}
//triggered when adding or editing a location
public function save_location($post_id){

    //check for nonce
    if(!isset($_POST['wp_location_nonce_field'])){
        return $post_id;
    }   
    //verify nonce
    if(!wp_verify_nonce($_POST['wp_location_nonce_field'], 'wp_location_nonce')){
        return $post_id;
    }
    //check for autosave
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
        return $post_id;
    }

    //get our phone, email and address fields
    $wp_location_phone = isset($_POST['wp_location_phone']) ? sanitize_text_field($_POST['wp_location_phone']) : '';
    $wp_location_email = isset($_POST['wp_location_email']) ? sanitize_text_field($_POST['wp_location_email']) : '';
    $wp_location_address = isset($_POST['wp_location_address']) ? sanitize_text_field($_POST['wp_location_address']) : '';

    //update phone, memil and address fields
    update_post_meta($post_id, 'wp_location_phone', $wp_location_phone);
    update_post_meta($post_id, 'wp_location_email', $wp_location_email);
    update_post_meta($post_id, 'wp_location_address', $wp_location_address);

    //search for our trading hour data and update
    foreach($_POST as $key => $value){
        //if we found our trading hour data, update it
        if(preg_match('/^wp_location_trading_hours_/', $key)){
            update_post_meta($post_id, $key, $value);
        }
    }

    //location save hook 
    //used so you can hook here and save additional post fields added via 'wp_location_meta_data_output_end' or 'wp_location_meta_data_output_end'
    do_action('wp_location_admin_save',$post_id, $_POST);

}
//enqueus scripts and stles on the back end
public function enqueue_admin_scripts_and_styles(){
    wp_enqueue_style('wp_location_admin_styles', plugin_dir_url(__FILE__) . '/css/wp_location_admin_styles.css');
}

//enqueues scripts and styled on the front end
public function enqueue_public_scripts_and_styles(){
    wp_enqueue_style('wp_location_public_styles', plugin_dir_url(__FILE__). '/css/wp_location_public_styles.css');

}
}
new wp_simple_location();
//include shortcodes
include(plugin_dir_path(__FILE__) . 'inc/wp_location_shortcode.php');
//include widgets
include(plugin_dir_path(__FILE__) . 'inc/wp_location_widget.php');