<?php 

global $wp;

$requestUrl = $wp -> request;

switch($requestUrl){
	case 'funding':
		$bannerImage = 'funding-programs.jpg';
		$type = 'financial options';

		break;
	case 'opportunities':
		$bannerImage = 'student-opportunities.jpg';
		$type = 'student opportunities';

		break;
	default:
		$bannerImage = 'education-programs.png';
		$type = 'education programs';
		
		break;
}


?><div class="archive-listing">
	<div class="container">
		<div class="row">
			<div class="col">
				<img src="<?php echo get_template_directory_uri().'/assets/img/'.$bannerImage; ?>" alt="" />
			</div>
			<div class="col listing-content">
				<p>FREE ACCESS and USE of ALL DATABASES. We just ask that you please sign in (Google or Facebook or with your email and password) or <a href="/signup"><u>create an account</u></a>.</p>
				<?php echo do_shortcode('[login-form redirect="'.home_url($requestUrl).'"]'); ?>
			</div>
		</div>
	</div>
</div>