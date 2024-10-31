<?php
class Postadv {

	/**
	 * constructor
	 */
	public function __construct() {

		if( is_admin() ) {

			add_action( 'admin_menu', array( $this, 'postadv_create_option_menu' ) );

			add_action( 'add_meta_boxes', array( $this, 'postadv_add_metabox' ), 10, 2 );
			add_action( 'save_post', array( $this, 'postadv_save_metabox' ), 10, 2 );
            add_filter( 'safe_style_css', array( $this, 'postadv_safe_style' ));
		}

		add_shortcode( 'postadv', array( $this, 'postadv_render_adv' ));
	}

	/**
	 * Add submenu under settings menu
	 */
	public function postadv_create_option_menu() {
				
		add_options_page(
			__( 'Postadv Settings', 'postadv' ),
			__( 'Postadv', 'postadv'),
			'manage_options',
			'postadv.php',
			array( $this, 'postadv_display_admin_page' )
		);
	}

	/**
	 * Display postadv admin settings
	 */
	public function postadv_display_admin_page() {

		require_once( POSTADV_PLUGIN_DIR_PATH . '/view/admin-settings.php' );
	}

	/**
	 * Add, render and save meta box
	 */
	public function postadv_add_metabox( $post_type, $post ) {
		
		add_meta_box( 'postadv_script_metabox', __( 'Postadv.', 'postadv' ), array( $this, 'postadv_render_script_metabox' ), $post_type, 'side' );
	}

	public function postadv_render_script_metabox( $post ) { 

		wp_nonce_field( 'postadv_postedit', 'postadv_postedit_nonce' );
		$postadv_meta_script = get_post_meta( $post->ID, 'postadv_meta_script', true );
		
		?>
		<p>If you want to have different adv. per post than add your script here else leave empty.</p>
		<textarea name="postadv_ip_adv" rows="5" style="width: 100%;"><?php echo $postadv_meta_script; ?></textarea>

	<?php 
	}

	function postadv_save_metabox( $post_id, $post ) {
		
		// Verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		if ( !isset( $_POST['postadv_postedit_nonce'] ) || !wp_verify_nonce( $_POST['postadv_postedit_nonce'], 'postadv_postedit' ) )
			return $post_id;

		// Verify if this is an auto save routine. If it is our form has not been submitted, we dont want to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;

		// Check permissions to edit pages and/or posts
		if ( 'page' == $_POST['post_type'] ||  'post' == $_POST['post_type']) {
			if ( !current_user_can( 'edit_page', $post_id ) || !current_user_can( 'edit_post', $post_id ))
			  return $post_id;
		} 
		
		// OK, we're authenticated: we need to find and save the data
		$value = $this->postadv_sanitize_script( $_POST['postadv_ip_adv'] );

		// save data
		update_post_meta( $post_id, 'postadv_meta_script', $value ); 
	}

	/**
	 * Basically tells WordPress to whitelist the style attribute:display
     * https://wordpress.stackexchange.com/questions/173526/why-is-wp-kses-not-keeping-style-attributes-as-expected
     *
     * @param array default whitlelisted arrays
     * @return array
     *
     * @since 1.0.2
	 */
    function postadv_safe_style( $styles )
    {
        $styles[] = 'display';
        return $styles;
    }

	/**
	 * Shortcode for rendering the adsense
     *
     * @param array parameters from the shortcode or none
     *
     * @since 1.0.0
	 */
	function postadv_render_adv( $atts ) {

		$a = shortcode_atts( array (
		    'hidein' => get_option( 'postadv_opt_hidein' ),
			'latency' => get_option( 'postadv_opt_latency' ),
			'latency_day' => get_option( 'postadv_opt_latency_day' ) 
			), $atts );

		ob_start();

		// first check if the MCU box is checked to disable the shortcode
		// if checked to stop all shortcode then no need to go down, return 
		if( 'on' === get_option( 'postadv_opt_mcu' ) )
			return;

		// second check if the post has adsense code as meta
		global $post;
		$postadv = get_post_meta( $post->ID, 'postadv_meta_script', true );

		// if the post has no AdSense script, use the script form the settings page
		$postadv = ( "" == $postadv ) ? get_option( 'postadv_opt_script' ) : $postadv ;
		
		if( !empty( $postadv ) ) {

			// hidein option
			if( $a['hidein'] != "" && $a['hidein'] === "desktop"  ) {
			    if( wp_is_mobile() ) {
				    $this->postadv_render_adsense( $a, $post, $postadv );
			    }
			} elseif( $a['hidein'] != "" && $a['hidein'] === "mobile"  ){
			    if( ! wp_is_mobile() ) {
				    $this->postadv_render_adsense( $a, $post, $postadv );
                }
			} else {
                $this->postadv_render_adsense( $a, $post, $postadv );
            }
			return ob_get_clean();
		}
	}

	/**
	 * This actually renders the AdSense in the front
     *
     * @param array final settings of array
     * @param object globa post object
     * @param string actual google adsense script
     * @return void
     *
     * @since 1.0.2
	 */
	private function postadv_render_adsense( $a, $post, $postadv ) {

		// now lets check the latency
		// if latecny is on
		if ( "on" == $a['latency'] ) {

			$published_day = $post->post_date;

			$date1 = new DateTime( $post->post_date );
			$date2 = new DateTime( date( 'Y-m-d H:i:s' ) );

			$diff = $date2->diff( $date1 )->format( "%a" );

			if ( $diff > $a['latency_day'] ) {

				echo '<div class="postadv-wrapper" style="text-align:center;margin-bottom: 10px">';
				echo html_entity_decode( $postadv );
				echo '</div>';

			} else {
				// echo '<p>Latency date not crossed.</p>';
			}

		} else {

			// else show directly
			echo '<div class="postadv-wrapper" style="text-align:center;margin-bottom: 10px">';
			echo html_entity_decode( $postadv );
			echo '</div>';

		}
    }

	/**
	 * Sanitizes the script values
	 * can be extended for other inputs in future
     *
     * @param string scripts added from the settings page
     * @return string sanitized script
     *
     * @since 1.0.0
	 */
	public function postadv_sanitize_script( $string ) {

		$allowed_html = array(
			"ins" => array(
				"class"	=> array(),
				"style"	=> array(),
				"data-ad-client" => array(),
				"data-ad-slot" => array(),
				"data-ad-format" => array()
			),
			"script" => array(
				"async" => array(),
				"src" => array(),
				"type" => array(),
				"data-id" => array(),
				"data-format"=> array()
			)
		); 
		return htmlentities( wp_kses( trim( $string ), $allowed_html ) );
		// return htmlentities( wp_kses( stripslashes( trim( $string ) ), $allowed_html ) );
	}
}