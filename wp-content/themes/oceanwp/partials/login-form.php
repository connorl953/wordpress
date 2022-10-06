<?php 

if(!class_exists('WP_Query')){
	define('WP_USE_THEMES',false);
	require('../../../../wp-load.php');
}

$addToFavourites = isset($_GET['addToFavourites']) ? $_GET['addToFavourites'] : 0;

?><form action="<?php echo esc_url(admin_url('admin-post.php')) ?>" method="POST" onsubmit="return login_signup(this,<?php echo $addToFavourites; ?>)" novalidate><fieldset><label>Email Address*</label><input name="email_address" type="email" value="" required /></fieldset><fieldset><label>Password*</label><input name="password" type="password" value="" required/></fieldset><fieldset><button>Login</button><input type="hidden" name="action" value="process_login"><a href="/signup">Don't have an account? <u>Register here</u></a></fieldset></form>