<div class="form-field">
	<div class="form-label">
		<label>Program Link</label>
	</div>
	<div class="form-input">
		<input name="_link" type="text" value="<?php echo get_post_meta($post -> ID,'_link',true); ?>">
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Institution</label>
	</div>
	<div class="form-input">
		<input name="_institution" type="text" value="<?php echo get_post_meta($post -> ID,'_institution',true); ?>">
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Program Length</label>
	</div>
	<div class="form-input">
		<input name="_program_length" type="text" value="<?php echo get_post_meta($post -> ID,'_program_length',true); ?>">
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Location</label>
	</div>
	<div class="form-input">
		<textarea name="_location"><?php echo get_post_meta($post -> ID,'_location',true); ?></textarea>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Admissions req:</label>
	</div>
	<div class="form-input">
		<?php 

		$admissionsReq = get_post_meta($post -> ID,'_admissions_req',true);

		wp_editor($admissionsReq,'_admissions_req',array('media_buttons'=>false,'editor_height'=>250)); 

		?>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Highlight</label>
	</div>
	<div class="form-input">
		<?php 

		$highlight = get_post_meta($post -> ID,'_highlight',true);

		wp_editor($highlight,'_highlight',array('media_buttons'=>false,'editor_height'=>250)); 

		?>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Cost</label>
	</div>
	<div class="form-input">
		<?php 

		$cost = get_post_meta($post -> ID,'_cost',true);

		wp_editor($cost,'_cost',array('media_buttons'=>false,'editor_height'=>250)); 

		?>
	</div>
</div>