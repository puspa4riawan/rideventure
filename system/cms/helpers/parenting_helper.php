<?php defined('BASEPATH') OR exit('No direct script access allowed.');

if ( ! function_exists('app_datetime'))
{
	function app_datetime(){
		date_default_timezone_set('Asia/Jakarta');
		return date('Y-m-d H:i:s');
	}
}


if ( ! function_exists('app_date'))
{
	function app_date(){
		date_default_timezone_set('Asia/Jakarta');
		return date('Y-m-d');
	}
}

if ( ! function_exists('app_datetime_indonesia'))
{
	function app_datetime_indonesia($datetime){     
	    $bulan = array(1=>'Januari','Februari','Maret','April','Mei','Juni','July','Agustus','September','Oktober','November','Desember');
	    $daylist = array(
				'Sun' => 'Minggu',
				'Mon' => 'Senin',
				'Tue' => 'Selasa',
				'Wed' => 'Rabu',
				'Thu' => 'Kamis',
				'Fri' => 'Jum\'at',
				'Sat' => 'Sabtu'
		);
	 
	    $time = ''; 
	    $exp = explode(' ',$datetime);     
	    if(count($exp) > 1){ //datetime 
	        $a = explode('-', $exp[0]);         
	        $time = ' '.$exp[1]; 
	    }else{         
	        $a = explode('-', $datetime); 
	    } 
	     
	    $b = mktime(0, 0, 0, $a[1], $a[2], $a[0]); //m d Y     	    
	    $c = $daylist[date('D', $b)].', '.$a[2].' '.$bulan[date('n', $b)].' '.$a[0].', '.substr($time, 0, -3).' WIB'; 
	    return $c; 
	     
	}	
}

if ( ! function_exists('convert_indodate_to_systemdate'))
{
	function convert_indodate_to_systemdate($date){
		$month = array(
			'Januari'=>'01',
			'Februari'=>'02',
			'Maret'=>'03',
			'April'=>'04',
			'Mei'=>'05',
			'Juni'=>'06',
			'Juli'=>'07',
			'Agustus'=>'08',
			'September'=>'09',
			'Oktober'=>'10',
			'November'=>'11',
			'Desember'=>'12',
		);
		$exp = explode(' ',$date);
		$newdate = $exp[2].'-'.$month[$exp[1]].'-'.$exp[0];

		return $newdate;
	}
}
