<?php 

#Custom Post Type - Procedimentos

add_action( 'init', 'register_cpt_procedimentos' );

function register_cpt_procedimentos() {

  $labels = array( 
    'name' => __('Procedimentos','wpanimal'),
    'singular_name' => __('Procedimentos','wpanimal'),
    'add_new' => __('Adicionar Procedimentos','wpanimal'),
    'add_new_item' => __('Fazer novo Procedimento','wpanimal'),
    'edit_item' => __('Editar Procedimentos','wpanimal'),
    'new_item' => __('Novo Procedimento','wpanimal'),
    'view_item' => __('Ver Procedimentos','wpanimal'),
    'search_items' => __('Pesquisar','wpanimal'),
    'not_found' => __('Nada Aqui','wpanimal'),
    'not_found_in_trash' => __('Nada Aqui','wpanimal'),
    'parent_item_colon' => __('Procedimentos','wpanimal'),
    'menu_name' => __('Procedimentos','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Lida com Procedimentos Ambulatoriais dos animais',
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
  register_post_type( 'procedimento', $args );
}
# Metabox dados do Procedimento

add_action( 'add_meta_boxes', 'dados_procedimento' );

function dados_procedimento() {
  add_meta_box(
    'dados_procedimento_id',
    __('Dados do Procedimento','wpanimal'),
    'procedimento',
    'procedimento',
    'side'
  );
}
function procedimento($procedimento) {

//Selecao do animal
  $animalprocedimento = get_post_meta( $procedimento->ID, 'animal_procedimento', true );

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


  echo '<select class="widefat" name="animal_procedimento" id="animal_procedimento">';

  echo '<option value="">Selecione um Animal</option>';

  foreach ($animais as $animal) {
  ?>
    <option value="<?php echo $animal->ID?>" <?php if ($animalprocedimento == $animal->ID ){echo 'SELECTED';}?>> <?php echo $animal->post_title?></option>
  <?php 
  }

  echo '</select>';
  echo '<br><br>';

//Selecao do Veterinario
  $veterinarioescolhido = get_post_meta( $procedimento->ID, 'veterinario_animal', true );

  $args = array(

    'posts_per_page'   => -1,
    'orderby'          => 'post_date',
    'order'            => 'DESC',
    'post_type'        => 'veterinario',
    'post_status'      => 'publish',
    'suppress_filters' => true 
  );
  $veterinarios = get_posts( $args );

  echo '<strong>Veterinario</strong>';

  echo '<select class="widefat" name="veterinario_animal" id="veterinario_animal">';

  echo '<option value="">Selecione um Veterinario</option>';

 
  foreach ($veterinarios as $veterinario) {
  ?>
    <option value="<?php echo $veterinario->ID?>" <?php if ($veterinarioescolhido == $veterinario->ID ){echo 'SELECTED';}?>> <?php echo $veterinario->post_title?></option>
  <?php 
  }

  echo '</select>';
?>
  <p>
    <strong><label  for="data_procedimento">Data procedimento:</label></strong>
    <br />
    <p><input  type="date" class="widefat"  name="data_procedimento" value="<?php echo get_post_meta( $procedimento->ID, 'data_procedimento', true ); ?>" /></p>
  </p>
<?php
}
#Salvamento
add_action( 'save_post', 'salva_metas_procedimento', 10, 2 );

function salva_metas_procedimento( $procedimento_id, $procedimento ) {

  global $post;

  if ($post->post_type == 'procedimento') {

    if(!defined('DOING_AJAX')) {

      update_post_meta( $procedimento_id, 'animal_procedimento', strip_tags( $_POST['animal_procedimento'] ) );
      update_post_meta( $procedimento_id, 'veterinario_animal', strip_tags( $_POST['veterinario_animal'] ) );
      update_post_meta( $procedimento_id, 'data_procedimento', strip_tags( $_POST['data_procedimento'] ) );
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-procedimento_columns', 'cria_edit_procedimento_columns' ) ;

function cria_edit_procedimento_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Procedimento' ),
  'animal' => __('Animal'),
  'data_procedimento' => __('Data da Procedimento'),
  'veterinario' => __('Veterinario'),
  //'thumbnail' => __('Foto')
);

return $columns;
}
add_action( 'manage_procedimento_posts_custom_column', 'cria_manage_procedimento_columns', 10, 2 );

function cria_manage_procedimento_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

  	case 'animal' :

      $animal = get_post_meta( $post_id, 'animal_procedimento', true );

      if ( empty( $animal ) )

      	echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      $animal = get_post($animal);

      echo "<strong>$animal->post_title</strong>"; 
     break;

    case 'data_procedimento' :

      $dataresgate = get_post_meta( $post_id, 'data_procedimento', true );

      if ( empty( $dataresgate ) )

      echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      echo "<strong>". date("d/m/Y", strtotime($dataresgate))."</strong>"; 
    break;

    case 'veterinario' :

      $veterinario = get_post_meta( $post_id, 'veterinario_animal', true );

      if ( empty( $veterinario ) )

      	echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      $veterinario = get_post($veterinario);

      echo "<strong>$veterinario->post_title</strong>"; 
     break;
     
    /*

    case 'thumbnail' :

      if (has_post_thumbnail($post->ID))

      echo get_the_post_thumbnail($post->ID, array(90, 90));

      else

      echo '<em>Sem Miniatura</em>';
    break;
    
    */
  } 
}