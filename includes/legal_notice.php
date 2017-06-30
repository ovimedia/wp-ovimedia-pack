<?php if ( ! defined( 'ABSPATH' ) ) exit;  ?>

<div id="legal_notice_container" class="tab_content">

    <p><label for="title_aviso_legal"><?php echo translate( 'Legal notice title page:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="title_aviso_legal" name="title_aviso_legal" 
        value="<?php if($this->wop_options['title_aviso_legal'] != "") echo $this->wop_options['title_aviso_legal']; 
        else echo translate( 'Legal Notice', 'wp-ovimedia-pack' )  ?>" /></p>    

    <p><label for="slug_aviso_legal"><?php echo translate( 'Legal notice slug page:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="slug_aviso_legal" name="slug_aviso_legal" 
        value="<?php if($this->wop_options['slug_aviso_legal'] != "") echo $this->wop_options['slug_aviso_legal']; 
        else echo translate( 'legal-notice', 'wp-ovimedia-pack' )  ?>" /></p>    

    <p><label for="name_empresa"><?php echo translate( 'Company name:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="name_empresa" name="name_empresa" 
        value="<?php if($this->wop_options['name_empresa'] != "") echo $this->wop_options['name_empresa']; ?>"
          placeholder="<?php echo translate( 'Company', 'wp-ovimedia-pack' )  ?>" /></p>        

    <p><label for="address_empresa"><?php echo translate( 'Company address:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="address_empresa" name="address_empresa" 
        value="<?php if($this->wop_options['address_empresa'] != "") echo $this->wop_options['address_empresa']; ?>"
        placeholder="<?php echo translate( 'Address', 'wp-ovimedia-pack' )  ?>" />
        
        <input type="hidden" value="<?php echo translate( 'with registered office in', 'wp-ovimedia-pack' ); ?> " id="pre_address_empresa" name="pre_address_empresa" />
    </p>   

    <p><label for="cif_empresa"><?php echo translate( 'Company CIF:', 'wp-ovimedia-pack' ); ?>:</label>
    <input type="text"  id="cif_empresa" name="cif_empresa" 
        value="<?php if($this->wop_options['cif_empresa'] != "") echo $this->wop_options['cif_empresa']; ?>"
        placeholder="<?php echo translate( 'CIF', 'wp-ovimedia-pack' )  ?>" />
        
        <input type="hidden" value="<?php echo translate( 'with number CIF', 'wp-ovimedia-pack' ); ?> " id="pre_cif_empresa" name="pre_cif_empresa" />
    </p>   

    <p><label for="register_empresa"><?php echo translate( 'Company Mercantile Registry:', 'wp-ovimedia-pack' ); ?>:</label>
    <input type="text"  id="register_empresa" name="register_empresa" 
        value="<?php if($this->wop_options['register_empresa'] != "") echo $this->wop_options['register_empresa']; ?>"
        placeholder="<?php echo translate( 'Mercantile Registry', 'wp-ovimedia-pack' ); ?>" />
        
        <input type="hidden" value="<?php echo translate( 'and registered in the Mercantile Registry', 'wp-ovimedia-pack' ); ?> " id="pre_register_empresa" name="pre_register_empresa" />
    </p> 

    <p><label for="domain_empresa"><?php echo translate( 'Company domain:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="domain_empresa" name="domain_empresa" 
        value="<?php if($this->wop_options['domain_empresa'] != "") echo $this->wop_options['domain_empresa']; ?>"
        placeholder="<?php echo translate( 'Domain', 'wp-ovimedia-pack' )  ?>" /></p>       

    <p><label for="email_empresa"><?php echo translate( 'Company E-mail:', 'wp-ovimedia-pack' ); ?></label>
    <input type="text"  id="email_empresa" name="email_empresa" 
        value="<?php if($this->wop_options['email_empresa'] != "") echo $this->wop_options['email_empresa']; ?>"
        placeholder="<?php echo translate( 'E-mail', 'wp-ovimedia-pack' );  ?>" /></p>     

    <p><input type="button" id="button_law_page" value="<?php echo translate( 'Create law notice page', 'wp-ovimedia-pack' )  ?>" class="button button-primary" /></p>

</div>