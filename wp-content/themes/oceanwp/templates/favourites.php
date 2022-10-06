<?php 

/* Template Name: Favourites */

get_header();

global $wpdb;

$currentUser = wp_get_current_user();
$favouritesDB = $wpdb -> get_results('SELECT post FROM '.$wpdb->prefix.'favourites WHERE user='.$currentUser -> data -> ID,ARRAY_A);
$favourites = [];

if($favouritesDB){
	foreach($favouritesDB as $key => $favourite){
		if(isset($favourite['post'])){
			array_push($favourites,$favourite['post']);
		}
	}
}

$favourites = (array) $favourites;
$args = array('post_type'=>array('programs','opportunities','funding'),'post__in'=>$favourites);
$postsQuery = new WP_Query($args);
$posts = $postsQuery -> posts;

//results
$results = ['programs'=>['label'=>'Education Programs','posts'=>[]],'funding'=>['label'=>'Funding Options','posts'=>[]],'opportunities'=>['label'=>'Student Opportunities','posts'=>[]]];

foreach($posts as $key => $singlePost){
	$postType = $singlePost -> post_type;

	if(isset($results[$postType])){
		array_push($results[$postType]['posts'],$singlePost);
	}
}

?>

<script type="text/javascript">
var actionUrl = '<?php echo esc_url(admin_url('admin-post.php')) ?>';
var themeUrl = '<?php echo get_template_directory_uri(); ?>';
</script>

<div class="archive-listing">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1>My Favourites</h1>
			</div>
			<?php foreach($results as $key => $value){ ?>
			<div class="result <?php echo $key; ?>">
				<div class="heading">
					<span><?php echo $value['label']; ?></span>
				</div>
				<?php 

				$posts = $value['posts'];
				$columns = [[],[],[],[]];
				$count = 0;

				foreach($posts as $index => $singlePost){ 
					array_push($columns[$count],$singlePost);
					
					$count++;

					if($count > 3){
						$count = 0;
					}
				}

				foreach($columns as $index => $programs){ ?>
				<div class="column <?php if($index % 2 !== 0 && $index !== 0){ ?>padding<?php echo ' '.$index; } ?>">
					<?php foreach($programs as $program){ ?>
					<div class="bubble" data-id="<?php echo $program -> ID; ?>">
						<div>
							<strong><?php echo get_post_meta($program -> ID,'_listing_title',true) ?></strong>
							<a href="<?php echo get_permalink($program -> ID); ?>" target="_BLANK"></a>
							<i class="fa fa-times" onclick="deleteFavourite(<?php echo $program -> ID; ?>)"></i>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php 
				}

				?>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php 

get_footer();

?>