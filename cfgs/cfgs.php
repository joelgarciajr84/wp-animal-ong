<?php 

require_once dirname( __FILE__ ) . '/cfgs-titulos.php';

#Insercao de Taxonomias e CPTS no Widget ' At  a Glance'
function HomeWPAnimalOng() {
		#Taxonomias
		$MostraTaxonomias = 1;
		
		if ($MostraTaxonomias) {
			$taxonomias = get_taxonomies( array( '_builtin' => false ), 'objects' );

			foreach ( $taxonomias as $tax ) {
				$num_terms  = wp_count_terms( $tax->name );
				$num = number_format_i18n( $num_terms );
				$text = _n( $tax->labels->singular_name, $tax->labels->name, $num_terms );
				$associated_post_type = $tax->object_type;
				

				$output = '<a href="edit-tags.php?taxonomy=' . $tax->name . '&post_type=' . $associated_post_type[0] . '">' . $num . ' ' . $text .'</a>';
				
				echo '<li class="taxonomy-count">' . $output . ' </li>';
			}
		}

		#Custom Post Types
		$post_types = get_post_types( array( '_builtin' => false ), 'objects' );
		foreach ( $post_types as $post_type ) {
			if($post_type->show_in_menu==false) {
				continue;
			}
			$num_posts = wp_count_posts( $post_type->name );
			$num = number_format_i18n( $num_posts->publish );
			$text = _n( $post_type->labels->singular_name, $post_type->labels->name, $num_posts->publish );
			
			$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
			
			if ( $num_posts->pending > 0 ) {
				$num = number_format_i18n( $num_posts->pending );
				$text = _n( $post_type->labels->singular_name . ' pending', $post_type->labels->name . ' pending', $num_posts->pending );
				$output .= '<a class="waiting" href="edit.php?post_status=pending&post_type=' . $post_type->name . '">' . $num . ' pending</a>';
			}
			echo '<li class="page-count ' . $post_type->name . '-count">' . $output . '</td>';
		}
}
add_action( 'dashboard_glance_items', 'HomeWPAnimalOng' );
