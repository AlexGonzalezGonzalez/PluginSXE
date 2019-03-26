<?php
/*
Plugin Name: LePlugin2
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Añade una linea a un post 
Author: Excalibur
Version: 3.0
Author URI: http://c9.io
*/
//Metodo principal que comprueba si el post contiene la palabra tonto
//Si la contiena mantiene el contenido tal cual
//Si no añade al mensaje que Dam2 aprueba este post y have un insert
function success($content) {
    
    //Si contiene tonto devuelve el contenido tal cual
    if(strstr($content,"tonto")){
        return $content;
    //Si no devuelve el contenido + aprobacion y inserta ese contenido en la base de datos
    }else{
      insert($content);
      return  $content= $content ." ". "Dam2 aprueba este post";
        
    }
}

//Inserta una fila en una tabla
function insert($content){
        global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

$wpdb->insert( 
	"wp5_success", 
	array( 
		'contenido' => $content, 
	) 
);
}
add_filter('the_content','success');


//Solo se ejecuta cuando se activa el plugin
function crear_tabla(){
    global $wpdb;

$charset_collate = $wpdb->get_charset_collate();

// le añado el prefijo a la tabla
$table_name = $wpdb->prefix . 'success';

// creamos la sentencia sql

$sql = "CREATE TABLE $table_name (
id mediumint(9) NOT NULL AUTO_INCREMENT,
contenido text NOT NULL,
PRIMARY KEY (id)
) $charset_collate;";

require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
dbDelta( $sql );
}
add_action('activated_plugin','crear_tabla');
