<?php 

$validUpdateFields = ['_custom_field_section_1','_custom_field_section_2','_custom_field_section_3','_custom_field_section_4','_custom_field_section_summary_1','_custom_field_section_summary_2','_custom_field_section_summary_3','_pdf_file'];

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