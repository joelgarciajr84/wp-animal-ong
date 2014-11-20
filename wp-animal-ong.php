<?php
/*
* Plugin Name: WP Animal ONG
* Plugin URL: https://github.com/joelgarciajr84/wp-animal-ong
* Description: Um plugin WordPress para auxiliar na gestão de ONG`s que resgatam e cuidam de animais.
* Author: Joel Garcia Jr
* Version: 0.1
* Text Domain: wpanimal
* Author URL: joel.garciajr84@gmail.com
*/

//Invocacoes Necessarias
require_once dirname( __FILE__ ) . '/cfgs/menu-esquerdo.php';
require_once dirname( __FILE__ ) . '/cpts/cpts.php';
require_once dirname( __FILE__ ) . '/cfgs/cfgs.php';


#Importacao dos javascripts necessarios

add_action( 'admin_enqueue_scripts', 'jsnecessarios' );
function jsnecessarios() {

	wp_enqueue_script(  'maskedinput', plugins_url('/js/jquery.maskedinput.js', __FILE__));

	wp_enqueue_script(  'mascaras', plugins_url('/js/mascaras.js', __FILE__));
}
#Desabilita o salvamento automatico de posts

add_action( 'admin_init', 'sem_auto_save' );

function sem_auto_save() {

	wp_deregister_script( 'autosave' );
}
?>