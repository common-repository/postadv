<?php
/*
Plugin Name: PostAdv
Plugin URI: #
Description: This plugin will help you to add the Adv. in your desired location as post content using shortcode.
Version: 1.0.2
Author: ugene, sachyya-sachet
Author URI: #
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: postadv
*/

defined( 'ABSPATH' ) 				    or die( 'No script kiddies please!' );


/*------------------------------------------------------------------------*
 * Constants
 *------------------------------------------------------------------------*/
defined( 'POSTADV_VERSION' ) 			or define( 'POSTADV_VERSION', '1.0.1' );
defined( 'POSTADV_PLUGIN_DIR_PATH' )  	or define( 'POSTADV_PLUGIN_DIR_PATH', dirname(__FILE__) );
defined( 'POSTADV_PLUGIN_FILE_PATH' ) 	or define( 'POSTADV_PLUGIN_FILE_PATH', __FILE__ );
defined( 'POSTADV_PLUGIN_URL' ) 		or define( 'POSTADV_PLUGIN_URL', plugins_url( plugin_basename( dirname( __FILE__ ))));

require( POSTADV_PLUGIN_DIR_PATH . '/inc/class-postadv.php' );

// register_activation_hook( __FILE__, array( 'Postadv', 'pa_create_admin_menu' ));
$postadv = new Postadv;