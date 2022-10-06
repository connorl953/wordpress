<?php 

$validUpdateFields = ['_link','_subtitle','_hide_post','_listing_title','_listing_small_title'];

if($postData){
    foreach($validUpdateFields as $key => $value) {
        if(isset($postData[$value]) && $postData[$value]){
        	$insertValue = is_array($postData[$value]) ? json_encode($postData[$value]) : $postData[$value];
            update_post_meta($id,$value,$postData[$value]);
        }else{
            delete_post_meta($id,$value);
		}
    }
}

?>