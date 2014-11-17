<?php 

#Custom Post Type - Cadastro de Animais

add_action( 'init', 'register_cpt_animais' );

function register_cpt_animais() {

  $labels = array( 
    'name' => __('Animal','wpanimal'),
    'singular_name' => __('Animal','wpanimal'),
    'add_new' => __('Adicionar Animal','wpanimal'),
    'add_new_item' => __('Adicionar Animal','wpanimal'),
    'edit_item' => __('Editar Animal','wpanimal'),
    'new_item' => __('Novo Animal','wpanimal'),
    'view_item' => __('Ver Animal','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Animais','wpanimal'),
    'menu_name' => __('Animais','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Animais',
    'supports' => array('title', 'editor','thumbnail'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
    'capability_type' => 'post'
  );
  register_post_type( 'animal', $args );
}
