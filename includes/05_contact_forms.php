<div id="contact_forms_container" class="tab_content">

<?php 

    if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) { ?>

    <p><label for="contact_form_name"><?php echo translate( 'Contact form name:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="contact_form_name" name="contact_form_name" 

    value="<?php echo $this->wop_options['contact_form_name']; ?>" /></p>

    <p><label for="contact_form_receiver_email"><?php echo translate( 'Contact form receiver:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="contact_form_receiver_email" name="contact_form_receiver_email" 

    value="<?php echo $this->wop_options['contact_form_receiver_email']; ?>" /></p>

    <p><label for="contact_form_type"><?php echo translate( 'Contact form type:', 'wp-ovimedia-pack' ); ?></label>

        <select id="contact_form_type" name="contact_form_type" >

            <?php           

                $formtypes = array("Avada", "Visual Composer" );

                for ($x = 0; $x < count($formtypes); $x++) 
                { 
                    echo "<option value='".$formtypes[$x]."' ";                             

                    if($formtypes[$x] == $this->wop_options['contact_form_type']) 
                        echo ' selected="selected" '; 

                    echo ">".$formtypes[$x]."</option>";


                } 

            ?>
        </select>
    </p>

     <p><input  type="button" id="contact_form_generator" value="<?php echo translate( 'Generate contact form:', 'wp-ovimedia-pack' )  ?>" class="button button-primary" /></p>

<?php } 
    else {
         echo "<p class='warning'>". translate( 'To use this function you need to install and activate contact form 7 plugin.', 'wp-ovimedia-pack' )."</p>";

} ?>
</div>