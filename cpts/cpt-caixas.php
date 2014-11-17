<?php 

#Custom Post Type - Cadastro de Caixas

add_action( 'init', 'register_cpt_caixas' );

function register_cpt_caixas() {

  $labels = array( 
    'name' => __('Caixa','wpanimal'),
    'singular_name' => __('Caixa','wpanimal'),
    'add_new' => __('Adicionar Caixa','wpanimal'),
    'add_new_item' => __('Adicionar Caixa','wpanimal'),
    'edit_item' => __('Editar Caixa','wpanimal'),
    'new_item' => __('Novo Caixa','wpanimal'),
    'view_item' => __('Ver Caixa','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Caixas','wpanimal'),
    'menu_name' => __('Caixas','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Caixas',
    'supports' => array('title', 'editor'),
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
  register_post_type( 'caixas', $args );
}
#Metabox Informações dos caixas

add_action( 'add_meta_boxes', 'caixas_dados' );

function caixas_dados() {
  add_meta_box(
    'caixas_id',
    __('Dados do Caixa','wpanimal'),
    'caixas',
    'caixas',
    'side'
  );
}
function caixas($caixas) {

?>

  <p>
    <label  for="saldo">Saldo:</label>
    <br />
    <input  type="text" width="50px"  name="saldo" value="<?php echo get_post_meta( $caixas->ID, 'saldo', true ); ?>" />
  </p>
  <p>
    <label  for="responsavel">Responsavel:</label>
    <br />
    <input  type="text" width="50px"  name="responsavel" value="<?php echo get_post_meta( $caixas->ID, 'responsavel', true ); ?>" />
  </p>
<?php
}
add_action( 'save_post', 'salva_metas_caixas', 10, 2 );

function salva_metas_caixas( $caixas_id, $caixas ) {

  global $post;

  if ($post->post_type == 'caixas') {


    if(!defined('DOING_AJAX')) {

     
      update_post_meta( $caixas_id, 'responsavel', strip_tags( $_POST['responsavel'] ) );
      
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-caixas_columns', 'cria_edit_caixas_columns' ) ;

function cria_edit_caixas_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Caixa' ),
  'responsavel' => __('Responsavel'),
  'saldo' => __('Saldo')
);

return $columns;
}
add_action( 'manage_caixas_posts_custom_column', 'cria_manage_caixas_columns', 10, 2 );

function cria_manage_caixas_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'responsavel' :

      $responsavel = get_post_meta( $post_id, 'responsavel', true );

      if ( empty( $responsavel ) )

      echo __( 'Não cadastrado' );

      else
            echo $responsavel; 
    break;

    case 'saldo' :

      $saldo = get_post_meta( $post_id, 'saldo', true );

      if ($saldo < 0) {

        echo '<p style="color: red";>'. "R$ " . $saldo . '</p>'; 
      }
      elseif($saldo >= 0){

        echo '<p style="color: green";>'. "R$ " . $saldo . '</p>'; 
      }
      break;
    } 
  }
?>