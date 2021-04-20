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
        // $UrlApiBeetrack="http://app.beetrack.com/api/external/v1/";
        $TituloWidget= apply_filters( 'widget_title', $instance['TituloWidget'] );
        $Ruta= (isset($instance['ruta']) && !empty($instance['ruta'])) ? esc_attr($instance['ruta']) : rand() ;


        /* creando titulo */
        if ( ! empty( $TituloWidget ) ){ $salida_titulo = $before_title . $TituloWidget . $after_title;}


        /* conectar */
        // require 'RestClientLib/RestClient.php';
        // foreach (glob('RestClientLib/*.php') as $filename) require_once $filename;
        require( plugin_dir_path( __FILE__ ) . 'RestClientLib/CurlHttpResponse.php');
        require( plugin_dir_path( __FILE__ ) . 'RestClientLib/CurlMultiHttpResponse.php');
        require( plugin_dir_path( __FILE__ ) . 'RestClientLib/RestClient.php');
        require( plugin_dir_path( __FILE__ ) . 'RestClientLib/RestMultiClient.php');


$restClient = new RestClient();
$restClient->setRemoteHost('app.beetrack.com')
           ->setUriBase('/api/external/v1/')
           ->setUseSsl(false)
           ->setUseSslTestMode(false)
        //    ->setBasicAuthCredentials('username', 'password')
           ->setHeaders(array('Accept' => 'application/json'));
// make requests against service
$response = $restClient->get('resource');


        // /* creando salida widget */
        $salida .= $before_widget;
        // $salida .='<hr>';
        // $salida .= var_dump( $resultado_lista_vehiculos->response_status_lines );
        // $salida .= $resultado_lista_vehiculos->info->http_code ;
        $salida .= $response;
        $salida .= 'xxx<hr>';
        // $salida .= "<code>".$ruta."</code>";
        $salida .= $after_widget;
        
        echo $salida;
    }


}


