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
function add_my_custom_menu(){
    add_menu_page(
        "customplugin", // page title
        "Movie", // menu title
        "manage_options", // admin level
        "top-level-menu-slug",   // page slug
        "call_top_menu", // callback function
        "dashicons-menu", //icon url
         80 //positions
        );
    add_submenu_page(
        "top-level-menu-slug", //parent slug
        "Submenu1-title", //page title
        "Dashboard", //menu title
        "manage_options", //capability = user_level_access
        "sub-menu1-slug", //menu slug
        "call_submenu1" //callback function
    );
    add_submenu_page(
        "top-level-menu-slug", //parent slug
        "Submenu2-title", //page title
        "Settings", //menu title
        "manage_options", //capability = user_level_access
        "sub-menu2-slug", //menu slug
        "call_submenu2" //callback function
    );
}
function call_top_menu(){
    
}
function call_submenu1(){
    
}
function call_submenu2(){
    }
 add_action("admin_menu", "add_my_custom_menu");
