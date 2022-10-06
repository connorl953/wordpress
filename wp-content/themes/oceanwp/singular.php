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

					while(have_posts()):
    					the_post(); 

    					$author = get_post_meta($post -> ID,'_author',true);
    				?>

    			<div class="post">
    				<span><?php the_date('F d'); ?></span>
    				<h1><?php the_title(); ?></h1>
    				<?php if($author){ ?><small>By <?php echo $author ?></small><?php } ?>
    				<?php the_content(); ?>
    			</div>

    				<?php
					endwhile;

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
