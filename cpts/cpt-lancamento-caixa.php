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
    'show_in_menu' => 'menu-financeiro',
    'menu_position' => 5,
    'show_in_nav_menus' => true,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => true,
     'capability_type' => 'lancamentocaixa',
    'capabilities' => array(
		'publish_posts' => 'publish_lancamentocaixa',
		'edit_posts' => 'edit_lancamentocaixa',
		'edit_others_posts' => 'edit_others_lancamentocaixa',
		'delete_posts' => 'delete_lancamentocaixa',
		'delete_others_posts' => 'delete_others_lancamentocaixa',
		'read_private_posts' => 'read_private_lancamentocaixa',
		'edit_post' => 'edit_lancamentocaixa',
		'delete_post' => 'delete_lancamentocaixa',
		'read_post' => 'read_lancamentocaixa',
	),
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
?>
  <script>
  function moeda(z){

    v = z.value;
    v=v.replace(/\D/g,"")  //permite digitar apenas números
    v=v.replace(/[0-9]{12}/,"inválido")   //limita pra máximo 999.999.999,99
    //v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")  //coloca ponto antes dos últimos 8 digitos
    //v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  //coloca ponto antes dos últimos 5 digitos
    v=v.replace(/(\d{1})(\d{1,2})$/,"$1.$2")  //coloca virgula antes dos últimos 2 digitos
    z.value = v;

  }
</script>
<?php
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


  echo '<label style="height:2px;"><strong style="font-size: 14px;">Caixa:</strong></label>';

  echo '<br><br>';

  echo '<select required style="width: 100%; color: blue; font-size: 14px;" name="caixa_lancamento" id="caixa_lancamento">';

  echo '<option value="">Selecione um Caixa</option>';

  foreach ($caixaescolhido as $caixa) {
  ?>
    <option value="<?php echo $caixa->ID?>" <?php if ($caixalancamento == $caixa->ID ){echo 'SELECTED';}?>> <?php echo $caixa->post_title?></option>
  <?php 
  }
  echo '</select>';
  echo '<hr>';
?>
   <label style="height:2px;"><strong style="font-size: 14px;">Valor:</strong></label>
<br>
    <p>R$ <input required style="width: 90%; color: blue; font-size: 14px;" type="text" name="valor_lancamento" onKeyUp="moeda(this)" value="<?php echo get_post_meta( $lancamentocaixa->ID, 'valor_lancamento', true ); ?>" /></p>
  </p>
<hr>
<?php
  $tipos = array("Entrada","Saida");

  foreach ($tipos as $tipo) {
  ?>
    <input required type="radio" name="tipo_lancamento" value="<?php echo $tipo ?>"<?php if ($tipolancamento == $tipo) {echo 'CHECKED';} ?>> <?php echo $tipo ?>
  <?php
  }
}
add_action( 'save_post', 'salva_metas_lancamentocaixa', 10, 2 );


function salva_metas_lancamentocaixa( $lancamentocaixa_id, $lancamentocaixa ) {

  setlocale(LC_MONETARY, 'pt_BR');
  global $post;

  if ($post->post_type == 'lancamentocaixa') {


    if(!defined('DOING_AJAX')) {


 #Salvamentos

      update_post_meta( $lancamentocaixa_id, 'valor_lancamento', $_POST['valor_lancamento']);
      update_post_meta( $lancamentocaixa_id, 'caixa_lancamento', strip_tags( $_POST['caixa_lancamento'] ) );
      update_post_meta( $lancamentocaixa_id, 'tipo_lancamento', strip_tags( $_POST['tipo_lancamento'] ) );

      $caixalancamento = floatval($_POST['caixa_lancamento']);
      $valordolancamento = floatval($_POST['valor_lancamento']);

      $saldoatual = floatval(get_post_meta($caixalancamento, "saldo", true));

      $saldoatual = floatval($saldoatual);

      $valordolancamento = floatval($valordolancamento);

      #Tratamento para atualizar Saldo do Caixa

      if ($_POST['tipo_lancamento'] == "Entrada") {

        $novosaldo = $saldoatual + $valordolancamento;

      }elseif ($_POST['tipo_lancamento'] == "Saida"){

        $novosaldo = $saldoatual - $valordolancamento;
      }

      #Atualiza saldo do Caixa baseado no valor da movimentacao

      update_post_meta($caixalancamento, 'saldo', floatval($novosaldo));
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
    'caixa' => __('Caixa'),
    'valor' => __('Valor'),
    'operacao' => __('Operacao'),
    'usuario' => __('Usuario'),
  );

  return $columns;
}
add_action( 'manage_lancamentocaixa_posts_custom_column', 'cria_manage_lancamentocaixa_columns', 10, 2 );

function cria_manage_lancamentocaixa_columns( $column, $post_id ) {
  global $post;

  $caixalancamento = get_post_meta( $post->ID, 'caixa_lancamento', true );

  $tipolancamento = get_post_meta( $post->ID, 'tipo_lancamento', true );

  switch( $column ) {

    case 'caixa' :

      $caixa = get_post($caixalancamento);

      if ( empty( $caixa ) )

        echo __( 'Não cadastrado' );
      else
        echo '<strong>'. $caixa->post_title;  '</strong>';
    break;

    case 'valor' :

      $valor = get_post_meta( $post_id, 'valor_lancamento', true );

      if ( empty( $valor ) )

        echo __( 'Não cadastrado' );
      else

        if ($tipolancamento == "Entrada") {


         echo '<strong style="color: green";>'. "R$ " . $valor . '</strong>'; 
        }elseif ($tipolancamento == "Saida") {

          echo '<strong style="color: red";>'. "R$ " . $valor . '</strong>'; 
        }
    break;

    case 'operacao' :

      if ( empty( $tipolancamento ) )

        echo __( 'Não cadastrado' );
      else
        echo '<strong>'. $tipolancamento;  '</strong>';
    break;

     case 'usuario' :

        echo '<strong>'. the_modified_author();  '</strong>';
    break;
  } 
}