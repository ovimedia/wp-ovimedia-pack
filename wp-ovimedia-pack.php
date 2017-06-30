<?php
/*
Plugin Name: Ovimedia Pack 
Description: Pack of functional modules for Wordpress.
Author: Ovi García - ovimedia.es
Author URI: http://www.ovimedia.es/
Text Domain: wp-ovimedia-pack
Version: 1.2
Plugin URI: http://www.ovimedia.es/
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

if ( ! class_exists( 'wp_ovimedia_pack' ) ) 
{
	class wp_ovimedia_pack 
    {
        public $wop_options;
        
        function __construct() 
        {   
            add_action( 'init', array( $this, 'wop_load_languages') );
            add_action( 'init', array( $this, 'wop_save_options') );
            add_action( 'wp_footer', array( $this, 'wop_front_js_css') );
            add_action( 'admin_menu', array( $this, 'wop_admin_menu' ));
            add_action( 'wp_footer', array( $this, 'wop_show_cookies' ), 1);
            add_action( 'admin_head', array( $this, 'wop_admin_js_css') );

            add_action( 'wp_ajax_wop_generate_pages', array( $this, 'wop_generate_pages') );
            add_action( 'wp_ajax_wop_generate_forms', array( $this, 'wop_generate_forms') );

            add_action ( 'admin_enqueue_scripts', function () {
                if (is_admin ())
                    wp_enqueue_media ();
            } );

            $this->wop_options = json_decode(get_option("wop_options"), true);

            add_filter( 'login_headerurl', array( $this,'wop_logo_url_login') ); 

            if($this->wop_options["enable_floating_widget"] == "on") 
            {  
                add_action( 'widgets_init', array( $this, 'floating_widget') );
                add_action( 'wp_footer', array( $this, 'wop_show_floating_widget' ), 10);
            }

            if($this->wop_options["enable_footer"] == "on")    
            {
                add_action( 'widgets_init', array( $this, 'extra_footer_widgets') );
                add_action( 'wp_footer', array( $this, 'wop_show_extra_footer' ), 100);
            }

            if($this->wop_options["core_updates"] == "on")
                add_filter('pre_site_transient_update_core', array( $this,'wop_remove_updates'));
            
            if($this->wop_options["plugin_updates"] == "on")
                add_filter('pre_site_transient_update_plugins',array( $this,'wop_remove_updates'));
            
            if($this->wop_options["theme_updates"] == "on")
                add_filter('pre_site_transient_update_themes', array( $this,'wop_remove_updates'));

            
            if($this->wop_options["enable_logout_redirect"]  == "on")
                add_action( 'wp_logout', array( $this, 'wop_custom_logout_redirect'));

            if($this->wop_options["enable_login_redirect"]  == "on")
                add_action( 'wp_login', array( $this, 'wop_custom_login_redirect') );

            add_action( 'login_head', array( $this,'wop_custom_login_style' ));  

        }
                
        public function wop_load_languages() 
        {
            load_plugin_textdomain( 'wp-ovimedia-pack', false, '/'.basename( dirname( __FILE__ ) ) . '/languages/' ); 
        }

        public function wop_admin_menu() 
        {	
            $menu = add_menu_page( 'Ovimedia Pack', 'Ovimedia Pack', 'read',  
                                  'wp-ovimedia-pack', array( $this,'wop_form'), 'dashicons-screenoptions', 50);
        }         
                       
        public function wop_save_options() 
        {
			$page_viewed = basename($_SERVER['REQUEST_URI']);
				if( $page_viewed == "wop_save_options" ) {
                    
                    update_option("wop_options", json_encode($_REQUEST));
					wp_redirect("./wp-admin/admin.php?page=wp-ovimedia-pack");
				    exit();
			     }
		}
        
        public function wop_front_js_css() 
        {
            wp_register_style( 'wop_style_css', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/css/wop_style.css', false, '1.0.0' );
            wp_enqueue_style( 'wop_style_css' );

            wp_enqueue_script( 'wop_front_script', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/js/wop.js', array('jquery') );
        }

        public function wop_admin_js_css() 
        {
            wp_register_style( 'wop_admin_style_css', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/css/wop_admin_style.css', false, '1.0.0' );
            wp_enqueue_style( 'wop_admin_style_css' );

            wp_register_style( 'wop_spectrum_css', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/css/spectrum.css', false, '1.0.0' );
            wp_enqueue_style( 'wop_spectrum_css' );

            wp_register_style( 'wop_switchery_style_css', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/css/switchery.min.css', false, '1.0.0' );
            wp_enqueue_style( 'wop_switchery_style_css' );
       
            wp_register_style( 'codes_select2_css', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/css/select2.min.css', false, '1.0.0' );

            wp_enqueue_style( 'codes_select2_css' );

            wp_enqueue_script( 'wop_script_spectrum', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/js/spectrum.js', array('jquery') );
            wp_enqueue_script( 'wop_script_admin', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/js/wop_admin.js', array('jquery') );
            wp_enqueue_script( 'wop_switchery_script', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/js/switchery.min.js', array('jquery') ); 

            wp_enqueue_script( 'codes_select2', WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/js/select2.min.js', array('jquery') );
        }
                       
        public function wop_form()
        {
            ?><div class="wrap_wop_form">

            <form method="post" action="/wop_save_options">

            <?php 

                  $sections = array(
                            "updates.php",
                            "legal_notice.php",
                            "cookies.php",
                            "login.php",
                            "footer.php",
                            "contact_forms.php",
                            "floating_widget.php");
                
                ?>
                
                <ul id="list_options">
                    <?php 
                        for($x = 0; $x < count($sections); $x++)  
                        {
                            echo "<li id='".substr($sections[$x], 0, -4)."' title='#".substr($sections[$x], 0, -4)."_container' class='tab_links ";

                            if($x == 0) 
                                echo " active_tab' >";
                            else 
                                echo "' >";

                            echo translate(ucwords(str_replace("_", " ", substr($sections[$x], 0, -4))), 'wp-ovimedia-pack' )."</li>";
                        }
                    ?>
                </ul>

                <?php 
                    $url = "../wp-content/plugins/".basename( dirname( __FILE__ ) )."/includes/";
                    include_once $url.$sections[0];
                    include_once $url.$sections[1];
                    include_once $url.$sections[2];
                    include_once $url.$sections[3];
                    include_once $url.$sections[4];
                    include_once $url.$sections[5];
                    include_once $url.$sections[6];          
                ?>
                
                <p><input type="submit" value="<?php echo translate( 'Save changes', 'wp-ovimedia-pack' )  ?>" class="button button-primary" /></div></p>
           
                <div id="messages_plugin" ></div>
            </form>

          </div><?php 

        }   

        function wop_show_cookies() 
        {
            if($this->wop_options['enable_cookies'] == "on") {
            ?>
            <div class="wop_cookies cookies_pos_<?php echo $this->wop_options['position_cookies']; ?>" 
            style="background-color: <?php echo $this->wop_options['background_color_cookies']; ?>;
            box-shadow: 0px 0px <?php echo $this->wop_options['box_shadow_cookies']; ?>px #000;">

                    <div class="block_cookies">
                        <div <?php if($this->wop_options['hide_cookies'] != "auto") echo 'class="col_2_3"' ?>>

                            <p class="texto_cookies" style="line-height: <?php echo $this->wop_options['font_size_cookies']; ?>px;font-size: <?php echo $this->wop_options['font_size_cookies']; ?>px; color: <?php echo $this->wop_options['font_color_cookies']; ?>;">

                                <?php echo $this->wop_options["text_message_cookies"]; ?>

                                <strong><a style="text-decoration: underline;color: <?php echo $this->wop_options['font_color_cookies']; ?>;" target="_blank" 
                                href="<?php echo get_home_url().'/'.$this->wop_options['slug_politica_cookies']; ?>"> 
                                <?php echo $this->wop_options["link_text_cookies"]; ?></a></strong>

                            </p>
                            
                            <input type='hidden' value='<?php echo $this->wop_options['hide_cookies']; ?>' id='cookie_mode' />

                        </div>
                            <?php

                            if($this->wop_options['hide_cookies'] != "auto")
                            {
                                ?> 
                                    <div class="col_1_3">
                                        <span id="btn_cookies" style="color:<?php echo $this->wop_options['font_color_button_cookies']; ?>;
                                        background-color: <?php echo $this->wop_options['background_color_button_cookies']; ?>;
                                        border-radius: <?php echo $this->wop_options['button_radius_cookies']; ?>px;
                                        font-size: <?php echo $this->wop_options['font_size_cookies']; ?>px;
                                        line-height: <?php echo $this->wop_options['font_size_cookies']; ?>px;">
                                        <?php echo $this->wop_options['text_button_cookies']; ?></span>
                                        
                                        <?php  if($this->wop_options['hide_cookies'] == "2buttons") { ?>
                                        <span id="btn_cancel_cookies" style="margin-left: 12px;color:<?php echo $this->wop_options['font_color_cancel_button_cookies']; ?>;
                                        background-color: <?php echo $this->wop_options['background_color_cancel_button_cookies']; ?>;
                                        border-radius: <?php echo $this->wop_options['button_radius_cookies']; ?>px;
                                        font-size: <?php echo $this->wop_options['font_size_cookies']; ?>px;
                                        line-height: <?php echo $this->wop_options['font_size_cookies']; ?>px;">
                                        <?php echo $this->wop_options['text_button_cancel_cookies']; ?></span>
                                        <?php } ?>
                                    </div>

                                <?php
                            }
                            ?>

                    </div>

                </div>

            <?php
            }
        }

        public function wop_custom_login_style()
        {
            echo "<link rel='stylesheet' id='style-css'  
            href='".WP_PLUGIN_URL."/".basename( dirname( __FILE__ ) )."/themes/".$this->wop_options['theme_login']."' type='text/css' media='screen' />";

            $logo =  wp_get_attachment_image_src($this->wop_options['login_logo_image'], "medium");
            $background =  wp_get_attachment_image_src($this->wop_options['login_background_image'], "full");

            echo "<style>";

            if(isset($logo[0]))
            {
                echo ".login h1 a{width: ".$logo[1]."px; 
                height: ".$logo[2]."px; background-size: auto;
                background-image: url('".$logo[0]."');}";
            }

            echo ".login.login-action-login{background-size: cover;
            background-repeat: no-repeat;
            background-image: url('".$background[0]."');}";

            echo "</style>";
        }

        public function wop_show_extra_footer()
        {
            echo "<div id='wop_extra_footer' style='padding-left:".$this->wop_options['footer_left_padding'].";
            padding-right:".$this->wop_options['footer_right_padding'].";
            width:".$this->wop_options['footer_width'].";
            background-color:".$this->wop_options['footer_background_color'].";'>";

            for($x = 1; $x <= $this->wop_options['footer_columns']; $x++ )
            {
                echo "<div class='extra_footer_col_1_".$this->wop_options['footer_columns']."' >";

                dynamic_sidebar( 'extra_footer_widget'.$x );	

                echo "</div>";
            }

            echo "</div>";

            echo "<style>
            #wop_extra_footer .widget .textwidget p,
            #wop_extra_footer .widget .textwidget a,
            #wop_extra_footer .widget .textwidget h1,
            #wop_extra_footer .widget .textwidget h2,
            #wop_extra_footer .widget .textwidget h3,
            #wop_extra_footer .widget .textwidget h4,
            #wop_extra_footer .widget .textwidget h5,
            #wop_extra_footer .widget .textwidget h6        
            {color:".$this->wop_options['footer_font_color']." !important;}</style>";
        }

        public function wop_show_floating_widget()
        {
            echo "<div id='floating_widget_button_".$this->wop_options['floating_widget_location']."'";

            echo "style='background-color: ".$this->wop_options['floating_widget_button_background_color'].";
            color: ".$this->wop_options['floating_widget_button_font_color'].";'" ; 
            
            echo ">".$this->wop_options['floating_widget_button_text']."</div>";

            echo "<div id='floating_widget_".$this->wop_options['floating_widget_location']."'
            class='".$this->wop_options['floating_widget_location']."_hide'>";

            dynamic_sidebar( 'floating_widget' );	

            echo "</div>";

            echo "<style>";

            echo "#floating_widget_button_".$this->wop_options['floating_widget_location'].", 
            #floating_widget_".$this->wop_options['floating_widget_location']."{
                color: ".$this->wop_options['floating_widget_font_color']." !important;"; 

            if($this->wop_options['floating_widget_location'] == "left" || 
            $this->wop_options['floating_widget_location'] == "right")
                echo "top:";
            else
                echo "left:";

            echo $this->wop_options['floating_widget_position']." !important;
            background-color:".$this->wop_options['floating_widget_background_color'].";
            font-size: ".$this->wop_options['floating_widget_font_size']."px;}";
            echo "
            .".$this->wop_options['floating_widget_location']."_show {
                ".$this->wop_options['floating_widget_location'].": 0px!important;
                -webkit-transition: ".$this->wop_options['floating_widget_location']." 
                ".$this->wop_options['floating_widget_transition_delay']."s;
                transition: ".$this->wop_options['floating_widget_location']." 
                ".$this->wop_options['floating_widget_transition_delay']."s;
            }

            
            .".$this->wop_options['floating_widget_location']."_hide {
                ".$this->wop_options['floating_widget_location'].": 0px!important;";

            if($this->wop_options['floating_widget_location'] == "left" || 
            $this->wop_options['floating_widget_location'] == "right")
                echo $this->wop_options['floating_widget_location'].": -".$this->wop_options['floating_widget_width']. " !important;";
            else
                echo $this->wop_options['floating_widget_location'].": -".$this->wop_options['floating_widget_height']. " !important;";

               echo "-webkit-transition: ".$this->wop_options['floating_widget_location']." 
               ".$this->wop_options['floating_widget_transition_delay']."s;
                transition: ".$this->wop_options['floating_widget_location']." 
                ".$this->wop_options['floating_widget_transition_delay']."s;
            }

            .".$this->wop_options['floating_widget_location']."_button_hide {
                ".$this->wop_options['floating_widget_location'].": 0px!important; 
                -webkit-transition: ".$this->wop_options['floating_widget_location']." 
                ".$this->wop_options['floating_widget_transition_delay']."s;
                transition: ".$this->wop_options['floating_widget_location']." 
                ".$this->wop_options['floating_widget_transition_delay']."s;
            }";

            echo ".".$this->wop_options['floating_widget_location']."_button_show {";

            if($this->wop_options['floating_widget_location'] == "left" || 
            $this->wop_options['floating_widget_location'] == "right")
                echo $this->wop_options['floating_widget_location'].": ".$this->wop_options['floating_widget_width']. " !important;";
            else
                echo $this->wop_options['floating_widget_location'].": ".$this->wop_options['floating_widget_height']. " !important;";

            echo "-webkit-transition: ".$this->wop_options['floating_widget_location']." 
            ".$this->wop_options['floating_widget_transition_delay']."s;
            transition: ".$this->wop_options['floating_widget_location']." 
            ".$this->wop_options['floating_widget_transition_delay']."s;}";     


            echo "#floating_widget_".$this->wop_options['floating_widget_location']."
            {width: ".$this->wop_options['floating_widget_width']. ";
            height: ".$this->wop_options['floating_widget_height']. ";box-sizing: border-box; }";

            echo "#floating_widget_".$this->wop_options['floating_widget_location']." a,
            #floating_widget_".$this->wop_options['floating_widget_location']." p,
            #floating_widget_".$this->wop_options['floating_widget_location']." h1,
            #floating_widget_".$this->wop_options['floating_widget_location']." h2,
            #floating_widget_".$this->wop_options['floating_widget_location']." h3,
            #floating_widget_".$this->wop_options['floating_widget_location']." h4,
            #floating_widget_".$this->wop_options['floating_widget_location']." h5,
            #floating_widget_".$this->wop_options['floating_widget_location']." h6{
            color: ".$this->wop_options['floating_widget_font_color']." !important;}";

            echo "</style>";

        }

        public function extra_footer_widgets() 
        {
            for($x = 1; $x <= $this->wop_options['footer_columns']; $x++ )
            {
                register_sidebar( 
                    array(
                        'name' => "Extra footer ".$x,
                        'id' => 'extra_footer_widget'.$x,
                        'before_widget' => '<div class="widget">',
                        'after_widget' => '</div>',
                        'before_title' => '<h3>',
                        'after_title' => '</h3>'
                    ) 
                );
            }
        }

        public function floating_widget() 
        {
            register_sidebar( 
                array(
                    'name' => "Floating Widget",
                    'id' => 'floating_widget',
                    'before_widget' => '<div class="widget">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3>',
                    'after_title' => '</h3>'
                ) 
            );   
        }

        public function wop_custom_login_redirect()
        {
            wp_redirect($this->wop_options["url_login_redirect"]);
            
            exit();
        }

        public function wop_custom_logout_redirect()
        {
            wp_redirect($this->wop_options["url_logout_redirect"]);
            
            exit();
        }

        public function wop_logo_url_login()
        {
            return get_home_url();
        }

        public function wop_remove_updates()
        {
            global $wp_version;
            
            return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,);
        }

        public function wop_generate_pages()
        {
            if(isset($_REQUEST['title_aviso_legal']))
                $this->create_page($_REQUEST['title_aviso_legal'], $_REQUEST['slug_aviso_legal'], 1);

            if(isset($_REQUEST['title_politica_cookies']))
                $this->create_page($_REQUEST['title_politica_cookies'], $_REQUEST['slug_politica_cookies'], 2);

            if(isset($_REQUEST['title_mas_informacion']))
                $this->create_page($_REQUEST['title_mas_informacion'],$_REQUEST['slug_mas_informacion'], 3);
        }

        public function wop_generate_forms()
        {
            if(isset($_REQUEST['form_name']))
                $this->create_form($_REQUEST['form_name'], $_REQUEST['receiver_email'], 
                $_REQUEST['legal_notice_url'], $_REQUEST['form_columns'], $_REQUEST['include_legal_notice'],
                $_REQUEST['include_message'], $_REQUEST['contact_form_fields'], $_REQUEST['contact_form_subject'], $_REQUEST['contact_form_required_fields'] );
        }

        public function create_page($title, $slug, $type)
        {
            $content = "";
                
            switch($type)
            {
                case 1: //AVISO LEGAL
                
                    $content = $this->page_aviso_legal($_REQUEST['name_empresa'], $_REQUEST['address_empresa'], $_REQUEST['cif_empresa'], $_REQUEST['register_empresa'], $_REQUEST['domain_empresa'], $_REQUEST['email_empresa']);
                
                break;
                
                case 2: //POLITICA DE COOKIES
                
                    $content = $this->page_politica_cookies(get_home_url().'/'.$_REQUEST['slug_mas_informacion']);
                
                break;
                
                case 3: //MAS INFORMACION
                
                    $content = $this->page_mas_informacion();
                
                break;
            }
            
            $post = array(
            'post_name'      => $slug, 
            'post_content' => $content,
            'post_title'     => $title,
            'post_status'    => 'publish', 
            'post_type'      => 'page' 
            );  
            
            $page = get_page_by_title($title);
            
            if( $page == null)
            {
                wp_insert_post($post);  
                
                echo "- Página $title creada correctamente. " ;
            }
            else 
            {
                $post['ID'] = $page->ID;
                
                wp_update_post( $post );
                
                echo "- Página $title actualizada. " ;
            }
        }

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

            $body .=  "\n".translate( 'Message', 'wp-ovimedia-pack' ).":\n[".$form_name."-".translate( 'Message', 'wp-ovimedia-pack' )."]\n";
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

        public function page_politica_cookies($enlace)
        {
            return '<h1>Política de cookies</h1>
        <p>
            Una <em>cookie</em> es un pequeño fichero de texto que se almacena en su navegador cuando visita casi cualquier página web. Su utilidad es que la web sea capaz de recordar su visita cuando vuelva a navegar por esa página. Las <em>cookies</em> suelen almacenar información de carácter técnico, preferencias personales, personalización de contenidos, estadísticas de uso, enlaces a redes sociales, acceso a cuentas de usuario, etc. El objetivo de la <em>cookie</em> es adaptar el contenido de la web a su perfil y necesidades, sin <em>cookies</em> los servicios ofrecidos por cualquier página se verían mermados notablemente. Si desea consultar más información sobre qué son las <em>cookies</em>, qué almacenan, cómo eliminarlas, desactivarlas, etc., <a href="'.$enlace.'">le rogamos se dirija a este enlace.</a>
        </p>
        <h2>Cookies utilizadas en este sitio web</h2>
        <p>
            Siguiendo las directrices de la Agencia Española de Protección de Datos procedemos a detallar el uso de <em>cookies</em> que hace esta web con el fin de informarle con la máxima exactitud posible.
        </p>
        <p>
            Este sitio web utiliza las siguientes <strong>cookies propias</strong>:
            <ul>
                <li>Cookies de sesión, para garantizar que los usuarios que escriban comentarios en el blog sean humanos y no aplicaciones automatizadas. De esta forma se combate el <em>spam</em>.</li>
            </ul>
        </p>
        <p>
            Este sitio web utiliza las siguientes <strong>cookies de terceros</strong>:
            <ul>
                <li>Google Analytics: Almacena <em>cookies</em> para poder elaborar estadísticas sobre el tráfico y volumen de visitas de esta web. Al utilizar este sitio web está consintiendo el tratamiento de información acerca de usted por Google. Por tanto, el ejercicio de cualquier derecho en este sentido deberá hacerlo comunicando directamente con Google.</li>
                <li>Redes sociales: Cada red social utiliza sus propias <em>cookies</em> para que usted pueda pinchar en botones del tipo <em>Me gusta</em> o <em>Compartir</em>.</li>
            </ul>
        </p>
        <h2>Desactivación o eliminación de cookies</h2>
        <p>
            En cualquier momento podrá ejercer su derecho de desactivación o eliminación de cookies de este sitio web. Estas acciones se realizan de forma diferente en función del navegador que esté usando. <a href="'.$enlace.'">Aquí le dejamos una guía rápida para los navegadores más populares</a>.
        </p>
        <h2>Notas adicionales</h2>
        <p>
            <ul>
                <li>
                    Ni esta web ni sus representantes legales se hacen responsables ni del contenido ni de la veracidad de las políticas de privacidad que puedan tener los terceros mencionados en esta política de <em>cookies</em>.
                </li>
                <li>
                    Los navegadores web son las herramientas encargadas de almacenar las <em>cookies</em> y desde este lugar debe efectuar su derecho a eliminación o desactivación de las mismas. Ni esta web ni sus representantes legales pueden garantizar la correcta o incorrecta manipulación de las <em>cookies</em> por parte de los mencionados navegadores.
                </li>
                <li>
                    En algunos casos es necesario instalar <em>cookies</em> para que el navegador no olvide su decisión de no aceptación de las mismas.
                </li>
                <li>
                    En el caso de las <em>cookies</em> de Google Analytics, esta empresa almacena las <em>cookies</em> en servidores ubicados en Estados Unidos y se compromete a no compartirla con terceros, excepto en los casos en los que sea necesario para el funcionamiento del sistema o cuando la ley obligue a tal efecto. Según Google no guarda su dirección IP. Google Inc. es una compañía adherida al Acuerdo de Puerto Seguro que garantiza que todos los datos transferidos serán tratados con un nivel de protección acorde a la normativa europea. Puede consultar información detallada a este respecto <a href="http://safeharbor.export.gov/companyinfo.aspx?id=16626" target="_blank">en este enlace</a>. Si desea información sobre el uso que Google da a las cookies <a href="https://developers.google.com/analytics/devguides/collection/analyticsjs/cookie-usage?hl=es&csw=1" target="_blank">le adjuntamos este otro enlace</a>.
                </li>
                <li>
                    Para cualquier duda o consulta acerca de esta política de <em>cookies</em> no dude en comunicarse con nosotros a través de la sección de contacto.</a>
                </li>
            </ul>
        </p>';
            
        }

        public function page_mas_informacion()
        {

        return '
        <h2>¿Qué es una cookie?</h2>
        <p>
            Una <em>cookie</em> es un fichero de texto <b>inofensivo</b> que se almacena en su navegador cuando visita casi cualquier página web. La utilidad de la <em>cookie</em> es que la web sea capaz de recordar su visita cuando vuelva a navegar por esa página. Aunque mucha gente no lo sabe las <em>cookies</em> se llevan utilizando desde hace 20 años, cuando aparecieron los primeros navegadores para la World Wide Web.
        </p> 
        <h2>¿Qué NO ES una cookie?</h2>
        <p>
            No es un virus, ni un troyano, ni un gusano, ni spam, ni spyware, ni abre ventanas pop-up.
        </p> 
        <h2>¿Qué información almacena una <em>cookie</em>?</h2>
        <p>
            Las <em>cookies</em> no suelen almacenar información sensible sobre usted, como tarjetas de crédito o datos bancarios, fotografías, su DNI o información personal, etc. Los datos que guardan son de carácter técnico, preferencias personales, personalización de contenidos, etc.
        </p>
        <p>
            El servidor web no le asocia a usted como persona si no a su navegador web. De hecho, si usted navega habitualmente con Internet Explorer y prueba a navegar por la misma web con Firefox o Chrome verá que la web no se da cuenta que es usted la misma persona porque en realidad está asociando al navegador, no a la persona.
        </p>
        <h2>¿Qué tipo de <em>cookies</em> existen?</h2>
        <p>
            <ul>
                <li><em>Cookies</em> técnicas: Son las más elementales y permiten, entre otras cosas, saber cuándo está navegando un humano o una aplicación automatizada, cuándo navega un usuario anónimo y uno registrado, tareas  básicas para el funcionamiento de cualquier web dinámica.</li>
                <li><em>Cookies</em> de análisis: Recogen información sobre el tipo de navegación que está realizando, las secciones que más utiliza, productos consultados, franja horaria de uso, idioma, etc.</li>
                <li><em>Cookies</em> publicitarias: Muestran publicidad en función de su navegación, su país de procedencia, idioma, etc.</li>
            </ul>
        </p>
        <h2>¿Qué son las <em>cookies</em> propias y las de terceros?</h2>
        <p>
            Las <em>cookies propias</em> son las generadas por la página que está visitando y las <em>de terceros</em> son las generadas por servicios o proveedores externos como Facebook, Twitter, Google, etc.
        </p> 
        <h2>¿Qué ocurre si desactivo las <em>cookies</em>?</h2>
        <p>
            Para que entienda el alcance que puede tener desactivar las <em>cookies</em> le mostramos unos ejemplos:
            <ul>
                <li>No podrá compartir contenidos de esa web en Facebook, Twitter o cualquier otra red social.</li>
                <li>El sitio web no podrá adaptar los contenidos a sus preferencias personales, como suele ocurrir en las tiendas online.</li>
                <li>No podrá acceder al área personal de esa web, como por ejemplo <em>Mi cuenta</em>, o <em>Mi perfil</em> o <em>Mis pedidos</em>.</li>
                <li>Tiendas online: Le será imposible realizar compras online, tendrán que ser telefónicas o visitando la tienda física si es que dispone de ella.</li>
                <li>No será posible personalizar sus preferencias geográficas como franja horaria, divisa o idioma.</li>
                <li>El sitio web no podrá realizar analíticas web sobre visitantes y tráfico en la web, lo que dificultará que la web sea competitiva.</li>
                <li>No podrá escribir en el blog, no podrá subir fotos, publicar comentarios, valorar o puntuar contenidos. La web tampoco podrá saber si usted es un humano o una aplicación automatizada que publica <em>spam</em>.</li>
                <li>No se podrá mostrar publicidad sectorizada, lo que reducirá los ingresos publicitarios de la web.</li>
                <li>Todas las redes sociales usan <em>cookies</em>, si las desactiva no podrá utilizar ninguna red social.</li>
            </ul>
        </p>
        <h2>¿Se pueden eliminar las <em>cookies</em>?</h2>
        <p>
            Sí. No sólo eliminar, también bloquear, de forma general o particular para un dominio específico.
        </p>
        <p>
            Para eliminar las <em>cookies</em> de un sitio web debe ir a la configuración de su navegador y allí podrá buscar las asociadas al dominio en cuestión y proceder a su eliminación.
        </p>
        <h2 id="navegadores">Configuración de <em>cookies</em> para los navegadores más polulares</h2>
        <p>
            A continuación le indicamos cómo acceder a una <em>cookie</em> determinada del navegador <b>Chrome</b>. Nota: estos pasos pueden variar en función de la versión del navegador:
            <ol>
                <li>Vaya a Configuración o Preferencias mediante el menú Archivo o bien pinchando el icono de personalización que aparece arriba a la derecha.</li>
                <li>Verá diferentes secciones, pinche la opción <em>Mostrar opciones avanzadas</em>.</li>
                <li>Vaya a <em>Privacidad</em>, <em>Configuración de contenido</em>.</li>
                <li>Seleccione <em>Todas las <em>cookies</em> y los datos de sitios</em>.</li>
                <li>Aparecerá un listado con todas las <em>cookies</em> ordenadas por dominio. Para que le sea más fácil encontrar las <em>cookies</em> de un determinado dominio introduzca parcial o totalmente la dirección en el campo <em>Buscar cookies</em>.</li>
                <li>Tras realizar este filtro aparecerán en pantalla una o varias líneas con las <em>cookies</em> de la web solicitada. Ahora sólo tiene que seleccionarla y pulsar la <em>X</em> para proceder a su eliminación.</li>
            </ol>
        </p>
        <p>
            Para acceder a la configuración de <em>cookies</em> del navegador <b>Internet Explorer</b> siga estos pasos (pueden variar en función de la versión del navegador):
            <ol>
                <li>Vaya a <em>Herramientas</em>, <em>Opciones de Internet</em></li>
                <li>Haga click en <em>Privacidad</em>.</li>
                <li>Mueva el deslizador hasta ajustar el nivel de privacidad que desee.</li>
            </ol>
        </p>
        <p>
            Para acceder a la configuración de <em>cookies</em> del navegador <b>Firefox</b> siga estos pasos (pueden variar en función de la versión del navegador):
            <ol>
                <li>Vaya a <em>Opciones</em> o <em>Preferencias</em> según su sistema operativo.</li>
                <li>Haga click en <em>Privacidad</em>.</li>
                <li>En <em>Historial</em> elija <em>Usar una configuración personalizada para el historial</em>.</li>
                <li>Ahora verá la opción <em>Aceptar cookies</em>, puede activarla o desactivarla según sus preferencias.</li>
            </ol>
        </p>
        <p>
            Para acceder a la configuración de <em>cookies</em> del navegador <b>Safari para OSX</b> siga estos pasos (pueden variar en función de la versión del navegador):
            <ol>
                <li>Vaya a <em>Preferencias</em>, luego <em>Privacidad</em>.</li>
                <li>En este lugar verá la opción <em>Bloquear cookies</em> para que ajuste el tipo de bloqueo que desea realizar.</li>
            </ol>
        </p>
        <p>
            Para acceder a la configuración de <em>cookies</em> del navegador <b>Safari para iOS</b> siga estos pasos (pueden variar en función de la versión del navegador):
            <ol>
                <li>Vaya a <em>Ajustes</em>, luego <em>Safari</em>.</li>
                <li>Vaya a <em>Privacidad y Seguridad</em>, verá la opción <em>Bloquear cookies</em> para que ajuste el tipo de bloqueo que desea realizar.</li>
            </ol>
        </p>
        <p>
            Para acceder a la configuración de <em>cookies</em> del navegador para dispositivos <b>Android</b> siga estos pasos (pueden variar en función de la versión del navegador):
            <ol>
                <li>Ejecute el navegador y pulse la tecla <em>Menú</em>, luego <em>Ajustes</em>.</li>
                <li>Vaya a <em>Seguridad y Privacidad</em>, verá la opción <em>Aceptar cookies</em> para que active o desactive la casilla.</li>
            </ol>
        </p>
        <p>
            Para acceder a la configuración de <em>cookies</em> del navegador para dispositivos <b>Windows Phone</b> siga estos pasos (pueden variar en función de la versión del navegador):
            <ol>
                <li>Abra <em>Internet Explorer</em>, luego <em>Más</em>, luego <em>Configuración</em></li>
                <li>Ahora puede activar o desactivar la casilla <em>Permitir cookies</em>.</li>
            </ol>
        </p>';

        }


        public function page_aviso_legal($nombre_empresa, $direccion_empresa, $cif_empresa, $registro_mercantil, $dominio_empresa, $correo_empresa)
        {

        return '

        <ol>
            <li><strong> Política de privacidad y protección de datos personales </strong></li>
        </ol>
        Mediante este aviso, '.$nombre_empresa.', '.$direccion_empresa.' '.$cif_empresa.' '.$registro_mercantil.' informa a los usuarios del portal web '.$dominio_empresa.' acerca de su política de protección de datos de carácter personal para que los usuarios determinen, libre y voluntariamente, si desean facilitar a '.$nombre_empresa.' los Datos Personales que se les puedan requerir o que se puedan obtener de los Usuarios con ocasión de la suscripción o alta en algunos de los servicios ofrecidos por '.$nombre_empresa.' en el Portal o a través del Portal. '.$nombre_empresa.' se reserva el derecho a modificar la presente política para adaptarla a novedades legislativas o jurisprudenciales así como a prácticas de la industria.

        En dichos supuestos, '.$nombre_empresa.' anunciará en esta página los cambios introducidos con razonable antelación a su puesta en práctica. A los efectos de la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, le informamos que los datos recabados en los distintos formularios serán incluidos en un fichero de datos de carácter personal con el fin de tramitar adecuadamente su solicitud, y cuyo destinatario será '.$nombre_empresa.'. '.$nombre_empresa.', como responsable del fichero, garantiza el ejercicio de los derechos de acceso, rectificación, cancelación y oposición de los datos facilitados. Para ello, y con el fin de facilitarle este trámite, bastará con que nos remita un mensaje con su petición, a la dirección electrónica: '.$correo_empresa.'.

        De igual modo, se compromete, en la utilización de los datos incluidos en el fichero, a respetar su confidencialidad y a utilizarlos de acuerdo con la finalidad del fichero. Remitiendo la información solicitada en los formularios, el interesado consiente expresamente el tratamiento y cesión de sus datos a '.$nombre_empresa.', para el cumplimiento de la finalidad arriba indicada.

        A los efectos de la Ley Orgánica 15/1999, de 13 de diciembre, de Protección de Datos de Carácter Personal, le informamos que sus datos recabados en los distintos formularios serán incluidos en un fichero de '.$nombre_empresa.' con la finalidad de tramitar su solicitud y gestionar adecuadamente la prestación de servicios. Dichos datos serán tratados asimismo para informarle y remitirle publicidad sobre promociones especiales relativas a servicios o productos relacionados con internet y la nuevas tecnologías. Si no desea que sus datos sean tratados con finalidad comercial, le rogamos comunique marque la casilla que le aparecerá en el momento de contratar el servicio. En la dirección electrónica: '.$correo_empresa.' podrá ejercer los derechos de acceso rectificación, cancelación y oposición que la normativa le reconoce.
        <ol start="2">
            <li><strong> Navegación web. Cookies</strong></li>
        </ol>
        Las cookies son pequeños archivos de texto que se instalan en el navegador del ordenador del Usuario para registrar su actividad, enviando una identificación anónima que se almacena en el mismo, con la finalidad de que la navegación sea más sencilla, permitiendo, por ejemplo, el acceso a los Usuarios que se hayan registrado previamente y el acceso a las áreas, servicios, promociones o concursos reservados exclusivamente a ellos sin tener que registrarse en cada visita. Se pueden utilizar también para medir la audiencia, parámetros del tráfico y navegación, tiempo de sesión, y/o controlar el progreso y el número de entradas.

        '.$nombre_empresa.' procurará en todo momento establecer mecanismos adecuados para obtener el consentimiento del Usuario para la instalación de cookies que lo requieran. No obstante lo anterior, deberá tenerse en cuenta que, de conformidad con la Ley, se entenderá que el Usuario ha dado su consentimiento si modifica la configuración del navegador deshabilitando las restricciones que impiden la entrada de cookies y que el referido consentimiento no será preciso para la instalación de aquellas cookies que sean estrictamente necesarias para la prestación de un servicio expresamente solicitado por el Usuario (mediante registro previo).

        A continuación adjuntamos una lista de las cookies principales que '.$nombre_empresa.' está utilizando:
        <table>
        <tbody>
        <tr>
        <td><strong>Nombre</strong></td>
        <td><strong>Origen</strong></td>
        <td><strong>Función de la cookie</strong></td>
        </tr>
        <tr>
        <td>-utma</td>
        <td>Google Analytics</td>
        <td>Habilitan la función de control de visitas únicas. La primera vez que un usuario entre en el sitio Web de '.$nombre_empresa.'. A través de un navegador se instalará esta cookie. Cuando este usuario vuelva a entrar en nuestra página con el mismo navegador, la cookie considerará que es el mismo usuario. Solo en el caso de que el usuario cambie de navegador, Google Analytics lo considerará otro usuario.</td>
        </tr>
        <tr>
        <td>-utmb

        -utmc</td>
        <td>Google Analytics</td>
        <td>Habilitan la función de cálculo del tiempo de sesión. La primera (utmb) registra la hora de entrada en la página y la segunda (utmc) comprueba si se debe mantener la sesión abierta o se debe crear una sesión nueva. La cookie utmb caduca a los 30 minutos desde el último registro de página vista mientras que la utmc es una variable de sesión, por lo que se elimina automáticamente al cambiar de web o al cerrar el navegador.</td>
        </tr>
        <tr>
        <td>-utmz</td>
        <td>Google Analytics</td>
        <td>Habilitan la función de registro de la procedencia del usuario. Los datos registrados serán, entre otros, si el usuario llega a nuestro sitio Web por tráfico directo, desde otra web, desde una campaña publicitaria o desde un buscador (indicando la palabra clave utilizada y la fuente)</td>
        </tr>
        <tr>
        <td>PHPSESSID</td>
        <td>Propia de '.$nombre_empresa.'</td>
        <td>Habilita la función de control de idioma, detectando asi el pais de origen del visitante y mandandolo al idioma correcto.</td>
        </tr>
        <tr>
        <td>'.$nombre_empresa.'</td>
        <td>Propia de '.$nombre_empresa.'</td>
        <td>Permite realizar la permanencia de la sesión para mostrar el mensaje de informacion de las cookies</td>
        </tr>
        </tbody>
        </table>
        Sin perjuicio de lo anterior, el Usuario tiene la posibilidad de configurar su navegador para ser avisado de la recepción de cookies y para impedir su instalación en su equipo.

        &nbsp;
        <ol start="3">
            <li><strong> Condiciones de Uso y su aceptación</strong></li>
        </ol>
        Estas condiciones regulan el uso de la web de '.$nombre_empresa.' para el usuario de Internet, y expresan la aceptación plena y sin reservas del mismo de todas y cada una de las condiciones y restricciones que estén publicadas en la web en el momento en que acceda a la misma. El acceso a la web y/o la utilización de cualquiera de los servicios en ella incluidos supondrá la aceptación de todas las condiciones de uso. '.$nombre_empresa.' se reserva el derecho a modificar unilateralmente la web y los servicios en ella ofrecidos, incluyendo la modificación de las condiciones de uso. Por ello se recomienda al usuario que lea este Aviso Legal tantas veces como acceda a la web.

        &nbsp;
        <ol start="4">
            <li><strong> Condiciones de utilización de la Web</strong></li>
        </ol>
        El usuario debe utilizar la web de conformidad con los usos autorizados. Queda expresamente prohibida la utilización de la web o de cualquiera de sus servicios con fines o efectos ilícitos, contrarios a la buena fe, al orden público o a lo establecido en las condiciones de uso. Queda igualmente prohibido cualquier uso lesivo de derechos o intereses de terceros o que, de cualquier forma, dificulten la utilización por parte de otros usuarios la normal utilización de la web y/o sus servicios. La utilización de la web es gratuita para el usuario.

        &nbsp;
        <ol start="5">
            <li><strong> Derechos de Propiedad Intelectual e Industrial</strong></li>
        </ol>
        Todos los contenidos de la web (marca, nombres comerciales, imágenes, iconos, diseño y presentación general de las diferentes secciones) están sujetos a derechos de propiedad intelectual o industrial de '.$nombre_empresa.' o de terceros. En ningún caso el acceso a la web implica que por parte de '.$nombre_empresa.' o del titular de esos derechos: (1) se otorgue autorización o licencia alguna sobre esos contenidos, (2) se renuncie, transmita o ceda total o parcialmente ninguno de sus derechos sobre esos contenidos (entre otros, sus derechos de reproducción, distribución y comunicación pública). No podrán realizarse utilizaciones de la web y/o de sus contenidos, diferentes de las expresamente autorizadas por '.$nombre_empresa.'. Ningún usuario de esta web puede revender, volver a publicar, imprimir, bajar, copiar, retransmitir o presentar ningún elemento de esta web ni de los contenidos de la misma sin el consentimiento previo por escrito de '.$nombre_empresa.', a menos que la ley permita, en medida razonable, copiar o imprimir los contenidos para uso personal y no comercial manteniéndose inalterados, en todo caso, el Copyright y demás datos identificativos de los derechos de '.$nombre_empresa.' y/o del titular de los derechos de esos contenidos. Esta web y sus contenidos están protegidos por las leyes de protección de la Propiedad Industrial e Intelectual internacionales y de España, ya sea como obras individuales y/o como compilaciones. El usuario no puede borrar ni modificar de ninguna forma la información relativa a esos derechos incluidos en la web. Quedan reservados todos los derechos a favor de '.$nombre_empresa.' o del titular de los mismos.

        &nbsp;
        <ol start="6">
            <li><strong> Exclusión de Garantías y Responsabilidad</strong></li>
        </ol>
        <strong>Exclusión de garantías y responsabilidad por el funcionamiento de la Web</strong>

        '.$nombre_empresa.' no garantiza y no asume ninguna responsabilidad por el funcionamiento de la web y/o sus servicios. En caso de producirse interrupciones en su funcionamiento '.$nombre_empresa.' tratará, si esto fuera posible, de advertirlo al usuario. '.$nombre_empresa.' tampoco garantiza la utilidad de la web y/o sus servicios para la realización de ninguna actividad en particular, su infalibilidad ni que el usuario pueda utilizar en todo momento la web o los servicios que se ofrezcan. '.$nombre_empresa.' está autorizado a efectuar cuantas modificaciones técnicas sean precisas para mejorar la calidad, rendimiento, eficacia del sistema y de su conexión. Salvo que se indique expresamente un plazo, la prestación de los servicios tiene en principio una duración indefinida, no obstante, '.$nombre_empresa.' está autorizado a dar por terminados alguno de los servicios o el acceso a la web en cualquier momento. Siempre que esto fuera posible, '.$nombre_empresa.' tratará de comunicarlo con antelación al usuario.

        <strong>Exclusión de garantías y responsabilidad por los contenidos</strong>

        Los contenidos de todo tipo incluidos en la web que se hallan disponibles para el público en general, facilitan el acceso a información, productos y servicios suministrados o prestados por '.$nombre_empresa.'. Dichos contenidos son facilitados de buena fe por '.$nombre_empresa.' con información procedente, en ocasiones, de fuentes distintas a '.$nombre_empresa.'. Por lo tanto, '.$nombre_empresa.' no puede garantizar la fiabilidad, veracidad, exhaustividad y actualidad de los contenidos y, por tanto queda excluido cualquier tipo de responsabilidad de '.$nombre_empresa.' que pudiera derivarse por los daños causados, directa o indirectamente, por la información a la que se acceda por medio de la web. '.$nombre_empresa.' no garantiza la idoneidad de los contenidos incluidos en la web para fines particulares de quien acceda a la misma. En consecuencia, tanto el acceso a dicha web como el uso que pueda hacerse de la información y contenidos incluidos en las mismas se efectúa bajo la exclusiva responsabilidad de quien lo realice, y '.$nombre_empresa.' no responderá en ningún caso y en ninguna medida por los eventuales perjuicios derivados del uso de la información y contenidos accesibles en la web. Asimismo, '.$nombre_empresa.' no será en ningún caso responsable por productos o servicios prestados u ofertados por otras personas o entidades, o por contenidos, informaciones, comunicaciones, opiniones o manifestaciones de cualquier tipo originados o vertidos por terceros y a las que se pueda acceder a través de la web.

        <strong>Exclusión de garantías y responsabilidad por enlaces a otras páginas</strong>

        La web puede permitir al usuario su acceso por medio de enlaces a otras páginas web. '.$nombre_empresa.' no responde ni hace suyo el contenido de las páginas web enlazadas, ni garantiza la legalidad, exactitud, veracidad y fiabilidad de la información que incluyan. La existencia de un enlace no supondrá la existencia de relación de ningún tipo entre '.$nombre_empresa.' y la titular del sitio enlazado. '.$nombre_empresa.' no tendrá ningún tipo de responsabilidad por infracciones o daños que se causen al usuario o a terceros por el contenido de las páginas web a las que se encuentre unidas por un enlace. Jurisdicción y ley aplicable. Las condiciones de uso y los servicios ofrecidos en la web se rigen por la Ley Española. '.$nombre_empresa.' no tiene control alguno sobre quien o quienes pueden acceder a su web y donde pueden estar emplazados. A pesar de que '.$nombre_empresa.' es consciente de ello, esto no significa que se someta a las jurisdicciones de países extranjeros; en caso de conflicto o reclamación en relación a la web o cualquiera de los servicios por ella prestados, las partes acuerdan someterse expresamente a los juzgados y tribunales de Madrid (España).

        ';

        }
    }

}

$GLOBALS['wp_ovimedia_pack'] = new wp_ovimedia_pack();  
                       
?>