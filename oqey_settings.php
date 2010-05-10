<?php
header("Cache-Control: no-cache");
include("../../../wp-config.php");
global $wpdb;

$oqey_image_url = get_option('siteurl') . '/wp-content/oqey_headers_images/';
$oqey_header = $wpdb->prefix . "oqey_header"; 

function oQeyHeaderPluginUrlS() {
	$url = get_option('siteurl') . '/wp-content/plugins/oqey_headers';   
	return $url;
} 
//.....................................................

if(isset($_GET['id'])){
//get all header images from db
$oqey_images = $wpdb->get_results(" SELECT *
                                      FROM $oqey_header
                                     WHERE oqey_h_exclude !=1								     
								     ");
									 
			// get them random ORDER BY Rand() LIMIT 1						 
//$output ='<div id="qqheader" align="center"><em>';

if(count($oqey_images)!=0){
echo '<ul id="oqeysortable" class="oqeysortable">';		  

foreach ($oqey_images as $oqey_image){
$output .= '<li id="img_header_id_'.$oqey_image->oqey_h_id.'">';

$output .= '<img src="'.$oqey_image_url.$oqey_image->oqey_h_link.'" alt="'.$oqey_image->oqey_h_alt.'" style="width:300px; max-width:300px; height:auto; border:#999999 thin solid;" />';
$output .= '<a href="#null" onclick="deleteImage(\''.$oqey_image->oqey_h_id.'\'); return false;" title="Delete this image" >
	        <img src="'.oQeyHeaderPluginUrlS().'/images/delete.png" alt="delete" class="b_img"/></a>';
$output .= '</li>';
}

//$output .='</ul></em></div>';

echo $output;

echo '</ul>';

}else{

echo "No images. Please upload one.";
}

}

//delete image

if( isset($_GET['delete_id']) ){
        
		$get_title_id = $wpdb->get_row("SELECT *
                                          FROM $oqey_header
							             WHERE oqey_h_id ='".mysql_real_escape_string($_GET['delete_id'])."'  ");
		$image_title = $get_title_id->oqey_h_link;
	
	    $delete_img = $wpdb->query("DELETE FROM $oqey_header
								          WHERE oqey_h_id = '".mysql_real_escape_string($_GET['delete_id'])."'
						           ");
		
   if(unlink(ABSPATH."wp-content/oqey_headers_images/".$image_title) ){
   echo "Deleted";
   }else{
   echo "error, please try again.";
   }
}


//update order for sneak peek images
if(isset($_GET['img_header_id'])){//order images

foreach ($_GET['img_header_id'] as $position => $item){

$h_update = sprintf("UPDATE $oqey_header
                           SET oqey_h_order = '%d'
						 WHERE oqey_h_id = '%s'
					   ", $position, 
						  $item
						);						
$update_h = mysql_query($h_update) or die (mysql_error());

}//end foreach

echo "Updated";

}
?>