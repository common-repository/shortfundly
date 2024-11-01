<?php

/*
 *	Plugin Name: Shortfundly Plugin
 *	Plugin URI: https://wordpress.org/shortfundly-plugin
 *	Description: Provides both widgets and shortcodes to help  display top rated films  on your website.
 *	Version: 1.0
 *	Author: Shortfundly
 *	Author URI: http:www.shortfundly.com
 *	License: GPL2
 *
*/

//$plugin_url = WP_PLUGIN_URL . '/shortfundly-plugin';
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$options = array();
$page_n = 1;
$err = 1; 

function shortfundly_plugin_menu() {
    
        /*
         * 	Use the add_options_page function
         * 	add_options_page( $page_title, $menu_title, $capability, $menu-slug, $function ) 
         *
        */
    
        add_options_page(
            'Shortfundly Plugin',
            'Top Rated Films',
            'manage_options',
            'shortfundly_plugin',
            'shortfundly_plugin_options_page'
        );
    
    }
    add_action( 'admin_menu', 'shortfundly_plugin_menu' );
    
/* 
 *  This function is called when you open the setting's page 
*/

function shortfundly_plugin_options_page() {
    
    if(!current_user_can( 'manage_options' ) ) {

        
    wp_die( 'You do not have suggicient permissions to access this page.' );}
    

    /* for images to display use src="<?php echo $plugin_url . '/images/name.png'; ?>"*/
    global $options;

    if( isset( $_POST['shortfundly_form_submitted1'] ) ) {


        if(wp_verify_nonce($_POST['shortfundly_form_submitted1'], 'shortfundly_form_submitted1')) {

        //$hidden_field =sanitize_text_field($_POST['shortfundly_form_submitted']);
        //update_post_meta($post->ID, 'shortfundly_form_submitted', $hidden_field);

        //$hidden_field = esc_html( $_POST['shortfundly_form_submitted'] );
        //echo 'meeeeeeeeeee';
        //if( $hidden_field == 'Y' ) {
            
            $shortfundly_id =sanitize_text_field($_POST['shortfundly_id']);
            update_post_meta($post->ID, 'shortfundly_id', $shortfundly_id);


            //$shortfundly_id = esc_html( $_POST['shortfundly_id'] );


            $shortfundly_data = shortfundly_plugin_get_data( $shortfundly_id );

            $options['shortfundly_id']	= $shortfundly_id;
            $options['last_updated']	= time();
            $options['shortfundly_data'] = $shortfundly_data;
            $options['page_no']= 1;

            /* 
            *  This update the option array into wordpress database 
            */
            //var_dump($options);
            update_option( 'shortfundly_plugin', $options ); 

       // }
    
     }else{echo "meeeeiefief";}
}
    $options = get_option( 'shortfundly_plugin' );
    
    if( $options != '' ) {
        $shortfundly_id = $options['shortfundly_id'];
        $shortfundly_data = $options['shortfundly_data'];
        $page_no = $options['page_no'];
    }
    
    /* 
    *  This function sets which php file should be shown when setting page of the plugin is clicked 
    */
    require('inc/options-page-wrapper.php');
//}

}

/* 
*  This function returns the object form of api's json data 
*/

function shortfundly_plugin_get_data( $shortfundly_id ) {
    global $options;
    global $err;

    $options = get_option( 'shortfundly_plugin' );
    $page_no=$options['page_no'];

    $json_feed_url = 'http://api.shortfundly.com/film/toprated?p='.$page_no;
    
    //var_dump($json_feed_url);

    $headers = array('Content-Type' => 'application/json', 'X-Api-Key' => ''.$shortfundly_id);
    $args = array('headers' => $headers);

    $json_feed = wp_remote_get( $json_feed_url, $args );
   // var_dump($json_feed);
    $shortfundly_data = json_decode( $json_feed['body'] );

         //var_dump($shortfundly_data);

    if($shortfundly_data->{'error'}=="Invalid API key "){
        $err =2 ; 
        return "wrong key";
        
    }
    $err=1;
    return $shortfundly_data;
    
}

/* 
*  This function is called when '>' or next page button is clicked on the front end
*/

function shortfundly_badges_refresh_profile() {
    global $options;
    $options = get_option( 'shortfundly_plugin' );

    $shortfundly_id = $options['shortfundly_id'];
    $page_no = $options['page_no'];
    $page_no = $page_no+1;

    $options['page_no']=$page_no;
    update_option( 'shortfundly_plugin', $options );
    $options['shortfundly_data'] =shortfundly_plugin_get_data( $shortfundly_id );
        
    $options['last_updated'] = time();

    update_option( 'shortfundly_plugin', $options );

    die();

}


add_action( 'wp_ajax_shortfundly_badges_refresh_profile', 'shortfundly_badges_refresh_profile' );


/* 
*  This function is called when '<' or next page button is clicked on the front end
*/

function shortfundly_badges_refresh_profil2() {
    global $options;
    $options = get_option( 'shortfundly_plugin' );
    $shortfundly_id = $options['shortfundly_id'];
    
    $page_no = $options['page_no'];
    $page_no = $page_no-1;
    $options['page_no']=$page_no;
    update_option( 'shortfundly_plugin', $options );
    $options['shortfundly_data'] =shortfundly_plugin_get_data( $shortfundly_id );
    $options['last_updated'] = time();

    update_option( 'shortfundly_plugin', $options );
    die();
    
}


add_action( 'wp_ajax_shortfundly_badges_refresh_profil2', 'shortfundly_badges_refresh_profil2' );


function shortfundly_badges_enable_frontend_ajax() {
    ?>    
        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
        </script>
    <?php
    }
    
add_action( 'wp_head', 'shortfundly_badges_enable_frontend_ajax' );
    




class Shortfundly_Plugin_Widget extends WP_Widget {
    
    function __construct() {
        // Instantiate the parent object
        parent::__construct( false, 'Shortfundly Shortfilms Widget ' );
    }

    function widget( $args, $instance ) {
        // Widget output

        extract( $args );
        $title = apply_filters( 'widget_title' , $instance['title'] );
       
        $options = get_option( 'shortfundly_plugin' );
        $shortfundly_id = $options['shortfundly_id'];

        $shortfundly_data = shortfundly_plugin_get_data( $shortfundly_id );
        update_option( 'shortfundly_plugin', $options );
        require( 'inc/front-end.php' );
    }

    function update( $new_instance, $old_instance ) {
        // Save widget options
    
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        
        return $instance;
    }

    function form( $instance ) {
        // Output admin widget options form

        $title = esc_attr($instance['title']);
        
        require( 'inc/widget-fields.php' );
        
    }
}
    
function shortfundly_plugin_register_widgets() {
    register_widget( 'Shortfundly_Plugin_Widget' );
}
    
add_action( 'widgets_init', 'shortfundly_plugin_register_widgets' );
    


function shortfundly_plugin_shortcode( $atts, $content = null ) {
        
    global $post;

    $options = get_option( 'shortfundly_plugin' );
    $shortfundly_id = $options['shortfundly_id'];
    $shortfundly_data=$options['shortfundly_data'];
    ob_start();

    require( 'inc/front-end.php' ); // This is what is displayed when we use shortcodes in posts or pages

    $content = ob_get_clean();

    return $content;

}

add_shortcode( 'shortfundly-plugin', 'shortfundly_plugin_shortcode' );
        


//this is to link the css files to the backend i.e setting's page
function shortfundly_plugin_backend_styles() {
    
    wp_enqueue_style( 'shortfundly_plugin_backend_styles', plugins_url( 'shortfundly-plugin-backend.css' ) );
    
}

add_action( 'admin_head', 'shortfundly_plugin_backend_styles' );


//this is to link the css files to the frontend

function shortfundly_plugin_frontend_scripts_and_styles() {
    
    wp_enqueue_style( 'shortfundly_plugin_frontend_css', plugins_url( 'shortfundly-plugin-frontend.css' ) );

    /*
    *   To include js files to frontend 
    *   wp_enqueue_script( 'wptreehouse_badges_frontend_js', plugins_url( 'wptreehouse-badges/wptreehouse-badges.js' ), array('jquery'), '', true );
    */
}

add_action( 'wp_enqueue_scripts', 'shortfundly_plugin_frontend_scripts_and_styles' );

?>