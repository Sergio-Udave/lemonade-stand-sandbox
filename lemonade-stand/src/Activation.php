<?php
/**
 * Plugin Setup
 *
 * This file handles all the setup for the plugin upon activation. It also provides a centralized location
 * to manage the plugin's configuration and settings should any need to occur upon activation of this plugin. 
 * Additionally, it grants the administrator role the capability to manage this plugin.
 */


namespace LemonadeStand;

class Activation {

    public static function activate() {
        
        $role = get_role( 'administrator' );

        if ( ! empty( $role ) ) {
            $role->add_cap( 'lemonade_stand_manage' );
        }
    }
}

register_activation_hook( __FILE__, function() {
    require_once LS_PLUGIN_DIR . 'src/Activation.php';
    Activation::activate();
} );
