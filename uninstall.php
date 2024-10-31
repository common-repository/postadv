<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

// delete options
delete_option( 'postadv_opt_script' );
delete_option( 'postadv_opt_hidein' );
delete_option( 'postadv_opt_latency' );
delete_option( 'postadv_opt_latency_day' );
delete_option( 'postadv_opt_mcu' );
 
// deleta all meta keys nd values from post meta the plugin has created.
global $wpdb;
$wpdb->delete( $wpdb->prefix . 'postmeta', array( 'meta_key' => 'postadv_meta_script' ) );

