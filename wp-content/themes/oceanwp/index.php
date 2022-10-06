<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package OceanWP WordPress theme
 */

get_header(); 

$categories = get_categories();

?>

	<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr blog-archive">

		<div class="left-column">

			<div class="categories">
				<ul>
					<li><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>">All</a></li>
					<?php foreach($categories as $category){ ?>
					<li><a href="<?php echo get_category_link($category); ?>"><?php echo $category -> name; ?></a></li>
					<?php } ?>
				</ul>
			</div>

			<div class="posts">

				<?php 
				
				if(have_posts()):

					while(have_posts()):
    					the_post(); 

    					$author = get_post_meta($post -> ID,'_author',true);
    			?>

    			<div class="post">
    				<span><?php the_date('F d'); ?></span>
    				<strong><?php the_title(); ?></strong>
    				<?php if($author){ ?><small>By <?php echo $author ?></small><?php } ?>
    				<?php the_excerpt(); ?>
    				<a href="<?php the_permalink(); ?>">Read More</a>
    			</div>

    				<?php
					endwhile;

				endif; 

				?>

			</div>

		</div>

		<div class="right-column">
			<div class="blog-sidebar">
				<img src="<?php echo get_template_directory_uri() ?>/assets/img/bg-sidebar-blog.png" alt="" /></div>
			<div class="blog-pagination">
				<a href="#" class="btn"></a>
				<?php 

				the_posts_pagination(array(
					'mid_size'  => 2,
					'prev_text' => null,
					'next_text' => null,
				));

				?>
			</div>
		</div>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>