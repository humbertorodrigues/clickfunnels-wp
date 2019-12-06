<?php
/**
* Plugin Name: ClickFunnels-WP
* Plugin URI: http://humberto.ninja
* Description: Load clickfunnels pages inside wp
* Version: 1.0
* Author: Humberto Rodrigues

**/
add_shortcode( 'clickfunnels' , 'func_pegar_pagina' );
add_filter( 'template_include', 'substituir_template',99);

function func_pegar_pagina($atts){

	if ( isset($_GET['action']) ) {
		if($_GET['action']=="edit"){

	    	return;
		}
	}
    $atts = shortcode_atts(array('url'=>''),$atts);
    $url = $atts['url'];
    
    ob_start();
	wp_head();
	$header = ob_get_clean();
	ob_start();
	wp_footer();
	$footer = ob_get_clean();

    $pagina = file_get_contents($url);

    $pagina = str_ireplace("</head>",$header."</head>",$pagina);
    $pagina = str_ireplace("</body>",$footer."</body>",$pagina);

    $pagina = str_ireplace("%5B","[",$pagina);
    $pagina = str_ireplace("%5D","]",$pagina);
    

    $pagina = do_shortcode( $pagina );
    return $pagina;
}

function substituir_template( $template ) {
	global $post;

	if ( has_shortcode($post->post_content, 'clickfunnels' ) ) {
		$conteudo = do_shortcode( $post->post_content );
		$template =  (__DIR__."/template/template-structure.php");
		echo $conteudo;
	}else{
	
	}

    return $template;
}

