<?php
include ("../../../wp-load.php");
global $wpdb;
header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);
$oqey_header = $wpdb->prefix . "oqey_header"; 
$rutaimages = get_option('siteurl').'/wp-content/oqey_headers_images/';

$r .= '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>';
$r .= '<oQeyFlashHeader imgPath="'.$rutaimages.'">'; 

$all_image = $wpdb->get_results(" SELECT * FROM $oqey_header WHERE oqey_h_exclude !=1 ");
 						      
foreach($all_image as $img) { 
$r .= '<image path="'.$img->oqey_h_link.'" />';
}
$r .= '</oQeyFlashHeader>';
echo $r;
?>