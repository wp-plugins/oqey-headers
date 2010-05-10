<?php

    //if (!empty($_SERVER['SCRIPT_FILENAME']) && 'bcupload.php' == basename($_SERVER['SCRIPT_FILENAME']))
         // die ('Please do not load this page directly. Thanks!');
echo 'Upload result:<br>';

include("../../../wp-config.php");
global $wpdb;
$oqey_header = $wpdb->prefix . "oqey_header";

$filespath = $_GET['loc'];

if($_FILES['Filedata']['size']>0){
    	if($_FILES["Filedata"]["size"]>0){
    		$path = pathinfo($_FILES["Filedata"]["name"]);
    		if(strtolower($path["extension"])=="jpg"){
    		$j = 0;
  			while(1){
  				//$name = str_pad($j,4,"0",STR_PAD_LEFT) . ".jpg";
				$name =rand_str().".jpg";
				$header_alt = $_FILES["Filedata"]["name"];
				//$header_alt = eregi_replace(".jpg", "", $header_alt);
				$header_alt = preg_replace('/.jpg/i', '', $header_alt); 
																
  				if(!file_exists($filespath . $name)) {
                    $fileloc = $filespath;
  					move_uploaded_file($_FILES["Filedata"]["tmp_name"],$fileloc.$name);
					$file = $fileloc.$name;
                    //img_resize( $file, $filespaththumb, $name);
					$wpdb->query("INSERT INTO $oqey_header (oqey_h_link, oqey_h_alt) 
                                       VALUES ('$name', '$header_alt')");
				    
					
  					break;
  				}
  				$j++;
  			}
    	}
	}
}

echo 'File uploaded';
echo "</pre>";

// Generate a random character string
function rand_str($length = 10, $chars = 'abcdefghijklmnopqrstuvwxyz1234567890')
{    // Length of character list
    $chars_length = (strlen($chars) - 1);
    // Start our string
    $string = $chars{rand(0, $chars_length)};   
    // Generate random string
    for ($i = 1; $i < $length; $i = strlen($string))    {
        // Grab a random character from our list
        $r = $chars{rand(0, $chars_length)};       
        // Make sure the same two characters don't appear next to each other
        if ($r != $string{$i - 1}) $string .=  $r;
		}   
    // Return the string
	//$string = md5($string);
	
    return $string;
}
?>