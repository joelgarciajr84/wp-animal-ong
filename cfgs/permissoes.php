<?php
function setPermissions(){

	$regras = get_editable_roles();

	$DefaultFinancePermissions = array(
		'publish_caixas',
		'edit_caixas',
		'edit_others_caixas',
		'delete_caixas',
		'delete_others_caixas',
		'read_private_caixas',
		'edit_caixas',
		'delete_caixas',
		'read_caixas',
		'publish_lancamentocaixa',
		'edit_lancamentocaixa',
		'edit_others_lancamentocaixa',
		'delete_lancamentocaixa',
		'delete_others_lancamentocaixa',
		'read_private_lancamentocaixa',
		'edit_lancamentocaixa',
		'delete_lancamentocaixa',
		'read_lancamentocaixa',
	);

	foreach (get_editable_roles() as $role_name => $role_info):

		$regra = get_role($role_name);

		foreach ($DefaultFinancePermissions as $finance_permission) {

			if($regra->name == 'administrator'){

				$regra->add_cap( $finance_permission );
			}else{

				$regra->remove_cap($finance_permission);
			}
		}
	endforeach;

}

register_activation_hook( __FILE__, 'setPermissions' );
//add_action('admin_init', 'setPermissions');