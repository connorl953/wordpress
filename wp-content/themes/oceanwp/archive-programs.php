<?php 

get_header();

$currentUser = wp_get_current_user();

if(RESTRICT_PROGRAMS && !$currentUser || RESTRICT_PROGRAMS && !$currentUser -> ID){
	$bannerImage = 'education-programs.png';

	get_template_part('partials/custom-login');
}else{

$costs = get_terms('cost');
$durations = get_terms('duration');
$locations = get_terms('locations');
$alpha = [];

//params
$costsParams = isset($_GET['costs']) ? explode(',',$_GET['costs']) : [];
$durationsParams = isset($_GET['durations']) ? explode(',',$_GET['durations']) : [];
$locationsParams = isset($_GET['location']) ? explode(',',$_GET['location']) : [];

//get programs
$args = array('post_type'=>'programs','posts_per_page'=>-1,'order'=>'ASC','orderby'=>'meta_value','meta_key'=>'_listing_title','meta_query' => array(array('key' => '_hide_post','compare' => 'NOT EXISTS')));

if($costsParams || $durationsParams || $locationsParams){
	$args['tax_query'] = array(
		'relation' => 'AND',
	);
}

if($costsParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'cost',
		'field'    => 'term_id',
		'terms'    => $costsParams,
	));
}

if($durationsParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'duration',
		'field'    => 'term_id',
		'terms'    => $durationsParams,
	));
}

if($locationsParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'locations',
		'field'    => 'term_id',
		'terms'    => $locationsParams,
	));
}

$programs = get_posts($args);
$typeIcons = [];

foreach($programs as $key => $value) {
	$listingTitle = get_post_meta($value -> ID,'_listing_title',true);
	
	if($listingTitle){
		$letter = $listingTitle[0];
		$value -> listing_title = $listingTitle;

		if(!isset($alpha[$letter])){
			$alpha[$letter] = [];
		}

		array_push($alpha[$letter],$value);
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

$costsSelection = '';
$durationsSelection = '';
$locationsSelection = '';

?>

<div class="archive-listing">
	<div class="container">
		<div class="row">
			<div class="col">
				<img src="<?php echo get_template_directory_uri().'/assets/img/education-programs.png'; ?>" alt="Educational programs" />
			</div>
			<div class="col browse">
				<strong>Browse By Subject Area</strong>
				<ul>
					<?php foreach($alpha as $letter => $alphabet){ ?><li><a href="#<?php echo $letter ?>"><?php echo $letter ?></a></li><?php }; ?>
				</ul>
			</div>	
			<div class="col filters">
				<strong>Filters</strong>
				<ul>
					<li>Cost
						<ul>
						<?php foreach($costs as $key => $cost){ 
							if(!$costsSelection){
								$costsSelection = in_array($cost -> term_id,$costsParams) ? $cost -> name : '';
							}else{
								$costsSelection .= in_array($cost -> term_id,$costsParams) ? ','.$cost -> name : '';
							}
							
						?><li><input id="cost-<?php echo $key ?>" name="costs" type="checkbox" value="<?php echo $cost -> term_id; ?>" <?php if(in_array($cost -> term_id,$costsParams)){ ?>checked<?php } ?>> <label for="cost-<?php echo $key ?>"><?php echo $cost -> name; ?></label></li><?php } ?>
						</ul>
					</li>
					<li>Duration
						<ul>
						<?php foreach($durations as $key => $duration){ 
							if(!$durationsSelection){
								$durationsSelection = in_array($duration -> term_id,$durationsParams) ? $duration -> name : '';
							}else{
								$durationsSelection .= in_array($duration -> term_id,$durationsParams) ? ','.$duration -> name : '';
							}
						?><li><input id="duration-<?php echo $key ?>" name="durations" type="checkbox" value="<?php echo $duration -> term_id; ?>" <?php if(in_array($duration -> term_id,$durationsParams)){ ?>checked<?php } ?>> <label for="duration-<?php echo $key ?>"><?php echo $duration -> name; ?></label></li><?php } ?>
						</ul>
					</li>
					<li>Location
						<ul class="large">
						<?php foreach($locations as $key => $location){ 
							if(!$locationsSelection){
								$locationsSelection = in_array($location -> term_id,$locationsParams) ? $location -> name : '';
							}else{
								$locationsSelection .= in_array($location -> term_id,$locationsParams) ? ','.$location -> name : '';
							}
						?><li><input id="location-<?php echo $key ?>" name="location" type="checkbox" value="<?php echo $location -> term_id; ?>" <?php if(in_array($location -> term_id,$locationsParams)){ ?>checked<?php } ?>> <label for="location-<?php echo $key ?>"><?php echo $location -> name; ?></label></li><?php } ?>
						</ul>
					</li>
				</ul>
				<p><?php if($costsSelection){ ?><span>Costs:</span> <?php echo $costsSelection; ?><br /><?php } ?><?php if($durationsSelection){ ?><span>Duration:</span> <?php echo $durationsSelection; ?><br /><?php } ?><?php if($locationsSelection){ ?><span>Locations:</span> <?php echo $locationsSelection; ?><?php } ?></p>
			</div>
			<?php if(count($typesList) > 0){ ?>
			<div class="icon-types">
				<ul>
				<?php foreach($typesList as $type){ if($type -> icon){ ?>
					<li><img src="<?php echo $type -> icon; ?>" alt="" /> <span><span style="color:#f1e913;">=</span> <?php echo $type -> description; ?></span></li>
				<?php }; }; ?>
				</ul>
			</div>
			<?php } ?>
			<?php foreach($alpha as $key => $value){ ?>
			<div class="result">
				<div id="<?php echo $key ?>" class="heading">
					<span><?php echo $key ?></span>
				</div>
				<?php 

				$columns = [[],[],[],[],[],[],[]];
				$count = 0;

				foreach($value as $index => $program){ 
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
			<?php $table_num = 0; foreach($alpha as $key => $value){ ?>
			<div id="mobile_<?php echo ++$table_num?>" class="result">
				<div id="<?php echo $key ?>" class="heading" onclick="toggle('mobile_<?php echo $table_num?>')">
					<span><?php echo $key ?></span>
          <i class="<?php echo $table_num == 1 ? "fas fa-angle-up" : "fas fa-angle-down"; ?>" id = "drop-down-arrow" style = "color: #f1e913;"></i>
				</div>
				<?php 

				$columns = [[],[],[]];
				$count = 0;

				foreach($value as $index => $program){ 
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