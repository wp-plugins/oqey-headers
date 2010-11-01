<?php
global $wpdb;

function oQeyAllImages(){// get all images, array
global $wpdb;
$oqey_header = $wpdb->prefix . "oqey_header"; 

//get all header images from db
$images = $wpdb->get_results(" SELECT *
                                 FROM $oqey_header
                                WHERE oqey_h_exclude !=1
							 ORDER BY oqey_h_order ASC	
							 ");

return $images;
}

function oQeyRandomImage($sli, $fli){// get random image
global $wpdb;

$site_url = get_option('siteurl');
$oqey_header = $wpdb->prefix . "oqey_header"; 

//get random header image from db
$r_image = $wpdb->get_results(" SELECT *
                                  FROM $oqey_header
                                 WHERE oqey_h_exclude !=1
						      ORDER BY Rand() LIMIT 1
								     ");
					  
foreach ($r_image as $image){

list($width, $height, $type, $attr) = getimagesize(ABSPATH."/wp-content/oqey_headers_images/".$image->oqey_h_link);
$output .= $sli.'<img src="'.$site_url.'/wp-content/oqey_headers_images/'.$image->oqey_h_link.'" alt="'.$image->oqey_h_alt.' by wp-gallery-plugin.com" '.$attr.' />'.$fli;

}

echo $output;
}

function oQeyFlashImages(){// get flash header
//get the flash header
echo '
<div id="logo">
<script type="text/javascript">
	var flashvars = {};
	var params = {wMode:"transparent"};
	var attributes = {id: "logo"};
	swfobject.embedSWF("'.get_option('siteurl').'/wp-content/plugins/oqey-headers/oqeyheader.swf", "logo", "900", "300", "8.0.0", "", flashvars, params, attributes);
</script>
</div>';

}

?>