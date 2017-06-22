<?php 

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );

require_once( $parse_uri[0] . 'wp-load.php' );

require_once( $parse_uri[0] . 'wp-includes/link-template.php' );


//SE COMPRUEBAN LOS PARAMETROS RECIBIDOS PARA CREAR LAS PAGINAS CORRESPONDIENTES
if(isset($_REQUEST['form_type']))
	create_form($_REQUEST['form_type'], $_REQUEST['form_name'], $_REQUEST['receiver_email'], $_REQUEST['legal_notice_url']);

//FUNCION PARA CREAR LAS PAGINAS DE AVISO LEGAL, POLITICA DE COOKIES O MAS INFORMACION
function create_form($type, $form_name, $receiver_email, $legal_notice_url)
{
	if($type == "Visual Composer")
	{
		$content = '
<div class="vc_col-sm-6"><p>[text* your-name placeholder "Nombre"]</p></div>
<div class="vc_col-sm-6"><p>[email* your-email placeholder "E-mail"]</p> </div>
<div class="vc_col-sm-6"><p>[text* your-phone placeholder "Teléfono"]</p> </div>
<div class="vc_col-sm-6"><p>[text your-subject placeholder "Asunto"]</p> </div>

<div class="vc_col-sm-12"><p>[textarea* your-message placeholder "Mensaje"] </p></div>

<div class="vc_col-sm-12"><p>[acceptance acceptance-10] Acepto la <a target="_blank" href="'.get_home_url().'/'.$legal_notice_url.'/">Política de Privacidad</a></p></div>

<div class="vc_col-sm-12"><p>[submit "Enviar"]</p></div>';

	}
	elseif($type == "Avada")
	{
		$content = '
<div class="fusion-one-half fusion-layout-column fusion-spacing-yes"><p>[text* your-name placeholder "Nombre"]</p></div>
<div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes"><p>[email* your-email placeholder "E-mail"]</p></div>
<div class="fusion-one-half fusion-layout-column fusion-spacing-yes"><p>[text* your-phone placeholder "Teléfono"]</p></div>
<div class="fusion-one-half fusion-layout-column fusion-column-last fusion-spacing-yes"><p>[text your-subject placeholder "Asunto"]</p></div>
<p>[textarea* your-message placeholder "Mensaje"] </p>
<p>[acceptance acceptance-10] Acepto la <a target="_blank" href="'.get_home_url().'/'.$legal_notice_url.'/">Política de Privacidad</a></p>
<p>[submit "Enviar"]</p>';

	}
	
	$post = array(
	  'post_name'      => "Formulario de contacto ".$form_name, 
	  'post_content' => $content,
	  'post_title'     => "Formulario de contacto ".$form_name,
	  'post_status'    => 'publish', 
	  'post_type'      => 'wpcf7_contact_form' 
	);  
	

	$id = wp_insert_post($post);  
	
	add_post_meta($id, "_form", $content);
	
	add_post_meta($id, "_locale", "es_ES");
	
	$values = array("subject" => 'Contacto "[your-subject]"', 
                    "sender"=> '[your-name] <[your-email]>', 
                    "body" => 'De: [your-name] <[your-email]>

Teléfono: [your-phone]
Asunto: [your-subject]

Cuerpo del mensaje:
[your-message]

--
Este mensaje se ha enviado desde un formulario de contacto de '.get_home_url(), "recipient" => $receiver_email, "additional_headers" => 'Reply-To: [your-email]', "attachments" => "", "use_html" => 'exclude_blank');
	
	add_post_meta($id, "_mail", $values);
		
	echo "Formulario generado correctamente.";

}

?>
