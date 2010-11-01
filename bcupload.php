<?php
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
				$name =rand_name().".jpg";
				$header_alt = $_FILES["Filedata"]["name"];
				$header_alt = preg_replace('/.jpg/i', '', $header_alt); 																
  				if(!file_exists($filespath . $name)) {
                    $fileloc = $filespath;
  					move_uploaded_file($_FILES["Filedata"]["tmp_name"],$fileloc.$name);
					$file = $fileloc.$name;
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

function rand_name($length = 10, $chars = 'abcdefghijklmnopqrstuvwxyz1234567890')
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