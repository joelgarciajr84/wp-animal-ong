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
    <input  type="date" class="widefat" id="data_resgate" name="data_resgate" value="<?php echo get_post_meta( $animal->ID, 'data_resgate', true ); ?>" />
  </p>

<?php  

$resgatantelancamento = get_post_meta( $animal->ID, 'resgatante', true );

$args = array(
  'numberposts' => -1,
  'post_type' => 'apoiador',
  'suppress_filters' => false, 
  'tax_query' => array(
  array(
    'taxonomy' => 'tax_tipo_apoiador',
    'field' => 'slug', 
    'terms' => 'resgate'
    )));
$resgatantes = get_posts($args);

echo '<strong>Resgatante</strong>';

echo '<select class="widefat" name="resgatante" id="resgatante">';

echo '<option value="">Selecione o Resgatante:</option>';


foreach ($resgatantes as $resgatante) {
?>
<option value="<?php echo $resgatante->ID?>" <?php if ($resgatantelancamento == $resgatante->ID ){echo 'SELECTED';}?>> <?php echo $resgatante->post_title?></option>
<?php 
}

echo '</select>';
}

#Metabox Informações do Local do Resgate

add_action( 'add_meta_boxes', 'local_resgate_dados' );

function local_resgate_dados() {
  add_meta_box(
    'local_resgate_id',
    __('Local do Resgate','wpanimal'),
    'animal_resgate',
    'animal',
    'normal'
  );
}
function animal_resgate($animal) {

?>
<p>
  <label  for="rua">Rua:</label>
  <br />
  <input  type="text" class="widefat" name="rua" value="<?php echo get_post_meta( $animal->ID, 'rua', true ); ?>" />
</p>
<p>
  <label  for="nr">Número:</label>
  <br />
  <input  type="text" name="nr" value="<?php echo get_post_meta( $animal->ID, 'nr', true ); ?>" />
</p>
<p>
  <label  for="cpl">Complemento:</label>
  <br />
  <input  type="text" class="widefat" name="cpl" value="<?php echo get_post_meta( $animal->ID, 'cpl', true ); ?>" />
</p>
<p>
  <label  for="bairro">Bairro:</label>
  <br />
  <input  type="text" class="widefat" name="bairro" value="<?php echo get_post_meta( $animal->ID, 'bairro', true ); ?>" />
</p>
<p>
  <label  for="cidade">Cidade:</label>
  <br />
  <input  type="text" class="widefat" name="cidade" value="<?php echo get_post_meta( $animal->ID, 'cidade', true ); ?>" />
</p>
<p>
  <label for="est"> Estado: </label>
    <br />
<select name="est"> 
<?php
$valor = get_post_meta($animal->ID, 'est', true );
$values = array(
  ""=>"Escolha o Estado",
  "AC"=>"Acre",
  "AL"=>"Alagoas",
  "AM"=>"Amazonas",
  "AP"=>"Amapá",
  "BA"=>"Bahia",
  "CE"=>"Ceará",
  "DF"=>"Distrito Federal",
  "ES"=>"Espírito Santo",
  "GO"=>"Goiás",
  "MA"=>"Maranhão",
  "MT"=>"Mato Grosso",
  "MS"=>"Mato Grosso do Sul",
  "MG"=>"Minas Gerais",
  "PA"=>"Pará",
  "PB"=>"Paraíba",
  "PR"=>"Paraná",
  "PE"=>"Pernambuco",
  "PI"=>"Piauí",
  "RJ"=>"Rio de Janeiro",
  "RN"=>"Rio Grande do Norte",
  "RO"=>"Rondônia",
  "RS"=>"Rio Grande do Sul",
  "RR"=>"Roraima",
  "SC"=>"Santa Catarina",
  "SE"=>"Sergipe",
  "SP"=>"São Paulo",
  "TO"=>"Tocantins"
  );

foreach ($values as $val) {
  ?>
  <option value="<?php echo $val?>" <?php if ($valor==$val ){echo 'SELECTED';}?>> <?php echo $val?></option>
  <?php
}
?>
</select> 
</p>
<?php
}
add_action( 'save_post', 'salva_metas_animais', 10, 2 );

function salva_metas_animais( $animal_id, $animal ) {

  global $post;

  if ($post->post_type == 'animal') {

    if(!defined('DOING_AJAX')) {

      update_post_meta( $animal_id, 'data_resgate', strip_tags( $_POST['data_resgate'] ) );
      update_post_meta( $animal_id, 'rua', strip_tags( $_POST['rua'] ) );
      update_post_meta( $animal_id, 'nr', strip_tags( $_POST['nr'] ) );
      update_post_meta( $animal_id, 'cpl', strip_tags( $_POST['cpl'] ) );
      update_post_meta( $animal_id, 'bairro', strip_tags( $_POST['bairro'] ) );
      update_post_meta( $animal_id, 'cidade', strip_tags( $_POST['cidade'] ) );
      update_post_meta( $animal_id, 'est', strip_tags( $_POST['est'] ) );
      update_post_meta( $animal_id, 'resgatante', strip_tags( $_POST['resgatante'] ) );
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
  'resgatante' => __('Resgatante'),
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

      echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      echo "<strong>". date("d/m/Y", strtotime($dataresgate))."</strong>"; 
    break;

    case 'resgatante' :

      $resgatante = get_post_meta( $post_id, 'resgatante', true );

      if ( empty( $resgatante ) )

      echo "<strong>".__( 'Não cadastrado' ) ."</strong>";

      else
      $resgatante = get_post($resgatante);

      echo "<strong>$resgatante->post_title</strong>"; 
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