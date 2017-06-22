<div id="login_container" class="tab_content">

    <p><label for="enable_login_redirect" class="label_switchery"><?php echo translate( 'Enable login redirect:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="enable_login_redirect" name="enable_login_redirect" <?php if($this->wop_options['enable_login_redirect'] == "on") echo " checked "; ?>  /></p>

    <p><label for="url_login_redirect"><?php echo translate( 'URL login redirect:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="url_login_redirect" name="url_login_redirect" 
        value="<?php echo $this->wop_options['url_login_redirect']; ?>"
        placeholder="<?php echo translate( 'URL', 'wp-ovimedia-pack' )  ?>" /></p>    

    <p><label for="enable_logout_redirect" class="label_switchery"><?php echo translate( 'Enable logout redirect:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="enable_logout_redirect" name="enable_logout_redirect" <?php if($this->wop_options['enable_logout_redirect'] == "on") echo " checked "; ?>  /></p>

    <p><label for="url_logout_redirect"><?php echo translate( 'URL logout redirect:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="url_logout_redirect" name="url_logout_redirect" 
        value="<?php echo $this->wop_options['url_logout_redirect']; ?>"
        placeholder="<?php echo translate( 'URL', 'wp-ovimedia-pack' )  ?>" /></p> 

    <p>
        <label for="theme_login"><?php echo translate( 'Login theme:', 'wp-ovimedia-pack' ); ?></label>

        <select id="theme_login" name="theme_login" >

        <option value="default.css" 

        <?php 
        
        if($this->wop_options['theme_login'] == "default.css")
            echo ' selected="selected" ';

        echo " >".translate( 'Default', 'wp-ovimedia-pack' )."</option>";  
        

        $ruta = '../wp-content/plugins/wp-ovimedia-pack/themes/';
                
        if ($themes = opendir($ruta)) 
        {
            while (false !== ($css = readdir($themes))) 
                if ($css != "." && $css != ".." && $css != "default.css") 
                {
                    echo '<option value="'.$css.'" ';

                    if($this->wop_options['theme_login'] == $css)
                        echo ' selected="selected" ';
                    
                    echo ' >'.translate(ucfirst (substr($css,0,-4)), 'wp-ovimedia-pack' ) .'</option>'; 
                }

            closedir($themes);
        } ?>

        </select>

    </p>
    <?php

     $logo =  wp_get_attachment_image_src($this->wop_options['login_logo_image'], "medium");
     $background =  wp_get_attachment_image_src($this->wop_options['login_background_image'], "medium");   
    ?>
    <p class="image_login_btn">
        <input type="number" value="<?php echo $this->wop_options['login_logo_image']; ?>" 
        class="regular-text login_logo_image" id="login_logo_image" name="login_logo_image" /> 
        <input type="button" class="set_custom_logo button button-primary" 
        value="<?php echo translate( 'Add logo', 'wp-ovimedia-pack' ); ?>"/>
        <input type="button" class="button button-primary" 
        id="remove_login_logo_button" value="<?php echo translate( 'Remove logo', 'wp-ovimedia-pack' ); ?>"/>
        
        <img class="image_login_page" src="<?php echo $logo[0]; ?>" />
    </p>

    <p class="image_login_btn">
        <input type="number" value="<?php echo $this->wop_options['login_background_image']; ?>" 
        class="regular-text login_logo_image" id="login_background_image" name="login_background_image" /> 
        <input type="button" class="set_custom_background button button-primary" 
        value="<?php echo translate( 'Add background', 'wp-ovimedia-pack' ); ?>"/>
        <input type="button" class="button button-primary" 
        id="remove_login_background_button" value="<?php echo translate( 'Remove background', 'wp-ovimedia-pack' ); ?>"/>
        <img class="image_background_page" src="<?php echo $background[0]; ?>" />
    </p>

</div>