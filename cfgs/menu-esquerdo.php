<?php

#Remocao de itens default do menu do WordPress

add_action( 'admin_menu', 'remove_wp_menus' );

function remove_wp_menus() {

	if ( !current_user_can('administrator') ) {

		remove_menu_page('edit.php');
		remove_menu_page('edit.php?post_type=page');
		remove_menu_page('plugins.php');
		remove_menu_page('tools.php');
		remove_menu_page('update-core.php');
		remove_menu_page('upload.php');
		remove_menu_page('themes.php');
		remove_menu_page('options-general.php');
		remove_menu_page('edit-comments.php');
	}
	

}

#Adiciona os menus (` chave `)

add_action( 'admin_menu','Menu_WP_Animal_ONG' );

function Menu_WP_Animal_ONG (){


		add_menu_page(
			'Apoiadores',
			'Apoiadores',
			'edit_posts',
			'menu-apoiadores',
			'',
			plugins_url('wp-animal-ong/images/associados.png'),
			'101'
		);
		
		add_menu_page(
			'Financeiro',
			'Financeiro',
			'edit_caixas',
			'menu-financeiro',
			'',
			plugins_url('wp-animal-ong/images/financeiro.png'),
			'102'
		);
			
		add_menu_page(
			'Animais',
			'Animais',
			'edit_posts',
			'menu-animais',
			'',
			plugins_url('wp-animal-ong/images/animais.png'),
			'103'
		);
		add_menu_page(
			'Saude',
			'Saude',
			'edit_posts',
			'menu-saude',
			'',
			plugins_url('wp-animal-ong/images/farmacia.png'),
			'105'
		);
		add_menu_page(
			'Adoções',
			'Adoções',
			'edit_posts',
			'menu-adocoes',
			'',
			plugins_url('wp-animal-ong/images/lares.png'),
			'106'
		);
		add_menu_page(
			'Relatorios',
			'Relatorios',
			'edit_posts',
			'wp-animal-ong/relatorios/relatorios.php',
			'',
			plugins_url('wp-animal-ong/images/relatorios.png'),
			'107'
		);

	
}

#Ordem de Exibição dos Menus

add_filter('custom_menu_order', 'custom_menu_order'); // ATIVA A FUNCAO
add_filter('menu_order', 'custom_menu_order');
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;

	return array(

		'index.php', // Dashboard
		'menu-apoiadores',
		'menu-financeiro',

		'separator1',

		'menu-animais',
		'menu-saude',
		'menu-adocoes',
		'menu-relatorios',
		//'separator-last', Ultimo Separador
		#'edit.php', // Posts normais
		'separator2', //Segundo separador
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
