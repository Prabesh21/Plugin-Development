<?php
/**
 * Plugin Name:       Task 1
 * Plugin URI:        https://google.com/
 * Description:       Gives a message on activation.
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
function pluginprefix_activate(){
    print_r("Task 1 completed");
}
add_action( 'admin_notices', 'pluginprefix_activate' );