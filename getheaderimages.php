<?php
include ("../../../wp-config.php");
global $wpdb;

/*
<?xml version="1.0" encoding="UTF-8"?>
<oQeyFlashHeader imgPath="headerimg/">
	<image path="0000.jpg" />
	<image path="0001.jpg" />
	<image path="0002.jpg" />
	<image path="0003.jpg" />
	<image path="0004.jpg" />
	<image path="0005.jpg" />
	<image path="0006.jpg" />
	<image path="0007.jpg" />
</oQeyFlashHeader>
*/

header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);

$oqey_header = $wpdb->prefix . "oqey_header"; 
$rutaimages = get_option('siteurl').'/wp-content/oqey_headers_images/';

$dax .= '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
$dax .= '<oQeyFlashHeader imgPath="'.$rutaimages.'">'; 

$all_image = $wpdb->get_results(" SELECT *
                                  FROM $oqey_header
                                 WHERE oqey_h_exclude !=1
 						      ");

foreach($all_image as $img) { 
$dax .= '<image path="'.$img->oqey_h_link.'" />';
}

$dax .= '</oQeyFlashHeader>';

echo $dax;

?>