 <?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @package OceanWP WordPress theme
 */

get_header(); ?>

	<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr blog-archive">

		<div class="left-column">

			<div class="post-content">

				<?php 
				
				if(have_posts()):

					custom_post_types_get_custom_template();

				endif; 

				?>

			</div>

		</div>

		<div class="right-column">
			<img src="<?php echo get_template_directory_uri() ?>/assets/img/bg-sidebar-blog.png" alt="" />
		</div>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>
