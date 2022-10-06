<?php 

$types = get_terms('perspective-type');

if(count($types) > 0){ ?>
<div class="perspectives">
	<?php foreach($types as $type){ 
		$perspectivesPosts = get_posts(array('post_type'=>'perspectives','posts_per_page'=>20,'orderBy'=>'date','order'
		=>'DESC','tax_query' => array(array('taxonomy' => 'perspective-type','field' => 'id','terms' => array($type -> term_id)))));
	?>
	<div class="perspective-single" data-items="<?php echo count($perspectivesPosts); ?>">
		<div class="perspective-label">
			<strong><?php echo $type -> name; ?></strong>
		</div>
		<div class="perspective-items">
			<div class="perspective-container">
				<?php 
			
				foreach($perspectivesPosts as $singlePost){ 

					$thumb = wp_get_attachment_image_src(get_post_thumbnail_id($singlePost -> ID),'full');
					$secondaryImage = get_post_meta($singlePost -> ID,'_secondary_featured_image',true);
					$link = get_post_meta($singlePost -> ID,'_link',true);

					if($thumb){ ?>
				<div class="perspective-item">
					<div class="perspective-thumb" style="background:url('<?php echo $thumb[0]; ?>') no-repeat center center/cover">
						<?php if($secondaryImage){ ?><img src="<?php echo $secondaryImage; ?>" alt="" /><?php } ?>
						<?php if($link){ ?><a href="<?php echo $link; ?>"></a><?php } ?>
					</div>
				</div>
				<?php }; }; ?>
			</div>
		</div>
		<div class="arrow left">
		</div>
		<div class="arrow right">
		</div>
	</div>
	<?php } ?>
</div>
<?php } ?>