<?php
// oQey Headers
// Copyright (c) 2011 oqeysites.com
// This is an plugin for WordPress
// http://wordpress.org/
//
/*  Copyright 2011 www.oqeysites.com  (email : dorin@oqeysites.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Plugin Name: oQey Headers
Plugin URI: http://oqeysites.com
Version: 0.4
Description: oQey Headers plugin, the header manager for your blog, custom flash header.
Author: oqeysites
Author URI:  http://oqeysites.com
*/
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'oqey_headers.php' == basename($_SERVER['SCRIPT_FILENAME']))
	   die ('Please do not load this page directly. Thanks!');

   wp_enqueue_script('swfobject'); 
   wp_enqueue_script('jquery');
   wp_enqueue_script('jqueryeditable', WP_PLUGIN_URL . '/oqey-headers/js/jquery.jeditable.js', array('jquery'));
   wp_enqueue_script('jquery-ui-core ');
   wp_enqueue_script('jquery-ui-sortable');  
   wp_enqueue_script('jquery-ui-draggable '); 
   wp_register_style('oQey-header-css', WP_PLUGIN_URL . '/oqey-headers/css/header.css');
   wp_enqueue_style('oQey-header-css');

    global $qgal_db_version;
    $oqey_header_db_version = "0.1";
	   
   function oqey_headers_install(){   
   global $wpdb;   
   $oqey_header = $wpdb->prefix . "oqey_header"; 
   $dd_dir_up = ABSPATH."/wp-content/oqey_headers_images";
   wp_mkdir_p ($dd_dir_up);
   
        $sqlqheader = "CREATE TABLE " . $oqey_header . " (
		oqey_h_id int NOT NULL AUTO_INCREMENT,
		oqey_h_link varchar(255) NOT NULL DEFAULT '',
		oqey_h_alt varchar(255) NOT NULL DEFAULT '',
		oqey_h_order int(11) NOT NULL DEFAULT '0',
		oqey_h_description varchar(255) NOT NULL DEFAULT '',
            oqey_h_status varchar(25) NOT NULL DEFAULT '',
		oqey_h_exclude int(11) NOT NULL DEFAULT '0',
		PRIMARY KEY  (oqey_h_id)
	);";
	
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sqlqheader);
	
	// Upgrade table code
   $installed_oqey_header_db_version = get_option( "oqey_header_db_version" );
   if( $installed_oqey_header_db_version != $oqey_header_db_version ) {

        $sqlqheader = "CREATE TABLE " . $oqey_header . " (
		oqey_h_id int NOT NULL AUTO_INCREMENT,
		oqey_h_link varchar(255) NOT NULL DEFAULT '',
		oqey_h_alt varchar(255) NOT NULL DEFAULT '',
		oqey_h_order int(11) NOT NULL DEFAULT '0',
		oqey_h_description varchar(255) NOT NULL DEFAULT '',
            oqey_h_status varchar(25) NOT NULL DEFAULT '',
		oqey_h_exclude int(11) NOT NULL DEFAULT '0',
		PRIMARY KEY  (oqey_h_id)
	);";
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
    update_option( "qgal_db_version", $qgal_db_version );
  }		
}//end activation   

if (function_exists('register_activation_hook')) { register_activation_hook( __FILE__, 'oqey_headers_install' ); }   
function oQeyHeadersPluginUrl() {
	$url = get_option('siteurl') . '/wp-content/plugins/oqey-headers';   
	return $url;
} 

// Hook for adding admin menus
add_action('admin_menu', 'oQey_header_add_pages');
// action function for above hook
function oQey_header_add_pages() {
    add_menu_page('oQey Headers', 'oQey Headers', 8, __FILE__, 'oqey_first_page');
	add_submenu_page(__FILE__,'oQey Headers', 'Manage', 8, 'Manage_headers',  'init_Manage_header');
}
function oqey_first_page() {
	echo '<div class="wrap">
        	<h2>oQey Headers plugin</h2>
          </div>
		  <div class="wrap">
		  oQey Headers plugin is a Wordpress Plugin that allows easy to add and manage images for blog header.<br/>
To insert image  in blog header use this line of code, this function get random image on refresh:<br/>

<p>&lt;?php if (function_exists(&quot;oQeyRandomImage&quot;)) { oQeyRandomImage(&quot;&quot;, &quot;&quot;); } ?&gt;</p>
<p>Ex:</p>
<p>&lt;ul&gt;</p>
<p>oQeyRandomImage(&quot;&lt;li&gt;&quot;, &quot;&lt;/li&gt;&quot;);</p>
<p>&lt;/ul&gt;</p>
<p>you can use this to display</p>
<p>&lt;ul&gt;</p>
<p>&lt;li&gt;&lt;img src=&quot;example.jpg&quot; width=&quot;x&quot; height=&quot;y&quot; alt=&quot;text&quot;  /&gt; &lt;/li&gt;</p>
<p>&lt;/ul&gt;</p>
<p>or you can get all images and process how you whant:</p>
<p>&lt;?php if (function_exists(&quot;oQeyAllImages&quot;)) { oQeyAllImages(); } ?&gt;</p>

<p>If you want to add flash header, use this code</p>
<p>&lt;?php if (function_exists(&quot;oQeyFlashImages&quot;)) { oQeyFlashImages(); } ?&gt;</p>
</div>';?>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><strong>Please Donate, one, two, three dollars or more to help the plugin development.</strong></p><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
"><input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"></form><?php }
function init_Manage_header(){
$dd_dir_up = ABSPATH."wp-content/oqey_headers_images/";

?>
<div class="wrap"><h2>Upload your images</h2></div>

<div id="flashcontent" style="height:70px; width:600px; min-height:70px;">
	  <div align="center">
		  <p class="style4">&nbsp;</p>
		  <p class="style4"><strong>This site requires Flash Player 8 or later.</strong></p>
		  <p><img src="<?php echo oQeyHeadersPluginUrl(); ?>/images/flashplayer.jpg" alt="" width="60" height="60" /></p>
	    <p><a href="http://www.macromedia.com/go/getflashplayer" target="_blank" class="style4">GET FLASH PLAYER</a></p>
  </div>
</div>

<script type="text/javascript">
	var flashvars = {BatchUploadPath:"<?php echo $dd_dir_up; ?>"};
	var params = {bgcolor:"#FFFFFF", allowFullScreen:"false", wMode:"transparent"};
	var attributes = {id: "flash"};
	swfobject.embedSWF("<?php echo oQeyHeadersPluginUrl(); ?>/bupload.swf", "flashcontent", "600", "70", "8.0.0", "", flashvars, params, attributes);
	/*flash Uploader Copyright - Victor Placinta vitorian@gmail.com; for commercial use please contact him via email*/
</script>

<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="126"><input type="submit" name="click" id="click" value="save order" onclick="saveOrder(); return false;" class="button-primary"/></td>
    <td width="474"><div id="message" style=" font-weight:bold; color:#E06D05;"></div></td>
  </tr>
</table>
<div style="border-bottom:#999999 thin solid; padding:5px; width:600px;"><em>Note: drag and drop to order images; Doubleclick to add/edit description.</em></div>
<div id="images" style="padding:5px; width:600px;"></div>
<script type="text/javascript">
function uprefresh(){
jQuery.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?id=awsqjksa77",
  cache: false,
  success: function(html){
    jQuery("#images").html(html);
	jQuery(function() { jQuery("#oqeysortable").sortable(); });
	jQuery("#sort_cats").disableSelection();  
    jQuery(".dblclick").editable("<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?imgedit=yes", { 
      indicator : "Updating...",
      type      : "textarea",
	  tooltip   : "Doubleclick to edit...",
 	  event     : "dblclick",
      submit    : "OK",
      cancel    : "Cancel",
 	  style  : "inherit"
  });	
  }
});
}
function GetImages(){
jQuery.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?id=awsqjksa77",
  cache: false,
  success: function(html){
    jQuery("#images").html(html);
	jQuery(function() { jQuery("#oqeysortable").sortable();     
    jQuery("#sort_cats").disableSelection();  
    jQuery(".dblclick").editable("<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?imgedit=yes", { 
      indicator : "Updating...",
      type      : "textarea",
	  tooltip   : "Doubleclick to edit...",
 	  event     : "dblclick",
      submit    : "OK",
      cancel    : "Cancel",
 	  style  : "inherit"
  });	
});
}
});
}
window.onload = GetImages;
function deleteImage(id){
jQuery('#img_header_id_'+id).hide(1000);
jQuery.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?delete_id="+id,
  cache: false,
  success: function(html){
  jQuery("#message").html(html);
  setTimeout("clearDiv()",5000);
  }
});
}
function saveOrder(){
	var d = jQuery('#oqeysortable').sortable('serialize');	
	jQuery.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?"+d,
  cache: false,
  success: function(html){
   jQuery("#message").html(html);
   setTimeout("clearDiv()",5000);
  }
});
}
function clearDiv(){
var Display = document.getElementById('message');
	Display.innerHTML = "&nbsp;";
}
function EditeazaD(id){
jQuery('#d'+id).slideToggle("fast");
}
</script>
<?php } include("oqey_functions.php"); ?>