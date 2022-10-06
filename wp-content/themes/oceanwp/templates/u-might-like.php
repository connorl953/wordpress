<?php 

/* Template Name: U Might Like */

get_header();

$attachment = wp_get_attachment_image_src(get_post_thumbnail_id($post -> ID),1200);

$posts = get_posts(array('post_type'=>'u-might-like','posts_per_page'=>1,'orderby'=>'ID','order'=>'DESC'));
$post = isset($posts[0]) ? $posts[0] : null;

?>

<div class="sections">
	<div class="container">
		<div class="row">
			<div class="col-12 banner">
				<img src="<?php echo $attachment[0]; ?>" alt="" />
				<p>Our short and light every-so-often email with a few options for postsecondary plans.</p>
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