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
//add_action( 'admin_notices', 'pluginprefix_activate' );
register_activation_hook( __FILE__, 'fx_admin_notice_example_activation_hook' );

function fx_admin_notice_example_activation_hook() {
    set_transient( 'fx-admin-notice-example', true, 5 );
}

add_action( 'admin_notices', 'fx_admin_notice_example_notice' );

function fx_admin_notice_example_notice(){

    /* Check transient, if available display notice */
    if( get_transient( 'fx-admin-notice-example' ) ){
        ?>
        <div class="updated notice is-dismissible">
            <p>Thank you for using this plugin! <strong>You are awesome</strong>.</p>
        </div>
        <?php
        /* Delete transient, only display this notice once. */
        delete_transient( 'fx-admin-notice-example' );
    }
}