<?php 

$terms = get_terms(array('taxonomy'=>'team-type','orderby'=>'term_id','order'=>'ASC'));

if(count($terms) > 0){ ?>
<div class="team-list">
<?php 
	$count = 1;

	foreach($terms as $key => $term){ 
		$team = get_posts(array('post_type'=>'team','posts_per_page'=>-1,'order'=>'DESC','orderby'=>'date','tax_query' => array(array('taxonomy'=>'team-type','field'=>'term_id','terms'=>$term -> term_id))));
		$totalTeam = count($team) + 1;
	?>
	<div class="term-list">
		<div class="team-category icon-<?php echo $count; ?>">
			<div class="team-category-label">
				<p><?php echo $term -> name; ?></p>
			</div>
		</div>
<?php 
		$count ++;

		if($count > 4){
			$count = 0;
		}

		foreach($team as $member){
			$memberImg = wp_get_attachment_image_src(get_post_thumbnail_id($member -> ID),'full');
			
			echo '<div class="team-member">';

			if($memberImg){
				$terms = wp_get_post_terms($member -> ID,'universities');
				
				if(count($terms)){
					echo '<div class="universities" data-count="'.count($terms).'">';

					foreach($terms as $term){
						$categoryImage = get_term_meta($term -> term_id,'badge',true);

						if($categoryImage){
							echo '<img src="'.$categoryImage.'" alt="" />';
						}
					}

					echo '</div>';
				}

				$title = get_post_meta($member -> ID,'_title',true);
				$quote = get_post_meta($member -> ID,'_quote',true);
				
				echo $quote ? '<div class="team-img" style="background:url(\''.$memberImg[0].'\') no-repeat center center/cover;"><p>'.$quote.'</p><b>'.$title.'</b></div>' : '<div class="team-img" style="background:url(\''.$memberImg[0].'\') no-repeat center center/cover;"><b>'.$title.'</b></div>';
			}else{
				$title = get_post_meta($member -> ID,'_title',true);

				echo '<div class="team-img"><b>'.$title.'</b></div>';
			}

			$location = get_post_meta($member -> ID,'_location',true);
			$description = get_post_meta($member -> ID,'_description',true);

			echo '<div class="team-content"><strong>'.$member -> post_title.'</strong><span>'.$location.'</span><p>'.$description.'</p></div></div>';
		}

		if($totalTeam % 4 !== 0){
			echo '<div class="team-member-empty"><img src="'.get_template_directory_uri().'/assets/img/to-be-continued.png" alt="" /></div>';
		}
	}; ?>
	</div>
<?php }; ?>
</div>