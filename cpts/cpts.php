<?php 

#Invocacao de Custom Post Types

require_once dirname( __FILE__ ) . '/cpt-associados.php';
require_once dirname( __FILE__ ) . '/cpt-medicamentos.php';
require_once dirname( __FILE__ ) . '/cpt-caixas.php';
require_once dirname( __FILE__ ) . '/cpt-lancamento-caixa.php';
require_once dirname( __FILE__ ) . '/cpt-animais.php';
require_once dirname( __FILE__ ) . '/cpt-veterinarios.php';
require_once dirname( __FILE__ ) . '/cpt-lares-adocao.php';



#Invoca Taxonomias

require_once dirname(__FILE__) . '/taxonomias/taxonomias.php';
?>