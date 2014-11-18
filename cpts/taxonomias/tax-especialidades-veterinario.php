<?php

add_action( 'init', 'register_taxonomy_espec_vet' );

function register_taxonomy_espec_vet() {

    $labels = array( 
        'name' => __( 'Especialidade', 'wpanimal' ),
        'singular_name' => __( 'Especialidade', 'wpanimal' ),
        'search_items' => __( 'Pesquisar Especialidade', 'wpanimal' ),
        'popular_items' => __( 'Populares', 'wpanimal' ),
        'all_items' => __( 'Especialidade', 'wpanimal' ),
        'parent_item' => __( 'Especialidade Pai', 'wpanimal' ),
        'parent_item_colon' => __( 'Especialidade Pai:', 'wpanimal' ),
        'edit_item' => __( 'Editar Especialidade', 'wpanimal' ),
        'update_item' => __( 'Atualizar Especialidade', 'wpanimal' ),
        'add_new_item' => __( 'Adicionar Especialidade', 'wpanimal' ),
        'new_item_name' => __( 'Novas Especialidade', 'wpanimal' ),
        'add_or_remove_items' => __( 'Adicionar ou remover Especialidade', 'wpanimal' ),
        'choose_from_most_used' => __( 'Escolher entre os mais usados', 'wpanimal' ),
        'menu_name' => __( 'Especialidades', 'wpanimal' ),
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

    register_taxonomy( 'especialidade_vet', 'veterinario', $args );
}
?>