<?php 

#Custom Post Type - Aplicacao de Medicamentos

add_action( 'init', 'register_cpt_aplicacao_medicamentos' );

function register_cpt_aplicacao_medicamentos() {

  $labels = array( 
    'name' => __('Aplicacao de Medicamento','wpanimal'),
    'singular_name' => __('Aplicacao de Medicamento','wpanimal'),
    'add_new' => __('Adicionar Aplicacao de Medicamento','wpanimal'),
    'add_new_item' => __('Adicionar Aplicacao de Medicamento','wpanimal'),
    'edit_item' => __('Editar Aplicacao de Medicamento','wpanimal'),
    'new_item' => __('Novo Aplicacao de Medicamento','wpanimal'),
    'view_item' => __('Ver Aplicacao de Medicamento','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Aplicacao de Medicamento','wpanimal'),
    'menu_name' => __('Aplicacao de Medicamento','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Aplicacao de Medicamentos',
    'supports' => array('title', 'editor'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'menu-farmacia',
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
  register_post_type( 'aplicamed', $args );
}

# Metabox para dados de Aplicacao do Medicamento esoclhido

add_action( 'add_meta_boxes', 'lanca_aplica_med' );

function lanca_aplica_med() {
  add_meta_box(
    'lanca_aplica_med_id',
    __('Dados da Aplicacao','wpanimal'),
    'aplicamed',
    'aplicamed',
    'side'
  );
}
function aplicamed($aplicamed) {

//Selecao do medicamento
  $medicamentolancamento = get_post_meta( $aplicamed->ID, 'medicamento_lancamento', true );

  $args = array(

    'posts_per_page'   => -1,
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
  echo '<br><br>';

//Selecao do Animal
  $animallancamento = get_post_meta( $aplicamed->ID, 'animal_lancamento', true );

  $args = array(

    'posts_per_page'   => -1,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'animal',
    'post_status'      => 'publish',
    'suppress_filters' => true 
  );

  $animalescolhido = get_posts( $args );

  echo '<strong>Animal</strong>';

  echo '<select class="widefat" name="animal_lancamento" id="animal_lancamento">';

  echo '<option value="">Selecione um Animal</option>';

 


  foreach ($animalescolhido as $animal) {
  ?>
    <option value="<?php echo $animal->ID?>" <?php if ($animallancamento == $animal->ID ){echo 'SELECTED';}?>> <?php echo $animal->post_title?></option>
  <?php 
  }

  echo '</select>';

?>
  <p>
    <strong><label  for="quantidade">Quantidade:</label></strong>
    <br />
    <p><input  type="text" class="widefat"  name="quantidade" value="<?php echo get_post_meta( $aplicamed->ID, 'quantidade', true ); ?>" /></p>
  </p>
<?php
}
add_action( 'save_post', 'salva_metas_aplicamed', 10, 2 );

function salva_metas_aplicamed( $aplicamed_id, $aplicamed ) {

  global $post;

  if ($post->post_type == 'aplicamed') {


    if(!defined('DOING_AJAX')) {

 
      update_post_meta( $aplicamed_id, 'medicamento_lancamento', strip_tags( $_POST['medicamento_lancamento'] ) );
      update_post_meta( $aplicamed_id, 'animal_lancamento', strip_tags( $_POST['animal_lancamento'] ) );

      update_post_meta( $aplicamed_id, 'quantidade', strip_tags( $_POST['quantidade'] ) );

      $medicamentolancamento = get_post_meta( $aplicamed->ID, 'medicamento_lancamento', true );

      $estoqueatual = get_post_meta( $medicamentolancamento, 'estoque', true);

      $novoestoque = $estoqueatual - $_POST['quantidade'];

      update_post_meta($medicamentolancamento, 'estoque', $novoestoque);
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-aplicamed_columns', 'cria_edit_aplicamed_columns' ) ;

function cria_edit_aplicamed_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Lancamento' ),
  'medicamento' => __('Medicamento'),
  'animal' => __('Animal'),
  'quantidade' => __('Quantidade'),
  'usuario' => __('Usuario'),

);

return $columns;
}
add_action( 'manage_aplicamed_posts_custom_column', 'cria_manage_aplicamed_columns', 10, 2 );

function cria_manage_aplicamed_columns( $column, $post_id ) {
  global $post;

  $medicamentolancamento = get_post_meta( $post->ID, 'medicamento_lancamento', true );
  $animallancamento = get_post_meta( $post->ID, 'animal_lancamento', true );



  switch( $column ) {


    case 'medicamento' :

      $medicamento = get_post($medicamentolancamento);

      if ( empty( $medicamento ) )

        echo __( 'Não cadastrado' );
      else
        echo '<p>'. $medicamento->post_title;  '</p>';
    break;

    case 'animal' :

      $animal = get_post($animallancamento);

      if ( empty( $animal ) )

        echo __( 'Não cadastrado' );
      else
        echo '<p>'. $animal->post_title;  '</p>';
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

     case 'usuario' :
         echo '<p>'.the_modified_author();'</p>';
    break;
  } 
}
?>