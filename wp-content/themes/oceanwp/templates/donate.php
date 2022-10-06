<?php 

/* Template Name: Donate */

get_header();

$attachment = wp_get_attachment_image_src(get_post_thumbnail_id($post -> ID),1200);
	
while(have_posts()):
    the_post(); 

    $bottomContent = get_post_meta($post -> ID,'_bottom_content',true);
?>

<div class="donate">
	<div class="container">
		<div class="row">
			<?php if($attachment){ ?>
			<div class="col-12">
				<img src="<?php echo $attachment[0]; ?>" alt="" />
			</div>
			<?php } ?>
			<div class="col-lg-8 col-md-6 col-12">
				<div class="the-content">
					<?php the_content(); ?>
				</div>
				<div class="features">
					<?php 

					$types = get_terms('features-type',array('orderby'=>'term_id','order'=>'ASC'));
					$totalTypes = count($types);

					foreach ($types as $index => $type){ 
						$features = get_posts(array('post_type'=>'features','posts_per_page'=>-1,'tax_query'=>array(array('taxonomy'=>'features-type','field'=>'term_id','terms'=>array($type -> term_id)))));
						
						if($index % 2 === 0){ ?>
					<div class="type-row" id="features">
						<?php }
					?>
					<div class="type">
						<div class="type-thumbs">
							<div class="thumb">
								<?php 

								$count = 0;

								foreach($features as $feature){ 
									$attachment = wp_get_attachment_image_src(get_post_thumbnail_id($feature -> ID),1200);

									if($attachment){
										$link = get_post_meta($feature -> ID,'_features_link',true);
								?>
								<img src="<?php echo $attachment[0]; ?>" alt="" data-link="<?php echo $link ?>" />
								<?php $count++; }; };  ?>
							</div>
							<?php 

							if($count > 1){ ?>
							<div class="arrow left"></div>
							<div class="arrow right"></div>
							<?php } ?>
						</div>
						<div class="type-details">
							<strong><?php echo $type -> name ?></strong>
							<p><?php echo $type -> description ?></p>
						</div>
					</div>
					<?php
						if($index % 2 !== 0){ ?>
					</div>
						<?php }
					} ?>
				</div>
				<?php if($bottomContent){ ?>
				<div class="the-content">
					<?php echo apply_filters('the_content',$bottomContent); ?>
				</div>
				<?php } ?>
			</div>
			<div class="col-lg-4 col-md-6 col-12">
				<div class="form">
					<strong>I’d like to offer some support!</strong>
					<form action="<?php echo admin_url('admin-ajax.php'); ?>" method="POST" onsubmit="return submitDonateForm(this)" novalidate>
						<fieldset class="type">
							<input id="type-1" name="type" type="radio" value="1" checked />
							<label for="type-1">One Time</label>
							<input id="type-2" name="type" type="radio" value="2" />
							<label for="type-2">Monthly</label>
						</fieldset>
						<fieldset class="amount">
							<span>US Dollars (USD)</span>
							<input id="amount-1" name="amount" type="radio" value="3" onchange="updateDonateAmount(this)" checked />
							<label for="amount-1">$3</label>
							<input id="amount-2" name="amount" type="radio" value="5" onchange="updateDonateAmount(this)" />
							<label for="amount-2">$5</label>
							<input id="amount-3" name="amount" type="radio" value="10" onchange="updateDonateAmount(this)" /> 
							<label for="amount-3">$10</label>
							<input id="amount-4" name="amount" type="radio" value="20" onchange="updateDonateAmount(this)" /> 
							<label for="amount-4">$20</label>
							<input id="amount-5" name="amount" type="radio" value="50" onchange="updateDonateAmount(this)" /> 
							<label for="amount-5">$50</label>
							<input id="amount-6" name="amount" type="radio" value="100" onchange="updateDonateAmount(this)" /> 
							<label for="amount-6">$100</label>
							<input id="amount-7" name="amount" type="radio" value="0" onchange="updateDonateAmount(this)" /> 
							<label for="amount-7">Custom</label>
						</fieldset>
						<fieldset class="custom">
							<input name="custom_amount" type="number" value="" placeholder="$ Custom Amount" onchange="return updateAmount(this)" />
						</fieldset>
						<fieldset class="payment">
							<input name="name" type="text" value="" placeholder="Name" required />
							<input name="email" type="text" value="" placeholder="Email Address" required />
							<input name="secret" type="hidden" value="" />
							<div id="stripe-form"></div>
							<p>Powered By <i class="fab fa-cc-stripe"></i></p>
						</fieldset>
                        <div class="h-captcha" data-sitekey="4d71e4ba-6832-41c4-a837-eceb9bac93dd"></div>
						<fieldset>
							<input name="action" type="hidden" value="contribute_form" />
							<button>Donate</button>
						</fieldset>

                        <script src="https://js.hcaptcha.com/1/api.js" async defer></script>
					</form>
				</div>
			</div>	
		</div>
	</div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
	var stripe = Stripe('<?php echo BUILDING_U_STRIPE_KEY_PUBLIC; ?>');
	var elements = stripe.elements();
	var cardElement = elements.create('card');
	var styles = {base:{'::placeholder':{color:'#F00'}}};

	cardElement.mount('#stripe-form',{style:styles});
</script>

<?php 

endwhile;

get_footer();

?>
