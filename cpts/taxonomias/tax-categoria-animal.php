<?php

add_action( 'init', 'register_taxonomy_cat_animal' );

function register_taxonomy_cat_animal() {

    $labels = array( 
        'name' => __( 'Tipo Animal', 'wpanimal' ),
        'singular_name' => __( 'Tipo Animal', 'wpanimal' ),
        'search_items' => __( 'Pesquisar Tipo animal', 'wpanimal' ),
        'popular_items' => __( 'Populares', 'wpanimal' ),
        'all_items' => __( 'Tipo Animal', 'wpanimal' ),
        'parent_item' => __( 'Tipo Animal Pai', 'wpanimal' ),
        'parent_item_colon' => __( 'Tipo Animal Pai:', 'wpanimal' ),
        'edit_item' => __( 'Editar Tipo Animal', 'wpanimal' ),
        'update_item' => __( 'Atualizar Tipo Animal', 'wpanimal' ),
        'add_new_item' => __( 'Adicionar Tipo Animal', 'wpanimal' ),
        'new_item_name' => __( 'Novas Tipo Animal', 'wpanimal' ),
        'add_or_remove_items' => __( 'Adicionar ou remover Tipo Animal', 'wpanimal' ),
        'choose_from_most_used' => __( 'Escolher entre os mais usados', 'wpanimal' ),
        'menu_name' => __( 'Tipo Animal', 'wpanimal' ),
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

    register_taxonomy( 'tax_tp_animals', 'animal', $args );
}
?>