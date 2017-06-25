<?php 

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );

require_once( $parse_uri[0] . 'wp-load.php' );
require_once( $parse_uri[0] . 'wp-includes/link-template.php' );
require_once( $parse_uri[0] . 'wp-includes/l10n.php' );


//SE COMPRUEBAN LOS PARAMETROS RECIBIDOS PARA CREAR LAS PAGINAS CORRESPONDIENTES
if(isset($_REQUEST['form_name']))
	create_form($_REQUEST['form_name'], $_REQUEST['receiver_email'], 
    $_REQUEST['legal_notice_url'], $_REQUEST['form_columns'], $_REQUEST['include_legal_notice'],
    $_REQUEST['include_message'], $_REQUEST['contact_form_fields'], $_REQUEST['contact_form_subject'], $_REQUEST['contact_form_required_fields'] );

//FUNCION PARA CREAR LAS PAGINAS DE AVISO LEGAL, POLITICA DE COOKIES O MAS INFORMACION
function create_form( $form_name, $receiver_email, $legal_notice_url, $form_columns, $include_legal_notice,
    $include_message, $contact_form_fields, $subject, $contact_form_required_fields)
{
    $fields = array("name", "last name", "email", "phone", "subject");

    $div_col_end = "</p></div>\n";

    $div_col = '<div class="vc_col-sm-'.(12 / $form_columns).'"><p>';

    $content = $reply_email = $sender = $body = "";

    for($x = 0; $x < count($contact_form_fields); $x++)
    {
        $content .= $div_col;

        if(strtolower($contact_form_fields[$x]) == "email" )
        {
            $content .= "[email";
            $sender = $reply_email =  "[".$form_name."-".str_replace(" ", "",$contact_form_fields[$x])."]";
        }
        else
            $content .= "[text";

        if(in_array($contact_form_fields[$x], $contact_form_required_fields) ) 
            $content .= "* ";
        else
            $content .= " ";
            
        $content .= $form_name."-".str_replace(" ", "",$contact_form_fields[$x])." placeholder '".translate( ucfirst ($contact_form_fields[$x]), 'wp-ovimedia-pack' )."']";

        $content .= $div_col_end;

        $body .=  translate( ucfirst ($contact_form_fields[$x]), 'wp-ovimedia-pack' ).": [".$form_name."-".str_replace(" ", "",$contact_form_fields[$x])."]\n";
    }

if($include_message == 'yes')
{
    $content .= "<div class='vc_col-sm-12'><p>[textarea* ".$form_name."-".translate( "Message", "wp-ovimedia-pack" )." placeholder '".translate( "Message", "wp-ovimedia-pack" )."'] </p></div>\n";

    $body .=  "\n".translate( 'Message', 'wp-ovimedia-pack' ).":\n [".$form_name."-".translate( 'Message', 'wp-ovimedia-pack' )."]\n";
}

if($include_legal_notice == 'yes')
    $content .=  "<div class='vc_col-sm-12'><p>[acceptance ".$form_name."-".rand(1,100)."] ".translate( "I accept the", "wp-ovimedia-pack" )." <a target='_blank' href='".get_home_url()."/".$legal_notice_url."'>".translate( "Privacy Policy", "wp-ovimedia-pack" )." </a></p></div>\n";

$content .= "<div class='vc_col-sm-12'><p>[submit '".translate( "Send", "wp-ovimedia-pack" )."']</p></div>";


	
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

    $body .= "\n \n -- \n Este mensaje se ha enviado desde un formulario de contacto de ".get_home_url();
	
	$values = array("subject" => $subject, 
                    "sender"=> $sender, 
                    "body" => $body,
                     "recipient" => $receiver_email, 
                     "additional_headers" => 'Reply-To: '.$reply_email, 
                     "attachments" => "", 
                     "use_html" => 'exclude_blank'
                     );
	
	add_post_meta($id, "_mail", $values);
		
	echo "Formulario ".$form_name." generado correctamente.";
}

?>
