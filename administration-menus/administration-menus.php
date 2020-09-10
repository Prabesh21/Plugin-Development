<?php
/**
 * Plugin Name:       Adding Menu
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
abstract class AdminMenuAbs{    
    abstract public function create_menu();
    abstract protected static function abs_function();

}
class AdminMenu extends AdminMenuAbs{
   
    public function create_menu()
    {
        add_action("admin_menu", array($this, "add_my_custom_menu"));
    }
    public function add_my_custom_menu(){
        add_menu_page(
            __('customplugin','administration-menus'), // page title
            __('Movie', 'administration-menus'), // menu title
            "manage_options", // admin level
            "top-level-menu-slug",   // page slug
            array($this, "call_top_menu"), // callback function
            "dashicons-menu", //icon url
             80 //positions
            );
        add_submenu_page(
            "top-level-menu-slug", //parent slug
            __('Submenu1-title','administration-menus'), //page title
            __('Dashboard','administration-menus'), //menu title
            "manage_options", //capability = user_level_access
            "sub-menu1-slug", //menu slug
            array($this, "call_submenu1") //callback function
        );
        add_submenu_page(
            "top-level-menu-slug", //parent slug
            __('Submenu2-title','administration-menus'), //page title
            __('Settings','administration-menus'), //menu title
            "manage_options", //capability = user_level_access
            "sub-menu2-slug", //menu slug
            array($this, "call_submenu2") //callback function
        );
    }
    public static function call_top_menu(){
    
    }
    public function call_submenu1(){
        
    }
    public function call_submenu2(){
        }
    public static function abs_function(){
            _e('This is from abstract staic function', 'administration-menus');
        }
}
$obj = new AdminMenu();
$obj->create_menu();
AdminMenu::abs_function();


 
