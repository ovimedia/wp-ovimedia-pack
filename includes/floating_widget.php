<?php if ( ! defined( 'ABSPATH' ) ) exit;  ?>

<div id="floating_widget_container" class="tab_content">
    
    <p>
    <label for="enable_floating_widget" class="label_switchery"><?php echo translate( 'Enable floating widget:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="enable_floating_widget" name="enable_floating_widget" <?php if($this->wop_options['enable_floating_widget'] == "on") echo " checked "; ?>  />
    </p>
    
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>

    <p><label for="floating_widget_location"><?php echo translate( 'Widget location:', 'wp-ovimedia-pack' ); ?></label>

        <select id="floating_widget_location" name="floating_widget_location" >

            <?php           

                $positions = array("top", "bottom", "left", "right");

                for ($x = 0; $x < count($positions); $x++) 
                { 
                    echo "<option value='".$positions[$x]."' ";                             

                    if($this->wop_options['floating_widget_location'] == $positions[$x]) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($positions[$x]), 'wp-ovimedia-pack' )."</option>"; 

                } 

            ?>
        </select>
    </p>

    <p><label for="floating_widget_position"><?php echo translate( 'Widget position:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_position" name="floating_widget_position" 

    placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>" 

    value="<?php echo $this->wop_options['floating_widget_position']; ?>" /></p>

    <p><label for="floating_widget_font_size"><?php echo translate( 'Widget font size:', 'wp-ovimedia-pack' ); ?></label>

        <select id="floating_widget_font_size" name="floating_widget_font_size" >

            <?php

                for ($x = 10; $x <= 24; $x++) 
                { 
                    echo "<option value='".$x."' ";                             

                    if($this->wop_options['floating_widget_font_size'] == $x) 
                        echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 
                } 

            ?>
            
        </select>
    </p>


    <p><label for="floating_widget_button_text"><?php echo translate( 'Widget button text:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_button_text" name="floating_widget_button_text" 

    value="<?php echo $this->wop_options['floating_widget_button_text']; ?>" /></p>

    <p><label for="floating_widget_button_background_color"><?php echo translate( 'Widget button background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_button_background_color" name="floating_widget_button_background_color" 

    class="jscolor" value="<?php echo $this->wop_options['floating_widget_button_background_color']; ?>" /></p>

    <p><label for="floating_widget_button_font_color"><?php echo translate( 'Widget button font color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_button_font_color" name="floating_widget_button_font_color" 

    class="jscolor" value="<?php echo $this->wop_options['floating_widget_button_font_color']; ?>" /></p>

    <p><label for="floating_widget_button_mode"><?php echo translate( 'Floating button action:', 'wp-ovimedia-pack' ); ?></label>

        <select id="floating_widget_button_mode" name="floating_widget_button_mode" >

            <?php           

                $modes = array("widget", "link");

                for ($x = 0; $x < count($modes); $x++) 
                { 
                    echo "<option value='".$modes[$x]."' ";                             

                    if($this->wop_options['floating_widget_button_mode'] == $modes[$x]) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($modes[$x]), 'wp-ovimedia-pack' )."</option>"; 

                } 

            ?>
        </select>
    </p>

    <p><label for="floating_widget_url"><?php echo translate( 'Floating button URL:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_url" name="floating_widget_url" 

    value="<?php echo $this->wop_options['floating_widget_url']; ?>" /></p>

    <p><label for="floating_widget_width"><?php echo translate( 'Widget width:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_width" name="floating_widget_width" 

    placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>" 

    value="<?php echo $this->wop_options['floating_widget_width']; ?>" /></p>

    <p><label for="floating_widget_height"><?php echo translate( 'Widget height:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_height" name="floating_widget_height" 

    placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>" 

    value="<?php echo $this->wop_options['floating_widget_height']; ?>" /></p>


    <p><label for="floating_widget_background_color"><?php echo translate( 'Widget background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_background_color" name="floating_widget_background_color" 

    class="jscolor" value="<?php echo $this->wop_options['floating_widget_background_color']; ?>" /></p>

    <p><label for="floating_widget_font_color"><?php echo translate( 'Widget font color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_font_color" name="floating_widget_font_color" 

    class="jscolor" value="<?php echo $this->wop_options['floating_widget_font_color']; ?>" /></p>

    <p><label for="floating_widget_transition_delay"><?php echo translate( 'Widget delay appearance:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="floating_widget_transition_delay" name="floating_widget_transition_delay" 

     value="<?php echo $this->wop_options['floating_widget_transition_delay']; ?>" 
     placeholder="<?php echo translate( 'In seconds', 'wp-ovimedia-pack' ); ?>" /></p>

</div>