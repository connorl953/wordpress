 <?php

get_header(); 

global $wpdb,$wp;

$requestUrl = $wp -> request;

$link = get_post_meta($post -> ID,'_link',true);
$subtitle = get_post_meta($post -> ID,'_subtitle',true); 
$currentUser = wp_get_current_user();
$validUser = isset($currentUser -> data -> ID) ? true : false;
$validUser = isset($currentUser -> data -> ID) ? true : false;
$isFavourite = $validUser ? $wpdb -> get_results('SELECT * FROM '.$wpdb->prefix.'favourites WHERE user='.$currentUser -> data -> ID.' AND post='.$post -> ID.' LIMIT 1', OBJECT) : [];

?>

<script type="text/javascript">
var actionUrl = '<?php echo esc_url(admin_url('admin-post.php')) ?>';
</script>

<div class="arm-details">
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="title <?php if($subtitle){ ?>has-subtitle<?php } ?>">
					<h1><?php if($link){ ?><a href="<?php echo $link ?>" target="_BLANK"><?php } ?><?php the_title(); ?><?php if($link){ ?></a><?php } ?></h1>
					<?php if($subtitle){ ?><p><?php echo $subtitle ?></p><?php } ?>
				</div>
				<div class="add-btn">
					<a	href="#"
 							data-favourite="<?php echo $isFavourite ? 1: 0; ?>"
							data-id="<?php echo $post -> ID; ?>"
							data-user="<?php echo $validUser ? 1: 0; ?>"
							class="<?php echo $isFavourite ? 'disabled' : '' ?>">
						<?php if($isFavourite){ ?>
							<i class="fa fa-check"></i> Added To Favourites
						<?php }else{ ?>
							<i class="fa fa-plus"></i> to Favourites
						<?php } ?>
					</a>
				</div>
				<?php 

				if(RESTRICT_PROGRAMS && !$currentUser || RESTRICT_PROGRAMS && !$currentUser -> ID){ ?>
				<div class="content">
					<p>FREE ACCESS and USE of ALL DATABASES. We just ask that you please sign in (Google or Facebook or with your email and password) or <a href="/signup"><u>create an account</u></a>.</p>
					<?php echo do_shortcode('[login-form redirect="'.home_url($requestUrl).'"]'); ?>
				</div>
				<?php 
				}else{

				?>
				<div class="content">
					<?php echo apply_filters('the_content',$post -> post_content); ?>
				</div>
				<div class="icon" style="background:none">
					<img src="/wp-content/uploads/skills-icon-home.png" alt="" />
				</div>
				<div class="back-btn">
					<a href="../"><i class="fa fa-caret-left"></i> Back</a>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<?php 

get_footer(); 

?>
