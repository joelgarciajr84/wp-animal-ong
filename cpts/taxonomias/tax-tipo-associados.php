<?php

add_action( 'init', 'register_taxonomy_tp_associados' );

function register_taxonomy_tp_associados() {

    $labels = array( 
        'name' => __( 'Tipo de Associado', 'wpanimal' ),
        'singular_name' => __( 'Tipo de Associado', 'wpanimal' ),
        'search_items' => __( 'Pesquisar Tipo de Associado', 'wpanimal' ),
        'popular_items' => __( 'Populares', 'wpanimal' ),
        'all_items' => __( 'Tipo de Associado', 'wpanimal' ),
        'parent_item' => __( 'Tipo de Associado Pai', 'wpanimal' ),
        'parent_item_colon' => __( 'Tipo de Associado Pai:', 'wpanimal' ),
        'edit_item' => __( 'Editar Tipo de Associado', 'wpanimal' ),
        'update_item' => __( 'Atualizar Tipo de Associado', 'wpanimal' ),
        'add_new_item' => __( 'Adicionar Tipo de Associado', 'wpanimal' ),
        'new_item_name' => __( 'Novas Tipo de Associado', 'wpanimal' ),
        'add_or_remove_items' => __( 'Adicionar ou remover Tipo de Associado', 'wpanimal' ),
        'choose_from_most_used' => __( 'Escolher entre os mais usados', 'wpanimal' ),
        'menu_name' => __( 'Tipo de Associado', 'wpanimal' ),
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

    register_taxonomy( 'tax_tp_associados', 'associados', $args );
}
?>