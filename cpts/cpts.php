<?php 

#Invocacao de Custom Post Types

require_once dirname( __FILE__ ) . '/cpt-apoiadores.php';
require_once dirname( __FILE__ ) . '/cpt-medicamentos.php';
require_once dirname( __FILE__ ) . '/cpt-entrada-medicamentos.php';
require_once dirname( __FILE__ ) . '/cpt-aplicacao-medicamentos.php';

if(!function_exists('wp_get_current_user')) {
    include(ABSPATH . "wp-includes/pluggable.php"); 
}

if( current_user_can( 'administrator' ) ){

	require_once dirname( __FILE__ ) . '/cpt-caixas.php';
	require_once dirname( __FILE__ ) . '/cpt-lancamento-caixa.php';
}


require_once dirname( __FILE__ ) . '/cpt-animais.php';
require_once dirname( __FILE__ ) . '/cpt-veterinarios.php';
require_once dirname( __FILE__ ) . '/cpt-procedimentos.php';
//require_once dirname( __FILE__ ) . '/cpt-lares-adocao.php';
require_once dirname( __FILE__ ) . '/cpt-adocoes.php';


#Invoca Taxonomias

require_once dirname(__FILE__) . '/taxonomias/taxonomias.php';