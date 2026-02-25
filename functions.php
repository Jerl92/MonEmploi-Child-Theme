<?php

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

function my_custom_after_registration_action( $user_id, $args ) {
    if ( empty( $user_id ) || is_wp_error( $user_id ) ) {
        return;
    }
    
    // Check if the specific radio button field value exists in the submitted data
    $user = new WP_User( $user_id );
	$meta_for_user = get_user_meta( $user_id, 'Status', true ); 
	$meta_user_status = $meta_for_user[0];
	$statuts_value = sanitize_text_field( $meta_user_status );
	if($meta_user_status == 'Employeur'){    
		$user->set_role( 'um_employeur' );
	}
	if($meta_user_status == 'Employer'){ 
		$user->set_role( 'employer' );
	}
}
add_action( 'um_registration_set_extra_data', 'my_custom_after_registration_action', 10, 2 );

add_filter( 'login_url', 'um_custom_login_url', 10, 3 );
function um_custom_login_url( $login_url, $redirect, $force_reauth ) {
    return um_get_core_page( 'login' );
}

function auto_approve_all_comments( $approved, $commentdata ) {
    return 1;
}
add_filter( 'pre_comment_approved', 'auto_approve_all_comments', 99, 2 );

