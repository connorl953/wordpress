<div class="form-field">
	<div class="form-label">
		<label>Bottom Content</label>
	</div>
	<div class="form-input">
		<?php 

		$bottomContent = get_post_meta($post -> ID,'_bottom_content',true);

		wp_editor($bottomContent,'_bottom_content',array('media_buttons'=>false,'editor_height'=>250)); 

		?>
	</div>
</div>