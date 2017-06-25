<?php
/*
Plugin Name: Ovimedia Pack 
Description: Pack of functional modules for Wordpress.
Author: Ovi García - ovimedia.es
Author URI: http://www.ovimedia.es/
Text Domain: wp-ovimedia-pack
Version: 1.1.1
Plugin URI: http://www.ovimedia.es/
*/


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

                $sections = array();
                
                $ruta = '../wp-content/plugins/'.basename( dirname( __FILE__ ) ).'/includes/';
                
                if ($gestor = opendir($ruta)) 
                {
                    while (false !== ($file = readdir($gestor))) 
                        if ($file != "." && $file != "..") 
                            $sections[] = $file;

                    closedir($gestor);
                }

                sort($sections);

                ?>
                
                <ul id="list_options">
                    <?php 
                        for($x = 0; $x < count($sections); $x++)  
                        {
                            echo "<li id='".substr($sections[$x], 3, -4)."' title='#".substr($sections[$x], 3, -4)."_container' class='tab_links ";

                            if($x == 0) echo " active_tab' >";
                            else echo "' >";

                            echo translate(  ucwords(str_replace("_", " ", substr($sections[$x], 3, -4))), 'wp-ovimedia-pack' )."</li>";
                        }
                    ?>
                </ul>

                <?php 

                    foreach (glob($ruta."*.php") as $module)
                    {
                        include $module;
                    }

                ?>

                <input type="hidden" id="url_base" value="<?php echo WP_PLUGIN_URL. '/'.basename( dirname( __FILE__ ) ).'/'; ?>" />
                
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
    }

}

$GLOBALS['wp_ovimedia_pack'] = new wp_ovimedia_pack();  
                       
?>