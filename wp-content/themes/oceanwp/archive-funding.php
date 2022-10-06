<?php 

get_header();

$currentUser = wp_get_current_user();

if(RESTRICT_PROGRAMS && !$currentUser || RESTRICT_PROGRAMS && !$currentUser -> ID){
	get_template_part('partials/custom-login');
}else{

$schoolEligibility = get_terms('school-eligibility');
$financialEligibility = get_terms('financial-eligibility');
$demographics = get_terms('demographics');

//layout category
$studentTypes = get_terms('student-types');

//params
$schoolEligibilityParams = isset($_GET['school']) ? explode(',',$_GET['school']) : [];
$financialEligibilityParams = isset($_GET['financial']) ? explode(',',$_GET['financial']) : [];
$demographicsParams = isset($_GET['demographic']) ? explode(',',$_GET['demographic']) : [];

//get programs
$args = array('post_type'=>'funding','posts_per_page'=>-1,'order'=>'ASC','orderby'=>'meta_value','meta_key'=>'_listing_title','meta_query' => array(array('key' => '_hide_post','compare' => 'NOT EXISTS')));


if($schoolEligibilityParams || $financialEligibilityParams || $demographicsParams){
	$args['tax_query'] = array(
		'relation' => 'AND',
	);
}

if($schoolEligibilityParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'school-eligibility',
		'field'    => 'term_id',
		'terms'    => $schoolEligibilityParams,
	));
}

if($financialEligibilityParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'financial-eligibility',
		'field'    => 'term_id',
		'terms'    => $financialEligibilityParams,
	));
}

if($demographicsParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'demographics',
		'field'    => 'term_id',
		'terms'    => $demographicsParams,
	));
}

$programs = get_posts($args);
$typesList = [];

foreach($programs as $key => $value) {
	$listingTitle = get_post_meta($value -> ID,'_listing_title',true);
	$postTerms = wp_get_post_terms($value -> ID,'student-types');
	$postStudentTypes = [];
	
	foreach($postTerms as $key => $postTerm){
		array_push($postStudentTypes,$postTerm -> term_id);
	}

	if($listingTitle){
		$value -> listing_title = $listingTitle;
	}

	$listingSmallTitle = get_post_meta($value -> ID,'_listing_small_title',true);
	
	if($listingSmallTitle){
		$value -> listing_small_title = $listingSmallTitle;
	}

	$value -> student_types = $postStudentTypes;

	foreach($studentTypes as $key => $studentType){
		if(!$studentType -> posts){
			$studentType -> posts = [];
		}

		if(in_array($studentType -> term_id,$value -> student_types)){
			array_push($studentType -> posts,$value);
		}
	}

	$type = wp_get_post_terms($value -> ID,'resource_type');

	if($type){
		$primaryType = $type[0];

		if(!array_key_exists($primaryType -> term_id,$typesList)){
			$primaryType -> icon = get_term_meta($primaryType->term_id,'taxonomy_icon',true);

			$value -> icon_type = $primaryType -> icon;

			$typesList[$primaryType -> term_id] = $primaryType;
		}

		$value -> icon_type = array_key_exists($primaryType -> term_id,$typesList) ? $typesList[$primaryType -> term_id] -> icon : null;
	}
}

$schoolEligibilitySelection = '';
$financialEligibilitySelection = '';
$demographicsSelection = '';

?>

<div class="archive-listing">
	<div class="container">
		<div class="row">
			<div class="col banner">
				<img src="<?php echo get_template_directory_uri().'/assets/img/funding-programs.jpg'; ?>" alt="Financial options for students" />
				<strong>Let’s get acquainted with some funding terminology <a href="../definition/"></a></strong>
			</div>
			<div class="col browse">
				<strong>Browse By Your Eligibility</strong>
				<ul>
					<?php foreach($studentTypes as $key => $studentType){
						$label = get_term_meta($studentType->term_id,'_taxonomy_label',true);
						
						if($label){

					?><li><a href="#<?php echo $studentType -> slug ?>"><?php echo $label ?></a></li><?php
						}
					} ?>
				</ul>
			</div>
			<div class="col filters">
				<strong>Filters</strong>
				<ul>
					<li>School Eligibility
						<ul>
						<?php foreach($schoolEligibility as $key => $school){ 
							if(!$schoolEligibilitySelection){
								$schoolEligibilitySelection = in_array($school -> term_id,$schoolEligibilityParams) ? $school -> name : '';
							}else{
								$schoolEligibilitySelection .= in_array($school -> term_id,$schoolEligibilityParams) ? ','.$school -> name : '';
							}
							
						?><li><input id="school-<?php echo $key ?>" name="school" type="checkbox" value="<?php echo $school -> term_id; ?>" <?php if(in_array($school -> term_id,$schoolEligibilityParams)){ ?>checked<?php } ?>> <label for="school-<?php echo $key ?>"><?php echo $school -> name; ?></label></li><?php } ?>
						</ul>
					</li>
					<li>Financial Eligibility
						<ul>
						<?php foreach($financialEligibility as $key => $financial){ 
							if(!$financialEligibilitySelection){
								$financialEligibilitySelection = in_array($financial -> term_id,$financialEligibilityParams) ? $financial -> name : '';
							}else{
								$financialEligibilitySelection .= in_array($financial -> term_id,$financialEligibilityParams) ? ','.$financial -> name : '';
							}
						?><li><input id="financial-<?php echo $key ?>" name="financial" type="checkbox" value="<?php echo $financial -> term_id; ?>" <?php if(in_array($financial -> term_id,$financialEligibilityParams)){ ?>checked<?php } ?>> <label for="financial-<?php echo $key ?>"><?php echo $financial -> name; ?></label></li><?php } ?>
						</ul>
					</li>
					<li>Demographics
						<ul class="large">
						<?php foreach($demographics as $key => $demographic){ 
							if(!$demographicsSelection){
								$demographicsSelection = in_array($demographic -> term_id,$demographicsParams) ? $demographic -> name : '';
							}else{
								$demographicsSelection .= in_array($demographic -> term_id,$demographicsParams) ? ','.$demographic -> name : '';
							}
						?><li><input id="demographic-<?php echo $key ?>" name="demographic" type="checkbox" value="<?php echo $demographic -> term_id; ?>" <?php if(in_array($demographic -> term_id,$demographicsParams)){ ?>checked<?php } ?>> <label for="demographic-<?php echo $key ?>"><?php echo $demographic -> name; ?></label></li><?php } ?>
						</ul>
					</li>
				</ul>
				<p><?php if($schoolEligibilitySelection){ ?><span>School Eligibility:</span> <?php echo $schoolEligibilitySelection; ?><br /><?php } ?><?php if($financialEligibilitySelection){ ?><span>Financial Eligibility:</span> <?php echo $financialEligibilitySelection; ?><br /><?php } ?><?php if($demographicsSelection){ ?><span>Demographics:</span> <?php echo $demographicsSelection; ?><?php } ?></p>
			</div>
			<?php if(count($typesList) > 0){ ?>
			<div class="icon-types">
				<ul>
				<?php foreach($typesList as $type){ if($type -> icon){ ?>
					<li><img src="<?php echo $type -> icon; ?>" alt="" /> <span><span style="color:#94c426;">=</span> <?php echo $type -> description; ?></span></li>
				<?php }; }; ?>
				</ul>
			</div>
			<?php } ?>
			<?php foreach($studentTypes as $key => $studentType){  ?>
			<div id="<?php echo $studentType -> slug ?>" class="result">
				<div class="heading">
					<span><?php echo $studentType -> description ?></span>
				</div>
				<?php 

				$programs = $studentType -> posts;
				$columns = [[],[],[],[],[],[],[]];
				$count = 0;

				foreach($programs as $index => $program){ 
					array_push($columns[$count],$program);
					
					$count++;

					if($count > 6){
						$count = 0;
					}
				}

				

				foreach($columns as $index => $programs){ ?>
				<div class="column <?php if($index % 2 !== 0 && $index !== 0){ ?>padding<?php echo ' '.$index; } ?>">
					<?php foreach($programs as $program){ ?>
					<div class="bubble">
						<div>
							<?php if($program -> icon_type){ ?><img src="<?php echo $program -> icon_type; ?>" alt="" /><?php } ?>
							<?php if($program -> listing_small_title){ ?><small><?php echo $program -> listing_small_title ?></small><?php } ?>
							<strong><?php echo $program -> listing_title ?></strong>
							<a href="<?php echo get_permalink($program -> ID); ?>"></a>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php 
				}

				?>
			</div>
			<?php } ?>

			<!-- Created another set of balls but with 3 columns instead of 7 with drop down window-->
      <?php $table_num = 0; foreach($studentTypes as $key => $studentType){  ?>
			<div id="mobile_<?php echo ++$table_num?>" class="result">
				<div class="heading" onclick="toggle('mobile_<?php echo $table_num ?>')">
					<span><?php echo $studentType -> description ?></span>
					<i class="<?php echo $table_num == 1 ? "fas fa-angle-up" : "fas fa-angle-down"; ?>" id = "drop-down-arrow" style = "color: #94c426;"></i>
				</div>
				<?php 

				$programs = $studentType -> posts;
				$columns = [[],[],[]];
				$count = 0;

				foreach($programs as $index => $program){ 
					array_push($columns[$count],$program);
					
					$count++;

					if($count > 2){
						$count = 0;
					}
				}

				foreach($columns as $index => $programs){ ?>
				<div style = "<?php echo $table_num == 1 ? "display: inline-block" : "display: none"; ?>" class="column <?php if($index % 2 !== 0 && $index !== 0){ ?>padding<?php echo ' '.$index; } ?>">
					<?php foreach($programs as $program){ ?>
					<div class="bubble">
						<div>
							<?php if($program -> icon_type){ ?><img src="<?php echo $program -> icon_type; ?>" alt="" /><?php } ?>
							<?php if($program -> listing_small_title){ ?><small><?php echo $program -> listing_small_title ?></small><?php } ?>
							<strong><?php echo $program -> listing_title ?></strong>
							<a href="<?php echo get_permalink($program -> ID); ?>"></a>
						</div>
					</div>
					<?php } ?>
				</div>
				<?php 
				}

				?>
			</div>
			<?php } ?>
			<!-- Created another set of balls but with 3 columns instead of 7 with drop down window-->
		</div>
	</div>
</div>

<?php 

}

get_footer();

?>