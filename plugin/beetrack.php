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
        // 
        /* variables */
        // $ApiKeyBeetrack= "6f3bfd68d7b802d94d2575d28e189797f8369bf8c9781841bd7ac887af1c17ad";

        // https://app.beetrack.com/api/external/v1/routes
        $UrlApiBeetrack="http://app.beetrack.com/api/external/v1/";
        // https://app.beetrack.com/api/external/v1/dispatches
        $TituloWidget= apply_filters( 'widget_title', $instance['TituloWidget'] );
        $Ruta= (isset($instance['ruta']) && !empty($instance['ruta'])) ? esc_attr($instance['ruta']) : rand() ;

        /* creando titulo */
        if ( ! empty( $TituloWidget ) ){ $salida_titulo = $before_title . $TituloWidget . $after_title;}

        /* deatlle cobnecvvion  */
        require 'restclient.php';
        $api = new RestClient([
            'base_url' => $UrlApiBeetrack, 
            // 'format' => "json", 
            // 'format' => "php",
             // https://dev.twitter.com/docs/auth/application-only-auth
            // 'headers' => ['Authorization' => 'X-AUTH-TOKEN '.$ApiKeyBeetrack ,  ], 
            'headers' => array(
                'X-AUTH-TOKEN' => $ApiKeyBeetrack ,
                // 'Content-Type' => 'application/json'
            )
        ]);
        // $result = $api->get("trucks");

        $result = $api->post('dispatches', 
        
            // 'name' => 'jose vargas name',
            // 'id' => '234567',
            // 'contact_name' => 'jose vargas',
            // 'contact_address' =>'ginber 450' , 
            // 'contact_phone'=> '91929192'
        
            
            [
                "identifier" => "1355444",
                "contact_name" => "jose vargas molina",
                "contact_address"=>"ginebra 450 , los angeles ",
                "contact_phone" => "34543534",
                "contact_email" => "dev@beetrack.com",
                "items" => [
                    
                        "code" => "SKU123",
                        "description"=> "LED Monitor 10",
                        "quantity"=> 1,
                        "price" => 300
                ],
                    [
                        "code"=>"SKU124",
                        "description"=> "LED Monitor 20",
                        "quantity"=> 1,
                        "price"=>400
            ]
                ]
            


        );

        // GET http://api.twitter.com/1.1/search/tweets.json?q=%23php
        // if($result->info->http_code == 200)
            // $response = var_dump($result->decode_response());
            // $response_json = $result->decode_response();

        // foreach($result as $key => $value)
        // $salida .= var_dump($value);


        // /* creando salida widget */
        $salida .= $before_widget;
        // $salida .='<hr>';
        // $salida .= var_dump( $resultado_lista_vehiculos->response_status_lines );
        // $salida .= $resultado_lista_vehiculos->info->http_code ;
        $salida .= $result->body;
        $salida .= $result->info->http_code;
        // $salida .= print_r( $result->response_status_lines );
        $salida .= '<hr>';
        $salida .= $result->headers->content_type;
        $salida .= $result->headers->x_powered_by;
        $salida .= $result->headers->body;
        $salida .= '<hr>';
        $salida .= $result->SERVER->REQUEST_METHOD;

        // $salida .= "<code>".$ruta."</code>";
        $salida .= $after_widget;
        
        echo $salida;
    }


}


