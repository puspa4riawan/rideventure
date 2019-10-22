<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Code here is run before frontend controllers
 *
 * @author      MaxCMS Dev Team
 * @copyright   Copyright (c) 2012, MaxCMS LLC
 * @package 	MaxCMS\Core\Controllers
 */
class Public_Controller extends MY_Controller
{
	/**
	 * Loads the gazillion of stuff, in Flash Gordon speed.
	 * @todo Document properly please.
	 */
	public function __construct()
	{
		parent::__construct();

		$this->benchmark->mark('public_controller_start');
		Events::trigger('public_controller');
		$this->load->library('facebook/facebook');

		// Check the frontend hasnt been disabled by an admin
		if ( ! $this->settings->frontend_enabled && (empty($this->current_user) or $this->current_user->group != 'admin'))
		{
			header('Retry-After: 600');

			$error = $this->settings->unavailable_message ? $this->settings->unavailable_message : lang('cms:fatal_error');
			show_error($error, 503);
		}

		// -- Navigation menu -----------------------------------
		$this->load->model('pages/page_m');

		// Load the current theme so we can set the assets right away
		ci()->theme = $this->theme_m->get();

		if (empty($this->theme->slug))
		{
			show_error('This site has been set to use a theme that does not exist. If you are an administrator please '.anchor(ADMIN_URL.'/themes', 'change the theme').'.');
		}

		// Set the theme as a path for Asset library
		Asset::add_path('theme', $this->theme->path.'/');
		Asset::set_path('theme');
		
		//set default jquery
		Asset::js('theme::jquery.js');

		// Support CDN URL's like Amazon CloudFront 
		if (Settings::get('cdn_domain'))
		{
			$protocol = ( ! empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') ? 'https' : 'http';

			// Make cdn.maxcms.com into https://cdn.maxcms.com/
			Asset::set_url($protocol.'://'.rtrim(Settings::get('cdn_domain'), '/').'/');
		}

		// Set the theme view folder
		$this->template->set_theme($this->theme->slug);

		// Is there a layout file for this module?
		if ($this->template->layout_exists($this->module.'.html'))
		{
			$this->template->set_layout($this->module.'.html');
		}

		// Nope, just use the default layout
		elseif ($this->template->layout_exists('default.html'))
		{
			$this->template->set_layout('default.html');
		}

		// Make sure whatever page the user loads it by, its telling search robots the correct formatted URL
		$this->template->set_metadata('canonical', site_url($this->uri->uri_string()), 'link');

		// If there is a blog module, link to its RSS feed in the head
		if (module_enabled('blog'))
		{
			$this->template->append_metadata('<link rel="alternate" type="application/rss+xml" title="'.Settings::get('site_name').'" href="'.site_url('blog/rss/all.rss').'" />');
		}

		
		// grab the theme options if there are any
		$this->theme->options = $this->maxcache->model('theme_m', 'get_values_by', array(array('theme' => $this->theme->slug)));

		// Assign segments to the template the new way
		$this->template->server = $_SERVER;
		$this->template->theme = $this->theme;

		//set code reset
		if($reset_code = $this->session->flashdata('code'))
		{
			$this->template->set('reset_code',site_url(array('lupa-password',$reset_code)));
			Asset::js_inline('var RESET_CODE = true;');
		}
		
		$this->benchmark->mark('public_controller_end');
	}
}
