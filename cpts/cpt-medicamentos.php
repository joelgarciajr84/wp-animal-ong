<?php 

#Custom Post Type - Cadastro de Medicamentos

add_action( 'init', 'register_cpt_medicamentos' );

function register_cpt_medicamentos() {

  $labels = array( 
    'name' => __('Medicamento','wpanimal'),
    'singular_name' => __('Medicamento','wpanimal'),
    'add_new' => __('Adicionar Medicamento','wpanimal'),
    'add_new_item' => __('Adicionar Medicamento','wpanimal'),
    'edit_item' => __('Editar Medicamento','wpanimal'),
    'new_item' => __('Novo Medicamento','wpanimal'),
    'view_item' => __('Ver Medicamento','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Medicamentos','wpanimal'),
    'menu_name' => __('Medicamentos','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Medicamentos',
    'supports' => array('title','thumbnail', 'editor'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'menu-saude',
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
  register_post_type( 'medicamentos', $args );
}
#Metabox Informações dos medicamentos

add_action( 'add_meta_boxes', 'medicamentos_dados' );

function medicamentos_dados() {
  add_meta_box(
    'medicamentos_id',
    __('Dados do Medicamento','wpanimal'),
    'medicamentos',
    'medicamentos',
    'normal'
  );
}
function medicamentos($medicamentos) {

?>

<p>
  <label  for="indicacao">Indicacao:</label>
  <br />
  <input  type="text" width="50px"  name="indicacao" value="<?php echo get_post_meta( $medicamentos->ID, 'indicacao', true ); ?>" />
</p>
<p>
  <label  for="raca">Raca:</label>
  <br />
  <input  type="text" class="widefat" name="raca" value="<?php echo get_post_meta( $medicamentos->ID, 'raca', true ); ?>" />
</p>
<p>
  <label  for="idade">Idade:</label>
  <br />
  <input  type="text" name="idade" value="<?php echo get_post_meta( $medicamentos->ID, 'idade', true ); ?>" />
</p>
<p>
  <label  for="marca">Marca:</label>
  <br />
  <input  type="text" class="widefat" name="marca" value="<?php echo get_post_meta( $medicamentos->ID, 'marca', true ); ?>" />
</p>
<p>
  <label  for="linha">Linha:</label>
  <br />
  <input  type="text" class="widefat" name="linha" value="<?php echo get_post_meta( $medicamentos->ID, 'linha', true ); ?>" />
</p>
<p>
  <label  for="tipo">Tipo:</label>
  <br />
  <input  type="text" class="widefat" name="tipo" value="<?php echo get_post_meta( $medicamentos->ID, 'tipo', true ); ?>" />
</p>
<p>
  <label for="composicao">Composicao:</label>
  <br />
  <input  type="composicao" class="widefat" name="composicao" value="<?php echo get_post_meta( $medicamentos->ID, 'composicao', true ); ?>" />
</p>
<p>
  <label for="posologia">Posologia:</label>
  <br />
  <input  type="posologia" class="widefat" name="posologia" value="<?php echo get_post_meta( $medicamentos->ID, 'posologia', true ); ?>" />
</p>
<p>
  <label for="estoque">Estoque:</label>
  <br />
  <input  type="estoque" class="widefat" name="estoque" value="<?php echo get_post_meta( $medicamentos->ID, 'estoque', true ); ?>" />
</p>

<?php
}
add_action( 'save_post', 'salva_metas_medicamentos', 10, 2 );

function salva_metas_medicamentos( $medicamentos_id, $medicamentos ) {

  global $post;

  if ($post->post_type == 'medicamentos') {


    if(!defined('DOING_AJAX')) {

      update_post_meta( $medicamentos_id, 'indicacao', strip_tags( $_POST['indicacao'] ) );
      update_post_meta( $medicamentos_id, 'raca', strip_tags( $_POST['raca'] ) );
      update_post_meta( $medicamentos_id, 'idade', strip_tags( $_POST['idade'] ) );
      update_post_meta( $medicamentos_id, 'marca', strip_tags( $_POST['marca'] ) );
      update_post_meta( $medicamentos_id, 'linha', strip_tags( $_POST['linha'] ) );
      update_post_meta( $medicamentos_id, 'tipo', strip_tags( $_POST['tipo'] ) );
      update_post_meta( $medicamentos_id, 'composicao', strip_tags( $_POST['composicao'] ) );
      update_post_meta( $medicamentos_id, 'posologia', strip_tags( $_POST['posologia'] ) );
     // update_post_meta( $medicamentos_id, 'estoque', strip_tags( $_POST['estoque'] ) );

    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-medicamentos_columns', 'cria_edit_medicamentos_columns' ) ;

function cria_edit_medicamentos_columns( $columns ) {

  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => __( 'Medicamento' ),
    'marca' => __('Marca'),
    'tipo' => __('Tipo'),
    'estoque' => __('Estoque'),
    'thumbnail' => __('Foto')
  );

  return $columns;
}
add_action( 'manage_medicamentos_posts_custom_column', 'cria_manage_medicamentos_columns', 10, 2 );

function cria_manage_medicamentos_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'marca' :

      $marca = get_post_meta( $post_id, 'marca', true );

      if ( empty( $marca ) )

      echo __( 'Não cadastrado' );

      else
            echo $marca; 
    break;

    case 'tipo' :

      $tipo = get_post_meta( $post_id, 'tipo', true );

      if ( empty( $tipo ) )

      echo __( 'Não cadastrado' );

      else
       echo $tipo; 
     break;
     case 'estoque' :

      $estoque = get_post_meta( $post_id, 'estoque', true );

      if ( empty( $estoque ) )

      echo __( 'Não cadastrado' );

      else
       echo $estoque; 
    break;

    case 'thumbnail' :

      if (has_post_thumbnail($post->ID))

      echo get_the_post_thumbnail($post->ID, array(90, 90));

      else

      echo '<em>Sem Foto</em>';
    break;
  } 
}
?>