<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Open Software License version 3.0
 *
 * This source file is subject to the Open Software License (OSL 3.0) that is
 * bundled with this package in the files license.txt / license.rst. It is
 * also available through the world wide web at this URL:
 * http://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/**
 * Native PHP session management driver
 *
 * This is the driver that uses the native PHP $_SESSION array through the Session driver library.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Sessions
 * @author		EllisLab Dev Team
 */
class CI_Session_native extends CI_Session_driver {
	
	/* tambahan untuk single sign on database */
			/**
	 * Whether to encrypt the session cookie
	 *
	 * @var bool
	 */
	public $sess_encrypt_cookie		= FALSE;

	/**
	 * Whether to use to the database for session storage
	 *
	 * @var bool
	 */
	public $sess_use_database		= FALSE;

	/**
	 * Name of the database table in which to store sessions
	 *
	 * @var string
	 */
	public $sess_table_name			= '';

	/**
	 * Length of time (in seconds) for sessions to expire
	 *
	 * @var int
	 */
	public $sess_expiration			= 7200;

	/**
	 * Whether to kill session on close of browser window
	 *
	 * @var bool
	 */
	public $sess_expire_on_close	= FALSE;

	/**
	 * Whether to match session on ip address
	 *
	 * @var bool
	 */
	public $sess_match_ip			= FALSE;

	/**
	 * Whether to match session on user-agent
	 *
	 * @var bool
	 */
	public $sess_match_useragent	= TRUE;

	/**
	 * Name of session cookie
	 *
	 * @var string
	 */
	public $sess_cookie_name		= 'ci_session';

	/**
	 * Session cookie prefix
	 *
	 * @var string
	 */
	public $cookie_prefix			= '';

	/**
	 * Session cookie path
	 *
	 * @var string
	 */
	public $cookie_path				= '';

	/**
	 * Session cookie domain
	 *
	 * @var string
	 */
	public $cookie_domain			= '';

	/**
	 * Whether to set the cookie only on HTTPS connections
	 *
	 * @var bool
	 */
	public $cookie_secure			= FALSE;

	/**
	 * Whether cookie should be allowed only to be sent by the server
	 *
	 * @var bool
	 */
	public $cookie_httponly 		= FALSE;

	/**
	 * Interval at which to update session
	 *
	 * @var int
	 */
	public $sess_time_to_update		= 300;

	/**
	 * Key with which to encrypt the session cookie
	 *
	 * @var string
	 */
	public $encryption_key			= '';

	/**
	 * Timezone to use for the current time
	 *
	 * @var string
	 */
	public $time_reference			= 'local';

	/**
	 * Session data
	 *
	 * @var array
	 */
	public $userdata				= array();

	/**
	 * Reference to CodeIgniter instance
	 *
	 * @var object
	 */
	public $CI;

	/**
	 * Current time
	 *
	 * @var int
	 */
	public $now;
	
	protected $data_dirty = FALSE;
	protected $defaults = array(
		'session_id' => NULL,
		'ip_address' => NULL,
		'user_agent' => NULL,
		'last_activity' => NULL
		);
	
	/* end tambahan */

	/**
	 * Initialize session driver object
	 *
	 * @return	void
	 */
		protected function initialize()
		{
			// Get config parameters
			$config = array();
			$CI =& get_instance();
			$prefs = array(
				'sess_cookie_name',
				'sess_expire_on_close',
				'sess_expiration',
				'sess_match_ip',
				'sess_match_useragent',
				'sess_time_to_update',
				'cookie_prefix',
				'cookie_path',
				'cookie_domain',
				/* tambahan */
				'cookie_secure',	
	            'cookie_httponly',
				'time_reference',
				'sess_use_database',
				'sess_table_name',
				
			);
	
			foreach ($prefs as $key)
			{
				$this->$key = $config[$key] = isset($this->_parent->params[$key])
					? $this->_parent->params[$key]
					: $CI->config->item($key);
			}
			
			/* tambahan */
			// Check for database
			if ($this->sess_use_database === TRUE && $this->sess_table_name !== '')
			{
				// Load database driver
				$CI->load->database();
	
				// Register shutdown function
				register_shutdown_function(array($this, '_update_db'));
			}
			
				// Set the "now" time. Can either be GMT or server time, based on the config prefs.
			// We use this to set the "last activity" time
			$this->now = $this->_get_time();
			
			/* end tambahan */
	
			// Set session name, if specified
			if ($config['sess_cookie_name'])
			{
				// Differentiate name from cookie driver with '_id' suffix
				$name = $config['sess_cookie_name'].'_id';
				if ($config['cookie_prefix'])
				{
					// Prepend cookie prefix
					$name = $config['cookie_prefix'].$name;
				}
				session_name($name);
			}
	
			// Set expiration, path, and domain
			$expire = 7200;
			$path = '/';
			$domain = '';
			/* tambahan */
			$cookie_httponly = false;
			$cookie_secure = false;
			/* end tambahan */
			
			if ($config['sess_expiration'] !== FALSE)
			{
				// Default to 2 years if expiration is "0"
				$expire = ($config['sess_expiration'] == 0) ? (60*60*24*365*2) : $config['sess_expiration'];
			}
	
			if ($config['cookie_path'])
			{
				// Use specified path
				$path = $config['cookie_path'];
			}
	
			if ($config['cookie_domain'])
			{
				// Use specified domain
				$domain = $config['cookie_domain'];
			}
			
			/* tambahan */
			if ($config['cookie_secure'])
			{
				// Use specified domain
				$cookie_secure = $config['cookie_secure'];
			}
			if ($config['cookie_httponly'])
			{
				// Use specified domain
				$cookie_httponly = $config['cookie_httponly'];
			}
			/* end tambahan */
			
			session_set_cookie_params($config['sess_expire_on_close'] ? 0 : $expire, $path, $domain,$cookie_secure,$cookie_httponly);
	
			// Start session
			session_start();
	
			// Check session expiration, ip, and agent
			$now = time();
			$destroy = FALSE;
			if (isset($_SESSION['last_activity']) && ($_SESSION['last_activity'] + $expire) < $now)
			{
				// Expired - destroy
				$destroy = TRUE;
			}
			elseif ($config['sess_match_ip'] === TRUE && isset($_SESSION['ip_address'])
				&& $_SESSION['ip_address'] !== $CI->input->ip_address())
			{
				// IP doesn't match - destroy
				$destroy = TRUE;
			}
			elseif ($config['sess_match_useragent'] === TRUE && isset($_SESSION['user_agent'])
				&& $_SESSION['user_agent'] !== trim(substr($CI->input->user_agent(), 0, 50)))
			{
				// Agent doesn't match - destroy
				$destroy = TRUE;
			}
	
			// Destroy expired or invalid session
			if ($destroy)
			{
				
				
				// Clear old session and start new
				$this->sess_destroy();
				if(function_exists('session_status') )
				{
					if(session_status() == PHP_SESSION_NONE)
					{
						session_start();
					}	
				}
				else if(session_id() ==''){
					session_start();
				}
			}
	
			// Check for update time
			if ($config['sess_time_to_update'] && isset($_SESSION['last_activity'])
				&& ($_SESSION['last_activity'] + $config['sess_time_to_update']) < $now)
			{
				// Regenerate ID, but don't destroy session
				$this->sess_regenerate(FALSE);
			}
	
			// Set activity time
			$_SESSION['last_activity'] = $now;
	
			// Set matching values as required
			if ($config['sess_match_ip'] === TRUE && ! isset($_SESSION['ip_address']))
			{
				// Store user IP address
				$_SESSION['ip_address'] = $CI->input->ip_address();
			}
	
			if ($config['sess_match_useragent'] === TRUE && ! isset($_SESSION['user_agent']))
			{
				// Store user agent string
				$_SESSION['user_agent'] = trim(substr($CI->input->user_agent(), 0, 50));
			}
	
			// Make session ID available
			$_SESSION['session_id'] = session_id();
			
			/* tambahan */
			if ( ! $this->_sess_read())
			{
				
				$this->_sess_create();
				
			}
			else
			{
				$this->_sess_update();
				
				
			}
			
			$this->_sess_gc();
			/* end tambahan */
		}

		// ------------------------------------------------------------------------

		/**
		 * Save the session data
		 *
		 * @return	void
		 */
		public function sess_save()
		{
			/* tambahan */
			// Check for database
			if ($this->sess_use_database === TRUE)
			{
				// Mark custom data as dirty so we know to update the DB
				$this->data_dirty = TRUE;
			}
			/* end tambahan  */
			// Nothing to do - changes to $_SESSION are automatically saved
		}
	
		// ------------------------------------------------------------------------

		/**
		 * Destroy the current session
		 *
		 * @return	void
		 */
		public function sess_destroy()
		{
			// Cleanup session
			$_SESSION = array();
			$name = session_name();
			if (isset($_COOKIE[$name]))
			{
				// Clear session cookie
				$params = session_get_cookie_params();
				//tamabahan secure sama http only
				setcookie($name, '', time() - 42000, $params['path'], $params['domain'],(bool)$params['secure'],(bool)$params['httponly']);
				unset($_COOKIE[$name]);
			}
			
			
			
			session_destroy();
			/* tambahan */
			if(function_exists('session_status') )
			{
				if(session_status() == PHP_SESSION_NONE)
				{
					session_start();
				}	
			}
			else if(session_id() ==''){
				session_start();
			}
			
			
			/* end tambahan */
		}
		
		public function sess_destroy_database()
		{
			/* tambahan */
				$session_old = isset($_SESSION['session_id'])? ($_SESSION['session_id']): false ;
				/* end tambahan */
			/* tambahan */
			if ($this->sess_use_database === TRUE && $session_old)
			{
				
				$CI =& get_instance();
				$CI->db->delete($this->sess_table_name, array('session_id' =>$session_old));
				$this->data_dirty = FALSE;
			}		
			/* end tambahan */
		}
	
		// ------------------------------------------------------------------------

		/**
		 * Regenerate the current session
		 *
		 * Regenerate the session id
		 *
		 * @param	bool	Destroy session data flag (default: FALSE)
		 * @return	void
		 */
		public function sess_regenerate($destroy = FALSE)
		{
			// Just regenerate id, passing destroy flag
			/* tambahan */
			$old_session = session_id();
			/* end tambahan */
			session_regenerate_id($destroy);
			/* tambahan */
			if ($destroy)
			{
				
				// Destroy old session and create new one
				$this->sess_destroy();
				$this->_sess_create();
			}
			else
			{
				// Just force an update to recreate the id
				$this->_sess_update(TRUE,$old_session);
			}
			/* end tambahan */
			$_SESSION['session_id'] = session_id();
		}

		// ------------------------------------------------------------------------

		/**
		 * Get a reference to user data array
		 *
		 * @return	array	Reference to userdata
		 */
		public function &get_userdata()
		{
			// Just return reference to $_SESSION
			return $_SESSION;
		}
	
		/* tambahan */
	
		public function _update_db()
		{
			$CI =& get_instance();
			// Check for database and dirty flag and unsaved
			if ($this->sess_use_database === TRUE && $this->data_dirty === TRUE)
			{
				// Set up activity and data fields to be set
				// If we don't find custom data, user_data will remain an empty string
				$set = array(
					'last_activity' => (!isset($_SESSION['last_activity'])? $this->now: $_SESSION['last_activity']),
					'user_data' => ''
				);
	
				// Get the custom userdata, leaving out the defaults
				// (which get stored in the cookie)
				$userdata = array_diff_key($_SESSION, $this->defaults);
	
				// Did we find any custom data?
				if ( ! empty($userdata))
				{
					// Serialize the custom data array so we can store it
					$set['user_data'] = $this->_serialize($userdata);
				}
	
				// Run the update query
				// Any time we change the session id, it gets updated immediately,
				// so our where clause below is always safe
				$CI->db->update($this->sess_table_name, $set, array('session_id' => isset($_SESSION['session_id'])?$_SESSION['session_id']:session_id()));
	
				// Clear dirty flag to prevent double updates
				$this->data_dirty = FALSE;
	
				log_message('debug', 'CI_Session Data Saved To DB');
			}
		}

		protected function _sess_read()
		{
			$CI =& get_instance();
			// Fetch the cookie
			$session = $_SESSION;
			
			//var_dump(isset($session['session_id'], $session['ip_address'], $session['user_agent'], $session['last_activity']));
			// Is the session data we unserialized an array with the correct format?
			if ( ! is_array($session) OR ! isset($session['session_id'], $session['user_agent'], $session['last_activity']))
			{
				$this->sess_destroy_database();
				$this->sess_destroy();
				return FALSE;
			}
	
			// Is the session current?
			if (($session['last_activity'] + $this->sess_expiration) < $this->now)
			{	
				$this->sess_destroy_database();
				$this->sess_destroy();
				return FALSE;
			}
	
			// Does the IP match?
			$match_ip = false;
			if(isset($session['ip_address']))
			{
				$match_ip = (bool)($session['ip_address'] !== $CI->input->ip_address());
			}
			
			if ($this->sess_match_ip === TRUE && $match_ip )
			{
				

				$this->sess_destroy_database();
				$this->sess_destroy();
				return FALSE;
			}
	
			// Does the User Agent Match?
			if ($this->sess_match_useragent === TRUE &&
				trim($session['user_agent']) !== trim(substr($CI->input->user_agent(), 0, 50)))
			{
				$this->sess_destroy_database();
				$this->sess_destroy();
				return FALSE;
			}
		
			// Is there a corresponding session in the DB?
			if ($this->sess_use_database === TRUE)
			{
				$CI->db->where('session_id', $session['session_id']);
	
				if ($this->sess_match_ip === TRUE)
				{
					$CI->db->where('ip_address', $session['ip_address']);
				}
	
				if ($this->sess_match_useragent === TRUE)
				{
					$CI->db->where('user_agent', $session['user_agent']);
				}
	
				// Is caching in effect? Turn it off
				$db_cache = $CI->db->cache_on;
				$CI->db->cache_off();
	
				$query = $CI->db->limit(1)->get($this->sess_table_name);
				
				// Was caching in effect?
				if ($db_cache)
				{
					// Turn it back on
					$CI->db->cache_on();
				}
	
				// No result? Kill it!
				if ($query->num_rows() === 0)
				{
					$this->sess_destroy_database();
					$this->sess_destroy();
					
					return FALSE;
				}
	
				// Is there custom data? If so, add it to the main session array
				$row = $query->row();
				if ( ! empty($row->user_data))
				{
					$custom_data = $this->_unserialize($row->user_data);
	
					if (is_array($custom_data))
					{
						$session = $session + $custom_data;
					}
				}
			}
	
			return TRUE;
		}

		protected function _sess_create()
		{
			$CI =& get_instance();
			// Initialize userdata
			
			$this->userdata = array(
				'session_id'	=> session_id(),
				'ip_address'	=> $CI->input->ip_address(),
				'user_agent'	=> substr($CI->input->user_agent(), 0, 50),
				'last_activity'	=> $this->now,
			);
			
			
			// Check for database
			if ($this->sess_use_database === TRUE)
			{
				// Add empty user_data field and save the data to the DB
				$CI->db->set('user_data', '')->insert($this->sess_table_name, $this->userdata);
			}
	
		}
		
		protected function _sess_update($force = FALSE,$old_session=null)
		{
			$CI =& get_instance();
			// We only update the session every five minutes by default (unless forced)
			if ( ! $force && ($_SESSION['last_activity'] + $this->sess_time_to_update) >= $this->now)
			{
				return;
			}
	
			// Update last activity to now
			$_SESSION['last_activity'] = $this->now;
		
			// Save the old session id so we know which DB record to update
			$old_sessid = ($old_session)? $old_session:session_id();
	
			// Check for database
			if ($this->sess_use_database === TRUE)
			{
				
				// Update the session ID and last_activity field in the DB
				$CI->db->update($this->sess_table_name, array(
						 'last_activity' => $this->now,
						 'session_id' => session_id()
				), array('session_id' => $old_sessid));
			}
	
		}
	
		protected function _get_time()
		{
			if ($this->time_reference === 'local' OR $this->time_reference === date_default_timezone_get())
			{
				return time();
			}
	
			$datetime = new DateTime('now', new DateTimeZone($this->time_reference));
			sscanf($datetime->format('j-n-Y G:i:s'), '%d-%d-%d %d:%d:%d', $day, $month, $year, $hour, $minute, $second);
	
			return mktime($hour, $minute, $second, $month, $day, $year);
		}

		protected function _serialize($data)
		{
			if (is_array($data))
			{
				array_walk_recursive($data, array(&$this, '_escape_slashes'));
			}
			elseif (is_string($data))
			{
				$data = str_replace('\\', '{{slash}}', $data);
			}
	
			return serialize($data);
		}
	
		/**
		 * Escape slashes
		 *
		 * This function converts any slashes found into a temporary marker
		 *
		 * @param	string	Value
		 * @param	string	Key
		 * @return	void
		 */
		protected function _escape_slashes(&$val, $key)
		{
			if (is_string($val))
			{
				$val = str_replace('\\', '{{slash}}', $val);
			}
		}
	
		// ------------------------------------------------------------------------

		/**
		 * Unserialize
		 *
		 * This function unserializes a data string, then converts any
		 * temporary slash markers back to actual slashes
		 *
		 * @param	mixed	Data to unserialize
		 * @return	mixed	Unserialized data
		 */
		protected function _unserialize($data)
		{
			$data = @unserialize(strip_slashes(trim($data)));
	
			if (is_array($data))
			{
				array_walk_recursive($data, array(&$this, '_unescape_slashes'));
				return $data;
			}
	
			return is_string($data) ? str_replace('{{slash}}', '\\', $data) : $data;
		}

		// ------------------------------------------------------------------------
	
		/**
		 * Unescape slashes
		 *
		 * This function converts any slash markers back into actual slashes
		 *
		 * @param	string	Value
		 * @param	string	Key
		 * @return	void
		 */
		protected function _unescape_slashes(&$val, $key)
		{
			if (is_string($val))
			{
		 		$val= str_replace('{{slash}}', '\\', $val);
			}
		}
	
		
		/**
		 * Garbage collection
		 *
		 * This deletes expired session rows from database
		 * if the probability percentage is met
		 *
		 * @return	void
		 */
		protected function _sess_gc()
		{
			if ($this->sess_use_database !== TRUE)
			{
				return;
			}
			$CI =& get_instance();
			//update database user_id
			if(isset($_SESSION['user_id']) )
			{
				//remove is session_id && user_id !same &7 !last_activity
				$data_old = $CI->db->where(array('session_id !=' =>$_SESSION['session_id'],'user_id'=>$_SESSION['user_id']))->count_all_results($this->sess_table_name);
				
				//check is group admin
				$is_admin = ((bool) isset($_SESSION['group']) && $_SESSION['group'] =='admin');
				if( $data_old && !$is_admin )
				{
					$CI->db->delete($this->sess_table_name, array('session_id !=' =>$_SESSION['session_id'],'user_id'=>$_SESSION['user_id']));
				}
				
				if($CI->db->where(array('session_id'=>$_SESSION['session_id'],'user_id'=>  NULL))->count_all_results($this->sess_table_name ) == 1)
				{
					
					$CI->db->update($this->sess_table_name, array(
						 'user_id' => $_SESSION['user_id'],
					 ), array('session_id' => $_SESSION['session_id']));
				}
								
				
			}
	
			$probability = ini_get('session.gc_probability');
			$divisor = ini_get('session.gc_divisor');
			
			
			srand(time());
			if ((mt_rand(0, $divisor) / $divisor) < $probability)
			{
				$expire = $this->now - $this->sess_expiration;
				$CI->db->delete($this->sess_table_name, 'last_activity < '.$expire);
	
				log_message('debug', 'Session garbage collection performed.');
			}
		}
	/* end tambahan */

}

/* End of file Session_native.php */
/* Location: ./system/libraries/Session/drivers/Session_native.php */