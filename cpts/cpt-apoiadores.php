<?php 

#Custom Post Type - Cadastro de Apoiadores

add_action( 'init', 'register_cpt_apoiadores' );

function register_cpt_apoiadores() {

  $labels = array( 
    'name' => __('Apoiador','wpanimal'),
    'singular_name' => __( 'Apoiador','wpanimal'),
    'add_new' => __('Adicionar Apoiador','wpanimal'),
    'add_new_item' => __( 'Adicionar Apoiador','wpanimal'),
    'edit_item' => __( 'Editar Apoiador','wpanimal'),
    'new_item' => __( 'Novo Apoiador','wpanimal'),
    'view_item' => __( 'Ver Apoiador','wpanimal'),
    'search_items' => __( 'Pesquisar','wpanimal'),
    'not_found' => __( 'Nada Aqui','wpanimal'),
    'not_found_in_trash' => __( 'Nada Aqui','wpanimal'),
    'parent_item_colon' => __( 'Apoiadores','wpanimal'),
    'menu_name' => __( 'Apoiador','wpanimal'),
  );
  $args = array( 
    'labels' => $labels,
    'hierarchical' => true,
    'description' => 'Adicionar Apoiador',
    'supports' => array('title','thumbnail', 'editor'),
    'taxonomies' => array(''),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => 'menu-apoiadores',
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
  register_post_type( 'apoiador', $args );
}
#Metabox Informações dos apoiador

add_action( 'add_meta_boxes', 'apoiador_dados' );

function apoiador_dados() {
    add_meta_box(
        'apoiador_id',
        __('Dados da Pessoa','wpanimal'),
        'apoiador',
        'apoiador',
        'normal'
    );
}
function apoiador($apoiador) {?>
<style>
.cadastro{
  width: 100%;
  height: 400px;
  position: relative;
}
.rua {
  width: 30%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.numero {
  width: 8%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.bairro {
  width: 18%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.cidade {
  width: 40%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.estado {
  width: 40%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.email {
  width: 30%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.cpf {
  width: 20%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.telefone {
  width: 20%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.celular {
  width: 20%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.nascimento {
  width: 21%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.sexo {
  width: 15%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
.inputs{
  width: 18%;
  height: 30px;
  font-size: 16px;
  color: #0085cf !important;
  position: relative;
}
</style>
<div class="cadastro">
<p>
<strong>Rua:</strong>

  <input required class="rua" type="text" name="rua" value="<?php echo get_post_meta( $apoiador->ID, 'rua', true ); ?>" />

  <strong>Numero: </strong>

  <input required  type="text" class="numero" name="nr" value="<?php echo get_post_meta( $apoiador->ID, 'nr', true ); ?>" />

 <strong>Complemento: </strong>

  <input  type="text" class="inputs" name="cpl" value="<?php echo get_post_meta( $apoiador->ID, 'cpl', true ); ?>" />
</p>
<p>
<strong>Bairro: </strong>

  <input required  type="text" class="bairro" name="bairro" value="<?php echo get_post_meta( $apoiador->ID, 'bairro', true ); ?>" />
</p>
  <strong>Cidade: </strong>
  
  <input required type="text" name="cidade" class="cidade" value="<?php echo get_post_meta( $apoiador->ID, 'cidade', true ); ?>" />

  <strong>Estado: </strong>

<select class="estado" name="est"> 
<?php
$valor = get_post_meta($apoiador->ID, 'est', true );
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
 <strong>Telefone: </strong>
  
  <input required  type="tel" id="tel" name="fone" class="telefone" value="<?php echo get_post_meta( $apoiador->ID, 'fone', true ); ?>" /> 

  <strong>Celular: </strong>

  <input   type="tel" id="telad" name="celular" class="celular" value="<?php echo get_post_meta( $apoiador->ID, 'celular', true ); ?>" />
<strong>Sexo: </strong>

<select class="sexo" name="sexo"> 
<?php
$valor = get_post_meta($apoiador->ID, 'sexo', true );
$values = array(""=> "Escolha o Sexo","M"=> "Masculino","F"=> "Feminino");

foreach ($values as $val) {?>
  <option value="<?php echo $val?>" <?php if ($valor==$val ){echo 'SELECTED';}?>> <?php echo $val?></option>
  <?php
}
?>
</select> 

</p>
<p>
  <strong>Email: </strong>
 
  <input  type="email" class="email" name="email" value="<?php echo get_post_meta( $apoiador->ID, 'email', true ); ?>" />

  <strong>CPF: </strong>
  
  <input  type="text" id="cpf1" name="cpf" class="cpf" value="<?php echo get_post_meta( $apoiador->ID, 'cpf', true ); ?>" />
</p>
<strong>Data de Nascimento: </strong>
  <input  type="date" class="nascimento"  name="nasci" value="<?php echo get_post_meta( $apoiador->ID, 'nasci', true ); ?>" />


</p>
</div>
<?php
}
add_action( 'save_post', 'salva_metas', 10, 2 );

function salva_metas( $apoiador_id, $apoiador ) {

  global $post;

  if ($post->post_type == 'apoiador') {


    if(!defined('DOING_AJAX')) {

      update_post_meta( $apoiador_id, 'nacionalidade', strip_tags( $_POST['nacionalidade'] ) );
      update_post_meta( $apoiador_id, 'cnatal', strip_tags( $_POST['cnatal'] ) );
      update_post_meta( $apoiador_id, 'email', strip_tags( $_POST['email'] ) );
      update_post_meta( $apoiador_id, 'fone', strip_tags( $_POST['fone'] ) );
      update_post_meta( $apoiador_id, 'celular', strip_tags( $_POST['celular'] ) );
      update_post_meta( $apoiador_id, 'nasci', strip_tags( $_POST['nasci'] ) );
      update_post_meta( $apoiador_id, 'rua', strip_tags( $_POST['rua'] ) );
      update_post_meta( $apoiador_id, 'nr', strip_tags( $_POST['nr'] ) );
      update_post_meta( $apoiador_id, 'cpl', strip_tags( $_POST['cpl'] ) );
      update_post_meta( $apoiador_id, 'bairro', strip_tags( $_POST['bairro'] ) );
      update_post_meta( $apoiador_id, 'cidade', strip_tags( $_POST['cidade'] ) );
      update_post_meta( $apoiador_id, 'cpf', strip_tags( $_POST['cpf'] ) );


      #Estado
      $estado = strip_tags( $_POST['est'] );
      if ($estado == "Escolha o Estado"){ $estado = '';}
      update_post_meta( $apoiador_id, 'est',$estado);

      #Sexo
      $sexo = strip_tags( $_POST['sexo'] );
      if ($sexo == "Escolha o Sexo"){ $sexo = '';}
      update_post_meta( $apoiador_id, 'sexo',$sexo);
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-apoiador_columns', 'cria_edit_apoiador_columns' ) ;

function cria_edit_apoiador_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Apoiador' ),
  'Cidade' => __('Cidade'),
  'Bairro' => __('Bairro'),
  'Telefone' => __('Telefone'),
  'thumbnail' => __('Foto')
);

return $columns;
}
add_action( 'manage_apoiador_posts_custom_column', 'cria_manage_apoiador_columns', 10, 2 );

function cria_manage_apoiador_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'Cidade' :

      $cidade = get_post_meta( $post_id, 'cidade', true );

      if ( empty( $cidade ) )

      echo __( 'Não cadastrado' );

      else
      echo "<strong>$cidade</strong>";
    break;

    case 'Bairro' :

      $bairro = get_post_meta( $post_id, 'bairro', true );

      if ( empty( $bairro ) )

      echo __( 'Não cadastrado' );

      else
       echo "<strong>$bairro</strong>"; 
     break;
     case 'Telefone' :

      $telefone = get_post_meta( $post_id, 'fone', true );

      if ( empty( $telefone ) )

      echo __( 'Não cadastrado' );

      else
       echo "<strong>$telefone</strong>"; 
    break;

    case 'thumbnail' :

      if (has_post_thumbnail($post->ID))

      echo get_the_post_thumbnail($post->ID, array(90, 90));

      else

      echo '<em>Sem Miniatura</em>';
    break;
  }
}