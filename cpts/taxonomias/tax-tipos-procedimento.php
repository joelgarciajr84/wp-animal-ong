<?php

add_action( 'init', 'register_taxonomy_tp_procedimentos' );

function register_taxonomy_tp_procedimentos() {

    $labels = array( 
        'name' => __( 'Tipos de Procedimento', 'wpanimal' ),
        'singular_name' => __( 'Tipos de Procedimento', 'wpanimal' ),
        'search_items' => __( 'Pesquisar Tipos de Procedimento', 'wpanimal' ),
        'popular_items' => __( 'Populares', 'wpanimal' ),
        'all_items' => __( 'Tipos de Procedimento', 'wpanimal' ),
        'parent_item' => __( 'Tipos de Procedimento Pai', 'wpanimal' ),
        'parent_item_colon' => __( 'Tipos de Procedimento Pai:', 'wpanimal' ),
        'edit_item' => __( 'Editar Tipos de Procedimento', 'wpanimal' ),
        'update_item' => __( 'Atualizar Tipos de Procedimento', 'wpanimal' ),
        'add_new_item' => __( 'Adicionar Tipos de Procedimento', 'wpanimal' ),
        'new_item_name' => __( 'Novas Tipos de Procedimento', 'wpanimal' ),
        'add_or_remove_items' => __( 'Adicionar ou remover Tipos de Procedimento', 'wpanimal' ),
        'choose_from_most_used' => __( 'Escolher entre os mais usados', 'wpanimal' ),
        'menu_name' => __( 'Tipos de Procedimento', 'wpanimal' ),
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

    register_taxonomy( 'tax_tp_proc', 'procedimento', $args );
}
?>