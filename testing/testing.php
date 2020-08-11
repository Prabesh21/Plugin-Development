<?php
/**
 * Plugin Name:       Classes
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
if(file_exists( dirname(__FILE__).'C:\laragon\www\test\wp-includes\sodium_compat\autoload.php')){
    include_once dir(__FILE__).'C:\laragon\www\test\wp-includes\sodium_compat\autoload.php';
}
class Abcd{
    public $plugin;
    function __construct()
    {
        add_action('init', array($this, 'custom_post_type'));
        //$this->print_stuffpr();
        $this->plugin =  plugin_basename(__FILE__); 
    }
    public function register(){
        add_action('admin_enqueue_scripts', array($this, 'enqueue')); //this works only if object is initialized
        //add_action('admin_enqueue_scripts', array('Abcd', 'enqueue')); //this is for static function
        add_action('admin_menu', array($this, 'add_admin_pages'));
        //echo $this->plugin;
        add_filter("plugin_action_links_$this->plugin",array($this, 'settings_link'));
        
    }
    public function settings_link($links){
        //add custom setting links
        $settings_link = '<a href="options-general.php?page=top_menu">Settings</a>';
        array_push($links, $settings_link);
        return $links;

    }
    function add_admin_pages(){
        add_menu_page('Page title', 'Top Menu', 'manage_options', 'top_menu', array($this, 'admin_index'), 'dashicons-store', 101);
    }
    function admin_index(){
        include_once dirname( __FILE__ ).'/template/admin.php';
    }
    protected function print_stuff(){
        //var_dump('this is protected function and can be accessed by its class as well as child class');
    }
    private function print_stuffpr(){
        //var_dump('this is private function and can be accessed by its class only');
    }
    function uninstall(){
        
    }
    function custom_post_type(){
       register_post_type('wporg_product',
        array(
            'labels'      => array(
                'name'          => __( 'Products', 'textdomain' ),
                'singular_name' => __( 'Product', 'textdomain' ),
            ),
            'public'      => true,
            'has_archive' => true,
            'rewrite'     => array( 'slug' => 'products' ), // my custom slug
        )
    );
        
    }
    function activation(){
        include_once dirname( __FILE__ ).'/includes/plugin-activate.php';
        AbcdPluginActivate::activate();
    }
   function enqueue(){
        //enqueue all our scripts
        wp_enqueue_style('mypluginstyle', plugins_url('/assets/style.css', __FILE__));
        wp_enqueue_script('mypluginscript', plugins_url('/assets/myscripts.js', __FILE__));
    }
}
class SecondClass extends Abcd{
    function using_another_class(){
        $this->print_stuff();
    }
}
//$obj2 = new SecondClass();
//$obj2->using_another_class();
if(class_exists('Abcd')){
    $obj = new Abcd();    //initializing the class by creating object $obj
    $obj->register();
   //Abcd::register(); //for statically calling the functions
}
//activation
register_activation_hook(__FILE__, array($obj, 'activation'));
//register_activation_hook(__FILE__, array('AbcdPluginActivate', 'activation'));

//deactivation
include_once dirname( __FILE__ ).'/includes/plugin-deactivate.php';
//register_deactivation_hook(__FILE__, array($obj, 'deactivation'));
register_deactivation_hook(__FILE__, array('AbcdPluginDeactivate', 'deactivation'));
//register_uninstall_hook(__FILE__, array($obj, 'uninstall'));