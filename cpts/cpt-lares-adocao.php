<?php 

#Custom Post Type - Cadastro de Lares para Adocao

add_action( 'init', 'register_cpt_lares_adocao' );

function register_cpt_lares_adocao() {

  $labels = array( 
    'name' => __('Lar','wpanimal'),
    'singular_name' => __( 'Lar','wpanimal'),
    'add_new' => __('Adicionar Lar','wpanimal'),
    'add_new_item' => __( 'Adicionar Lar','wpanimal'),
    'edit_item' => __( 'Editar Lar','wpanimal'),
    'new_item' => __( 'Novo Lar','wpanimal'),
    'view_item' => __( 'Ver Lar','wpanimal'),
    'search_items' => __( 'Pesquisar','wpanimal'),
    'not_found' => __( 'Nada Aqui','wpanimal'),
    'not_found_in_trash' => __( 'Nada Aqui','wpanimal'),
    'parent_item_colon' => __( 'Lares','wpanimal'),
    'menu_name' => __( 'Lares','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Adicionar Lar',
    'supports' => array('title','thumbnail', 'editor'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'menu-lares',
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
  register_post_type( 'lar', $args );
}
#Metabox Informações dos Lares para Adocao

add_action( 'add_meta_boxes', 'lares_dados' );

function lares_dados() {
    add_meta_box(
        'lares_id',
        __('Dados do lares','wpanimal'),
        'lar',
        'lar',
        'normal'
    );
}
function lar($lar) {

?>
<p>
  <label  for="rua">Rua:</label>
  <br />
  <input  type="text" class="widefat" name="rua" value="<?php echo get_post_meta( $lar->ID, 'rua', true ); ?>" />
</p>
<p>
  <label  for="nr">Número:</label>
  <br />
  <input  type="text" name="nr" value="<?php echo get_post_meta( $lar->ID, 'nr', true ); ?>" />
</p>
<p>
  <label  for="cpl">Complemento:</label>
  <br />
  <input  type="text" class="widefat" name="cpl" value="<?php echo get_post_meta( $lar->ID, 'cpl', true ); ?>" />
</p>
<p>
  <label  for="bairro">Bairro:</label>
  <br />
  <input  type="text" class="widefat" name="bairro" value="<?php echo get_post_meta( $lar->ID, 'bairro', true ); ?>" />
</p>
<p>
  <label  for="cidade">Cidade:</label>
  <br />
  <input  type="text" class="widefat" name="cidade" value="<?php echo get_post_meta( $lar->ID, 'cidade', true ); ?>" />
</p>
<p>
  <label for="est"> Estado: </label>
    <br />
<select name="est"> 
<?php
$valor = get_post_meta($lar->ID, 'est', true );
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
  <input  type="email" class="widefat" name="email" value="<?php echo get_post_meta( $lar->ID, 'email', true ); ?>" />
</p>
<p>
  <label  for="fone">Telefone:</label>
  <br />
  <input  type="tel" id="tel" class="widefat" name="fone" value="<?php echo get_post_meta( $lar->ID, 'fone', true ); ?>" />
</p>
<p>
  <label  for="fone2">Telefone Adicional:</label>
  <br />
  <input  type="tel" id="telad" name="fone2" value="<?php echo get_post_meta( $lar->ID, 'fone2', true ); ?>" />
</p>

<?php
}
add_action( 'save_post', 'salva_metas_lars', 10, 2 );

function salva_metas_lars( $lar_id, $lar ) {

  global $post;

  if ($post->post_type == 'lar') {


    if(!defined('DOING_AJAX')) {

      update_post_meta( $lar_id, 'email', strip_tags( $_POST['email'] ) );
      update_post_meta( $lar_id, 'fone', strip_tags( $_POST['fone'] ) );
      update_post_meta( $lar_id, 'fone2', strip_tags( $_POST['fone2'] ) );
      update_post_meta( $lar_id, 'rua', strip_tags( $_POST['rua'] ) );
      update_post_meta( $lar_id, 'nr', strip_tags( $_POST['nr'] ) );
      update_post_meta( $lar_id, 'cpl', strip_tags( $_POST['cpl'] ) );
      update_post_meta( $lar_id, 'bairro', strip_tags( $_POST['bairro'] ) );
      update_post_meta( $lar_id, 'cidade', strip_tags( $_POST['cidade'] ) );


      #Estado
      $estado = strip_tags( $_POST['est'] );
      if ($estado == "Escolha o Estado"){ $estado = '';}
      update_post_meta( $lar_id, 'est',$estado);

      #Sexo
      $sexo = strip_tags( $_POST['sexo'] );
      if ($sexo == "Escolha o Sexo"){ $sexo = '';}
      update_post_meta( $lar_id, 'sexo',$sexo);
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-lar_columns', 'cria_edit_lar_columns' ) ;

function cria_edit_lar_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Lar' ),
  'Cidade' => __('Cidade'),
  'Bairro' => __('Bairro'),
  'Telefone' => __('Telefone'),
  'thumbnail' => __('Foto')
);

return $columns;
}
add_action( 'manage_lar_posts_custom_column', 'cria_manage_lar_columns', 10, 2 );

function cria_manage_lar_columns( $column, $post_id ) {
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