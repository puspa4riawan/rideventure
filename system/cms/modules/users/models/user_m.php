<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * The User model.
 *
 * @author MaxCMS Dev Team
 * @package MaxCMS\Core\Modules\Users\Models
 */
class User_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->profile_table = $this->db->dbprefix('profiles');
	}

	// --------------------------------------------------------------------------

	/**
	 * Get a specified (single) user
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function get($params)
	{
		if (isset($params['id']))
		{
			$this->db->where('users.id', $params['id']);
		}

		if (isset($params['email']))
		{
			$this->db->where('LOWER('.$this->db->dbprefix('users.email').')', strtolower($params['email']));
		}

		if (isset($params['role']))
		{
			$this->db->where('users.group_id', $params['role']);
		}

		$this->db
			->select($this->profile_table.'.*, users.*')
			->limit(1)
			->join('profiles', 'profiles.user_id = users.id', 'left');

		return $this->db->get('users')->row();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get recent users
	 *
	 * @param     int  $limit defaults to 10
	 *
	 * @return     object
	 */
	public function get_recent($limit = 10)
	{
		$this->db->order_by('users.created_on', 'desc');
		$this->db->limit($limit);
		return $this->get_all();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get all user objects
	 *
	 * @return object
	 */
	public function get_all()
	{
		$this->db
			->select($this->profile_table.'.*, g.description as group_name, users.*')
			->join('groups g', 'g.id = users.group_id')
			->join('profiles', 'profiles.user_id = users.id', 'left')
			->group_by('users.id');

		return parent::get_all();
	}

	// --------------------------------------------------------------------------

	/**
	 * Create a new user
	 *
	 * @param array $input
	 *
	 * @return int|true
	 */
	public function add($input = array())
	{
		$this->load->helper('date');

		return parent::insert(array(
			'email' => $input->email,
			'password' => $input->password,
			'salt' => $input->salt,
			'role' => empty($input->role) ? 'user' : $input->role,
			'active' => 0,
			'lang' => $this->config->item('default_language'),
			'activation_code' => $input->activation_code,
			'created_on' => now(),
			'last_login' => now(),
			'ip' => $this->input->ip_address()
		));
	}

	// --------------------------------------------------------------------------

	/**
	 * Update the last login time
	 *
	 * @param int $id
	 */
	public function update_last_login($id)
	{
		$this->db->update('users', array('last_login' => now()), array('id' => $id));
	}

	// --------------------------------------------------------------------------

	/**
	 * Activate a newly created user
	 *
	 * @param int $id
	 *
	 * @return bool
	 */
	public function activate($id)
	{
		return parent::update($id, array('active' => 1, 'activation_code' => ''));
	}

	// --------------------------------------------------------------------------

	/**
	 * Count by
	 *
	 * @param array $params
	 *
	 * @return int
	 */
	public function count_by($params = array())
	{
		$this->db->from($this->_table)
			->join('profiles', 'users.id = profiles.user_id', 'left');

		if (isset($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'];
			$this->db->where('users.active', $params['active']);
		}

		if (isset($params['is_blogger']))
		{
			$this->db->where('profiles.is_blogger', $params['is_blogger']);
		}

		if (isset($params['is_expert']))
		{
			$this->db->where('profiles.is_expert', $params['is_expert']);
		}

		if (isset($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}

		if (isset($params['name']))
		{
			$this->db
				->like('users.username', trim($params['name']))
				->or_like('users.email', trim($params['name']))
				->or_like('profiles.first_name', trim($params['name']))
				->or_like('profiles.last_name', trim($params['name']));
		}

		if(isset($params['date_start'])){
			$arr_date = explode('-', $params['date_start']);
			$date = $arr_date[2].'-'.$arr_date[1].'-'.$arr_date[0].' 00:00:00';
			$this->db->where('users.created_on >=', strtotime($date));
		}

		if(isset($params['date_end'])){
			$arr_date = explode('-', $params['date_end']);
			$date = $arr_date[2].'-'.$arr_date[1].'-'.$arr_date[0].' 24:00:00';
			$this->db->where('users.created_on <=', strtotime($date));
		}

		return $this->db->count_all_results();
	}

	// --------------------------------------------------------------------------

	/**
	 * Get by many
	 *
	 * @param array $params
	 *
	 * @return object
	 */
	public function get_many_by($params = array())
	{
		if (isset($params['active']))
		{
			$params['active'] = $params['active'] === 2 ? 0 : $params['active'];
			$this->db->where('active', $params['active']);
		}

		if ( isset($params['group_id']))
		{
			$this->db->where('group_id', $params['group_id']);
		}
		if ( isset($params['user_id']))
		{
			$this->db->where('users.id', $params['user_id']);
		}

		if ( isset($params['name']))
		{
			$this->db
				->or_like('users.username', trim($params['name']))
				->or_like('users.email', trim($params['name']));
		}

		if (isset($params['is_blogger']))
		{
			$this->db->where('profiles.is_blogger', $params['is_blogger']);
		}

		if (isset($params['is_expert']))
		{
			$this->db->where('profiles.is_expert', $params['is_expert']);
		}

		if ( isset($params['sorted_by'])){
			if($params['sorted_by']=='created'){
				$this->db->order_by('created_on', $params['sorted']);
			}
			if($params['sorted_by']=='total'){
				$this->db->order_by('total_point', $params['sorted']);
			}
			if($params['sorted_by']=='point'){
				$this->db->order_by('point', $params['sorted']);
			}
		}

		if(isset($params['date_start'])){
			$arr_date = explode('-', $params['date_start']);
			$date = $arr_date[2].'-'.$arr_date[1].'-'.$arr_date[0].' 00:00:00';
			$this->db->where('users.created_on >=', strtotime($date));
		}

		if(isset($params['date_end'])){
			$arr_date = explode('-', $params['date_end']);
			$date = $arr_date[2].'-'.$arr_date[1].'-'.$arr_date[0].' 24:00:00';
			$this->db->where('users.created_on <=', strtotime($date));
		}

		return $this->get_all();
	}

	public function get_single_data($params, $table){

        $this->db->where($params);
        return $this->db->get($table)->row();
    }

    public function insert_data($table, $data){

        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function get_all_data($table){

        $this->db
			->select('*');

		return $this->db->get($table)->result();
    }

    public function update_data($table, $data, $field, $id){

        return $this->db->update($table, $data, $field.' = '.$id);
    }

    public function get_all_user_export() {
		$this->db
			 ->select(
				'users.*,
				profiles.display_name,
				profiles.first_name,
				profiles.last_name,
				profiles.phone,
				profiles.address_line1,
				profiles.address_line2,
				profiles.tw_id,
				profiles.tw_screen_name,
				profiles.fb_id,
				profiles.gplus_id,
				profiles.photo_profile,
				profiles.address_line3,
				profiles.address_line4,
				profiles.dob,
				profiles.postcode,
				profiles.tgl,
				profiles.bulan,
				profiles.tahun,
				profiles.total_point,
				profiles.eways_id,
				profiles.address_line3,
				profiles.address_line4,
				profiles.merk_susu,
				kids_user.name_kids_first,
				kids_user.tgl_kids_first,
				kids_user.bulan_kids_first,
				kids_user.tahun_kids_first,
				kids_user.jk_kids_first,
				kids_user.name_kids_second,
				kids_user.tgl_kids_second,
				kids_user.bulan_kids_second,
				kids_user.tahun_kids_second,
				kids_user.jk_kids_second,
				kids_user.name_kids_third,
				kids_user.tgl_kids_third,
				kids_user.bulan_kids_third,
				kids_user.tahun_kids_third,
				kids_user.jk_kids_third,
				location_kota.kota_name,
				location_provinsi.provinsi_name'
			)
			 ->where(array('users.active'=>1, 'users.group_id'=>2))
			 ->join('profiles', 'profiles.user_id=users.id')
			 ->join('location_kota', 'location_kota.kota_id=profiles.address_line4', 'left')
			 ->join('location_provinsi', 'location_provinsi.provinsi_id=profiles.address_line3', 'left')
			 ->join('kids_user', 'kids_user.user_id=users.id', 'left');

		return $this->db->get('users')->result();
	}

	public function verify($id){
		return $this->db->update('users', array('group_id'=>3), array('id'=>$id));
	}

	public function verify_expert($id, $email)
	{
		$doctor = $this->db
			->where('doctor_email', $email)
			->get('ae_doctors')
			->row();

		if ($doctor) {
			$this->db->update('ae_doctors', array('user_id' => $id), array('doctor_id' => $doctor->doctor_id));
			$this->db->update('users', array('group_id' => 5), array('id' => $id));

			return true;
		}

		return false;
	}

	public function checkUtmUsers($limit, $offset)
	{
		// Kondisi #5: 18-09-2017 (1505692800)
		// Kondisi #4: 01-10-2017 (1506816000)
		// Kondisi #3: 01-10-2017 (1506816000)
		// Kondisi #2: 30-08-2017 (1504051200)
		// Kondisi #1: 01-07-2017 (1498867200)
		$from = 1505692800;
		// Kondisi #5: 30-09-2017 (1506815999)
		// Kondisi #4: 06-10-2017 (1507334399)
		// Kondisi #3: 05-10-2017 (1507247999)
		// Kondisi #2: 05-09-2017 (1504655999)
		// Kondisi #1: 19-07-2017 (1500508799)
		$to = 1506815999;
		$counter = 1;

		$users = $this->db
			->select('u.id, u.created_on, u.username')
			->from('users u')
			->join('utm ut', 'ut.user_id = u.id', 'left')
			->where('u.active', 1)
			->where('u.created_on >=', $from)
			->where('u.created_on <=', $to)
			->limit($limit, $offset)
			->get()
			->result();

		if ($users) {
			foreach ($users as $user) {
				//------ Kondisi #1
				/*$valid = $this->db->get_where('utm', array('user_id' => $user->id))->num_rows();

				if ($valid === 0) {
					$date = date('Y-m-d H:i:s', $user->created_on);
					$utmData = array(
						'user_id' 	=> $user->id,
						'campaign'	=> '',
						'medium'	=> '',
						'source'	=> '',
						'content'	=> '',
						'term'		=> '',
						'status'	=> 0,
						'created'	=> $date,
						'updated'	=> $date,
						'activated'	=> $date
					);

					$this->db->insert('utm', $utmData);
					$utmId = $this->db->insert_id();

					if ($utmId) {
						$utmCode = $this->db
							->where('status', 0)
							->limit(1, 0)
							->get('utm_code')
							->row();

						$utmDataUpdate = array(
							'code_id' => $utmCode->id,
							'status'  => 1
						);

						$this->db->update('utm', $utmDataUpdate, array('user_id' => $user->id));

						$utmCodeUpdate = array(
							'user_id' 	=> $user->id,
							'status'	=> 1,
							'activated' => $date,
							'updated'	=> $date
						);

						$this->db->update('utm_code', $utmCodeUpdate, array('id' => $utmCode->id));
					}

					echo $counter.PHP_EOL;
					$counter++;
				}*/
				//------ Kondisi #1

				//------ Kondisi #2 & #3
				/*$valid = $this->db->get_where('utm', array('user_id' => $user->id))->row();

				if ($valid && !$valid->code_id) {
					$date = date('Y-m-d H:i:s', $user->created_on);
					$utmCode = $this->db
						->where('status', 0)
						->limit(1, 0)
						->get('utm_code')
						->row();

					if ($utmCode) {
						$utmDataUpdate = array(
							'code_id' => $utmCode->id,
							'status'  => 1
						);

						$this->db->update('utm', $utmDataUpdate, array('user_id' => $user->id));

						$utmCodeUpdate = array(
							'user_id' 	=> $user->id,
							'status'	=> 1,
							'activated' => $date,
							'updated'	=> $date
						);

						$this->db->update('utm_code', $utmCodeUpdate, array('id' => $utmCode->id));

						echo $counter.PHP_EOL;
						$counter++;
					}
				}*/
				//------ Kondisi #2 & #3

				//------ Kondisi #4
				/*$valid = $this->db
					->select('*')
					->from('utm_code')
					->where('user_id', $user->id)
					->get()
					->result();

				if (count($valid) > 1) {
					foreach ($valid as $test) {
						if (preg_match('/WNPC3/', $test->code)) {
							$invalidate = array(
								'user_id'   => null,
								'status'    => 2,
								'activated' => null
							);

							$this->db->update('utm_code', $invalidate, array('id' => $test->id));

							$e_voucher = 'uploads/e_voucher/'.$user->username.'.png';
							$saved_voucher_path = './'.$e_voucher;

							if (is_file($saved_voucher_path)) {
								unlink($saved_voucher_path);

								echo $counter.PHP_EOL;
								$counter++;
							}
						}
					}
				}*/
				//------ Kondisi #4

				//------ Kondisi #5
				$valid = $this->db
					->select('*')
					->from('utm_code')
					->where('user_id', $user->id)
					->get()
					->row();

				if ($valid) {
					if (preg_match('/WNPC3/', $valid->code)) {
						$invalidate = array(
							'user_id'   => null,
							'status'    => 2,
							'activated' => null
						);

						$this->db->update('utm_code', $invalidate, array('id' => $valid->id));

						$date = date('Y-m-d H:i:s', $user->created_on);
						$utmCode = $this->db
							->where('status', 0)
							->limit(1, 0)
							->get('utm_code')
							->row();

						if ($utmCode) {
							$utmDataUpdate = array(
								'code_id' => $utmCode->id,
								'status'  => 1
							);

							$this->db->update('utm', $utmDataUpdate, array('user_id' => $user->id));

							$utmCodeUpdate = array(
								'user_id' 	=> $user->id,
								'status'	=> 1,
								'activated' => $date,
								'updated'	=> $date
							);

							$this->db->update('utm_code', $utmCodeUpdate, array('id' => $utmCode->id));

							$e_voucher = 'uploads/e_voucher/'.$user->username.'.png';
							$saved_voucher_path = './'.$e_voucher;

							if (is_file($saved_voucher_path)) {
								unlink($saved_voucher_path);

								echo 'old voucher img deleted'.PHP_EOL;
							}

							echo $counter.PHP_EOL;
							$counter++;
						}
					}
				}
				//------ Kondisi #5
			}
		}

		return;
	}

	public function get_asks_data($params = array())
	{
		$this->db
			->select('a.*, p.display_name, p.photo_profile, d.doctor_image, s.speciality_title, s.speciality_slug')
			->from('ae_ask a')
			->join('profiles p', 'p.user_id = a.user_id', 'left')
			->join('ae_doctors d', 'd.doctor_id = a.doctor_id', 'left')
			->join('ae_doctor_specialities s', 's.speciality_id = d.speciality_id', 'left');

		if (isset($params['super_admin'])) {
			if (!$params['super_admin']) {
				if (isset($params['doctor_id'])) {
					$this->db->where('a.doctor_id', $params['doctor_id']);
				} else {
					$this->db->reset_query();

					return array();
				}
			} else {
				// if (!isset($params['doctor_id'])) {
				// 	$this->db->reset_query();

				// 	return array();
				// }

				if (isset($params['doctor_id']) && $params['doctor_id'] > 0) {
					$this->db->where('a.doctor_id', $params['doctor_id']);
				}
			}
		}

		if (isset($params['status']) && $params['status'] !== 'all') {
			$this->db->where('a.answer_status', $params['status']);
		}

		if (isset($params['limit'], $params['offset'])) {
			$this->db->limit($params['limit'], $params['offset']);
		}

		if (isset($params['order']) && is_array($params['order'])) {
			$this->db->order_by($params['order'][0], $params['order'][1]);
		}

		return $this->db->get()->result();
	}

	public function get_doctor_details($user_id)
	{
		return $this->db
			->select('d.*, s.speciality_title, s.speciality_slug')
			->from('ae_doctors d')
			->join('ae_doctor_specialities s', 's.speciality_id = d.speciality_id', 'left')
			->where('user_id', $user_id)
			->get()
			->row();
	}
}
