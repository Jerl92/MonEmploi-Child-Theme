<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Enqueue parent stylesheet */
function deothemes_chichi_child_enqueue_styles() {
    wp_enqueue_style( 'deothemes-child-chichi-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );

}
add_action( 'wp_enqueue_scripts', 'deothemes_chichi_child_enqueue_styles' );

function my_custom_scripts() {
    wp_enqueue_script( 'monemploi', get_stylesheet_directory_uri() . '/js/monemploi.js', array( 'jquery'  ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'my_custom_scripts' );

function add_material_icons() {
    wp_enqueue_style( 'material-icons', 'https://fonts.googleapis.com/icon?family=Material+Icons', array(), '1.0.0' );
}
add_action( 'wp_enqueue_scripts', 'add_material_icons' );

function my_custom_menus() {
    register_nav_menus(
        array(
            'top-header-menu' => __( 'Top header menu' )
        )
    );
}
add_action( 'init', 'my_custom_menus' );

?>