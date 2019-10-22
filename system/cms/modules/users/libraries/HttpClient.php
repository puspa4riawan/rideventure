<?php

/**
 * HTTP Client Class
 * 
 * HTTP client wrapper class that will handle api request
 * 
 * @author Andrew Aculana <andrew.aculana@gmail.com>
 * 
 */
class HttpClient
{
	public $url;
	public $postString;
	public $httpResponse;

	public $ch;

	public function __construct($url)
	{
		$this->url = $url;
		$this->ch  = curl_init( $this->url );
		curl_setopt( $this->ch, CURLOPT_FOLLOWLOCATION, false );
		curl_setopt( $this->ch, CURLOPT_HEADER, false );
		curl_setopt( $this->ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $this->ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt( $this->ch, CURLOPT_VERBOSE, true);
	}


	public function __destruct()
	{
		curl_close($this->ch);
	}  
	
	public function setPostData($params)
	{
	   $this->postString = rawurldecode(http_build_query( $params ));
	   curl_setopt( $this->ch, CURLOPT_POST, true );
	   curl_setopt ( $this->ch, CURLOPT_POSTFIELDS, $this->postString );
	}
	
	public function setHeaderData($params)
	{
		curl_setopt( $this->ch, CURLOPT_HTTPHEADER, $params);
	}

	public function send()
	{
	   $this->httpResponse = curl_exec( $this->ch );
		if(curl_errno($this->ch))
		{
			die ('error:' . curl_error($this->ch));
		}
		
	}

	public function getHttpResponse()
	{
		return $this->httpResponse;
	}
}
