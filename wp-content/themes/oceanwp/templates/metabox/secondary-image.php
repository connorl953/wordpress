<?php 

$secondaryImage = get_post_meta($post -> ID,'_secondary_featured_image',true);

?><div class="secondary-featured-image <?php if($secondaryImage){ ?>has-featured<?php } ?>">
	<div class="featured-image">
		<?php if($secondaryImage){ ?><img src="<?php echo $secondaryImage; ?>" alt="" style="width:100%;" onclick="return selectMediaFile(this)" /><?php } ?>
		<p><i>Click the image to edit or update</i></p>
	</div>
	<div class="featured-labels">
		<a href="#" data-add="<?php if($secondaryImage){ ?>1<?php }else{ ?>0<?php } ?>" onclick="return selectFeaturedImage(this)"><?php if($secondaryImage){ ?>Remove featured image<?php }else{ ?>Set featured image<?php } ?></a>
		<input name="_secondary_featured_image" type="hidden" value="<?php echo $secondaryImage; ?>"  />
	</div>
</div>