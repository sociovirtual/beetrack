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
        
        /* variables */
        $ApiKeyBeetrack= "6f3bfd68d7b802d94d2575d28e189797f8369bf8c9781841bd7ac887af1c17ad";
        // https://app.beetrack.com/api/external/v1/routes
        $UrlApiBeetrack="https://app.beetrack.com/api/external/v1/routes/";
        $TituloWidget= apply_filters( 'widget_title', $instance['TituloWidget'] );
        $Ruta= (isset($instance['ruta']) && !empty($instance['ruta'])) ? esc_attr($instance['ruta']) : rand() ;


        /* creando titulo */
        if ( ! empty( $TituloWidget ) ){ $salida_titulo = $before_title . $TituloWidget . $after_title;}

        /* coneccion a beetrack */
        $URLConeccionBeetrack = $UrlApiBeetrack.$Ruta;
        $ArgumentoConeccionBeetrack = array(
            CURLOPT_URL => $URLConeccionBeetrack,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            // CURLOPT_ENCODING => "",
            // CURLOPT_MAXREDIRS => 10,
            // CURLOPT_TIMEOUT => 30,
            // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            // CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_HTTPHEADER => array(
                'X-AUTH-TOKEN' => $ApiKeyBeetrack ,
                'Content-Type' => 'application/json'
            )
        );

        $curl = curl_init();
        curl_setopt_array($curl, $ArgumentoConeccionBeetrack );
        $responde = curl_exec($curl);
        $error_responde = curl_error($curl);
        curl_close($curl);

        if ($error_responde) { $responde = "cURL Error #:" . $error_responde; }
        /* creando salida widget */
        $salida = $before_widget;
        $salida .='<hr>';
        $salida .= $responde;
        $salida .= '<hr>';
        $salida .= "<code>".$ruta."</code>";
        $salida .= $after_widget;
        
        echo $salida;
    }


}


