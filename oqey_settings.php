<?php
header("Cache-Control: no-cache");
include("../../../wp-config.php");
global $wpdb;

$oqey_image_url = get_option('siteurl') . '/wp-content/oqey_headers_images/';
$oqey_header = $wpdb->prefix . "oqey_header"; 

function oQeyHeaderPluginUrlS() {
	$url = get_option('siteurl') . '/wp-content/plugins/oqey-headers';   
	return $url;
} 
//.....................................................
if(isset($_GET['id'])){
$oqey_images = $wpdb->get_results(" SELECT *
                                      FROM $oqey_header
                                     WHERE oqey_h_exclude !=1								     
								     ");

$message = "Are you sure you want to delete this image???";
if(count($oqey_images)!=0){
echo '<ul id="oqeysortable" class="oqeysortable">';	 
foreach ($oqey_images as $oqey_image){
$output .= '<li id="img_header_id_'.$oqey_image->oqey_h_id.'">';
$output .= '<div style="position:relative; width:420px;"> ';
$output .= '<img src="'.$oqey_image_url.$oqey_image->oqey_h_link.'" alt="'.$oqey_image->oqey_h_alt.'" style="width:400px; max-width:400px; height:auto; border:#999999 thin solid;" />';
$output .='<a href="#edit"  onclick="EditeazaD(\''.$oqey_image->oqey_h_id.'\'); return false;">
           <img src="'.oQeyHeaderPluginUrlS().'/images/settings2.png" width="16" height="16" style="position:absolute; left: 402px; top: 3px;" title="Edit/Add description to this image" />
		   </a>';
$output .= '<a href="#null" onclick="if(confirm(\''.$message.'\')){ deleteImage(\''.$oqey_image->oqey_h_id.'\'); return false; }" title="Delete this image" >
			<img src="'.oQeyHeaderPluginUrlS().'/images/delete.png" width="16" height="16" style="position:absolute; left: 402px; top: 30px;" />
			</a>';
$output .='<div class="dblclick" style="display:none; min-height:50px; width:400px; max-width:400px; height:auto; border:#999999 thin solid;" id="d'.$oqey_image->oqey_h_id.'">'.$oqey_image->oqey_h_description.'</div>';
$output .= '</div></li>';
}
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
   if(unlink(ABSPATH."wp-content/oqey_headers_images/".$image_title) ){ echo "Deleted"; }else{ echo "error, please try again."; }
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

//edit description
if(isset($_GET['imgedit'])){ 
$id = str_replace("d", "", $_REQUEST['id']);
$update = sprintf("UPDATE $oqey_header
                        SET oqey_h_description = '%s'
					  WHERE oqey_h_id = '%d'
					", mysql_real_escape_string(stripslashes($_POST['value'])), 
					   $id
					);						
$update_d = mysql_query($update) or die (mysql_error());
if($update_d){ echo stripslashes($_POST['value']); }else{ echo "Error, try again please."; }
}
?>