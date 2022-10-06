<div class="admin-container">
<h1>Featured Content</h1>
</div>
<div class="admin-container">
	<form method="post" action="options.php"> 
		<div class="form-field">
			<div class="form-label">
				<label>Education Programs</label>
			</div>
			<div class="form-input">
				<?php 

				$featuredContent1 = get_option('_featured_content_1');
				$posts = get_posts(array('post_type'=>'programs','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC'));

				?>
				<select name="_featured_content_1">
					<option value="">- Select -</option>
					<?php foreach($posts as $key => $post){ ?>
					<option value="<?php echo $post -> ID; ?>" <?php if($post -> ID == $featuredContent1){ ?>selected<?php } ?>><?php echo $post -> post_title; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-field">
			<div class="form-label">
				<label>Funding Options</label>
			</div>
			<div class="form-input">
				<?php 

				$featuredContent2 = get_option('_featured_content_2');
				$posts = get_posts(array('post_type'=>'funding','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC'));

				?>
				<select name="_featured_content_2">
					<option value="">- Select -</option>
					<?php foreach($posts as $key => $post){ ?>
					<option value="<?php echo $post -> ID; ?>" <?php if($post -> ID == $featuredContent2){ ?>selected<?php } ?>><?php echo $post -> post_title; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-field">
			<div class="form-label">
				<label>Student Opportunities</label>
			</div>
			<div class="form-input">
				<?php 

				$featuredContent3 = get_option('_featured_content_3');
				$posts = get_posts(array('post_type'=>'opportunities','posts_per_page'=>-1,'orderby'=>'title','order'=>'ASC'));

				?>
				<select name="_featured_content_3">
					<option value="">- Select -</option>
					<?php foreach($posts as $key => $post){ ?>
					<option value="<?php echo $post -> ID; ?>" <?php if($post -> ID == $featuredContent3){ ?>selected<?php } ?>><?php echo $post -> post_title; ?></option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="form-field" style="display:none">
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
		<div class="form-field" style="display:none">
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
		<div class="form-field" style="display:none">
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
