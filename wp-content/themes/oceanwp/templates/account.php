<?php 

/* Template Name: Account */

$currentUser = wp_get_current_user();

if($currentUser -> ID){

	get_header();

	global $wpdb;

	$attachment = wp_get_attachment_image_src(get_post_thumbnail_id($post -> ID),1200);
	$currentUser = wp_get_current_user();
	$roles = isset($currentUser -> roles) ? $currentUser -> roles : [];

	//user data
	$firstName = get_user_meta($currentUser -> ID,'first_name',true);
	$lastName = get_user_meta($currentUser -> ID,'last_name',true);
	$educationLevel = get_user_meta($currentUser -> ID,'education_level',true);
	$gender = get_user_meta($currentUser -> ID,'gender',true);
	$otherGender = get_user_meta($currentUser -> ID,'other_gender',true);
	$emailAddress = $currentUser -> user_email;
?>

<div class="sections">
	<div class="container">
		<div class="row">
			<div class="col-12 banner">
				<img src="<?php echo $attachment[0]; ?>" alt="" style="width:100%" />
			</div>
			<?php if(isset($currentUser -> ID)){ 
				$country = get_user_meta($currentUser -> ID,'_user_country',true);
			?>
			<div class="section-copy">
				<p>Please enter your profile information below</p>
			</div>
			<div id="profile" class="section">
				<div class="section-title">
					<strong>My Profile</strong>
				</div>
				<div class="section-content">
					<form action="<?php echo admin_url('admin-post.php'); ?>" method="POST" onsubmit="return submitForm(this)" novalidate>
						<fieldset class="half">
							<span>First Name</span>
							<input name="first_name" type="text" value="<?php echo $firstName; ?>" required />
						</fieldset>
						<fieldset class="half right">
							<span>Last Name</span>
							<input name="last_name" type="text" value="<?php echo $lastName; ?>" required />
						</fieldset>
						<fieldset>
							<span>Address</span>
							<input type="text" name="address" value="<?php echo get_user_meta($currentUser -> ID,'_user_address',true); ?>" />
						</fieldset>
						<fieldset class="three">
							<span>City</span>
							<input type="text" name="city" value="<?php echo get_user_meta($currentUser -> ID,'_user_city',true); ?>" />
						</fieldset>
						<fieldset class="three small">
							<span>State/Province</span>
							<input type="text" name="region" value="<?php echo get_user_meta($currentUser -> ID,'_user_region',true); ?>" />
						</fieldset>
						<fieldset class="three">
							<span>Country</span>
							<select name="country"><option name="CA">Canada</option><option value="USA" <?php if($country === 'USA'){ echo 'selected'; } ?>>United States</option></select>
						</fieldset>
						<fieldset>
							<span style="margin-bottom:10px;">Education Level</span>
							<div>
								<input id="grade-7" type="radio" name="education_level" value="Grade 7" <?php if($educationLevel == 'Grade 7'){ ?>checked<?php } ?> />
								<label for="grade-7">Grade 7</label>
							</div>
							<div>
								<input id="grade-8" type="radio" name="education_level" value="Grade 8" <?php if($educationLevel == 'Grade 8'){ ?>checked<?php } ?> />
								<label for="grade-8">Grade 8</label>
							</div>
							<div>
								<input id="grade-9" type="radio" name="education_level" value="Grade 9" <?php if($educationLevel == 'Grade 9'){ ?>checked<?php } ?> />
								<label for="grade-9">Grade 9</label>
							</div>
							<div>
								<input id="grade-10" type="radio" name="education_level" value="Grade 10" <?php if($educationLevel == 'Grade 10'){ ?>checked<?php } ?> />
								<label for="grade-10">Grade 10</label>
							</div>
							<div>
								<input id="grade-11" type="radio" name="education_level" value="Grade 11" <?php if($educationLevel == 'Grade 11'){ ?>checked<?php } ?> />
								<label for="grade-11">Grade 11</label>
							</div>
							<div>
								<input id="grade-12" type="radio" name="education_level" value="Grade 12" <?php if($educationLevel == 'Grade 12'){ ?>checked<?php } ?> />
								<label for="grade-12">Grade 12</label>
							</div>
							<div>
								<input id="post-secondary" type="radio" name="education_level" value="Post secondary or equivalent" <?php if($educationLevel == 'Post secondary or equivalent'){ ?>checked<?php } ?> />
								<label for="post-secondary">Post secondary or equivalent</label>
							</div>
						</fieldset>
						<fieldset>
							<span style="margin-bottom:10px;">Gender</span>
							<div>
								<input id="female" type="radio" name="gender" value="Female" <?php if($gender == 'Female'){ ?>checked<?php } ?> />
								<label for="female">Female</label>
							</div>
							<div>
								<input id="male" type="radio" name="gender" value="Male" <?php if($gender == 'Male'){ ?>checked<?php } ?> />
								<label for="male">Male</label>
							</div>
							<div>
								<input id="non-binary" type="radio" name="gender" value="Non-Binary" <?php if($gender == 'Non-Binary'){ ?>checked<?php } ?> />
								<label for="non-binary">Non-Binary</label>
							</div>
							<div>
								<input id="other" type="radio" name="gender" value="Other" <?php if($gender == 'Other'){ ?>checked<?php } ?> />
								<label for="other">Other</label>
								<input type="text" name="other_gender" value="<?php echo $otherGender ?>" />
							</div>
						</fieldset>
						<fieldset>
							<span>Phone</span>
							<input type="text" name="phone" value="<?php echo get_user_meta($currentUser -> ID,'_user_phone',true); ?>" />
						</fieldset>
						<fieldset>
							<span>Email Address</span>
							<input type="text" name="email" value="<?php echo $emailAddress; ?>" readonly />
						</fieldset>
						<fieldset>
							<input name="action" type="hidden" value="update_profile" />
							<button>Update</button>
						</fieldset>
					</form>				
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php 

$favouritesDB = $wpdb->get_results('SELECT post FROM '.$wpdb->prefix.'favourites WHERE user='.$currentUser -> data -> ID,ARRAY_A);
// create favourites array
$favourites = [];
if(!empty($favouritesDB)){
	foreach($favouritesDB as $key => $favourite){
		if(isset($favourite['post'])){
			array_push($favourites,$favourite['post']);
		}
	}
}
// create posts array
$posts = [];
if(!empty($favourites)) {
	$postsQuery = new WP_Query(array( 'post_type'=> array('programs','opportunities','funding'),'post__in'=> $favourites));
	$posts = $postsQuery -> posts;
}
// create results array
$results = ['programs'=>['label'=>'Education Programs','posts'=>[]],'funding'=>['label'=>'Funding Options','posts'=>[]],'opportunities'=>['label'=>'Student Opportunities','posts'=>[]]];
if(!empty($posts)){
	foreach($posts as $key => $singlePost){
		$postType = $singlePost -> post_type;
		if(isset($results[$postType])){
			array_push($results[$postType]['posts'],$singlePost);
		}
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
				<h1 style="margin:0">My Favourites</h1>
			</div>
			<?php foreach($results as $key => $value){ ?>
			<div class="result <?php echo $key; ?>">
				<div class="heading">
					<span><?php echo $value['label']; ?></span>
					<b>Click <a href="<?php echo get_post_type_archive_link($key) ?>">Here</a> To Explore <?php echo $value['label']; ?></b>
				</div>
				<?php
					$posts = $value['posts'];
					$columns = [[],[],[],[]];
					$count = 0;

					if(!empty($posts)){
						foreach($posts as $index => $singlePost){ 
							array_push($columns[$count],$singlePost);						
							$count++;
							if($count > 3){
								$count = 0;
							}
						}
					}					
				
					if(!empty($columns)){
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
						<?php } ?>
					</div>
					<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<?php 

	get_footer();

}else{
	wp_redirect('/login');
}

?>