<?php
/**
 * Plugin Name:       Setting APi
 * Plugin URI:        https://google.com/
 * Description:       Addes menus and sub-menu on activation.
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
class SettingApi{
    function __construct()
    {

    }
    public function register(){
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_action( 'admin_init',array($this, 'eg_settings_api_init') );
    }
    function eg_settings_api_init() {
        add_settings_section('eg_setting_section', 'Setting Section using Setting Api', 'eg_setting_section_callback_function','reading');
        add_settings_field( 'eg_setting_name', 'Checkbox', 'eg_setting_callback_function', 'reading', 'eg_setting_section' );
        add_settings_field( 'eg_setting_name_radio', 'Radio Button', 'eg_setting_callback_function_radio', 'reading', 'eg_setting_section' );
        add_settings_field( 'eg_setting_name_textarea', 'Textarea', 'eg_setting_callback_function_textarea', 'reading', 'eg_setting_section' );
        add_settings_field( 'eg_setting_name_input', 'Input', 'eg_setting_callback_function_input', 'reading', 'eg_setting_section' );
        add_settings_field( 'eg_setting_name_dropdown', 'Dropdown', 'eg_setting_callback_function_dropdown', 'reading', 'eg_setting_section' );
       
        function eg_setting_section_callback_function() {
        echo '<p>Intro text for our settings section</p>';
    }
        
    function eg_setting_callback_function() {
        echo '<input name="eg_setting_name" id="eg_setting_name" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'eg_setting_name' ), false ) . ' /> Explanation text';
    }
    function eg_setting_callback_function_radio() {
        echo '<input name="eg_setting_name_radio" id="eg_setting_name_radio" type="radio" value="1" class="code" ' . checked( 1, get_option( 'eg_setting_name_radio' ), false ) . ' /> English';
        echo '<input name="eg_setting_name_radio" id="eg_setting_name_radio" type="radio" value="1" class="code" ' . checked( 2, get_option( 'eg_setting_name_radio' ), false ) . ' /> British';
    }
    function eg_setting_callback_function_textarea() {
        echo '<input type="textarea" name="eg_setting_name_textarea" id="eg_setting_name_textarea" value="Message" class="code"  rows="4"  cols="50"' . checked( 1, get_option( 'eg_setting_name_textarea' ), false ) . '/>';   
    }
    function eg_setting_callback_function_input() {
        echo '<input type="text" name="eg_setting_name_input" id="eg_setting_name_input" value="input" class="code"' . checked( 1, get_option( 'eg_setting_name_input' ), false ) . '/>';   
    }
    function eg_setting_callback_function_dropdown() {
        echo '<select name="eg_setting_name_dropdown" id="eg_setting_name_dropdown"  class="code"' . checked( 1, get_option( 'eg_setting_name_dropdown' ), false ) . '>'.'<option value="volvo">Volvo</option>
        <option value="saab">Saab</option>
        <option value="mercedes">Mercedes</option>
        <option value="audi">Audi</option>'.'/>';   
    }
        // Register our setting so that $_POST handling is done for us and
        // our callback function just has to echo the <input>
        register_setting( 'reading', 'eg_setting_name' );
        register_setting( 'reading', 'eg_setting_name_radio' );
        register_setting( 'reading', 'eg_setting_name_textarea' );
        register_setting( 'reading', 'eg_setting_name_input' );
        register_setting( 'reading', 'eg_setting_name_dropdown' );
    }
    function add_admin_pages(){
        add_menu_page('Page title', 'Top Menu', 'manage_options', 'top_menu', array($this, 'admin_index'), 'dashicons-store', 101);
    }
    function admin_index(){
        include_once dirname( __FILE__ ).'/template/admin.php';
    }
}
if(class_exists('SettingApi')){
    $obj = new SettingApi();    //initializing the class by creating object $obj
    $obj->register();
}