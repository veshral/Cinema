<?php

//inclusion d'une librairie
include "twitteroauth/twitteroauth.php";


class Twitter{



    /**
    * Constructeur
    */
    public function __construct(){
        $this->ci =& get_instance();
    }


    /**
     * Récupérer les Tweets
     */
    public function getTweets($compte, $limit)
    {
        # Define constants
        $clefconsomme = '7WBlmscOGK6FMIWuAABZCquiG';
        $secretconsomme = 'GcYUvDMNG2WJB5OhMoP7ChC9sfmjVVCSxjOfBSdCNqNSk73Fkv';
        $accesstoken =  '79562559-TpMXvf5EVI4yyEiIwLswFXUDhtvlI8qhLpLHdKAiA';
        $accesssecret = 'xPyeYFQj0eVV3gvJbCaUsPWQrdYkVPuPT27yu9EhlmAPA';




        # Create the connection
        $twitter = new TwitterOAuth($clefconsomme, $secretconsomme, $accesstoken, $accesssecret);
        $twitter->ssl_verifypeer = true; //connexion en ssl

        $tweets = $twitter->get('statuses/user_timeline', array(
            'screen_name' => $compte,
            'exclude_replies' => 'true',
            'include_rts' => 'false',
            'count' => $limit
        ));

        $tabtweets = array();

        if(!empty($tweets)) {
            foreach($tweets as $tweet) {

                # Access as an object
                $tweetText = $tweet->text;

                # Make links active
                $tweetText = preg_replace("#(http://|(www.))(([^s<]{4,68})[^s<]*)#", '<a href="http://$2$3" target="_blank">$1$2$4</a>', $tweetText);

                # Linkify user mentions
                $tweetText = preg_replace("/@(w+)/", '<a href="http://www.twitter.com/$1" target="_blank">@$1</a>', $tweetText);

                # Linkify tags
                $tweetText = preg_replace("/#(w+)/", '<a href="http://search.twitter.com/search?q=$1" target="_blank">#$1</a>', $tweetText);

                # Output
                $tabtweets[$tweet->id] = 
                array(
                    'text' => $tweetText, 
                    'id' => $tweet->id
                );
            }
        }

        return $tabtweets;
    }


    public function delete($id){
        $clefconsomme = '7WBlmscOGK6FMIWuAABZCquiG';
        $secretconsomme = 'GcYUvDMNG2WJB5OhMoP7ChC9sfmjVVCSxjOfBSdCNqNSk73Fkv';
        $accesstoken =  '79562559-TpMXvf5EVI4yyEiIwLswFXUDhtvlI8qhLpLHdKAiA';
        $accesssecret = 'xPyeYFQj0eVV3gvJbCaUsPWQrdYkVPuPT27yu9EhlmAPA';


        # Create the connection
        $twitter = new TwitterOAuth($clefconsomme, $secretconsomme, $accesstoken, $accesssecret);
        $twitter->ssl_verifypeer = true;


        $twitter->post('statuses/destroy', array(
            'id' => $id
        ));
    }


    public function create($message){
        $clefconsomme = '7WBlmscOGK6FMIWuAABZCquiG';
        $secretconsomme = 'GcYUvDMNG2WJB5OhMoP7ChC9sfmjVVCSxjOfBSdCNqNSk73Fkv';
        $accesstoken =  '79562559-TpMXvf5EVI4yyEiIwLswFXUDhtvlI8qhLpLHdKAiA';
        $accesssecret = 'xPyeYFQj0eVV3gvJbCaUsPWQrdYkVPuPT27yu9EhlmAPA';


        # Create the connection
        $twitter = new TwitterOAuth($clefconsomme, $secretconsomme, $accesstoken, $accesssecret);
        $twitter->ssl_verifypeer = true;


        $twitter->post('statuses/update', array(
            'status' => $message,
        ));


    }

    /**
     * Récupérer Infos Twitter
     */
    public function getInfos($compte)
    {
        # Define constants
        $clefconsomme = '7WBlmscOGK6FMIWuAABZCquiG';
        $secretconsomme = 'GcYUvDMNG2WJB5OhMoP7ChC9sfmjVVCSxjOfBSdCNqNSk73Fkv';
        $accesstoken =  '79562559-TpMXvf5EVI4yyEiIwLswFXUDhtvlI8qhLpLHdKAiA';
        $accesssecret = 'xPyeYFQj0eVV3gvJbCaUsPWQrdYkVPuPT27yu9EhlmAPA';


        # Create the connection
        $twitter = new TwitterOAuth($clefconsomme, $secretconsomme, $accesstoken, $accesssecret);
        $twitter->ssl_verifypeer = true;

        $tweets = $twitter->get('users/show', array(
            'screen_name' => $compte,
            'exclude_replies' => 'true',
            'include_rts' => 'false'));

        return $tweets;
    }



    public function authentification(){

        # Define constants
        $oauth_token = '7WBlmscOGK6FMIWuAABZCquiG';
        $oauth_token_secret = 'GcYUvDMNG2WJB5OhMoP7ChC9sfmjVVCSxjOfBSdCNqNSk73Fkv';
        $accesstoken =  '79562559-TpMXvf5EVI4yyEiIwLswFXUDhtvlI8qhLpLHdKAiA';
        $accesssecret = 'xPyeYFQj0eVV3gvJbCaUsPWQrdYkVPuPT27yu9EhlmAPA';

        define('CONSUMER_KEY', $oauth_token);
        define('CONSUMER_SECRET', $oauth_token_secret);

        # Create the connection
        $twitter = new TwitterOAuth($oauth_token, $oauth_token_secret);


        $temporary_credentials = $twitter->getRequestToken("http://localhost/cinema/index.php/dashboard/login"); // Use config.php callback URL.


        $redirect_url = $twitter->getAuthorizeURL($temporary_credentials); // Use Sign in with Twitter

        $token = $this->ci->input->get('oauth_token');

        if(!empty($token)){
            $this->ci->session->set_userdata('oauth_token', $token);
            $token_credentials = $twitter->getAccessToken($_GET['oauth_verifier']);
          //  exit(var_dump($token_credentials));
            $twitter  = $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $token_credentials['oauth_token'],$token_credentials['oauth_token_secret']);
            $token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);

           // print_r($twitter);
           // exit(var_dump($token_credentials));
        }

        return $redirect_url;

    }









}