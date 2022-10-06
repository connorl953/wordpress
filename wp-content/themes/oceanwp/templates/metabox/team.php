<div class="form-field">
	<div class="form-label">
		<label>Title</label>
	</div>
	<div class="form-input">
		<input name="_title" type="text" value="<?php echo get_post_meta($post -> ID,'_title',true); ?>" />
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Location</label>
	</div>
	<div class="form-input">
		<input name="_location" type="text" value="<?php echo get_post_meta($post -> ID,'_location',true); ?>" />
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Description</label>
	</div>
	<div class="form-input">
		<textarea name="_description"><?php echo get_post_meta($post -> ID,'_description',true); ?></textarea>
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Quote</label>
	</div>
	<div class="form-input">
		<textarea name="_quote"><?php echo get_post_meta($post -> ID,'_quote',true); ?></textarea>
	</div>
</div>