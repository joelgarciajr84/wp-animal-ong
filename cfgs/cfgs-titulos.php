<?php 

#Altera os Rotulos e Titulos de alguns cadastros.

add_filter( 'enter_title_here', 'titulos_personalizados' );

function titulos_personalizados( $input ) {
    global $post_type;

    if ('associados' == $post_type )
        return __( 'Digite o nome do Associado', 'wpanimal' );

    if ('medicamentos' == $post_type )
        return __( 'Digite o nome do Medicamento', 'wpanimal' );

    if ('caixas' == $post_type )
        return __( 'Digite o nome do Caixa', 'wpanimal' );

    if ('lancamentocaixa' == $post_type )
        return __( 'Digite o Titulo do Lancamento', 'wpanimal' );

     if ('animal' == $post_type )
        return __( 'Digite o nome do Animal', 'wpanimal' );
    

    return $input;
}
add_action('do_meta_boxes', 'change_image_box');

function change_image_box(){

    remove_meta_box(

        'postimagediv',
        'associados', 
        'side'
    );
    add_meta_box(

        'postimagediv',
        __('Foto'),
        'post_thumbnail_meta_box',
        'associados',
        'side', 
        'high'
    ); 
}
?>