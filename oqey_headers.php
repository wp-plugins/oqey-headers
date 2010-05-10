<?php
// oQey Headers
// Copyright (c) 2010 www.qusites.com
// This is an plugin for WordPress
// http://wordpress.org/
//
/*  Copyright 2010  qusites.com  (email : dariimd@gmail.com)

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
Version: 0.1
Description: oQey Headers plugin, the header manager for your blog.
Author: Dorin D. | www.qusites.com
Author URI: http://www.qusites.com
*/

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'oqey_headers.php' == basename($_SERVER['SCRIPT_FILENAME']))
	   die ('Please do not load this page directly. Thanks!');
	
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
	$url = get_option('siteurl') . '/wp-content/plugins/oqey_headers';   
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


</div>
		  ';
}

function init_Manage_header(){
$dd_dir_up = ABSPATH."wp-content/oqey_headers_images/";
?>
<script type="text/javascript" src="<?php echo oQeyHeadersPluginUrl(); ?>/js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo oQeyHeadersPluginUrl(); ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?php echo oQeyHeadersPluginUrl(); ?>/js/jquery-ui.js"></script> 


<div class="wrap">
        	<h2>Upload your images</h2>
</div>

<div id="flashcontent">
	  <div align="center">
		  <p class="style4">&nbsp;</p>
		  <p class="style4"><strong>This site requires Flash Player 8 or later.</strong></p>
		  <p><img src="<?php echo oQeyHeadersPluginUrl(); ?>/images/flashplayer.jpg" alt="" width="60" height="60" /></p>
	    <p><a href="http://www.macromedia.com/go/getflashplayer" target="_blank" class="style4">GET FLASH PLAYER</a></p>
  </div>
</div>
	
<script type="text/javascript">
		// <![CDATA[
		
		var so = new SWFObject("<?php echo oQeyHeadersPluginUrl(); ?>/bupload.swf", "sotester", "600", "70", "8", "#FFFFFF");
		so.addParam("scale", "noScale");
		so.addParam("FlashVars", "BatchUploadPath=<?php echo $dd_dir_up; ?>");
		so.write("flashcontent");
		
		// ]]>
</script>

<table width="600" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="126"><input type="submit" name="click" id="click" value="save order" onclick="saveOrder(); return false;" class="button-primary"/></td>
    <td width="474"><div id="message"></div></td>
  </tr>
</table>


<div style="border-bottom:#999999 thin solid; padding:5px; width:600px;"><em>Note: drag and drop to order images</em></div>
<div id="images" style="padding:5px; width:600px;"></div>

<script type="text/javascript">
function uprefresh(){
//alert("merge");
$.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?id=awsqjksa77",
  cache: false,
  success: function(html){
    $("#images").html(html);
	$(function() { $("#oqeysortable").sortable(); });
  }
});
}

function GetImages(){
//alert("merge");
$.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?id=awsqjksa77",
  cache: false,
  success: function(html){
    $("#images").html(html);
	$(function() { $("#oqeysortable").sortable(); });
  }
});

}
window.onload = GetImages;

function deleteImage(id){
$('#img_header_id_'+id).hide(1000);

$.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?delete_id="+id,
  cache: false,
  success: function(html){
  $("#message").html(html);
  setTimeout("clearDiv()",5000);
  }
});

}

function saveOrder(){
	var d = $('#oqeysortable').sortable('serialize');	
	$.ajax({
  url: "<?php echo oQeyHeadersPluginUrl(); ?>/oqey_settings.php?"+d,
  cache: false,
  success: function(html){
   $("#message").html(html);
   setTimeout("clearDiv()",5000);
  }
});

}

function clearDiv(){
var Display = document.getElementById('message');
	Display.innerHTML = "&nbsp;";
}
</script>
<?php } //manage header 

include("oqey_functions.php");
?>