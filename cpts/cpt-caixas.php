<?php

#Custom Post Type - Cadastro de Caixas

add_action( 'init', 'register_cpt_caixas' );

function register_cpt_caixas() {

	$labels = array(
		'name' => __('Caixas','wpanimal'),
		'singular_name' => __('Caixas','wpanimal'),
		'add_new' => __('Adicionar Caixa','wpanimal'),
		'add_new_item' => __('Adicionar Caixa','wpanimal'),
		'edit_item' => __('Editar Caixa','wpanimal'),
		'new_item' => __('Novo Caixa','wpanimal'),
		'view_item' => __('Ver Caixa','wpanimal'),
		'search_items' => __('Pesquisar','wpanimal'),
		'not_found' => __('Nada Aqui','wpanimal'),
		'not_found_in_trash' => __('Nada Aqui','wpanimal'),
		'parent_item_colon' => __('Caixas','wpanimal'),
		'menu_name' => __('Caixas','wpanimal'),
	);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'description' => 'Lida com Caixas',
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
		'capability_type' => 'caixas',
		'capabilities' => array(
			'publish_posts' => 'publish_caixas',
			'edit_posts' => 'edit_caixas',
			'edit_others_posts' => 'edit_others_caixas',
			'delete_posts' => 'delete_caixas',
			'delete_others_posts' => 'delete_others_caixas',
			'read_private_posts' => 'read_private_caixas',
			'publish_post' => 'publish_caixa',
			'edit_post' => 'edit_caixa',
			'delete_post' => 'delete_caixa',
			'read_post' => 'read_caixa',
		),
	);
  register_post_type( 'caixas', $args );
}
#Metabox Informações dos caixas

add_action( 'add_meta_boxes', 'caixas_dados' );

function caixas_dados() {
  add_meta_box(
    'caixas_id',
    __('Dados do Caixa','wpanimal'),
    'caixas',
    'caixas',
    'side'
  );
}
function caixas($caixas) {
	setlocale(LC_MONETARY, 'pt_BR');

  	$saldoatual = floatval(get_post_meta( $caixas->ID, 'saldo', true ));
?>
  <p align="center">
    <strong style="font-size: 16px;">:: Saldo Atual :: </strong>
    <br>
    <?php

switch ($saldoatual) {
	case (empty($saldoatual)):

		$saldoatual = floatval(0);

		echo '<strong style="font-size: 16px;">R$</strong><input style="width: 89%; color:green; height: 40px;font-size: 16px;" type="text" name="saldo" disabled value=' . $saldoatual;'/>';
	break;

	case ($saldoatual< floatval(0)):


		echo '<strong style="font-size: 16px;">R$</strong><input style="width: 89%; color:green; height: 40px;font-size: 16px;" type="text" name="saldo" disabled value=' . $saldoatual;'/>';
	break;
	
	default:
		echo '<strong style="font-size: 16px;">R$</strong><input style="width: 89%; color:green; height: 40px;font-size: 16px;" type="text" name="saldo" disabled value=' . $saldoatual;'/>';
		break;
}
     ?>
  </p>
  <p align="center">
    <strong style="font-size: 16px;">:: Responsavel :: </strong>
    <br />
    <input required style="width: 100%; color:green; height: 40px;font-size: 16px;"  type="text" name="responsavel" value="<?php echo get_post_meta( $caixas->ID, 'responsavel', true ); ?>" />
  </p>
<?php
}
#Metabox Informações dos caixas

add_action( 'add_meta_boxes', 'snippet_report_caixa' );

function snippet_report_caixa() {
  add_meta_box(
    'snippet_report_caixa_id',
    __('Movimentações recentes neste caixa','wpanimal'),
    'inner_movimentacao',
    'caixas',
    'normal'
  );
}
function inner_movimentacao($caixas){?>

	<style type="text/css">

	.tg  {
		border-collapse:collapse;
		border-spacing:0;
		border-color:#aabcfe;
		width: 100%;
	}
	.tg td{
		font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;
		border-style:solid;border-width:1px;
		overflow:hidden;word-break:normal;
		border-color:#aabcfe;
		color:#669;
		background-color:#e8edff;
	}
	.tg th{
		font-family:Arial, sans-serif;
		font-size:14px;
		font-weight:normal;
		padding:10px 5px;
		border-style:solid;
		border-width:1px;
		overflow:hidden;
		word-break:normal;
		border-color:#aabcfe;
		color:#039;
		background-color:#b9c9fe;
	}

	</style>
<?php
	$args = array(
		'posts_per_page'   => 5,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'meta_key'         => 'caixa_lancamento',
		'meta_value'       =>  $caixas->ID,
		'post_type'        => 'lancamentocaixa',
		'post_status'      => 'publish',
		'suppress_filters' => true 
	);
	$ultimoslancamentos = get_posts( $args );

	if(!is_array($ultimoslancamentos) || empty($ultimoslancamentos)){
		return;
	}
	?>
	<table class="tg">
		<tr>
			<th class="tg-031e"><?php  echo __( 'ID' ); ?></th>
			<th class="tg-031e"><?php  echo __( 'Lançamento' ); ?></th>
			<th class="tg-031e"><?php  echo __( 'Valor' ); ?></th>
			<th class="tg-031e"><?php  echo __( 'Tipo' ); ?></th>
			<th class="tg-031e"><?php  echo __( 'Data' ); ?></th>
			<th class="tg-031e"><?php  echo __( 'Usuario' ); ?></th>
		</tr>
		
		<?php foreach ($ultimoslancamentos as $lancamento):?>

			<tr>
				<td class="tg-031e"><?php echo $lancamento->ID; ?></td>
				<td class="tg-031e"><?php echo $lancamento->post_title; ?></td>
				<td class="tg-031e"><?php echo get_post_meta($lancamento->ID, 'valor_lancamento', true); ?></td>
				<td class="tg-031e"><?php echo get_post_meta($lancamento->ID, 'tipo_lancamento', true); ?></td>
				<td class="tg-031e"><?php echo date(('d/m/Y H:i:s'), strtotime($lancamento->post_date)); ?></td>
				<td class="tg-031e"><?php echo get_the_author_meta( 'user_nicename', $lancamento->post_author );?></td>
			</tr>	
		<?php endforeach; ?>
	
	</table>
<?php
}
add_action( 'save_post', 'salva_metas_caixas', 10, 2 );

function salva_metas_caixas( $caixas_id, $caixas ) {

  global $post;

  if ($post->post_type == 'caixas') {

    if(!defined('DOING_AJAX')) {
      update_post_meta( $caixas_id, 'responsavel', strip_tags( $_POST['responsavel'] ) );
    }
  }
  return true;
}
# Colunas Externas
add_filter( 'manage_edit-caixas_columns', 'cria_edit_caixas_columns' ) ;

function cria_edit_caixas_columns( $columns ) {

$columns = array(
  'cb' => '<input type="checkbox" />',
  'title' => __( 'Caixa' ),
  'responsavel' => __('Responsavel'),
  'saldo' => __('Saldo')
);

return $columns;
}
add_action( 'manage_caixas_posts_custom_column', 'cria_manage_caixas_columns', 10, 2 );

function cria_manage_caixas_columns( $column, $post_id ) {
  global $post;

  switch( $column ) {

    case 'responsavel' :

      $responsavel = get_post_meta( $post_id, 'responsavel', true );

      if ( empty( $responsavel ) )

      echo __( 'Não cadastrado' );

      else
      echo "<strong>$responsavel</strong>"; 
    break;

    case 'saldo' :

      $saldo = get_post_meta( $post_id, 'saldo', true );

      if ($saldo < 0) {

        echo '<strong style="color: red";>'. "R$ " . $saldo . '</strong>'; 
      }
      elseif($saldo >= 0){

        echo '<strong style="color: green";>'. "R$ " . $saldo . '</strong>'; 
      }elseif($saldo == 0){

        echo '<strong style="color: orange";>'. "R$ 0,00" .'</strong>'; 
      }
      break;
    } 
  }