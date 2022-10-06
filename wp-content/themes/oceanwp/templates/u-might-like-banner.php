<div class="admin-container">
<h1>Banner Content</h1>
</div>
<div class="admin-container">
	<form method="post" action="options.php"> 
		<div class="form-field">
			<div class="form-label">
				<label>Banner Content 1</label>
			</div>
			<div class="form-input">
				<?php 

				$bannerContent1 = get_option('_banner_content_1');

				wp_editor($bannerContent1,'_banner_content_1',array('media_buttons'=>false,'editor_height'=>250)); 

				?>
			</div>
		</div>
		<div class="form-field">
			<div class="form-label">
				<label>Banner Content 2</label>
			</div>
			<div class="form-input">
				<?php 

				$bannerContent2 = get_option('_banner_content_2');

				wp_editor($bannerContent2,'_banner_content_2',array('media_buttons'=>false,'editor_height'=>250)); 

				?>
			</div>
		</div>
		<div class="form-field">
			<div class="form-label">
				<label>Banner Content 3</label>
			</div>
			<div class="form-input">
				<?php 

				$bannerContent3 = get_option('_banner_content_3');

				wp_editor($bannerContent3,'_banner_content_3',array('media_buttons'=>false,'editor_height'=>250)); 

				?>
			</div>
		</div>
	    <?php settings_fields('custom-options-settings');?>
    	<?php do_settings_sections('custom-options-settings');?>
	    <?php submit_button(); ?>
	</form>
</div>
