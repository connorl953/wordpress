<?php 

$categoryImage = isset($term -> term_id) ? get_term_meta($term -> term_id,'badge',true) : null;

if($categoryImage == '-1'){
	$categoryImage = null;
}

?><style type="text/css">
.category-image span {display:block;margin:0 0 10px 0;width:100%;max-width:120px;height:120px;cursor:pointer;background:#FFF;border:1px solid #DDD;}
</style>
<table class="form-table category-image">
	<tbody>
		<tr class="form-field form-required">
			<th scope="row">
				<label for="name">Category Image</label>
			</th>
			<td>
				<span <?php if($categoryImage){ ?>style="background:url('<?php echo $categoryImage; ?>') no-repeat center center/contain #FFF;"<?php } ?> onclick="setImage(this)"></span>
				<a href="#" data-state="<?php if($categoryImage){ ?>1<?php }else{ ?>0<?php }?>" onclick="return setImage(this)"><?php if($categoryImage){ ?>Remove<?php }else{ ?>Set<?php }?> Category Image</a>
				<input name="badge" type="hidden" value="<?php echo $categoryImage; ?>">
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
		previewLink.innerText = 'Select category image';
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
				previewLink.innerText = 'Remove category image';
				previewLink.setAttribute('data-state',1);
			}
		});

		mediaFrame.open();
	}

	return false;
}
</script>