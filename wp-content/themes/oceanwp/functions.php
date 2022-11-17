<?php
/**
 * T heme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package OceanWP WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core Constants
define( 'OCEANWP_THEME_DIR', get_template_directory() );
define( 'OCEANWP_THEME_URI', get_template_directory_uri() );
define('RESTRICT_PROGRAMS',0);

final class OCEANWP_Theme_Class {

	/**
	 * Main Theme Class Constructor
	 *
	 * @since   1.0.0
	 */
	public function __construct() {

		// Define constants
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'constants' ), 0 );

		// Load all core theme function files
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'include_functions' ), 1 );

		// Load configuration classes
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'configs' ), 3 );

		// Load framework classes
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'classes' ), 4 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'theme_setup' ), 10 );

		// Setup theme => Generate the custom CSS file
		add_action( 'admin_bar_init', array( 'OCEANWP_Theme_Class', 'save_customizer_css_in_file' ), 9999 );

		// register sidebar widget areas
		add_action( 'widgets_init', array( 'OCEANWP_Theme_Class', 'register_sidebars' ) );

		// register custom post types
		add_action( 'widgets_init', array( 'OCEANWP_Theme_Class', 'custom_posts_register' ) );

		// register custom post types
		add_action('add_meta_boxes',array( 'OCEANWP_Theme_Class', 'custom_meta_boxes_register' ));

		// register custom fields save
		add_action('save_post',array( 'OCEANWP_Theme_Class', 'custom_save_fields' ));

		// student role and profile
		add_role('student',__('Student'),array('read'=>true,'edit_posts'=>false,'delete_posts'=>false,));
		add_role('ucrew',__('UCrew'),array('read'=>true,'edit_posts'=>false,'delete_posts'=>false,));
		add_action('show_user_profile',array( 'OCEANWP_Theme_Class', 'display_user_custom_fields' ));
		add_action('edit_user_profile',array( 'OCEANWP_Theme_Class', 'display_user_custom_fields' ));
		add_action('edit_user_profile_update',array( 'OCEANWP_Theme_Class', 'update_user_custom_fields' ));
		add_action('profile_update',array( 'OCEANWP_Theme_Class', 'update_user_custom_fields' ));
		add_action('admin_menu',array( 'OCEANWP_Theme_Class','add_menu_pages'));

		// shortcodes
		add_shortcode('signup-form',array( 'OCEANWP_Theme_Class','render_signup'));
		add_shortcode('login-form',array( 'OCEANWP_Theme_Class','render_login'));
		add_shortcode('might-like-banners',array( 'OCEANWP_Theme_Class','render_might_like_banners'));
		add_shortcode('box-hover',array( 'OCEANWP_Theme_Class','render_box_hover'));
		add_shortcode('forgot-password',array( 'OCEANWP_Theme_Class','render_forgot_password'));
		add_shortcode('review-btn',array( 'OCEANWP_Theme_Class','render_review_btn'));
		add_shortcode('donate-btn',array( 'OCEANWP_Theme_Class','render_donate_btn'));
		add_shortcode('form',array( 'OCEANWP_Theme_Class','render_form'));
		add_shortcode('dot',array( 'OCEANWP_Theme_Class','render_dot'));
		add_shortcode('featured-programs',array( 'OCEANWP_Theme_Class','render_featured_programs'));
		add_shortcode('template-element',array( 'OCEANWP_Theme_Class','render_template_element'));
		add_shortcode('my-favs',array( 'OCEANWP_Theme_Class','render_my_favs'));
		add_shortcode('faqs',array( 'OCEANWP_Theme_Class','render_faqs'));
		add_shortcode('partners',array( 'OCEANWP_Theme_Class','render_partners'));
		add_shortcode('team',array( 'OCEANWP_Theme_Class','render_team'));
		add_shortcode('perspectives',array( 'OCEANWP_Theme_Class','render_perspectives'));
		add_shortcode('perspective-social-media',array( 'OCEANWP_Theme_Class','render_perspective_social_media'));
		add_shortcode('donate-text',array( 'OCEANWP_Theme_Class','render_donate_text'));
		add_shortcode('yt-video',array( 'OCEANWP_Theme_Class','render_video'));
		add_shortcode('link',array( 'OCEANWP_Theme_Class','render_link'));

		//processors
		add_action('admin_post_nopriv_process_signup', array( 'OCEANWP_Theme_Class','process_signup'));
		add_action('admin_post_nopriv_process_login', array( 'OCEANWP_Theme_Class','process_login'));
		add_action('admin_post_process_logout', array( 'OCEANWP_Theme_Class','process_logout'));
		add_action('admin_post_process_add_to_favourites', array( 'OCEANWP_Theme_Class','process_add_to_favourites'));
		add_action('admin_post_nopriv_process_add_to_favourites', array( 'OCEANWP_Theme_Class','process_add_to_favourites'));
		add_action('admin_post_process_forgot_password', array( 'OCEANWP_Theme_Class','process_forgot_password'));
		add_action('admin_post_nopriv_process_forgot_password', array( 'OCEANWP_Theme_Class','process_forgot_password'));
		add_action('admin_post_process_reset_password', array( 'OCEANWP_Theme_Class','process_reset_password'));
		add_action('admin_post_nopriv_process_reset_password', array( 'OCEANWP_Theme_Class','process_reset_password'));
		add_action('admin_post_update_profile', array( 'OCEANWP_Theme_Class','process_update_profile'));
		add_action('admin_post_nopriv_update_profile', array( 'OCEANWP_Theme_Class','process_update_profile'));
		add_action('admin_post_process_payment_intent', array( 'OCEANWP_Theme_Class','process_payment_intent'));
		add_action('admin_post_process_payment', array( 'OCEANWP_Theme_Class','process_payment'));
		add_action('wp_ajax_process_hours', array( 'OCEANWP_Theme_Class','process_hours'));
		add_action('wp_ajax_retrieve_hours', array( 'OCEANWP_Theme_Class','retrieve_hours'));
		add_action('wp_ajax_retrieve_payments', array( 'OCEANWP_Theme_Class','retrieve_payments'));
		add_action('wp_ajax_delete_hours', array( 'OCEANWP_Theme_Class','delete_hours'));
		add_action('wp_ajax_process_manual_payment', array( 'OCEANWP_Theme_Class','process_manual_payment'));
		add_action('wp_ajax_process_payment_deletion', array( 'OCEANWP_Theme_Class','process_payment_deletion'));
		add_action('wp_ajax_process_lead', array( 'OCEANWP_Theme_Class','process_lead'));
		add_action('wp_ajax_nopriv_process_lead', array( 'OCEANWP_Theme_Class','process_lead'));
		add_action('wp_ajax_business_donation', array( 'OCEANWP_Theme_Class','process_business_donation'));
		add_action('wp_ajax_nopriv_business_donation', array( 'OCEANWP_Theme_Class','process_business_donation'));
		add_action('universities_edit_form',array( 'OCEANWP_Theme_Class','edit_universities_custom_fields'));
		add_action('edited_universities',array( 'OCEANWP_Theme_Class','add_universities_custom_fields_save'));
		//stripe payment intent
        add_action('wp_ajax_stripe_payment_intent', array( 'OCEANWP_Theme_Class','getStripePaymentIntent'));
        add_action('wp_ajax_nopriv_stripe_payment_intent', array( 'OCEANWP_Theme_Class','getStripePaymentIntent'));
        // business registration payment
        add_action('wp_ajax_business_registration_payment', array( 'OCEANWP_Theme_Class','processBusinessPayment'));
        add_action('wp_ajax_nopriv_business_registration_payment', array( 'OCEANWP_Theme_Class','processBusinessPayment'));
        // business form persistence
        add_action('wp_ajax_business_form_save', array( 'OCEANWP_Theme_Class','saveBusinessForm'));
        add_action('wp_ajax_nopriv_business_form_save', array( 'OCEANWP_Theme_Class','saveBusinessForm'));

		add_action('wp_ajax_contribute_form', array( 'OCEANWP_Theme_Class','process_contribute_form'));
		add_action('wp_ajax_nopriv_contribute_form', array( 'OCEANWP_Theme_Class','process_contribute_form'));
		add_action('wp_ajax_process_logout', array( 'OCEANWP_Theme_Class','process_logout'));
		add_action('wp_ajax_nopriv_process_logout', array( 'OCEANWP_Theme_Class','process_logout'));

		//add Filters
		add_filter('use_block_editor_for_post','__return_false');
		add_filter('wp_nav_menu_items',array( 'OCEANWP_Theme_Class','custom_menu_items'),10,2);	
		add_filter('manage_users_columns',array( 'OCEANWP_Theme_Class','bu_modify_user_table'));
		add_filter('manage_users_custom_column',array( 'OCEANWP_Theme_Class','bu_manage_users_custom_column'), 10, 3);	

		// Registers theme_mod strings into Polylang
		if ( class_exists( 'Polylang' ) ) {
			add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'polylang_register_string' ) );
		}

		/** Admin only actions **/
		if ( is_admin() ) {

			// Load scripts in the WP admin
			add_action( 'admin_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'admin_scripts' ) );

			// Outputs custom CSS for the admin
			add_action( 'admin_head', array( 'OCEANWP_Theme_Class', 'admin_inline_css' ) );

		/** Non Admin actions **/
		} else {

			// Load theme CSS
			add_action( 'wp_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'theme_css' ) );

			// Load his file in last
			add_action( 'wp_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'custom_style_css' ), 9999 );

			// Remove Customizer CSS script from Front-end
			add_action( 'init', array( 'OCEANWP_Theme_Class', 'remove_customizer_custom_css' ) );

			// Load theme js
			add_action( 'wp_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'theme_js' ) );

			// Add a pingback url auto-discovery header for singularly identifiable articles
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'pingback_header' ), 1 );

			// Add meta viewport tag to header
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'meta_viewport' ), 1 );

			// Add an X-UA-Compatible header
			add_filter( 'wp_headers', array( 'OCEANWP_Theme_Class', 'x_ua_compatible_headers' ) );

			// Loads html5 shiv script
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'html5_shiv' ) );

			// Outputs custom CSS to the head
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'custom_css' ), 9999 );

			// Minify the WP custom CSS because WordPress doesn't do it by default
			add_filter( 'wp_get_custom_css', array( 'OCEANWP_Theme_Class', 'minify_custom_css' ) );

			// Alter the search posts per page
			add_action( 'pre_get_posts', array( 'OCEANWP_Theme_Class', 'search_posts_per_page' ) );

			// Alter tagcloud widget to display all tags with 1em font size
			add_filter( 'widget_tag_cloud_args', array( 'OCEANWP_Theme_Class', 'widget_tag_cloud_args' ) );

			// Alter WP categories widget to display count inside a span
			add_filter( 'wp_list_categories', array( 'OCEANWP_Theme_Class', 'wp_list_categories_args' ) );

			// Add a responsive wrapper to the WordPress oembed output
			add_filter( 'embed_oembed_html', array( 'OCEANWP_Theme_Class', 'add_responsive_wrap_to_oembeds' ), 99, 4 );

			// Adds classes the post class
			add_filter( 'post_class', array( 'OCEANWP_Theme_Class', 'post_class' ) );

			// Add schema markup to the authors post link
			add_filter( 'the_author_posts_link', array( 'OCEANWP_Theme_Class', 'the_author_posts_link' ) );

			// Add support for Elementor Pro locations
			add_action( 'elementor/theme/register_locations', array( 'OCEANWP_Theme_Class', 'register_elementor_locations' ) );

			// Remove the default lightbox script for the beaver builder plugin
			add_filter( 'fl_builder_override_lightbox', array( 'OCEANWP_Theme_Class', 'remove_bb_lightbox' ) );

			// Add meta tags
			add_filter( 'wp_head', array( 'OCEANWP_Theme_Class', 'meta_tags' ), 1 );

		}

		add_action('after_setup_theme',function(){
			$user = wp_get_current_user();
			$roles = isset($user -> roles) ? $user -> roles : null;
			
			if(in_array('student',$roles) || in_array('ucrew',$roles)){
				show_admin_bar(false);
			}
		});

		add_filter('whitelist_options',function($options){
			$options['reading'][] = 'page_for_might_like';
			$options['reading'][] = 'page_for_account';

		    return $options;
		});
		add_filter('display_post_states',function($states,$post){
			if(intval(get_option('page_for_might_like')) === $post->ID){
		        $states['page_for_might_like'] = __('U Might Like');
		    }

		    if(intval(get_option('page_for_account')) === $post->ID){
		        $states['page_for_account'] = __('My Account');
		    }

		    return $states;
		}, 10, 2 );
		add_action( 'admin_init', function () {
			$user = wp_get_current_user();
			$roles = isset($user -> roles) ? $user -> roles : null;
			$screen = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : null;
			$screens = ['/wp-admin/admin-post.php','/wp-admin/admin-ajax.php'];
			
			if(in_array('student',$roles) && !in_array($screen,$screens) || in_array('ucrew',$roles) && !in_array($screen,$screens)){
				wp_die( __( 'You are not allowed to access this part of the site' ) );
			}

			register_setting('custom-options-settings','_banner_content_1');
			register_setting('custom-options-settings','_banner_content_2');
			register_setting('custom-options-settings','_banner_content_3');

			register_setting('custom-options-settings','_featured_content_1');
			register_setting('custom-options-settings','_featured_content_2');
			register_setting('custom-options-settings','_featured_content_3');

			register_setting('custom-options-perspective-settings','perspectives_facebook_post');
			register_setting('custom-options-perspective-settings','perspectives_facebook_post_link');
			register_setting('custom-options-perspective-settings','perspectives_instagram_post');
			register_setting('custom-options-perspective-settings','perspectives_instagram_post_link');
			register_setting('custom-options-perspective-settings','perspectives_linkedin_post');
			register_setting('custom-options-perspective-settings','perspectives_linkedin_post_link');

            $id = 'page_for_might_like';
		    add_settings_field($id, 'Might Like page:',function( $args ) use ($id) {
			    wp_dropdown_pages(array('name' => $id,'show_option_none' => '&mdash; Select &mdash;','option_none_value' => '0','selected' => get_option($id),));
			}, 'reading', 'default', array('label_for' => 'field-'.$id,'class' => 'row-' . $id,));

            $id = 'page_for_account';
			add_settings_field($id, 'Account page:',function( $args ) use ($id) {
			    wp_dropdown_pages(array('name' => $id,'show_option_none' => '&mdash; Select &mdash;','option_none_value' => '0','selected' => get_option($id),));
			}, 'reading', 'default', array('label_for' => 'field-'.$id,'class' => 'row-' . $id,));

			add_filter("manage_edit-resource_type_columns",function($columns){
				$columns['icon'] = 'Icon';

				return $columns;
			}); 

			add_filter("manage_resource_type_custom_column",function($out,$column_name,$term_id){
				switch($column_name){
			        case 'icon': 
			            $icon = get_term_meta($term_id,'taxonomy_icon',true);;
			            $out .= '<img src="'.$icon.'" style="max-width:40px;width:100%;" />'; 
			            
			            break;
			 
			        default:
			            break;
			    }
			    return $out;
			},10,3);
		});

		add_action('rest_api_init',function(){
            register_rest_route( 'building-u','/v1/leads', array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => array($this,'render_api_leads'),
            ));
        });
	}

	public function bu_modify_user_table($column){
		$column['favourites'] = 'Favourites';
		$column['created'] = 'Registration Date';
    	
    	return $column;
	}

	public function bu_manage_users_custom_column($val, $column_name, $user_id ) {
		global $wpdb;

		switch ($column_name) {
	        case 'created' :
	        	$user = get_user_by('id',$user_id);
	        	
	        	return date('Y-m-d',strtotime($user -> user_registered));
	        case 'favourites' :
	        	$total = $wpdb -> get_results('SELECT post FROM '.$wpdb->prefix.'favourites WHERE user='.$user_id,ARRAY_A);

	        	return count($total);
	        default:
	    }

	    return $val;
	}


	/**
	 * Contribute Form
	 *
	 * @since   1.0.0
	 */
	public function process_contribute_form($args){
		$postData = isset($_POST) ? $_POST : null;
		$response = ['success'=>true];

		if($postData){
			$paymentIntent = isset($postData['payment_intent']) ? $postData['payment_intent'] : null;

			if($paymentIntent){
				require_once(__DIR__.'/vendor/autoload.php');

	            \Stripe\Stripe::setApiKey(BUILDING_U_STRIPE_KEY_SECRET);

	            try {
	                $metaData = ['metadata'=>['user_id'=>$currentUser -> ID,'user_email'=>$postData['email']]]; 
	                $intent = \Stripe\PaymentIntent::retrieve($postData['payment_intent']);
	                $updateMetadata = \Stripe\PaymentIntent::update($postData['payment_intent'],$metaData);
	                
	                $response['success'] = true;
	                $response['data'] = $intent;                    
	            }catch(\Stripe\Error\Base $error){
	                $response['error'] = $error -> getMessage();
	            }
			}else{
				$response['error'] = 'Missing payment information!';
			}
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Team
	 *
	 * @since   1.0.0
	 */
	public function render_video($args){
		$id = isset($args['id']) ? $args['id'] : null;
		$html = $id ? '<div class="yt-video"><iframe width="560" height="315" src="https://www.youtube.com/embed/'.$id.'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>' : '';

		return $html;
	}

	/**
	 * Render link
	 *
	 * @since   1.0.0
	 */
	public function render_link($atts){
		$text = isset($atts['text']) ? $atts['text'] : null;
		$link = isset($atts['url']) ? $atts['url'] : null;

		return $text && $link ? '<a href="'.$link.'" onclick="trackLink(this)" target="_BLANK">'.$text.'</a>' : null;
	}

	/**
	 * Team
	 *
	 * @since   1.0.0
	 */
	public function render_perspectives(){
		$path = __DIR__.'/elements/perspectives.php';
		$html = '';

		if(file_exists($path)){
			ob_start();

	        include($path);

	        $html = ob_get_clean();
		}

		return $html;
	}

	/**
	 * Team
	 *
	 * @since   1.0.0
	 */
	public function render_donate_text($args){
		$text = isset($args['text']) ? $args['text'] : null;
		$html = $text ? '<div class="donate-txt"><p>'.$text.'</p></div>' : '';

		return $html;
	}

	/**
	 * Perspectives Social Media
	 *
	 * @since   1.0.0
	 */
	public function render_perspective_social_media(){
		$perspectivesFB = get_option('perspectives_facebook_post');
		$perspectivesInstagram = get_option('perspectives_instagram_post');
		$perspectivesLinkedin = get_option('perspectives_linkedin_post');
		$html = '';

		if($perspectivesFB || $perspectivesInstagram || $perspectivesLinkedin){
			$html .= '<div class="perspectives-social-media">';

			if($perspectivesInstagram){
				$instagramLink = get_option('perspectives_instagram_post_link');
				$html .= $instagramLink ? '<div class="perspectives-item instagram"><a href="'.$instagramLink.'" target="_BLANK"><img src="'.$perspectivesInstagram.'" alt="" /></a></div>' : '<div class="perspectives-item instagram"><img src="'.$perspectivesInstagram.'" alt="" /></div>';
			}

			if($perspectivesFB){
				$fbLink = get_option('perspectives_facebook_post_link');
				$html .= $fbLink ? '<div class="perspectives-item facebook"><a href="'.$fbLink.'" target="_BLANK"><img src="'.$perspectivesFB.'" alt="" /></a></div>' : '<div class="perspectives-item facebook"><img src="'.$perspectivesFB.'" alt="" /></div>';
			}

			if($perspectivesLinkedin){
				$linkedinLink = get_option('perspectives_linkedin_post_link');
				$html .= $linkedinLink ? '<div class="perspectives-item linkedin"><a href="'.$linkedinLink.'" target="_BLANK"><img src="'.$perspectivesLinkedin.'" alt="" /></a></div>' : '<div class="perspectives-item linkedin"><img src="'.$perspectivesLinkedin.'" alt="" /></div>';
			}

			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Team
	 *
	 * @since   1.0.0
	 */
	public function render_team(){
		$path = __DIR__.'/elements/team.php';
		$html = '';

		if(file_exists($path)){
			ob_start();

	        include($path);

	        $html = ob_get_clean();
		}

		return $html;

	}

	/**
	 * API Students
	 *
	 * @since   1.0.0
	 */
	public function add_universities_custom_fields_save($term){
	    if(isset($_REQUEST['badge'])){
	        update_term_meta($term,'badge',$_REQUEST['badge']);
	    }
	}

	/**
	 * API Students
	 *
	 * @since   1.0.0
	 */
	public function edit_universities_custom_fields($term){    
	    include_once('inc/universities.php');
	}

	/**
	 * API Students
	 *
	 * @since   1.0.0
	 */
	public function render_api_leads(){
		$taxonomy = isset($_GET['taxonomy']) ? $_GET['taxonomy'] : null;
		$perPage = isset($_GET['per_page']) && is_numeric($_GET['per_page']) ? $_GET['per_page'] : 10;
		$args = $taxonomy ? array('post_type'=>'leads','posts_per_page'=>$perPage,'order'=>'DESC','tax_query' => array(array('taxonomy' => 'lead-type','field' => 'slug','terms' => array($taxonomy),),)) : array('post_type'=>'leads','posts_per_page'=>$perPage,'order'=>'DESC');
        $leads = new WP_Query($args);
        $posts = $leads -> posts;

        if($taxonomy == 'student-registration'){
        	foreach($posts as $key => $value) {
        		$firstName = get_post_meta($value -> ID,'_first_name',true);
        		$lastName = get_post_meta($value -> ID,'_last_name',true);
        		$email = get_post_meta($value -> ID,'_email',true);
        		$contactEmail = get_post_meta($value -> ID,'contact_email',true);
        		$phone = get_post_meta($value -> ID,'_phone',true);
        		$grade = get_post_meta($value -> ID,'_grade',true);
        		$state = get_post_meta($value -> ID,'_city_state',true);
				$instagram = get_post_meta($value -> ID,'_instagram',true);

        		$value -> meta = [];
        		$value -> meta['first_name'] = $firstName;
        		$value -> meta['last_name'] = $lastName;
        		$value -> meta['contact_email'] = $contactEmail;
        		$value -> meta['phone'] = $phone;
        		$value -> meta['grade'] = $grade;
        		$value -> meta['city_state'] = $state;
        		$value -> meta['instagram'] = $instagram;
        		$value -> meta['email'] = $email;
        	}
        }
        
        $response = ['success'=>true,'per_page'=>$perPage,'pages'=>$leads -> max_num_pages,'leads'=>$posts];

        //initia WP response
        $wpRestResponse = new WP_REST_Response($response);
        $wpRestResponse -> set_status(200);
        
        return $wpRestResponse;
	}

	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public static function constants() {

		$version = self::theme_version();

		// Theme version
		define( 'OCEANWP_THEME_VERSION', $version );

		// Javascript and CSS Paths
		define( 'OCEANWP_JS_DIR_URI', OCEANWP_THEME_URI .'/assets/js/' );
		define( 'OCEANWP_CSS_DIR_URI', OCEANWP_THEME_URI .'/assets/css/' );

		// Include Paths
		define( 'OCEANWP_INC_DIR', OCEANWP_THEME_DIR .'/inc/' );
		define( 'OCEANWP_INC_DIR_URI', OCEANWP_THEME_URI .'/inc/' );

		// stripe live keys
		define( 'BUILDING_U_STRIPE_KEY_PUBLIC', 'pk_live_CW63DxmeInyq8DinWKN6bmMh005NZl66X1');
        define( 'BUILDING_U_STRIPE_KEY_SECRET', 'sk_live_VPJdtm1Cu8Sp9z6HkzXy0D3300pnsxQ2MZ');

		// stripe test keys
		//define( 'BUILDING_U_STRIPE_KEY_PUBLIC', 'pk_test_5A2paP2uCJ7PYlRLWZXOqGZv00sfNNPTPg');
		//define( 'BUILDING_U_STRIPE_KEY_SECRET', 'sk_test_ADmO4uXEOBmwNZFFbLsnMduq00TDMSZrJD');

		// Check if plugins are active
		define( 'OCEAN_EXTRA_ACTIVE', class_exists( 'Ocean_Extra' ) );
		define( 'OCEANWP_ELEMENTOR_ACTIVE', class_exists( 'Elementor\Plugin' ) );
		define( 'OCEANWP_BEAVER_BUILDER_ACTIVE', class_exists( 'FLBuilder' ) );
		define( 'OCEANWP_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
		define( 'OCEANWP_EDD_ACTIVE', class_exists( 'Easy_Digital_Downloads' ) );
		define( 'OCEANWP_LIFTERLMS_ACTIVE', class_exists( 'LifterLMS' ) );

	}

	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0
	 */
	public static function include_functions() {
		$dir = OCEANWP_INC_DIR;
		require_once ( $dir .'helpers.php' );
		require_once ( $dir .'header-content.php' );
		require_once ( $dir .'customizer/controls/typography/webfonts.php' );
		require_once ( $dir .'walker/init.php' );
		require_once ( $dir .'walker/menu-walker.php' );
		require_once ( $dir .'third/class-elementor.php' );
		require_once ( $dir .'third/class-beaver-themer.php' );
		require_once ( $dir .'third/class-bbpress.php' );
		require_once ( $dir .'third/class-buddypress.php' );
		require_once ( $dir .'third/class-lifterlms.php' );
		require_once ( $dir .'third/class-sensei.php' );
		require_once ( $dir .'third/class-social-login.php' );
	}

	/**
	 * Configs for 3rd party plugins.
	 *
	 * @since 1.0.0
	 */
	public static function configs() {

		$dir = OCEANWP_INC_DIR;

		// WooCommerce
		if ( OCEANWP_WOOCOMMERCE_ACTIVE ) {
			require_once ( $dir .'woocommerce/woocommerce-config.php' );
		}

		// Easy Digital Downloads
		if ( OCEANWP_EDD_ACTIVE ) {
			require_once ( $dir .'edd/edd-config.php' );
		}

	}

	/**
	 * Returns current theme version
	 *
	 * @since   1.0.0
	 */
	public static function theme_version() {

		// Get theme data
		$theme = wp_get_theme();

		// Return theme version
		return $theme->get( 'Version' );

	}

	/**
	 * Load theme classes
	 *
	 * @since   1.0.0
	 */
	public static function classes() {

		// Admin only classes
		if ( is_admin() ) {

			// Recommend plugins
			require_once( OCEANWP_INC_DIR .'plugins/class-tgm-plugin-activation.php' );
			require_once( OCEANWP_INC_DIR .'plugins/tgm-plugin-activation.php' );

		}

		// Front-end classes
		else {

			// Breadcrumbs class
			require_once( OCEANWP_INC_DIR .'breadcrumbs.php' );

		}

		// Customizer class
		require_once( OCEANWP_INC_DIR .'customizer/customizer.php' );

	}

	/**
	 * Process business donation
	 *
	 * @since   1.0.0
	 */
	public function process_business_donation(){
		$amount = isset($_POST['amount']) ? $_POST['amount'] : null;
	    $response = ['success'=>false];
	    
	    if($amount){
	    	require_once(__DIR__.'/vendor/autoload.php');

	    	$paymentIntent = isset($_POST['secret']) ? $_POST['secret'] : null;

	    	\Stripe\Stripe::setApiKey(BUILDING_U_STRIPE_KEY_SECRET);

            try{
                $intent = $paymentIntent ? \Stripe\PaymentIntent::update($paymentIntent,[
                    'amount' => ($amount * 100),
                    'currency' => 'USD',
                ]) : \Stripe\PaymentIntent::create([
                    'amount' => ($amount * 100),
                    'currency' => 'USD',
                    'receipt_email' => $_POST['email'],
                ]);

            }catch(Exception $exception){
                $response['data'] = $exception;
            }

            if(isset($intent -> id) && $intent -> id){
                $response['success'] = true;
                $response['intent'] = $intent -> id;
                $response['secret'] = $intent -> client_secret;
            }else{  
                $response['error'] = 'Invalid configuration token';
            }
               
	    }

	    print(json_encode($response));
	    wp_die();
	}

    /**
     * Method will create a payment intent based on amount
     * added: feat/business-registration
     */
    public function getStripePaymentIntent() {
        $amount = $_POST['stripe_amount'] ??  null;
        $response = ['success'=>false];

        // amount validation
        if(!$amount) {
            $response['error_message'] = "No amount set";
            exit(json_encode($response));
        }

        require_once( __DIR__ . '/vendor/autoload.php');
        \Stripe\Stripe::setApiKey(BUILDING_U_STRIPE_KEY_SECRET);
        try {
            $payment_intent = \Stripe\PaymentIntent::create([
                'amount' => ($amount * 100),
                'currency' => 'USD',
                'receipt_email' => $_POST['email'],
            ]);
            $response['success'] = true;
            $response['intent'] = $payment_intent->id;
            $response['secret'] = $payment_intent->client_secret;
            exit(json_encode($response));
        }catch (Exception $e) {
            $response['error_message'] = $e->getMessage();
            exit(json_encode($response));
        }
    }

    public function processBusinessPayment() {
        $paymentIntent = $_POST['payment_intent'] ?? null;
        $response = ['success'=>false];

        // payment intent validation
        if(!$paymentIntent) {
            $response['error_message'] = "No payment intent set";
            exit(json_encode($response));
        }
        require_once( __DIR__ . '/vendor/autoload.php');
        \Stripe\Stripe::setApiKey(BUILDING_U_STRIPE_KEY_SECRET);
        try {
            $metaData = ['metadata'=>['business_name'=>$_POST['businessName']]];
            $intent = \Stripe\PaymentIntent::retrieve($paymentIntent);
            if($intent) {
                $updatedIntent = \Stripe\PaymentIntent::update($paymentIntent,$metaData);
                $response['success'] = true;
                $response['data'] = $updatedIntent;
                exit(json_encode($response));
            } else {
                $response['error_message'] = 'Intent not found';
                exit(json_encode($response));
            }
        }catch(Exception $e){
            $response['error_message'] = $e->getMessage();
            exit(json_encode($response));
        }
    }

    public function saveBusinessForm() {
        $response = ['success'=>false];
        $business_form = array(
            'ID' => '',
            'post_type' => 'business_form',
            'post_status' => 'publish',
            'first_name' =>  $_POST['first_name'],
            'last_name' => $_POST['last_name'],
            'business_name' => $_POST['business_name'],
            'country' => $_POST['country'],
            'email' => $_POST['email'],
            'phone' => $_POST['phone'],
            'sponsor_partner' => $_POST['sponsor_partner'] == "true",
            'sponsor_plan' => $_POST['sponsor_plan'],
            'event_partner' => $_POST['event_partner'] == "true",
            'event_invited' => $_POST['event_invited'],
            'raffle_partner' => $_POST['raffle_partner'] == "true",
            'status' => $_POST['status']
        );

        $post_id = wp_insert_post($business_form);
        if($post_id) {
            update_field( 'field_630257c8e2fd0', $business_form['first_name'], $post_id );
            update_field( 'field_630257dee2fd1', $business_form['last_name'], $post_id );
            update_field( 'field_630257f9e2fd2', $business_form['business_name'], $post_id );
            update_field( 'field_6302580de2fd3', $business_form['country'], $post_id );
            update_field( 'field_6302581ee2fd4', $business_form['email'], $post_id );
            update_field( 'field_63025828e2fd5', $business_form['phone'], $post_id );
            update_field( 'field_63025835e2fd6', $business_form['sponsor_partner'], $post_id );
            $sponsor_plan = null;
            switch ($business_form['sponsor_plan']) {
                case "5000":
                    $sponsor_plan = 4;
                    break;
                case "2700":
                    $sponsor_plan = 3;
                    break;
                case "1400":
                    $sponsor_plan = 2;
                    break;
                case "500":
                    $sponsor_plan = 1;
                    break;
                case "0":
                    $sponsor_plan = 5;
                    break;
                default:
                    break;
            }
            update_field( 'field_63025853e2fd7', $sponsor_plan, $post_id );
            update_field( 'field_63025893e2fd8', $business_form['event_partner'], $post_id );
            update_field( 'field_630258afe2fd9', $business_form['event_invited'], $post_id );
            update_field( 'field_630258cde2fda', $business_form['raffle_partner'], $post_id );
            update_field( 'field_630258e1e2fdb', $business_form['status'], $post_id );
            $response['sucess'] = true;
            $response['business_form_id'] = $post_id;
            exit(json_encode($response));
        }
        exit(json_encode($response));
    }

	/**
	 * 
	 *
	 * @since   1.0.0
	 */
	public function render_faqs(){
		$faqs = get_posts(array('post_type'=>'faqs','posts_per_page'=>-1,'order'=>'ASC','orderby'=>'date'));
		$html = '<div class="faq-list">';

		foreach($faqs as $faq){
			$html .= '<div class="faq"><div class="faq-title"><strong>'.$faq -> post_title.'</strong></div><div class="faq-content">'.apply_filters('the_content',$faq -> post_content).'</div></div>';
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * 
	 *
	 * @since   1.0.0
	 */
	public function render_my_favs(){
		$html ='<div class="my-favs"><div class="my-favs-img"><img src="/wp-content/uploads/my-favs.png" alt="" /><a href="/"></a></div></div>';

		return $html;
	}

	/**
	 * Process lead
	 *
	 * @since   1.0.0
	 */
	public function process_lead(){
		$postData = isset($_POST) ? $_POST : null;
	    $postFile = isset($postData['type']) ? __DIR__.'/forms/post/'.$postData['type'].'.php' : null;
	    $response = ['success'=>false];
	    
	    if(file_exists($postFile)){
	        include_once($postFile);
	    }else{
	        $response['error'] = 'Invalid POST file!';
	    }

	    print(json_encode($response));
	    wp_die();
	}

	/**
	 * Process retrieve payments 
	 *
	 * @since   1.0.0
	 */
	public function process_payment_deletion(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$id = isset($postData['payment_id']) ? (int) $postData['payment_id'] : null;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) && in_array('administrator',$currentUser -> roles) ? ['success'=>false,'data'=>$postData] : ['success'=>false,'error'=>'No user logged in or invalid permissions!'];

		if(!isset($response['error'])){
			$payment = $wpdb -> get_results('SELECT * FROM wp_payments_hours WHERE id='.$id);
			$associatedHours = $wpdb -> get_results('SELECT * FROM wp_hours_used WHERE payment='.$id);
			if(count($associatedHours) > 0 && count($payment) > 0){
				$nextPayment = $wpdb -> get_results('SELECT * FROM wp_payments_hours WHERE user='.$payment[0] -> user.' AND id!='.$id.' ORDER BY id DESC LIMIT 1');

				if(count($nextPayment) > 0){
					foreach($associatedHours as $hour){
						$wpdb->update('wp_hours_used', array('payment'=>$nextPayment[0] -> id), array('id'=>$hour -> id));
					}
				}
			}

			$response['success'] = $wpdb -> delete('wp_payments_hours',array('id'=>$id),array('%d'));
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Render Dot 
	 *
	 * @since   1.0.0
	 */
	public function render_featured_programs($atts){
		$html = '<div class="featured-programs"><img src="/wp-content/uploads/signup-to.png" alt="" class="featured-label" /><div class="featured-program"><a href="/signup/"><span>Favourite</span></a></div><div class="featured-program"><a href="/event/"><span>S4Yt</span></a></div><div class="featured-program"><a href="https://search.google.com/local/writereview?placeid=ChIJ0SinC4QzK4gRAEtX_pqnhDU"><span>Leave a Review</span></a></div></div>';
		
		return $html;	
	}

	/**
	 * Render Partners 
	 *
	 * @since   1.0.0
	 */
	public function render_partners(){
		$partners = get_posts(array('post_type'=>'partners','posts_per_page'=>-1,'order'=>'date','orderBy'=>'DESC'));
		$html = '';

		if(count($partners) > 0){
			$html .= '<div class="partners-list">';

			foreach($partners as $partner){
				$partnerImg = wp_get_attachment_image_src(get_post_thumbnail_id($partner -> ID),1200);
				$html .= $partnerImg ? '<div class="partner-logo" style="background-image:url(\''.$partnerImg[0].'\')"></div>' : '';
			}

			$html .= '</div>';
		}

		return $html;
	}

	/**
	 * Render Dot 
	 *
	 * @since   1.0.0
	 */
	public function render_dot(){
		$html = '<span class="dot"></span>';

		return $html;
	}

	/**
	 * Render Template element 
	 *
	 * @since   1.0.0
	 */
	public function render_template_element($atts){
		$name = isset($atts['name']) ? $atts['name'] : null;
	    $path = $name ? __DIR__.'/elements/'.$name.'.php' : null;
	    $html = '';
	   	
	   	if($name && file_exists($path)){
	        ob_start();

	        include($path);

	        $html = ob_get_clean();
	    }

	    return $html;
	}

	/**
	 * Render Form 
	 *
	 * @since   1.0.0
	 */
	public function render_form($atts){
		$form = isset($atts['name']) ? $atts['name'] : null;
	    $email = isset($atts['email']) ? $atts['email'] : null;
	    $path = $form ? __DIR__.'/forms/'.$form.'.php' : null;
	    $html = '';

	    if($form && $email && file_exists($path)){
	        ob_start();

	        include($path);

	        $html = ob_get_clean();
	    }

	    return $html;
	}

	/**
	 * Process retrieve payments 
	 *
	 * @since   1.0.0
	 */
	public function process_manual_payment(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$requiredFields = ['date','hours','payment','student_id'];
		$response = ['success'=>false];
		$validFields = true;

		foreach($requiredFields as $key => $value){
			if(!isset($postData[$value])){
				$validFields = false;
				break;
			}
		}

		if($validFields){
			$hours = number_format($postData['hours'],2);
 
			//insert hours
            $insert = $wpdb -> insert('wp_payments_hours',array('created'=>date($postData['date'].' H:i:s'),'user'=>$postData['student_id'],'hours'=>$hours,'payment'=>'N/A','data'=>$postData['payment'].' - Manual'),array('%s','%d','%d','%s','%s')); 
            $response['hours'] = $hours;
            $response['success'] = true;
		}else{
			$response['error'] = 'Missing required fields!';
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Process retrieve payments 
	 *
	 * @since   1.0.0
	 */
	public function delete_hours(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$id = isset($postData['id']) ? (int) $postData['id'] : null;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) && in_array('administrator',$currentUser -> roles) ? ['success'=>false,'data'=>$postData] : ['success'=>false,'error'=>'No user logged in or invalid permissions!'];

		if(!isset($response['error'])){
			$response['success'] = $wpdb -> delete('wp_hours_used',array('id'=>$id),array('%d'));
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Process retrieve payments 
	 *
	 * @since   1.0.0
	 */
	public function retrieve_payments(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$studentId = isset($postData['student_id']) ? (int) $postData['student_id'] : null;
		$page = isset($postData['page']) && is_numeric($postData['page']) ? (int) $postData['page'] : 1;
		$limit = isset($postData['limit']) && is_numeric($postData['limit']) ? (int) $postData['limit'] : 10;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) ? ['success'=>false,'data'=>$postData] : ['success'=>false,'error'=>'No user logged in!'];

		if($postData && $studentId && $currentUser -> ID){
			$studentId = $currentUser -> ID == $studentId || in_array('administrator',$currentUser -> roles) ? $studentId : null;

			if($studentId){
				$offset = $page > 1 ? ($page * $limit) - ($limit) : 0;
				$total = $wpdb -> get_results('SELECT COUNT(*) as total FROM wp_payments_hours WHERE user = '.$studentId);
				$payments = $wpdb -> get_results('SELECT * FROM wp_payments_hours WHERE user='.$studentId.' ORDER BY created DESC LIMIT '.$limit.' OFFSET '.$offset.'');

				foreach($payments as $key => $payment){
					$totalUsedQuery = $wpdb -> get_results('SELECT SUM(hours) as total FROM wp_hours_used WHERE student='.$studentId.' AND payment='.$payment -> id);

					
					try{
						$paymentData = json_decode($payment -> data,true);
					}catch(Exception $e){
						$paymentData = $payment -> data;
					}

					$payments[$key] -> created = date('m/d/y',strtotime($payment -> created));
					$payments[$key] -> payment_amount = isset($paymentData['amount']) ? number_format(($paymentData['amount'] * 0.01 ),2) : $payment -> data.' - Manual';
					$payments[$key] -> hours_used = isset($totalUsedQuery[0] -> total) ? $totalUsedQuery[0] -> total : 0;
				}
				
				$response['data'] = $payments;
				$response['page'] = $page;
				$response['limit'] = $limit;
				$response['offset'] = $offset;
				$response['total'] = (int) $total[0] -> total;
				$response['success'] = true;
			}else{

			}
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Process retrieve hours 
	 *
	 * @since   1.0.0
	 */
	public function retrieve_hours(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$studentId = isset($postData['student_id']) ? (int) $postData['student_id'] : null;
		$page = isset($postData['page']) && is_numeric($postData['page']) ? (int) $postData['page'] : 1;
		$limit = isset($postData['limit']) && is_numeric($postData['limit']) ? (int) $postData['limit'] : 10;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) ? ['success'=>false,'data'=>$postData] : ['success'=>false,'error'=>'No user logged in!'];

		if($postData && $studentId && $currentUser -> ID){
			$studentId = $currentUser -> ID == $studentId || in_array('administrator',$currentUser -> roles) ? $studentId : null;

			if($studentId){
				$offset = $page > 1 ? ($page * $limit) - ($limit) : 0;
				$total = $wpdb -> get_results('SELECT COUNT(*) as total FROM wp_hours_used WHERE student = '.$studentId);
				$hours = $wpdb -> get_results('SELECT * FROM wp_hours_used WHERE student='.$studentId.' ORDER BY created DESC LIMIT '.$limit.' OFFSET '.$offset.'');

				foreach($hours as $key => $hour){
					$hours[$key] -> created = date('Y-m-d',strtotime($hour -> created));
				}
				
				$response['data'] = $hours;
				$response['page'] = $page;
				$response['limit'] = $limit;
				$response['offset'] = $offset;
				$response['total'] = (int) $total[0] -> total;
				$response['success'] = true;
			}else{

			}
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Process hours 
	 *
	 * @since   1.0.0
	 */
	public function process_hours(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) ? ['success'=>false,'data'=>$postData] : ['success'=>false,'error'=>'No user logged in!'];

		if($postData){
			if(in_array('administrator',$currentUser -> roles)){
				$requiredFields = ['created','hours','date','payment_id','student_id','description','type'];
				$validFields = true;

				foreach($requiredFields as $key => $value){
					if(!isset($postData[$value])){
						$validFields;
						break;
					}
				}

				if($validFields){
					$user = get_user_by('ID',$postData['student_id']);

					if($user && in_array('student',$user -> roles)){
						$payment = $wpdb -> get_results('SELECT * FROM wp_payments_hours WHERE id='.$postData['payment_id'].' AND user='.$postData['student_id'].' LIMIT 1');
						$hoursId = isset($postData['hours_id']) ? $postData['hours_id'] : null;

						if(count($payment) == 1){
							if($hoursId){
								$response['update'] = $wpdb->update('wp_hours_used', array('id'=>$postData['hours_id'], 'created'=>$postData['date'], 'hours'=>$postData['hours'],'description'=>$postData['description'], 'type'=>$postData['type'],'payment'=>$postData['payment_id']), array('id'=>$postData['hours_id']));
								
							}else{
								$response['insert'] = $wpdb -> insert('wp_hours_used',array('created'=>$postData['date'].'H:i:s','user'=>$currentUser -> ID,'student'=>$user -> ID,'hours'=>$postData['hours'],'description'=>$postData['description'],'payment'=>$postData['payment_id'],'type'=>$postData['type']),array('%s','%d','%d','%f','%s','%d','%d')); 
							}

							$response['success'] = true;
						}else{
							$response['error'] = 'Payment ID #'.$postData['payment_id'].' does not belong to this user';
						}
					}else{
						$response['error'] = 'Invalid user!';
					}
				}else{
					$response['error'] = 'Missing required fields!';
				}
			}else{
				$response['error'] = 'Invalid permissions!';
			}
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * Process payment 
	 *
	 * @since   1.0.0
	 */
	public function process_payment(){
		global $wpdb;

		$postData = isset($_POST) ? $_POST : null;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) ? ['success'=>false,'data'=>$postData] : ['success'=>false,'error'=>'No user logged in!'];

		if($postData){
			$requiredFields = ['client_secret','email','first_name','hours','last_name','payment_intent','total'];
			$validData = true;

			foreach($requiredFields as $key => $value){
				if(!isset($postData[$value])){
					$validData = false;
					break;
				}
			}

			if($validData){
				require_once(__DIR__.'/vendor/autoload.php');

                \Stripe\Stripe::setApiKey(BUILDING_U_STRIPE_KEY_SECRET);

                try {
                    $metaData = ['metadata'=>['user_id'=>$currentUser -> ID,'user_email'=>$postData['email']]]; 
                    $intent = \Stripe\PaymentIntent::retrieve($postData['payment_intent']);
                    $updateMetadata = \Stripe\PaymentIntent::update($postData['payment_intent'],$metaData);
                    
                    //insert hours
                    $insert = $wpdb -> insert('wp_payments_hours',array('created'=>date('Y-m-d H:i:s'),'user'=>$currentUser -> ID,'hours'=>$postData['hours'],'payment'=>$postData['payment_intent'],'data'=>json_encode($intent)),array('%s','%d','%d','%s','%s')); 

                    $response['success'] = true;
                    $response['data'] = $intent;
                    $response['insert'] = $insert;                      
                }catch(\Stripe\Error\Base $error){
                    $response['error'] = $error -> getMessage();
                }
			}else{
				$response['error'] = 'Invalid POST data!';
			}
		}

		print(json_encode($response));
	}

	/**
	 * Process payment intent
	 *
	 * @since   1.0.0
	 */
	public function process_payment_intent(){
		$hours = isset($_POST['hours']) && is_numeric($_POST['hours']) ? (float) $_POST['hours'] : null;
		$paymentIntent = isset($_POST['payment_intent']) ? $_POST['payment_intent'] : null;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) ? ['success'=>false] : ['success'=>false,'error'=>'No user logged in!'];

		if(isset($currentUser -> ID) && $hours){
			require_once(__DIR__.'/vendor/autoload.php');

			$country = get_user_meta($currentUser -> ID,'_user_country',true);
			$currency = $country === 'USA' ? 'usd' : 'cad';

			if($hours >= 1 && $hours <= 5){
				$amount = 90 * $hours;
			}else if($hours >= 6 && $hours <= 10){
				$amount = 85 * $hours;
			}else{
				$amount = 75 * $hours;
			}

            \Stripe\Stripe::setApiKey(BUILDING_U_STRIPE_KEY_SECRET);

            try{
                $intent = $paymentIntent ? \Stripe\PaymentIntent::update($paymentIntent,[
                    'amount' => ($amount * 100),
                    'currency' => $currency,
                ]) : \Stripe\PaymentIntent::create([
                    'amount' => ($amount * 100),
                    'currency' => $currency,
                ]);

            }catch(Exception $exception){
                $response['data'] = $exception;
            }

            if(isset($intent -> id) && $intent -> id){
                $response['success'] = true;
                $response['intent'] = $intent -> id;
                $response['secret'] = $intent -> client_secret;
            }else{  
                $response['error'] = 'Invalid configuration token';
            }
		}

		print(json_encode($response));
	}

	/**
	 * Update user profile
	 *
	 * @since   1.0.0
	 */
	public function process_update_profile(){
		$postData = isset($_POST) ? $_POST : null;
		$currentUser = wp_get_current_user();
		$response = isset($currentUser -> ID) ? ['success'=>true] : ['success'=>false,'error'=>'No user logged in!'];

		if(isset($currentUser -> ID)){
			$validFields = isset($postData['gender']) && $postData['gender'] == 'Other' ? ['first_name'=>'','last_name'=>'','address'=>'_user_address','country'=>'_user_country','phone'=>'_user_phone','city'=>'_user_city','region'=>'_user_region','education_level'=>'education_level','gender'=>'gender','other_gender'=>'other_gender'] : ['first_name'=>'','last_name'=>'','address'=>'_user_address','country'=>'_user_country','phone'=>'_user_phone','city'=>'_user_city','region'=>'_user_region','education_level'=>'education_level','gender'=>'gender'];
			$validData = true;

			foreach($validFields as $key => $value){
				if(!isset($postData[$key]) || !$postData[$key]){
					$validData = false;
					$response['error'] = 'Invalid user data!';
					break;
				}
			}

			if($validData){
				$update = wp_update_user(array('ID'=>$currentUser -> ID,'first_name'=>$postData['first_name'],'last_name'=>$postData['last_name']));

				foreach($validFields as $key => $value){
					if(isset($postData[$key]) && $postData[$key] && $value){
						update_user_meta($currentUser -> ID,$value,$postData[$key]);
					}
				}
			}
		}

		print(json_encode($response));
	}

	/**
	 * Display Student User Profile
	 *
	 * @since   1.0.0
	 */
	public static function update_user_custom_fields($user_id){
		$postData = isset($_POST) ? $_POST : null;
		$metaData = ['student'=>['_ucrew_mentor']];
		$user = get_userdata($user_id);
		$roles = $user ? $user -> roles : [];
		$role = null;

		foreach($metaData as $key => $value){
			if(in_array($key,$roles)){
				$role = $key;
				break;
			}
		}

		if($role){
			$roleMetaData = $metaData[$role];

			foreach($roleMetaData as $key => $value){
				if(isset($postData[$value]) && $postData[$value]){
					update_user_meta($user_id,$value,$postData[$value]);
				}else{
					delete_post_meta($user_id,$value);
				}
			}
		}

		$fields = ['_user_address','_profile_image','_user_country','_user_city','_user_region','_user_phone'];

		foreach($fields as $key => $field){
			if(isset($postData[$field])){
				update_user_meta($user_id,$field,$postData[$field]);
			}else{
				delete_post_meta($user_id,$field);
			}
		};

	}

	/**
	 * Render donate button
	 *
	 * @since   1.0.0
	 */
	public static function render_donate_btn(){
		$html = '<form class="paypay_form" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_BLANK"><input type="hidden" name="cmd" value="_s-xclick" /><input type="hidden" name="hosted_button_id" value="YKU39P66XSMFQ" /><input type="image" src="https://www.building-u.com/wp-content/uploads/donate-btn.jpg" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" height="48" style="float:right;" /><img alt="" border="0" src="https://www.paypal.com/en_CA/i/scr/pixel.gif" width="1" height="1" /></form>';

		return $html;
	}

	/**
	 * Display Student User Profile
	 *
	 * @since   1.0.0
	 */
	public static function display_user_custom_fields($user){
		global $wpdb;

		$roles = isset($user -> roles) ? $user -> roles : null;
		$address = get_user_meta($user -> ID,'_user_address',true);
		$city = get_user_meta($user -> ID,'_user_city',true);
		$region = get_user_meta($user -> ID,'_user_region',true);
		$country = get_user_meta($user -> ID,'_user_country',true);
		$phone = get_user_meta($user -> ID,'_user_phone',true);
		$profileImage = get_user_meta($user -> ID,'_profile_image',true);

		$html = '<h3>User Custom Fields</h3><table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Address</th><td><fieldset><legend class="screen-reader-text"></legend><textarea name="_user_address">'.$address.'</textarea></fieldset></td></tr></tbody></table>';

		$html .= '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">City</th><td><fieldset><legend class="screen-reader-text"></legend><input name="_user_city" value="'.$city.'" /></fieldset></td></tr></tbody></table>';

		$html .= '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">State/Province</th><td><fieldset><legend class="screen-reader-text"></legend><input name="_user_region" value="'.$region.'" /></fieldset></td></tr></tbody></table>';

		$html .= $country === 'USA' ? '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Country</th><td><fieldset><legend class="screen-reader-text"></legend><select name="_user_country"><option value="CA">Canada</option><option value="USA" selected>United States</option></select></fieldset></td></tr></tbody>' : '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Country</th><td><fieldset><legend class="screen-reader-text"></legend><select name="_user_country"><option value="CA">Canada</option><option value="USA">United States</option></select></fieldset></td></tr></tbody>';

		$html .= '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Phone</th><td><fieldset><legend class="screen-reader-text"></legend><input name="_user_phone" value="'.$phone.'" /></fieldset></td></tr></tbody></table>';
		
		$html .= $profileImage ? '</table><table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Profile</th><td><fieldset><legend class="screen-reader-text"></legend><div class="profile" data-add="1" style="background:url(\''.$profileImage.'\') no-repeat center center/contain;"><i class="fa fa-times" onclick="this.parentNode.removeAttribute(\'style\');this.parentNode.removeAttribute(\'data-add\');this.parentNode.parentNode.lastElementChild.value = \'\'"></i></div><input type="button" value="Select Image" class="button wp-generate-pw hide-if-no-js" onclick="return selectImage(this)" /><input name="_profile_image" type="hidden" value="'.$profileImage.'" /></fieldset></td></tr></tbody></table>' : '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Profile</th><td><fieldset><legend class="screen-reader-text"></legend><div class="profile"><i class="fa fa-times" onclick="this.parentNode.removeAttribute(\'style\');this.parentNode.removeAttribute(\'data-add\');this.parentNode.parentNode.lastElementChild.value = \'\'"></i></div><input type="button" value="Select Image" class="button wp-generate-pw hide-if-no-js" onclick="return selectImage(this)" /><input name="_profile_image" type="hidden" value="" /></fieldset></td></tr></tbody></table>';

		$html .= '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">Registered Date</th><td><fieldset><legend class="screen-reader-text"><span>Registered Date</span></legend><label for="_hubspot_active"><input type="text" value="'.date('Y-m-d G:i',strtotime($user -> user_registered)).'" readonly /></td></tr></tbody></table>';

		if(in_array('student',$user -> roles)){
			//favourites
			$favouritesDB = $wpdb -> get_results('SELECT created,post FROM '.$wpdb->prefix.'favourites WHERE user='.$user -> data -> ID,ARRAY_A);
			$favourites = [];

			if($favouritesDB){
				foreach($favouritesDB as $key => $favourite){
					if(isset($favourite['post'])){
						array_push($favourites,get_post($favourite['post']));
					}
				}
			}
			
			$html .= '<div class="favourites-list"><div class="favourites-header"><h3>Favourites</h3></div><div class="table"><div class="labels"><ul><li>Date</li><li>Type</li><li>Resource</li></ul></div><div class="items">';

			foreach($favourites as $index => $favourite){
				$html .= '<ul><li>'.date('Y-m-d',strtotime($favouritesDB[$index]['created'])).'</li><li>'.ucwords($favourite -> post_type).'</li><li><a href="'.get_permalink($favourite -> ID).'" target="_BLANK">'.$favourite -> post_title.'</a></li></ul>';
			}

			$html .='</div></div></div>';

			//other
			$ucrewMembers = get_users(array('role'=>'ucrew'));
			$ucrewMentor = get_user_meta($user -> ID,'_ucrew_mentor',true);

			$html .= '<table class="form-table"><tbody><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">HubSpot Active</th><td><fieldset><legend class="screen-reader-text"><span>HubSpot Active</span></legend>';
			$html .= 'onclick="return false;" style="cursor:default;"></label><br></fieldset></td></tr><tr class="show-admin-bar user-admin-bar-front-wrap"><th scope="row">U-Crew Mentor</th><td><select name="_ucrew_mentor"><option>-- Select --</option>';

			foreach($ucrewMembers as $key => $value){
				$html .= $ucrewMentor == $value -> ID ? '<option value="'.$value -> ID.'" selected>'.$value -> display_name.'</option>' : '<option value="'.$value -> ID.'">'.$value -> display_name.'</option>';
			}

			$html .= '</select></td></tr></tbody></table>';

			$html .= '<div class="hours-used" data-user="'.$user -> ID.'" data-page="1" data-limit="5"><h3>Used Hours</h3><!--input type="button" class="button" value="Add Used Hours" onclick="this.parentNode.nextElementSibling.className += \' open\'" /--!><div class="table"><div class="labels"><ul><li>Date</li><li>Type</li><li>Hours Used</li><li>Description</li></ul></div><div class="items"></div><div class="pagination"></div></div></div>';

			$html .= '<div class="modal"><div class="row"><div class="content"><i class="fa fa-times" onclick="this.parentNode.parentNode.parentNode.className = \'modal\';"></i><strong>Add Manual Payment</strong><p>Please enter the following details.</p><fieldset><label>Date</label><input name="date" type="date" required /></fieldset><fieldset><label>Hours</label><input name="hours" type="number" required /></fieldset><fieldset><label>Payment</label><input name="payment" type="number" value="" required /></fieldset><fieldset><input name="student_id" type="hidden" value="'.$user -> ID.'" required /><input type="button" class="button button-primary" value="Submit" onclick="submitPayment(this)" /></fieldset></div></div></div>';

			$html .= '<div class="payment-list" data-user="'.$user -> ID.'" data-page="1" data-limit="5"><div class="payment-header"><h3>Payments</h3><a href="#" onclick="return addPayment(this)">Add Manual Payment</a></div><div class="table"><div class="labels"><ul><li>Id</li><li>Date</li><li>Hours</li><li>Used Hours</li><li>Payment</li></ul></div><div class="items"></div><div class="pagination"></div></div></div>';

			$html .= '<div class="modal"><div class="row"><div class="content"><i class="fa fa-times" onclick="this.parentNode.parentNode.parentNode.className = \'modal\'"></i><strong>Add Used Hours</strong><p>Please enter the following details.</p><fieldset><label>Date</label><input name="date" type="date" required /></fieldset><fieldset><label>Hours Used</label><input name="hours" type="number" required /></fieldset><fieldset><label>Description</label><textarea name="description" required></textarea></fieldset><fieldset class="radio"><input type="radio" name="type" value="1" id="sessions" checked /><label for="sessions">Session Hours</label><input type="radio" name="type" value="2" id="out-of-sessions" /><label for="out-of-sessions">Out-of-Session Research</label></fieldset><fieldset><label>Belongs to Payment ID <a href="" onclick="this.style.display=\'none\';this.parentNode.nextElementSibling.focus();this.parentNode.nextElementSibling.removeAttribute(\'readonly\');return false;">edit</a></label><input name="payment_id" type="number" readonly required /></fieldset><fieldset><input name="student_id" type="hidden" value="'.$user -> ID.'" required><input type="button" class="button button-primary" value="Submit" onclick="submitHours(this)" /><input name="hours_id" type="hidden" value="" /></fieldset></div></div></div>';
		}
		
		wp_enqueue_media();	

		print($html);
	}

	/**
	 * Display custom menu
	 *
	 * @since   1.0.0
	 */
	public static function custom_menu_items($items,$args){
		global $wpdb;

		$currentUser = wp_get_current_user();
		$favourites = isset($currentUser -> ID) && $currentUser -> ID ? $wpdb -> get_var('SELECT COUNT(*) FROM '.$wpdb -> prefix.'favourites WHERE user='.$currentUser -> data -> ID) : 0;
		$items .= isset($currentUser -> ID) && $currentUser -> ID ? '<li class="favourites dropdown"><a href="/my-account/"><i></i> ('.$favourites.')</a><ul class="sub-menu"><li class="video"><span>Replay Video</span></li><li class="logout"><span class="text-wrap">Logout</span></li></ul></li>' : '<li class="favourites"><a href="/login/"><i></i> (0)</a><ul class="sub-menu"><li class="video"><span>Replay Video</span></li></ul></li>';

    	return $items;
	}

	/**
	 * shortcode
	 *
	 * @since   1.0.0
	 */
	public static function render_forgot_password($args){
		$code = isset($_GET['key']) ? $_GET['key'] : null;
		$login = isset($_GET['login']) ? $_GET['login'] : null;
		$html = '';

		if($code && $login){
			$validate = check_password_reset_key($code,$login);

			if(is_wp_error($validate)){
    			$html .= '<p style="color:#F00;"><b>'.$validate -> get_error_message().'</b></p>';
			}else{
				$html .= '<form action="'.esc_url(admin_url('admin-post.php')).'" method="POST" onsubmit="return resetPassword(this)" novalidate><fieldset><input name="password" type="password" placeholder="New Password" required /></fieldset><fieldset><input name="confirm_password" type="password" placeholder="Confirm New Password" required /></fieldset><fieldset><button>Reset</button><input name="login" type="hidden" value="'.$login.'" /><input name="key" type="hidden" value="'.$code.'" /><input name="action" type="hidden" value="process_reset_password" /></fieldset></form>';
			}
		}else{
			$html .= '<p style="color:#F00;"><b>Invalid verification code!</b></p>';
		}

		return $html;
	}

	/**
	 * shortcode
	 *
	 * @since   1.0.0
	 */
	public static function render_review_btn($args){
		$class = isset($args['class']) ? $args['class'] : null;
		$html = $class ? '<a href="https://search.google.com/local/writereview?placeid=ChIJ0SinC4QzK4gRAEtX_pqnhDU" class="review-btn '.$class.'" target="_BLANK"><img src="/wp-content/uploads/leave-a-review-kite01_hovered.jpg" alt="" /><img src="/wp-content/uploads/leave-a-review.png" alt="Leave a review" /></a>' : '<a href="https://search.google.com/local/writereview?placeid=ChIJ0SinC4QzK4gRAEtX_pqnhDU" class="review-btn" target="_BLANK"><img src="/wp-content/uploads/leave-a-review-kite01_hovered.jpg" alt="" /><img src="/wp-content/uploads/leave-a-review.png" alt="Leave a review" /></a>';

		return $html;
	}

	/**
	 * shortcode
	 *
	 * @since   1.0.0
	 */
	public static function render_box_hover($args){
		$ids = [1,2,3,4,5];
		$id = isset($args['id']) && in_array($args['id'],$ids) ? $args['id'] : 1;
		$html = '';

		if($id == 1){
			$html = '<div class="box-hover resources"><div class="box-img"><img src="/wp-content/uploads/2018/10/resources-1.jpg" alt="" /></div><div class="box-text"><div><div><p>Resources</p></div></div></div><div class="box-link"><a href="/resources-2/"></a></div></div>';
		}else if($id == 2){
			$html = '<div class="box-hover services"><div class="box-img"><img src="/wp-content/uploads/2018/10/services-1.jpg" alt="" /></div><div class="box-text"><div><div><p>Blog & Beyond</p></div></div></div><div class="box-link"><a href="/blog/"></a></div></div>';
		}else if($id == 3){
			$html = '<div class="box-hover u-might"><div class="box-img"><img src="/wp-content/uploads/2018/10/email.jpg" alt="" /></div><div class="box-text"><div><div><p>Events</p></div></div></div><div class="box-link"><a href="/event/"></a></div></div>';
		}else if($id == 4){
			$html = '<div class="box-hover u-crew"><div class="box-img"><img src="/wp-content/uploads/2018/10/u_crew.jpg" alt="" /></div><div class="box-text"><div><div><p>About</p></div></div></div><div class="box-link"><a href="/our-purpose/"></a></div></div>';
		}else if($id == 5){
			$html = '<div class="box-hover share"><div class="box-img"><img src="/wp-content/uploads/2019/02/shareheader.png" alt="" /></div><div class="box-text"><div><div><p>Connect with Us</p></div></div></div><div class="box-link"><a href="/u-might-like-some-more-information/"></a></div></div>';
		};

		return $html;
	}

	/**
	 * shortcode
	 *
	 * @since   1.0.0
	 */
	public static function render_might_like_banners(){
		$mightLikePage = get_option('page_for_might_like');
		$html = '';

		if($mightLikePage){
			$banner1 = get_option('_banner_content_1');
			$banner2 = get_option('_banner_content_2');
			$banner3 = get_option('_banner_content_3');

			if($banner1 || $banner2 || $banner3){
				$html .= '<div class="slider">';

				if($banner1){
					$html .= '<div class="slide programs">'.apply_filters('the_content',$banner1).'</div>';
				}

				if($banner2){
					$html .= '<div class="slide funding">'.apply_filters('the_content',$banner2).'</div>';
				}

				if($banner3){
					$html .= '<div class="slide opportunities">'.apply_filters('the_content',$banner3).'</div>';
				}

				if($banner1 && $banner2 || $banner2 && $banner3 || $banner1 && $banner3){
					$html .= '<div class="arrow left"><i class="fa fa-angle-left"></i></div><div class="arrow right"><i class="fa fa-angle-right"></i></div>';
				}

				$html .= '<!--a href="'.get_permalink($mightLikePage).'"></a--></div>';
			}
		}

		return $html;
	}	

	/**
	 * shortcode
	 *
	 * @since   1.0.0
	 */
	public static function render_signup(){
		$currentUser = wp_get_current_user();
		
		if(isset($currentUser -> data -> ID)){
			$html = '<!--p>You are logged in as <strong style="color:#000;">'.$currentUser -> data -> display_name.'</strong><br /><form action="'.esc_url(admin_url('admin-post.php')).'" method="POST" onsubmit="return logout(this)" novalidate><button>Logout</button><input type="hidden" name="action" value="process_logout"></form></p--><script>document.location.href = \'/my-account/\'</script>';
		}else{
			$html = '<form name="signup" action="'.esc_url(admin_url('admin-post.php')).'" method="POST" onsubmit="return login_signup(this)" novalidate><fieldset><label>First Name*</label><input name="first_name" type="text" value="" required /></fieldset><fieldset><label>Last Name*</label><input name="last_name" type="text" value="" required /></fieldset><fieldset><label>Email Address*</label><input name="email_address" type="email" value="" required /></fieldset><fieldset><label>Password*</label><input name="password" type="password" value="" required/></fieldset><fieldset><label>Confirm Password*</label><input name="confirm_password" type="password" value="" required/></fieldset><fieldset><button>Signup</button><input type="hidden" name="action" value="process_signup"></fieldset></form>';
		}
		
		return $html;
	}

	/**
	 * shortcode
	 *
	 * @since   1.0.0
	 */
	public static function render_login($args){
		$currentUser = wp_get_current_user();
		
		if(isset($currentUser -> data -> ID)){
			$page = intval(get_option('page_for_account'));
			$html = $page ? '<script>document.location.href = \''.get_permalink($page).'\'</script>' : '<p>You are logged in as <strong style="color:#000;">'.$currentUser -> data -> display_name.'</strong><br /><form action="'.esc_url(admin_url('admin-post.php')).'" method="POST" onsubmit="return logout(this)" novalidate><button>Logout</button><input type="hidden" name="action" value="process_logout"></form></p>';
		}else{
			require_once __DIR__.'/../../vendor/autoload.php';

			//is FB login
			$fb = new \Facebook\Facebook(['app_id' => '792117054488333','app_secret' => 'bf55d30f2b1ef39a2cc615e34cecf820','default_graph_version' => 'v2.10',]);
			$fbHelper = $fb -> getRedirectLoginHelper();
            $fbLoginUrl = $fbHelper -> getLoginUrl('https://www.building-u.com/wp-content/themes/oceanwp/processors/auth.php',['email']);
			
			//google API
            $gClient = new \Google_Client();
            $gClient -> setAuthConfig(__DIR__.'/assets/credentials.json');
            $gClient -> setIncludeGrantedScopes(true);
            $gClient -> addScope('email');
            $gClient -> setRedirectUri('https://www.building-u.com/wp-content/themes/oceanwp/processors/auth.php');
            $googleLoginUrl = $gClient -> createAuthUrl();

            //redirect
            $redirect = isset($args['redirect']) ? $args['redirect'] : null;

			$html = $redirect ? '<div class="login-form"><ul class="social-login"><li><a href="'.$fbLoginUrl.'" onclick="setCookie(\'redirect\',\''.$redirect.'\',30)"><i class="fab fa-facebook-f"></i> Login with Facebook</a></li><li><a href="'.$googleLoginUrl.'" onclick="setCookie(\'redirect\',\''.$redirect.'\',30)"><i class="fab fa-google"></i> Login with Google</a></li></ul><p><b>or</b></p><form name="login" action="'.esc_url(admin_url('admin-post.php')).'" method="POST" onsubmit="return login_signup(this)" novalidate><fieldset><label>Email Address*</label><input name="email_address" type="email" value="" required /></fieldset><fieldset><label>Password*</label><input name="password" type="password" value="" required/></fieldset><fieldset><button>Login</button><input type="hidden" name="action" value="process_login"><a href="#" onclick="return forgotPasswordModal(this,\''.esc_url(admin_url('admin-post.php')).'\')">Forgot your password?</a><br /><a href="/signup/">Need To Register?</a></fieldset></form></div>' : '<div class="login-form"><ul class="social-login"><li><a href="'.$fbLoginUrl.'"><i class="fab fa-facebook-f"></i> Login with Facebook</a></li><li><a href="'.$googleLoginUrl.'"><i class="fab fa-google"></i> Login with Google</a></li></ul><p><b>or</b></p><form name="login" action="'.esc_url(admin_url('admin-post.php')).'" method="POST" onsubmit="return login_signup(this)" novalidate><fieldset><label>Email Address*</label><input name="email_address" type="email" value="" required /></fieldset><fieldset><label>Password*</label><input name="password" type="password" value="" required/></fieldset><fieldset><button>Login</button><input type="hidden" name="action" value="process_login"><a href="#" onclick="return forgotPasswordModal(this,\''.esc_url(admin_url('admin-post.php')).'\')">Forgot your password?</a><br /><a href="/signup/">Need To Register?</a></fieldset></form></div>';
		}
		
		return $html;
	}

	/**
	 * processor action
	 *
	 * @since   1.0.0
	 */
	public static function process_add_to_favourites(){
		global $wpdb;

		$postId = isset($_POST['id']) ? $_POST['id'] : null;
		$currentUser = wp_get_current_user();
		$response = ['success'=>false];

		if(isset($currentUser -> data -> ID) && $postId){
			$isFavourite = $wpdb -> get_results('SELECT * FROM '.$wpdb -> prefix.'favourites WHERE user='.$currentUser -> data -> ID.' AND post='.$postId.' LIMIT 1', OBJECT);

			if(!$isFavourite){
				$wpdb -> query($wpdb -> prepare('INSERT INTO '.$wpdb -> prefix.'favourites (user,post) VALUES (%d,%d)',$currentUser -> data -> ID,$postId));
			}else{
				$wpdb -> delete($wpdb -> prefix.'favourites',array('user'=>$currentUser -> data -> ID,'post'=>$postId));
			}
			$response['success'] = true;
		}else{
			$response['error'] = 'No user logged in!';
		}
		print(json_encode($response));
	}

	/**
	 * processor action
	 *
	 * @since   1.0.0
	 */
	public static function process_reset_password(){
		$postData = isset($_POST) ? $_POST : null;
		$response = ['success'=>true];

		if($postData){
			$requiredFields = ['login','key','password'];
			$validFields = true;

			foreach($requiredFields as $key => $value){
				if(!isset($postData[$value])){
					$validFields = false;
					break;
				}
			}

			if($validFields){
				$validKey = check_password_reset_key($postData['key'],$postData['login']);

				if(is_wp_error($validKey)){
	    			$response['error'] = $validate -> get_error_message();
				}else{
					$user = get_user_by('login',$postData['login']);

					wp_set_password($postData['password'],$user -> data -> ID);
					
					$response['success'] = true;
				}
			}else{
				$response['error'] = 'Invalid POST fields!';
			}
		}

		print(json_encode($response));
	}

	/**
	 * processor action
	 *
	 * @since   1.0.0
	 */
	public static function process_forgot_password(){
		$emailAddress = isset($_POST['email']) ? $_POST['email'] : null;
		$currentUser = wp_get_current_user();
		$response = ['success'=>true];

		if($emailAddress && email_exists($emailAddress)){
			$user = get_user_by('email',$emailAddress);
			$resetKey = get_password_reset_key($user);
			$link = 'https://www.building-u.com/forgot-password/?login='.$user -> user_login.'&key='.$resetKey;

			wp_mail($emailAddress,'Email reset','In order to reset your password, please click on the following link: <br /><br /><a href="'.esc_url_raw($link).'">'.$link.'</a>',array('Content-Type: text/html; charset=UTF-8'));
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * processor action
	 *
	 * @since   1.0.0
	 */
	public static function process_logout(){
		$currentUser = wp_get_current_user();
		$response = ['success'=>true];

		if(isset($currentUser -> data -> ID)){
			wp_logout();
		}

		print(json_encode($response));
		wp_die();
	}

	/**
	 * processor action
	 *
	 * @since   1.0.0
	 */
	public static function process_login(){
		$postData = isset($_POST) ? $_POST : null;
		$currentUser = wp_get_current_user();
		$response = ['success'=>false];

		if(!isset($currentUser -> data -> ID)){
			$requiredFields = ['email_address','password'];
			$validFields = true;
			$userData = [];

			foreach($requiredFields as $key => $value){
				if(isset($postData[$value])){
					$userData[$value] = $postData[$value];
				}else{
					$validFields = false;
					break;
				}
			}

			if($validFields){
				$login = wp_signon(array('user_password'=>$postData['password'],'user_login'=>$postData['email_address']),false);

				if(!isset($login -> errors)){
					$response['success'] = true;
				}else{
					$error = $login -> get_error_message();
				}
			}else{
				$error = $postData;
			}
		}

		if($error){
			$response['error'] = $error;
		}

		print(json_encode($response));
	}

	/**
	 * processor action
	 *
	 * @since   1.0.0
	 */
	public static function process_signup(){
		$postFields = isset($_POST) ? $_POST : null;
		$requiredFields = ['first_name','last_name','email_address','password','confirm_password'];
		$response = ['success'=>false];

		if($postFields){
			$validFields = true;
			$userData = [];

			foreach($requiredFields as $key => $value){
				if(!isset($postFields[$value])){
					$validFields = false;
					break;
				}
			}

			if($validFields){
				$userData['user_login'] = $postFields['email_address'];
				$userData['user_email'] = $postFields['email_address'];
				$userData['first_name'] = $postFields['first_name'];
				$userData['last_name'] = $postFields['last_name'];
				$userData['user_pass'] = $postFields['password'];
				$userData['user_password'] = $postFields['password'];
				$userData['role'] = 'student';

				$insertUser = wp_insert_user($userData);

				if(!isset($insertUser -> errors)){
					$login = wp_signon($userData,false);
					$response['success'] = true;
				}else{
					$error = $insertUser -> get_error_message();
				}
			}else{
				$error = 'Missing signup fields!';
			}
		}else{
			$error = 'Invalid POST data';
		}

		if($error){
			$response['error'] = $error;
		}

		print(json_encode($response));
	}

	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public static function custom_posts_register() {
		//////////////////////////////// Programs ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Programs'),
	        'singular_name' => __('Program'),
	        'add_new' => __('Add Program'),
	        'add_new_item' => __('Add New Program'),
	        'edit_item' => __('Edit Program'),
	        'new_item' => __('New Program'),
	        'view_item' => __('View Program'),
	        'search_items' => __('Search Programs'),
	        'not_found' => __('No Programs found'),
	        'not_found_in_trash' => __('No Programs found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Programs')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','editor','thumbnail'),
	        'has_archive' => true,
	        'rewrite' => array('slug'=>'programs', 'with_front' => false),
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-welcome-learn-more'
	    );

	    register_post_type('programs', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// Funding Programs ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Funding'),
	        'singular_name' => __('Funding'),
	        'add_new' => __('Add Funding'),
	        'add_new_item' => __('Add New Funding'),
	        'edit_item' => __('Edit Funding'),
	        'new_item' => __('New Funding'),
	        'view_item' => __('View Funding'),
	        'search_items' => __('Search Funding'),
	        'not_found' => __('No Funding found'),
	        'not_found_in_trash' => __('No Funding found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Funding')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','editor'),
	        'has_archive' => true,
	        'rewrite' => array('slug'=>'funding', 'with_front' => false),
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-thumbs-up'
	    );

	    register_post_type('funding', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// Opportunities Programs ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Opportunities'),
	        'singular_name' => __('Opportunity'),
	        'add_new' => __('Add Opportunity'),
	        'add_new_item' => __('Add New Opportunity'),
	        'edit_item' => __('Edit Opportunity'),
	        'new_item' => __('New Opportunity'),
	        'view_item' => __('View Opportunity'),
	        'search_items' => __('Search Opportunities'),
	        'not_found' => __('No Opportunities found'),
	        'not_found_in_trash' => __('No Opportunities found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Opportunities')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','editor'),
	        'has_archive' => true,
	        'rewrite' => array('slug'=>'opportunities', 'with_front' => false),
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-star-filled'
	    );

	    register_post_type('opportunities', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// U Might Like ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('U Might Like'),
	        'singular_name' => __('U Might Like'),
	        'add_new' => __('Add U Might Like'),
	        'add_new_item' => __('Add New U Might Like'),
	        'edit_item' => __('Edit U Might Like'),
	        'new_item' => __('New U Might Like'),
	        'view_item' => __('View U Might Like'),
	        'search_items' => __('Search U Might Like'),
	        'not_found' => __('No U Might Like found'),
	        'not_found_in_trash' => __('No U Might Like found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('U Might Like')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','thumbnail'),
	        'has_archive' => true,
	        'rewrite' => array('slug'=>'u-might-like', 'with_front' => false),
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-archive'
	    );

	    register_post_type('u-might-like', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// FAQs ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('FAQs'),
	        'singular_name' => __('FAQ'),
	        'add_new' => __('Add FAQ'),
	        'add_new_item' => __('Add FAQ'),
	        'edit_item' => __('Edit FAQ'),
	        'new_item' => __('New FAQ'),
	        'view_item' => __('View FAQ'),
	        'search_items' => __('Search FAQs'),
	        'not_found' => __('No FAQs found'),
	        'not_found_in_trash' => __('No FAQs found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('FAQs')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => false,
	        'publicly_queryable' => false,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','editor'),
	        'has_archive' => false,
	        'rewrite' => false,
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-editor-help'
	    );

	    register_post_type('faqs', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// Partners ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Partners'),
	        'singular_name' => __('Partner'),
	        'add_new' => __('Add Partner'),
	        'add_new_item' => __('Add Partner'),
	        'edit_item' => __('Edit Partner'),
	        'new_item' => __('New Partner'),
	        'view_item' => __('View Partner'),
	        'search_items' => __('Search Partners'),
	        'not_found' => __('No Partners found'),
	        'not_found_in_trash' => __('No Partners found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Partners')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => false,
	        'publicly_queryable' => false,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','thumbnail'),
	        'has_archive' => false,
	        'rewrite' => false,
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-awards'
	    );

	    register_post_type('partners', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// Team ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Team'),
	        'singular_name' => __('Team'),
	        'add_new' => __('Add Team'),
	        'add_new_item' => __('Add Team'),
	        'edit_item' => __('Edit Team'),
	        'new_item' => __('New Team'),
	        'view_item' => __('View Team'),
	        'search_items' => __('Search Team'),
	        'not_found' => __('No Team found'),
	        'not_found_in_trash' => __('No Team found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Team')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => false,
	        'publicly_queryable' => false,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','thumbnail'),
	        'has_archive' => false,
	        'rewrite' => false,
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-groups'
	    );

	    register_post_type('team', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// Leads ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Leads'),
	        'singular_name' => __('Lead'),
	        'add_new' => __('Add Lead'),
	        'add_new_item' => __('Add Lead'),
	        'edit_item' => __('Edit Lead'),
	        'new_item' => __('New Lead'),
	        'view_item' => __('View Leads'),
	        'search_items' => __('Search Leads'),
	        'not_found' => __('No Leads found'),
	        'not_found_in_trash' => __('No Leads found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Leads')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => false,
	        'publicly_queryable' => false,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title'),
	        'has_archive' => false,
	        'rewrite' => false,
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-clipboard'
	    );

	    register_post_type('leads', $news_args);
	    flush_rewrite_rules();

	    //////////////////////////////// Perspectives ////////////////////////////////////
	    $news_labels = array(
	        'name' => __('Perspectives'),
	        'singular_name' => __('Perspective'),
	        'add_new' => __('Add Perspective'),
	        'add_new_item' => __('Add Perspective'),
	        'edit_item' => __('Edit Perspective'),
	        'new_item' => __('New Perspective'),
	        'view_item' => __('View Perspective'),
	        'search_items' => __('Search Perspectives'),
	        'not_found' => __('No Perspectives found'),
	        'not_found_in_trash' => __('No Perspectives found in Trash'),
	        'parent_item_colon' => '',
	        'menu_name' => __('Perspectives')
	    );

	    $news_capabilities = array(
	        'edit_post' => 'edit_post',
	        'edit_posts' => 'edit_posts',
	        'edit_others_posts' => 'edit_others_posts',
	        'publish_posts' => 'publish_posts',
	        'read_post' => 'read_post',
	        'read_private_posts' => 'read_private_posts',
	        'delete_post' => 'delete_post'
	    );

	    $news_capabilitytype = 'post';
	    $news_mapmetacap = true;

	    $news_args = array(
	        'labels' => $news_labels,
	        'public' => false,
	        'publicly_queryable' => false,
	        'exclude_from_search' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'capability_type' => $news_capabilitytype,
	        'capabilities' => $news_capabilities,
	        'map_meta_cap' => $news_mapmetacap,
	        'hierarchical' => false,
	        'supports' => array('title','thumbnail'),
	        'has_archive' => false,
	        'rewrite' => false,
	        'query_var' => true,
	        'can_export' => true,
	        'show_in_nav_menus' => false,
	        'menu_icon' => 'dashicons-visibility'
	    );

	    register_post_type('perspectives', $news_args);
	    flush_rewrite_rules();

	    /* CustomType: BusinessForm*/
        $business_form_labels = array(
            'name' => __('Business Forms'),
            'singular_name' => __('Business Form'),
            'add_new' => __('Add Business Form'),
            'add_new_item' => __('Add Business Form'),
            'edit_item' => __('Edit Business Form'),
            'new_item' => __('New Business Form'),
            'view_item' => __('View Business Form'),
            'search_items' => __('Search Business Form'),
            'not_found' => __('No Business Forms found'),
            'not_found_in_trash' => __('No Business Forms found in Trash'),
            'parent_item_colon' => '',
            'menu_name' => __('Business Forms')
        );
        $business_form_capabilities = array(
            'edit_post' => 'edit_post',
            'edit_posts' => 'edit_posts',
            'edit_others_posts' => 'edit_others_posts',
            'publish_posts' => 'publish_posts',
            'read_post' => 'read_post',
            'read_private_posts' => 'read_private_posts',
            'delete_post' => 'delete_post'
        );
        $business_form_args = array(
            'labels'        => $business_form_labels,
            'capabilities' => $business_form_capabilities,
            'capability_type' => 'post',
            'description'   => 'Holds our business form records',
            'public'        => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'supports'      => array( 'custom_fields' ),
            'hierarchical' => false,
            'has_archive'   => false,
            'menu_icon' => 'dashicons-store',
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'show_in_rest' => false,
            'rewrite' => false,
            'query_var' => true,
            'can_export' => true,
            'show_in_nav_menus' => false,
            'delete_with_user' => false,
            'map_meta_cap' => true,
        );
        register_post_type( 'business_form', $business_form_args );
        flush_rewrite_rules();

        if(!post_type_exists('features')){
			/* Leads */
			$customPostArgs = array(
		        'labels' => array('name' => __('Features'),'singular_name' => __('Feature'),'add_new' => __('Add Feature'),'add_new_item' => __('Add New Feature'),'edit_item' => __('Edit Feature'),'new_item' => __('New Feature'),'view_item' => __('View Feature'),'search_items' => __('Search Features'),'not_found' => __('No Features found'),'not_found_in_trash' => __('No Features found in Trash'),'parent_item_colon' => '','menu_name' => __('Features')),
		        'public' => false,
		        'publicly_queryable' => false,
		        'exclude_from_search' => false,
		        'show_ui' => true,
		        'show_in_menu' => true,
		        'capability_type' => 'post',
		        'capabilities' => array('edit_post' => 'edit_post','edit_posts' => 'edit_posts','edit_others_posts' => 'edit_others_posts','publish_posts' => 'publish_posts','read_post' => 'read_post','read_private_posts' => 'read_private_posts','delete_post' => 'delete_post'),
		        'map_meta_cap' => true,
		        'hierarchical' => false,
		        'supports' => array('title','thumbnail'),
		        'has_archive' => false,
		        'rewrite' => false,
		        'query_var' => true,
		        'can_export' => true,
		        'show_in_nav_menus' => false,
		        'menu_icon' => 'dashicons-awards'
		    );

		    register_post_type('features',$customPostArgs);
		    flush_rewrite_rules();
		}

	    //taxonomies
	    register_taxonomy('perspective-type',array('perspectives'),array('label' => __('Type'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('locations',array('programs','opportunities'),array('label' => __('Locations'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('duration','programs',array('label' => __('Duration'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('cost','programs',array('label' => __('Cost'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('type',array('opportunities'),array('label' => __('Kinds'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('season','opportunities',array('label' => __('Season'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('school-eligibility','funding',array('label' => __('School Eligibility'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('financial-eligibility','funding',array('label' => __('Financial Eligibility'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('demographics','funding',array('label' => __('Designated Eligibility'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));	
		register_taxonomy('subjects','programs',array('label' => __('Subjects'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));	
		register_taxonomy('kinds',array('funding'),array('label' => __('Types'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));	
		register_taxonomy('timeframe','opportunities',array('label' => __('Time frame'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));	
		register_taxonomy('student-types',array('funding'),array('label' => __('Student Types'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true)); 
		register_taxonomy('lead-type',array('leads'),array('label' => __('Type'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('resource_type',array('programs','opportunities','funding'),array('label' => __('Type'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>false));
		register_taxonomy('universities',array('team'),array('label' => __('Universities'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>false));
		register_taxonomy('team-type',array('team'),array('label' => __('Type'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('features-type',array('features'),array('label' => __('Features'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));

		//resource taxonomies
		register_taxonomy('topics',array('programs','opportunities','funding'),array('label' => __('Topics'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));
		register_taxonomy('levelts',array('programs','opportunities','funding'),array('label' => __('Levels'),'hierarchical' => true,'with_front' => false,'show_admin_column'=>true));	

		// register tax custom fields 
		add_action('resource_type_edit_form_fields',function($term){

			$image = get_term_meta($term->term_id,'taxonomy_icon',true);

			$html = $image ? '<tr class="form-field image"> <th scope="row" valign="top"><label>Category Icon</label></th><td><span style="background:url(\''.$image.'\') no-repeat center center/contain #FFF;"></span><a href="" onclick="return selectImage(this)">Select Image</a><input type="hidden" name="taxonomy_icon" size="25" style="width:60%;" value="'.$image.'"></td></tr>' : '<tr class="form-field image"> <th scope="row" valign="top"><label>Category Icon</label></th><td><span></span><a href="" onclick="return selectImage(this)">Select Image</a><input type="hidden" name="taxonomy_icon" size="25" style="width:60%;" value=""></td></tr>';
			wp_enqueue_media();
		    print($html);
		},10,2);

		// register tax save custom fields
		add_action('edited_resource_type',function($term_id){
			$validTermKeys = ['taxonomy_icon'];

		    if(isset($_POST)){  
		        foreach($validTermKeys as $key){
		            if(isset($_POST[$key])){
		                update_term_meta($term_id,$key,$_POST[$key]);
		            }
		        }
		    } 

		}, 10, 2 );

		// register tax custom fields 
		add_action('student-types_edit_form_fields',function($term){

			$html = '<tr class="form-field"> <th scope="row" valign="top"><label>Label</label></th><td><input type="text" name="_taxonomy_label" size="25" style="width:60%;" value="'.get_term_meta($term->term_id,'_taxonomy_label',true).'"></td></tr>';

		    print($html);
		},10,2);  
		
		// register tax save custom fields
		add_action('edited_student-types',function($term_id){
			$validTermKeys = ['_taxonomy_label'];

		    if(isset($_POST)){  
		        foreach($validTermKeys as $key){
		            if(isset($_POST[$key])){
		                update_term_meta($term_id,$key,$_POST[$key]);
		            }
		        }
		    } 

		}, 10, 2 );

		// register tax custom fields 
		add_action('timeframe_edit_form_fields',function($term){

			$html = '<tr class="form-field"> <th scope="row" valign="top"><label>Label</label></th><td><input type="text" name="_taxonomy_label" size="25" style="width:60%;" value="'.get_term_meta($term->term_id,'_taxonomy_label',true).'"></td></tr>';

		    print($html);
		},10,2);  
		
		// register tax save custom fields
		add_action('edited_timeframe',function($term_id){
			$validTermKeys = ['_taxonomy_label'];

		    if(isset($_POST)){  
		        foreach($validTermKeys as $key){
		            if(isset($_POST[$key])){
		                update_term_meta($term_id,$key,$_POST[$key]);
		            }
		        }
		    } 
		    
		}, 10, 2 );

        // business_form admin columns headers
        add_filter('manage_business_form_posts_columns', function($columns) {
            $columns = [
                'cb' => $columns['cb'],
                'first_name' => __('First Name'),
                'last_name' => __('Last Name'),
                'business_name' => __('Business Name'),
                'status' => __('Status'),
                'date' => __( 'Date' )
            ];
            return $columns;
        });

        // business_form admin columns data
        add_action('manage_business_form_posts_custom_column', function($column, $post_id) {
           switch ($column) {
               case "first_name":
                   echo get_post_meta($post_id, 'first_name',true);
                   break;
               case "last_name":
                   echo get_post_meta($post_id, 'last_name',true);
                   break;
               case "business_name":
                   echo get_post_meta($post_id, 'business_name',true);
                   break;
               case "status":
                   echo get_post_meta($post_id, 'status',true);
                   break;
               default:
                   break;
           }
        }, 10, 2);
	}

	/**
	 * Custom Post Meta Boxes
	 *
	 * @since   1.0.0
	 */
	public static function add_menu_pages(){
		/*add_submenu_page('edit.php?post_type=u-might-like','U Might Like Banner Content','Banner Content','manage_options','u-might-like-banner-content',function(){
	    	include_once(__DIR__.'/templates/u-might-like-banner.php');
	    });*/

	    add_submenu_page('edit.php?post_type=perspectives','Perspectives Posts','Perspectives Posts','manage_options','perspectives-posts',function(){
	    	include_once(__DIR__.'/templates/perspectives-posts.php');
	    });

	    add_submenu_page('edit.php?post_type=u-might-like','U Might Like Featured Content','Featured Content','manage_options','u-might-like-featured-content',function(){
	    	include_once(__DIR__.'/templates/featured-content.php');
	    });
	}

	/**
	 * Custom Post Meta Boxes
	 *
	 * @since   1.0.0
	 */
	public static function custom_meta_boxes_register(){
		global $post;

		$mightLikePage = get_option('page_might_like');

		$templateMatrix = ['favourites.php'];
		$template = basename(get_page_template());
		$metaBox = $post -> post_type === 'page' && $post -> ID !== $mightLikePage ? __DIR__.'/templates/metabox/'.$template : __DIR__.'/templates/metabox/'.$post -> post_type.'.php';
		
		if(in_array($template,$templateMatrix)){
			remove_post_type_support('page','elementor');
			remove_post_type_support('page','editor');
			remove_meta_box('butterbean-ui-oceanwp_mb_settings','page','normal');
			remove_meta_box('revisionsdiv','page','normal');
			remove_meta_box('commentsdiv','page','normal');
		}
		
		if(file_exists($metaBox)){
			if($template !== 'donate.php'){
				remove_post_type_support('page','elementor');
				remove_post_type_support('page','editor');
			}
			
			remove_meta_box('butterbean-ui-oceanwp_mb_settings','page','normal');
			remove_meta_box('revisionsdiv','page','normal');
			remove_meta_box('commentsdiv','page','normal');

			add_meta_box('custom-fields-page',__('Custom Fields'),function($args,$callback){
				global $post;

				include_once($callback['args']['metabox_file']);
			},array($postType),'normal','core',array('metabox_file'=>$metaBox));
		}

		if($post -> post_type === 'leads'){
			add_meta_box('custom-fields-leads',__('Details'),function(){
		        global $post;

		        $terms = wp_get_post_terms($post -> ID,'lead-type');

		        foreach($terms as $key => $term){
		            $file = __DIR__.'/forms/metabox/'.$term -> slug.'.php';
		            
		            if(file_exists($file)){
		                include_once($file);
		                break;
		            }
		        }
		    },array('leads'),'normal','high');
		}

		add_meta_box('custom-fields-programs',__('Details'),function(){
			global $post;
			
			include_once(__DIR__.'/templates/metabox/custom-fields.php');
		},array('funding','opportunities','programs'),'normal','high');

		add_meta_box('custom-fields-post',__('Author'),function(){
			global $post;
			
			include_once(__DIR__.'/templates/metabox/author-field.php');
		},array('post'),'normal','high');

		add_meta_box('custom-fields-secondary-image',__('Badge'),function(){
	        global $post;

	        include_once(__DIR__.'/templates/metabox/secondary-image.php');
	    },array('perspectives'),'side','low');
	}

	/**
	 * Save custom Post Fields
	 *
	 * @since   1.0.0
	 */
	public static function custom_save_fields($id){
		$postType = get_post_type($id);
		$saveDataFile = $postType === 'page' ? basename(get_page_template_slug($id)) : $postType.'.php';
		$postInclude = $saveDataFile ? __DIR__.'/templates/metabox/post/'.$saveDataFile : null;
		$postData = isset($_POST) ? $_POST : null;

		if($postType === 'funding' || $postType === 'programs' || $postType === 'opportunities'){
			$postInclude = __DIR__.'/templates/metabox/post/custom-fields.php';
		}

		if($postType === 'post'){
			$postInclude = __DIR__.'/templates/metabox/post/author-fields.php';
		}

		if($postData && file_exists($postInclude)){
			include_once($postInclude);
		}
	}	

	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public static function theme_setup() {

		// Load text domain
		load_theme_textdomain( 'oceanwp', OCEANWP_THEME_DIR .'/languages' );

		// Get globals
		global $content_width;

		// Set content width based on theme's default design
		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}

		// Register navigation menus
		register_nav_menus( array(
			'topbar_menu'     => esc_html__( 'Top Bar', 'oceanwp' ),
			'main_menu'       => esc_html__( 'Main', 'oceanwp' ),
			'footer_menu'     => esc_html__( 'Footer', 'oceanwp' ),
			'mobile_menu'     => esc_html__( 'Mobile (optional)', 'oceanwp' )
		) );

		// Adding Gutenberg support
		add_theme_support( 'gutenberg', array( 'wide-images' => true ) );

		// Enable support for Post Formats
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );

		// Enable support for <title> tag
		add_theme_support( 'title-tag' );

		// Add default posts and comments RSS feed links to head
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails on posts and pages
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for header image
		 */
		add_theme_support( 'custom-header', apply_filters( 'ocean_custom_header_args', array(
			'width'              => 2000,
			'height'             => 1200,
			'flex-height'        => true,
			'video'              => true,
		) ) );

		/**
		 * Enable support for site logo
		 */
		add_theme_support( 'custom-logo', apply_filters( 'ocean_custom_logo_args', array(
			'height'      => 45,
			'width'       => 164,
			'flex-height' => true,
			'flex-width'  => true,
		) ) );

		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'widgets',
		) );

		// Declare WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add editor style
		add_editor_style( 'assets/css/editor-style.min.css' );

		// Declare support for selective refreshing of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.1.0
	 */
	public static function pingback_header() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}

	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.0.0
	 */
	public static function meta_viewport() {

		// Meta viewport
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';

		// Apply filters for child theme tweaking
		echo apply_filters( 'ocean_meta_viewport', $viewport );

	}

	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_scripts() {
		global $pagenow;
		if ( 'nav-menus.php' == $pagenow ) {
			wp_enqueue_style( 'oceanwp-menus', OCEANWP_INC_DIR_URI .'walker/assets/menus.css' );
		}

		$directory = get_template_directory();
	    $directoryUrl = get_template_directory_uri();
	    $customCss = '/assets/css/admin.css';
	    $customJs = '/assets/js/admin.js';
	    
	    if(file_exists($directory.$customCss)){
	    	wp_enqueue_style('oceanwp-style-admin-custom',$directoryUrl.$customCss.'?v='.filemtime($directory.$customCss),array(),null,'all');
	    }

	    if(file_exists($directory.$customJs)){
	    	wp_enqueue_style('oceanwp-style-admin-custom',$directoryUrl.$customCss.'?v='.filemtime($directory.$customCss),array(),null,'all');
	    	wp_enqueue_script( 'custom-admin-js',$directoryUrl.$customJs.'?v='.filemtime($directory.$customJs), array( 'jquery' ), null, true );
	    }

	}

	/**
	 * Load front-end scripts
	 *
	 * @since   1.0.0
	 */
	public static function theme_css() {
		global $wp;
    $uri = '/' . add_query_arg(array(), $wp->request);

    // Common CSS
    wp_enqueue_style( 'oceanwp-style', OCEANWP_CSS_DIR_URI .'style.min.css', false, OCEANWP_THEME_VERSION );
    wp_enqueue_style( 'building-u', OCEANWP_CSS_DIR_URI .'building-u.css', false, OCEANWP_THEME_VERSION );

		switch ($uri) {
			case '/' :
					wp_enqueue_style( 'homepage', OCEANWP_CSS_DIR_URI .'/pages/homepage.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/u-crew':
					wp_enqueue_style( 'u-crew', OCEANWP_CSS_DIR_URI .'/pages/u-crew.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/contribute':
					wp_enqueue_style( 'contribute', OCEANWP_CSS_DIR_URI .'/pages/contribute.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/profile':
					wp_enqueue_style( 'profile', OCEANWP_CSS_DIR_URI .'/pages/profile.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/resources':	
					wp_enqueue_style( 'resources', OCEANWP_CSS_DIR_URI .'/pages/resources.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/partners':
					wp_enqueue_style( 'partners', OCEANWP_CSS_DIR_URI .'/pages/partners.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/blog':
					wp_enqueue_style( 'blog', OCEANWP_CSS_DIR_URI .'/pages/blog.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/programs':
					wp_enqueue_style( 'resources-template', OCEANWP_CSS_DIR_URI .'/resources-template.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'programs', OCEANWP_CSS_DIR_URI .'/pages/programs.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/funding':
					wp_enqueue_style( 'resources-template', OCEANWP_CSS_DIR_URI .'/resources-template.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'funding', OCEANWP_CSS_DIR_URI .'/pages/funding.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/opportunities':
					wp_enqueue_style( 'resources-template', OCEANWP_CSS_DIR_URI .'/resources-template.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'opportunities', OCEANWP_CSS_DIR_URI .'/pages/opportunities.css', false, OCEANWP_THEME_VERSION );
					break;
			case '/u-might-like':
				wp_enqueue_style( 'u-might-like', OCEANWP_CSS_DIR_URI .'/pages/u-might-like.css', false, OCEANWP_THEME_VERSION );
				break;
			case '/u-might-like-some-more-information':
				wp_enqueue_style( 'u-might-like-some-more-information', OCEANWP_CSS_DIR_URI .'/pages/u-might-like-some-more-information.css', false, OCEANWP_THEME_VERSION );
				break;
			case '/my-account':
				wp_enqueue_style( 'my-account', OCEANWP_CSS_DIR_URI .'/pages/my-account.css', false, OCEANWP_THEME_VERSION );
				break;
			case '/event':
				wp_enqueue_style( 'event', OCEANWP_CSS_DIR_URI .'/pages/event.css', false, OCEANWP_THEME_VERSION );
				break;
            case '/business-registration':
                wp_enqueue_style( 'business-registration', OCEANWP_CSS_DIR_URI .'/pages/business-registration.css', false, OCEANWP_THEME_VERSION );
                break;
			case (preg_match('/opportunities\/[az]*/i', $uri) == 1):
					wp_enqueue_style( 'single-resource', OCEANWP_CSS_DIR_URI .'/single-resource.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'opportunity-single', OCEANWP_CSS_DIR_URI .'/pages/opportunity-single.css', false, OCEANWP_THEME_VERSION );
					break;
			case (preg_match('/funding\/[az]*/i', $uri) == 1):
					wp_enqueue_style( 'single-resource', OCEANWP_CSS_DIR_URI .'/single-resource.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'funding-single', OCEANWP_CSS_DIR_URI .'/pages/funding-single.css', false, OCEANWP_THEME_VERSION );
					break;
			case (preg_match('/programs\/[az]*/i', $uri) == 1):
					wp_enqueue_style( 'single-resource', OCEANWP_CSS_DIR_URI .'/single-resource.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'program-single', OCEANWP_CSS_DIR_URI .'/pages/program-single.css', false, OCEANWP_THEME_VERSION );
					break;
			case (preg_match('/blog\/[az]*/i', $uri) == 1):
					wp_enqueue_style( 'blog', OCEANWP_CSS_DIR_URI .'/pages/blog.css', false, OCEANWP_THEME_VERSION );
					wp_enqueue_style( 'blog-single', OCEANWP_CSS_DIR_URI .'/pages/blog-single.css', false, OCEANWP_THEME_VERSION );
					break;
			default:
					break;
		}
	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.0.0
	 */
	public static function theme_js() {

		// Get js directory uri
		$dir = OCEANWP_JS_DIR_URI;

		// Get current theme version
		$theme_version = OCEANWP_THEME_VERSION;

		// Get localized array
		$localize_array = self::localize_array();

		// Comment reply
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Add images loaded
		wp_enqueue_script( 'imagesloaded' );

		// Register nicescroll script to use it in some extensions
		wp_register_script( 'nicescroll', $dir .'third/nicescroll.min.js', array( 'jquery' ), $theme_version, true );

		// Enqueue nicescroll script if vertical header style
		if ( 'vertical' == oceanwp_header_style() ) {
			wp_enqueue_script( 'nicescroll' );
		}

		// Register Infinite Scroll script
		wp_register_script( 'infinitescroll', $dir .'third/infinitescroll.min.js', array( 'jquery' ), $theme_version, true );

		// WooCommerce scripts
		if ( OCEANWP_WOOCOMMERCE_ACTIVE ) {
			wp_enqueue_script( 'oceanwp-woocommerce', $dir .'third/woo/woo-scripts.min.js', array( 'jquery' ), $theme_version, true );
		}

		// Load the lightbox scripts
		wp_enqueue_script( 'magnific-popup', $dir .'third/magnific-popup.min.js', array( 'jquery' ), $theme_version, true );
		wp_enqueue_script( 'oceanwp-lightbox', $dir .'third/lightbox.min.js', array( 'jquery' ), $theme_version, true );

		// Load minified js
		wp_enqueue_script( 'oceanwp-main', $dir .'main.min.js', array( 'jquery' ), $theme_version, true );

		// Load minified js
		//wp_enqueue_script( 'oceanwp-custom-js', $dir .'custom.js', array( 'jquery' ), $theme_version, true );
		
		// Localize array
		wp_localize_script( 'oceanwp-main', 'oceanwpLocalize', $localize_array );

		$directory = get_template_directory();
	    $directoryUrl = get_template_directory_uri();
	    $scripts = '/assets/js/custom.js';
	   
	    if(file_exists($directory.$scripts)){
	    	$mobileJL = '/assets/css/mobilejl.css';

	    	wp_enqueue_script('oceanwp-custom-js-scripts',$directoryUrl.$scripts.'?v='.filemtime($directory.$scripts),array(),null,true);

	    	wp_enqueue_style('mobile-style-jl',$directoryUrl.$mobileJL.'?v='.filemtime($directory.$mobileJL),array(),null,'all');
	    }

        global $wp;
        $uri = '/' . add_query_arg(array(), $wp->request);

        switch ($uri) {
            case '/business-registration' :
                wp_enqueue_script('business-registration', OCEANWP_JS_DIR_URI . '/pages/business-registration.js', false, OCEANWP_THEME_VERSION);
                break;
            case '/contribute' :
                wp_enqueue_script('contribute', OCEANWP_JS_DIR_URI . '/pages/contribute.js', false, OCEANWP_THEME_VERSION);
                break;
            default:
                break;
        }
	}

	/**
	 * Functions.js localize array
	 *
	 * @since 1.0.0
	 */
	public static function localize_array() {

		// Create array
		$sidr_side 		= get_theme_mod( 'ocean_mobile_menu_sidr_direction', 'left' );
		$sidr_side 		= $sidr_side ? $sidr_side : 'left';
		$sidr_target 	= get_theme_mod( 'ocean_mobile_menu_sidr_dropdown_target', 'icon' );
		$sidr_target 	= $sidr_target ? $sidr_target : 'icon';
		$vh_target 		= get_theme_mod( 'ocean_vertical_header_dropdown_target', 'icon' );
		$vh_target 		= $vh_target ? $vh_target : 'icon';
		$array = array(
			'isRTL'                 => is_rtl(),
			'menuSearchStyle'       => oceanwp_menu_search_style(),
			'sidrSource'       		=> oceanwp_sidr_menu_source(),
			'sidrDisplace'       	=> get_theme_mod( 'ocean_mobile_menu_sidr_displace', true ) ? true : false,
			'sidrSide'       		=> $sidr_side,
			'sidrDropdownTarget'    => $sidr_target,
			'verticalHeaderTarget'  => $vh_target,
			'customSelects'         => '.woocommerce-ordering .orderby, #dropdown_product_cat, .widget_categories select, .widget_archive select, .single-product .variations_form .variations select',
		);

		// WooCart
		if ( OCEANWP_WOOCOMMERCE_ACTIVE ) {
			$array['wooCartStyle'] 	= oceanwp_menu_cart_style();
		}

		// Apply filters and return array
		return apply_filters( 'ocean_localize_array', $array );
	}

	/**
	 * Add headers for IE to override IE's Compatibility View Settings
	 *
	 * @since 1.0.0
	 */
	public static function x_ua_compatible_headers( $headers ) {
		$headers['X-UA-Compatible'] = 'IE=edge';
		return $headers;
	}

	/**
	 * Load HTML5 dependencies for IE8
	 *
	 * @since 1.0.0
	 */
	public static function html5_shiv() {
		wp_register_script( 'html5shiv', OCEANWP_JS_DIR_URI . '/third/html5.min.js', array(), OCEANWP_THEME_VERSION, false );
		wp_enqueue_script( 'html5shiv' );
		wp_script_add_data( 'html5shiv', 'conditional', 'lt IE 9' );
	}

	/**
	 * Registers sidebars
	 *
	 * @since   1.0.0
	 */
	public static function register_sidebars() {

		// Default Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Default Sidebar', 'oceanwp' ),
			'id'			=> 'sidebar',
			'description'	=> esc_html__( 'Widgets in this area will be displayed in the left or right sidebar area if you choose the Left or Right Sidebar layout.', 'oceanwp' ),
			'before_widget'	=> '<div id="%1$s" class="sidebar-box %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>',
		) );

		// Left Sidebar
		register_sidebar( array(
			'name'			=> esc_html__( 'Left Sidebar', 'oceanwp' ),
			'id'			=> 'sidebar-2',
			'description'	=> esc_html__( 'Widgets in this area are used in the left sidebar region if you use the Both Sidebars layout.', 'oceanwp' ),
			'before_widget'	=> '<div id="%1$s" class="sidebar-box %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>',
		) );

		// Search Results Sidebar
		if ( get_theme_mod( 'ocean_search_custom_sidebar', true ) ) {
			register_sidebar( array(
				'name'			=> esc_html__( 'Search Results Sidebar', 'oceanwp' ),
				'id'			=> 'search_sidebar',
				'description'	=> esc_html__( 'Widgets in this area are used in the search result page.', 'oceanwp' ),
				'before_widget'	=> '<div id="%1$s" class="sidebar-box %2$s clr">',
				'after_widget'	=> '</div>',
				'before_title'	=> '<h4 class="widget-title">',
				'after_title'	=> '</h4>',
			) );
		}

		// Footer 1
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 1', 'oceanwp' ),
			'id'			=> 'footer-one',
			'description'	=> esc_html__( 'Widgets in this area are used in the first footer region.', 'oceanwp' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>',
		) );

		// Footer 2
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 2', 'oceanwp' ),
			'id'			=> 'footer-two',
			'description'	=> esc_html__( 'Widgets in this area are used in the second footer region.', 'oceanwp' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>',
		) );

		// Footer 3
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 3', 'oceanwp' ),
			'id'			=> 'footer-three',
			'description'	=> esc_html__( 'Widgets in this area are used in the third footer region.', 'oceanwp' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>',
		) );

		// Footer 4
		register_sidebar( array(
			'name'			=> esc_html__( 'Footer 4', 'oceanwp' ),
			'id'			=> 'footer-four',
			'description'	=> esc_html__( 'Widgets in this area are used in the fourth footer region.', 'oceanwp' ),
			'before_widget'	=> '<div id="%1$s" class="footer-widget %2$s clr">',
			'after_widget'	=> '</div>',
			'before_title'	=> '<h4 class="widget-title">',
			'after_title'	=> '</h4>',
		) );

	}

	/**
	 * Registers theme_mod strings into Polylang.
	 *
	 * @since 1.1.4
	 */
	public static function polylang_register_string() {

		if ( function_exists( 'pll_register_string' ) && $strings = oceanwp_register_tm_strings() ) {
			foreach( $strings as $string => $default ) {
				pll_register_string( $string, get_theme_mod( $string, $default ), 'Theme Mod', true );
			}
		}

	}

	/**
	 * All theme functions hook into the oceanwp_head_css filter for this function.
	 *
	 * @since 1.0.0
	 */
	public static function custom_css( $output = NULL ) {
			    
	    // Add filter for adding custom css via other functions
		$output = apply_filters( 'ocean_head_css', $output );

		// If Custom File is selected
		if ( 'file' == get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {

			global $wp_customize;
			$upload_dir = wp_upload_dir();

			// Render CSS in the head
			if ( isset( $wp_customize ) || ! file_exists( $upload_dir['basedir'] .'/oceanwp/custom-style.css' ) ) {

				 // Minify and output CSS in the wp_head
				if ( ! empty( $output ) ) {
					echo "<!-- OceanWP CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( oceanwp_minify_css( $output ) ) . "\n</style>";
				}
			}

		} else {

			// Minify and output CSS in the wp_head
			if ( ! empty( $output ) ) {
				echo "<!-- OceanWP CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( oceanwp_minify_css( $output ) ) . "\n</style>";
			}

		}

	}

	/**
	 * Minify the WP custom CSS because WordPress doesn't do it by default.
	 *
	 * @since 1.1.9
	 */
	public static function minify_custom_css( $css ) {

		return oceanwp_minify_css( $css );

	}

	/**
	 * Save Customizer CSS in a file
	 *
	 * @since 1.4.12
	 */
	public static function save_customizer_css_in_file( $output = NULL ) {

		// If Custom File is not selected
		if ( 'file' != get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {
			return;
		}

		// Get all the customier css
	    $output = apply_filters( 'ocean_head_css', $output );

	    // Get Custom Panel CSS
	    $output_custom_css = wp_get_custom_css();

	    // Minified the Custom CSS
		$output .= oceanwp_minify_css( $output_custom_css );
			
		// We will probably need to load this file
		require_once( ABSPATH . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'file.php' );
		
		global $wp_filesystem;
		$upload_dir = wp_upload_dir(); // Grab uploads folder array
		$dir = trailingslashit( $upload_dir['basedir'] ) . 'oceanwp'. DIRECTORY_SEPARATOR; // Set storage directory path

		WP_Filesystem(); // Initial WP file system
		$wp_filesystem->mkdir( $dir ); // Make a new folder 'oceanwp' for storing our file if not created already.
		$wp_filesystem->put_contents( $dir . 'custom-style.css', $output, 0644 ); // Store in the file.

	}

	/**
	 * Include Custom CSS file if present.
	 *
	 * @since 1.4.12
	 */
	public static function custom_style_css( $output = NULL ) {

		// If Custom File is not selected
		if ( 'file' != get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {
			return;
		}

		global $wp_customize;
		$upload_dir = wp_upload_dir();

		// Get all the customier css
	    $output = apply_filters( 'ocean_head_css', $output );

	    // Get Custom Panel CSS
	    $output_custom_css = wp_get_custom_css();

	    // Minified the Custom CSS
		$output .= oceanwp_minify_css( $output_custom_css );

		// Render CSS from the custom file
		if ( ! isset( $wp_customize ) && file_exists( $upload_dir['basedir'] .'/oceanwp/custom-style.css' ) && ! empty( $output ) ) { 
		    wp_enqueue_style( 'oceanwp-custom', trailingslashit( $upload_dir['baseurl'] ) . 'oceanwp/custom-style.css', false, null );	    			
		}		
	}

	/**
	 * Remove Customizer style script from front-end
	 *
	 * @since 1.4.12
	 */
	public static function remove_customizer_custom_css() {

		// If Custom File is not selected
		if ( 'file' != get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {
			return;
		}
		
		global $wp_customize;

		// Disable Custom CSS in the frontend head
		remove_action( 'wp_head', 'wp_custom_css_cb', 11 );
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		// If custom CSS file exists and NOT in customizer screen
		if ( isset( $wp_customize ) ) {
			add_action( 'wp_footer', 'wp_custom_css_cb', 9999 );
		}
	}

	/**
	 * Adds inline CSS for the admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_inline_css() {
		echo '<style>div#setting-error-tgmpa{display:block;}</style>';
	}


	/**
	 * Alter the search posts per page
	 *
	 * @since 1.3.7
	 */
	public static function search_posts_per_page( $query ) {
		$posts_per_page = get_theme_mod( 'ocean_search_post_per_page', '8' );
		$posts_per_page = $posts_per_page ? $posts_per_page : '8';

		if ( $query->is_main_query() && is_search() ) {
			$query->set( 'posts_per_page', $posts_per_page );
		}
	}

	/**
	 * Alters the default WordPress tag cloud widget arguments.
	 * Makes sure all font sizes for the cloud widget are set to 1em.
	 *
	 * @since 1.0.0 
	 */
	public static function widget_tag_cloud_args( $args ) {
		$args['largest']  = '0.923em';
		$args['smallest'] = '0.923em';
		$args['unit']     = 'em';
		return $args;
	}

	/**
	 * Alter wp list categories arguments.
	 * Adds a span around the counter for easier styling.
	 *
	 * @since 1.0.0
	 */
	public static function wp_list_categories_args( $links ) {
		$links = str_replace( '</a> (', '</a> <span class="cat-count-span">(', $links );
		$links = str_replace( ' )', ' )</span>', $links );
		return $links;
	}

	/**
	 * Alters the default oembed output.
	 * Adds special classes for responsive oembeds via CSS.
	 *
	 * @since 1.0.0
	 */
	public static function add_responsive_wrap_to_oembeds( $cache, $url, $attr, $post_ID ) {

		// Supported video embeds
		$hosts = apply_filters( 'ocean_oembed_responsive_hosts', array(
			'vimeo.com',
			'youtube.com',
			'blip.tv',
			'money.cnn.com',
			'dailymotion.com',
			'flickr.com',
			'hulu.com',
			'kickstarter.com',
			'vine.co',
			'soundcloud.com',
			'#http://((m|www)\.)?youtube\.com/watch.*#i',
	        '#https://((m|www)\.)?youtube\.com/watch.*#i',
	        '#http://((m|www)\.)?youtube\.com/playlist.*#i',
	        '#https://((m|www)\.)?youtube\.com/playlist.*#i',
	        '#http://youtu\.be/.*#i',
	        '#https://youtu\.be/.*#i',
	        '#https?://(.+\.)?vimeo\.com/.*#i',
	        '#https?://(www\.)?dailymotion\.com/.*#i',
	        '#https?://dai\.ly/*#i',
	        '#https?://(www\.)?hulu\.com/watch/.*#i',
	        '#https?://wordpress\.tv/.*#i',
	        '#https?://(www\.)?funnyordie\.com/videos/.*#i',
	        '#https?://vine\.co/v/.*#i',
	        '#https?://(www\.)?collegehumor\.com/video/.*#i',
	        '#https?://(www\.|embed\.)?ted\.com/talks/.*#i'
		) );

		// Supports responsive
		$supports_responsive = false;

		// Check if responsive wrap should be added
		foreach( $hosts as $host ) {
			if ( strpos( $url, $host ) !== false ) {
				$supports_responsive = true;
				break; // no need to loop further
			}
		}

		// Output code
		if ( $supports_responsive ) {
			return '<p class="responsive-video-wrap clr">' . $cache . '</p>';
		} else {
			return '<div class="oceanwp-oembed-wrap clr">' . $cache . '</div>';
		}

	}

	/**
	 * Adds extra classes to the post_class() output
	 *
	 * @since 1.0.0
	 */
	public static function post_class( $classes ) {

		// Get post
		global $post;

		// Add entry class
		$classes[] = 'entry';

		// Add has media class
		if ( has_post_thumbnail()
			|| get_post_meta( $post->ID, 'ocean_post_oembed', true )
			|| get_post_meta( $post->ID, 'ocean_post_self_hosted_media', true )
			|| get_post_meta( $post->ID, 'ocean_post_video_embed', true )
		) {
			$classes[] = 'has-media';
		}

		// Return classes
		return $classes;

	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 1.0.0
	 */
	public static function the_author_posts_link( $link ) {

		// Add schema markup
		$schema = oceanwp_get_schema_markup( 'author_link' );
		if ( $schema ) {
			$link = str_replace( 'rel="author"', 'rel="author" '. $schema, $link );
		}

		// Return link
		return $link;

	}

	/**
	 * Add support for Elementor Pro locations
	 *
	 * @since 1.5.6
	 */
	public static function register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_all_core_location();
	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 1.1.5
	 */
	public static function remove_bb_lightbox() {
		return true;
	}

	/**
	 * Get meta tags
	 *
	 * @since 1.5.6
	 */
	public static function opengraph_tag( $attr, $property, $content ) {
		echo '<meta ', esc_attr( $attr ), '="', esc_attr( $property ), '" content="', esc_attr( $content ), '" />', "\n";
	}

	/**
	 * Add meta tags
	 *
	 * @since 1.5.6
	 */
	public static function meta_tags() {

		// Return if disabled or if Yoast SEO enabled as they have their own meta tags
		if ( false == get_theme_mod( 'ocean_open_graph', false )
			|| defined( 'WPSEO_VERSION' ) ) {
			return;
		}

		// Facebook URL
		$facebook_url = get_theme_mod( 'ocean_facebook_page_url' );

		// Disable Jetpack's Open Graph tags
		add_filter( 'jetpack_enable_opengraph', '__return_false', 99 );
		add_filter( 'jetpack_enable_open_graph', '__return_false', 99 );
		add_filter( 'jetpack_disable_twitter_cards', '__return_true', 99 );

		// Type
		if ( is_front_page() || is_home() ) {
			$type = 'website';
		} else if ( is_singular() ) {
			$type = 'article';
		} else {
			// We use "object" for archives etc. as article doesn't apply there.
			$type = 'object';
		}

		// Title
		if ( is_singular() ) {
			$title = get_the_title();
		} else {
			$title = oceanwp_title();
		}

		// Description
		if ( is_category() || is_tag() || is_tax() ) {
			$description = strip_shortcodes( wp_strip_all_tags( term_description() ) );
		} else {
			$description = html_entity_decode( htmlspecialchars_decode( oceanwp_excerpt( 40 ) ) );
		}

		// Image
		$image = '';
		$has_img = false;
		if ( OCEANWP_WOOCOMMERCE_ACTIVE
			&& is_product_category() ) {
		    global $wp_query;
		    $cat = $wp_query->get_queried_object();
		    $thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
		    $get_image = wp_get_attachment_url( $thumbnail_id );
		    if ( $get_image ) {
				$image = $get_image;
				$has_img = true;
			}
		} else {
			$get_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
			$image = $get_image[0];
			$has_img = true;
		}

		// Post author
		if ( $facebook_url ) {
			$author = $facebook_url;
		}

		// Facebook publisher URL
		if ( ! empty( $facebook_url ) ) {
			$publisher = $facebook_url;
		}

		// Facebook APP ID
		$facebook_appid = get_theme_mod( 'ocean_facebook_appid' );
		if ( ! empty( $facebook_appid ) ) {
			$fb_app_id = $facebook_appid;
		}

		// Twiiter handle
		$twitter_handle = '@' . str_replace( '@' , '' , get_theme_mod( 'ocean_twitter_handle' ) );

		// Output
		$output = self::opengraph_tag( 'property', 'og:type', trim( $type ) );
		$output .= self::opengraph_tag( 'property', 'og:title', trim( $title ) );

		if ( isset( $description ) && ! empty( $description ) ) {
			$output .= self::opengraph_tag( 'property', 'og:description', trim( $description ) );
		}

		if ( has_post_thumbnail( oceanwp_post_id() ) && true == $has_img ) {
			$output .= self::opengraph_tag( 'property', 'og:image', trim( $image ) );
			$output .= self::opengraph_tag( 'property', 'og:image:width', absint( $get_image[1] ) );
			$output .= self::opengraph_tag( 'property', 'og:image:height', absint( $get_image[2] ) );
		}

		$output .= self::opengraph_tag( 'property', 'og:url', trim( get_permalink() ) );
		$output .= self::opengraph_tag( 'property', 'og:site_name', trim( get_bloginfo( 'name' ) ) );

		if ( is_singular() && ! is_front_page() ) {

			if ( isset( $author ) && ! empty( $author ) ) {
				$output .= self::opengraph_tag( 'property', 'article:author', trim( $author ) );
			}

			if ( is_singular( 'post' ) ) {
				$output .= self::opengraph_tag( 'property', 'article:published_time', trim( get_post_time( 'c' ) ) );
				$output .= self::opengraph_tag( 'property', 'article:modified_time', trim( get_post_modified_time( 'c' ) ) );
				$output .= self::opengraph_tag( 'property', 'og:updated_time', trim( get_post_modified_time( 'c' ) ) );
			}

		}

		if ( is_singular() ) {

			$tags = get_the_tags();
			if ( ! is_wp_error( $tags ) && ( is_array( $tags ) && $tags !== array() ) ) {
				foreach ( $tags as $tag ) {
					$output .= self::opengraph_tag( 'property', 'article:tag', trim( $tag->name ) );
				}
			}

			$terms = get_the_category();
			if ( ! is_wp_error( $terms ) && ( is_array( $terms ) && $terms !== array() ) ) {
				// We can only show one section here, so we take the first one.
				$output .= self::opengraph_tag( 'property', 'article:section', trim( $terms[0]->name ) );
			}

		}

		if ( isset( $publisher ) && ! empty( $publisher ) ) {
			$output .= self::opengraph_tag( 'property', 'article:publisher', trim( $publisher ) );
		}

		if ( isset( $fb_app_id ) && ! empty( $fb_app_id ) ) {
			$output .= self::opengraph_tag( 'property', 'fb:app_id', trim( $fb_app_id ) );
		}

		// Twitter
		$output .= self::opengraph_tag( 'name', 'twitter:card', 'summary_large_image' );
		$output .= self::opengraph_tag( 'name', 'twitter:title', trim( $title ) );

		if ( isset( $description ) && ! empty( $description ) ) {
			$output .= self::opengraph_tag( 'name', 'twitter:description', trim( $description ) );
		}

		if ( has_post_thumbnail( get_the_ID() ) && true == $has_img ) {
			$output .= self::opengraph_tag( 'name', 'twitter:image', trim( $image ) );
		}

		if ( isset( $twitter_handle ) && ! empty( $twitter_handle ) ) {
			$output .= self::opengraph_tag( 'name', 'twitter:site', trim( $twitter_handle ) );
			$output .= self::opengraph_tag( 'name', 'twitter:creator', trim( $twitter_handle ) );
		}

		echo $output;

	}

}
new OCEANWP_Theme_Class;

function add_user_hubspot($firstName = null,$lastName = null,$email = null){
	if($firstName && $lastName && $email){
		$postData = array('properties' => array(array('property' => 'email','value' => $email),array('property' => 'firstname','value' => $firstName),array('property' => 'lastname','value' => $lastName),));

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($postData));
		curl_setopt($ch, CURLOPT_URL,'https://api.hubapi.com/contacts/v1/contact?hapikey=3bca9545-7c8b-4402-8c3e-ee93fd76b1ed');
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		$response = curl_exec($ch);
		$statusCode = @curl_getinfo($ch, CURLINFO_HTTP_CODE);
		
		curl_close($ch);
	}
}
