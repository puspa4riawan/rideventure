<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * MaxCMS Pagination Helpers
 *  
 * @package MaxCMS\Core\Helpers
 * @author      MaxCMS Dev Team
 * @copyright   Copyright (c) 2012, MaxCMS LLC
 */
if ( ! function_exists('create_pagination'))
{

	/**
	 * The Pagination helper cuts out some of the bumf of normal pagination
	 *
	 * @param string $uri The current URI.
	 * @param int $total_rows The total of the items to paginate.
	 * @param int|null $limit How many to show at a time.
	 * @param int $uri_segment The current page.
	 * @param boolean $full_tag_wrap Option for the Pagination::create_links()
	 * @return array The pagination array. 
	 * @see Pagination::create_links()
	 */
	function create_pagination($uri, $total_rows, $limit = null, $uri_segment = 4, $full_tag_wrap = true, $page=0)
	{
		$ci = & get_instance();
		$ci->load->library('pagination');

		$current_page = $ci->uri->segment($uri_segment, 0) ? $ci->uri->segment($uri_segment, 0) : $page;
		$suffix = $ci->config->item('url_suffix');

		$limit = $limit === null ? Settings::get('records_per_page') : $limit;

		// Initialize pagination
		$ci->pagination->initialize(array(
			'suffix' 				=> $suffix,
			'base_url' 				=> ( ! $suffix) ? rtrim(site_url($uri), $suffix) : site_url($uri),
			'total_rows' 			=> $total_rows,
			'per_page' 				=> $limit,
			'uri_segment' 			=> $uri_segment,
			'use_page_numbers'		=> true,
			'reuse_query_string' 	=> true,
		));

		$offset = $limit * ($current_page - 1);
		
		//avoid having a negative offset
		if ($offset < 0) $offset = 0;

		// return array(
		// 	'current_page' => $current_page,
		// 	'per_page' => $limit,
		// 	'limit' => $limit,
		// 	'offset' => $offset,
		// 	'links' => $ci->pagination->create_links($full_tag_wrap)
		// );

		
		return array(
			'current_page' => $current_page,
			'per_page' => $limit,
			'limit' => $limit,
			'offset' => $offset,
			'total_pages'=>(int) ceil( $total_rows / $limit),
			'links' => $ci->pagination->create_links($full_tag_wrap)
		);
	}
	
	function custom_pagination($uri, $total_rows, $limit = null, $uri_segment = 4, $full_tag_wrap = true)
	{
		$ci = & get_instance();
		$ci->load->library('pagination');
	
		$current_page = $ci->uri->segment($uri_segment, 0);
		$suffix = $ci->config->item('url_suffix');
	
		$limit = $limit === null ? Settings::get('records_per_page') : $limit;
	
		// Initialize pagination
		$ci->pagination->initialize(array(
			'suffix' 				=> $suffix,
			'base_url' 				=> ( ! $suffix) ? rtrim(site_url($uri), $suffix) : site_url($uri),
			'total_rows' 			=> $total_rows,
			'per_page' 				=> $limit,
			'uri_segment' 			=> $uri_segment,
			'use_page_numbers'		=> true,
			'reuse_query_string' 	=> true,
			'use_custom'			=> true,
			'first_link'			=> 'First',
			'next_link'			=> 'Next',
			'prev_link'			=> 'Prev',
			'last_link'			=> 'Last',
			'cur_tag_open'		=>'<a href="javascript:void(0)" class="disabled">',
			'cur_tag_close'	=>'</a> ',
			'num_tag_open' =>'',
			'num_tag_close'=>'',
			'next_tag_open'=>'',
			'next_tag_close'=>'',
			'last_tag_open'=>'',
			'last_tag_close'=>'',
			'prev_tag_open'=>'',
			'prev_tag_close'=>'',
			'first_tag_open'=>'',
			'first_tag_close'=>'',
			'full_tag_open'=>'',
			'full_tag_close'=>'',
			'num_links'=>2
			
		));
	
		$offset = $limit * ($current_page - 1);
		
		//avoid having a negative offset
		if ($offset < 0) $offset = 0;
	
		return array(
			'current_page' => $current_page,
			'per_page' => $limit,
			'limit' => $limit,
			'offset' => $offset,
			'links' => $ci->pagination->create_links($full_tag_wrap),
			'dropdown_links'=>$ci->pagination->dropdown_links()
		);
	}
}