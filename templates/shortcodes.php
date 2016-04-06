<?php
// @settings_fields('resmio_btn_wdgt_plugin_group');
// @do_settings_fields('resmio_btn_wdgt_plugin_group');
$resmioID = get_option('resmio_id');
$resmioExtended = get_option('resmio_extended');
$resmioBtnText = get_option('resmio_btn_text');
$resmioBtnBG = get_option('resmio_btn_bg');
$resmioBtnBGl = get_option('resmio_btn_bg_light');
$resmioBtnBGd = get_option('resmio_btn_bg_dark');
$resmioWdgtText = get_option('resmio_wdgt_text');
$resmioWdgtBG = get_option('resmio_wdgt_bg');
$resmioWdgtWidth = get_option('resmio_wdgt_width');
$resmioWdgtHeight = get_option('resmio_wdgt_height');

$shortcode = "";
if ($resmioID == '') {
	$shortcode = __('No resmio ID saved!','resmio_btn_wdgt_i18n');
}
else {
	switch( $tag ) {
	    case "resmio-button":
			if (($resmioExtended == 1) && ($resmioBtnBG !='') && ($resmioBtnText !='')) {
				$shortcode = '
					<style type="text/css" media="all">
						.resmio-button .btn {
						  background-color: '.$resmioBtnBG.';
						  background-image: linear-gradient(top,'.$resmioBtnBGl.','.$resmioBtnBG.');
						  background-image: -webkit-linear-gradient(top,'.$resmioBtnBGl.','.$resmioBtnBG.');
						  background-image: -o-linear-gradient(top,'.$resmioBtnBGl.','.$resmioBtnBG.');
						  background-image: -moz-linear-gradient(top,'.$resmioBtnBGl.','.$resmioBtnBG.');
						  background-image: -ms-linear-gradient(top,'.$resmioBtnBGl.','.$resmioBtnBG.');
						  border-style: 1px solid '.$resmioBtnBGl.';
						  border-color: '.$resmioBtnBGl.';
						  color: '.$resmioBtnText.';
						}
						.resmio-button .btn:hover, .resmio-button .btn:focus {
						  background-color: '.$resmioBtnBGd.';
						  background-image: linear-gradient(top,'.$resmioBtnBG.','.$resmioBtnBGd.');
						  background-image: -webkit-linear-gradient(top,'.$resmioBtnBG.','.$resmioBtnBGd.');
						  background-image: -o-linear-gradient(top,'.$resmioBtnBG.','.$resmioBtnBGd.');
						  background-image: -moz-linear-gradient(top,'.$resmioBtnBG.','.$resmioBtnBGd.');
						  background-image: -ms-linear-gradient(top,'.$resmioBtnBG.','.$resmioBtnBGd.');
						  border-style: 1px solid '.$resmioBtnBG.';
						  border-color: '.$resmioBtnBG.';
						  color: '.$resmioBtnText.';
						}
					</style>
				';
			}
	        $shortcode .= '
	        	<script data-resmio-button="'.$resmioID.'">
				  (function(d, s) {
				    var js, rjs = d.getElementsByTagName(s)[0];
				    js = d.createElement(s);
				    js.src = "//static.resmio.com/static/de/button.js";
				    js.async = true;
				   rjs.parentNode.insertBefore(js, rjs); }(document, "script")
				  );
				</script>
	        ';
	        break;
	    case "resmio-widget":
			if (($resmioExtended == 1) && ($resmioWdgtWidth >= 150) && ($resmioWdgtHeight >= 200) && ($resmioWdgtBG != '') && ($resmioWdgtText !='')) {
				if ($resmioWdgtBG == '') { $resmioWdgtBG = '#ffffff'; }
				if ($resmioWdgtText == '') { $resmioWdgtText = '#000000'; }
				$shortcodeAdd = '&width='.$resmioWdgtWidth.'px&height='.$resmioWdgtHeight.'px&backgroundColor='.substr($resmioWdgtBG, 1).'&color='.substr($resmioWdgtText, 1);
			}
			else {
				 $shortcodeAdd = '&width=275px&height=400px';
			}
	        $shortcode = '
	        	<div id="resmio-'.$resmioID.'"></div>
				<script>(function(d, s) {
				    var js, rjs = d.getElementsByTagName(s)[0];
				    js = d.createElement(s);
				    js.src = "//static.resmio.com/static/de/widget.js#id='.$resmioID.$shortcodeAdd.'";
				    rjs.parentNode.insertBefore(js, rjs);
				}(document, "script"));
				</script>
	        ';
	        break;
	    default:
			$shortcode = __('Shortcode not supported!','resmio_btn_wdgt_i18n');
	        break;
	}
}
?>