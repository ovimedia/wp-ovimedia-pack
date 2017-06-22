<div id="cookies_container" class="tab_content">
    
    <p>
    <label for="enable_cookies" class="label_switchery"><?php echo translate( 'Enable cookies notice:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="enable_cookies" name="enable_cookies" <?php if($this->wop_options['enable_cookies'] == "on") echo " checked "; ?>  /></p>
    
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>

    <p><label for="position_cookies"><?php echo translate( 'Position message cookies:', 'wp-ovimedia-pack' ); ?></label>

        <select id="position_cookies" name="position_cookies" >

            <?php

                $positions = array("top", "bottom");

                for ($x = 0; $x < count($positions); $x++) 
                { 
                    echo "<option value='".$positions[$x]."' ";                             

                    if($this->wop_options['position_cookies'] == $positions[$x]) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($positions[$x]), 'wp-ovimedia-pack' )."</option>"; 
                } 

            ?>
            
        </select>
    </p>

    <p><label for="hide_cookies"><?php echo translate( 'Hide message:', 'wp-ovimedia-pack' ); ?></label>

        <select id="hide_cookies" name="hide_cookies" >

            <option value="auto" <?php if($this->wop_options['hide_cookies'] == "auto") echo ' selected="selected" '; ?>> 

            <?php echo translate( 'Auto', 'wp-ovimedia-pack' ) ?></option>

            <option value="button" <?php if($this->wop_options['hide_cookies'] == "button") echo ' selected="selected" '; ?>> 

            <?php echo translate( 'Only acept button', 'wp-ovimedia-pack' ) ?></option>

            <option value="2buttons" <?php if($this->wop_options['hide_cookies'] == "2buttons") echo ' selected="selected" '; ?>> 

            <?php echo translate( 'Acept and cancel buttons', 'wp-ovimedia-pack' ) ?></option>

        </select>

    </p>

    <p><label for="box_shadow_cookies"><?php echo translate( 'Box shadow cookies:', 'wp-ovimedia-pack' ); ?></label>

        <select id="box_shadow_cookies" name="box_shadow_cookies" >

            <?php           

                for ($x = 0; $x <= 20; $x++) 
                { 
                    echo "<option value='".$x."' ";                             

                    if($this->wop_options['box_shadow_cookies'] == $x) echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 

                } 

            ?>

        </select>

    </p>

    <p><label for="font_size_cookies"><?php echo translate( 'Cookies notice font size:', 'wp-ovimedia-pack' ); ?></label>

        <select id="font_size_cookies" name="font_size_cookies" >

            <?php           

                for ($x = 10; $x <= 32; $x++) 
                { 
                    echo "<option value='".$x."' ";                             

                    if($this->wop_options['font_size_cookies'] == $x) echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 

                } 

            ?>

        </select>

    </p>

    <p><label for="button_radius_cookies"><?php echo translate( 'Border radius buttons:', 'wp-ovimedia-pack' ); ?></label>

        <select id="button_radius_cookies" name="button_radius_cookies" >

            <?php           

                for ($x = 0; $x <= 20; $x++) 
                { 
                    echo "<option value='".$x."' ";                              

                    if($this->wop_options['button_radius_cookies'] == $x) echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 

                } 
            ?>

        </select>

    </p>

    <p><label for="text_message_cookies"><?php echo translate( 'Cookies message text:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="text_message_cookies" name="text_message_cookies" 

        value="<?php if($this->wop_options['text_message_cookies'] != "") echo $this->wop_options['text_message_cookies']; 

        else echo translate( 'This website uses cookies. If you continue browsing we understand that you accept', 'wp-ovimedia-pack' )  ?>" /></p>

    <p><label for="link_text_cookies"><?php echo translate( 'Link cookies text:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="link_text_cookies" name="link_text_cookies" 

        value="<?php if($this->wop_options['link_text_cookies'] != "") echo $this->wop_options['link_text_cookies']; 

        else echo translate( 'the conditions of use.', 'wp-ovimedia-pack' )  ?>" /></p> 

    <p><label for="text_button_cookies"><?php echo translate( 'Button text acept cookies:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="text_button_cookies" name="text_button_cookies" 

        value="<?php if($this->wop_options['text_button_cookies'] != "") echo $this->wop_options['text_button_cookies']; 

        else echo translate( 'Ok', 'wp-ovimedia-pack' )  ?>" /></p>

    <p><label for="text_button_cancel_cookies"><?php echo translate( 'Button text cancel cookies:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="text_button_cancel_cookies" name="text_button_cancel_cookies" 

        value="<?php if($this->wop_options['text_button_cancel_cookies'] != "") echo $this->wop_options['text_button_cancel_cookies']; 

        else echo translate( 'Cancel', 'wp-ovimedia-pack' )  ?>" /></p>

    <p><label for="title_politica_cookies"><?php echo translate( 'Cookie law title page:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="title_politica_cookies" name="title_politica_cookies" 

        value="<?php if($this->wop_options['title_politica_cookies'] != "") echo $this->wop_options['title_politica_cookies']; 

        else echo translate( 'Cookie Law', 'wp-ovimedia-pack' )  ?>" /></p>    

    <p><label for="slug_politica_cookies"><?php echo translate( 'Cookie law slug page:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="slug_politica_cookies" name="slug_politica_cookies" 

        value="<?php if($this->wop_options['slug_politica_cookies'] != "") echo $this->wop_options['slug_politica_cookies']; 

        else echo translate( 'cookie-law', 'wp-ovimedia-pack' )  ?>" /></p>    

    <p><label for="title_mas_informacion"><?php echo translate( 'More information cookies title page:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="title_mas_informacion" name="title_mas_informacion" 

        value="<?php if($this->wop_options['title_mas_informacion'] != "") echo $this->wop_options['title_mas_informacion']; 

        else echo translate( 'More information about cookies', 'wp-ovimedia-pack' )  ?>" /></p>        

    <p><label for="slug_mas_informacion"><?php echo translate( 'More information cookies slug page:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="slug_mas_informacion" name="slug_mas_informacion" 

        value="<?php if($this->wop_options['slug_mas_informacion'] != "") echo $this->wop_options['slug_mas_informacion']; 

        else echo translate( 'more-information-about-cookies', 'wp-ovimedia-pack' )  ?>" /></p>   



    <p><label for="background_color_cookies"><?php echo translate( 'Notice background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="background_color_cookies" name="background_color_cookies" 

    class="jscolor" value="<?php echo $this->wop_options['background_color_cookies']; ?>" /></p>



    <p><label for="font_color_cookies"><?php echo translate( 'Notice font color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="font_color_cookies" name="font_color_cookies" 

    class="jscolor" value="<?php echo $this->wop_options['font_color_cookies']; ?>" /></p>



    <p><label for="background_color_button_cookies"><?php echo translate( 'Acept button background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="background_color_button_cookies" name="background_color_button_cookies" 

    class="jscolor" value="<?php echo $this->wop_options['background_color_button_cookies']; ?>" /></p>

    <p><label for="font_color_button_cookies"><?php echo translate( 'Acept button font color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="font_color_button_cookies" name="font_color_button_cookies" 

    class="jscolor" value="<?php echo $this->wop_options['font_color_button_cookies']; ?>" /></p>  



    <p><label for="background_color_cancel_button_cookies"><?php echo translate( 'Cancel button background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="background_color_cancel_button_cookies" name="background_color_cancel_button_cookies" 

    class="jscolor" value="<?php echo $this->wop_options['background_color_cancel_button_cookies']; ?>" /></p>

    <p><label for="font_color_cancel_button_cookies"><?php echo translate( 'Cancel button font color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="font_color_cancel_button_cookies" name="font_color_cancel_button_cookies" 

    class="jscolor" value="<?php echo $this->wop_options['font_color_cancel_button_cookies']; ?>" /></p>  

    <p><input  type="button" id="button_cookies_pages" value="<?php echo translate( 'Create cookie pages', 'wp-ovimedia-pack' )  ?>" class="button button-primary" /></p>

</div>