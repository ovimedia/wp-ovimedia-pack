<?php if ( ! defined( 'ABSPATH' ) ) exit;  ?>

<div id="scroll_back_container" class="tab_content">
    
    <p>
    <label for="enable_scroll_back" class="label_switchery"><?php echo translate( 'Enable scroll back:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="enable_scroll_back" name="enable_scroll_back" <?php if($this->wop_options['enable_scroll_back'] == "on") echo " checked "; ?>  />
    </p>
    
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>
    <p class="mobile_hide"></p>


    <p><label for="scroll_back_bottom_right_margin"><?php echo translate( 'Scroll back bottom and right margin:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_bottom_right_margin" name="scroll_back_bottom_right_margin" 

    placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>" 

    value="<?php echo $this->wop_options['scroll_back_bottom_right_margin']; ?>" /></p>

    <p><label for="scroll_back_size"><?php echo translate( 'Scroll back size:', 'wp-ovimedia-pack' ); ?></label>

        <select id="scroll_back_size" name="scroll_back_size" >

            <?php

                for ($x = 20; $x <= 120; $x++) 
                { 
                    echo "<option value='".$x."' ";                             

                    if($this->wop_options['scroll_back_size'] == $x) 
                        echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 
                } 

            ?>
            
        </select>
    </p>

    <p><label for="scroll_back_radius"><?php echo translate( 'Scroll back radius:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_radius" name="scroll_back_radius" 

    placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>" 

    value="<?php echo $this->wop_options['scroll_back_radius']; ?>" /></p>

    <p><label for="scroll_back_padding"><?php echo translate( 'Scroll back padding:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_padding" name="scroll_back_padding" 

    placeholder="<?php echo translate( 'px or %', 'wp-ovimedia-pack' ); ?>" 

    value="<?php echo $this->wop_options['scroll_back_padding']; ?>" /></p>

    <p><label for="scroll_back_background_color"><?php echo translate( 'Scroll back background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_background_color" name="scroll_back_background_color" 

    class="jscolor" value="<?php echo $this->wop_options['scroll_back_background_color']; ?>" /></p>

    <p><label for="scroll_back_icon_color"><?php echo translate( 'Scroll back icon color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_icon_color" name="scroll_back_icon_color" 

    class="jscolor" value="<?php echo $this->wop_options['scroll_back_icon_color']; ?>" /></p>

    <p><label for="scroll_back_hover_background_color"><?php echo translate( 'Scroll back hover background color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_hover_background_color" name="scroll_back_hover_background_color" 

    class="jscolor" value="<?php echo $this->wop_options['scroll_back_hover_background_color']; ?>" /></p>

    <p><label for="scroll_back_hover_icon_color"><?php echo translate( 'Scroll back hover icon color:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="scroll_back_hover_icon_color" name="scroll_back_hover_icon_color" 

    class="jscolor" value="<?php echo $this->wop_options['scroll_back_hover_icon_color']; ?>" /></p>

</div>