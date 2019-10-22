<?php
/*
 * Sample application for Google+ client to server authentication.
 * Remember to fill in the OAuth 2.0 client id and client secret,
 * which can be obtained from the Google Developer Console at
 * https://code.google.com/apis/console
 *
 * Copyright 2013 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/*
 * Note (Gerwin Sturm):
 * Include path is still necessary despite autoloading because of the require_once in the libary
 * Client library should be fixed to have correct relative paths
 * e.g. require_once '../Google/Model.php'; instead of require_once 'Google/Model.php';
 */
set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ .'/vendor/google/apiclient/src');

require_once __DIR__.'/vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class Gplus {
	
	public function __construct()
	{
		$this->ci =& get_instance();
		$this->ci->config->load('google_config');		
		$client = new Google_Client();
		
		$client->setApplicationName($this->ci->config->item('google_application_name'));
		$client->setClientId($this->ci->config->item('google_client_id'));
		$client->setClientSecret($this->ci->config->item('google_client_secret'));
		$client->setRedirectUri(site_url($this->ci->config->item('google_redirect')));
		$client->addScope(array(Google_Service_Plus::PLUS_LOGIN,Google_Service_Plus::PLUS_ME,Google_Service_Plus::USERINFO_EMAIL,Google_Service_Plus::USERINFO_PROFILE));
		$this->plus = new Google_Service_Plus($client);
		$this->client = $client;
	}
	
	
	public function connect()
	{
		$token = $this->ci->session->userdata('g_token');

	    if (!$token && $this->ci->input->get('code')) {
	        // Ensure that this is no request forgery going on, and that the user
	        // sending us this connect request is the user that was supposed to.
	
	        $code = $this->ci->input->get('code');
	        // Exchange the OAuth 2.0 authorization code for user credentials.
	        $this->client->authenticate($code);
	        $token = json_decode($this->client->getAccessToken());
	
	        // You can read the Google user ID in the ID token.
	        // "sub" represents the ID token subscriber which in our case
	        // is the user ID. This sample does not use the user ID.
	        $attributes = $this->client->verifyIdToken($token->id_token, $this->ci->config->item('google_client_id'))
	            ->getAttributes();
	        $gplus_id = $attributes["payload"]["sub"];
	        // Store the token in the session for later use.
			$this->ci->session->set_userdata('g_token',json_encode($token));
			return array('status'=>true);
	    } else if($token){
			
	       return array('status'=>true);
	    }
		else {
			return array('status'=>false,'url'=>$this->generate_url()) ;
		}
		
		
	}
	
	public function get_info()
	{
		 $token = $this->ci->session->userdata('g_token');
		 $this->client->setAccessToken($token);
		 $info = $this->plus->people->get('me');
		 return $info;
	}
	
	public function generate_url()
	{
		$auth_url = $this->client->createAuthUrl();
		return $auth_url ;
	}
	
	
	
}
