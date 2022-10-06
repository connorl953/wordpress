<?php 

get_header();

$attachment = wp_get_attachment_image_src(get_post_thumbnail_id($post -> ID),1200);

?>

<div class="sections">
	<div class="container">
		<div class="row">
			<div class="col-12 banner">
				<img src="<?php if($attachment[0]){ echo $attachment[0]; }else{ echo '/wp-content/uploads/2018/11/UMLbanner-1.png'; }; ?>" alt="" />
				<p>our  short and light weekly email with a few options for postsecondary plans.</p>
			</div>
			<div class="col-12"><div>
				<?php 

				$section1 = get_post_meta($post -> ID,'_custom_field_section_1',true);

				echo $section1;

				?>
			</div></div>
			<div class="col-12"><div>
				<?php 

				$section2 = get_post_meta($post -> ID,'_custom_field_section_2',true);

				echo $section2;

				?>
			</div></div>
			<div class="col-12"><div>
				<?php 

				$section3 = get_post_meta($post -> ID,'_custom_field_section_3',true);

				echo $section3;

				?>
			</div></div>
			<div class="col-12"><div>
				<?php 

				$section4 = get_post_meta($post -> ID,'_custom_field_section_4',true);

				echo $section4;

				?>
			</div></div>
			<div class="col-12">
				<a href="https://goo.gl/forms/JzujfdXCvRKecTWe2" class="share-btn">TREMENDOUSLY-EASY-TO-<br />SHARE-BUTTON</a>
			</div>
		</div>
	</div>
</div>

<?php 

get_footer();

?>