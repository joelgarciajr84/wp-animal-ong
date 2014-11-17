<?php 

#Custom Post Type - Lancamento nos caixas

add_action( 'init', 'register_cpt_lancamento_caixas' );

function register_cpt_lancamento_caixas() {

  $labels = array( 
    'name' => __('Lancamento','wpanimal'),
    'singular_name' => __('Lancamento','wpanimal'),
    'add_new' => __('Adicionar Lancamento','wpanimal'),
    'add_new_item' => __('Adicionar Lancamento','wpanimal'),
    'edit_item' => __('Editar Lancamento','wpanimal'),
    'new_item' => __('Novo Lancamento','wpanimal'),
    'view_item' => __('Ver Lancamento','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Lancamentos','wpanimal'),
    'menu_name' => __('Lancamentos','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Lancamentos',
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
  register_post_type( 'lancamentocaixa', $args );
}

# Metabox para dados de Lancamento no caixa escolhido

add_action( 'add_meta_boxes', 'lanca_Caixa_dados' );

function lanca_Caixa_dados() {
  add_meta_box(
    'lanca_Caixa_id',
    __('Dados do Lancamento','wpanimal'),
    'lancamentocaixa',
    'lancamentocaixa',
    'side'
  );
}
function lancamentocaixa($lancamentocaixa) {

  $caixalancamento = get_post_meta( $lancamentocaixa->ID, 'caixa_lancamento', true );

  $tipolancamento = get_post_meta( $lancamentocaixa->ID, 'tipo_lancamento', true );

  $args = array(

    'posts_per_page'   => 5,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'caixas',
    'post_status'      => 'publish',
    'suppress_filters' => true 
  );

  $caixaescolhido = get_posts( $args );

  echo '<label  for="valor_lancamento">Caixa:</label>';

  echo '<select class="widefat" name="caixa_lancamento" id="caixa_lancamento">';

  echo '<option value="">Selecione um Caixa</option>';

 


  foreach ($caixaescolhido as $caixa) {
  ?>
    <option value="<?php echo $caixa->ID?>" <?php if ($caixalancamento == $caixa->ID ){echo 'SELECTED';}?>> <?php echo $caixa->post_title?></option>
  <?php 
  }

  echo '</select>';

  echo '<br>';
?>
  <p>
    <label  for="valor_lancamento">Valor do Lancamento:</label>
    <br />
    <p>R$ <input  type="text" width="50px"  name="valor_lancamento" value="<?php echo get_post_meta( $lancamentocaixa->ID, 'valor_lancamento', true ); ?>" /></p>
  </p>
<?php
    
  $tipos = array("Entrada","Saida");

  foreach ($tipos as $tipo) {
  ?>
    <input type="radio" name="tipo_lancamento" value="<?php echo $tipo ?>"<?php if ($tipolancamento == $tipo) {echo 'CHECKED';} ?>> <?php echo $tipo ?>
  <?php
  }


}
add_action( 'save_post', 'salva_metas_lancamentocaixa', 10, 2 );

function salva_metas_lancamentocaixa( $lancamentocaixa_id, $lancamentocaixa ) {

  global $post;

  if ($post->post_type == 'lancamentocaixa') {


    if(!defined('DOING_AJAX')) {


      update_post_meta( $lancamentocaixa_id, 'caixa_lancamento', strip_tags( $_POST['caixa_lancamento'] ) );
      update_post_meta( $lancamentocaixa_id, 'valor_lancamento', strip_tags( $_POST['valor_lancamento'] ) );
      update_post_meta( $lancamentocaixa_id, 'tipo_lancamento', strip_tags( $_POST['tipo_lancamento'] ) );

      $caixalancamento = get_post_meta( $lancamentocaixa->ID, 'caixa_lancamento', true );

      $saldoatual = get_post_meta( $caixalancamento, "saldo", true);

      if ($_POST['tipo_lancamento'] == "Entrada") {

        $novosaldo = $saldoatual + $_POST['valor_lancamento'];
      }elseif ($_POST['tipo_lancamento'] == "Saida") {
        
       $novosaldo = $saldoatual - $_POST['valor_lancamento'];
      }
      
      update_post_meta($caixalancamento, 'saldo', $novosaldo);

    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-lancamentocaixa_columns', 'cria_edit_lancamentocaixa_columns' ) ;

function cria_edit_lancamentocaixa_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Lancamento' ),
  'valor' => __('Valor'),
);

return $columns;
}
add_action( 'manage_lancamentocaixa_posts_custom_column', 'cria_manage_lancamentocaixa_columns', 10, 2 );

function cria_manage_lancamentocaixa_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'valor' :

      $valor = get_post_meta( $post_id, 'valor_lancamento', true );

      if ( empty( $valor ) )

      echo __( 'Não cadastrado' );

      else
            echo $valor; 
    break;

  } 
}
?>