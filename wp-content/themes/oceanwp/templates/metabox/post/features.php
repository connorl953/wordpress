<?php 

$validUpdateFields = ['_features_link'];

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