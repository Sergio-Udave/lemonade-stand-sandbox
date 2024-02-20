<?php
/**
 * Plugin Uninstall
 * 
 * It is important to check if the constant WP_UNINSTALL_PLUGIN is defined before doing anything. 
 * This constant is defined by WordPress when the uninstall.php file is called. If it is not defined, 
 * the plugin should not do anything and should exit immediately. This is a security measure to prevent 
 * the uninstall.php file from uninententionally being called and deleting data.
 */
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    wp_die( sprintf( 
        __( '%s should only be called when uninstalling the plugin.', 'lemonade-stand' ), 
        __FILE__ ) );
    exit;
}

$role = get_role( 'administrator' );

if ( ! empty( $role ) ) {
    $role->remove_cap( 'lemonade_stand_manage' );
}