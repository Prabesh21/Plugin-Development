<?php
/**
 * Plugin Name:       Admin Notice
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
function fn_to_call_transient() {
    set_transient( 'fn_to_set_transient', true, 5 );
}
function fn_admin_message(){

    /* Check transient, if available display notice */
    if( get_transient( 'fn_to_set_transient' ) ){
        ?>
        <div >
            <h2>Welcome to my plugin</h2>
        </div>
        <?php
        /* Delete transient, only display this notice once. */
        delete_transient( 'fn_to_set_transient' );
    }
}

//add_action( 'admin_notices', 'pluginprefix_activate' );
register_activation_hook( __FILE__, 'fn_to_call_transient' ); //callls fn_to_call_transient when plugin is activated.
add_action( 'admin_notices', 'fn_admin_message' ); //action hook for admin notice