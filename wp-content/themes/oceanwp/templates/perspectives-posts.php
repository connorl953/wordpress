<div class="admin-container">
<h1>Perspectives Posts</h1>
</div>
<div class="admin-container">
	<form method="post" action="options.php"> 		
<?php 

$perspectivesFB = get_option('perspectives_facebook_post');

if($perspectivesFB == '-1'){
	$perspectivesFB = null;
}

?><style type="text/css">
.category-image span {display:block;margin:0 0 10px 0;width:100%;max-width:120px;height:120px;cursor:pointer;background:#FFF;border:1px solid #DDD;}
</style>
<table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Facebook Post Image</label>
			</th>
			<td>
				<span <?php if($perspectivesFB){ ?>style="background:url('<?php echo $perspectivesFB; ?>') no-repeat center center/contain #FFF;"<?php } ?> onclick="setImage(this)"></span>
				<a href="#" data-state="<?php if($perspectivesFB){ ?>1<?php }else{ ?>0<?php }?>" onclick="return setImage(this)"><?php if($perspectivesFB){ ?>Remove<?php }else{ ?>Set<?php }?> Post Image</a>
				<input name="perspectives_facebook_post" type="hidden" value="<?php echo $perspectivesFB; ?>">
			</td>
		</tr>   
	</tbody> 
</table>
<table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Facebook Post Link</label>
			</th>
			<td>
				<input name="perspectives_facebook_post_link" type="text" value="<?php echo get_option('perspectives_facebook_post_link'); ?>">
			</td>
		</tr>   
	</tbody> 
</table>
<?php 

$perspectivesInstagram = get_option('perspectives_instagram_post');

if($perspectivesInstagram == '-1'){
	$perspectivesInstagram = null;
}

?><table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Instagram Post Image</label>
			</th>
			<td>
				<span <?php if($perspectivesInstagram){ ?>style="background:url('<?php echo $perspectivesInstagram; ?>') no-repeat center center/contain #FFF;"<?php } ?> onclick="setImage(this)"></span>
				<a href="#" data-state="<?php if($perspectivesInstagram){ ?>1<?php }else{ ?>0<?php }?>" onclick="return setImage(this)"><?php if($perspectivesInstagram){ ?>Remove<?php }else{ ?>Set<?php }?> Post Image</a>
				<input name="perspectives_instagram_post" type="hidden" value="<?php echo $perspectivesInstagram; ?>">
			</td>
		</tr>   
	</tbody> 
</table>
<table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Instagram Post Link</label>
			</th>
			<td>
				<input name="perspectives_instagram_post_link" type="text" value="<?php echo get_option('perspectives_instagram_post_link'); ?>">
			</td>
		</tr>   
	</tbody> 
</table>
<?php 

$perspectivesLinkedin = get_option('perspectives_linkedin_post');

if($perspectivesLinkedin == '-1'){
	$perspectivesLinkedin = null;
}

?><table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Linkedin Post Image</label>
			</th>
			<td>
				<span <?php if($perspectivesLinkedin){ ?>style="background:url('<?php echo $perspectivesLinkedin; ?>') no-repeat center center/contain #FFF;"<?php } ?> onclick="setImage(this)"></span>
				<a href="#" data-state="<?php if($perspectivesLinkedin){ ?>1<?php }else{ ?>0<?php }?>" onclick="return setImage(this)"><?php if($perspectivesLinkedin){ ?>Remove<?php }else{ ?>Set<?php }?> Post Image</a>
				<input name="perspectives_linkedin_post" type="hidden" value="<?php echo $perspectivesLinkedin; ?>">
			</td>
		</tr>   
	</tbody> 
</table>
<table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Linkedin Post Link</label>
			</th>
			<td>
				<input name="perspectives_linkedin_post_link" type="text" value="<?php echo get_option('perspectives_linkedin_post_links'); ?>">
			</td>
		</tr>   
	</tbody> 
</table>
<?php wp_enqueue_media(); ?>
<script type='text/javascript'>
function setImage(_element){
	var previewElement = _element.nodeName.toLowerCase() === 'span' ? _element : _element.previousElementSibling;
	var previewLink = _element.nodeName.toLowerCase() === 'a' ? _element : _element.nextElementSibling;
	var inputSelect = _element.parentNode.lastElementChild;
	var state = parseInt(previewLink.getAttribute('data-state'));

	if(state && _element === previewLink){
		previewElement.style.background = '#FFF';
		inputSelect.value = '-1';
		previewLink.innerText = 'Select image';
		previewLink.setAttribute('data-state',0);
	}else{
		var mediaFrame;

		mediaFrame = wp.media.frames.file_frame = wp.media({
			title: 'Select a image',
			button: {
				text: 'Use this image',
			},
			multiple: false
		});

		mediaFrame.on( 'select', function() {
			attachment = mediaFrame.state().get('selection').first().toJSON();
			
			if(previewElement && inputSelect){
				previewElement.style.background = 'url("'+attachment.url+'") no-repeat center center/contain #FFF';
				inputSelect.value = attachment.url;
				previewLink.innerText = 'Remove post image';
				previewLink.setAttribute('data-state',1);
			}
		});

		mediaFrame.open();
	}

	return false;
}
</script>

	    <?php settings_fields('custom-options-perspective-settings');?>
    	<?php do_settings_sections('custom-options-perspective-settings');?>
	    <?php submit_button(); ?>
	</form>
</div>
