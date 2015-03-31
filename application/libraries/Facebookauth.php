<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include "facebooksdk/facebook.php";


class Facebookauth{


    protected $ci;


    public function __construct(){
        $this->ci = & get_instance();

    }

    public function connectUrl(){

        //Connexion avec App ID et Secret
        $facebook = new Facebook(
            array(
                'appId'  => '552592408160039',
                'secret' => '57eb877a52cbd1b6a2713ffd9ad4b066',
                'cookie' => true

            )
        );

        $accessToken = $facebook->getAccessToken();

        # Get User ID
        $user = $facebook->getUser();
        $facebook->setAccessToken($accessToken);

        //exit(print_r($user));   


        if ($user) {
            try {

                $user_profile = $facebook->api('/me', 'GET'); //1639712699

                //créer un objet vide
                $user = new stdClass();
                $user->email = $user_profile['email'];
                $user->username =  $user_profile['first_name']." ".$user_profile['last_name'];
                $user->id =  $user_profile['id'];
                $user->dob =  $user_profile['birthday'];
                $user->is_admin =  false;


                $this->ci->session->set_userdata(array('user', $user));

            } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
            }
        }


        // Login or logout url will be needed depending on current user state.
        if ($user) {
            $logoutUrl = $facebook->getLogoutUrl();
        } else {
            $loginUrl = $facebook->getLoginUrl(array(
                'cookie' => true,
                'scope'     => 'email,user_birthday, user_likes, public_profile, user_friends',
                'redirect_uri'  => base_url().'index.php/welcome/index',
            ));
        }


        if (!$user){
            return $loginUrl;
        }
        else{
            return $logoutUrl;
        }

    }





}