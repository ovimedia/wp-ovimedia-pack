<div id="updates_container" class="tab_content">
    
    <p><label for="core_updates" class="label_switchery">
    <?php echo translate( 'Disable core updates:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="core_updates" name="core_updates" 
    <?php if($this->wop_options['core_updates'] == "on") echo " checked "; ?>  /></p>

    <p><label for="plugin_updates" class="label_switchery">
    <?php echo translate( 'Disable plugin updates:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="plugin_updates" name="plugin_updates" 
    <?php if($this->wop_options['plugin_updates'] == "on") echo " checked "; ?>  /></p>

    <p><label for="theme_updates" class="label_switchery">
    <?php echo translate( 'Disable theme updates:', 'wp-ovimedia-pack' ); ?></label>
    <input type="checkbox" class="js-switch" id="theme_updates" name="theme_updates" 
    <?php if($this->wop_options['theme_updates'] == "on") echo " checked "; ?>  /></p>

</div>