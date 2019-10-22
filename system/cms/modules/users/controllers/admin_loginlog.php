<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin controller for the users module
 *
 * @author		 MaxCMS Dev Team
 * @package	 MaxCMS\Core\Modules\Users\Controllers
 */
class Admin_loginlog extends Admin_Controller
{

	protected $section = 'login_log';

	/**
	 * Constructor method
	 */
	public function __construct()
	{
		parent::__construct();

		// Load the required classes
		$this->load->model(array('profile_m', 'ion_auth_model'));
	}

	/**
	 * List all users
	 */
	public function index()
	{
		$base_where = array();

		if($this->input->post('f_keywords')){
			$base_where['keywords'] = $this->input->post('f_keywords');
		}

		if($this->input->post('f_from')){
			$base_where['from'] = (int)$this->input->post('f_from');
		}

		if($this->input->post('f_to')){
			$base_where['to'] = $this->input->post('f_to');
		}

		// Create pagination links
		$total_rows = $this->profile_m->get_log('login', $base_where)->num_rows();
		$pagination = create_pagination(ADMIN_URL.'/users/login_log/index', $total_rows, Settings::get('records_per_page'), 5);

		// Using this data, get the relevant results
		$this->db->limit($pagination['limit'], $pagination['offset']);
		$log = $this->profile_m->get_log('login', $base_where)->result();

		// Unset the layout if we have an ajax request
		if ($this->input->is_ajax_request()){
			$this->template->set_layout(false);
		}

		// Render the view
		$this->template
			->title($this->module_details['name'])
			->set('pagination', $pagination)
			->set('data_', $log)
			->set('total_rows', $total_rows)
			->set_partial('filters', 'admin_loginlog/partials/filters')
			->append_js('admin/filter.js');

		$this->input->is_ajax_request() ? $this->template->build('admin_loginlog/tables/table') : $this->template->build('admin_loginlog/index');
	}

	public function resolve(){
		if($this->input->is_ajax_request()){
			$id = $this->input->post('id');

			$data = $this->profile_m->get_single_log('login_log', array('login_log.id'=>$id));
			if($data){
				switch ($data->reason) {
					case 'User not active':
					case 'User Locked':
						if($this->profile_m->set_active($data->email)){
							$message = 'User is activated, please try to login.';
						}
						break;

					case 'User not exist':
					case 'Invalid Email':
						$message = 'User not registered, please register';
						break;

					case 'Invalid Password':
						$new_password = $this->generateRandomString();
						$new_pass = $this->ion_auth_model->hash_password($new_password, $data->salt);
						$new = array(
							'password'					=> $new_pass,
							'forgotten_password_code'	=> '0',
							'active'					=> 1,
							'forgot_password_access'	=> null
						);

						if($this->profile_m->update_data('users', $new, array('email'=>$data->email))){
							$message = 'User password has changed to '.$new_password.'. Please try to login with this password.';
						}
						break;
					
					default:
						$message = "Can't Resolve!";
						break;
				}

				echo json_encode(array('message'=>$message));
			}
		}
	}

	private function generateRandomString() {
	    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $numbers = '0123456789';
	    $specials = '!?%$#@^&*';
	    $charactersLength = strlen($characters);
	    $numbersLength = strlen($numbers);
	    $specialsLength = strlen($specials);
	    $randomString = '';
	    for ($i = 0; $i < 4; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    for ($i = 0; $i < 2; $i++) {
	        $randomString .= $numbers[rand(0, $numbersLength - 1)];
	    }
	    for ($i = 0; $i < 2; $i++) {
	        $randomString .= $specials[rand(0, $specialsLength - 1)];
	    }
	    return $randomString;
	}
}