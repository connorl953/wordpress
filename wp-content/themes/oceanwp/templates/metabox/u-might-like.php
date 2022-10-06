<?php 

$hasCustomFields = strtotime('13th april 2020') > strtotime($post -> post_date) ? true : false;

if($hasCustomFields){ ?>
<div class="form-field">
	<div class="form-label">
		<label>Section 1</label>
	</div>
	<div class="form-input">
		<?php 

		$section1 = get_post_meta($post -> ID,'_custom_field_section_1',true);

		if(!$section1){
			$section1 = '<img class="alignnone size-full wp-image-628 aligncenter" src="/wp-content/uploads/2018/11/UMLEdOp.png" alt="" width="288" height="288" /><p style="text-align: center;">Education Programs Out There</p><hr /><p>Enter New Content Here...</p>';
		}

		wp_editor($section1,'_custom_field_section_1',array('media_buttons'=>true,'editor_height'=>250)); 

		?>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Section 2</label>
	</div>
	<div class="form-input">
		<?php 

		$section2 = get_post_meta($post -> ID,'_custom_field_section_2',true);

		if(!$section2){
			$section2 = '<img class="alignnone size-full wp-image-629 aligncenter" src="/wp-content/uploads/2018/11/UMLfinop.png" alt="" width="288" height="288" /><p style="text-align: center;">Ways to Finance Them</p><hr /><p>Enter New Content Here...</p>';
		}

		wp_editor($section2,'_custom_field_section_2',array('media_buttons'=>true,'editor_height'=>250)); 

		?>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Section 3</label>
	</div>
	<div class="form-input">
		<?php 

		$section3 = get_post_meta($post -> ID,'_custom_field_section_3',true);

		if(!$section3){
			$section3 = '<img class="alignnone size-full wp-image-630 aligncenter" src="/wp-content/uploads/2018/11/UMLStudop.png" alt="" width="288" height="288" /><p style="text-align: center;">Unheard of Opportunities</p><hr /><p>Enter New Content Here...</p>';
		}

		wp_editor($section3,'_custom_field_section_3',array('media_buttons'=>true,'editor_height'=>250)); 

		?>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Section 4</label>
	</div>
	<div class="form-input">
		<?php 

		$section4 = get_post_meta($post -> ID,'_custom_field_section_4',true);

		if(!$section4){
			$section4 = '<img class="alignnone size-full wp-image-631 aligncenter" src="/wp-content/uploads/2018/11/UMLsharing.png" alt="" width="288" height="288" /><p style="text-align: center;">Sharing: Don’t Drop the Ball!</p><hr /><p>Enter New Content Here...</p>';
		}

		wp_editor($section4,'_custom_field_section_4',array('media_buttons'=>true,'editor_height'=>250)); 

		?>
	</div>
</div>
<?php }else{ ?>
<div class="form-field">
	<div class="form-label">
		<label>File URL</label>
	</div>
	<div class="form-input">
		<input name="_pdf_file" type="text" value="<?php echo get_post_meta($post -> ID,'_pdf_file',true); ?>" />
	</div>
</div>
<?php } ?>