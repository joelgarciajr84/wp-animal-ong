<?php 

#Custom Post Type - Cadastro de Veterinarios

add_action( 'init', 'register_cpt_veterinarios' );

function register_cpt_veterinarios() {

  $labels = array( 
    'name' => __('Veterinario','wpanimal'),
    'singular_name' => __( 'Veterinario','wpanimal'),
    'add_new' => __('Adicionar Veterinario','wpanimal'),
    'add_new_item' => __( 'Adicionar Veterinario','wpanimal'),
    'edit_item' => __( 'Editar Veterinario','wpanimal'),
    'new_item' => __( 'Novo Veterinario','wpanimal'),
    'view_item' => __( 'Ver Veterinario','wpanimal'),
    'search_items' => __( 'Pesquisar','wpanimal'),
    'not_found' => __( 'Nada Aqui','wpanimal'),
    'not_found_in_trash' => __( 'Nada Aqui','wpanimal'),
    'parent_item_colon' => __( 'Veterinarios','wpanimal'),
    'menu_name' => __( 'Veterinarios','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Adicionar Veterinario',
    'supports' => array('title','thumbnail', 'editor'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'menu-veterinarios',
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
  register_post_type( 'veterinario', $args );
}
#Metabox Informações dos Veterinarios

add_action( 'add_meta_boxes', 'veterinario_dados' );

function veterinario_dados() {
    add_meta_box(
        'veterinario_id',
        __('Dados do Veterinario','wpanimal'),
        'veterinario',
        'veterinario',
        'normal'
    );
}
function veterinario($veterinario) {

?>
<p>
  <label  for="rua">Rua:</label>
  <br />
  <input  type="text" class="widefat" name="rua" value="<?php echo get_post_meta( $veterinario->ID, 'rua', true ); ?>" />
</p>
<p>
  <label  for="nr">Número:</label>
  <br />
  <input  type="text" name="nr" value="<?php echo get_post_meta( $veterinario->ID, 'nr', true ); ?>" />
</p>
<p>
  <label  for="cpl">Complemento:</label>
  <br />
  <input  type="text" class="widefat" name="cpl" value="<?php echo get_post_meta( $veterinario->ID, 'cpl', true ); ?>" />
</p>
<p>
  <label  for="bairro">Bairro:</label>
  <br />
  <input  type="text" class="widefat" name="bairro" value="<?php echo get_post_meta( $veterinario->ID, 'bairro', true ); ?>" />
</p>
<p>
  <label  for="cidade">Cidade:</label>
  <br />
  <input  type="text" class="widefat" name="cidade" value="<?php echo get_post_meta( $veterinario->ID, 'cidade', true ); ?>" />
</p>
<p>
  <label for="est"> Estado: </label>
    <br />
<select name="est"> 
<?php
$valor = get_post_meta($veterinario->ID, 'est', true );
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
<p>
  <label for="email">Email:</label>
  <br />
  <input  type="email" class="widefat" name="email" value="<?php echo get_post_meta( $veterinario->ID, 'email', true ); ?>" />
</p>
<p>
  <label  for="fone">Telefone:</label>
  <br />
  <input  type="tel" id="tel" class="widefat" name="fone" value="<?php echo get_post_meta( $veterinario->ID, 'fone', true ); ?>" />
</p>
<p>
  <label  for="fone2">Telefone Adicional:</label>
  <br />
  <input  type="tel" id="telad" name="fone2" value="<?php echo get_post_meta( $veterinario->ID, 'fone2', true ); ?>" />
</p>

<?php
}
add_action( 'save_post', 'salva_metas_veterinarios', 10, 2 );

function salva_metas_veterinarios( $veterinario_id, $veterinario ) {

  global $post;

  if ($post->post_type == 'veterinario') {


    if(!defined('DOING_AJAX')) {

      update_post_meta( $veterinario_id, 'cnatal', strip_tags( $_POST['cnatal'] ) );
      update_post_meta( $veterinario_id, 'email', strip_tags( $_POST['email'] ) );
      update_post_meta( $veterinario_id, 'fone', strip_tags( $_POST['fone'] ) );
      update_post_meta( $veterinario_id, 'fone2', strip_tags( $_POST['fone2'] ) );
      update_post_meta( $veterinario_id, 'nasci', strip_tags( $_POST['nasci'] ) );
      update_post_meta( $veterinario_id, 'rua', strip_tags( $_POST['rua'] ) );
      update_post_meta( $veterinario_id, 'nr', strip_tags( $_POST['nr'] ) );
      update_post_meta( $veterinario_id, 'cpl', strip_tags( $_POST['cpl'] ) );
      update_post_meta( $veterinario_id, 'bairro', strip_tags( $_POST['bairro'] ) );
      update_post_meta( $veterinario_id, 'cidade', strip_tags( $_POST['cidade'] ) );


      #Estado
      $estado = strip_tags( $_POST['est'] );
      if ($estado == "Escolha o Estado"){ $estado = '';}
      update_post_meta( $veterinario_id, 'est',$estado);

    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-veterinario_columns', 'cria_edit_veterinario_columns' ) ;

function cria_edit_veterinario_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Veterinario' ),
  'Cidade' => __('Cidade'),
  'Bairro' => __('Bairro'),
  'Telefone' => __('Telefone'),
  'thumbnail' => __('Foto')
);

return $columns;
}
add_action( 'manage_veterinario_posts_custom_column', 'cria_manage_veterinario_columns', 10, 2 );

function cria_manage_veterinario_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'Cidade' :

      $cidade = get_post_meta( $post_id, 'cidade', true );

      if ( empty( $cidade ) )

      echo __( 'Não cadastrado' );

      else
            echo $cidade; 
    break;

    case 'Bairro' :

      $bairro = get_post_meta( $post_id, 'bairro', true );

      if ( empty( $bairro ) )

      echo __( 'Não cadastrado' );

      else
       echo $bairro; 
     break;
     case 'Telefone' :

      $telefone = get_post_meta( $post_id, 'fone', true );

      if ( empty( $telefone ) )

      echo __( 'Não cadastrado' );

      else
       echo $telefone; 
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