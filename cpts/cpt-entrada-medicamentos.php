<?php 

#Custom Post Type - Entrada de Medicamentos

add_action( 'init', 'register_cpt_entrada_medicamentos' );

function register_cpt_entrada_medicamentos() {

  $labels = array( 
    'name' => __('Entrada de Medicamento','wpanimal'),
    'singular_name' => __('Entrada de Medicamento','wpanimal'),
    'add_new' => __('Adicionar Entrada de Medicamento','wpanimal'),
    'add_new_item' => __('Adicionar Entrada de Medicamento','wpanimal'),
    'edit_item' => __('Editar Entrada de Medicamento','wpanimal'),
    'new_item' => __('Novo Entrada de Medicamento','wpanimal'),
    'view_item' => __('Ver Entrada de Medicamento','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Entrada de Medicamento','wpanimal'),
    'menu_name' => __('Entrada de Medicamento','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com entrada de Medicamentos',
    'supports' => array('title', 'editor'),
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
  register_post_type( 'entmed', $args );
}

# Metabox para dados de Lancamento no medicamento escolhido

add_action( 'add_meta_boxes', 'lanca_entrada_med' );

function lanca_entrada_med() {
  add_meta_box(
    'lanca_entrada_med_id',
    __('Dados da Entrada','wpanimal'),
    'entmed',
    'entmed',
    'side'
  );
}
function entmed($entmed) {

  $medicamentolancamento = get_post_meta( $entmed->ID, 'medicamento_lancamento', true );

  $args = array(

    'posts_per_page'   => 5,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'medicamentos',
    'post_status'      => 'publish',
    'suppress_filters' => true 
  );

  $medicamentoescolhido = get_posts( $args );

  echo '<strong>Medicamento</strong>';


  echo '<select class="widefat" name="medicamento_lancamento" id="medicamento_lancamento">';

  echo '<option value="">Selecione um medicamento</option>';

 


  foreach ($medicamentoescolhido as $medicamento) {
  ?>
    <option value="<?php echo $medicamento->ID?>" <?php if ($medicamentolancamento == $medicamento->ID ){echo 'SELECTED';}?>> <?php echo $medicamento->post_title?></option>
  <?php 
  }

  echo '</select>';

?>
  <p>
    <strong><label  for="quantidade">Quantidade:</label></strong>
    <br />
    <p><input  type="text" class="widefat"  name="quantidade" value="<?php echo get_post_meta( $entmed->ID, 'quantidade', true ); ?>" /></p>
  </p>
<?php
}
add_action( 'save_post', 'salva_metas_entmed', 10, 2 );

function salva_metas_entmed( $entmed_id, $entmed ) {

  global $post;

  if ($post->post_type == 'entmed') {


    if(!defined('DOING_AJAX')) {

 
      update_post_meta( $entmed_id, 'medicamento_lancamento', strip_tags( $_POST['medicamento_lancamento'] ) );
      update_post_meta( $entmed_id, 'quantidade', strip_tags( $_POST['quantidade'] ) );

      $medicamentolancamento = get_post_meta( $entmed->ID, 'medicamento_lancamento', true );

      $estoqueatual = get_post_meta( $medicamentolancamento, 'estoque', true);

      $novoestoque = $estoqueatual + $_POST['quantidade'];

      update_post_meta($medicamentolancamento, 'estoque', $novoestoque);
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-entmed_columns', 'cria_edit_entmed_columns' ) ;

function cria_edit_entmed_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Lancamento' ),
  'medicamento' => __('Medicamento'),
  'quantidade' => __('Quantidade'),
  'responsavel' => __('Responsavel'),

);

return $columns;
}
add_action( 'manage_entmed_posts_custom_column', 'cria_manage_entmed_columns', 10, 2 );

function cria_manage_entmed_columns( $column, $post_id ) {
  global $post;

  $medicamentolancamento = get_post_meta( $post->ID, 'medicamento_lancamento', true );

  $tipolancamento = get_post_meta( $post->ID, 'tipo_lancamento', true );

  switch( $column ) {


    case 'medicamento' :

      $medicamento = get_post($medicamentolancamento);

      if ( empty( $medicamento ) )

        echo __( 'Não cadastrado' );
      else
        echo '<p>'. $medicamento->post_title;  '</p>';
    break;

    case 'quantidade' :

      $quantidade = get_post_meta( $post_id, 'quantidade', true );

      if ( empty( $quantidade ) )

        echo __( 'Não cadastrado' );
      else
        echo $quantidade; 
    break;

    case 'operacao' :

      if ( empty( $tipolancamento ) )

        echo __( 'Não cadastrado' );
      else
         echo '<p>'. $tipolancamento;  '</p>';
    break;

     case 'responsavel' :
        echo '<p>'.the_modified_author();'</p>';
    break;
  } 
}
?>