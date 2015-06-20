<?php 

#Custom Post Type - Cadastro de Adocoes

add_action( 'init', 'register_cpt_adocoes' );

function register_cpt_adocoes() {

  $labels = array( 
    'name' => __('Adoção','wpanimal'),
    'singular_name' => __('Adoção','wpanimal'),
    'add_new' => __('Adicionar Adoção','wpanimal'),
    'add_new_item' => __('Fazer nova Adoção','wpanimal'),
    'edit_item' => __('Editar Adoção','wpanimal'),
    'new_item' => __('Nova Adoção','wpanimal'),
    'view_item' => __('Ver Adoção','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Adoções','wpanimal'),
    'menu_name' => __('Adoções','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Adoções dos animais',
    'supports' => array('title', 'editor','thumbnail'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'menu-adocoes',
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
  register_post_type( 'adocao', $args );
}
# Metabox dados da Adocao

add_action( 'add_meta_boxes', 'dados_adocao' );

function dados_adocao() {
  add_meta_box(
    'dados_adocao_id',
    __('Dados da Adocao','wpanimal'),
    'adocao',
    'adocao',
    'side'
  );
}
function adocao($adocao) {

//Selecao do animal
  $animaladocao = get_post_meta( $adocao->ID, 'animal_adocao', true );

  $args = array(

    'posts_per_page'   => -1,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'animal',
    'post_status'      => 'publish',
    'suppress_filters' => true 
  );

  $animais = get_posts( $args );

  echo '<strong>Animal</strong>';


  echo '<select class="widefat" name="animal_adocao" id="animal_adocao">';

  echo '<option value="">Selecione um Animal</option>';

  foreach ($animais as $animal) {
  ?>
    <option value="<?php echo $animal->ID?>" <?php if ($animaladocao == $animal->ID ){echo 'SELECTED';}?>> <?php echo $animal->post_title?></option>
  <?php 
  }

  echo '</select>';
  echo '<br><br>';

//Selecao do Adotante
  $adotanteescolhido = get_post_meta( $adocao->ID, 'adotante_animal', true );

  $args = array(
  'numberposts' => -1,
  'post_type' => 'apoiador',
  'suppress_filters' => false, 
  'tax_query' => array(
	  array(
	    'taxonomy' => 'tax_tipo_apoiador',
	    'field' => 'slug', 
	    'terms' => 'adotante'
	    )));
  $adotantes = get_posts( $args );

  echo '<strong>Adotante</strong>';

  echo '<select class="widefat" name="adotante_animal" id="adotante_animal">';

  echo '<option value="">Selecione um Adotante</option>';

 
  foreach ($adotantes as $adotante) {
  ?>
    <option value="<?php echo $adotante->ID?>" <?php if ($adotanteescolhido == $adotante->ID ){echo 'SELECTED';}?>> <?php echo $adotante->post_title?></option>
  <?php 
  }

  echo '</select>';
?>
  <p>
    <strong><label  for="data_adocao">Data Adocao:</label></strong>
    <br />
    <p><input required  type="date" class="widefat"  name="data_adocao" value="<?php echo get_post_meta( $adocao->ID, 'data_adocao', true ); ?>" /></p>
  </p>
  <p>
    <strong><label  for="data_final">Data Final Adocao:</label></strong>
    <br />
    <p><input  type="date" class="widefat"  name="data_final" value="<?php echo get_post_meta( $adocao->ID, 'data_final', true ); ?>" /></p>
  </p>
<?php
}
#Salvamento
add_action( 'save_post', 'salva_metas_adocoes', 10, 2 );

function salva_metas_adocoes( $adocao_id, $adocao ) {

  global $post;

  if ($post->post_type == 'adocao') {

    if(!defined('DOING_AJAX')) {

      update_post_meta( $adocao_id, 'animal_adocao', strip_tags( $_POST['animal_adocao'] ) );
      update_post_meta( $adocao_id, 'adotante_animal', strip_tags( $_POST['adotante_animal'] ) );
      update_post_meta( $adocao_id, 'data_adocao', strip_tags( $_POST['data_adocao'] ) );
      update_post_meta( $adocao_id, 'data_final', strip_tags( $_POST['data_final'] ) ); 
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-adocao_columns', 'cria_edit_adocao_columns' ) ;

function cria_edit_adocao_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Adocao' ),
  'animal' => __('Animal'),
  'data_adocao' => __('Data da Adocao'),
  'data_final' => __('Data Final Adocao'),
  'adotante' => __('Adotante'),
  'thumbnail' => __('Foto')
);

return $columns;
}
add_action( 'manage_adocao_posts_custom_column', 'cria_manage_adocao_columns', 10, 2 );

function cria_manage_adocao_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

  	case 'animal' :

      $animal = get_post_meta( $post_id, 'animal_adocao', true );

      if ( empty( $animal ) )

      	echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      $animal = get_post($animal);

      echo "<strong>$animal->post_title</strong>"; 
     break;

    case 'data_adocao' :

      $dataresgate = get_post_meta( $post_id, 'data_adocao', true );

      if ( empty( $dataresgate ) )

      echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      echo "<strong>". date("d/m/Y", strtotime($dataresgate))."</strong>"; 
    break;

    case 'data_final' :

      $datafinal = get_post_meta( $post_id, 'data_final', true );

      if ( empty( $datafinal ) )

      echo "<strong>".__( 'Adocao Definitiva' ) ."</strong>";

      else
      echo "<strong>". date("d/m/Y", strtotime($datafinal))."</strong>"; 
    break;

    case 'adotante' :

      $adotante = get_post_meta( $post_id, 'adotante_animal', true );

      if ( empty( $adotante ) )

      	echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      $adotante = get_post($adotante);

      echo "<strong>$adotante->post_title</strong>"; 
     break;
     
    case 'thumbnail' :

      if (has_post_thumbnail($post->ID))

      echo get_the_post_thumbnail($post->ID, array(90, 90));

      else

      echo '<em>Sem Miniatura</em>';
    break;
  } 
}