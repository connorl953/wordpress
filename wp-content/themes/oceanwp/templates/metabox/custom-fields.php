<div class="form-field">
	<div class="form-label">
		<label>Link</label>
	</div>
	<div class="form-input">
		<input name="_link" type="text" value="<?php echo get_post_meta($post -> ID,'_link',true); ?>">
	</div>
</div>
<div class="form-field">
	<div class="form-label">
		<label>Subtitle</label>
	</div>
	<div class="form-input">
		<input name="_subtitle" type="text" value="<?php echo get_post_meta($post -> ID,'_subtitle',true); ?>">
	</div>
</div>
<?php if($post -> post_type !== 'programs'){ ?>
<div class="form-field">
	<div class="form-label">
		<label>Listing Small Title</label>
	</div>
	<div class="form-input">
		<input name="_listing_small_title" type="text" value="<?php echo get_post_meta($post -> ID,'_listing_small_title',true); ?>">
	</div>
</div>
<?php } ?>
<div class="form-field">
	<div class="form-label">
		<label>Listing Title</label>
	</div>
	<div class="form-input">
		<input name="_listing_title" type="text" value="<?php echo get_post_meta($post -> ID,'_listing_title',true); ?>">
	</div>
</div>
<?php 

$hidden = get_post_meta($post -> ID,'_hide_post',true);

?>
<div class="form-field">
	<div class="form-label">
		<label>Hidden</label>
	</div>
	<div class="form-input">
		<input name="_hide_post" type="checkbox" value="1" <?php if($hidden == 1){ echo 'checked'; }; ?>>
	</div>
</div>
