<?php 

define('WP_USE_THEMES',false);
require('../../../../wp-load.php');

$LoginUrl = '/login/';

if(file_exists(__DIR__.'/../../../vendor/autoload.php')){
	require(__DIR__.'/../../../vendor/autoload.php');

	//is FB login
	$fbLogin = isset($_GET['code']) && isset($_GET['state']) ? true : false;
	$fb = new \Facebook\Facebook(['app_id' => '792117054488333','app_secret' => 'bf55d30f2b1ef39a2cc615e34cecf820','default_graph_version' => 'v2.10',]);

	//googleLogin
	$googleLogin = isset($_GET['code']) && isset($_GET['scope']) ? true : false;

	if($fbLogin){
		$helper = $fb -> getRedirectLoginHelper();
        $state = isset($_GET['state']) ? $_GET['state'] : null;

        if($state){
            $helper->getPersistentDataHandler()->set('state',$state);
        }

        try {
            $accessToken = $helper->getAccessToken();
        }catch(Facebook\Exceptions\FacebookResponseException $e) {
            wp_redirect($LoginUrl.'?error=1');
        }catch(Facebook\Exceptions\FacebookSDKException $e) {
            wp_redirect($LoginUrl.'?error=1');
        }

        try {
            $response = $fb -> get('/me?fields=id,first_name,last_name,email,picture.width(250).height(250)',$accessToken);
        }catch(Facebook\Exceptions\FacebookResponseException $e) {
            wp_redirect($LoginUrl.'?error=1');
        }catch(Facebook\Exceptions\FacebookSDKException $e) {
            wp_redirect($LoginUrl.'?error=1');
        }

        $user = $response -> getGraphUser();

        if($user){
        	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $randomPassword = substr(str_shuffle($chars),0,10);

            if(email_exists($user['email'])){
            	$user = get_user_by('email',$user['email']);
            	$userData = ['user_login'=>$user -> user_login,'user_password'=>$randomPassword,'remember'=>true];
            	
            	wp_set_password($randomPassword,$user -> ID);
            	$login = wp_signon($userData,false);

            	if(!isset($login -> errors)){
					wp_set_current_user($user -> ID,$user -> user_login);
					wp_set_auth_cookie($user -> ID, true, false );
					do_action('wp_login',$user -> user_login);

                    wp_redirect($LoginUrl);
				}else{
					wp_redirect($LoginUrl.'?error=1');
				}
            }else{
            	$userData = [];
            	$userData['user_login'] = $user['email'];
				$userData['user_email'] = $user['email'];
				$userData['first_name'] = $user['first_name'];
				$userData['last_name'] = $user['last_name'];
				$userData['user_pass'] = $randomPassword;
				$userData['user_password'] = $randomPassword;
				$userData['role'] = 'student';

				$insertUser = wp_insert_user($userData);

				if(!isset($insertUser -> errors)){
					$login = wp_signon($userData,false);

                     wp_redirect($LoginUrl);
				}else{
					wp_redirect($LoginUrl.'?error=1');
				}
            }
        }else{
            wp_redirect($LoginUrl.'?error=1');
        }
	}else if($googleLogin){
        //google API
        $code = $_GET['code'];
        $gClient = new \Google_Client();
        $gClient -> setAuthConfig(__DIR__.'/../assets/credentials.json');
        $gClient -> authenticate($code);
        $token = $gClient -> getAccessToken();

        $googleAccount = new \Google_Service_Oauth2($gClient);
        $email =  $googleAccount -> userinfo -> get() -> email;
        
        if($email){
            $lastName = $googleAccount -> userinfo-> get() -> familyName;
            $firstName = $googleAccount -> userinfo-> get() -> givenName;
            $picture = $googleAccount -> userinfo-> get() -> picture;
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $randomPassword = substr(str_shuffle($chars),0,10);

            if(email_exists($email)){
                $user = get_user_by('email',$email);
                $userData = ['user_login'=>$user -> user_login,'user_password'=>$randomPassword,'remember'=>true];
                
                wp_set_password($randomPassword,$user -> ID);
                $login = wp_signon($userData,false);

                if(!isset($login -> errors)){
                    wp_set_current_user($user -> ID,$user -> user_login);
                    wp_set_auth_cookie($user -> ID, true, false );
                    do_action('wp_login',$user -> user_login);

                    wp_redirect($LoginUrl);
                }else{
                    wp_redirect($LoginUrl.'?error=1');
                }
            }else{
                $userData = [];
                $userData['user_login'] = $email;
                $userData['user_email'] = $email;
                $userData['first_name'] = $firstName;
                $userData['last_name'] = $lastName;
                $userData['user_pass'] = $randomPassword;
                $userData['user_password'] = $randomPassword;
                $userData['role'] = 'student';

                $insertUser = wp_insert_user($userData);

                if(!isset($insertUser -> errors)){
                    $login = wp_signon($userData,false);

                     wp_redirect($LoginUrl);
                }else{
                    wp_redirect($LoginUrl.'?error=1');
                }
            }
        }else{
            wp_redirect($LoginUrl.'?error=1');
        }
	}
}



?>