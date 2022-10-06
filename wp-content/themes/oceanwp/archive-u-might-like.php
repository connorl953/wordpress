<?php 

get_header();

$startYear = 2018;
$currentYear = date('Y');

?>
<div class="archive-u-might-like">
	<div class="container">
		<div class="row">
			<div class="col banner">
				<img src="/wp-content/uploads/2018/11/UMLbanner-1.png" alt="" />
				<p>a short and light every-so-often email reminder with a few notes for postsecondary plans.</p>
			</div>
			<div class="col years">
				<?php for($x=$currentYear;$x>=$startYear;$x--){ 
					$posts = get_posts(array('post_type'=>'u-might-like','posts_per_page'=>-1,'date_query' => array(array('year'=>$x),),));

					if(count($posts) > 0){ ?>
				<div class="year">
					<input id="year-<?php echo $x ?>" name="year[]" type="checkbox" value="<?php echo $x ?>" />
					<label for="year-<?php echo $x ?>"></label>
					<ul>
						<?php foreach($posts as $key => $postData){ 
							if($x >= 2020){
								$url = get_post_meta($postData -> ID,'_pdf_file',true);
							}else{
								$url = get_permalink($postData -> ID);
							}

							if($url){
						?>
						<li><a href="<?php echo $url; ?>" target="_BLANK"><?php echo $postData -> post_title ?></a></li>
						<?php }; }; ?>
					</ul>
				</div>
				<?php }; }; ?>
				<!--h1>Archive</h1>
				<ul>
					<?php foreach($posts as $key => $postData){ 
						if($key !== 0){
					?>
					<li><a href="<?php echo get_permalink($postData -> ID); ?>">U Might Like - <?php echo $postData -> post_title ?></a></li>
					<?php
						}
					} ?>
				</ul-->
			</div>
		</div>
	</div>
</div>

<?php 

get_footer();

?>