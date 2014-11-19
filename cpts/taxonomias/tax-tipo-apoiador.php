<?php

add_action( 'init', 'register_taxonomy_tipo_apoiador' );

function register_taxonomy_tipo_apoiador() {

    $labels = array( 
        'name' => __( 'Tipo de Apoiador', 'wpanimal' ),
        'singular_name' => __( 'Tipo de Apoiador', 'wpanimal' ),
        'search_items' => __( 'Pesquisar Tipos', 'wpanimal' ),
        'popular_items' => __( 'Populares', 'wpanimal' ),
        'all_items' => __( 'Tipos de Apoiadores', 'wpanimal' ),
        'parent_item' => __( 'Tipo Pai', 'wpanimal' ),
        'parent_item_colon' => __( 'Tipo Pai:', 'wpanimal' ),
        'edit_item' => __( 'Editar Tipo de Apoiador', 'wpanimal' ),
        'update_item' => __( 'Atualizar Tipo', 'wpanimal' ),
        'add_new_item' => __( 'Adicionar Tipo de Apoiador', 'wpanimal' ),
        'new_item_name' => __( 'Novo tipo de Apoiador', 'wpanimal' ),
        'add_or_remove_items' => __( 'Adicionar ou remover Tipos', 'wpanimal' ),
        'choose_from_most_used' => __( 'Escolher entre os mais usados', 'wpanimal' ),
        'menu_name' => __( 'Tipos de Apoiadores', 'wpanimal' ),
    );

     $args = array( 
        'labels' => $labels,
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'show_tagcloud' => true,
        'show_admin_column' => true,
        'hierarchical' => true,
        'query_var' => true
    );

    register_taxonomy( 'tax_tipo_apoiador', 'apoiador', $args );
}

add_action( 'admin_init', 'adiciona_tipos_apoiadores' );

function adiciona_tipos_apoiadores() {

    $tipos = array("Associado", "Adotante", "Lar");

    foreach ($tipos as $tipo) {
      
        wp_insert_term( $tipo, 'tax_tipo_apoiador');
    }
}
?>