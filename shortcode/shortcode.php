<?php
/**
 * Plugin Name:       Registration form
 * Plugin URI:        https://google.com/
 * Description:       form using shortcode
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
class UsingShortcode{
    function __construct()
    {
      add_shortcode("my_registration_form", array($this, 'fn_reg_form'));
    }

    public function fn_reg_form($atts = [], $content = null, $tag = ''){
        $atts = array_change_key_case( (array) $atts, CASE_LOWER );
        $wporg_atts = shortcode_atts(
            array(
                'redirect_after_registration' => 'https://basic.pm/sample-page',
            ), $atts, $tag
        );
    $link = $wporg_atts['redirect_after_registration'];
    include_once dirname(__FILE__).'/form.php';       
    }
}
new UsingShortcode();