<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * User Plugin
 *
 * Run checks on a users status
 *
 * @author  MaxCMS Dev Team
 * @package MaxCMS\Core\Plugins
 */
class Plugin_User extends Plugin
{

	public $version = '1.0.0';
	public $name = array(
		'en' => 'User',
	);
	public $description = array(
		'en' => 'Access current user profile variables and settings.',
		'br' => 'Acessa variáveis e configurações do perfil do usuário atual.',
		'el' => 'Πρόσβαση σε μεταβλητές και ρυθμίσεις προφίλ του εκάστοτε χρήστη.',
            'fa' => 'دسترسی به پروفایل کاربر حاضر و تنظیمات',
		'fr' => 'Accéder aux données de l\'utilisateur courant.',
		'it' => 'Accedi alle variabili del profilo e alle impostazioni dell\'utente corrente'
	);

	/**
	 * Returns a PluginDoc array that MaxCMS uses
	 * to build the reference in the admin panel
	 *
	 * All options are listed here but refer
	 * to the Blog plugin for a larger example
	 *
	 * @todo fill the  array with details about this plugin, then uncomment the return value.
	 * @todo  I did the __call magic method... the others still need to be documented
	 *
	 * @return array
	 */
	public function _self_doc()
	{
		$info = array();

		// dynamically build the array for the magic method __call
		$user = (array) $this->current_user;
		ksort($user);

		foreach ($user as $key => $value)
		{
			if (in_array($key, array('password', 'salt'))) continue;

			$info[$key]['description'] = array(
				'en' => 'Displays the '.$key.' for the current user.',
				'br' => 'Exibe o campo "'.$key.'" do usuário atual.'
			);
			$info[$key]['single'] = true;
			$info[$key]['double'] = (is_array($value) ? true : false);
			$info[$key]['variables'] = (is_array($value) ? implode('|', array_keys($value)) : '');
			$info[$key]['params'] = array();
		}

		return $info;
	}

	/**
	 * Array of data for the currently
	 * logged in user.
	 */
	public $user_profile_data = array();

	/**
	 * Logged in
	 *
	 * See if a user is logged in as an if or two-part tag.
	 *
	 * Usage:
	 *
	 *     {{ user:logged_in group="admin" }}
	 *         <p>Hello admin!</p>
	 *     {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function logged_in()
	{
		$group = $this->attribute('group', null);

		if ($this->current_user)
		{
			if ($group and $group !== $this->current_user->group)
			{
				return '';
			}

			return $this->content() ? $this->content() : true;
		}

		return '';
	}

	/**
	 * Not logged in
	 *
	 * See if a user is logged out or not part of a group
	 *
	 * Usage:
	 *
	 *     {{ user:not_logged_in group="admin" }}
	 *            <p>Hello not an admin</p>
	 *     {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function not_logged_in()
	{
		$group = $this->attribute('group', null);

		// Logged out or not the right user
		if (!$this->current_user or ($group and $group !== $this->current_user->group))
		{
			return $this->content() ? $this->content() : true;
		}

		return '';
	}

	/**
	 * Has Control Panel permissions
	 *
	 * See if a user can access the control panel.
	 *
	 * Usage:
	 *
	 *     {{ user:has_cp_permissions}}
	 *         <a href="/admin">Access the Control Panel</a>
	 *     {{ endif }}
	 *
	 * @return boolean State indicator.
	 */
	public function has_cp_permissions()
	{
		if ($this->current_user)
		{
			if (!(($this->current_user->group == 'admin') or $this->permission_m->get_group($this->current_user->group_id)))
			{
				return '';
			}

			return $this->content() ? $this->content() : true;
		}

		return '';
	}

	public function profile_fields()
	{
		$profile_data = $this->get_user_profile(false);

		if (is_null($profile_data))
		{
			return null;
		}

		$this->lang->load('streams_core/maxstreams');
		$this->lang->load('users/user');

		$plugin_data = array();

		$plugin_data[] = array(
			'value' => $profile_data['email'],
			'name'  => lang('global:email'),
			'slug'  => 'email'
		);

		$plugin_data[] = array(
			'value' => $profile_data['username'],
			'name'  => lang('user:username'),
			'slug'  => 'username'
		);

		$plugin_data[] = array(
			'value' => $profile_data['group_description'],
			'name'  => lang('user:group_label'),
			'slug'  => 'group_name'
		);

		$plugin_data[] = array(
			'value' => date(Settings::get('date_format'), $profile_data['last_login']),
			'name'  => lang('profile_last_login_label'),
			'slug'  => 'last_login'
		);

		$plugin_data[] = array(
			'value' => date(Settings::get('date_format'), $profile_data['created_on']),
			'name'  => lang('profile_registred_on_label'),
			'slug'  => 'registered_on'
		);

		// Display name and updated on
		$plugin_data[] = array(
			'value' => $profile_data['display_name'],
			'name'  => lang('profile_display_name'),
			'slug'  => 'display_name'
		);
		$plugin_data[] = array(
			'value' => date(Settings::get('date_format'), $profile_data['updated_on']),
			'name'  => lang('profile_updated_on'),
			'slug'  => 'updated_on'
		);

		foreach ($this->ion_auth_model->user_stream_fields as $key => $field)
		{
			if (!isset($profile_data[$key]))
			{
				continue;
			}

			$name = (lang($field->field_name)) ? $this->lang->line($field->field_name) : $field->field_name;

			$plugin_data[] = array(
				'value' => $profile_data[$key],
				'name'  => $this->fields->translate_label($name),
				'slug'  => $field->field_slug
			);

			unset($name);
		}

		return $plugin_data;
	}

	// --------------------------------------------------------------------------

	/**
	 * Allows usage of full user variables inside of a tag pair.
	 *
	 * Usage:
	 *
	 *     {{ user:profile }}
	 *         {{ variable }}
	 *     {{ /user:profile }}
	 *
	 * @return string
	 */
	public function profile()
	{
		// We can't parse anything if there is no content.
		if ( ! $this->content())
		{
			return null;
		}

		$profile_data = $this->get_user_profile();

		if (is_null($profile_data))
		{
			return null;
		}

		$this->load->driver('Streams');

		// Dumb hack that should be goine in 2.2
		$profile_data['user_id'] = $profile_data['id'];
		$profile_data['id']      = $profile_data['profile_id'];

		return $this->streams->parse->parse_tag_content($this->content(), $profile_data, 'profiles', 'users', false);
	}

	/**
	 * Get a user's profile data.
	 *
	 * Function shared by single user profile tags as well as the tag pair.
	 * Takes care of runtime caching as well.
	 *
	 * @param bool $plugin_call does this need to be processed with full plugin vars?
	 *
	 * @return array
	 */
	private function get_user_profile($plugin_call = true)
	{
		$user_id = $this->attribute('user_id', null);

		// If we do not have a user id and there is
		// no currently logged in user, there is nothing to display.
		if (is_null($user_id) and !isset($this->current_user->id))
		{
			return null;
		}
		elseif (is_null($user_id) and isset($this->current_user->id))
		{
			// Otherwise, we can use the current user id
			$user_id = $this->current_user->id;
		}

		$user = $this->ion_auth_model->get_user($user_id)->row_array();

		// Nobody needs these as profile fields.
		unset($user['password']);
		unset($user['salt']);
		unset($user['remember_code']);

		// Got through each stream field and see if we need to format it
		// for plugin return (ie if we haven't already done that).
		foreach ($this->ion_auth_model->user_stream_fields as $field_key => $field_data)
		{
			if ($plugin_call)
			{
				if (!isset($this->user_profile_data[$user_id]['plugin'][$field_key]) and isset($user[$field_key]))
				{
					$this->user_profile_data[$user_id]['plugin'][$field_key] = $this->row_m->format_column(
							$field_key, $user[$field_key], $user['profile_id'], $field_data->field_type, $field_data->field_data, $this->ion_auth_model->user_stream, true);
				}

				if (isset($user[$field_key]))
				{
					$user[$field_key] = $this->user_profile_data[$user_id]['plugin'][$field_key];
				}
			}
			else
			{
				if (!isset($this->user_profile_data[$user_id]['pre_formatted'][$field_key]) and isset($user[$field_key]))
				{
					$this->user_profile_data[$user_id]['pre_formatted'][$field_key] = $this->row_m->format_column(
							$field_key, $user[$field_key], $user['profile_id'], $field_data->field_type, $field_data->field_data, $this->ion_auth_model->user_stream, false);
				}

				if (isset($user[$field_key]))
				{
					$user[$field_key] = $this->user_profile_data[$user_id]['pre_formatted'][$field_key];
				}
			}
		}

		return $user;
	}

	/**
	 * Get a single user variable
	 *
	 * @param string $var     The variable to get
	 * @param int    $user_id The id of the user
	 *
	 * @return string The formatted column
	 */
	private function get_user_var($var, $user_id)
	{
		if (isset($this->user_profile_data[$user_id]['plugin'][$var]))
		{
			return $this->user_profile_data[$user_id]['plugin'][$var];
		}

		$user = $this->ion_auth_model->get_user($user_id)->row_array();

		// Is this a user stream field?
		if (array_key_exists($var, $this->ion_auth_model->user_stream_fields))
		{
			$formatted_column = $this->row_m->format_column(
					$var, $user[$var], $user['profile_id'], $this->ion_auth_model->user_stream_fields->{$var}->field_type, $this->ion_auth_model->user_stream_fields->{$var}->field_data, $this->ion_auth_model->user_stream, true
			);
		}
		else
		{
			$formatted_column = $user[$var];
		}

		// Save for later user
		$this->user_profile_data[$user_id]['plugin'][$var] = $formatted_column;

		if (is_array($formatted_column))
		{
			return array($formatted_column);
		}

		return $formatted_column;
	}

	/**
	 * Load a variable
	 *
	 * Magic method to get a user variable.
	 * This is where the user_id gets set to the current user if none is specified.
	 *
	 * @param string $name
	 * @param string $data
	 *
	 * @return string
	 */
	public function __call($name, $data)
	{
		if (in_array($name, array('password', 'salt', 'remember_code')))
		{
			return;
		}

		$user_id = $this->attribute('user_id', null);

		// If we do not have a user id and there is
		// no currently logged in user, there's nothing we can do
		if (is_null($user_id) and !isset($this->current_user->id))
		{
			return null;
		}
		elseif (is_null($user_id) and isset($this->current_user->id))
		{
			// Otherwise, we can use the current user id
			$user_id = $this->current_user->id;

			// but first, is it data we already have? (such as user:username)
			if (isset($this->current_user->{$name}))
			{
				return $this->current_user->{$name};
			}
		}

		// we're fetching a different user than the currently logged in one
		return $this->get_user_var($name, $user_id);
	}

	public function getUserCount() {
		$this->load->model(array('users/profile_m'));
		$base_where = array();

		/*if($this->input->post('f_kids')){
			$base_where['kids'] = $this->input->post('f_kids');
		}

		if($this->input->post('f_kidsage')){
			$base_where['kidsage'] = $this->input->post('f_kidsage');
		}*/

		if($this->input->post('f_from')){
			$base_where['from'] = $this->input->post('f_from');
			$base_where_abl['date_start'] = $this->input->post('f_from');
		}

		if($this->input->post('f_to')){
			$base_where['to'] = $this->input->post('f_to');
			$base_where_abl['date_end'] = $this->input->post('f_to');
		}

		//one kid 0-2year
		$base_where['kids'] = 1;
		$base_where['kidsage'] = 1;
		$total_onekid_02year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//one kid 3-4year
		$base_where['kids'] = 1;
		$base_where['kidsage'] = 2;
		$total_onekid_34year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//one kid 5-6year
		$base_where['kids'] = 1;
		$base_where['kidsage'] = 3;
		$total_onekid_56year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//two kids 0-2year
		$base_where['kids'] = 2;
		$base_where['kidsage'] = 1;
		$total_twokids_02year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//two kids 3-4year
		$base_where['kids'] = 2;
		$base_where['kidsage'] = 2;
		$total_twokids_34year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//two kids 5-6year
		$base_where['kids'] = 2;
		$base_where['kidsage'] = 3;
		$total_twokids_56year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//three kids 0-2year
		$base_where['kids'] = 3;
		$base_where['kidsage'] = 1;
		$total_threekids_02year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//three kids 3-4year
		$base_where['kids'] = 3;
		$base_where['kidsage'] = 2;
		$total_threekids_34year = null; // $this->profile_m->get_count($base_where)->num_rows();

		//three kids 5-6year
		$base_where['kids'] = 3;
		$base_where['kidsage'] = 3;
		$total_threekids_56year = null; // $this->profile_m->get_count($base_where)->num_rows();

		$nokid = null; // $this->profile_m->nokid_count($base_where)->num_rows();
		$pregnant = null; // $this->profile_m->pregnant_count($base_where)->row('count');

		$base_where_abl['status'] = 'completed';

		$base_where_abl['smart_cat_slug'] = 'music-smart';
		$abl_result_music = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'people-smart';
		$abl_result_people = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'self-smart';
		$abl_result_self = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'number-smart';
		$abl_result_number = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'word-smart';
		$abl_result_word = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'nature-smart';
		$abl_result_nature = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'body-smart';
		$abl_result_body = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_abl['smart_cat_slug'] = 'picture-smart';
		$abl_result_picture = array(); // $this->ability_finder_m->get_data_abl_result($base_where_abl)->num_rows();

		$base_where_parents = array('group_id' => 2);
		$total_parents = $this->profile_m->get_parents_counter($base_where_parents)->num_rows();

		// $base_where_parents['active'] = 1;
		// $base_where_parents['gender'] = 'f';
		// $total_mam_active = $this->profile_m->get_parents_counter($base_where_parents)->num_rows();

		$sq = "SELECT count(*) as total_mam_active FROM `default_users` `u` LEFT JOIN `default_profiles` `p` ON `p`.`user_id` = `u`.`id` WHERE `u`.`group_id` = 2 AND `u`.`active` = 1 AND `p`.`gender` = 'f'";
		$total_mam_active = $this->db->query($sq)->row()->total_mam_active;

		$base_where_parents['active'] = 0;
		$base_where_parents['gender'] = 'f';
		$total_mam_inactive = $this->profile_m->get_parents_counter($base_where_parents)->num_rows();

		$base_where_parents['active'] = 1;
		$base_where_parents['gender'] = 'm';
		$total_pap_active = $this->profile_m->get_parents_counter($base_where_parents)->num_rows();

		$base_where_parents['active'] = 0;
		$base_where_parents['gender'] = 'm';
		$total_pap_inactive = $this->profile_m->get_parents_counter($base_where_parents)->num_rows();

		$base_where_blogger = array('group_id' => 3);
		$total_blogger = $this->profile_m->get_parents_counter($base_where_blogger)->num_rows();

		$data = array(
			'total_onekid_02year' => $total_onekid_02year,
			'total_onekid_34year' => $total_onekid_34year,
			'total_onekid_56year' => $total_onekid_56year,
			'total_twokids_02year' => $total_twokids_02year,
			'total_twokids_34year' => $total_twokids_34year,
			'total_twokids_56year' => $total_twokids_56year,
			'total_threekids_02year' => $total_threekids_02year,
			'total_threekids_34year' => $total_threekids_34year,
			'total_threekids_56year' => $total_threekids_56year,
			'abl_result_music' => $abl_result_music,
			'abl_result_people' => $abl_result_people,
			'abl_result_self' => $abl_result_self,
			'abl_result_number' => $abl_result_number,
			'abl_result_word' => $abl_result_word,
			'abl_result_nature' => $abl_result_nature,
			'abl_result_body' => $abl_result_body,
			'abl_result_picture' => $abl_result_picture,
			'nokid' => $nokid,
			'pregnant' => $pregnant,
			'total_parents' => $total_parents,
			'total_mam_active' => $total_mam_active,
			'total_mam_inactive' => $total_mam_inactive,
			'total_pap_active' => $total_pap_active,
			'total_pap_inactive' => $total_pap_inactive,
			'total_blogger' => $total_blogger
		);

		return $this->load->view('users/admin_count/plugin', $data, true);
	}
}