<?php
/**
 * Plugin Name:       Register Taxonomy
 * Plugin URI:        https://google.com/
 * Description:       adds taxonomy called Fruits
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
 
function register_taxonomy_fruits()
{
    $labels = [
        'name'              => _x('Fruits', 'taxonomy general name'),
'singular_name'     => _x('Fruit', 'taxonomy singular name'),
'search_items'      => __('Search Fruits'),
'all_items'         => __('All Fruits'),
'parent_item'       => __('Parent Fruit'),
'parent_item_colon' => __('Parent Fruit:'),
'edit_item'         => __('Edit Fruit'),
'update_item'       => __('Update Fruit'),
'add_new_item'      => __('Add New Fruit'),
'new_item_name'     => __('New Fruit Name'),
'menu_name'         => __('Fruit'),
];
$args = [
'hierarchical'      => true, // make it hierarchical (like categories)
'labels'            => $labels,
'show_ui'           => true,
'show_admin_column' => true,
'query_var'         => true,
'rewrite'           => ['slug' => 'fruits'],
];
register_taxonomy('fruits', ['post'], $args);
}
function register_new_terms() {
    $taxonomy = 'fruits';
    $terms = array (
        '0' => array (
            'name'          => 'Apple',
            'slug'          => 'apple',
            'description'   => 'This is a test term one',
        ),
        '1' => array (
            'name'          => 'Banana',
            'slug'          => 'banana',
            'description'   => 'This is a test term two',
        ),
        '2' => array (
            'name'          => 'Orange',
            'slug'          => 'orange',
            'description'   => 'This is a test term three',
        ),
    );  

    foreach ( $terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $taxonomy, 
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
        unset( $term ); 
    }

}
add_action('init', 'register_taxonomy_fruits');
add_action('init', 'register_new_terms');