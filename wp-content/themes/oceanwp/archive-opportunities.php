<?php 

get_header();

$currentUser = wp_get_current_user();

if(RESTRICT_PROGRAMS && !$currentUser || RESTRICT_PROGRAMS && !$currentUser -> ID){
	get_template_part('partials/custom-login');
}else{

$locations = get_terms('locations');
$types = get_terms('type');
$seasons = get_terms('season');

//layout category
$timeframes = get_terms('timeframe');

//params
$locationsParams = isset($_GET['location']) ? explode(',',$_GET['location']) : [];
$typesParams = isset($_GET['types']) ? explode(',',$_GET['types']) : [];
$seasonsParams = isset($_GET['seasons']) ? explode(',',$_GET['seasons']) : [];

//get programs
$args = array('post_type'=>'opportunities','posts_per_page'=>-1,'order'=>'ASC','orderby'=>'meta_value','meta_key'=>'_listing_title','meta_query' => array(array('key' => '_hide_post','compare' => 'NOT EXISTS')));

if($locationsParams || $typesParams || $seasonsParams){
	$args['tax_query'] = array(
		'relation' => 'AND',
	);
}

if($locationsParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'locations',
		'field'    => 'term_id',
		'terms'    => $locationsParams,
	));
}

if($typesParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'type',
		'field'    => 'term_id',
		'terms'    => $typesParams,
	));
}

if($seasonsParams){
	array_push($args['tax_query'],array(
		'taxonomy' => 'season',
		'field'    => 'term_id',
		'terms'    => $seasonsParams,
	));
}

$programs = get_posts($args);
$typesList = [];

foreach($programs as $key => $value) {
	$listingTitle = get_post_meta($value -> ID,'_listing_title',true);
	$postTerms = wp_get_post_terms($value -> ID,'timeframe');
	$postTimeframes = [];
	
	foreach($postTerms as $key => $postTerm){
		array_push($postTimeframes,$postTerm -> term_id);
	}

	if($listingTitle){
		$value -> listing_title = $listingTitle;
	}

	$listingSmallTitle = get_post_meta($value -> ID,'_listing_small_title',true);
	
	if($listingSmallTitle){
		$value -> listing_small_title = $listingSmallTitle;
	}

	$value -> timeframes = $postTimeframes;

	foreach($timeframes as $key => $timeframe){
		if(!$timeframe -> posts){
			$timeframe -> posts = [];
		}

		if(in_array($timeframe -> term_id,$value -> timeframes)){
			array_push($timeframe -> posts,$value);
		}
	}

	$type = wp_get_post_terms($value -> ID,'resource_type');

	if($type){
		$value -> icons = [];

		foreach($type as $resourceType){
			if(!array_key_exists($resourceType -> term_id,$typesList)){
				$resourceType -> icon = get_term_meta($resourceType->term_id,'taxonomy_icon',true);

				$typesList[$resourceType -> term_id] = $resourceType;
			}

			array_push($value -> icons,$typesList[$resourceType -> term_id]); 
		}

		$primaryType = $type[0];
		
		if(!array_key_exists($primaryType -> term_id,$typesList)){
			$primaryType -> icon = get_term_meta($primaryType->term_id,'taxonomy_icon',true);

			$value -> icon_type = $primaryType -> icon;

			$typesList[$primaryType -> term_id] = $primaryType;
		}

		$value -> icon_type = array_key_exists($primaryType -> term_id,$typesList) ? $typesList[$primaryType -> term_id] -> icon : null;
	}
}

$locationsSelection = '';
$typesSelection = '';
$seasonsSelection = '';

?>
<span style="display:none;"><?php //print_r($programs); ?></span>

<div class="archive-listing">
	<div class="container">
		<div class="row">
			<div class="col banner">
				<img src="/wp-content/uploads/NEW_-Opportunities-header.png" alt="" />
			</div>
			<div class="col browse">
				<strong>Browse By Time Frame</strong>
				<ul>
					<?php foreach($timeframes as $key => $timeframe){
						$label = get_term_meta($timeframe->term_id,'_taxonomy_label',true);
						
						if($label){

					?><li><a href="#<?php echo $timeframe -> slug ?>"><?php echo $label ?></a></li><?php
						}
					} ?>
				</ul>
			</div>
			<div class="col filters">
				<strong>Filters</strong>
				<ul>
					<li>Locations
						<ul>
						<?php foreach($locations as $key => $location){ 
							if(!$locationsSelection){
								$locationsSelection = in_array($location -> term_id,$locationsParams) ? $location -> name : '';
							}else{
								$locationsSelection .= in_array($location -> term_id,$locationsParams) ? ','.$location -> name : '';
							}
							
						?><li><input id="location-<?php echo $key ?>" name="location" type="checkbox" value="<?php echo $location -> term_id; ?>" <?php if(in_array($location -> term_id,$locationsParams)){ ?>checked<?php } ?>> <label for="location-<?php echo $key ?>"><?php echo $location -> name; ?></label></li><?php } ?>
						</ul>
					</li>
					<li>Types
						<ul>
						<?php foreach($types as $key => $type){ 
							if(!$typesSelection){
								$typesSelection = in_array($type -> term_id,$typesParams) ? $type -> name : '';
							}else{
								$typesSelection .= in_array($type -> term_id,$typesParams) ? ','.$type -> name : '';
							}
						?><li><input id="types-<?php echo $key ?>" name="types" type="checkbox" value="<?php echo $type -> term_id; ?>" <?php if(in_array($type -> term_id,$typesParams)){ ?>checked<?php } ?>> <label for="types-<?php echo $key ?>"><?php echo $type -> name; ?></label></li><?php } ?>
						</ul>
					</li>
					<li>Seasons
						<ul class="large">
						<?php foreach($seasons as $key => $season){ 
							if(!$seasonsSelection){
								$seasonsSelection = in_array($season -> term_id,$seasonsParams) ? $season -> name : '';
							}else{
								$seasonsSelection .= in_array($season -> term_id,$seasonsParams) ? ','.$season -> name : '';
							}
						?><li><input id="seasons-<?php echo $key ?>" name="seasons" type="checkbox" value="<?php echo $season -> term_id; ?>" <?php if(in_array($season -> term_id,$seasonsParams)){ ?>checked<?php } ?>> <label for="seasons-<?php echo $key ?>"><?php echo $season -> name; ?></label></li><?php } ?>
						</ul>
					</li>
				</ul>
				<p><?php if($locationsSelection){ ?><span>Locations:</span> <?php echo $locationsSelection; ?><br /><?php } ?><?php if($typesSelection){ ?><span>Types:</span> <?php echo $typesSelection; ?><br /><?php } ?><?php if($seasonsSelection){ ?><span>Seasons:</span> <?php echo $seasonsSelection; ?><?php } ?></p>
			</div>
			<?php if(count($typesList) > 0){ ?>
			<div class="icon-types">
				<ul>
				<?php foreach($typesList as $type){ if($type -> icon){ ?>
					<li><img src="<?php echo $type -> icon; ?>" alt="" /> <span><span style="color:#48cdff;">=</span> <?php echo $type -> description; ?></span></li>
				<?php }; }; ?>
				</ul>
			</div>
			<?php } ?>
			<?php foreach($timeframes as $key => $timeframe){  ?>
			<div id="<?php echo $timeframe -> slug ?>" class="result">
				<div class="heading">
					<span><?php echo $timeframe -> name ?></span>
				</div>
				<?php 

				$programs = $timeframe -> posts;
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
					<?php foreach($programs as $program){  ?>
					<div class="bubble">
						<div>
							<?php 
							if($program -> icons){ 	
								$count = 1;

								$icon_count = 0;
								foreach($program -> icons as $icon){ ?>
							<img src="<?php echo $icon -> icon; ?>" class="icon-<?php echo $count; ?>" alt="" style=" <?php if($icon_count==0 && count($program -> icons) == 2) echo "left: 35px;"?>"/>
								<?php $count++;$icon_count++; };
								
							} ?>
							<strong><?php echo $program -> listing_title ?></strong>
							<?php if($program -> listing_small_title){ ?><small><?php echo $program -> listing_small_title ?></small><?php } ?>
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
			<?php $table_num = 0; foreach($timeframes as $key => $timeframe){  ?>
			<div id="mobile_<?php echo ++$table_num?>" class="result">
				<div class="heading" onclick="toggle('mobile_<?php echo $table_num?>')">
					<span><?php echo $timeframe -> name ?></span>
          <i class="<?php echo $table_num == 1 ? "fas fa-angle-up" : "fas fa-angle-down"; ?>" id = "drop-down-arrow" style = "color: #48cdff;"></i>
				</div>
				<?php 

				$programs = $timeframe -> posts;
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
					<?php foreach($programs as $program){  ?>
					<div class="bubble">
						<div>
							<?php 
							if($program -> icons){ 	
								$count = 1;

								foreach($program -> icons as $icon){ ?>
							<img src="<?php echo $icon -> icon; ?>" class="icon-<?php echo $count; ?>" alt="" />
								<?php $count++; };
								
							} ?>
							<strong><?php echo $program -> listing_title ?></strong>
							<?php if($program -> listing_small_title){ ?><small><?php echo $program -> listing_small_title ?></small><?php } ?>
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
			<!-- Created another set of balls but with 3 columns instead of 7 -->
		</div>
	</div>
</div>

<?php 

};

get_footer();

?>