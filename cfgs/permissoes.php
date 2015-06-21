<?php
function setPermissions(){

	$wpanimal_financial_permissions = array(
		'read',
		'edit_posts',
		'publish_caixas',
		'publish_caixa',
		'edit_caixas',
		'edit_others_caixas',
		'read_private_caixas',
		'edit_caixa',
		'read_caixa',
		'publish_lancamentocaixa',
		'edit_lancamentocaixa',
		'edit_others_lancamentocaixa',
		'read_private_lancamentocaixa',
		'edit_lancamentocaixa',
		'read_lancamentocaixa',
	);

	$result = add_role(
		'financeiro',
		__( 'Financeiro' )
	);

	foreach (get_editable_roles() as $role_name => $role_info):

		$regra = get_role($role_name);
		if($regra->name == 'administrator' || $regra->name == 'financeiro'){

			foreach ($wpanimal_financial_permissions as $financial_permission) {

				$regra->add_cap( $financial_permission );
			}
		}
	endforeach;
}