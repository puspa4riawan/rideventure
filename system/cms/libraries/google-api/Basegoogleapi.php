<?php
require_once 'vendor/autoload.php';

class Basegoogleapi
{
    protected $ci;

    public function __construct()
	{
        $this->ci =& get_instance();
        $this->ci->load->library('session');
        $this->ci->config->load('google_config');
        $this->google_client_id 				= $this->ci->config->item('google_client_id_test');
        $this->google_client_secret 			= $this->ci->config->item('google_client_secret_test');
        $this->google_redirect 			        = $this->ci->config->item('google_redirect_googleapi');

        $this->client = new Google_Client();
		$this->client->setClientId($this->google_client_id);
		$this->client->setClientSecret($this->google_client_secret);
		$this->client->setRedirectUri($this->google_redirect);
		$this->client->setScopes(array(
			"https://www.googleapis.com/auth/plus.login",
			"https://www.googleapis.com/auth/plus.me",
			"https://www.googleapis.com/auth/userinfo.email",
            "https://www.googleapis.com/auth/userinfo.profile",
            "https://www.googleapis.com/auth/calendar"
			)
        );
    }
    
    public function get_login_url()
    {
		return  $this->client->createAuthUrl();
    }
    
    public function validate()
    {		
		if ($this->ci->input->get('code')) {
            $this->client->authenticate($this->ci->input->get('code'));
            $token = $this->client->getAccessToken();
            $this->ci->session->set_userdata('google_token',$token);
		}
        
        if ($this->ci->session->set_userdata('google_token')) {
            $this->client->setAccessToken($this->ci->session->set_userdata('google_token'));
            $plus = new Google_Service_Plus($this->client);
            $person = $plus->people->get('me');
            $info['id']             =$person['id'];
            $info['email']          =$person['emails'][0]['value'];
            $info['name']           =$person['displayName'];
            $info['link']           =$person['url'];
            $info['profile_pic']    =substr($person['image']['url'],0,strpos($person['image']['url'],"?sz=50")) . '?sz=800';
            
            return  $info;
		}
    }
    
    public function connect()
	{
		$token = $this->ci->session->userdata('google_token');

	    if (!$token && $this->ci->input->get('code')) {
	        $code = $this->ci->input->get('code');
            $this->client->authenticate($code);
	        $token = $this->client->getAccessToken();
            $attributes = $this->client->verifyIdToken($token['id_token'], $this->ci->config->item('google_client_id_test'));
            
	        $gplus_id = $attributes["sub"];
			$this->ci->session->set_userdata('google_token',$token);
            
            return array('status'=>true);
	    } else if($token){			
	       return array('status'=>true);
	    } else {
			return array('status'=>false,'url'=>$this->get_login_url()) ;
		}
		
		
    }
    
    public function get_info()
	{
        $token = $this->ci->session->userdata('google_token');
        $this->client->setAccessToken($token);
        $plus = new Google_Service_Plus($this->client);
        $info = $plus->people->get('me');

        if ($this->client->isAccessTokenExpired()) {
            if ($this->client->getRefreshToken()) {
                $this->client->fetchAccessTokenWithRefreshToken($this->client->getRefreshToken());
            } else {
                $authUrl = $this->client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));
    
                $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
                $this->client->setAccessToken($accessToken);
    
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            
            $token = $this->client->getAccessToken();
            $attributes = $this->client->verifyIdToken($token['id_token'], $this->ci->config->item('google_client_id_test'));
            
	        $gplus_id = $attributes["sub"];
			$this->ci->session->set_userdata('google_token',$token);
        }
        
        return $info;
    }
    
    public function getEvent()
    {
        $service = new Google_Service_Calendar($this->client);

        $calendarId = 'primary';
        $optParams = array(
            'maxResults'    => 10,
            'orderBy'       => 'startTime',
            'singleEvents'  => true,
            'timeMin'   => date('c'),
        );
        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        return $events;
    }

    public function addEvent($dataEvent = array())
    {
        if (!$this->client->isAccessTokenExpired()) {
            $service = new Google_Service_Calendar($this->client);
            $event = new Google_Service_Calendar_Event($dataEvent);
            $calendarId = 'primary';
            $event = $service->events->insert($calendarId, $event);
        } else {
            return $this->get_info();
        }

        return ($event->htmlLink) ? true : false;
    }
}