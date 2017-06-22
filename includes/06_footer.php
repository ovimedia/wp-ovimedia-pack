<div id="footer_container" class="tab_content">
    
    <p>
    <label for="enable_footer" class="label_switchery"><?php echo translate( 'Enable extra footer:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="enable_footer" name="enable_footer" <?php if($this->wop_options['enable_footer'] == "on") echo " checked "; ?>  /></p>
    
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>

    <p><label for="footer_columns"><?php echo translate( 'Footer columns:', 'wp-ovimedia-pack' ); ?></label>

        <select id="footer_columns" name="footer_columns" >

            <?php           

                for ($x = 1; $x <= 4; $x++) 
                { 
                    echo "<option value='".$x."' ";                             

                    if($this->wop_options['footer_columns'] == $x) echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 

                } 

            ?>
        </select>
    </p>

    <p><label for="footer_width"><?php echo translate( 'Footer width:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="footer_width" name="footer_width" placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>"
    
     value="<?php echo $this->wop_options['footer_width']; ?>" /></p>

    <p><label for="footer_left_padding"><?php echo translate( 'Footer left padding:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="footer_left_padding" name="footer_left_padding" placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>"
    
     value="<?php echo $this->wop_options['footer_left_padding']; ?>" /></p>

     <p><label for="footer_right_padding"><?php echo translate( 'Footer right padding:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="footer_right_padding" name="footer_right_padding" placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>"
    
     value="<?php echo $this->wop_options['footer_right_padding']; ?>" /></p>



    <p><label for="footer_background_color"><?php echo translate( 'Footer background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="footer_background_color" name="footer_background_color" 

    class="jscolor" value="<?php echo $this->wop_options['footer_background_color']; ?>" /></p>

    <p><label for="footer_font_color"><?php echo translate( 'Footer font color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="footer_font_color" name="footer_font_color" 

    class="jscolor" value="<?php echo $this->wop_options['footer_font_color']; ?>" /></p>


</div>