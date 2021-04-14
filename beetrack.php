<?php
/*
Plugin Name: Beetrack
Description: Put para agregar despachos al hoja de ruta de beetrack
Version:     1.0.0
Author:      SocioVirtual
Author URI:  https://sociovirtual.com/
License: GPLv2 or later
*/  

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* widget */

add_action('widgets_init', 'register_beetrack_widget');
function register_beetrack_widget(){
	register_widget( 'WP_Widget_Beetrack' );
}


class  WP_Widget_Beetrack extends WP_Widget {

    /* constructor inicial widget de wordpress */ 
	public function __construct() {
		parent::__construct(
			'Beetrack',
			esc_html__('Beetrack widget', 'BeetrackIdioma'),
			array( 'Agregar datos despachos a hoja de ruta de beetrack' => esc_html__('Display photos from flickr', 'BeetrackIdioma'))
		);
	}


	public function widget( $args, $instance ) {
        extract($args); 
        $titulo_widget= apply_filters( 'widget_title', $instance['title'] );
    
    
    }


}


