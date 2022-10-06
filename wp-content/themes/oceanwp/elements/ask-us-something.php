<div class="ask-us-something">
	<div class="graphic">
		<img src="/wp-content/uploads/ask-us-something-2.jpg" alt="" class="desktop" />
		<img src="/wp-content/uploads/ask-us-something-mobile.jpg" alt="" class="mobile" />
	</div>
	<div class="form">
		<form name="custom" action="<?php echo admin_url('admin-ajax.php'); ?>" method="POST" onsubmit="return submitForm(this)" enctype="multipart/form-data" novalidate>
			<fieldset>
				<span>Your name:</span>
				<input name="name" type="text" value="" required />
			</fieldset>
			<fieldset>
				<span>Your Email:</span>
				<input name="email" type="text" value="" required />
			</fieldset>
			<fieldset>
				<span>Your Message</span>
				<textarea name="questions" required></textarea> 
			</fieldset>
			<fieldset>
				<input name="action" type="hidden" value="process_lead" />
				<input name="confirm_msg" type="hidden" value="Thank you!" />
				<?php if(isset($atts['email'])){ ?><input name="send_to" type="hidden" value="<?php echo $atts['email']; ?>" /><?php } ?>
				<input name="type" type="hidden" value="ask-us-something" />
				<button>Ask Us</button>
			</fieldset>
		</form>	
	</div>
</div>