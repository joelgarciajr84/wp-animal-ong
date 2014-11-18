<?php

add_action( 'init', 'register_taxonomy_cat_medicamentos' );

function register_taxonomy_cat_medicamentos() {

    $labels = array( 
        'name' => __( 'Categoria', 'wpanimal' ),
        'singular_name' => __( 'Categoria', 'wpanimal' ),
        'search_items' => __( 'Pesquisar Categoria', 'wpanimal' ),
        'popular_items' => __( 'Populares', 'wpanimal' ),
        'all_items' => __( 'Categoria', 'wpanimal' ),
        'parent_item' => __( 'Categoria Pai', 'wpanimal' ),
        'parent_item_colon' => __( 'Categoria Pai:', 'wpanimal' ),
        'edit_item' => __( 'Editar Categoria', 'wpanimal' ),
        'update_item' => __( 'Atualizar Categoria', 'wpanimal' ),
        'add_new_item' => __( 'Adicionar Categoria', 'wpanimal' ),
        'new_item_name' => __( 'Novas Categoria', 'wpanimal' ),
        'add_or_remove_items' => __( 'Adicionar ou remover Categoria', 'wpanimal' ),
        'choose_from_most_used' => __( 'Escolher entre os mais usados', 'wpanimal' ),
        'menu_name' => __( 'Categoria', 'wpanimal' ),
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

    register_taxonomy( 'categoria_medicamentos', 'medicamentos', $args );
}
?>