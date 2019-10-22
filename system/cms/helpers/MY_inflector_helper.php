<?php defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * MaxCMS Inflector Helpers
 * 
 * This overrides Codeigniter's helpers/inflector_helper.php file.
 *
 * @author      MaxCMS Dev Team
 * @copyright   Copyright (c) 2012, MaxCMS LLC
 * @package		MaxCMS\Core\Helpers
 */

if ( ! function_exists('keywords'))
{
	/**
	 * Keywords
	 *
	 * Takes multiple words separated by spaces and changes them to keywords
	 * Makes sure the keywords are separated by a comma followed by a space.
	 *
	 * @param string $str The keywords as a string, separated by whitespace.
	 * @return string The list of keywords in a comma separated string form.
	 */
	function keywords($str)
	{
		return preg_replace('/[\s]+/', ', ', trim($str));
	}
}

if(!function_exists('slugify'))
{
	/**
	 * Make slug from a given string
	 * 
	 * @param string $str The string you want to convert to a slug.
	 * @param string $separator The symbol you want in between slug parts.
	 * @return string The string in slugified form.
	 */
	function slugify($string, $separator = '-')
	{	
		$string = trim($string);
		$string = strtolower($string);
		$string = preg_replace('/[\s-]+/', $separator, $string);
		$string = preg_replace("/[^0-9a-zA-Z-]/", '', $string);
		
		return $string;
	}
}

if(!function_exists('rand_string'))
{
	/**
	 * Create a random hash string based on microtime
	 * @param 	int $length
	 * @return 	string
	*/
	function rand_string($length = 10)
	{
		$chars = 'ABCDEFGHKLMNOPQRSTWXYZabcdefghjkmnpqrstwxyz';
		$max = strlen($chars)-1;
		$string = '';
		mt_srand((double)microtime() * 1000000);
		while (strlen($string) < $length)
		{
			$string .= $chars{mt_rand(0, $max)};
		}
		return $string;
	}
}

if (!function_exists('sanitize_html'))
{
	function sanitize_html($dirty_html)
	{
		require_once APPPATH.'libraries/htmlpurifier/HTMLPurifier.auto.php';

		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', 'UTF-8');
		$config->set('Core.CollectErrors', true);
		$config->set('HTML.TidyLevel', 'medium');
		$config->set('HTML.Doctype', 'XHTML 1.0 Transitional');
		$config->set('HTML.Allowed','br,span[style]');
		$config->set('URI.DisableExternalResources', false);
		$config->set('CSS.AllowedProperties',array('text-decoration','font-weight','font-style'));



		$purifier = new HTMLPurifier($config); 
		$clean_html =$purifier->purify($dirty_html);

		return $clean_html;
	}
}
