<?php

#Remocao de itens default do menu do WordPress

add_action( 'admin_menu', 'remove_wp_menus' );

function remove_wp_menus() {

	remove_menu_page('edit.php');
	remove_menu_page('edit.php?post_type=page');
	remove_menu_page('plugins.php');
	remove_menu_page('tools.php');
	remove_menu_page('update-core.php');
	remove_menu_page('upload.php');
	remove_menu_page('edit-comments.php');
	remove_menu_page('themes.php');
	remove_menu_page('options-general.php');
}

#Adiciona os menus (` chave `)

add_action( 'admin_menu','Menu_WP_Animal_ONG' );

function Menu_WP_Animal_ONG (){

	if ( current_user_can('moderate_comments') ) {

		add_menu_page( 
			'Associados',
			'Associados',
			'6',
			'menu-associados',
			'',
			plugins_url('wp-animal-ong/images/associados.png'),
			'101'
		);
		add_menu_page( 
			'Financeiro',
			'Financeiro',
			'6',
			'menu-financeiro',
			'',
			plugins_url('wp-animal-ong/images/financeiro.png'),
			'102'
		);
		add_menu_page( 
			'Animais',
			'Animais',
			'6',
			'menu-animais',
			'',
			plugins_url('wp-animal-ong/images/animais.png'),
			'103'
		);
		add_menu_page( 
			'Veterinarios',
			'Veterinarios',
			'6',
			'menu-veterinarios',
			'',
			plugins_url('wp-animal-ong/images/veterinarios.png'),
			'104'
		);
		add_menu_page( 
			'Farmacia',
			'Farmacia',
			'6',
			'menu-farmacia',
			'',
			plugins_url('wp-animal-ong/images/farmacia.png'),
			'105'
		);
		add_menu_page( 
			'Lares',
			'Lares',
			'6',
			'menu-lares',
			'',
			plugins_url('wp-animal-ong/images/lares.png'),
			'106'
		);
	}
}

#Ordem de Exibição dos Menus

add_filter('custom_menu_order', 'custom_menu_order'); // ATIVA A FUNCAO
add_filter('menu_order', 'custom_menu_order');
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;

		return array(

			'index.php', // Dashboard
			'menu-associados',
			'menu-financeiro',
			'menu-animais',
			'menu-farmacia',
			'menu-veterinarios',
			'menu-lares',
			
			//'help-desk/relatorios.php',
			//'separator2', Segundo separador
			//'help-desk/formacoes.php',
			//'separator-last', Ultimo Separador
			'separator1',
			#'edit.php', // Posts normais
			'upload.php', // Manipulação de Media
			#'link-manager.php', // Links
			#'edit.php?post_type=page', // Páginas
			#'edit-comments.php', // Comentários
			'themes.php', // Aparencia
			'plugins.php', // Plugins
			'users.php', // Usuarios
			'tools.php', // Ferramentas
			'options-general.php', // Configuracoes
		);
	}

?>