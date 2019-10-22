<?php defined('BASEPATH') OR exit('No direct script access allowed');

function get_api_url($name){
	$api_url = array(
	    'videos' => 'https://www.googleapis.com/youtube/v3/videos',
	    'search' => 'https://www.googleapis.com/youtube/v3/search',
	    'channels' => 'https://www.googleapis.com/youtube/v3/channels',
	    'playlists' => 'https://www.googleapis.com/youtube/v3/playlists',
	    'playlistItems' => 'https://www.googleapis.com/youtube/v3/playlistItems',
	    'activities' => 'https://www.googleapis.com/youtube/v3/activities',
	);

    return $api_url[$name];
}

function get_youtube_thumbnail_by_url($url){
	if(!filter_var($url, FILTER_VALIDATE_URL)){
	    return false;
	}

	$domain=parse_url($url,PHP_URL_HOST);
	if($domain=='www.youtube.com' OR $domain=='youtube.com') {
	    if($querystring=parse_url($url,PHP_URL_QUERY)) {
	        parse_str($querystring);

	        if(!empty($v))  {
	        	$image_data=array(
	        		'default'		=>"https://img.youtube.com/vi/".$v."/default.jpg",
	        		'medium'		=>"https://img.youtube.com/vi/".$v."/mqdefault.jpg",
	        		'high'			=>"https://img.youtube.com/vi/".$v."/hqdefault.jpg",
	        		'standard'		=>"https://img.youtube.com/vi/".$v."/sddefault.jpg",
	        		'z0'			=>'https://img.youtube.com/vi/'.$v.'/0.jpg',
					'z1'			=>'https://img.youtube.com/vi/'.$v.'/1.jpg',
					'z2'			=>'https://img.youtube.com/vi/'.$v.'/2.jpg',
					'z3'			=>'https://img.youtube.com/vi/'.$v.'/3.jpg',
	        	);
	        	return $image_data;
	        } else {
	        	return false;
	        }
	    }
	    else return false;

	} elseif($domain == 'youtu.be') {
	    $v= str_replace('/','', parse_url($url, PHP_URL_PATH));
	    return (empty($v)) ? false : "https://img.youtube.com/vi/$v/0.jpg" ;
	}

	else
	return false;
}

function get_yuyub_api_data($vid) {
	$api_url = get_api_url('videos');
	$params 	= array(
        'id' 	=> $vid,
        'part' 	=> 'id, snippet, contentDetails, player, statistics, status',
        'key'	=> Settings::get('youtube_key'),
    );

    $yutubCurl = curl_init();
    curl_setopt($yutubCurl, CURLOPT_URL, $api_url.(strpos($api_url, '?') === FALSE ? '?' : '').http_build_query($params));

    if(strpos($api_url, 'https') === FALSE){
        curl_setopt($yutubCurl, CURLOPT_PORT , 80);
    } else {
        curl_setopt($yutubCurl, CURLOPT_PORT , 443);
    }

    curl_setopt($yutubCurl, CURLOPT_RETURNTRANSFER, 1);

    $yutubData = curl_exec($yutubCurl);

    if(curl_errno($yutubCurl)) {
      throw new \Exception('Curl Error : ' . curl_error($yutubCurl));
    }

    return $yutubData;
}

function calculate_article_time($datetime, $timezone = 'Asia/Jakarta') {
    $reserved = array('Asia/Jakarta', 'Asia/Pontianak', 'Asia/Makassar', 'Asia/Dili', 'Asia/Jayapura');
    $format = 'Y-m-d H:i:s';

    if (in_array($timezone, $reserved)) {
        if ($timezone == 'Asia/Makassar') {
            $created = date($format, strtotime('+1 hours', strtotime($datetime)));
        } elseif ($timezone == 'Asia/Dili' || $timezone == 'Asia/Jayapura') {
            $created = date($format, strtotime('+2 hours', strtotime($datetime)));
        } else {
            $created = date($format, strtotime($datetime));
        }

        $now = date($format, time());
        $now = new \DateTime($now);

        $start = new \DateTime($created);
        $since = $start->diff($now);

        if ($since->days > 0) {
            $result = sprintf('%d hari yang lalu', $since->days);
        } elseif ($since->d > 0 && $since->d < 29) {
            $result = sprintf('%d hari yang lalu', $since->d);
        } elseif ($since->h > 0) {
            $result = sprintf('%d jam yang lalu', $since->h);
        } elseif ($since->i >= 0) {
            $result = sprintf('%d menit yang lalu', $since->i);
        }
    } else {
        /* request matiin timezone
        $time = date($format, strtotime('-7 hours', strtotime($datetime)));
        $result = sprintf('%s (UTC)', $time);
        */

        $time = date($format, strtotime($datetime));
        $result = sprintf('%s ', $time);
    }

    return $result;
}
