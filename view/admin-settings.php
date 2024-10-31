<?php
	if( $_POST ) {

		// bail early if nonce is not verified
		if( ! wp_verify_nonce( $_POST['postadv_adminset_nonce'], 'postadv_adminset' ) ) {

			die( 'No script kidding please !' );

		} else {

			// if verified - validate, sanitize and save/update option

			if( !empty( $_POST[ 'postadv_ip_script' ] ) ) {
				$postadv_val_script 	= Postadv::postadv_sanitize_script( $_POST[ 'postadv_ip_script' ] );
			} else {
				$postadv_val_script 	= '';
			}

			if ( isset( $_POST[ 'postadv_ip_hidein' ] ) ) {
				$postadv_val_hidein = (string) $_POST[ 'postadv_ip_hidein' ];
            } else {
				$postadv_val_hidein = 'nohide';
            }
			
			if( isset( $_POST['postadv_ip_latency'] ) ) {

				$postadv_val_latency 	 = 'on';
				$postadv_val_latency_day = absint( $_POST[ 'postadv_ip_latency_day' ] );
				if( $postadv_val_latency_day ) {
					$postadv_val_latency_day = ( $postadv_val_latency_day > 0 && $postadv_val_latency_day <= 99 ) ? $postadv_val_latency_day : 1 ;
				}

			} else {
				$postadv_val_latency 	 = 'off';
				$postadv_val_latency_day = 1;
			}

			if( isset( $_POST['postadv_ip_mcu'] ) ) {
				$postadv_val_mcu 		= 'on';
			} else {
				$postadv_val_mcu 		= 'off';
			}

			update_option( 'postadv_opt_script', $postadv_val_script );
			update_option( 'postadv_opt_hidein', $postadv_val_hidein );
			update_option( 'postadv_opt_latency', $postadv_val_latency );
			update_option( 'postadv_opt_latency_day', $postadv_val_latency_day );
			update_option( 'postadv_opt_mcu', $postadv_val_mcu );
			echo '<div class="notice notice-success is-dismissible"><p>Postadv settings saved.</p></div>';
		}
	}
?>

<div class="wrap">
	<h1><?php _e( 'Postadv Settings', 'postadv' ); ?></h1>
	<form name="" method="post" action="">
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label> AdSense script</label>
					</th>
					<td>
						<?php $postadv_script = get_option( 'postadv_opt_script' ); ?>
						<textarea name="postadv_ip_script" cols="80" rows="10"><?php echo $postadv_script; ?></textarea>
					</td>
				</tr>
                <tr>
                    <th scope="row">
                        <label> Hide In</label>
                    </th>
                    <td>
						<?php
                            $postadv_hidein = get_option( 'postadv_opt_hidein' );
                            $hidein_checked_no = ''; $hidein_checked_desktop = ''; $hidein_checked_mobile = '';
                            if( $postadv_hidein && $postadv_hidein != "" ) {
                                $hidein_checked_no = ( $postadv_hidein === 'nohide' ) ? 'checked' : '';
                                $hidein_checked_desktop = ( $postadv_hidein === 'desktop' ) ? 'checked' : '';
                                $hidein_checked_mobile = ( $postadv_hidein === 'mobile' ) ? 'checked' : '';
                            }
						?>
                        <input type="radio" name="postadv_ip_hidein" value="nohide" <?php echo $hidein_checked_no; ?>> Do not hide
                        <input type="radio" name="postadv_ip_hidein" value="desktop" <?php echo $hidein_checked_desktop; ?>> Hide in Desktop
                        <input type="radio" name="postadv_ip_hidein" value="mobile" <?php echo $hidein_checked_mobile; ?>> Hide in Mobile
                    </td>
                </tr>
				<tr>
					<th scope="row">
						<label> Enable latency</label>
					</th>
					<td>
						<?php
							$postadv_latency = get_option( 'postadv_opt_latency' );
							$checked = ( "on" == $postadv_latency ) ? 'checked' : '';
						?>
						<input type="checkbox" name="postadv_ip_latency" onchange="postadv_toggle_day(this);" <?php echo $checked; ?>> Enable this checkbox to use latency of adv in posts.
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label id="latency_day"> Enter days in number</label>
					</th>
					<td>
						<?php $postadv_latency_day = absint( get_option( 'postadv_opt_latency_day' ) ); ?>
						<input type="number" name="postadv_ip_latency_day" id="postadv_ip_latency_day" <?php echo ( "on" == $postadv_latency ) ? '' : 'disabled'; ?> value="<?php echo $postadv_latency_day; ?>" min="1" max="99"> <i>( default is 1, likely to be 1 to 99 )</i>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<label> Disable Entire Shortcodes(MCU)</label>
					</th>
					<td>
						<?php
							$postadv_mcu = get_option( 'postadv_opt_mcu' );
							$checked = ( "on" == $postadv_mcu ) ? 'checked' : '';
						?>
						<input type="checkbox" name="postadv_ip_mcu" <?php echo $checked; ?>> Imp! Check only if you want to disable the shortcode otherwise leave unchecked.<br>
						Ticking this will save your time to disable the shortcode rather than going into each post and removing the shortcode manually.
					</td>
				</tr>
			</tbody>
		</table>
		<?php wp_nonce_field( 'postadv_adminset', 'postadv_adminset_nonce' ); ?>
		<?php submit_button( 'Save Changes', 'primary', 'postadv_ip_submit' ); ?>
	</form>
	<script type="text/javascript">
		function postadv_toggle_day( ele ) {
			
			if( ele.checked ) {
				document.getElementById( 'postadv_ip_latency_day' ).disabled = false;
				document.getElementById( 'latency_day' ).style.color = '#000';
			} else {
				document.getElementById( 'postadv_ip_latency_day' ).disabled = true;
				document.getElementById( 'latency_day' ).style.color = '#ccc';
			}
		}
	</script>
</div>