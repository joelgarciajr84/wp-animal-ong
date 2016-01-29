<?php
/*
	* Plugin Name: WP Animal ONG
	* Plugin URL: https://github.com/joelgarciajr84/wp-animal-ong
	* Description: Um plugin WordPress para auxiliar na gestão de ONG`s que resgatam e cuidam de animais.
	* Author: Joel Garcia Jr
	* Version: 1.1
	* Text Domain: wpanimal
	* Author URL: joel.garciajr84@gmail.com
	* 
*/
if ( ! defined( 'ABSPATH' ) ) {		
	exit; // Exit if accessed directly.		
}

register_activation_hook( __FILE__, 'setPermissions' );

load_textdomain( 'wpanimal', dirname(__FILE__) . '/langs/wpanimal.mo');
//Invocacoes Necessarias

require_once dirname(__FILE__) . '/cfgs/permissoes.php';
require_once dirname(__FILE__) . '/cfgs/menu-esquerdo.php';
require_once dirname(__FILE__) . '/cpts/cpts.php';
require_once dirname(__FILE__) . '/cfgs/cfgs.php';

#Importacao dos javascripts necessarios
add_action('admin_enqueue_scripts', 'jsnecessarios');
function jsnecessarios() {

	wp_enqueue_script('maskedinput', plugins_url('/js/jquery.maskedinput.js', __FILE__));

	wp_enqueue_script('mascaras', plugins_url('/js/mascaras.js', __FILE__));
}

function remove_dashboard_widgets() {
	global $wp_meta_boxes;

	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
	//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );
