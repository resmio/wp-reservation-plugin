<?php	
add_action( 'admin_enqueue_scripts', 'resmio_btn_wdgt_plugin_color_picker' );
function resmio_btn_wdgt_plugin_color_picker( $hook_suffix ) {
    // first check that $hook_suffix is appropriate for your admin page
    wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker' );
}

$resmioID = get_option('resmio_id');
?>

<div class="wrap resmio-btn-wdgt-plugin">
	<script language="JavaScript">
		jQuery(document).ready(function() {
			// COLOR PICKER
			var myOptions = {
			    // you can declare a default color here, or in the data-default-color attribute on the input
			    defaultColor: false,
			    // a callback to fire whenever the color changes to a valid color
			    change: function(event, ui){},
			    // a callback to fire when the input is emptied or an invalid color
			    clear: function() {},
			    // hide the color picker controls on load
			    hide: true,
			    // show a group of common colors beneath the square or, supply an array of colors to customize further
			    palettes: true
			};
			jQuery('.resmio-color-field').wpColorPicker(myOptions);
			
			// ON/OFF SWITCH
			jQuery(".cb-enable").click(function(){
		        var parent = jQuery(this).parents('.switch');
		        jQuery('.cb-disable',parent).removeClass('selected');
		        jQuery(this).addClass('selected');
		        jQuery('.checkbox',parent).attr('checked', true);
		        jQuery('.resmio-settings-extended-wrapper').removeClass('hidden');
		    });
		    jQuery(".cb-disable").click(function(){
		        var parent = jQuery(this).parents('.switch');
		        jQuery('.cb-enable',parent).removeClass('selected');
		        jQuery(this).addClass('selected');
		        jQuery('.checkbox',parent).attr('checked', false);
		         jQuery('.resmio-settings-extended-wrapper').addClass('hidden');
		    });
		});
	</script>
	
	<div class="resmio-main-header">
	    <a class="resmio-logo" href="https://www.resmio.de/" target="_blank"><img src="<?php echo WP_PLUGIN_URL ?>/resmio-button-and-widget/img/resmio-logo.png" /></a>
	    <h2 class="resmio-main-header-h"><?php _e('resmio button and widget','resmio_btn_wdgt_i18n') ?></h2>
    </div>
    
    <?php
    if ($resmioID == '') {
    	echo '<div class="error fade">';
    	echo '<p><strong>'.  __('Please type in your resmio ID and save the settings.', 'resmio_btn_wdgt_i18n') . '</strong></p>';
		echo '<p><strong>' . __('No resmio ID yet? Sign up ','resmio_btn_wdgt_i18n') . '<a href="https://app.resmio.com/signup?plan=2014-11-free&recurrence=monthly&referer=online_wpplugin" target="_blank">' . __('here','resmio_btn_wdgt_i18n') . '</a>' . __(' for free!','resmio_btn_wdgt_i18n') . '</strong></p>';
		echo '</div>';
    }
	?>
    
    <form method="post" action="options.php"> 
        <?php 
	        @settings_fields('resmio_btn_wdgt_plugin_group');
	        @do_settings_fields('resmio_btn_wdgt_plugin_group');
			$extendedSettings = get_option('resmio_extended');
			if (isset($_GET['settings-updated'])) {
				$resmioBtnBg = get_option('resmio_btn_bg');
				$resmioBtnBGl = adjustColorLightenDarken($resmioBtnBg, -10);
				$resmioBtnBGd = adjustColorLightenDarken($resmioBtnBg, 10);
				update_option( 'resmio_btn_bg_light', $resmioBtnBGl );
				update_option( 'resmio_btn_bg_dark', $resmioBtnBGd );
			}
        ?>
		
		<div class="resmio-settings">
			<div class="resmio-settings-section">
				<div class="resmio-settings-head">
					<h3><?php _e('resmio ID*','resmio_btn_wdgt_i18n') ?></h3>
					<p><?php _e('Type in your resmio ID','resmio_btn_wdgt_i18n') ?></p>
				</div>
				<div class="resmio-settings-content">
			        <table class="form-table">  
			            <tr valign="center">
			                <th scope="row"><label for="resmio-id"><?php _e('resmio ID*','resmio_btn_wdgt_i18n') ?></label></th>
			                <td><input type="text" name="resmio_id" id="resmio-id" value="<?php echo get_option('resmio_id'); ?>" /></td>
			            </tr>
			        </table>
		        </div>
	        </div>
	        <hr>
	        
	        <div class="resmio-settings-section">
		        <div class="resmio-settings-sub-section">
			        <div class="resmio-settings-head">
						<h3><?php _e('Advanced settings','resmio_btn_wdgt_i18n') ?></h3>
						<p><?php _e('Activate if you want to change button and or widget colors etc.','resmio_btn_wdgt_i18n') ?></p>
					</div>
			        <div class="resmio-settings-content">
						<p class="field switch">
							<?php
							$extendedClass = "";
						    if ($extendedSettings == 1){
						    	$extendedClass = "";
						    	$html = '<input type="radio" id="radio1" name="resmio_extended" value="1"' . checked( 1, $extendedSettings, false ) . '/>';
								$html .= '&nbsp;';
								$html .= '<label for="radio1" class="cb-enable selected"><span>On</span></label>';
								$html .= '&nbsp;';
								$html .= '<input type="radio" id="radio2" name="resmio_extended" value="2"' . checked( 2, $extendedSettings, false ) . '/>';
								$html .= '&nbsp;';
								$html .= '<label for="radio2" class="cb-disable"><span>Off</span></label>';
								echo $html;
						    }
							else {
								$extendedClass = "hidden";
								$html = '<input type="radio" id="radio1" name="resmio_extended" value="1"' . checked( 1, $extendedSettings, false ) . '/>';
								$html .= '&nbsp;';
								$html .= '<label for="radio1" class="cb-enable"><span>On</span></label>';
								$html .= '&nbsp;';
								$html .= '<input type="radio" id="radio2" name="resmio_extended" value="2"' . checked( 2, $extendedSettings, false ) . '/>';
								$html .= '&nbsp;';
								$html .= '<label for="radio2" class="cb-disable selected"><span>Off</span></label>';
								echo $html;	
							}
						    ?>
						</p>
					</div>
				</div>
		        <div class="resmio-settings-extended-wrapper <?php echo $extendedClass; ?>">
					<div class="resmio-settings-sub-section">
			        	<div class="resmio-settings-head">
							<h3><?php _e('resmio button','resmio_btn_wdgt_i18n') ?></h3>
							<p><?php _e('Edit the resmio button color properties.','resmio_btn_wdgt_i18n') ?></p>
						</div>
						<div class="resmio-settings-content">
							<table class="form-table">  
					            <tr valign="center">
					                <th scope="row"><label for="resmio-btn-text"><?php _e('Button font color','resmio_btn_wdgt_i18n') ?></label></th>
					                <td><input id="resmio-btn-text" type="text" class="resmio-color-field" data-default-color="#ffffff" name="resmio_btn_text" value="<?php echo get_option('resmio_btn_text'); ?>" /></td>
					            </tr>
					            <tr valign="center">
					                <th scope="row"><label for="resmio-btn-text"><?php _e('Button background color','resmio_btn_wdgt_i18n') ?></label></th>
					                <td><input id="resmio-btn-bg" type="text" class="resmio-color-field" data-default-color="#000000" name="resmio_btn_bg" value="<?php echo get_option('resmio_btn_bg'); ?>" /></td>
					            </tr>
					        </table>	
						</div>
					</div>
					<div class="resmio-settings-sub-section">
						<div class="resmio-settings-head">
							<h3><?php _e('resmio widget','resmio_btn_wdgt_i18n') ?></h3>
							<p><?php _e('Edit the resmio widget color and width/height properties.','resmio_btn_wdgt_i18n') ?></p>
						</div>
						<div class="resmio-settings-content">
							<table class="form-table">  
					            <tr valign="center">
					                <th scope="row"><label for="resmio-wdgt-text"><?php _e('Widget font color','resmio_btn_wdgt_i18n') ?></label></th>
					                <td><input id="resmio-wdgt-text" type="text" class="resmio-color-field" data-default-color="#000000" name="resmio_wdgt_text" value="<?php echo get_option('resmio_wdgt_text'); ?>" /></td>
					            </tr>
					            <tr valign="center">
					                <th scope="row"><label for="resmio-wdgt-bg"><?php _e('Widget background color','resmio_btn_wdgt_i18n') ?></label></th>
					                <td><input id="resmio-wdgt-bg" type="text" class="resmio-color-field" data-default-color="#ffffff" name="resmio_wdgt_bg" value="<?php echo get_option('resmio_wdgt_bg'); ?>" /></td>
					            </tr>
					            <tr valign="center">
					                <th scope="row"><label for="resmio-wdgt-width"><?php _e('Widget width (in px)','resmio_btn_wdgt_i18n') ?></label><p>(150 - 1920)</p></th>
					                <td><input type="number" min="150" max="1920" step="1" name="resmio_wdgt_width" id="resmio-wdgt-width" value="<?php echo get_option('resmio_wdgt_width'); ?>" /><p>(default: 275)</p></td>
					            </tr>
					            <tr valign="center">
					                <th scope="row"><label for="resmio-wdgt-height"><?php _e('Widget height (in px)','resmio_btn_wdgt_i18n') ?></label><p>(200 - 1200)</p></th>
					                <td><input type="number" min="200" max="1200" step="1" name="resmio_wdgt_height" id="resmio-wdgt-height" value="<?php echo get_option('resmio_wdgt_height'); ?>" /><p>(default: 400)</p></td>
					            </tr>
					        </table>	
						</div>
					</div>
		        </div>
	        </div>
	        
	        <hr>
	        <p><?php _e( '* = required', 'resmio_btn_wdgt_i18n' ); ?></p>
	        <p><strong><?php _e('No resmio ID yet? Sign up ','resmio_btn_wdgt_i18n') ?><a href="https://app.resmio.com/signup?plan=2014-11-free&recurrence=monthly&referer=online_wpplugin" target="_blank"><?php _e('here','resmio_btn_wdgt_i18n') ?></a> <?php _e(' for free!','resmio_btn_wdgt_i18n') ?></strong></p>
	        <?php submit_button(); ?>
	        <h2><?php _e( 'Short description', 'resmio_btn_wdgt_i18n' ); ?></h2>
	        <p><?php _e( 'After you have saved your resmio ID you can insert the resmio button or widget on your website through shortcodes.', 'resmio_btn_wdgt_i18n' ); ?></p>
	        <p><?php _e( 'There are two ways on a post or page to put these shortcodes inside the WordPress wysiwyg-editor (text editor):', 'resmio_btn_wdgt_i18n' ); ?></p>
	        <p><?php _e( '1) You can type in the shortcodes manually. Type in <b>[resmio-button]</b> for the resmio button and/or <b>[resmio-widget]</b> for the resmio widget.', 'resmio_btn_wdgt_i18n' ); ?></p>
	        <p><?php _e( '2) You insert them by clicking on the <i>resmio</i> button on the toolbar of the wysiwyg-editor (only in visual mode supported).', 'resmio_btn_wdgt_i18n' ); ?></p>
        </div>
    </form>
</div>