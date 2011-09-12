<?php
define('WP_ADMIN', true);
require_once("../../../wp-load.php");

global $wpdb;
$oqey_header = $wpdb->prefix . "oqey_header";
$filespath = OQEY_ABSPATH.'wp-content/oqey_headers_images/'; //$_GET['loc'];


if(isset($_REQUEST['loc'])){
$arr = explode("--", base64_decode($_REQUEST['loc']) );
}
if(isset($_REQUEST['id'])){
$arr = explode("--", base64_decode($_REQUEST['id']) );	
}
if( isset($_REQUEST['loc']) || isset($_REQUEST['id'])){
$gal_id = $arr[0];
$auth_cookie = $arr[1];
$logged_in_cookie = $arr[2];
$nonce = $arr[3];
}
if ( is_ssl() && empty($_COOKIE[SECURE_AUTH_COOKIE]) && !empty($auth_cookie) )
	$_COOKIE[SECURE_AUTH_COOKIE] = $auth_cookie;
elseif ( empty($_COOKIE[AUTH_COOKIE]) && !empty($auth_cookie) )
	$_COOKIE[AUTH_COOKIE] = $auth_cookie;
if ( empty($_COOKIE[LOGGED_IN_COOKIE]) && !empty($logged_in_cookie) )
	$_COOKIE[LOGGED_IN_COOKIE] = $logged_in_cookie;

unset($current_user);
global $wpdb;
require_once(OQEY_ABSPATH . 'wp-admin/admin.php');

if ( !wp_verify_nonce($nonce, 'oqey-header-upload') ) die("Access denied. Security check failed! What are you trying to do? It`s not working like that. ");
if ( !is_user_logged_in() ) die('Login failure. You must be logged in.');

if($_FILES['Filedata']['size']>0){
    	if($_FILES["Filedata"]["size"]>0){
    		$path = pathinfo($_FILES["Filedata"]["name"]);
    		if(strtolower($path["extension"])=="jpg"){
    		$j = 0;
  			while(1){
				$name =rand_name().".jpg";
				$header_alt = $_FILES["Filedata"]["name"];
				$header_alt = preg_replace('/.jpg/i', '', $header_alt); 																
  				if(!file_exists($filespath . $name)) {
                    $fileloc = $filespath;
  					move_uploaded_file($_FILES["Filedata"]["tmp_name"],$fileloc.$name);
					$file = $fileloc.$name;
					$wpdb->query( $wpdb->prepare( "INSERT INTO $oqey_header (oqey_h_link, oqey_h_alt) VALUES ('%s', '%s')",
                                                                             $name, 
                                                                             $header_alt 
                                                                             ));		    
  					break;
  				}
  				$j++;
  			}
    	}
	}
}

function rand_name($length = 11, $chars = 'abcdefghijklmnopqrstuvwxyz1234567890')
{ 
    $chars_length = (strlen($chars) - 1);
    $string = $chars{rand(0, $chars_length)};   
    for ($i = 1; $i < $length; $i = strlen($string))    {
        $r = $chars{rand(0, $chars_length)};       
        if ($r != $string{$i - 1}) $string .=  $r;
		}   
    return $string;
}
?>