<?php
/**
 * Plugin Name:       Custom APi
 * Plugin URI:        https://google.com/
 * Description:       Adds new setting in WordPress Settings.
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
class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_init', array( $this, 'save_setting_details' ) );

    }
    public function save_setting_details(){
        if(isset($_POST['my_submit_button'])){
            $arr_op = array(
                'my_id_number'=> isset($_POST['my_id_number']) ? absint($_POST['my_id_number']): "Default",
                'my_title'=> isset($_POST['my_title']) ? sanitize_text_field($_POST['my_title']): "Default",
                //'my_checkbox'=> isset($_POST['my_checkbox']) ? sanitize_checkbox($_POST['checkbox']): "Default",
                'my_select'=> isset($_POST['my_select']) ? sanitize_text_field($_POST['my_select']): "Default",
                'my_textarea'=> isset($_POST['my_textarea']) ? sanitize_textarea_field($_POST['my_textarea']): "Default",
            );
            if(!empty($arr_op)){
                update_option('my_option_name', $arr_op);
            }
        }
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin', 
            'My Settings', 
            'manage_options', 
            'my-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <h1>My Settings</h1>
            <form method="post">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'my-setting-admin' );
            ?>
            <input type="submit" name="my_submit_button" value="Save"/>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
         add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'my-setting-admin' // Page
        );  

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title 
            array( $this, 'id_number_callback' ), // Callback
            'my-setting-admin', // Page
            'setting_section_id' // Section           
        );      

        add_settings_field(
            'title', 
            'Title', 
            array( $this, 'title_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );
        add_settings_field(
            'checkbox', 
            'Checkbox', 
            array( $this, 'checkbox_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );   
        add_settings_field(
            'textarea', 
            'Textarea', 
            array( $this, 'textarea_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );
        add_settings_field(
            'select', 
            'Select', 
            array( $this, 'select_callback' ), 
            'my-setting-admin', 
            'setting_section_id'
        );         
    }
    /** 
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="my_id_number" name="my_id_number" value="%s" />',
            isset( $this->options['my_id_number'] ) ? esc_attr( $this->options['my_id_number']) : ''
        );
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="my_title" name="my_title" value="%s" />',
            isset( $this->options['my_title'] ) ? esc_attr( $this->options['my_title']) : ''
        );
    }
    public function checkbox_callback(){
        printf(
            '<input type="checkbox" id="my_checkbox" name="my_checkbox" value="%s" />'.'Tick me',
            isset( $this->options['my_checkbox'] ) ? esc_attr( $this->options['my_checkbox']) : ''
        );
    }
    public function textarea_callback(){
        printf(
            '<textarea id="textarea" name="my_textarea" value="%s"></textarea>',
            isset( $this->options['my_textarea'] ) ? esc_attr( $this->options['my_textarea']) : ''
        );
    }
    public function select_callback(){
        printf(
            '<select id="my_select" name="my_select">
            <option value="select">  Select </option>
            <option value="male">    Male   </option>
            <option value="female">  Female </option>
            </select>',
            isset( $this->options['my_select'] ) ? esc_attr( $this->options['my_select']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();