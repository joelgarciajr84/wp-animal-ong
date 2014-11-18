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
    'show_in_menu' => 'menu-animais',
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
#Metabox Informações do Animal

add_action( 'add_meta_boxes', 'animais_dados' );

function animais_dados() {
    add_meta_box(
        'animais_id',
        __('Dados do Animal','wpanimal'),
        'animal',
        'animal',
        'side'
    );
}
function animal($animal) {

?>

<p>
  <label  for="data_resgate">Data do Resgate:</label>
  <br />
  <input  type="date" class="widefat" id="data_resgate"  width="50px"  name="data_resgate" value="<?php echo get_post_meta( $animal->ID, 'data_resgate', true ); ?>" />
</p>
<p>
  <label  for="local_resgate">Local do Resgate:</label>
  <br />
  <input  type="text" class="widefat"  name="local_resgate" value="<?php echo get_post_meta( $animal->ID, 'local_resgate', true ); ?>" />
</p>
<p>
  <label  for="responsavel">Responsavel:</label>
  <br />
  <input  type="text" class="widefat"  name="responsavel" value="<?php echo get_post_meta( $animal->ID, 'responsavel', true ); ?>" />
</p>

<?php
}
add_action( 'save_post', 'salva_metas_animais', 10, 2 );

function salva_metas_animais( $animal_id, $animal ) {

  global $post;

  if ($post->post_type == 'animal') {


    if(!defined('DOING_AJAX')) {

      update_post_meta( $animal_id, 'data_resgate', strip_tags( $_POST['data_resgate'] ) );
      update_post_meta( $animal_id, 'local_resgate', strip_tags( $_POST['local_resgate'] ) );
      update_post_meta( $animal_id, 'responsavel', strip_tags( $_POST['responsavel'] ) );
     }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-animal_columns', 'cria_edit_animal_columns' ) ;

function cria_edit_animal_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Animal' ),
  'data_resgate' => __('Data do Resgate'),
  'responsavel' => __('Responsavel'),
  'thumbnail' => __('Foto')
);

return $columns;
}
add_action( 'manage_animal_posts_custom_column', 'cria_manage_animal_columns', 10, 2 );

function cria_manage_animal_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'data_resgate' :

      $dataresgate = get_post_meta( $post_id, 'data_resgate', true );

      if ( empty( $dataresgate ) )

      echo __( 'Não cadastrado' );

      else
            echo $dataresgate; 
    break;

    case 'responsavel' :

      $responsavel = get_post_meta( $post_id, 'responsavel', true );

      if ( empty( $responsavel ) )

      echo __( 'Não cadastrado' );

      else
       echo $responsavel; 
     break;
     
    case 'thumbnail' :

      if (has_post_thumbnail($post->ID))

      echo get_the_post_thumbnail($post->ID, array(90, 90));

      else

      echo '<em>Sem Miniatura</em>';
    break;
  } 
}
?>