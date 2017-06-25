<div id="contact_forms_container" class="tab_content">

<?php 

    if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) { ?>

    <p><label for="contact_form_name"><?php echo translate( 'Contact form name:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="contact_form_name" name="contact_form_name" 

    value="<?php echo $this->wop_options['contact_form_name']; ?>" /></p>

    <p><label for="contact_form_receiver_email"><?php echo translate( 'Contact form receiver:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="contact_form_receiver_email" name="contact_form_receiver_email" 

    value="<?php echo $this->wop_options['contact_form_receiver_email']; ?>" /></p>

    <p><label for="contact_form_subject"><?php echo translate( 'Contact form subject:', 'wp-ovimedia-pack' ); ?></label>

    <input type="text"  id="contact_form_subject" name="contact_form_subject" 

    value="<?php echo $this->wop_options['contact_form_subject']; ?>" /></p>

    

    <p><label for="contact_form_fields"><?php echo translate( 'Contact form fields:', 'wp-ovimedia-pack' ); ?></label>

        <select id="contact_form_fields" class="select2" multiple="multiple" name="contact_form_fields[]" >

            <?php

                $fields = array("name", "last name", "email", "phone", "subject");

                for ($x = 0; $x < count($fields); $x++) 
                { 
                    echo "<option value='".translate( ucfirst ($fields[$x]), 'wp-ovimedia-pack' )."' ";                             

                    if(in_array(translate( ucfirst ($fields[$x]), 'wp-ovimedia-pack' ), $this->wop_options['contact_form_fields'] )) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($fields[$x]), 'wp-ovimedia-pack' )."</option>"; 
                } 

            ?>
            
        </select>
    </p>

    <p><label for="contact_form_required_fields"><?php echo translate( 'Contact form required fields:', 'wp-ovimedia-pack' ); ?></label>

        <select id="contact_form_required_fields" class="select2" multiple="multiple" name="contact_form_required_fields[]" >

            <?php

                $fields = array("name", "last name", "email", "phone", "subject");

                for ($x = 0; $x < count($fields); $x++) 
                { 
                    echo "<option value='".translate( ucfirst ($fields[$x]), 'wp-ovimedia-pack' )."' ";                             

                    if(in_array(translate( ucfirst ($fields[$x]), 'wp-ovimedia-pack' ), $this->wop_options['contact_form_required_fields'] )) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($fields[$x]), 'wp-ovimedia-pack' )."</option>"; 
                } 

            ?>
            
        </select>
    </p>

    <p><label for="contact_form_include_message"><?php echo translate( 'Include message field in contact form:', 'wp-ovimedia-pack' ); ?></label>

        <select id="contact_form_include_message" name="contact_form_include_message" >

            <?php

                $values = array("yes", "no");

                for ($x = 0; $x < count($values); $x++) 
                { 
                    echo "<option value='".$values[$x]."' ";                             

                    if($this->wop_options['contact_form_include_message'] == $values[$x]) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($values[$x]), 'wp-ovimedia-pack' )."</option>"; 
                } 

            ?>
            
        </select>
    </p>

    <p><label for="contact_form_include_legal_notice"><?php echo translate( 'Include legal notice field in contact form:', 'wp-ovimedia-pack' ); ?></label>

        <select id="contact_form_include_legal_notice" name="contact_form_include_legal_notice" >

            <?php

                for ($x = 0; $x < count($values); $x++) 
                { 
                    echo "<option value='".$values[$x]."' ";                             

                    if($this->wop_options['contact_form_include_legal_notice'] == $values[$x]) 
                        echo ' selected="selected" '; 

                    echo ">".translate( ucfirst ($values[$x]), 'wp-ovimedia-pack' )."</option>"; 
                } 

            ?>
            
        </select>
    </p>

    <p><label for="contact_form_columns"><?php echo translate( 'Contact form columns:', 'wp-ovimedia-pack' ); ?></label>

        <select id="contact_form_columns" name="contact_form_columns" >

            <?php           

                for ($x = 1; $x <= 4; $x++) 
                { 
                    echo "<option value='".$x."' ";                             

                    if($this->wop_options['contact_form_columns'] == $x) echo ' selected="selected" '; 

                    echo ">".$x."</option>"; 

                } 

            ?>

        </select>

    </p>

     <p><input  type="button" id="contact_form_generator" value="<?php echo translate( 'Generate contact form', 'wp-ovimedia-pack' )  ?>" class="button button-primary" /></p>

<?php } 
    else {
         echo "<p class='warning'>". translate( 'To use this function you need to install and activate contact form 7 plugin.', 'wp-ovimedia-pack' )."</p>";

} ?>
</div>