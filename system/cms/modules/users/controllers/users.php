<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User controller for the users module (frontend)
 *
 * @author		 Phil Sturgeon
 * @author		MaxCMS Dev Team
 * @package		MaxCMS\Core\Modules\Users\Controllers
 */
class Users extends Public_Controller
{
	protected $forms_validation = array(
    	'title'	=> array(
    		'field'	=> 'title',
    		'label'	=> 'lang:articles:label_title',
    		'rules'	=> 'trim|required|xss_clean|callback__check_title'
    	),

		'desc' => array(
			'field'	=> 'description',
			'label'	=> 'lang:general:desc_label',
			'rules'	=> 'trim|xss_clean'
		),
    );

    protected $ask_limit;

	/**
	 * Constructor method
	 *
	 * @return \Users
	 */
	public function __construct(){
		parent::__construct();

		// Load the required classes
		$this->load->model(array('groups/group_m', 'user_m', 'profile_m', 'history_password_m','article/article_m'));
		$this->load->helper(array('user','download','parenting'));
		$this->lang->load(array('user'));
		$this->load->library(array('random_string', 'fileupload','session','user_agent'));

		$this->ask_limit = 5;

		$this->template
		     ->set_layout('default.html');

		//new for sso
		$this->load->config('sso');
		$this->load->library('HttpClient');

	}

	public function login_register_sso()
	{

		$message     = "";
		$isLoggedIn  = false;
		$forward_url = null;
		$profile_url = '';
		$register_url = '';

		if ($this->current_user) {
			$isLoggedIn = true;
			$query_params = array('response_type' => 'code',
								  'action'        => 'profile',
								  'client_id'     => $this->config->item('oauth2_client_id'),
								  'redirect_uri'  => $this->config->item('oauth2_redirect'),
								  'scope'         => 'user');

			$profile_url = $this->config->item('oauth2_auth_url') . '?' . http_build_query($query_params);
		} else {
			$query_params = array('response_type' => 'code',
								  'action'        => 'login',
								  'client_id'     => $this->config->item('oauth2_client_id'),
								  'redirect_uri'  => $this->config->item('oauth2_redirect'),
								  'scope'         => 'user');

			$forward_url = $this->config->item('oauth2_auth_url') . '?' . http_build_query($query_params);
			// $forward_url = 'https://connect.sahabatnestle.co.id/sso/auth?response_type=code&scope=user&action=login&redirect_uri=https%3A//sn-crm.otesuto.com/connect/checkauth&client_id=1_51ahfyh737gg8ks88g4c4ccckg4wg84owcc8gkwgs8swkwgg0o';
			// $forward_url = 'https://beta.connect.sahabatnestle.co.id/sso/auth?response_type=code&scope=user&action=login&redirect_uri=https%3A//sn-crm.otesuto.com/connect/checkauth&client_id=19_1ssujpgve3z4o0s08s08sg4c4goc880840044k0c00ks8s0wgo';
			// $forward_url = 'https://beta.connect.sahabatnestle.co.id/sso/auth?response_type=code&action=login&client_id=19_i94gh6pei2ygukzzd0s7xf318for9hl77punohkgq2j31642wb&redirect_uri=http://localhost/n4hk/callback&scope=user';
			
			$query_params = array('response_type' => 'code',
								  'action'        => 'register',
								  'client_id'     => $this->config->item('oauth2_client_id'),
								  'redirect_uri'  => $this->config->item('oauth2_redirect'),
								  'scope'         => 'user');

			$register_url = $this->config->item('oauth2_auth_url') . '?' . http_build_query($query_params);
		}

		$this->load->view('login_sso/index',array('isLoggedIn' => $isLoggedIn,'forward_url'=> $forward_url,'message'=> $message,'profile_url' => $profile_url, 'register_url' => $register_url));
	}

	public function callback(){
		
		$info = array();
		$responseObj = array();
		if (isset($_GET['code'])) {
			// try to get an access token
			$code = $_GET['code'];
			// authorization url
			$url = $oauth2_token_url;
			// this will be our POST data to send back to the OAuth server in exchange
			// for an access token
			$params = array(
				"code"          => $code,
				"client_id"     => $oauth2_client_id,
				"client_secret" => $oauth2_secret,
				"redirect_uri"  => $oauth2_redirect,
				"grant_type"    => "authorization_code"
			);
		 
			// build a new HTTP POST request
			$request = new HttpClient($url);
			$request->setPostData($params);
			$request->send();

			// decode the incoming string as JSON
			$responseObj = json_decode($request->getHttpResponse());
			

			// Tada: we have an access token!. You can now use this token to access the userinfo API endpoint.
			$info['token'] = sprintf("Access Token from Server: %s", $responseObj->access_token);
			
			// user information API endpoint
			$url = $oauth2_user_info;
			
			$request = new HttpClient($url);
			$request->setHeaderData(array(sprintf("Authorization: Bearer %s", $responseObj->access_token)));
			$request->send();

			// decode the incoming string as JSON
			$responseObj = json_decode($request->getHttpResponse());
			var_dump($responseObj);
			exit;
			if (!property_exists($responseObj,'error')) {
				$_SESSION['user']  = $responseObj;
			} else {
				$_SESSION['error'] = $responseObj->error;
			}
			
		} else {
			if (isset($_SESSION['user'])) {
				unset($_SESSION['user']);
			}
			var_dump('gagal dapat data');
		}
		
		// header('Location: index.php');
	}

	public function login_register(){
		
		if($this->current_user){
			redirect('dashboard');
		}

		/*session for register by utm*/
		$this->session->set_userdata('utm', $this->input->get());

		$login_register  = $this->uri->segment(1);
		if($this->session->flashdata('first_register')){
			$login_register = 'register';
		}

		$this->template
			 ->title(ucfirst($login_register))
			 ->set('login_register', $login_register)
			 ->build('login_register');
	}
	public function login_blog_register(){
		if($this->current_user){
			redirect('dashboard');
		}

		/*session for register by utm*/
		$this->session->set_userdata('utm', $this->input->get());

		$login_register  = $this->uri->segment(1);
		if($this->session->flashdata('first_register')){
			$login_register = 'blog-register';
		}

		$this->template
			 ->title(ucfirst('Blog Register'))
			 ->set('login_register', $login_register)
			 ->build('login_blog_register');
			 // ->build('login_blog_register_temp');
	}

	public function register_user(){
		//$this->load->library('wyeth_api/wyeth_api');
		//var_dump($this->wyeth_api->checkUserExists($this->input->post('phone')));die();
		//$redir = site_url('update-profile');

		$id_kid = 0;
		$redir = $this->session->userdata('last_url') ? $this->session->userdata('last_url') : site_url();

		if($this->current_user){
			if(!$this->input->is_ajax_request()){
            	redirect($redir);
			}else{
				echo json_encode(array('url'=>$redir, 'status'=>'success'));
				return;
			}
        }

		$validation = array(
			'first_name'	=> array(
				'field'	=> 'first_name',
				'label'	=> 'Nama Depan',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'last_name'	=> array(
				'field'	=> 'last_name',
				'label'	=> 'Nama Belakang',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'gender'	=> array(
				'field'	=> 'gender',
				'label'	=> 'Jenis Kelamin',
				'rules'	=> 'required|trim|xss_clean'
			),
			'email'	=> array(
				'field'	=> 'email',
				'label'	=> 'Email',
				'rules'	=> 'trim|required|valid_email|max_length[100]|callback__string_email_tambahan'
			),
			'phone'	=> array(
				'field'	=> 'phone',
				'label'	=> 'Nomor Telepon',
				'rules'	=> 'trim|max_length[20]|required|numeric'
			),
			'is_child'=> array(
				'field'	=> 'is_child',
				'label'	=> 'Nama Anak',
				'rules'	=> 'trim|xss_clean'
			),
			'pregnant' => array(
				'field'	=> 'pregnant',
				'label'	=> 'Status Kehamilan',
				'rules'	=> 'trim|xss_clean|numeric'
			),
			'password' => array(
				'field' => 'password',
				'label' => lang('global:password'),
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|callback_password_complexcity'
			),
			'rpassword' => array(
				'field' => 'rpassword',
				'label' => 'Ulangi Password',
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|callback_password_complexcity|matches[password]'
			),
			'tnc'	=> array(
				'field'	=> 'tnc',
				'label'	=> 'Syarat & Ketentuan',
				'rules'	=> 'trim|xss_clean|callback__check_value'
			),
		);

		$child_validation = array(
			'child_name'=> array(
				'field'	=> 'child_name',
				'label'	=> 'Nama Anak',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'child_dob' => array(
				'field'	=> 'child_dob',
				'label'	=> 'Tanggal Lahir Anak',
				'rules'	=> 'required|trim|xss_clean'
			),
			'child_gender' => array(
				'field'	=> 'child_gender',
				'label'	=> 'Jenis Kelamin Anak',
				'rules'	=> 'required|trim|xss_clean'
			),
		);

		$pregnant_validation = array(
			'pregnancy_age' => array(
				'field'	=> 'pregnancy_age',
				'label'	=> 'Usia Kehamilan',
				'rules'	=> 'required|trim|xss_clean|numeric'
			),
		);

		if ($this->input->post()){
			$rules = $validation;
			if($this->input->post('is_child')==1){
				$rules = array_merge($rules, $child_validation);
			}

			if($this->input->post('pregnant')==1){
				$rules = array_merge($rules, $pregnant_validation);
			}

			$this->form_validation->set_rules($rules);
			if($this->form_validation->run()) {
				$check1 = $this->_email_check($this->input->post('email'));
				$check2 = $this->_phone_check($this->input->post('phone'));
				if(!$check1 || !$check2){
					if(!$check1){
						$email = $this->input->post('email');
						$name = $this->input->post('first_name').' '.$this->input->post('last_name');
						$this->profile_m->register_log($name, $email, 'Email already exists');
					}else{
						$email = $this->input->post('email');
						$name = $this->input->post('first_name').' '.$this->input->post('last_name');
						$this->profile_m->register_log($name, $email, 'Phone Number already exists', $this->input->post('phone'), $this->session->userdata('email_reg'));

						$data = $this->db->select('u.email')
									     ->from('profiles p')
									     ->join('users u', 'p.user_id=u.id', 'left')
									     ->where('p.phone', $this->input->post('phone'))
									     ->get()->row();
						$email = $data->email;
					}

					$this->ion_auth->forgotten_password($email);
					$data = $this->user_m->get_single_data(array('email'=>$email), 'users');
					$data_mail = array(
						'message' => 'Anda mencoba mendaftar dengan akun yang sudah terdaftar. Silakan ubah password anda dengan mengklik link berikut. Terima Kasih.',
						'subject' => 'Anda Sudah Terdaftar',
						'button_text' => 'Ubah Password',
						'url' => site_url('password-recovery/'.$data->forgotten_password_code),
						'headline' => 'Anda Sudah Terdaftar'
					);

					//sent email after suksess update
					/*$this->load->library('Mandrill/Mandrill');
					$message = array(
				        'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'].$data_mail['url'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $data->email,
				                //'name' => $data->display_name,
				                'type' => 'to'
				            )
				        ),
				        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
				        'track_opens' => false,
        				'track_clicks' => false,
				    );
					$val = $this->mandrill->messages->send($message, false, '', '2016-09-01');*/

					$this->load->library('Swiftmailer/Baseswiftmailer');
					$message = array(
				       'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'].$data_mail['url'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $data->email,
				            )
				        ),
				    );
					$mailer = $this->baseswiftmailer->send($message);

					echo json_encode(array('status'=>'success'));
					exit();
				}else{
					/*$sms = false;
					$eways_id = 0;
					$point = 0;
					$is_true =  $this->wyeth_api->checkUserExists($this->input->post('phone'));
		           	if($is_true && !$this->input->post('sms_code')){
						//check eways id have used with valid user
						$res_eways = $this->profile_m->get_profile(array('eways_id'=>$is_true));
						if(!$res_eways){
							$data_result_sms = $this->wyeth_api->reqSMSCode($this->session->userdata('userIdWyeth'));
							if($data_result_sms){
								echo json_encode(array('status'=>'sms_verify'));
								return;
							}
						} else {
						    $this->session->unset_userdata('userIdWyeth');
						}
		           	}else if($is_true && $this->input->post('sms_code')){
		           		$eways_id = $this->session->unset_userdata('userIdWyeth');
		           		$code = $this->input->post('sms_code');

		           		$sms = $this->wyeth_api->verifySMSCode($eways_id, $code);
		           		if(!$sms){
		           			echo json_encode(array('message'=>'Invalid SMS Code', 'status'=>'invalid_sms'));
							return;
		           		}else{
		           			$point = $this->wyeth_api->getPoint($this->session->userdata('userIdWyeth'));
		           		}
		           	}*/

					//$data['eways_id'] = $eways_id;
					//$data['total_point'] = $point;
					$data['first_name'] = $this->input->post('first_name');
					$data['last_name'] = $this->input->post('last_name');
					$data['gender'] = $this->input->post('gender');
					$data['display_name'] = $data['first_name'].' '.$data['last_name'];
					$data['phone'] = $this->input->post('phone');
					$data['pregnant'] = $this->input->post('pregnant');
					$data['pregnancy_age'] = $this->input->post('pregnancy_age');

					/*$name = explode('-', $data['display_name']);
					$data['first_name'] = $name[0];
					unset($name[0]);
					$data['last_name'] = implode(' ', $name);*/

					$username		= strtolower(str_replace(' ', '', $data['display_name']));
					$password 		= escape_tags($this->input->post('password'));
					$email 			= $this->input->post('email');

					if($by = $this->session->userdata('konek_by')){
						$me = $this->session->userdata('me');
						if($by=='fb'){
							$data['fb_id'] 		= $me['fb_id'];
							$data['bio'] 		= $me['bio']!='' ? $me['bio'] : $me['about'];
						}else if($by=='gplus'){
							$data['gplus_id'] 	= $me['gplus_id'];
						}else if($by=='tw'){
							$data['tw_id'] 		= $me['tw_id'];
							$data['tw_screen_name'] = $me['screen_name'];
							$data['bio'] 		= $me['bio'];
						}
					}

					/*$dob = new DateTime($this->input->post('child_dob'));
					$today = new DateTime('today');
					$diff = $dob->diff($today);
					if($diff->y >= 1) {*/
						$id = $this->ion_auth->register($username, $password, $email, 2, $data);
						if($id) {
							//update images profile
			                if($profile = $this->input->post('image')){
			                	$uniq = uniqid();
								/* old profile image */
								/*$profile = preg_replace('/data:image\/\w+;base64,/', '', $profile);
								$profile = str_replace("[removed]", "", $profile);
								$image = base64_decode($profile);
								if(!is_dir('./uploads/profile/')){
									mkdir('./uploads/profile/', 755, true);
								}
								$file = 'uploads/profile/'.$uniq.'.png';
								$success = file_put_contents('./'.$file, $image);

								if($success){
				                	$new_data 	= array(
				                		'photo_profile'	=> $file,
				                	);

				                	$this->db->update('profiles', $new_data, array('user_id'=>$id));
								}*/

								/* new profile image */
								if(!is_dir('./uploads/profile/')){
									mkdir('./uploads/profile/', 755, true);
								}
								$newImage = 'uploads/profile/'.uniqid().'-'.$profile['lastProfileImageName'];

				                $image_config = array(
				                	'image_library'					=>'gd2',
				                	'source_image'					=>$profile['lastProfileImagePath'].$profile['lastProfileImageName'],
				                	'new_image'						=>$newImage,
				                	'quality'						=>'100%',
				                	'maintain_ratio'				=>FALSE,
				                	'x_axis'						=>$profile['x'],
				                	'y_axis'						=>$profile['y'],
				                	'width'							=>$profile['width'],
				                	'height'						=>$profile['height'],
				                );

				                $this->load->library('image_lib', $image_config);

						        $this->image_lib->initialize($image_config);
						        if (!$this->image_lib->crop()){
						            echo $this->image_lib->display_errors();
						        } else {
						        	$new_data 	= array(
				                		'photo_profile'	=> $newImage,
				                	);
				                	$this->db->update('profiles', $new_data, array('user_id'=>$id));

				                	/* delete temp image */
				                	if (is_dir($profile['lastProfileImagePath'])) {
										if(is_file($profile['lastProfileImagePath'].$profile['lastProfileImageName'])) {
										 	unlink($profile['lastProfileImagePath'].$profile['lastProfileImageName']);
										}
									}
						        }
								/* new requirment */
			                }

							//insert data anak
							$data_kids = array();
							if($this->input->post('is_child')==1){
								$ctDataAnak 	= count($this->input->post('namaanak'))-1;
								if($ctDataAnak>0) {
									$namaanak 		= $this->input->post('namaanak');
									$dobanak 		= $this->input->post('dobanak');
									$genderanak 	= $this->input->post('genderanak');

									for($ctAnk=1;$ctAnk<=$ctDataAnak;$ctAnk++) {
										$data_kids[$ctAnk] = array(
											'user_id'		=> $id,
											'name' 			=> $namaanak[$ctAnk],
											'dob'			=> $dobanak[$ctAnk],
											'child_number' 	=> 0,
											'gender' 		=> $genderanak[$ctAnk],
											'default' 		=> ($ctAnk==1) ? 'yes' : 'no',
										);
									}
								}
							}

							// register socmed ssf as guest
							/*if($by=='fb' or $by=='tw') {
								$user_kid 		= $this->profile_m->get_child(array('user_id'=>$id))->num_rows();
				            	$data_guestkid 	= ($this->session->userdata('unreg_kid')) ? $this->session->userdata('unreg_kid') : array();
				            	$data_kids 		= array();

								if($data_guestkid){
									if($user_kid < 3 ) {
										$data_kids = array(
											'user_id'		=> $data_user->user_id,
											'name' 			=> $data_guestkid['child_name'],
											'dob'			=> $data_guestkid['child_dob'],
											'child_number' 	=> 0,
											'gender' 		=> $data_guestkid['child_gender'],
											'default' 		=> 'yes'
										);

										if($id_kid = $this->user_m->insert_data('users_child', $data_kids)) {
											$this->session->set_userdata('user_kid', $id_kid);

											if($this->session->userdata('unreg_kid')) {
												$this->session->unset_userdata('unreg_kid');
											}
										}
									}
								}
							}*/

							/*if($sms){
								$data_children =$this->wyeth_api->getUserInfo($this->session->userdata('userIdWyeth'));
			                	if($data_children){
			                		for($x=1; $x<=3; $x++){
			                			if(!empty($data_children['ChildName'.$x])){
				                			$data_kids[$x] = array(
												'user_id'	=> $id,
												'name' 		=> $data_children['ChildName'.$x],
												'dob'		=> $this->input->post('child_dob'),
												'child_number' => $x,
												'gender' 	=> strtolower($data_children['Gender'.$x]) =='m' ? '1':'2',
												'default' => $x==3 ? 'yes' : 'no',
											);
										}
			                		}
			                    }

	                            $dataLastShipment = $this->wyeth_api->getLastShipment($this->session->userdata('userIdWyeth'));
	                            if($dataLastShipment){
	                                foreach($dataLastShipment as $item){
	                                    $new_itm = array();
	                                    foreach($item as $index =>$mini_item){
	                                        $new_itm[strtolower($index)] = $mini_item;
	                                    }
	                                    $new_itm['eways_id'] = $this->session->userdata('userIdWyeth');
	                                    $new_itm['user_id'] = $id;
	                                    $this->db->insert('default_last_shipment_history',$new_itm);
	                                }
	                            }

	                            $dataLastSubmitPoint = $this->wyeth_api->getLastSubmitPoint($this->session->userdata('userIdWyeth'));
	                            if($dataLastSubmitPoint){
	                                foreach($dataLastSubmitPoint as $item){
	                                    $new_itm = array();
	                                    foreach($item as $index =>$mini_item){
	                                        $new_itm[strtolower($index)] = $mini_item;
	                                    }
	                                    $new_itm['eways_id'] = $this->session->userdata('userIdWyeth');
	                                    $new_itm['user_id'] = $id;
	                                    $this->db->insert('default_last_shipment_history',$new_itm);
	                                }
	                            }
							}*/

							$id_kid = array();
							foreach ($data_kids as $key => $value) {
								// $id_kid = $this->db->insert('users_child', $value);
								$id_kid[] = $this->user_m->insert_data('users_child', $value);
							}

							if(!empty($id_kid)) {
								$this->session->set_userdata('user_kid', $id_kid);
								$this->session->set_flashdata('add_anak', true);

								if($this->session->userdata('unreg_kid')) {
									$this->session->unset_userdata('unreg_kid');
								}
							}

							//subscribe to mailchimp
							$this->load->library('MailChimp');
							$subscribe_data = array(
								'email' => $email,
								'status' => 'subscribed',
								'first_name' => $data['first_name'],
								'last_name' => $data['last_name'],
							);
							$this->mailchimp->subscribe($subscribe_data);

							//sent email after suksess register
							$code = $this->ion_auth->activation_email($id);
							$user_gender = $data['gender'] == 'm' ? 'Pap' : 'Mam';
							$data_mail = array(
								// Dengan e-voucher
								// 'message' => 'Halo '.$user_gender.' '.$data['first_name'].',<br>Terima kasih telah mendaftar Parenting Club! Klik tombol di bawah ini untuk verifikasi alamat email '.$user_gender.' dan mendapatkan voucher belanja senilai Rp 50,000*.',
								'message' => 'Halo '.$user_gender.' '.$data['first_name'].',<br>Terima kasih telah mendaftar Parenting Club! Klik tombol di bawah ini untuk verifikasi alamat email.',
								// Tanpa e-voucher
								// 'message' => 'Halo '.$user_gender.' '.$data['first_name'].',<br>Terima kasih telah mendaftar! Aktifkan akun Parenting Club dengan klik tombol di bawah ini untuk verifikasi alamat email.',
								'subject' => 'Parenting Club – Aktivasi Akun',
								'button_text' => 'Verifikasi email',
								'url' => site_url('activate/'.$code),
								'headline' => 'Email Aktivasi Akun'
							);
							/*$this->load->library('Mandrill/Mandrill');
							$message = array(
						        'html' => $this->load->view('mail', $data_mail, true),
						        'text' => $data_mail['message'].' Kunjungi '.$data_mail['url'].', untuk aktivasi akun.',
						        'subject' => $data_mail['subject'],
						        'from_email' => 'donotreply@parentingclub.id',
						        'from_name' => 'Parenting Club',
						        'to' => array(
						            array(
						                'email' => $email,
						                'name' => $data['display_name'],
						                'type' => 'to'
						            )
						        ),
						        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
						        'track_opens' => false,
	        					'track_clicks' => false,
						    );*/
							/*matikan email dulu*/
							// $this->mandrill->messages->send($message, false);
							
							/*matikan email dulu*/
							$this->load->library('Swiftmailer/Baseswiftmailer');
							$message = array(
						       	'html' => $this->load->view('mail', $data_mail, true),
						        // 'text' => $data_mail['message'].' Kunjungi '.$data_mail['url'].', untuk aktivasi akun.',
						        'subject' => $data_mail['subject'],
						        'from_email' => 'donotreply@parentingclub.id',
						        'from_name' => 'Parenting Club',
						        'to' =>array(
						        	array(
						                'email' => $email,
						                'name' => $data['display_name'],
						            )
						        ),
						    );
							$mailer = $this->baseswiftmailer->send($message);


							/*tambahan untuk ngecek dari utm apa ga*/
							// tambahan baru: semua user yang registrasi dapat kode voucher
							$session_utm = $this->session->userdata('utm');
							$from_utm = 0;
							$user_id = $id;

							/*load library dulu*/
							$this->load->library('utm/utm');
							if ($session_utm != NULL) {
								// user registrasi dari utm
								$campaign 	= isset($session_utm['utm_campaign']) ? $session_utm['utm_campaign'] : '';
								$medium 	= isset($session_utm['utm_medium']) ? $session_utm['utm_medium'] : '';
								$source 	= isset($session_utm['utm_source']) ? $session_utm['utm_source'] : '';
								$content 	= isset($session_utm['utm_content']) ? $session_utm['utm_content'] : '';
								$term 		= isset($session_utm['utm_term']) ? $session_utm['utm_term'] : '';
								$from_utm = 1;
								$id_utm = $this->utm->insert_to_utm($id, $campaign, $medium, $source, $content, $term);
							} else {
								// user registrasi biasa
								$id_utm = $this->utm->insert_to_utm($id);
							}

							$for_ga = ($session_utm == NULL) ? array() : $session_utm;
							// log_message('error', 'UTM ID: '.$id_utm);

							/*sampai di sini dulu tambahannya*/

							//-- UNSET ALL SESSION TERKAIT
							$this->session->set_userdata('first', true);
							$this->session->unset_userdata('me');
							$this->session->unset_userdata('konek_by');

							//$this->ion_auth->activate($id, false);
							//$this->ion_auth->force_login($id);

							if(!$this->input->is_ajax_request()){
								redirect($redir);
							} else {
								//echo json_encode(array('url'=>$redir, 'status'=>'success'));
								echo json_encode(array('status'=>'success','from_utm'=>$from_utm) + $for_ga);
								return;
							}
						}else{
							$email = $this->input->post('email');
							$name = $this->input->post('first_name').' '.$this->input->post('last_name');
							$this->profile_m->register_log($name, $email, 'Failed to register user');

							echo json_encode(array('message'=>$this->ion_auth->errors(), 'status'=>'failed'));
							return;
						}

					/*} else {
						echo json_encode(array('status'=>'failed', 'message'=> 'Maaf anda tidak dapat melanjutkan pendaftaran, karena usia anak anda belum mencukupi syarat pendaftaran.'));
						return;
					}*/
				}
			}else{
				foreach ($validation as $key => $fields) {
					$data_[$fields['field']] = form_error($fields['field']);
				}

				echo json_encode(array('status'=>'failed', 'error'=> $data_));
				return;
			}
		}
	}


	protected $user_path = 'uploads/user_blog';

	private function uploadOptions($file)
    {
	  	if (!is_dir($this->user_path)) {
            mkdir('./'.$this->user_path, 0755, true);
        }
        $config = array('encrypt_name' => true);
    	$config['upload_path']   = $this->user_path;
        // $config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|mp4|ogg|webm|pdf|plain|text|msword';
        $config['allowed_types'] = '*';
        $config['max_size']      = 204800; //  200 MB
        return $config;
    }



    public function user_upload()
    {
		$attachment_file = '';
		$this->load->library('upload');

		if ($_FILES['file']['size'] > 0) {
			// var_dump(self::uploadOptions($_FILES['file']));
			// die();
			$this->upload->initialize(self::uploadOptions($_FILES['file']));

		    if ($this->upload->do_upload('file')) {
		        $file = $this->upload->data();

		        $attachment_file = $this->user_path.'/'.$file['file_name'];
		    }
		}


    }


    private function email_blog_forgotpassword($email = "natanaelkristiawan@hotmail.com")
    {

		$message = 'Terima kasih sudah mendaftar untuk menjadi Mam Blogger. Anda sudah terdaftar sebagai anggota Parenting Club. Silahkan klik tombol di bawah ini apabila Anda ingin mengubah password Anda';
		$footer = 'Contoh tulisan Anda sudah kami terima dan saat ini Anda sedang dalam proses seleksi untuk menjadi Mam Blogger. Mohon menunggu, kami akan menghubungi Anda kembali. Prenting Club senantiasa hadir untuk mendampingi Mam & Pap dalam setiap langkah untuk mendukung sinergi kepintaran Akal, Fisik & Sosial si Kecil agar #PintarnyaBeda.';


		$this->ion_auth->forgotten_password($email);
		$data = $this->user_m->get_single_data(array('email'=>$email), 'users');
		$first_name = $this->user_m->get_single_data(array('user_id'=> $data->id), 'profiles')->first_name;
		$data_mail = array(
			'message' => $message,
			'subject' => 'Anda Sudah Terdaftar',
			'button_text' => 'Ubah Password',
			'url' => site_url('password-recovery/'.$data->forgotten_password_code),
			'headline' => 'Anda Sudah Terdaftar',
			'footer' => $footer,
			'name'	=> $first_name
		);

		//sent email after suksess update
		/*$this->load->library('Mandrill/Mandrill');
		$message = array(
	        'html' => $this->load->view('mail_blogger', $data_mail, true),
	        'text' => $data_mail['message'].$data_mail['url'],
	        'subject' => $data_mail['subject'],
	        'from_email' => 'donotreply@parentingclub.id',
	        'from_name' => 'Parenting Club',
	        'to' => array(
	            array(
	                'email' => $data->email,
	                //'name' => $data->display_name,
	                'type' => 'to'
	            )
	        ),
	        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
	        'track_opens' => false,
			'track_clicks' => false,
	    );
		$val = $this->mandrill->messages->send($message, false, '', '2016-09-01');*/

		$this->load->library('Swiftmailer/Baseswiftmailer');
		$message = array(
	       	'html' => $this->load->view('mail_blogger', $data_mail, true),
	        'text' => $data_mail['message'].$data_mail['url'],
	        'subject' => $data_mail['subject'],
	        'from_email' => 'donotreply@parentingclub.id',
	        'from_name' => 'Parenting Club',
	        'to' => array(
	            array(
	                'email' => $data->email,
	            )
	        ),
	    );
		$mailer = $this->baseswiftmailer->send($message);
    }

	public function register_blog_user(){
		//$this->load->library('wyeth_api/wyeth_api');
		//var_dump($this->wyeth_api->checkUserExists($this->input->post('phone')));die();
		//$redir = site_url('update-profile');

		$id_kid = 0;
		$redir = $this->session->userdata('last_url') ? $this->session->userdata('last_url') : site_url();

		if($this->current_user){
			if(!$this->input->is_ajax_request()){
            	redirect($redir);
			}else{
				echo json_encode(array('url'=>$redir, 'status'=>'success'));
				return;
			}
        }

		$validation = array(
			'first_name'	=> array(
				'field'	=> 'first_name',
				'label'	=> 'Nama Depan',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'last_name'	=> array(
				'field'	=> 'last_name',
				'label'	=> 'Nama Belakang',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'gender'	=> array(
				'field'	=> 'gender',
				'label'	=> 'Jenis Kelamin',
				'rules'	=> 'required|trim|xss_clean'
			),
			'email'	=> array(
				'field'	=> 'email',
				'label'	=> 'Email',
				'rules'	=> 'trim|required|valid_email|max_length[100]|callback__string_email_tambahan'
			),
			'phone'	=> array(
				'field'	=> 'phone',
				'label'	=> 'Nomor Telepon',
				'rules'	=> 'trim|max_length[20]|required|numeric'
			),
			'is_child'=> array(
				'field'	=> 'is_child',
				'label'	=> 'Nama Anak',
				'rules'	=> 'trim|xss_clean'
			),
			'pregnant' => array(
				'field'	=> 'pregnant',
				'label'	=> 'Status Kehamilan',
				'rules'	=> 'trim|xss_clean|numeric'
			),
			'password' => array(
				'field' => 'password',
				'label' => lang('global:password'),
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|callback_password_complexcity'
			),
			'rpassword' => array(
				'field' => 'rpassword',
				'label' => 'Ulangi Password',
				'rules' => 'required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|callback_password_complexcity|matches[password]'
			),
			'tnc'	=> array(
				'field'	=> 'tnc',
				'label'	=> 'Syarat & Ketentuan',
				'rules'	=> 'trim|xss_clean|callback__check_value'
			),
		);

		$child_validation = array(
			'child_name'=> array(
				'field'	=> 'child_name',
				'label'	=> 'Nama Anak',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'child_dob' => array(
				'field'	=> 'child_dob',
				'label'	=> 'Tanggal Lahir Anak',
				'rules'	=> 'required|trim|xss_clean'
			),
		);

		$pregnant_validation = array(
			'pregnancy_age' => array(
				'field'	=> 'pregnancy_age',
				'label'	=> 'Usia Kehamilan',
				'rules'	=> 'required|trim|xss_clean|numeric'
			),
		);

		if ($this->input->post()){
			$rules = $validation;
			if($this->input->post('is_child')==1){
				$rules = array_merge($rules, $child_validation);
			}

			if($this->input->post('pregnant')==1){
				$rules = array_merge($rules, $pregnant_validation);
			}

			$this->form_validation->set_rules($rules);
			if($this->form_validation->run()) {
				$check1 = $this->_email_check($this->input->post('email'));
				$check2 = $this->_phone_check($this->input->post('phone'));
				if(!$check1 || !$check2){
					if(!$check1){
						$email = $this->input->post('email');
						$name = $this->input->post('first_name').' '.$this->input->post('last_name');
						$this->profile_m->register_log($name, $email, 'Email already exists');
					}else{
						$email = $this->input->post('email');
						$name = $this->input->post('first_name').' '.$this->input->post('last_name');
						$this->profile_m->register_log($name, $email, 'Phone Number already exists', $this->input->post('phone'), $this->session->userdata('email_reg'));

						$data = $this->db->select('u.email')
									     ->from('profiles p')
									     ->join('users u', 'p.user_id=u.id', 'left')
									     ->where('p.phone', $this->input->post('phone'))
									     ->get()->row();
						$email = $data->email;
					}
					/*cek perubahan*/

					$id = $this->db->get_where('users', array('email'=>$email))->row('id');

              		$attachment_file = $this->db->get_where('profiles',array('user_id'=>$id))->row('attachment');

					$this->load->library('upload');
					if ($_FILES['file']['size'] > 0) {
						// var_dump(self::uploadOptions($_FILES['file']));
						// die();
						$this->upload->initialize(self::uploadOptions($_FILES['file']));

					    if ($this->upload->do_upload('file')) {
					        $file = $this->upload->data();

					        $attachment_file = $this->user_path.'/'.$file['file_name'];
					    }
					}



				   	$data_update_profile = array(
	                	'website' 	=> $this->input->post('links'),
	                	'bio'		=> $this->input->post('sort-bio'),
	                	'ig_account'=> str_replace('https://www.instagram.com/', '', $this->input->post('instagram')),
	                	'fb_account'	=>	$this->input->post('facebook'),
	                	'attachment'=> $attachment_file,
	                	 'is_blogger' => 1,
	                	);
                	$this->db->update('profiles', $data_update_profile, array('user_id'=>$id));
                	self::email_blog_forgotpassword($email);

                	echo json_encode(array('status'=>'success'));

					/*bisa update*/
					return;

				}else{
					/*$sms = false;
					$eways_id = 0;
					$point = 0;
					$is_true =  $this->wyeth_api->checkUserExists($this->input->post('phone'));
		           	if($is_true && !$this->input->post('sms_code')){
						//check eways id have used with valid user
						$res_eways = $this->profile_m->get_profile(array('eways_id'=>$is_true));
						if(!$res_eways){
							$data_result_sms = $this->wyeth_api->reqSMSCode($this->session->userdata('userIdWyeth'));
							if($data_result_sms){
								echo json_encode(array('status'=>'sms_verify'));
								return;
							}
						} else {
						    $this->session->unset_userdata('userIdWyeth');
						}
		           	}else if($is_true && $this->input->post('sms_code')){
		           		$eways_id = $this->session->unset_userdata('userIdWyeth');
		           		$code = $this->input->post('sms_code');

		           		$sms = $this->wyeth_api->verifySMSCode($eways_id, $code);
		           		if(!$sms){
		           			echo json_encode(array('message'=>'Invalid SMS Code', 'status'=>'invalid_sms'));
							return;
		           		}else{
		           			$point = $this->wyeth_api->getPoint($this->session->userdata('userIdWyeth'));
		           		}
		           	}*/

					//$data['eways_id'] = $eways_id;
					//$data['total_point'] = $point;
					$data['first_name'] = $this->input->post('first_name');
					$data['last_name'] = $this->input->post('last_name');
					$data['gender'] = $this->input->post('gender');
					$data['display_name'] = $data['first_name'].' '.$data['last_name'];
					$data['phone'] = $this->input->post('phone');
					$data['pregnant'] = $this->input->post('pregnant');
					$data['pregnancy_age'] = $this->input->post('pregnancy_age');

					/*$name = explode('-', $data['display_name']);
					$data['first_name'] = $name[0];
					unset($name[0]);
					$data['last_name'] = implode(' ', $name);*/

					$username		= strtolower(str_replace(' ', '', $data['display_name']));
					$password 		= escape_tags($this->input->post('password'));
					$email 			= $this->input->post('email');

					if($by = $this->session->userdata('konek_by')){
						$me = $this->session->userdata('me');
						if($by=='fb'){
							$data['fb_id'] 		= $me['fb_id'];
							$data['bio'] 		= $me['bio']!='' ? $me['bio'] : $me['about'];
						}else if($by=='gplus'){
							$data['gplus_id'] 	= $me['gplus_id'];
						}else if($by=='tw'){
							$data['tw_id'] 		= $me['tw_id'];
							$data['tw_screen_name'] = $me['screen_name'];
							$data['bio'] 		= $me['bio'];
						}
					}

					/*$dob = new DateTime($this->input->post('child_dob'));
					$today = new DateTime('today');
					$diff = $dob->diff($today);
					if($diff->y >= 1) {*/
						$id = $this->ion_auth->register($username, $password, $email, 2, $data);
						if($id) {
							//update images profile
			                if($profile = $this->input->post('image')){
			                	$uniq = uniqid();
								$profile = preg_replace('/data:image\/\w+;base64,/', '', $profile);
								$profile = str_replace("[removed]", "", $profile);
								$image = base64_decode($profile);
								if(!is_dir('./uploads/profile/')){
									mkdir('./uploads/profile/', 755, true);
								}
								$file = 'uploads/profile/'.$uniq.'.png';
								$success = file_put_contents('./'.$file, $image);

								if($success){
				                	$new_data 	= array(
				                		'photo_profile'	=> $file,
				                	);

				                	$this->db->update('profiles', $new_data, array('user_id'=>$id));
								}
			                }

			                /*update attachment*/
		              		$attachment_file = '';
							$this->load->library('upload');
							if ($_FILES['file']['size'] > 0) {
								// var_dump(self::uploadOptions($_FILES['file']));
								// die();
								$this->upload->initialize(self::uploadOptions($_FILES['file']));

							    if ($this->upload->do_upload('file')) {
							        $file = $this->upload->data();

							        $attachment_file = $this->user_path.'/'.$file['file_name'];
							    }
							}



			                /*update profiles bio*/
    			            $data_update_profile = array(
			                	'website' 	=> $this->input->post('links'),
			                	'bio'		=> $this->input->post('sort-bio'),
			                	'ig_account'=> str_replace('https://www.instagram.com/', '', $this->input->post('instagram')),
			                	'fb_account'	=>	$this->input->post('facebook'),
			                	'attachment'=> $attachment_file,
			                	'is_blogger' => 1,
			                	);
		                	$this->db->update('profiles', $data_update_profile, array('user_id'=>$id));

		                	/*ubah group ke bloger*/

		                	// $update_group = array(
		                	// 	'group_id' => 3
		                	// 	);
		                	// $this->db->update('users', $update_group, array('id'=>$id));

							//insert data anak
							$data_kids = array();
							if($this->input->post('child_name')){
								$data_kids[1] = array(
									'user_id'	=> $id,
									'name' 		=> $this->input->post('child_name'),
									'dob'		=> $this->input->post('child_dob'),
									'child_number' => 0,
									'gender' 	=> 0,
									'default' => 'yes'
								);
							}

							// register socmed ssf as guest
							/*if($by=='fb' or $by=='tw') {
								$user_kid 		= $this->profile_m->get_child(array('user_id'=>$id))->num_rows();
				            	$data_guestkid 	= ($this->session->userdata('unreg_kid')) ? $this->session->userdata('unreg_kid') : array();
				            	$data_kids 		= array();

								if($data_guestkid){
									if($user_kid < 3 ) {
										$data_kids = array(
											'user_id'		=> $data_user->user_id,
											'name' 			=> $data_guestkid['child_name'],
											'dob'			=> $data_guestkid['child_dob'],
											'child_number' 	=> 0,
											'gender' 		=> $data_guestkid['child_gender'],
											'default' 		=> 'yes'
										);

										if($id_kid = $this->user_m->insert_data('users_child', $data_kids)) {
											$this->session->set_userdata('user_kid', $id_kid);

											if($this->session->userdata('unreg_kid')) {
												$this->session->unset_userdata('unreg_kid');
											}
										}
									}
								}
							}*/

							/*if($sms){
								$data_children =$this->wyeth_api->getUserInfo($this->session->userdata('userIdWyeth'));
			                	if($data_children){
			                		for($x=1; $x<=3; $x++){
			                			if(!empty($data_children['ChildName'.$x])){
				                			$data_kids[$x] = array(
												'user_id'	=> $id,
												'name' 		=> $data_children['ChildName'.$x],
												'dob'		=> $this->input->post('child_dob'),
												'child_number' => $x,
												'gender' 	=> strtolower($data_children['Gender'.$x]) =='m' ? '1':'2',
												'default' => $x==3 ? 'yes' : 'no',
											);
										}
			                		}
			                    }

	                            $dataLastShipment = $this->wyeth_api->getLastShipment($this->session->userdata('userIdWyeth'));
	                            if($dataLastShipment){
	                                foreach($dataLastShipment as $item){
	                                    $new_itm = array();
	                                    foreach($item as $index =>$mini_item){
	                                        $new_itm[strtolower($index)] = $mini_item;
	                                    }
	                                    $new_itm['eways_id'] = $this->session->userdata('userIdWyeth');
	                                    $new_itm['user_id'] = $id;
	                                    $this->db->insert('default_last_shipment_history',$new_itm);
	                                }
	                            }

	                            $dataLastSubmitPoint = $this->wyeth_api->getLastSubmitPoint($this->session->userdata('userIdWyeth'));
	                            if($dataLastSubmitPoint){
	                                foreach($dataLastSubmitPoint as $item){
	                                    $new_itm = array();
	                                    foreach($item as $index =>$mini_item){
	                                        $new_itm[strtolower($index)] = $mini_item;
	                                    }
	                                    $new_itm['eways_id'] = $this->session->userdata('userIdWyeth');
	                                    $new_itm['user_id'] = $id;
	                                    $this->db->insert('default_last_shipment_history',$new_itm);
	                                }
	                            }
							}*/

							foreach ($data_kids as $key => $value) {
								// $id_kid = $this->db->insert('users_child', $value);
								$id_kid = $this->user_m->insert_data('users_child', $value);
							}

							if($id_kid!=0) {
								$this->session->set_userdata('user_kid', $id_kid);
								$this->session->set_flashdata('add_anak', true);

								if($this->session->userdata('unreg_kid')) {
									$this->session->unset_userdata('unreg_kid');
								}
							}

							//subscribe to mailchimp
							$this->load->library('MailChimp');
							$subscribe_data = array(
								'email' => $email,
								'status' => 'subscribed',
								'first_name' => $data['first_name'],
								'last_name' => $data['last_name'],
							);
							$this->mailchimp->subscribe($subscribe_data);

							//sent email after suksess register
							$footer = 'Contoh tulisan Anda sudah kami terima dan saat ini Anda sedang dalam proses seleksi untuk menjadi Mam Blogger. Mohon menunggu, kami akan menghubungi Anda kembali. Prenting Club senantiasa hadir untuk mendampingi Mam & Pap dalam setiap langkah untuk mendukung sinergi kepintaran Akal, Fisik & Sosial si Kecil agar #PintarnyaBeda.';
							$code = $this->ion_auth->activation_email($id);
							$user_gender = $data['gender'] == 'm' ? 'Mam' : 'Pap';
							$data_mail = array(
								// Dengan e-voucher
								// 'message' => 'Halo '.$user_gender.' '.$data['first_name'].',<br>Terima kasih telah mendaftar Parenting Club! Klik tombol di bawah ini untuk verifikasi alamat email '.$user_gender.' dan mendapatkan voucher belanja senilai Rp 50,000*. Blog Belum aktif',
								// Tanpa e-voucher
								// 'message' => 'Halo '.$user_gender.' '.$data['first_name'].',<br>Terima kasih telah mendaftar! Aktifkan akun Parenting Club dengan klik tombol di bawah ini untuk verifikasi alamat email.',
								'message' => 'Terima kasih sudah mendaftar untuk menjadi Mam Blogger. Silahkan aktivasikan akun Parenting Club Anda terlebih dahulu dengan klik tombol di bawah ini.',
								'subject' => 'Parenting Club – Aktivasi Akun',
								'button_text' => 'Aktivasikan Sekarang',
								'url' => site_url('activate/'.$code),
								'headline' => 'Email Aktivasi Akun',
								'footer'	=> $footer,
								'name'		=> $this->input->post('first_name')
							);
							
							/*$this->load->library('Mandrill/Mandrill');
							$message = array(
						        'html' => $this->load->view('mail_blogger', $data_mail, true),
						        'text' => $data_mail['message'].' Kunjungi '.$data_mail['url'].', untuk aktivasi akun.',
						        'subject' => $data_mail['subject'],
						        'from_email' => 'donotreply@parentingclub.id',
						        'from_name' => 'Parenting Club',
						        'to' => array(
						            array(
						                'email' => $email,
						                'name' => $data['display_name'],
						                'type' => 'to'
						            )
						        ),
						        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
						        'track_opens' => false,
	        					'track_clicks' => false,
						    );*/
							/*matikan send verifikasi di blog register*/
							// $this->mandrill->messages->send($message, false, '', '2016-09-01');

							/*matikan send verifikasi di blog register*/
							/*$this->load->library('Swiftmailer/Baseswiftmailer');
							$message = array(
						       	'html' => $this->load->view('mail_blogger', $data_mail, true),
						        'text' => $data_mail['message'].' Kunjungi '.$data_mail['url'].', untuk aktivasi akun.',
						        'subject' => $data_mail['subject'],
						        'from_email' => 'donotreply@parentingclub.id',
						        'from_name' => 'Parenting Club',
						        'to' => array(
						            array(
						                'email' => $email,
						                'name' => $data['display_name'],
						            )
						        ),
						    );
							$mailer = $this->baseswiftmailer->send($message);*/


							/*tambahan untuk ngecek dari utm apa ga*/
							// tambahan baru: semua user yang registrasi dapat kode voucher
							$session_utm = $this->session->userdata('utm');
							$from_utm = 0;
							$user_id = $id;

							/*load library dulu*/
							$this->load->library('utm/utm');
							if ($session_utm != NULL) {
								// user registrasi dari utm
								$campaign 	= isset($session_utm['utm_campaign']) ? $session_utm['utm_campaign'] : '';
								$medium 	= isset($session_utm['utm_medium']) ? $session_utm['utm_medium'] : '';
								$source 	= isset($session_utm['utm_source']) ? $session_utm['utm_source'] : '';
								$content 	= isset($session_utm['utm_content']) ? $session_utm['utm_content'] : '';
								$term 		= isset($session_utm['utm_term']) ? $session_utm['utm_term'] : '';
								$from_utm = 1;
								$id_utm = $this->utm->insert_to_utm($id, $campaign, $medium, $source, $content, $term);
							} else {
								// user registrasi biasa
								$id_utm = $this->utm->insert_to_utm($id);
							}

							$for_ga = ($session_utm == NULL) ? array() : $session_utm;
							// log_message('error', 'UTM ID: '.$id_utm);

							/*sampai di sini dulu tambahannya*/




							//-- UNSET ALL SESSION TERKAIT
							$this->session->set_userdata('first', true);
							$this->session->unset_userdata('me');
							$this->session->unset_userdata('konek_by');

							//$this->ion_auth->activate($id, false);
							//$this->ion_auth->force_login($id);

							if(!$this->input->is_ajax_request()){
								redirect($redir);
							} else {
								//echo json_encode(array('url'=>$redir, 'status'=>'success'));
								echo json_encode(array('status'=>'success','from_utm'=>$from_utm) + $for_ga);
								return;
							}
						}else{
							$email = $this->input->post('email');
							$name = $this->input->post('first_name').' '.$this->input->post('last_name');
							$this->profile_m->register_log($name, $email, 'Failed to register user');

							echo json_encode(array('message'=>$this->ion_auth->errors(), 'status'=>'failed'));
							return;
						}

					/*} else {
						echo json_encode(array('status'=>'failed', 'message'=> 'Maaf anda tidak dapat melanjutkan pendaftaran, karena usia anak anda belum mencukupi syarat pendaftaran.'));
						return;
					}*/
				}
			}else{
				foreach ($validation as $key => $fields) {
					$data_[$fields['field']] = form_error($fields['field']);
				}

				echo json_encode(array('status'=>'failed', 'error'=> $data_));
				return;
			}
		}
	}

	/**
	 * Let's login, shall we?
	 */
	public function login_user(){
		$url = site_url();
		if($redirect_to = $this->session->userdata('last_url')) {
			$url = $redirect_to;

			if($redirect_uri = $this->session->userdata('preganancytool_url')) {
				$url = site_url($redirect_uri);
			}
		} else if ($this->agent->is_referral()) {
		    $url = $this->agent->referrer();
		}

		if($this->current_user){
			$this->session->set_userdata('just_login', true);
			if($this->input->is_ajax_request()){
				$data = array(
					'status' => true,
					'message' => 'Anda Sudah Login',
					'data' => '', 'url'=>$url
				);
			}else{
				redirect($url);
			}
		}

		$validation = array(
			array(
				'field' => 'email',
				'label' => lang('global:email'),
				'rules' => 'required|trim|xss_clean|valid_email'
			),
			array(
				'field' => 'password',
				'label' => lang('global:password'),
				'rules' => 'required|trim|xss_clean'
			),
			array(
				'field' => 'captcha',
				'label' => 'Captcha',
				'rules' => 'trim|xss_clean|callback__captcha_check'
			),
		);

		// Set the validation rules
		$this->form_validation->set_rules($validation);

		// If the validation worked, or the user is already logged in
		if ($this->form_validation->run()){
			// trigger a post login event for third party devs
			//Events::trigger('post_user_login');

			// Get the user data
			$user = (object) array(
				'email' => strtolower($this->input->post('email')),
				'password' => $this->input->post('password')
			);

			if ($this->input->is_ajax_request()){
				if($this->_check_login($user->email)){
					$user = $this->ion_auth->get_user_by_email($user->email);
					$user->password = '';
					$user->salt = '';

					$this->session->set_userdata('just_login', true);
					$data = array(
						'status' 	=> true,
						'message' 	=> lang('user:logged_in'),
						'data' 		=> $user,
						'url'		=> $url
					);

					exit(json_encode($data));
				}else{
					$data = array('status' => false, 'message' => $this->session->userdata('message'));
					$this->session->unset_userdata('message');
					exit(json_encode($data));
				}
			} else {
				redirect();
			}
		}else{
			$error = array();
			foreach ($validation as $key => $value) {
				$error[$value['field']] = form_error($value['field']);
			}

			$data = array('status' => false, 'error' => $error);
			exit(json_encode($data));
		}
	}

	public function update_profile(){
		$redir = $this->session->userdata('last_url') ? $this->session->userdata('last_url') : site_url();
		$this->session->set_userdata('first', true);
		if($this->current_user && $this->session->userdata('first')){
			$child = array(); // $this->profile_m->get_child(array('user_id'=>$this->current_user->id));
			$profile = $this->profile_m->get_profile(array('user_id'=>$this->current_user->id));
			$region = $this->user_m->order_by('provinsi_name', 'ASC')
								   ->get_all_data('location_provinsi');
			$region = array(''=>'Pilih Provinsi') + array_for_select($region, 'provinsi_id', 'provinsi_name');
			$city = array(''=>'Pilih Provinsi Dulu');
			$validation= array(
				'first_name'	=> array(
					'field'	=> 'first_name',
					'label'	=> 'Nama Depan',
					'rules'	=> 'required|trim|xss_clean|alpha'
				),
				'last_name'	=> array(
					'field'	=> 'last_name',
					'label'	=> 'Nama Belakang',
					'rules'	=> 'required|trim|xss_clean|alpha'
				),
				'dob'	=> array(
					'field'	=> 'dob',
					'label'	=> 'Tanggal Lahir',
					'rules'	=> 'required|trim|xss_clean'
				),
				'phone'	=> array(
					'field'	=> 'phone',
					'label'	=> 'Nomor Telepon',
					'rules'	=> 'trim|max_length[20]|required|callback__phone_check|numeric'
				),
				'address'	=> array(
					'field'	=> 'address',
					'label'	=> 'Alamat',
					'rules'	=> 'required|trim|xss_clean'
				),
				'city'	=> array(
					'field'	=> 'city',
					'label'	=> 'Kota',
					'rules'	=> 'required|trim|xss_clean'
				),
				'region'	=> array(
					'field'	=> 'region',
					'label'	=> 'Provinsi',
					'rules'	=> 'required|trim|xss_clean'
				),
				'pregnancy_age' => array(
					'field'	=> 'pregnancy_age',
					'label'	=> 'Usia Kehamilan',
					'rules'	=> 'trim|xss_clean|numeric'
				),
			);

			if($this->input->post()){
				$rules = array_merge($validation);
				$this->form_validation->set_rules($rules);
				if ($this->form_validation->run()){
					$new_data = array(
						'first_name' => $this->input->post('first_name'),
						'last_name' => $this->input->post('last_name'),
						'dob' => $this->input->post('dob'),
						'address_line1' => $this->input->post('address'),
						'address_line3' => $this->input->post('region'),
						'address_line4' => $this->input->post('city'),
						'pregnant' => $this->input->post('pregnant'),
						'pregnancy_age' => $this->input->post('pregnancy_age'),
					);

					//update images profile
		            if($profile = $this->input->post('image')){
		            	$uniq = uniqid();
						$profile = preg_replace('/data:image\/\w+;base64,/', '', $profile);
						$profile = str_replace("[removed]", "", $profile);
						$image = base64_decode($profile);
						if(!is_dir('./uploads/profile/')){
							mkdir('./uploads/profile/', 755, true);
						}
						$file = 'uploads/profile/'.$uniq.'.png';
						$success = file_put_contents('./'.$file, $image);

						if($success){
		                	$new_data 	= array(
		                		'photo_profile'	=> $file,
		                	);
						}
		            }

		            if($this->db->update('profiles', $new_data, array('user_id'=>$this->current_user->id))){
		            	$this->session->unset_userdata('first');
						if(!$this->input->is_ajax_request()){
							redirect($redir);
						} else {
							echo json_encode(array('url'=>$redir, 'status'=>'success'));
							return;
						}
					}else{
						$this->session->set_flashdata('error', 'Failed to Update Profile');
						redirect('update_profile');
					}
				}else{
					$profile = new stdClass();
					foreach ($validation as $key => $field) {
						$profile->$field['field'] = set_value($field['field']);
					}

					if($region_id = $this->input->post('region')){
						$city = $this->user_m->order_by('kota_name', 'ASC')
									 ->where('provinsi_id', $region_id)
								     ->get_all_data('location_kota');
						$city = array(''=>'Pilih Kota') + array_for_select($city, 'kota_id', 'kota_name');
					}
				}
			}

			$this->template->set_layout('article.html')
						   ->title('Lengkapi Profile')
						   ->set('profile', $profile)
						   ->set('chlid', $child)
						   ->set('region', $region)
						   ->set('city', $city)
						   ->build('update_profile');
		}else{
			redirect($redir);
		}
	}

	/**
	 * Method to log the user out of the system
	 */
	public function logout(){
		// allow third party devs to do things right before the user leaves
		//Events::trigger('pre_user_logout');
		$this->afs_mail_user();

		$this->ion_auth->logout();
		$this->session->sess_destroy();

		if ($this->input->is_ajax_request()){
			exit(json_encode(array('status' => true, 'message' => lang('user:logged_out'))));
		} else {
			$this->session->set_flashdata('success', lang('user:logged_out'));
			redirect();
		}
	}

	public function dashboard($page_active = '', $article_slug=''){
		if(!$this->current_user || $this->current_user->group_id==1){
			redirect();
		}

		if($page_active==''){
			$page_active = 'edit-profile';
			// if($this->current_user->group_id==3){
			// 	$page_active = 'view-artikel';
			// }
		}

		$page = array('edit-profile', 'my-activity', 'settings', 'tulis-artikel', 'edit-artikel', 'view-artikel', 'dash-expert');
		if(!in_array($page_active, $page) and empty($article_slug)){
			redirect('dashboard');
		} else if ($page_active=='edit-artikel') {
			if ($article_slug=='') {
				$page_active = 'my-activity';
				if($this->current_user->group_id==3){
					$page_active = 'view-artikel';
				}
				redirect('dashboard/'.$page_active);
			}
		}

		$per_page = 6;
		$child = array(); // $this->profile_m->get_child(array('user_id'=>$this->current_user->id))->result_array();
		if(!empty($child)) {
			$to = new DateTime('today');
			foreach ($child as $key => $cld) {
				$from 	= new DateTime($cld['dob']);
				$old 	= (array)$from->diff($to);

				if($old['y']<=0) {
					$indoOld = $old['m'].' bulan';
				} else {
					$indoOld = $old['y'].' tahun '.$old['m'].' bulan';
				}
				$child[$key]['indo_age'] 		= $indoOld;
				$child[$key]['indo_date'] 		= $this->indo_date('d M Y', $cld['dob']);
				$child[$key]['gender_label'] 	= ($cld['gender']==1) ? 'boy' : 'girl';
			}
		}

		$profile = $this->profile_m->get_profile(array('user_id'=>$this->current_user->id));
		$profile->dob = $this->indo_date('d M Y', $profile->dob);

		$region = $this->user_m
					   ->order_by('provinsi_name', 'ASC')
					   ->get_all_data('location_provinsi');
		$region = array(''=>'Pilih Provinsi') + array_for_select($region, 'provinsi_id', 'provinsi_name');
		$region_id = $profile->address_line3 ? $profile->address_line3 : 0;
		$city = array(''=>'Pilih Provinsi Dulu');
		if($region_id){
			$city = $this->user_m->order_by('kota_name', 'ASC')
						 ->where('provinsi_id', $region_id)
					     ->get_all_data('location_kota');
			$city = array(''=>'Pilih Kota') + array_for_select($city, 'kota_id', 'kota_name');
		}

		$ae_notif = 0;
		$all_ae_notif = $this->profile_m->get_ae_notif($this->current_user->id, array('answer_status'=>'publish'))->result();
		$ae_notif = $this->profile_m->get_ae_notif($this->current_user->id, array('notif_read'=>0, 'answer_status'=>'publish'))->num_rows();

		$activity_all_count = $this->profile_m->get_notif($this->current_user->id)->num_rows();
		$activity_count = $this->profile_m->get_notif($this->current_user->id, array('read_status'=>0))->num_rows();
		$activity = $this->profile_m->get_notif($this->current_user->id, array(), array('limit'=>$per_page, 'offset'=>0))->result();
		$month = array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');


		$merge_activity = array_merge((array)$activity, (array)$all_ae_notif);

		// article
		$users_article = array();
		$edit_article = array();
		$edit_ar_files = array();
		$edit_ar_imgs = array();
		$edit_ar_video = array();
		$edit_ar_yt = array();

		if($this->current_user->group_id==3){
			$this->session->unset_userdata('dashboard-dir');
			$this->session->unset_userdata('dashboard-radio-img');
			$this->session->unset_userdata('dashboard-radio-file');
			$this->session->unset_userdata('dashboard-radio-edit');

			$users_article = $this->article_m->get_by_article(array('authors_id'=>$this->current_user->id));

			if (!empty($users_article)) {
				foreach ($users_article as $key => $article) {
					$article->created = $this->indo_date('d M Y',$article->created);

					$article->gallery = new stdClass;
					$article->as_bg = new stdClass;
					$data_files = $this->article_m->where(array('article_id' => $article->article_id))->get_all_data('article_files');
					if (!empty($data_files)) {
						$article->gallery = $data_files;
						foreach ($data_files as $file) {
							if ($file->as_background==1) {
								$article->as_bg = $file->full_path;
							}
						}
					}

					$article->count_comment = new stdClass;
					$count_comment			= $this->article_m->count_comments(array('status'=>'live','article'=>$article->article_id));
					if (!empty($count_comment)) {
						$article->count_comment = $count_comment;
					} else {
						$article->count_comment = 0;
					}
				}
			}

			if(!empty($article_slug)) {
				$article_slug = $this->security->xss_clean($article_slug);
				$edit_article = $this->article_m->where(array('article.slug' => $article_slug))->get_single_articles();

				$this->db->order_by('article_files.imges_id', 'DESC');
				$id_fls = $this->db->get('article_files')->row();
				$this->session->set_userdata('dashboard-radio-edit',$id_fls->imges_id);

				$edit_ar_files = $this->article_m->where(array('article_id' => $edit_article->article_id,'ftype'=>'file'))->get_all_data('article_files');
				$edit_ar_imgs = $this->article_m->where(array('article_id' => $edit_article->article_id,'ftype'=>'img'))->get_all_data('article_files');
				$edit_ar_video = $this->article_m->where(array('article_id' => $edit_article->article_id,'ftype'=>'video'))->get_all_data('article_files');
				$edit_ar_yt = $this->article_m->where(array('article_id' => $edit_article->article_id,'ftype'=>'youtube'))->get_all_data('article_files');
			}
		}

		/* $ar_template = array(
			'no-image'			=>'Article without image',
			'thumb' 			=>'Article with thumbnail',
			'2-tile' 			=>'Article with merge tile',
			'gallery' 			=>'Article with gallery',
		); */

		$ar_template = array(
			'none'     => 'Without image',
            'banner'   => 'Banner',
            'carousel' => 'Image Carousel',
            'youtube'  => 'Youtube Video URL',
            'video'    => 'Video'
        );

		$ar_bg_color = array(
			'red'			=>'Red',
			'yellow'		=>'Yellow',
		);

		$list_kidsage 	= array();
		$list_category 	= array();

		foreach ($this->article_m->get_many_kidsage(array('status'=>'live')) as $key => $row) {
			$list_kidsage[$key] = array(
				'id' => $row->kidsage_id,
				'title' => $row->title,
				'full_path' => $row->full_path,
			);
	   	}

	   	foreach ($this->article_m->get_many_category(array('status'=>'live')) as $key => $row) {
			$list_category[$key] = array(
				'id' => $row->categories_id,
				'title' => $row->title,
				'full_path' => $row->full_path,
			);
	   	}

	   	// Tambahan E-Voucher from UTM
		if (!is_dir('./uploads/e_voucher/')) {
			mkdir('./uploads/e_voucher/', 0755, true);
		}

		$e_voucher = 'uploads/e_voucher/'.$this->current_user->username.'.png';
		$saved_voucher_path = './'.$e_voucher;

		if (!is_file($saved_voucher_path)) {
			$voucher_code = $this->db
				->where('user_id', $this->current_user->user_id)
				->where('status', 1)
				->get('utm_code')
				->row();

			if ($voucher_code) {
				$font_path = getcwd().'/addons/default/themes/wyeth/img/utm/Lato-Black.ttf';
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher.png'; // Part 1
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-2.png'; // Part 2
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-3.png'; // Part 3
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-4.png'; // Part 4
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-5.png'; // Part 5
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-6.png'; // Part 6
				// $voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-7.png'; // Part 7
				//$voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-8.png'; // Part 8
				//$voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-9.png'; // Part 9
				$voucher_img_src = getcwd().'/addons/default/themes/wyeth/img/utm/e-voucher-10.png'; // Part 9
			   	$voucher_img = imagecreatefrompng($voucher_img_src);
			   	$voucher_text = sprintf('Kode Voucher %s*', $voucher_code->code);
			   	$text_color = imagecolorallocate($voucher_img, 109, 111, 113); // #6d6f71

			   	// imagettftext($voucher_img, 20, 0, 110, 235, $text_color, $font_path, $voucher_text); // Part 1
			   	// imagettftext($voucher_img, 14, 0, 200, 203, $text_color, $font_path, $voucher_text); // Part 2
			   	// imagettftext($voucher_img, 14, 0, 196, 203, $text_color, $font_path, $voucher_text); // Part 3
			   	imagettftext($voucher_img, 14, 0, 196, 235, $text_color, $font_path, $voucher_text); // Part 4

			   	// header('Content-Type: image/png');
			   	// imagepng($voucher_img);
			   	// imagedestroy($voucher_img);
			   	// exit();

			   	// Save image to file and destroy previous resource
			   	imagepng($voucher_img, $saved_voucher_path);
			   	imagedestroy($voucher_img);
			}
		}
	   	// E-Voucher from UTM

	   	Asset::js('module::SimpleAjaxUploader.js');
		// end of article

		$expert = false;
		$ask_params = array();
		$asks_data = array();
		$asks_data_total = array();
		$asks_data_total_unread = array();
		$doctor_data = array();
		$doctor_data_all = array();

		if (in_array($this->current_user->group, array('expert', 'super_expert'))) {
			$expert = true;
			$super_admin = $this->current_user->group === 'super_expert' ? true : false;
			$doctor_data = $this->user_m->get_doctor_details($this->current_user->user_id);
			$ask_params = array(
				'status'      => 'all',
				'order'       => array('a.ask_id', 'DESC'),
				'super_admin' => $super_admin,
				'limit'       => $this->ask_limit,
				'offset'      => 0
			);

			$this->load->model('ask_expert/doctor_m');
			$doctor_data_all = $this->doctor_m->get_doctor();

			if (isset($_GET['read']) && (int) $_GET['read'] == 0) {
				$ask_params['status'] = 'unpublish';
			}

			if ($doctor_data) {
				$ask_params['doctor_id'] = $doctor_data->doctor_id;
			}

			$asks_data = $this->user_m->get_asks_data($ask_params);

			foreach ($asks_data as $ask_sc) {
				$this->load->model('ask_expert/ask_expert_m');

				$ask_sc->comments = $this->ask_expert_m->get_ask_comments(array('arid' => $ask_sc->ask_id));
			}

			unset($ask_params['limit'], $ask_params['offset']);
			$ask_params['status'] = 'all';
			$asks_data_total = $this->user_m->get_asks_data($ask_params);

			$ask_params['status'] = 'unpublish';
			$asks_data_total_unread = $this->user_m->get_asks_data($ask_params);

			if (!isset($_GET['read']) || (isset($_GET['read']) && (int) $_GET['read'] != 0)) {
				$ask_params['status'] = 'all';
			}
		}

		$asks_data_count = count($asks_data_total) - $this->ask_limit;
		$asks_data_count_unread = count($asks_data_total_unread) - $this->ask_limit;

		if ($this->session->userdata('expert_unread_counts')) {
            $asks_data_count_unread = 0;
        }

		$this->template
			 ->set('page_active', $page_active)
			 ->set('child', $child)
			 ->set('profile', $profile)
			 ->set('region', $region)
			 ->set('city', $city)
			 ->set('activity_all_count', $activity_all_count)
			 ->set('activity_count', $activity_count+=$ae_notif)
			 // ->set('activity', $activity)
			 ->set('activity', $merge_activity)
			 ->set('month', $month)
			 ->set('per_page', $per_page)
			 ->set('users_article', $users_article)
			 ->set('edit_article', $edit_article)
			 ->set('edit_ar_files', $edit_ar_files)
			 ->set('edit_ar_imgs', $edit_ar_imgs)
			 ->set('edit_ar_video', $edit_ar_video)
			 ->set('edit_ar_yt', $edit_ar_yt)
			 ->set('ar_template', $ar_template)
			 ->set('ar_bg_color', $ar_bg_color)
			 ->set('list_kidsage', $list_kidsage)
			 ->set('list_category', $list_category)
			 ->set('e_voucher', $e_voucher)
			 ->set('expert', $expert)
			 ->set('asks_data', $asks_data)
			 ->set('asks_data_count', $asks_data_count)
			 ->set('asks_data_count_unread', $asks_data_count_unread)
			 ->set('ask_params', $ask_params)
			 ->set('ask_limit', $this->ask_limit)
			 ->set('doctor_data', $doctor_data)
			 ->set('doctor_data_all', $doctor_data_all)
			//  ->append_css('bootstrap-toggle.min.css')
			//  ->append_js('bootstrap-toggle.min.js')
			->append_css('theme::summernote.css')
			->append_css('theme::p-db.css')
			->append_js('theme::summernote.js')
			 ->build('dashboard_revamp');
	}

	/**
	 * Edit Profile
	 *
	 * @param int $id
	 */
	public function edit(){
		if(!$this->current_user || $this->current_user->group_id == 1){
			redirect(site_url());
		}

		$validation= array(
			'first_name'	=> array(
				'field'	=> 'first_name',
				'label'	=> 'Nama Depan',
				'rules'	=> 'required|trim|xss_clean|callback__string_spasi'
			),
			'last_name'	=> array(
				'field'	=> 'last_name',
				'label'	=> 'Nama Belakang',
				'rules'	=> 'required|trim|xss_clean|callback__string_spasi'
			),
			'gender'	=> array(
				'field'	=> 'gender',
				'label'	=> 'Jenis Kelamin',
				'rules'	=> 'required|trim|xss_clean|alpha'
			),
			'dob'	=> array(
				'field'	=> 'dob',
				'label'	=> 'Tanggal Lahir',
				'rules'	=> 'required|trim|xss_clean'
			),
			'phone'	=> array(
				'field'	=> 'phone',
				'label'	=> 'Nomor Telepon',
				'rules'	=> 'trim|max_length[20]|required|callback__phone_check|numeric|xss_clean'
			),
			'address_line1'	=> array(
				'field'	=> 'address_line1',
				'label'	=> 'Alamat',
				'rules'	=> 'required|trim|xss_clean|callback__string_angka_spasi'
			),
			'address_line4'	=> array(
				'field'	=> 'address_line4',
				'label'	=> 'Kota',
				'rules'	=> 'required|trim|xss_clean'
			),
			'address_line3'	=> array(
				'field'	=> 'address_line3',
				'label'	=> 'Provinsi',
				'rules'	=> 'required|trim|xss_clean'
			),
			'profesi'	=> array(
				'field'	=> 'profesi',
				'label'	=> 'Profesi',
				'rules'	=> 'trim|xss_clean|callback__string_spasi'
			),
			'bio'	=> array(
				'field'	=> 'bio',
				'label'	=> 'Bio',
				'rules'	=> 'trim|xss_clean|callback__string_angka_spasi'
			),
			/*'image'	=> array(
				'field'	=> 'image',
				'label'	=> 'Image',
				'rules'	=> 'trim|xss_clean'
			),*/
			'pregnant'	=> array(
				'field'	=> 'pregnant',
				'label'	=> 'Bio',
				'rules'	=> 'trim|xss_clean'
			),
			'pregnancy_age' => array(
				'field'	=> 'pregnancy_age',
				'label'	=> 'Usia Kehamilan',
				'rules'	=> 'trim|xss_clean|numeric'
			),
		);

		if($this->input->post()){
			$this->form_validation->set_rules($validation);
			if($this->form_validation->run()){
				$new_data = array(
					'first_name' => $this->input->post('first_name'),
					'last_name' => $this->input->post('last_name'),
					'gender' => $this->input->post('gender'),
					'dob' => $this->input->post('dob'),
					'phone' => $this->input->post('phone'),
					'address_line1' => $this->input->post('address_line1'),
					'address_line3' => $this->input->post('address_line3'),
					'address_line4' => $this->input->post('address_line4'),
					'pregnant' => $this->input->post('pregnant'),
					'pregnancy_age' => $this->input->post('pregnancy_age'),
					'profesi' => $this->input->post('profesi'),
					'bio' => $this->input->post('bio'),
					'fb_account' => $this->input->post('fb_account'),
					'tw_account' => $this->input->post('tw_account'),
					'ig_account' => $this->input->post('ig_account'),
					'website' => $this->input->post('website'),
				);

				//update images profile
	            if($profile = $this->input->post('image')){
	            	$uniq = uniqid();
					/* old requirment */
					/* $profile = preg_replace('/data:image\/\w+;base64,/', '', $profile);
					$profile = str_replace("[removed]", "", $profile);
					$image = base64_decode($profile);
					if(!is_dir('./uploads/profile/')){
						mkdir('./uploads/profile/', 755, true);
					}
					$file = 'uploads/profile/'.$uniq.'.png';
					$success = file_put_contents('./'.$file, $image);

					if($success){
	                	$new_data 	= array(
	                		'photo_profile'	=> $file,
	                	);
					} */
					/* old requirment */

					/* new requirment */
					$image_config['image_library'] = 'gd2';
	                $image_config['source_image'] = $profile['lastProfileImagePath'].$profile['lastProfileImageName'];
	                $image_config['new_image'] = $profile['lastProfileImagePath'].$uniq.'-'.$profile['lastProfileImageName'];
	                $image_config['quality'] = "100%";
	                $image_config['maintain_ratio'] = FALSE;
	                //$image_config['dynamic_output'] = TRUE;
	                $image_config['x_axis'] = $profile['x'];
	                $image_config['y_axis'] = $profile['y'];
	                // $image_config['width'] = '250';
	                // $image_config['height'] = '259';
	                $image_config['width'] = $profile['width'];;
	                $image_config['height'] = $profile['height'];

	                $this->load->library('image_lib', $image_config);

			        $this->image_lib->initialize($image_config);
			        if (!$this->image_lib->crop()){
			            echo $this->image_lib->display_errors();
			        } else {
			        	$new_data 	= array(
	                		'photo_profile'	=> $profile['lastProfileImagePath'].$uniq.'-'.$profile['lastProfileImageName'],
	                	);
			        }
					/* new requirment */
	            }

	            if($this->db->update('profiles', $new_data, array('user_id'=>$this->current_user->id))){
	            	//sent email after suksess update
					$data_mail = array(
						'message' => 'Selamat, profile anda telah berhasil diubah',
						'subject' => 'Ubah Profile Sukses',
						'button_text' => 'Konfirmasi Email',
						'url' => '',
						'headline' => 'Ubah Profile Sukses'
					);

					/*$this->load->library('Mandrill/Mandrill');
					$message = array(
				        'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $this->current_user->email,
				                'name' => $this->current_user->display_name,
				                'type' => 'to'
				            )
				        ),
				        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
				    );
					$this->mandrill->messages->send($message, false, '', '2016-09-01');*/

					$this->load->library('Swiftmailer/Baseswiftmailer');
					$message = array(
				       	'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $this->current_user->email,
				                'name' => $this->current_user->display_name,
				            )
				        ),
				    );
					$mailer = $this->baseswiftmailer->send($message);

					echo json_encode(array('status'=>true, 'message'=>'Profile Updated'));
				}else{
					echo json_encode(array('status'=>false, 'message'=>'Failed to Update Profile'));
				}
			}else{
				$data = new stdClass();
				foreach ($validation as $key => $field) {
					$data->$field['field'] = form_error($field['field']);
				}

				echo json_encode(array('status'=>false, 'errors'=>$data));
			}
		}
	}

	public function settings() {
		if(!$this->current_user) {
			redirect();
		}

		$validation= array(
			'old_password'	=> array(
				'field'	=> 'old_password',
				'label'	=> 'Kata Sandi Lama',
				'rules'	=> 'trim|required|callback__check_old_password'
			),
			'password'	=> array(
				'field'	=> 'password',
				'label'	=> 'Kata sandi',
				'rules' => 'trim|required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|callback_password_complexcity'
			),
			'r_password'=> array(
				'field'	=> 'r_password',
				'label'	=> 'Ulangi kata sandi',
				'rules'	=> 'trim|required|matches[password]'
			),
		);

		if($this->input->post()){
			$this->form_validation->set_rules($validation);
			if($this->form_validation->run()){
				$old_password 	= $this->input->post('old_password');
				$password 		= $this->input->post('password');
				$email 			= $this->current_user->email;

				$upd = $this->ion_auth->change_password($email, $old_password, $password);
				if($upd){
					//sent email after suksess update
					$data_mail = array(
						'message' => 'Selamat, password anda telah berhasil diubah',
						'subject' => 'Ubah Password Sukses',
						'button_text' => 'Konfirmasi Email',
						'url' => '',
						'headline' => 'Ubah Password Sukses'
					);

					/*$this->load->library('Mandrill/Mandrill');
					$message = array(
				        'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $email,
				                'name' => $this->current_user->display_name,
				                'type' => 'to'
				            )
				        ),
				        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
				    );
					$this->mandrill->messages->send($message, false, '', '2016-09-01');*/

					$this->load->library('Swiftmailer/Baseswiftmailer');
					$message = array(
				       	'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $email,
				                'name' => $this->current_user->display_name,
				            )
				        ),
				    );
					$mailer = $this->baseswiftmailer->send($message);

					echo json_encode(array('status'=>true, 'message'=>'Berhasil memperbaharui settings'));
				}else{
					echo json_encode(array('status'=>false, 'message'=>'Gagal memperbaharui settings'));
				}
			}else{
				$data = new stdClass;
				foreach($validation as $key => $value) {
					$data->{$value['field']} = form_error($value['field']);
				}

				echo json_encode(array('status'=>false, 'errors'=>$data));
			}
		}
	}

	public function my_activity(){
		if(!$this->current_user){
			redirect();
		}else{
			$child = array(); //$this->profile_m->get_child(array('user_id'=>$this->current_user->id))->result_array();

			$this->template
				 ->set_layout('default.html')
				 ->set('child', $child)
				 ->build('my_activity');
		}
	}

	/**
	 * View a user profile based on the username
	 *
	 * @param string $username The Username or ID of the user
	 */
	public function view($username = null, $page_active='profile')	{
		$username or redirect();
		if (preg_match('/[^a-zA-Z\d]/', $page_active)) {
			redirect();
		}
		
		$data = $this->ion_auth->get_user_by_username($username);
		if(!$data || $data->group_id==1){
			redirect();
		}else{
			$child = array(); // $this->profile_m->get_child(array('user_id'=>$data->id))->result_array();
			$profile = $this->profile_m->get_profile(array('user_id'=>$data->id));
			$month = array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

			// article
			$users_article = new stdClass();
			if($data->group_id==3){
				$users_article = $this->article_m->get_by_article(array('authors_id'=>$data->id,'status'=>'live'));

				if (!empty($users_article)) {
					foreach ($users_article as $key => $article) {
						$article->created = $this->indo_date('d M Y',$article->created);

						$article->gallery = new stdClass;
						$article->as_bg = new stdClass;
						$data_files = $this->article_m->where(array('article_id' => $article->article_id))->get_all_data('article_files');
						if (!empty($data_files)) {
							$article->gallery = $data_files;
							foreach ($data_files as $file) {
								if ($file->as_background==1) {
									$article->as_bg = $file->full_path;
								}
							}
						}

						$article->count_comment = new stdClass;
						$count_comment			= $this->article_m->count_comments(array('status'=>'live','article'=>$article->article_id));
						if (!empty($count_comment)) {
							$article->count_comment = $count_comment;
						} else {
							$article->count_comment = 0;
						}
					}
				}
			}

			$this->template
				 ->title('User Profile', ucwords($profile->display_name))
				 ->set('page_active', $page_active)
				 ->set('month', $month)
				 ->set('child', $child)
				 ->set('profile', $profile)
				 ->set('group_id', $data->group_id)
				 ->set('users_article', $users_article)
				 ->append_css('theme::p-db.css')
				 ->build('profile_revamp');
		}
	}

	public function forgot_password(){
		if($this->current_user){
			redirect('dashboard');
		}

		$data = new stdClass();
		$validation = array(
			array(
				'field' => 'email',
				'label' => 'Email',
				'rules' => 'xss_clean|required|trim|valid_email||callback__string_email_tambahan'
			),
		);

		$this->form_validation->set_rules($validation);
		if($this->form_validation->run()){
			$email = $this->input->post('email');

			$data = $this->user_m->get_single_data(array('email'=>$email), 'users');
			if($data){
				if($this->ion_auth->forgotten_password($email)){
					$data = $this->user_m->get_single_data(array('email'=>$email), 'users');
					$data_mail = array(
						'message' => 'Tak perlu khawatir! Cukup klik link berikut untuk mengubah password Anda.',
						'subject' => 'Lupa password?',
						'button_text' => 'Ubah Password',
						'url' => site_url('password-recovery/'.$data->forgotten_password_code),
						'headline' => 'Lupa Password?'
					);

					//sent email after suksess update
					/*$this->load->library('Mandrill/Mandrill');
					$message = array(
				        'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'].$data_mail['url'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $data->email,
				                //'name' => $data->display_name,
				                'type' => 'to'
				            )
				        ),
				        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
				        'track_opens' => false,
        				'track_clicks' => false,
				    );
					$this->mandrill->messages->send($message, false, '', '2016-09-01');*/
					
					$this->load->library('Swiftmailer/Baseswiftmailer');
					$message = array(
				        'html' => $this->load->view('mail', $data_mail, true),
				        'text' => $data_mail['message'].$data_mail['url'],
				        'subject' => $data_mail['subject'],
				        'from_email' => 'donotreply@parentingclub.id',
				        'from_name' => 'Parenting Club',
				        'to' => array(
				            array(
				                'email' => $data->email,
				            )
				        ),
				    );
					$mailer = $this->baseswiftmailer->send($message);
					$this->session->set_flashdata('success', 'Silakan periksa email anda.');
				}
			}else{
				$this->session->set_flashdata('success', 'Silakan periksa email anda.');
			}
			redirect('forgot-password');
		}else{
			foreach ($validation as $key => $value) {
				$data->{$value['field']} = set_value($value['field']);
			}
		}

		$this->template
		     ->title('Forgot Password')
		     ->set('data', $data)
		     ->set_layout('blank-layout.html')
		     ->build('forgot');
	}

	public function password_recovery($code=''){
		if(!$code){
			redirect('forgot-password');
		}

		$user = $this->user_m->get_single_data(array('forgotten_password_code'=>$code), 'users');
		if(!$user){
			redirect('forgot-password');
		}

		// $data = new stdClass();
		$data = array();

		$validation = array(
			'password'	=> array(
				'field'	=> 'password',
				'label'	=> 'Kata sandi',
				'rules' => 'trim|required|min_length['.$this->config->item('min_password_length', 'ion_auth').']|max_length['.$this->config->item('max_password_length', 'ion_auth').']|callback_password_complexcity'
			),
			'r_password'=> array(
				'field'	=> 'r_password',
				'label'	=> 'Ulangi kata sandi',
				'rules'	=> 'trim|required|matches[password]'
			),
		);

		$this->form_validation->set_rules($validation);
		if($this->form_validation->run()){
			$new_pass = $this->ion_auth_model->hash_password($this->input->post('password'), $user->salt);
			$data = array(
				'password'					=> $new_pass,
				'forgotten_password_code'	=> '0',
				'active'					=> 1,
				'forgot_password_access'	=> null
			);

			if($this->user_m->update_data('users', $data, 'id', $user->id)){
				//sent email after suksess update
				$history = array(
					'user_id'=>$user->id,
					'password_new'=>$new_pass,
					'password_old'=>$user->password,
					'salt'=>$user->salt,
					'message'=>'password recorvery',
					'created_on'=>now(),
				);
				$this->history_password_m->insert($history);
				$this->user_m->update_data('profiles', array('password_temp'=>0), 'user_id', $user->id);

				//send email
				$data_mail = array(
					'message' => 'Selamat! Sekarang Anda sudah bisa kembali menjelajahi Parenting Club. Yuk nikmati berbagai fitur yang dirancang untuk membantu Anda mendukung kepintaran si Kecil.',
					'subject' => 'Password Anda berhasil diubah',
					'button_text' => 'Kunjungi sekarang',
					'url' => site_url(),
					'headline' => 'Password Anda berhasil diubah'
				);

				/*$this->load->library('Mandrill/Mandrill');
				$message = array(
			        'html' => $this->load->view('mail', $data_mail, true),
			        'text' => $data_mail['message'],
			        'subject' =>  $data_mail['subject'],
			        'from_email' => 'donotreply@parentingclub.id',
			        'from_name' => 'Parenting Club',
			        'to' => array(
			            array(
			                'email' => $user->email,
			                //'name' => $data->display_name,
			                'type' => 'to'
			            )
			        ),
			        'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
			    );
				$this->mandrill->messages->send($message, false, '', '2016-09-01');*/

				$this->load->library('Swiftmailer/Baseswiftmailer');
				$message = array(
					'html' => $this->load->view('mail', $data_mail, true),
			        'text' => $data_mail['message'],
			        'subject' =>  $data_mail['subject'],
			        'from_email' => 'donotreply@parentingclub.id',
			        'from_name' => 'Parenting Club',
			        'to' => array(
			            array(
			                'email' => $user->email,
			                //'name' => $data->display_name,
			                'type' => 'to'
			            )
			        ),
			    );
				$mailer = $this->baseswiftmailer->send($message);

				$this->ion_auth->force_login($user->id);
				redirect('dashboard/profile');
			}else{
				$this->session->set_flashdata('error', 'Failed to reset password');
				redirect('password-recovery');
			}
		}else{
			foreach ($validation as $key => $value) {
				$data[$value['field']] = set_value($value['field']);
			}
			$data = (object)$data;
		}

		$this->template
			 ->title('Recorvery Password')
			 ->set('data', $data)
			 ->set_layout('blank-layout.html')
			 ->build('recorvery');
	}

	/**
	 * Activate a user
	 *
	 * @param int $id The ID of the user
	 * @param string $code The activation code
	 *
	 * @return void
	 */
	public function activate($code = ''){
		if($this->current_user){
			redirect('dashboard');
		}

		if(!$code){
			redirect();
		}

		$user = $this->user_m->get_single_data(array('activation_code'=>$code), 'users');
		if($user){
			$this->load->library('utm/utm');
			$result = $this->utm->is_user_utm($user->id);

			// $result = false;

			$this->ion_auth->activate($user->id, $code);
			$this->ion_auth->force_login($user->id);

			// limit tanggal matiin voucher
			date_default_timezone_set('Asia/Jakarta');
			$date_now = strtotime(date('Y-m-d H:i:s'));
			$date_limit = strtotime('2019-01-01 00:00:00');
			if ($date_now > $date_limit) {
				$result = false;
			}
			// limit tanggal matiin voucher

			$this->session->set_userdata('just_login', true);

			if ($result) {
				/*ambil data utm dulu*/
				$utm = $this->utm->get_utm($user->id);

				/*random to get code*/
				$code_utm = $this->utm->get_code();

				/*update untuk utm*/
				$this->utm->update_utm($user->id, NULL);

				/*update untuk utm code*/
				$this->utm->update_utm_code($user->id, $utm->source, $code_utm->id);
				$this->session->set_flashdata('source', $utm->source);

				// check total kode yang terpakai
				// kirim email notifikasi jika total sudah menyentuh angka 9000
				$total = $this->db->where('status', 1)
					->count_all_results('utm_code');

				if ($total == 9000) {

					$data_mail = array(
						'message'     => 'Total kode voucher yang sudah terpakai: '.$total.' kode',
						'subject'     => 'Total Kode Voucher Aktif',
						'button_text' => '',
						'headline'    => 'Total Kode Voucher Aktif',
						'url'		  => ''
					);

					// kirim email notifikasi
					/*$this->load->library('Mandrill/Mandrill');
					$message = array(
						'html'       => $this->load->view('mail', $data_mail, true),
						'text'       => $data_mail['message'].$data_mail['url'],
						'subject'    => $data_mail['subject'],
						'from_email' => 'donotreply@parentingclub.id',
						'from_name'  => 'Parenting Club',
						'to'         => array(
				            array(
								'email' => 'ajeng,wulandari@maxsolution.net',
								'type'  => 'to'
				            ),
				            array(
								'email' => 'kukuh.nugroho@ogilvy.com',
								'type'  => 'to'
				            ),
				            array(
								'email' => 'dhaniati.wiryawan@ogilvy.com',
								'type'  => 'to'
				            ),
				            array(
								'email' => 'antonius.budiono@ogilvy.com',
								'type'  => 'to'
				            )
				        ),
						'headers'      => array('Reply-To' => 'donotreply@parentingclub.id'),
						'track_opens'  => false,
						'track_clicks' => false,
				    );
					$this->mandrill->messages->send($message, false, '', '2016-09-01');*/

					$this->load->library('Swiftmailer/Baseswiftmailer');
					$message = array(
						'html'       => $this->load->view('mail', $data_mail, true),
						'text'       => $data_mail['message'].$data_mail['url'],
						'subject'    => $data_mail['subject'],
						'from_email' => 'donotreply@parentingclub.id',
						'from_name'  => 'Parenting Club',
						'to'         => array(
				            array(
								'email' => 'ajeng,wulandari@maxsolution.net',
								'type'  => 'to'
				            ),
				            array(
								'email' => 'kukuh.nugroho@ogilvy.com',
								'type'  => 'to'
				            ),
				            array(
								'email' => 'dhaniati.wiryawan@ogilvy.com',
								'type'  => 'to'
				            ),
				            array(
								'email' => 'antonius.budiono@ogilvy.com',
								'type'  => 'to'
				            )
				        ),
				    );
					$mailer = $this->baseswiftmailer->send($message);
				}

				// UTM user langsung ke dashboard
				redirect('activated');
			}

			redirect('activated');
		}else{
			redirect();
		}
	}

	public function activated(){
		if ($this->session->userdata('just_login')) {
			$this->session->unset_userdata('just_login');

			$this->template
				->title('Activated')
				->build('activate');
		} else {
			redirect();
		}
	}

	public function thank_you(){
		$this->template
			->title('Thank You')
			->set_layout('blank-layout.html')
			->build('thank_you');
	}
	public function thank_you_blog(){
		$this->template
			->title('Thank You')
			->build('thank_you_blog');
	}

	public function gplus_connect(){
		$this->load->library('gplus/gplus');
		$status = $this->gplus->connect();
       	$redir = $this->session->userdata('last_url') ? $this->session->userdata('last_url') : site_url();

       	if($status['status']==false){
           redirect($status['url']);
       	} else {
	        if($this->current_user && isset($this->current_user->id)) {
	            redirect($redir);
	        }

	        if(!$this->gplus->get_info()) {
	        	$gplus_connect_url = uri_string();
	        } else {
				$me = $this->gplus->get_info();
	        	$data_user = $this->profile_m->get_profile(array('gplus_id'=>$me['id']));

	        	if($data_user) {
	        		if($this->ion_auth->force_login($data_user->user_id)){
	                	redirect($redir);
	                }
	        	} else {
	        		$profile_data 					= array();
	                $profile_data['display_name'] 	= $me['displayName'];

	                $profile_data['gplus_id'] 		= $me['id'];
	                $profile_data['type_register'] 	= 'gplus';
	                $profile_data['email'] 			= (isset($me["modelData"]['emails'][0]['value'])) ? $me["modelData"]['emails'][0]['value'] : $email;
	                $profile_data['image_url'] 		= $me['image']['url'];
	                $profile_data['first_name']		= $me['name']['givenName'];
	                $profile_data['last_name']		= $me['name']['familyName'];

	                $this->session->set_userdata('me', $profile_data);
	                $this->session->set_userdata('konek_by', 'gplus');

	                $this->session->set_flashdata('first_register', true);
                	if(!$this->input->is_ajax_request()){
                		redirect($redir);
	                }else{
	                	echo json_encode(array('url'=>$redir));
	                }
	        	}
	        }
       	}
	}
	
	public function google_connect(){
		$this->load->library('google-api/Basegoogleapi');
		$status = $this->basegoogleapi->connect();
		$redir = $this->session->userdata('last_url') ? $this->session->userdata('last_url') : site_url();
		
		if($status['status']==false){
			redirect($status['url']);
		} else {
	        if($this->current_user && isset($this->current_user->id)) {
	            redirect($redir);
	        }

	        if(!$this->basegoogleapi->get_info()) {
	        	$gplus_connect_url = uri_string();
	        } else {
				$me = $this->basegoogleapi->get_info();
				if($me) {
					$events = $this->basegoogleapi->addEvent();
					echo "add-event--<br/>";
					dnd($events);
				}
				$data_user = $this->profile_m->get_profile(array('gplus_id'=>$me['id']));

	        	if($data_user) {
	        		if($this->ion_auth->force_login($data_user->user_id)){
	                	redirect($redir);
	                }
	        	} else {
	        		$profile_data 					= array();
	                $profile_data['display_name'] 	= $me['displayName'];

	                $profile_data['gplus_id'] 		= $me['id'];
	                $profile_data['type_register'] 	= 'gplus';
	                $profile_data['email'] 			= (isset($me['emails'][0]['value'])) ? $me['emails'][0]['value'] : $email;
	                $profile_data['image_url'] 		= $me['image']['url'];
	                $profile_data['first_name']		= $me['name']['givenName'];
	                $profile_data['last_name']		= $me['name']['familyName'];

	                $this->session->set_userdata('me', $profile_data);
	                $this->session->set_userdata('konek_by', 'gplus');

	                $this->session->set_flashdata('first_register', true);
                	if(!$this->input->is_ajax_request()){
                		redirect($redir);
	                }else{
	                	echo json_encode(array('url'=>$redir));
	                }
	        	}
			}
		}
    }

	public function fb_connect(){
        // $redir = $this->session->userdata('last_url') ? $this->session->userdata('last_url') : site_url();
        $redir = site_url();
		if($redirect_to = $this->session->userdata('last_url')){
			$redir = $redirect_to;
		} else if ($this->agent->is_referral()) {
		    $redir = $this->agent->referrer();
		}

        if($this->current_user && isset($this->current_user->id)){
            redirect($redir);
        }

        if(!$this->facebook->getUser()) {
            $params = array(
            	'redirect_uri'=>site_url('fb-connect'),
            	'scope'=>array('email','public_profile')
            ); 
            $data_url = $this->facebook->getLoginUrl($params);

            echo '<script>window.location.href="'.$data_url.'";</script>';
            return;
        } else {
            $me = array();
            try {
                $me = $this->facebook->api('/me?fields=id,name,about,email,birthday');
            } catch(FacebookApiException $e) {
                echo '<html><head><META HTTP-EQUIV="REFRESH" CONTENT="5;URL='.site_url('fb-connect').'?'.(($this->input->get())?http_build_query($this->input->get()):'').'"><title>Sedang Di Arahkan Ulang</title></head><body>tunggu sebentar</body></html>';
                return;
            }

            $this->facebook->setExtendedAccessToken();
            $data_user = $this->profile_m->get_profile_new(array('fb_id'=>$me['id']));
            if ($data_user){
				$user_kid 		= 0; // $this->profile_m->get_child(array('user_id'=>$data_user->user_id))->num_rows();
            	$data_guestkid 	= ($this->session->userdata('unreg_kid')) ? $this->session->userdata('unreg_kid') : array();
            	$data_kids 		= array();

				if($data_guestkid){
					if($user_kid < 3 ) {
						$data_kids = array(
							'user_id'		=> $data_user->user_id,
							'name' 			=> $data_guestkid['child_name'],
							'dob'			=> $data_guestkid['child_dob'],
							'child_number' 	=> 0,
							'gender' 		=> $data_guestkid['child_gender'],
							'default' 		=> 'yes'
						);

						if($id_kid = $this->user_m->insert_data('users_child', $data_kids)) {
							$this->session->set_userdata('user_kid', $id_kid);
							$this->session->set_flashdata('add_anak', true);

							if($this->session->userdata('unreg_kid')) {
								$this->session->unset_userdata('unreg_kid');
							}
						}
					}
				}

				// email sebelumnya kosong
				if($data_user->email=='') {
					$dataUpdate = array('email'=>$me['email']);
					$this->user_m->update_data('users', $dataUpdate, 'id', $data_user->user_id);
					// $this->user_m->update_data('profiles', $dataUpdate, 'user_id', $data_user->user_id);
					$data_user_email = $me['email'];
				} else {
					$data_user_email = $data_user->email;					
				}

                //force login
                if($this->ion_auth->force_login($data_user->user_id)){
                    redirect($redir);
                }else{
                	$this->profile_m->login_log($data_user->display_name, $data_user_email, 'User not active');
                	$this->session->set_flashdata('noactive', 'Anda belum melakukan aktivasi, silakan cek email anda untuk melakukan aktivasi.');
                	redirect($redir);
                }
            } else {
                $profile_data 					= array();
                $profile_data['display_name'] 	= $me['name'];

                $this->split_fullname($me['name'], $profile_data);
                $profile_data['fb_id'] 			= $me['id'];
                $profile_data['type_register'] 	= 'facebook';
                $profile_data['email'] 			=  (isset($me['email'])) ? $me['email'] : '';
                $profile_data['bio'] 			=  (isset($me['bio'])) ? $me['bio'] : '';
                $profile_data['about'] 			=  (isset($me['about'])) ? $me['about'] : '';
                $profile_data['dob'] 			=  (isset($me['birthday'])) ? $me['birthday'] : '';
                $profile_data['image_url'] 		= 'https://graph.facebook.com/'.$me['id'].'/picture?type=square';

                $this->session->set_userdata('me', $profile_data);
                $this->session->set_userdata('konek_by', 'fb');
                $this->session->set_flashdata('first_register', true);

                if(!$this->input->is_ajax_request()){
                	redirect($redir);
                }else{
                	echo json_encode(array('url'=>$redir));
                }
            }
        }
    }

    public function tw_connect(){
		$redir = site_url();
		if($redirect_to = $this->session->userdata('last_url')){
			$redir = $redirect_to;
		} else if ($this->agent->is_referral()) {
		    $redir = $this->agent->referrer();
		}

		$this->load->library('twitter');
        $tw = $this->session->userdata('tw_data');
        $oauth_token = $this->input->get('oauth_token');
        $oauth_verifier = $this->input->get('oauth_verifier');
        $denied = $this->input->get('denied');

        $params = array(
            'key'      => Settings::get('tw_consumer_key'),
            'secret'   => Settings::get('tw_consumer_secret'),
        );

        if (isset($oauth_token) && $tw['token'] != $oauth_token) {
            session_destroy();
            redirect('tw-connect');
        } elseif (isset($oauth_token) && $tw['token'] == $oauth_token) {
        	$connection = new twitter($params['key'], $params['secret'], $tw['token'], $tw['token_secret']);
        	$access_token = $connection->getAccessToken($oauth_verifier);
            $params = array(
            	'include_entities' => true,
            	'include_status' => false,
            	'include_email' => true,
            );
            $me = $connection->get('account/verify_credentials', $params);
            $data_user = $this->profile_m->get_profile_new(array('tw_id'=>$me->id));
            if ($data_user){
            	$user_kid 		= 0; // $this->profile_m->get_child(array('user_id'=>$data_user->user_id))->num_rows();
            	$data_guestkid 	= ($this->session->userdata('unreg_kid')) ? $this->session->userdata('unreg_kid') : array();
            	$data_kids 		= array();

				if($data_guestkid){
					if($user_kid < 3 ) {
						$data_kids = array(
							'user_id'		=> $data_user->user_id,
							'name' 			=> $data_guestkid['child_name'],
							'dob'			=> $data_guestkid['child_dob'],
							'child_number' 	=> 0,
							'gender' 		=> $data_guestkid['child_gender'],
							'default' 		=> 'yes'
						);

						if($id_kid = $this->user_m->insert_data('users_child', $data_kids)) {
							$this->session->set_userdata('user_kid', $id_kid);
							$this->session->set_flashdata('add_anak', true);

							if($this->session->userdata('unreg_kid')) {
								$this->session->unset_userdata('unreg_kid');
							}
						}
					}
				}

				// email sebelumnya kosong
				if($data_user->email=='') {
					$dataUpdate = array('email'=>$me->email);
					$this->user_m->update_data('users', $dataUpdate, 'id', $data_user->user_id);
					// $this->user_m->update_data('profiles', $dataUpdate, 'user_id', $data_user->user_id);
					$data_user_email = $me->email;
				} else {
					$data_user_email = $data_user->email;
				}

                //force login
                if($this->ion_auth->force_login($data_user->user_id)){
                    redirect($redir);
                }else{
                	$this->profile_m->login_log($data_user->display_name, $data_user_email, 'User not active');
                	$this->session->set_flashdata('noactive', 'Anda belum melakukan aktivasi, silakan cek email anda untuk melakukan aktivasi.');
                	redirect($redir);
                }
            } else {
                $profile_data 					= array();
                $profile_data['display_name'] 	= $me->name;

                $this->split_fullname($me->name, $profile_data);
                $profile_data['tw_id'] 			= $me->id;
                $profile_data['type_register'] 	= 'twitter';
                $profile_data['email'] 			= (isset($me->email)) ? $me->email : '';
                $profile_data['bio'] 			= (isset($me->description)) ? $me->description : '';
                $profile_data['screen_name'] 	= (isset($me->screen_name)) ? $me->screen_name : '';
                $profile_data['image_url'] 		= $me->profile_image_url;

                $this->session->set_userdata('me', $profile_data);
                $this->session->set_userdata('konek_by', 'tw');
                $this->session->set_flashdata('first_register', true);

                if(!$this->input->is_ajax_request()){
                	redirect($redir);
                }else{
                	echo json_encode(array('url'=>$redir));
                }
            }
        } else {
            if (isset($denied)) {
                $this->session->unset_userdata('tw_data');
                session_destroy();
                redirect($redir);
            }

            $connection = new twitter($params['key'], $params['secret']);
            $request_token = $connection->getRequestToken(site_url('tw-connect'));

            $tw_data = array(
                'token'        => $request_token['oauth_token'],
                'token_secret' => $request_token['oauth_token_secret'],
            );

            $this->session->set_userdata('tw_data', $tw_data);

            if ($connection->http_code == 200) {
                $url = $connection->getAuthorizeURL($request_token['oauth_token']);
                redirect($url);
            } else {
                $this->session->set_flashdata('notif', 'Error connecting to Twitter');
                redirect($redir);
            }
        }
	}

	public function link_gplus(){
       	$this->load->library('gplus/gplus');
   		$redir = site_url('dashboard/settings');

       	$status = $this->gplus->connect();
       	if($status['status']==false){
        	redirect($status['url']);
       	} else {
	        if(!$this->current_user) {
	            redirect();
	        }

	        $me = $this->gplus->get_info();
        	$data_gplus = array(
		    	'gplus_id'	=> $me['id']
		    );

			$this->user_m->update_data('profiles', $data_gplus, 'user_id', $this->current_user->id);
            redirect($redir);
       	}
    }

	public function link_fb(){
    	$redir = site_url('dashboard/settings');

        if(!$this->current_user){
            redirect();
        }

        if(!$this->facebook->getUser()){
        	$params = array(
            	'redirect_uri'=>site_url('dashboard/link-fb'),
            	'scope'=>array('email','public_profile')
            );
            $data_url = $this->facebook->getLoginUrl($params);

            redirect($data_url);
            return;
        } else {
            $me =array();
            try {
                $me = $this->facebook->api('/me?fields=id,name,bio,about,email,birthday');
            } catch(FacebookApiException $e) {
                echo '<html><head><META HTTP-EQUIV="REFRESH" CONTENT="5;URL='.site_url('fb-connect').'?'.(($this->input->get())?http_build_query($this->input->get()):'').'"><title>Sedang Di Arahkan Ulang</title></head><body>tunggu sebentar</body></html>';
                return;
            }

            $this->facebook->setExtendedAccessToken();
            $data = array('fb_id'=>$me['id']);
			$this->user_m->update_data('profiles', $data, 'user_id', $this->current_user->id);
			redirect($redir);
        }
    }

    public function link_tw(){
    	if(!$this->current_user) {
            redirect();
        }

    	$this->load->library('twitter');
        $tw = $this->session->userdata('tw_data');
        $oauth_token = $this->input->get('oauth_token');
        $oauth_verifier = $this->input->get('oauth_verifier');
        $denied = $this->input->get('denied');

        $params = array(
            'key'      => Settings::get('tw_consumer_key'),
            'secret'   => Settings::get('tw_consumer_secret'),
        );

        if (isset($oauth_token) && $tw['token'] != $oauth_token) {
            session_destroy();
            redirect('dashboard/link-tw');
        } elseif (isset($oauth_token) && $tw['token'] == $oauth_token) {
        	$connection = new twitter($params['key'], $params['secret'], $tw['token'], $tw['token_secret']);
        	$access_token = $connection->getAccessToken($oauth_verifier);

            $data = array('tw_id' => $access_token['user_id']);
			if($this->user_m->update_data('profiles', $data, 'user_id', $this->current_user->id)){
				$this->session->set_flashdata('success', 'Connected to Twitter');
			}else{
				$this->session->set_flashdata('error', 'Failed Connect to Twitter');
			}

			redirect('dashboard/settings');
        } else {
            if (isset($denied)) {
                $this->session->unset_userdata('tw_data');
                session_destroy();
                redirect('');
            }

            $connection = new twitter($params['key'], $params['secret']);
            $request_token = $connection->getRequestToken(site_url('dashboard/link-tw'));

            $tw_data = array(
                'token'        => $request_token['oauth_token'],
                'token_secret' => $request_token['oauth_token_secret'],
            );
            $this->session->set_userdata('tw_data', $tw_data);

            if ($connection->http_code == 200) {
                $url = $connection->getAuthorizeURL($request_token['oauth_token']);
                redirect($url);
            } else {
                $this->session->set_flashdata('notif', 'Error connecting to Twitter');
                redirect('dashboard/settings');
            }
        }
    }

    public function unlink_gplus() {
		if(!$this->current_user) {
            redirect();
        }

		$data = array('gplus_id' => '');
		if($this->user_m->update_data('profiles', $data, 'user_id', $this->current_user->id)){
			$this->session->set_flashdata('success', 'Disconnected from Gplus');
		}else{
			$this->session->set_flashdata('error', 'Failed Disconnected from Gplus');
		}

		redirect('dashboard/settings');
	}

    public function unlink_fb() {
		if(!$this->current_user) {
            redirect();
        }

		$data = array('fb_id' => '');
		if($this->user_m->update_data('profiles', $data, 'user_id', $this->current_user->id)){
			$this->session->set_flashdata('success', 'Disconnected from Facebook');
		}else{
			$this->session->set_flashdata('error', 'Failed Disconnected from Facebook');
		}

		redirect('dashboard/settings');
	}

	public function unlink_tw() {
		if(!$this->current_user) {
            redirect();
        }

		$data = array('tw_id' => '');
		if($this->user_m->update_data('profiles', $data, 'user_id', $this->current_user->id)){
			$this->session->set_flashdata('success', 'Disconnected from Twitter');
		}else{
			$this->session->set_flashdata('error', 'Failed Disconnected from Twitter');
		}

		redirect('dashboard/settings');
	}

	public function tamp_last(){
		if (!$this->input->is_ajax_request()){
			redirect();
		}

		$last_url = $this->input->post('last_url');
		$this->session->set_userdata('last_url', $last_url);

		$ret['status'] = true;
		echo json_encode($ret);
	}

	public function get_city() {
		$id = $this->input->post('region_id');
		$city	= $this->user_m->order_by('kota_name', 'ASC')
							   ->where('provinsi_id', $id)
							   ->get_all_data('default_location_kota');

		$city = array_for_select($city, 'kota_id', 'kota_name');

		echo json_encode($city);
	}

	public function set_notif(){
		if(!$this->current_user){
			redirect();
		}

		if($status = $this->input->post('status')){
			if($this->user_m->update_data('profiles', array('notif'=>$status), 'user_id', $this->current_user->id)){
				$data = array('status'=>true);
				if($status=='off'){
					//unsubscribe from mailchimp
					$this->load->library('MailChimp');
					$this->mailchimp->unsubscribe($this->current_user->email);
				}else{
					//subscribe to mailchimp
					$this->load->library('MailChimp');
					$subscribe_data = array(
						'email' => $this->current_user->email,
						'status' => 'subscribed',
						'first_name' => $this->current_user->first_name,
						'last_name' => $this->current_user->last_name,
					);
					$this->mailchimp->subscribe($subscribe_data);
				}
			}else{
				$data = array('status'=>false);
			}

			echo json_encode($data);
		}
	}

	public function read_notif(){
		if(!$this->current_user){
			redirect();
		}

		if($id=$this->input->post('id')){
			$status = $this->input->post('status');
			if($this->profile_m->update_data('article_comments', array($status.'_read'=>1), array('comments_id'=>$id))){
				echo json_encode(array('status'=>true));
			}
		}
	}

	public function read_notif_answer(){
		if(!$this->current_user){
			redirect();
		}

		if($id=$this->input->post('id')){
			if($this->profile_m->update_data('default_ae_notif_answers', array('notif_read'=>1), array('answer_id'=>(int)$id))){
				echo json_encode(array('status'=>true));
			}
		}
	}

	public function more_notif(){
		if(!$this->current_user){
			redirect();
		}

		if($page = $this->input->post('page')){
			$per_page = 6;
			$offset = $per_page * ($page - 1);
			$activity = $this->profile_m->get_notif($this->current_user->id, array(), array('limit'=>$per_page, 'offset'=>$offset))->result();

			echo json_encode(array('status'=>true, 'data'=>$this->load->view('activity_list', array('activity'=>$activity), true)));
		}
	}

	public function add_child(){
		if($this->current_user){
			$validation = array(
				'child_name'	=> array(
					'field'	=> 'child_name',
					'label'	=> 'Nama Anak',
					'rules'	=> 'required|trim|xss_clean|callback__string_spasi'
				),
				'child_dob'	=> array(
					'field'	=> 'child_dob',
					'label'	=> 'Tanggal Lahir Anak',
					'rules'	=> 'required|trim|xss_clean'
				),
				'child_gender'	=> array(
					'field'	=> 'child_gender',
					'label'	=> 'Jenis Kelamin Anak',
					'rules'	=> 'required|trim|xss_clean'
				),
				'image'	=> array(
					'field'	=> 'image',
					'label'	=> 'Image',
					'rules'	=> 'trim|xss_clean'
				),
			);
			$month = array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

			$user_kid = 0; // $this->profile_m->get_child(array('user_id'=>$this->current_user->id))->num_rows();
			if($user_kid < 3 ) {
				$this->form_validation->set_rules($validation);
				if($this->form_validation->run()){
					$data = array(
						'user_id' => $this->current_user->id,
						'name' => $this->input->post('child_name'),
						'dob' => $this->input->post('child_dob'),
						'gender' => $this->input->post('child_gender'),
						'created_at' => date('Y-m-d H:m:s'),
					);

					if($id = $this->user_m->insert_data('users_child', $data)){
						//update images profile
						$data['photo_profile'] = '';
			            if($profile = $this->input->post('image')){
			            	$uniq = uniqid();
							$profile = preg_replace('/data:image\/\w+;base64,/', '', $profile);
							$profile = str_replace("[removed]", "", $profile);
							$image = base64_decode($profile);
							if(!is_dir('./uploads/profile/')){
								mkdir('./uploads/profile/', 755, true);
							}
							$file = 'uploads/profile/'.$uniq.'.png';
							$success = file_put_contents('./'.$file, $image);

							if($success){
			                	$new_data['photo_profile'] = $file;
			                	$data['photo_profile'] = site_url($file);

			            		// $this->db->update('users_child', $new_data, array('id'=>$id));
							}
			            }

			            $user_kid = 0; // $this->profile_m->get_child(array('user_id'=>$this->current_user->id))->num_rows();

						$data['id'] = $id;
						$dob = new DateTime($data['dob']);
						$now = new DateTime('today');

						$data['umur'] = $dob->diff($now);
						$dob=explode('-', $data['dob']);
						$data['dob'] = $dob[2].' '.$month[$dob[1]].' '.$dob[0];

						$this->session->set_flashdata('add_anak', true);

						$data_return['status'] = true;
						$data_return['data'] = $data;
						$data_return['user_kid'] = $user_kid;
					}else{
						$data_return['status'] = false;
						$data_return['message'] = 'Failed to add child';
					}
				}else{
					foreach ($validation as $key => $value) {
						$data[$value['field']] = form_error($value['field']);
					}

					$data_return['status'] = false;
					$data_return['errors'] = $data;
				}
			} else {
				$data_return['status'] = false;
				$data_return['errors'] = array('maxkid'=>'Jumlah anak maksimal 3');
			}

			echo json_encode($data_return);
		}else{
			redirect();
		}
	}

	public function remove_child(){
		if(!$this->current_user){
			redirect();
		}

		if($id = $this->input->post('id')){
			// if($this->profile_m->delete_data('users_child', array('id'=>$id))){
				echo json_encode(array('status'=>true));
			// }
		}
	}

	public function update_child(){
		if($this->current_user){
			$validation = array(
				'child_name'	=> array(
					'field'	=> 'child_name',
					'label'	=> 'Nama Anak',
					'rules'	=> 'required|trim|xss_clean|callback__string_spasi'
				),
				'child_dob'	=> array(
					'field'	=> 'child_dob',
					'label'	=> 'Tanggal Lahir Anak',
					'rules'	=> 'required|trim|xss_clean'
				),
				'child_gender'	=> array(
					'field'	=> 'child_gender',
					'label'	=> 'Jenis Kelamin Anak',
					'rules'	=> 'required|trim|xss_clean'
				),
				'image'	=> array(
					'field'	=> 'image',
					'label'	=> 'Image',
					'rules'	=> 'trim|xss_clean'
				),
			);
			$month = array('01'=>'Januari', '02'=>'Februari', '03'=>'Maret', '04'=>'April', '05'=>'Mei', '06'=>'Juni', '07'=>'Juli', '08'=>'Agustus', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Desember');

			$this->form_validation->set_rules($validation);
			if($this->form_validation->run()){
				$id=$this->input->post('id');
				$data = array(
					'name' => $this->input->post('child_name'),
					'dob' => $this->input->post('child_dob'),
					'gender' => $this->input->post('child_gender'),
				);

				//update images profile
	            if($profile = $this->input->post('image')){
	            	$uniq = uniqid();
					$profile = preg_replace('/data:image\/\w+;base64,/', '', $profile);
					$profile = str_replace("[removed]", "", $profile);
					$image = base64_decode($profile);
					if(!is_dir('./uploads/profile/')){
						mkdir('./uploads/profile/', 755, true);
					}
					$file = 'uploads/profile/'.$uniq.'.png';
					$success = file_put_contents('./'.$file, $image);

					if($success){
	                	$data['photo_profile'] = $file;
					}
	            }

				if($this->profile_m->update_data('users_child', $data, array('id'=>$id))){
					$data['id'] = $id;
					$dob = new DateTime($data['dob']);
					$now = new DateTime('today');
					$data['umur'] = $dob->diff($now);
					$dob=explode('-', $data['dob']);
					$data['dob'] = $dob[2].' '.$month[$dob[1]].' '.$dob[0];

					$data_return['status'] = true;
					$data_return['data'] = $data;
				}else{
					$data_return['status'] = false;
					$data_return['message'] = 'Failed to update child';
				}
			}else{
				foreach ($validation as $key => $value) {
					$data[$value['field']] = form_error($value['field']);
				}

				$data_return['status'] = false;
				$data_return['errors'] = $data;
			}

			echo json_encode($data_return);
		}else{
			redirect();
		}
	}

	private function split_fullname($name, &$profile_data){
        $data_name = explode(' ',$name);
        if(count($data_name)> 1){
            $profile_data['first_name'] =$data_name[0];
            unset($data_name[0]);
            $profile_data['last_name'] = implode(' ',$data_name);
        } else {
            $profile_data['first_name'] = $name;
        }
    }

    private function grab_picture_twitter($image_url){

	}

	private function grab_picture_facebook($image_url){

	}

	/**
	 * Callback method used during login
	 *
	 * @param str $email The Email address
	 *
	 * @return bool
	 */
	public function _check_login($email){
		$this->session->unset_userdata('lockout_user');
		$remember = false;
		if ($this->input->post('remember') == 1){
			$remember = true;
		}

		if ($this->ion_auth->login($email, $this->input->post('password'), $remember)){
			return true;
		}
		Events::trigger('login_failed', $email);
		error_log('Login failed for user '.$email);
		if($this->session->userdata('lockout_user')){
			$this->session->set_userdata('message', 'Account anda sudah terkunci, hubungi Call Center kami untuk membuka account anda');
			//$this->form_validation->set_message('_check_login', 'Account anda sudah terkunci, hubungi Call Center kami untuk membuka account anda');
		}else{
			$this->session->set_userdata('message', 'Login Gagal');
			//$this->form_validation->set_message('_check_login', 'Login Gagal');
		}
		return false;
	}

	/**
	 * Username check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $username The username to check.
	 *
	 * @return bool
	 */
	public function _username_check($username){
		if($this->ion_auth->username_check($username)){
			$this->form_validation->set_message('_username_check', lang('user:error_username'));
			return false;
		}

		return true;
	}

	/**
	 * Email check
	 *
	 * @author Ben Edmunds
	 *
	 * @param string $email The email to check.
	 *
	 * @return bool
	 */
	public function _email_check($email){
		if ($this->ion_auth->email_check($email)){
			//$this->form_validation->set_message('_email_check', lang('user:error_email'));
			$this->session->set_userdata('message', lang('user:error_email'));
			return false;
		}else{
			$check_email = $this->_email_block($email);

			if(!$check_email) {
				//$this->form_validation->set_message('_email_check', lang('user:error_email'));
				$this->session->set_userdata('message', lang('user:error_email'));
			}
			return $check_email;
		}

		return true;
	}

	public function _phone_check($phone){
		$params['profiles.phone'] = $phone;
		if($this->current_user) {
			$params['profiles.user_id!='] = $this->current_user->id;
		}

		if($data = $this->profile_m->get_single_user('profiles', $params)){
			//$this->form_validation->set_message('_phone_check', lang('user:error_phone'));
			$this->session->set_userdata('email_reg', $data->email);
			$this->session->set_userdata('message', lang('user:error_phone'));
			return false;
		} else {
			return true;
		}
	}

	public function password_complexcity($pass){
		$this->form_validation->set_message('password_complexcity','Password minimal 8 karakter terdiri minimal 1 huruf, 1 angka dan karakter spesial.');
		preg_match('/[^a-zA-Z0-9]+/ism', $pass,$matches);
		preg_match('/[0-9]+/ism', $pass,$matches2);
		if(isset($matches2[0][0]) && ($matches2[0][0]!='') && !empty($matches[0][0])) {
			//compare with old password
			$user_id = $this->current_user ? $this->current_user->id : 0;
			if($user_id!=0){
				//echo $user_id;
				$user_info = $this->user_m->get(array('id' => $user_id));
				if($this->method == 'settings' && $this->input->post('old_password')){
					if(!$this->_check_old_password($this->input->post('old_password'),$this->current_user->id)){
						return false;
					}
				}

				if($user_info){
					$hashed_new_pass = $this->ion_auth_model->hash_password($pass ,$user_info->salt?$user_info->salt:'');
					$data_tst = $this->history_password_m->get_by(array('password_new'=>$hashed_new_pass,'user_id'=>$user_id));

					if($data_tst || ($hashed_new_pass == $user_info->password)){
						$this->form_validation->set_message('password_complexcity', 'Password tidak boleh sama dengan password lama.');
						return false;
					} else {
						$this->history_password_m->insert(array('user_id'=>$user_id,
																'password_new'=>$hashed_new_pass,
																'password_old'=>$user_info->password,
																'salt'=>$user_info->salt,
																'message'=>'password edited',
																'created_on'=>now()
																));
						return true;
					}
				}
			}

			return true;
		}
		return false;
	}

	public function _email_block($email){
		if($email){
			$ret = true;
			$arr_email = explode('@', $email);
			if(count($arr_email) > 0){
				$arr_email_host =  explode('.', $arr_email[1]);
				if(count($arr_email_host) > 0){
					if($arr_email_host[0]=='gmail'){
						$nama_email = $arr_email[0]; //str_replace('.', '', $arr_email[0]);
						$valid_email = $nama_email.'@'.$arr_email[1];
						$cek_email = $this->db->get_where('users', array('email'=>$email));
							if($cek_email->num_rows() > 0){
								$ret = false;
								return $ret;
							}
						$cek_valid_email = $this->db->get_where('users', array('email'=>$valid_email));
							if($cek_valid_email->num_rows() > 0){
								$ret = false;
								return $ret;
							}
						$ret = $valid_email;
					}
				}
			}


			if($ret){
				//--------- FOR BLOCK AN DOMAIN
				//build list of not allowed providers as lowercase
				$NotAllowedClients = array("guerrillamail", "mailinator","getairmail","fakeinbox","yopmail","10minutemail","temp-mail","mailcatch","mintemail","easytrashmail","ssl.trashmail.net","trashmail","meltmail","tempemail","sharklasers","fakemailgenerator","armyspy","cuvox","dayrep","einrot","jetable","disposableinbox","mytrashmail","tempmailer","inbox","spamgourmet","incognitomail","fakebox","tempsky","maildrop");

				preg_match_all('/\@(.*?)\./', $email, $clientarr);
				$client = strtolower($clientarr[1][0]);
				if($client=='ssl'){
					$cek = explode('@', $email);
					$client = $cek[1];
				}

				if(!in_array($client,$NotAllowedClients)){
				    //DO NOTHING
				    //var_dump($client); die();
				}else{
				    //NOT ALLOWED
				    $ret = false;
				}
				//---------
			}

			return $ret;
		}else{
			$ret = false;
			return $ret;
		}
	}

    public function _check_old_password($pass, $user_id) {
		$user_info = $this->user_m->get(array('id' => $user_id));
		if($user_info){
			$hashed_new_pass = $this->ion_auth_model->hash_password($this->input->post('old_password') ,$user_info->salt ? $user_info->salt : '');
			if($user_info->password !=  $hashed_new_pass){
				$this->form_validation->set_message('_check_old_password', 'Password lama tidak sesuai');
				return false;
			} else {
				return true;
			}
		}
	}

	public function _captcha_check($response){
		return true;

		$private_key = Settings::get('recaptcha_private_key');
		$url = 'https://www.google.com/recaptcha/api/siteverify?secret='.$private_key.'&response='.$response;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,$url);
		$result=curl_exec($ch);
		curl_close($ch);
		$hasil = json_decode($result);
		if (!$hasil->success) {
			$this->form_validation->set_message('_captcha_check', 'Recaptcha tidak valid');
			return false;
		}else{
			return true;
		}
	}

	public function _check_value($value){
		if($value!=1){
			$this->form_validation->set_message('_check_value', 'Anda harus menyetujui %s');
			return false;
		}
		return true;
	}

	public function submit_article_img_dashboard() {
		if (!$this->session->userdata('dashboard-radio-img')) {
			$this->session->set_userdata('dashboard-radio-img',1);
			$radio = 1;
		} else {
			$radio = (int)$this->session->userdata('dashboard-radio-img')+1;
			$this->session->set_userdata('dashboard-radio-img',$radio);
		}

		$json 		= array();
		$html 		= '';
		$option 	= $this->dashboard_upload_option('img');
		$upload_dir	= $option['upload_dir'];

		$upload = new FileUpload('uploadfile');
		$result = $upload->handleUpload(getcwd().$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name	= $upload->getFileName();
			$uri_path 	= base_url($upload_dir.$file_name);

			/* $html .= '<div class="item col-xs-6 col-md-3 dimg" id="dimg-'.$radio.'">'.
				'<div class="fix-ratio" ratio="1:1">'.
					'<img src="'.$uri_path.'" alt="">'.
					'<div class="detail">'.
						'<a href="javascript:void(0);" class="hapus" data-fl="dimg" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
						'<div class="filename">'.$file_name.'</div>'.
						'<input type="hidden" name="filename_img['.$radio.']" value="'.$file_name.'">'.
						'<input type="hidden" name="path_img['.$radio.']" value="'.$upload_dir.'">'.
						'<input type="hidden" name="full_path_img['.$radio.']" value="'.$upload_dir.$file_name.'">'.
					'</div>'.
				'</div>'.
			'</div>'; */

			$html .= 	'<div class="item dimg" id="dimg-'.$radio.'">'.
							'<div class="fix-ratio" ratio="1:1">'.
								'<img src="'.$uri_path.'" alt="">'.
								'<div class="detail">'.
									'<a href="javascript:void(0);" class="hapus hapus-create" data-fl="dimg" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
									'<div class="filename">'.$file_name.'</div>'.
									'<input type="hidden" name="filename_img['.$radio.']" value="'.$file_name.'">'.
									'<input type="hidden" name="path_img['.$radio.']" value="'.$upload_dir.'">'.
									'<input type="hidden" name="full_path_img['.$radio.']" value="'.$upload_dir.$file_name.'">'.
								'</div>'.
							'</div>'.
						'</div>';

			$set_bg = '<option value="'.$radio.'">'.$file_name.'</option>';

			$json = array(
				'success'		=>true,
				'filename'		=>$file_name,
				'path'			=>$upload_dir,
				'full_path'		=>$upload_dir.$file_name,
				'uri_path'		=>$uri_path,
				'html'			=>$html,
				'radio'			=>$radio,
				'set_bg'		=>$set_bg,
			);
		} else {
			$json = array(
				'success'		=>false,
				'message'		=>$upload->getErrorMsg(),
			);
		}

		echo json_encode($json);
	}

	public function submit_article_file_dashboard() {
		if (!$this->session->userdata('dashboard-radio-file')) {
			$this->session->set_userdata('dashboard-radio-file',1);
			$radio = 1;
		} else {
			$radio = (int)$this->session->userdata('dashboard-radio-file')+1;
			$this->session->set_userdata('dashboard-radio-file',$radio);
		}

		$json 		= array();
		$html 		= '';
		$option 	= $this->dashboard_upload_option('file');
		$upload_dir	= $option['upload_dir'];

		$upload = new FileUpload('uploadfile');
		$result = $upload->handleUpload(getcwd().$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name		= $upload->getFileName();
			$partfile_name	= explode('.',$upload->getFileName());
			$uri_path 		= base_url($upload_dir.$file_name);

			/*$html .= '<div class="item col-md-6 dfile" id="dfile-'.$radio.'">'.
				'<a href="javascript:void(0);" class="hapus" data-fl="dfile" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>'.
				'<span class="detail">'.
					'<a href="javascript:void(0);" class="rename"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i><span class="sr-only">Edit</span></a>'.
					'<span class="filename">'.$partfile_name[0].'</span><span class="ext">.'.$partfile_name[1].'</span>'.
				'</span>'.
				'<input type="hidden" name="filename_file['.$radio.']" value="'.$file_name.'">'.
				'<input type="hidden" name="path_file['.$radio.']" value="'.$upload_dir.'">'.
				'<input type="hidden" name="full_path_file['.$radio.']" value="'.$upload_dir.$file_name.'">'.
			'</div>';*/

			/* $html .= '<div class="item col-md-6 dfile" id="dfile-'.$radio.'">'.
				'<a href="javascript:void(0);" class="hapus" data-fl="dfile" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>'.
				'<span class="detail" id="dtail-'.$radio.'">'.
					'<a href="javascript:void(0);" class="rename" data-row="'.$radio.'"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i><span class="sr-only">Edit</span></a>'.
					'<input type="text" class="file-nm nm-file" value="'.$partfile_name[0].'" id="file-nm-'.$radio.'" style="display:none;">'.
					'<span class="filename" id="filename-'.$radio.'">'.$partfile_name[0].'</span>'.
					'<span class="ext" id="ext-'.$radio.'">.'.$partfile_name[1].'</span>'.
				'</span>'.
				'<input type="hidden" name="fname_file['.$radio.']" value="'.$file_name.'" id="fname-'.$radio.'">'.
				'<input type="hidden" name="filename_file['.$radio.']" value="'.$file_name.'">'.
				'<input type="hidden" name="path_file['.$radio.']" value="'.$upload_dir.'">'.
				'<input type="hidden" name="full_path_file['.$radio.']" value="'.$upload_dir.$file_name.'">'.
			'</div>'; */

			$html .= 	'<div class="item col-12 col-lg-6 dfile" id="dfile-'.$radio.'">'.
							'<a href="javascript:void(0);" class="hapus hapus-create" data-fl="dfile" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>'.
							'<span class="detail" id="dtail-'.$radio.'">'.
								'<a href="javascript:void(0);"><i class="fa fa-fw fa-check" aria-hidden="true"></i><span class="sr-only">Edit</span></a>'.
								'<input type="text" class="file-nm nm-file" value="'.$partfile_name[0].'" id="file-nm-'.$radio.'" style="display:none;">'.
								'<span class="filename" id="filename-'.$radio.'">'.$partfile_name[0].'</span>'.
							'</span>'.
							'<span class="ext" id="ext-'.$radio.'">.'.$partfile_name[1].'</span>'.
							'<input type="hidden" name="fname_file['.$radio.']" value="'.$file_name.'" id="fname-'.$radio.'">'.
							'<input type="hidden" name="filename_file['.$radio.']" value="'.$file_name.'">'.
							'<input type="hidden" name="path_file['.$radio.']" value="'.$upload_dir.'">'.
							'<input type="hidden" name="full_path_file['.$radio.']" value="'.$upload_dir.$file_name.'">'.
						'</div>';

			$json = array(
				'success'		=>true,
				'filename'		=>$file_name,
				'path'			=>$upload_dir,
				'full_path'		=>$upload_dir.$file_name,
				'uri_path'		=>$uri_path,
				'html'			=>$html,
				'radio'			=>$radio,
			);
		} else {
			$json = array(
				'success'		=>false,
				'message'		=>$upload->getErrorMsg(),
			);
		}

		echo json_encode($json);
	}

	public function submit_article_video_dashboard() {
		$radio      = 1;
		$json 		= array();
		$html 		= '';
		$option 	= $this->dashboard_upload_option('video');
		$upload_dir	= $option['upload_dir'];

		$upload = new FileUpload('uploadfile');
		$result = $upload->handleUpload(getcwd().$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name		= $upload->getFileName();
			$partfile_name	= explode('.',$upload->getFileName());
			$uri_path 		= base_url($upload_dir.$file_name);

			$html .= 	'<div class="item dvid" id="dvid-'.$radio.'">'.
							'<div class="fix-ratio" ratio="1:1">'.
								'<video width="300px" height="200px" controls><source src="'.$uri_path.'" type="video/mp4"></video>'.
								'<div class="detail">'.
									'<a href="javascript:void(0);" class="hapus hapus-create" data-fl="dvid" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
									'<div class="filename">'.$file_name.'</div>'.
									'<input type="hidden" name="filename_video['.$radio.']" value="'.$file_name.'">'.
									'<input type="hidden" name="path_video['.$radio.']" value="'.$upload_dir.'">'.
									'<input type="hidden" name="full_path_video['.$radio.']" value="'.$upload_dir.$file_name.'">'.
								'</div>'.
							'</div>'.
						'</div>';

			$json = array(
				'success'		=>true,
				'filename'		=>$file_name,
				'path'			=>$upload_dir,
				'full_path'		=>$upload_dir.$file_name,
				'uri_path'		=>$uri_path,
				'html'			=>$html,
				'radio'			=>$radio,
			);
		} else {
			$json = array(
				'success'		=>false,
				'message'		=>$upload->getErrorMsg(),
			);
		}

		echo json_encode($json);
	}

	public function submit_article_img_dashboard_edit() {
		$radio = (int)$this->session->userdata('dashboard-radio-edit')+1;
		$this->session->set_userdata('dashboard-radio-edit',$radio);

		$json 		= array();
		$html 		='';
		$option 	= $this->dashboard_upload_option('img');
		$upload_dir	= $option['upload_dir'];

		$upload = new FileUpload('uploadfile');
		$result = $upload->handleUpload(getcwd().$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name	= $upload->getFileName();
			$uri_path 	= base_url($upload_dir.$file_name);

			/*$html .= '<div class="item col-xs-6 col-md-3 dimg" id="dimg-'.$radio.'">'.
				'<div class="fix-ratio" ratio="1:1">'.
					'<img src="'.$uri_path.'" alt="">'.
					'<div class="detail">'.
						'<a href="javascript:void(0);" class="hapus" data-fl="dimg" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
						'<div class="filename">'.$file_name.'</div>'.
						'<input type="hidden" name="filename_img['.$radio.']" value="'.$file_name.'">'.
						'<input type="hidden" name="path_img['.$radio.']" value="'.$upload_dir.'">'.
						'<input type="hidden" name="full_path_img['.$radio.']" value="'.$upload_dir.$file_name.'">'.
					'</div>'.
				'</div>'.
			'</div>';*/

			/* $html .= '<div class="item col-xs-6 col-md-3 dimg" id="dimg-'.$radio.'">'.
				'<div class="fix-ratio" ratio="1:1">'.
					'<img src="'.$uri_path.'" alt="">'.
					'<div class="detail">'.
						'<a href="javascript:void(0);" class="hapus-edit" data-fl="dimg" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
						'<div class="filename">'.$file_name.'</div>'.
						'<input type="hidden" name="id_img_edit['.$radio.']" value="">'.
						'<input type="hidden" name="filename_img_edit['.$radio.']" value="'.$file_name.'">'.
						'<input type="hidden" name="path_img_edit['.$radio.']" value="'.$upload_dir.'">'.
						'<input type="hidden" name="full_path_img_edit['.$radio.']" value="'.$upload_dir.$file_name.'">'.
					'</div>'.
				'</div>'.
			'</div>'; */

			$html .= 	'<div class="item dimg" id="dimg-'.$radio.'">'.
                            '<div class="fix-ratio" ratio="1:1">'.
                                '<img src="'.$uri_path.'" alt="">'.
                                '<div class="detail">'.
                                    '<a href="javascript:void(0);" class="hapus hapus-edit" data-fl="dimg" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
									'<div class="filename">'.$file_name.'</div>'.
									'<input type="hidden" name="id_img_edit['.$radio.']" value="">'.
                                    '<input type="hidden" name="filename_img_edit['.$radio.']" value="'.$file_name.'">'.
                                    '<input type="hidden" name="path_img_edit['.$radio.']" value="'.$upload_dir.'">'.
                                    '<input type="hidden" name="full_path_img_edit['.$radio.']" value="'.$upload_dir.$file_name.'">'.
                                '</div>'.
                            '</div>'.
                        '</div>';


			$set_bg = '<option value="'.$radio.'">'.$file_name.'</option>';

			$json = array(
				'success'		=>true,
				'filename'		=>$file_name,
				'path'			=>$upload_dir,
				'full_path'		=>$upload_dir.$file_name,
				'uri_path'		=>$uri_path,
				'html'			=>$html,
				'radio'			=>$radio,
				'set_bg'		=>$set_bg,
			);
		} else {
			$json = array(
				'success'		=>false,
				'message'		=>$upload->getErrorMsg(),
			);
		}

		echo json_encode($json);
	}

	public function submit_article_file_dashboard_edit() {
		$radio = (int)$this->session->userdata('dashboard-radio-edit')+1;
		$this->session->set_userdata('dashboard-radio-edit',$radio);

		$json 		= array();
		$html 		='';
		$option 	= $this->dashboard_upload_option('file');
		$upload_dir	= $option['upload_dir'];

		$upload = new FileUpload('uploadfile');
		$result = $upload->handleUpload(getcwd().$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name		= $upload->getFileName();
			$partfile_name	= explode('.',$upload->getFileName());
			$uri_path 		= base_url($upload_dir.$file_name);

			/*$html .= '<div class="item col-md-6 dfile" id="dfile-'.$radio.'">'.
				'<a href="javascript:void(0);" class="hapus" data-fl="dfile" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>'.
				'<span class="detail">'.
					'<a href="javascript:void(0);" class="rename"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i><span class="sr-only">Edit</span></a>'.
					'<span class="filename">'.$partfile_name[0].'</span><span class="ext">.'.$partfile_name[1].'</span>'.
				'</span>'.
				'<input type="hidden" name="filename_file['.$radio.']" value="'.$file_name.'">'.
				'<input type="hidden" name="path_file['.$radio.']" value="'.$upload_dir.'">'.
				'<input type="hidden" name="full_path_file['.$radio.']" value="'.$upload_dir.$file_name.'">'.
			'</div>';*/

			/* $html .= '<div class="item col-md-6 dfile" id="dfile-'.$radio.'">'.
				'<a href="javascript:void(0);" class="hapus-edit" data-fl="dfile" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>'.
				'<span class="detail" id="dtail-'.$radio.'">'.
					'<a href="javascript:void(0);" class="rename-edit" data-row="'.$radio.'"><i class="fa fa-fw fa-pencil" aria-hidden="true"></i><span class="sr-only">Edit</span></a>'.
					'<input type="text" class="file-nm nm-file-edit" value="'.$partfile_name[0].'" id="file-nm-'.$radio.'" style="display:none;">'.
					'<span class="filename" id="filename-edit-'.$radio.'">'.$partfile_name[0].'</span>'.
					'<span class="ext" id="ext-edit-'.$radio.'">.'.$partfile_name[1].'</span>'.
				'</span>'.
				'<input type="hidden" name="id_file_edit['.$radio.']" value="">'.
				'<input type="hidden" name="fname_file_edit['.$radio.']" value="'.$file_name.'" id="fname-'.$radio.'">'.
				'<input type="hidden" name="filename_file_edit['.$radio.']" value="'.$file_name.'">'.
				'<input type="hidden" name="path_file_edit['.$radio.']" value="'.$upload_dir.'">'.
				'<input type="hidden" name="full_path_file_edit['.$radio.']" value="'.$upload_dir.$file_name.'">'.
			'</div>'; */

			$html .= 	'<div class="item col-12 col-lg-6 dfile" id="dfile-'.$radio.'">'.
                            '<a href="javascript:void(0);" class="hapus hapus-edit" data-fl="dfile" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times" aria-hidden="true"><span class="sr-only">Hapus</span></i></a>'.
                            '<span class="detail" id="dtail-'.$radio.'">'.
                                '<a href="javascript:void(0);" class="rename-edit" data-row="'.$radio.'"><i class="fa fa-fw fa-check" aria-hidden="true"></i><span class="sr-only">Edit</span></a>'.
                                '<input type="text" class="file-nm nm-file-edit" value="'.$partfile_name[0].'" id="file-nm-'.$radio.'" style="display:none;">'.
                                '<span class="filename" id="filename-edit-'.$radio.'">'.$partfile_name[0].'</span>'.
                            '</span>'.
							'<span class="ext" id="ext-edit-'.$radio.'">.'.$partfile_name[1].'</span>'.
							'<input type="hidden" name="id_file_edit['.$radio.']" value="">'.
                            '<input type="hidden" name="fname_file_edit['.$radio.']" value="'.$file_name.'" id="fname-'.$radio.'">'.
                            '<input type="hidden" name="filename_file_edit['.$radio.']" value="'.$file_name.'">'.
                            '<input type="hidden" name="path_file_edit['.$radio.']" value="'.$upload_dir.'">'.
                            '<input type="hidden" name="full_path_file_edit['.$radio.']" value="'.$upload_dir.$file_name.'">'.
                        '</div>';


			$json = array(
				'success'		=>true,
				'filename'		=>$file_name,
				'path'			=>$upload_dir,
				'full_path'		=>$upload_dir.$file_name,
				'uri_path'		=>$uri_path,
				'html'			=>$html,
				'radio'			=>$radio,
			);
		} else {
			$json = array(
				'success'		=>false,
				'message'		=>$upload->getErrorMsg(),
			);
		}

		echo json_encode($json);
	}

	public function submit_article_video_dashboard_edit() {
		$radio 		= 1;
		$json 		= array();
		$html 		='';
		$option 	= $this->dashboard_upload_option('video');
		$upload_dir	= $option['upload_dir'];

		$upload = new FileUpload('uploadfile');
		$result = $upload->handleUpload(getcwd().$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name		= $upload->getFileName();
			$partfile_name	= explode('.',$upload->getFileName());
			$uri_path 		= base_url($upload_dir.$file_name);

			$html .= 	'<div class="item dvid" id="dvid-'.$radio.'">'.
                            '<div class="fix-ratio" ratio="1:1">'.
                                '<video width="300px" height="200px" controls><source src="'.$uri_path.'" type="video/mp4"></video>'.
                                '<div class="detail">'.
                                    '<a href="javascript:void(0);" class="hapus hapus-edit" data-fl="dvid" data-row="'.$radio.'" data-dir="'.$upload_dir.'" data-filenm="'.$file_name.'"><i class="fa fa-fw fa-times"></i></a>'.
									'<div class="filename">'.$file_name.'</div>'.
									'<input type="hidden" name="id_video_edit['.$radio.']" value="">'.
                                    '<input type="hidden" name="filename_video_edit['.$radio.']" value="'.$file_name.'">'.
                                    '<input type="hidden" name="path_video_edit['.$radio.']" value="'.$upload_dir.'">'.
                                    '<input type="hidden" name="full_path_video_edit['.$radio.']" value="'.$upload_dir.$file_name.'">'.
                                '</div>'.
                            '</div>'.
                        '</div>';

			$json = array(
				'success'		=>true,
				'filename'		=>$file_name,
				'path'			=>$upload_dir,
				'full_path'		=>$upload_dir.$file_name,
				'uri_path'		=>$uri_path,
				'html'			=>$html,
				'radio'			=>$radio,
			);
		} else {
			$json = array(
				'success'		=>false,
				'message'		=>$upload->getErrorMsg(),
			);
		}

		echo json_encode($json);
	}

	public function delete_article_files_dashboard() {
		$dir 	= $this->input->post('dir',true);
		$row 	= $this->input->post('row',true);
		$filenm = $this->input->post('filenm',true);
		$fled 	= (array_key_exists('fled', $this->input->post())) ? $this->input->post('fled',true) : 0;

		if ($fled!=0) {
	        if($this->article_m->delete_data('article_files', 'imges_id', $fled)) {
	        	if (file_exists(getcwd().$dir.$filenm)) {
			        if(unlink(getcwd().$dir.$filenm)) {
			        	$json = array(
			        		'status' =>true,
			        		'row' =>$row,
			        	);
			        } else {
			        	$json = array(
			        		'status' =>false,
			        		'code'=>'01',
			        	);
			        }
			    } else {
		        	$json = array(
		        		'status' =>false,
		        		'code'=>'02',
		        	);
		        }
	        }
		} else {
			if (file_exists(getcwd().$dir.$filenm)) {
		        if(unlink(getcwd().$dir.$filenm)) {
		        	$json = array(
		        		'status' =>true,
		        		'row' =>$row,
		        	);
		        } else {
		        	$json = array(
		        		'status' =>false,
		        		'code'=>'01',
		        	);
		        }
		    } else {
	        	$json = array(
	        		'status' =>false,
	        		'code'=>'02',
	        	);
	        }
	    }

        echo json_encode($json);
	}

	public function post_article_dashboard() {
		date_default_timezone_set('Asia/Jakarta');

		$rules 	= array_merge($this->forms_validation);
		$this->form_validation->set_rules($rules);

		$created 		= date('Y-m-d H:i:s');
		$created_on 	= strtotime($created);
		$bgcl 			= array('red','yellow');
		$rand_bg 		= array_rand($bgcl, 1);
		$json 			= array();

		$intro 			= nl2br($this->input->post('intro',true));
		$template 		= $this->input->post('template',true);
		$as_background 	= $this->input->post('as_background',true);

		if ($this->form_validation->run()) {
			$extra = array(
				'title'			=> $this->input->post('title',true),
				'slug'			=> $this->slugfy($this->input->post('title',true)),
				'status'        => 'draft',
				'intro'			=> $intro,
				'categories_id'	=> (is_array($this->input->post('category_dashboard',true))) ? implode(',',$this->input->post('category_dashboard',true)) : $this->input->post('category_dashboard',true),
				'kidsage_id'	=> (is_array($this->input->post('kidsage_dashboard',true))) ? implode(',',$this->input->post('kidsage_dashboard',true)) : $this->input->post('kidsage_dashboard',true),
				'authors_id'	=> $this->current_user->id,
				'description'	=> nl2br($this->input->post('description',true)),
				'meta_keyword'	=> $this->input->post('meta_keyword'),
				'meta_desc'		=> $this->input->post('meta_description'),
				//'meta_desc'		=> $intro,
				'show_comments'	=> 'yes',
				'bg_color'		=> $bgcl[$rand_bg],
				'template'		=> 'no-image',
				'content_format'=> $template,
				'click'			=> 0,
				'likes'			=> 0,
				'created'		=> $created,
				'created_on'	=> $created_on,
			);

			$filename_img 		= $this->input->post('filename_img',true);
			$path_img 			= $this->input->post('path_img',true);
			$full_path_img 		= $this->input->post('full_path_img',true);

			$fname_file			= $this->input->post('fname_file',true);
			$filename_file 		= $this->input->post('filename_file',true);
			$path_file 			= $this->input->post('path_file',true);
			$full_path_file 	= $this->input->post('full_path_file',true);

			$filename_video 	= $this->input->post('filename_video',true);
			$path_video 		= $this->input->post('path_video',true);
			$full_path_video 	= $this->input->post('full_path_video',true);
			$inputPost 			= $this->input->post();

			if ($id = $this->article_m->insert_data('article', $extra)) {
				if ($template=='banner' || $template=='carousel') {
					if (!empty($filename_img)) {
						for ($i=0; $i <count($filename_img) ; $i++) {
							if(!empty($filename_img[$i]['value'])) {
								$ar_files = array(
									'article_id'		=>$id,
									'fname'				=>'',
									'filename'			=>$filename_img[$i]['value'],
									'path'				=>$path_img[$i]['value'],
									'full_path'			=>$full_path_img[$i]['value'],
									'as_background'		=>($filename_img[$i]['name']=='filename_img['.$as_background.']') ? 1 : 0,
									'ftype'				=>'img',
								);
								$this->article_m->insert_data('article_files', $ar_files);
							}
						}
					}

					if(!empty($filename_file)) {
						for ($i=0; $i <count($filename_file) ; $i++) {
							if(!empty($filename_file[$i]['value'])) {
								$ar_files = array(
									'article_id'		=>$id,
									'fname'				=>$fname_file[$i]['value'],
									'filename'			=>$filename_file[$i]['value'],
									'path'				=>$path_file[$i]['value'],
									'full_path'			=>$full_path_file[$i]['value'],
									'as_background'		=>0,
									'ftype'				=>'file',
								);
								$this->article_m->insert_data('article_files', $ar_files);
							}
						}
					}
				} elseif ($template=='youtube') {
					if (array_key_exists('youtube_url', $inputPost)) {
						if (!empty($inputPost['youtube_url'])) {
							$ar_files = array(
								'article_id'		=>$id,
								'fname'				=>'',
								'filename'			=>$this->input->post('youtube_url'),
								'path'				=>'',
								'full_path'			=>$this->input->post('youtube_url'),
								'as_background'		=>0,
								'ftype'				=>'youtube',
							);
							$this->article_m->insert_data('article_files', $ar_files);
						}
					}
				} elseif ($template=='video') {
					if (!empty($filename_video)) {
						for ($i=0; $i <count($filename_video) ; $i++) {
							if(!empty($filename_video[$i]['value'])) {
								$ar_files = array(
									'article_id'		=>$id,
									'fname'				=>'',
									'filename'			=>$filename_video[$i]['value'],
									'path'				=>$path_video[$i]['value'],
									'full_path'			=>$full_path_video[$i]['value'],
									'as_background'		=>0,
									'ftype'				=>'video',
								);
								$this->article_m->insert_data('article_files', $ar_files);
							}
						}
					}
				}

				$users_article = $this->article_m->get_by_article(array('authors_id'=>$this->current_user->id));

				$json = array(
					'status'		=>true,
					'ct_ar'			=>count($users_article),
					'msg'			=>sprintf(lang('general:add_success'), $this->input->post('title')),
					'ttl'			=>$this->input->post('title'),
				);
			} else {
				$json = array(
					'status'		=>false,
					'msg'			=>lang('general:post_add_error'),
				);
			}
		} else {
			$json =  array(
				'status' 	=>false,
				'msg'		=>form_error('title'),
				'ttl'		=>$this->input->post('title'),
			);
		}

		echo json_encode($json);
	}

	public function post_article_dashboard_edit() {
		$ar_id 			= $this->input->post('ar_id',true);
		$article_validation = array_merge($this->forms_validation, array(
			'title'=> array(
	    		'field'	=> 'title_edit',
	    		'label'	=> 'lang:articles:label_title',
	    		'rules'	=> 'trim|required|xss_clean|callback__check_title['.$ar_id.']'
	    	),
		));
		$rules 	= array_merge($this->forms_validation, $article_validation);
		$this->form_validation->set_rules($rules);

		$json 			= array();

		$intro 			= nl2br($this->input->post('intro_edit',true));
		$template 		= $this->input->post('template_edit',true);
		$as_background 	= $this->input->post('as_background_edit',true);

		if ($this->form_validation->run()) {
			$extra = array(
				'title'			=> $this->input->post('title_edit',true),
				'status'        => 'draft',
				'intro'			=> $intro,
				'categories_id'	=> (is_array($this->input->post('category_dashboard_edit',true))) ? implode(',',$this->input->post('category_dashboard_edit',true)) : $this->input->post('category_dashboard_edit',true),
				'kidsage_id'	=> (is_array($this->input->post('kidsage_dashboard_edit',true))) ? implode(',',$this->input->post('kidsage_dashboard_edit',true)) : $this->input->post('kidsage_dashboard_edit',true),
				'description'	=> nl2br($this->input->post('description_edit',true)),
				'meta_keyword'	=> $this->input->post('meta_keyword_edit'),
				'meta_desc'		=> $this->input->post('meta_description_edit'),
				//'meta_desc'		=> $intro,
				'content_format'	=> $template,
			);

			$id_img 			= $this->input->post('id_img_edit',true);
			$filename_img 		= $this->input->post('filename_img_edit',true);
			$path_img 			= $this->input->post('path_img_edit',true);
			$full_path_img 		= $this->input->post('full_path_img_edit',true);

			$id_file 			= $this->input->post('id_file_edit',true);
			$fname_file			= $this->input->post('fname_file_edit',true);
			$filename_file 		= $this->input->post('filename_file_edit',true);
			$path_file 			= $this->input->post('path_file_edit',true);
			$full_path_file 	= $this->input->post('full_path_file_edit',true);

			$id_video 			= $this->input->post('id_video_edit', true);
            $filename_video 	= $this->input->post('filename_video_edit', true);
            $path_video 		= $this->input->post('path_video_edit', true);
            $full_path_video 	= $this->input->post('full_path_video_edit', true);

			if ($this->article_m->update_data('article', $extra, 'article_id', $ar_id)) {
				if ($template=='banner' || $template=='carousel') {
					if (!empty($filename_img)) {
						for ($i=0; $i <count($filename_img) ; $i++) {
							if (empty($id_img[$i]['value'])) {
								$ar_files = array(
									'article_id'		=>$ar_id,
									'fname'				=>'',
									'filename'			=>$filename_img[$i]['value'],
									'path'				=>$path_img[$i]['value'],
									'full_path'			=>$full_path_img[$i]['value'],
									'as_background'		=>($filename_img[$i]['name']=='filename_img_edit['.$as_background.']') ? 1 : 0,
									'ftype'				=>'img',
								);
								$this->article_m->insert_data('article_files', $ar_files);
							} else {
								$ar_files = array(
									'filename'			=>$filename_img[$i]['value'],
									'path'				=>$path_img[$i]['value'],
									'full_path'			=>$full_path_img[$i]['value'],
									'as_background'		=>($filename_img[$i]['name']=='filename_img_edit['.$as_background.']') ? 1 : 0,
								);
								$this->article_m->update_data('article_files', $ar_files, 'imges_id', $id_img[$i]['value']);
							}
						}
					}

					if(!empty($filename_file)) {
						for ($i=0; $i <count($filename_file) ; $i++) {
							if (empty($id_file[$i]['value'])) {
    							$ar_files = array(
									'article_id'		=>$ar_id,
									'fname'				=>$fname_file[$i]['value'],
									'filename'			=>$filename_file[$i]['value'],
									'path'				=>$path_file[$i]['value'],
									'full_path'			=>$full_path_file[$i]['value'],
									'as_background'		=>0,
									'ftype'				=>'file',
								);
    							$this->article_m->insert_data('article_files', $ar_files);
							} else {
								$ar_files = array(
									'fname'				=>$fname_file[$i]['value'],
									'filename'			=>$filename_file[$i]['value'],
									'path'				=>$path_file[$i]['value'],
									'full_path'			=>$full_path_file[$i]['value'],
									'as_background'		=>0,
									'ftype'				=>'file',
								);
    							$this->article_m->update_data('article_files', $ar_files, 'imges_id', $id_file[$i]['value']);
							}
						}
					}
				} elseif ($template=='youtube') {
					if (!empty($inputPost['youtube_url_edit'])){
						if (empty($inputPost['youtube_url_edit_id'])) {
							$ar_files = array(
								'article_id'		=>$ar_id,
								'fname'				=>'',
								'filename'			=>$this->input->post('youtube_url_edit'),
								'path'				=>'',
								'full_path'			=>$this->input->post('youtube_url_edit'),
								'as_background'		=>0,
								'ftype'				=>'youtube',
							);
							$this->article_m->insert_data('article_files', $ar_files);
						} else {
							$ar_files = array(
                                'article_id'		=>$ar_id,
                                'fname'				=>'',
                                'filename'			=>$this->input->post('youtube_url_edit'),
                                'path'				=>'',
                                'full_path'			=>$this->input->post('youtube_url_edit'),
                                'as_background'		=>0,
                                'ftype'				=>'youtube',
                            );
                            $this->article_m->update_data('article_files', $ar_files, 'imges_id', $this->input->post('youtube_url_edit_id'));
						}
					}
				} elseif ($template=='video') {
					if (!empty($filename_video)) {
						for ($i=0; $i <count($filename_video) ; $i++) {
							if (empty($id_video[$i]['value'])) {
								$ar_files = array(
									'article_id'		=>$ar_id,
									'fname'				=>'',
									'filename'			=>$filename_video[$i]['value'],
									'path'				=>$path_video[$i]['value'],
									'full_path'			=>$full_path_video[$i]['value'],
									'as_background'		=>0,
									'ftype'				=>'video',
								);
								$this->article_m->insert_data('article_files', $ar_files);
							} else {
								$ar_files = array(
									'filename'			=>$filename_video[$i]['value'],
									'path'				=>$path_video[$i]['value'],
									'full_path'			=>$full_path_video[$i]['value'],
									'as_background'		=>0,
								);
								$this->article_m->update_data('article_files', $ar_files, 'imges_id', $id_video[$i]['value']);
							}
						}
					}
				}
				$users_article = $this->article_m->get_by_article(array('authors_id'=>$this->current_user->id));

				$json = array(
					'status'		=>true,
					'ct_ar'			=>count($users_article),
					'msg'			=>sprintf(lang('general:add_success'), $this->input->post('title_edit')),
					'ttl'			=>$this->input->post('title_edit'),
				);
			} else {
				$json = array(
					'status'		=>false,
					'msg'			=>lang('general:post_add_error'),
				);
			}
		} else {
			$json =  array(
				'status' 	=>false,
				'msg'		=>form_error('title'),
				'ttl'		=>$this->input->post('title'),
			);
		}

		echo json_encode($json);
	}

	public function _check_title($title, $id=0) {
		$this->form_validation->set_message('_check_title', sprintf(lang('articles:already_exist_error'), lang('global:title')));
		return $this->article_m->check_exists('article', array('title'=>$title, 'article_id'=>$id));
	}

	private function dashboard_upload_option($type='img') {
		if (!$this->session->userdata('dashboard-dir')) {
			$dir = $this->random_string->generate();
			$this->session->set_userdata('dashboard-dir',$dir);
		} else {
			$dir = $this->session->userdata('dashboard-dir');
		}

		$upload_dir 			= '/uploads/default/files/article_files/'.$dir.'/';

		if(!is_dir(getcwd().$upload_dir)) {
			mkdir(getcwd().$upload_dir,0775,true);
		}

		$option = array(
			'dir'				=> $dir,
			'upload_dir'		=> $upload_dir,
		);

		if ($type=='file') {
			$option['valid_extensions'] = array('pdf');
		} elseif ($type=='video') {
			$option['valid_extensions'] = array('mp4');
		} else {
			$option['valid_extensions'] = array('png', 'jpeg', 'jpg');
		}

		return $option;
	}

	private function slugfy($str) {
		$str = preg_replace('~[^\pL\d]+~u', '-', $str);
		$str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);
		$str = preg_replace('~[^-\w]+~', '', $str);
		$str = trim($str, '-');
		$str = preg_replace('~-+~', '-', $str);
		$str = strtolower($str);

		if (empty($str)) {
			return 'n-a';
		}

		return $str;
    }

    private function indo_date($format, $date="now", $lang="id"){
		$en=array("Sun","Mon","Tue","Wed","Thu","Fri","Sat","Jan","Feb",
		"Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");

		$id=array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu",
		"Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September",
		"Oktober","Nopember","Desember");

		return str_replace($en,$$lang,date($format,strtotime($date)));
	}

	public function exprt_usr()	{
		$doctor = array();
		$docs = $this->db->get('default_ae_doctors')->result();
		foreach($docs as $doc) {
			$doctor[$doc->doctor_slug] = $doc->doctor_fullname;
		}

		$this->template
				 ->title('Export User')
				 ->set('doctor', $doctor)
				 ->set_metadata('robots', 'noindex, nofollow')
				 ->build('export-user');
	}

	function export_data($date_from=0, $date_end=0){
		$keperluan = $this->input->get('keperluan');
		$this->load->library('excel');
		$nama_file = 'data_export';

		$params = array();
		if($date_from!=0){
			$params['date_start'] = $date_from.' 00:00:00';
		}

		if($date_end!=0){
			$params['date_end'] = $date_end.' 23:59:59';
		}
		switch ($keperluan) {
			case 'one_year_child':
				$data = $this->profile_m->get_report_oneyearchild($params);

       			$objPHPExcel = new PHPExcel();
					$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'NAMA ORANG TUA')
					->setCellValue('B1', 'NAMA ANAK')
					//->setCellValue('B1', 'JENIS KELAMIN')
					->setCellValue('C1', 'TANGGAL LAHIR')
					//->setCellValue('D1', 'UMUR')
					->setCellValue('D1', 'EMAIL')
					->setCellValue('E1', 'NO TELEPON')
					->setCellValue('F1', 'SMARTNESS');

				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(10)
				->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

				$no=1;
				$count = 2;
				foreach($data as $key=>$dt){
					$kelamin 	= $dt->gender == 2 ? 'Perempuan' : 'Laki-laki';
					$from = new DateTime($dt->dob);
					$to = new DateTime('today');
					$diff = $from->diff($to);
					$umur = $diff->y.' Tahun'.($diff->m ? ' '.$diff->m.' Bulan' : '');

					$smartness = ($dt->top_smartness == '' ? '-' : explode(',', $dt->top_smartness));

			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$count, $dt->parent_name, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$count, $dt->name, PHPExcel_Cell_DataType::TYPE_STRING);
			  	  	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$count, $kelamin, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$count, $dt->dob, PHPExcel_Cell_DataType::TYPE_STRING);
				  	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$count, $umur, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$count, $dt->email, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$count, $dt->phone, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$count, $smartness!='-' ? $smartness[0].', '.$smartness[1].', '.$smartness[2] : '-', PHPExcel_Cell_DataType::TYPE_STRING);
					$count++;
				}
				foreach(range('A','F') as $columnID) {
		            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		        }
		        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FB1FF'))));
		        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        		$filename = $nama_file.'_'.$date_from.'_'.$date_end.'.csv'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
				break;

			case 'one_year_child_noquiz':
				$data = $this->profile_m->get_report_oneyearchild_noquiz($params);

       			$objPHPExcel = new PHPExcel();
					$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'NAMA ORANG TUA')
					->setCellValue('B1', 'NAMA ANAK')
					//->setCellValue('B1', 'JENIS KELAMIN')
					->setCellValue('C1', 'TANGGAL LAHIR')
					//->setCellValue('D1', 'UMUR')
					->setCellValue('D1', 'EMAIL')
					->setCellValue('E1', 'NO TELEPON')
					->setCellValue('F1', 'SMARTNESS');

				$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(10)
				->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

				$no=1;
				$count = 2;
				foreach($data as $key=>$dt) {
					$kelamin 	= $dt->gender == 2 ? 'Perempuan' : 'Laki-laki';
					$from = new DateTime($dt->dob);
					$to = new DateTime('today');
					$diff = $from->diff($to);
					$umur = $diff->y.' Tahun'.($diff->m ? ' '.$diff->m.' Bulan' : '');

					$smartness = (!isset($dt->top_smartness)) ? '-' : ($dt->top_smartness == '' ? '-' : explode(',', $dt->top_smartness));

			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$count, $dt->parent_name, PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$count, $dt->name, PHPExcel_Cell_DataType::TYPE_STRING);
			  	  	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$count, $kelamin, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$count, $dt->dob, PHPExcel_Cell_DataType::TYPE_STRING);
				  	//$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$count, $umur, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$count, $dt->email, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$count, $dt->phone, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$count, $smartness!='-' ? $smartness[0].', '.$smartness[1].', '.$smartness[2] : '-', PHPExcel_Cell_DataType::TYPE_STRING);
					$count++;
				}
				foreach(range('A','F') as $columnID) {
		            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		        }
		        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FB1FF'))));
		        $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        		$filename = $nama_file.'_'.$date_from.'_'.$date_end.'.csv'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
				break;
			case 'all_user':
				$data = $this->profile_m->get_report_user($params);

				$objPHPExcel = new PHPExcel();
					$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'NAMA LENGKAP')
					->setCellValue('B1', 'EMAIL')
					->setCellValue('C1', 'NO HANDPHONE')
					->setCellValue('D1', 'JENIS KELAMIN')
					->setCellValue('E1', 'PROFESI')
					->setCellValue('F1', 'ACTIVE')
					->setCellValue('G1', 'BIO')
					->setCellValue('H1', 'TANGGAL DAFTAR')
					->setCellValue('I1', 'LOGIN TERAKHIR')
					->setCellValue('J1', 'NAMA ANAK')
					->setCellValue('K1', 'TGL LAHIR ANAK');

				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(10)
				->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);

				$no = 2;
				$count = 2;
				foreach($data as $key=>$dt){
					$active = $dt->active == 1 ? 'Ya' : 'Tidak';
					$kelamin = $dt->gender == 'f' ? 'Perempuan' : 'Laki-laki';

					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$no, $dt->display_name, PHPExcel_Cell_DataType::TYPE_STRING);
			  	  	$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$no, $dt->email, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$no, $dt->phone, PHPExcel_Cell_DataType::TYPE_STRING);
				  	$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$no, $kelamin, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$no, $dt->profesi, PHPExcel_Cell_DataType::TYPE_STRING);
			    	$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$no, $active, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$no, $dt->bio, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$no, date('d M Y H:i:s', $dt->created_on), PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$no, date('d M Y H:i:s', $dt->last_login), PHPExcel_Cell_DataType::TYPE_STRING);
					
					$children = $this->profile_m->get_child(array('user_id' => $dt->id))->result();
					if(!empty($children)) {
						foreach ($children as $key => $child) {
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$no, $child->name, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$no, $child->dob, PHPExcel_Cell_DataType::TYPE_STRING);
							// $count++;
							$no++;
						}
					}
				}

				foreach(range('A','K') as $columnID) {
		            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		        }

		        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FB1FF'))));
		        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        		$filename = $nama_file.'_'.$date_from.'_'.$date_end.'.csv'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
				break;

			case 'active_user':
				if($keperluan=='active_user'){
					$params['status'] = 1;
				}

				$data = $this->profile_m->get_report_user($params);

				$objPHPExcel = new PHPExcel();
					$objPHPExcel->getActiveSheet()
					->setCellValue('A1', 'NAMA LENGKAP')
					->setCellValue('B1', 'EMAIL')
					->setCellValue('C1', 'NO HANDPHONE')
					->setCellValue('D1', 'JENIS KELAMIN')
					->setCellValue('E1', 'PROFESI')
					->setCellValue('F1', 'ACTIVE')
					->setCellValue('G1', 'BIO')
					->setCellValue('H1', 'TANGGAL DAFTAR')
					->setCellValue('I1', 'LOGIN TERAKHIR')
					->setCellValue('J1', 'NAMA ANAK')
					->setCellValue('K1', 'TGL LAHIR ANAK');

				$objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getFont()->setSize(10)
				->getActiveSheet()->getStyle('A1:K1')->getFont()->setBold(true);

				$no = 1;
				$count = 2;
				foreach($data as $key=>$dt){
					$active = $dt->active == 1 ? 'Ya' : 'Tidak';
					$kelamin = $dt->gender == 'f' ? 'Perempuan' : 'Laki-laki';
					$children = $this->profile_m->get_child(array('user_id' => $dt->id))->result();

					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$count, $dt->display_name, PHPExcel_Cell_DataType::TYPE_STRING);
			  	  	$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$count, $dt->email, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$count, $dt->phone, PHPExcel_Cell_DataType::TYPE_STRING);
				  	$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$count, $kelamin, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$count, $dt->profesi, PHPExcel_Cell_DataType::TYPE_STRING);
			    	$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$count, $active, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$count, $dt->bio, PHPExcel_Cell_DataType::TYPE_STRING);
			      	$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$count, date('d M Y H:i:s', $dt->created_on), PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$count, date('d M Y H:i:s', $dt->last_login), PHPExcel_Cell_DataType::TYPE_STRING);

					if(!empty($children)) {
						foreach ($children as $key => $child) {
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$count, $child->name, PHPExcel_Cell_DataType::TYPE_STRING);
							$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$count, $child->dob, PHPExcel_Cell_DataType::TYPE_STRING);
							$count++;
						}
					}
				}

				foreach(range('A','K') as $columnID) {
		            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		        }

		        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FB1FF'))));
		        $objPHPExcel->getActiveSheet()->getStyle('A1:K1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        		$filename = $nama_file.'_'.$date_from.'_'.$date_end.'.csv'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
				break;

			case 'fa':
			case 'fa_pending':
				if($keperluan=='fa_pending'){
					$params['status'] = 'not-completed';
					$data = $this->profile_m->get_report($params);
				}else{
					$params['status'] = 'completed';
					$data = $this->profile_m->get_complete_report($params);
				}

				//$data = $this->profile_m->get_report($params);

				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getActiveSheet()
							->setCellValue('A1', 'NAMA LENGKAP')
							->setCellValue('B1', 'EMAIL')
							->setCellValue('C1', 'NO HANDPHONE')
							->setCellValue('D1', 'JENIS KELAMIN')
							->setCellValue('E1', 'PROFESI')
							->setCellValue('F1', 'BIO')
							->setCellValue('G1', 'TANGGAL DAFTAR')
							->setCellValue('H1', 'LOGIN TERAKHIR')
							->setCellValue('I1', 'TGL DOWNLOAD SMART ACTIVITIES')
							->setCellValue('J1', 'NAMA ANAK')
							->setCellValue('K1', 'TGL LAHIR ANAK')
							->setCellValue('L1', 'JENIS KELAMIN')
							->setCellValue('M1', 'TGL IKUT QUIZ')
							->setCellValue('N1', '3 KEPINTARAN ANAK')
							->setCellValue('O1', 'STATUS QUIZ');

				$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getFont()->setSize(10)
							->getActiveSheet()->getStyle('A1:O1')->getFont()->setBold(true);

				$no=1;
				$count = 2;
				foreach($data as $key=>$dt){
					$smartness = explode(',', $dt['top_smartness']);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$count, $dt['display_name'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('B'.$count, $dt['email'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('C'.$count, $dt['phone'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('D'.$count, ($dt['gender']=='m') ? 'Laki-laki' : 'Perempuan', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('E'.$count, $dt['profesi'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('F'.$count, $dt['bio'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('G'.$count, date('d M Y H:i:s', $dt['created_on']), PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('H'.$count, date('d M Y H:i:s', $dt['last_login']), PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('I'.$count, $dt['download_twentyone'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('J'.$count, $dt['child_name'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('K'.$count, $dt['child_dob'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('L'.$count, $dt['child_gender']==1 ? 'Laki-laki' : 'Perempuan', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('M'.$count, $dt['quiz_date'], PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('N'.$count, $dt['top_smartness']!='-' ? $smartness[0].', '.$smartness[1].', '.$smartness[2] : '-', PHPExcel_Cell_DataType::TYPE_STRING);
					$objPHPExcel->getActiveSheet()->setCellValueExplicit('O'.$count, $dt['quiz_status'], PHPExcel_Cell_DataType::TYPE_STRING);

					$count++;
				}

				foreach(range('A','O') as $columnID) {
		            $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
		        }

		        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray(array('fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => '8FB1FF'))));
		        $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        		$filename = $nama_file.'_'.$date_from.'_'.$date_end.'.csv'; //save our workbook as this file name
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
				$objWriter->save('php://output');
				exit;
				break;

			default:
				redirect('3x5-u5r');
				break;
		}
	}

	function export_data_json($date_from=0, $date_end=0){
		$keperluan = $this->input->get('keperluan');
		$this->load->library('excel');
		$nama_file = 'data_export';

		$params = array();
		if($date_from!=0){
			$params['date_start'] = $date_from.' 00:00:00';
		}

		if($date_end!=0){
			$params['date_end'] = $date_end.' 23:59:59';
		}

		switch ($keperluan) {
			case 'one_year_child':
				$data = $this->profile_m->get_report_oneyearchild();

       			$new_path = '/uploads/default/files/usr_export/';
				if(!is_dir(getcwd().$new_path)) {
					mkdir(getcwd().$new_path,0775,true);
				}

				$fp = fopen(getcwd().$new_path.'results.json', 'w');
				fwrite($fp, json_encode($data));
				fclose($fp);

				$data_dl = file_get_contents(getcwd().$new_path.'results.json');
				force_download('results.json', $data_dl);
				break;

			case 'all_user':
			case 'active_user':
				if($keperluan=='fa_pending'){
					$params['status'] = 'not-completed';
					$data = $this->profile_m->get_report($params);
				}else{
					$params['status'] = 'completed';
					$data = $this->profile_m->get_complete_report($params);
				}

				//$data = $this->profile_m->get_report_user($params);
				$new_path = '/uploads/default/files/usr_export/';
				if(!is_dir(getcwd().$new_path)) {
					mkdir(getcwd().$new_path,0775,true);
				}

				$fp = fopen(getcwd().$new_path.'results.json', 'w');
				fwrite($fp, json_encode($data));
				fclose($fp);

				$data_dl = file_get_contents(getcwd().$new_path.'results.json');
				force_download('results.json', $data_dl);
				break;

			case 'fa':
			case 'fa_pending':
				if($keperluan=='fa_pending'){
					$params['status'] = 'not-completed';
				}else{
					$params['status'] = 'completed';
				}

				$data = $this->profile_m->get_report($params);

				$new_path = '/uploads/default/files/usr_export/';
				if(!is_dir(getcwd().$new_path)) {
					mkdir(getcwd().$new_path,0775,true);
				}

				$fp = fopen(getcwd().$new_path.'results.json', 'w');
				fwrite($fp, json_encode($data));
				fclose($fp);

				$data_dl = file_get_contents(getcwd().$new_path.'results.json');
				force_download('results.json', $data_dl);
				break;

			default:
				redirect('3x5-u5r');
				break;
		}

		$keperluan = $this->input->get('keperluan');
		$this->load->library('excel');
		$nama_file = 'data_export';
	}

	public function get_session_time_left(){
		if ($this->input->is_ajax_request()){
			$result['status'] = 'false';
			if($this->current_user && $this->current_user->id){
				$sess_time_left    	= 0;
			    $sess_exp_time     	= $this->config->config["sess_expiration"];
			    $curl_time        	= time();
			    $last_activity 		= $this->session->userdata('last_activity');
			    $sess_time_left 	= ($sess_exp_time - ($curl_time - $last_activity));
			    $result['status']	= 'true';
			    $result['tmlft'] 	= $sess_time_left;
			}
		    echo json_encode($result);
		}
	}

	public function _string_angka_spasi($string){
		if(preg_match('/[^a-zA-Z0-9\s\.\,\@\-\(\)]+/ism', $string)){
			$this->form_validation->set_message('_string_angka_spasi', 'Bagian %s invalid string');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function _string_spasi($string){
		if(preg_match('/[^a-zA-Z\s]+/ism', $string)){
			$this->form_validation->set_message('_string_spasi', 'Bagian %s hanya string dan spasi');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function _string_email_tambahan($string){
		if(preg_match('/[^a-zA-Z0-9_\.@]+/ism', $string)){
			$this->form_validation->set_message('_string_email_tambahan', 'Bagian %s invalid string');
			return FALSE;
		}else{
			return TRUE;
		}
	}

	public function export_ae(){
		$this->load->model('ask_expert/ask_expert_m');
		$nama_file = "data_export_smart_consultation";
		$base_where = array();

		if($this->input->post('f_from') != ''){
			$base_where['from'] = $this->input->post('f_from');
		}

		if($this->input->post('f_to') != ''){
			$base_where['to'] = $this->input->post('f_to');
		}

		if($this->input->post('f_doctor') != ''){
			$base_where['doctor'] = $this->input->post('f_doctor');
		}

		if($this->input->post('f_status') != ''){
			$base_where['publish'] = $this->input->post('f_status');
		}

		if($this->input->post('f_keywords')!=''){
			$base_where['keyword'] = $this->input->post('f_keywords');
		}

		$data = $this->ask_expert_m->get_data($base_where);
		if($data){
			$this->load->library('excel');
        	$nama_file = 'data_export';

        	$this->excel->getActiveSheet()->setCellValue('A1', 'NAMA USER');
	    	$this->excel->getActiveSheet()->setCellValue('B1', 'SUBJEK');
	    	$this->excel->getActiveSheet()->setCellValue('C1', 'PERTANYAAN');
	    	$this->excel->getActiveSheet()->setCellValue('D1', 'DOKTER');
	    	$this->excel->getActiveSheet()->setCellValue('E1', 'TANGGAL TANYA');
	    	$this->excel->getActiveSheet()->setCellValue('F1', 'STATUS');

	    	$this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setSize(13);
	    	$this->excel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);

	    	$count=2;
			foreach($data as $value){
		        $this->excel->getActiveSheet()->setCellValueExplicit('A'.$count, $value->user_display_name, PHPExcel_Cell_DataType::TYPE_STRING);
		      	$this->excel->getActiveSheet()->setCellValueExplicit('B'.$count, $value->ask_subject, PHPExcel_Cell_DataType::TYPE_STRING);
		        $this->excel->getActiveSheet()->setCellValueExplicit('C'.$count, $value->ask_value, PHPExcel_Cell_DataType::TYPE_STRING);
		        $this->excel->getActiveSheet()->setCellValueExplicit('D'.$count, $value->doctor_fullname, PHPExcel_Cell_DataType::TYPE_STRING);
		        $this->excel->getActiveSheet()->setCellValueExplicit('E'.$count, $value->ask_time, PHPExcel_Cell_DataType::TYPE_STRING);
		        $this->excel->getActiveSheet()->setCellValueExplicit('F'.$count, lang('ask:label_'.$value->answer_status), PHPExcel_Cell_DataType::TYPE_STRING);

	        	$count++;
	        }

	        foreach(range('A','F') as $columnID) {
	            $this->excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
	        }

	        header('Content-Type: application/vnd.ms-excel'); //mime type
	        header('Content-Disposition: attachment;filename="'.$nama_file.'.xls"'); //tell browser what's the file name
	        header('Cache-Control: max-age=0');
	        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	        $objWriter->save('php://output');
	        exit;
		}else{
			redirect('3x5-u5r');
		}
	}

	public function check_user_lock()
	{
		$locked_user = $this->db->query("select * from default_users where time_lock is  NOT NULL")->result_array();

		if(!empty($locked_user) and is_array($locked_user)) {
			foreach ($locked_user as $key => $locked) {
				$start = strtotime($locked['time_lock']);
				$end = strtotime(date('Y-m-d H:i:s'));
				$time = (int)floor(abs($end - $start) / 60);

				if($time>=30) {
					$data = array(
						'active'	=> 1,
						'time_lock'	=> null
					);

					$profiles = array(
						'password_temp'	=> 0
					);

					$this->user_m->update_data('users', $data, 'id', $locked['id']);
					$this->user_m->update_data('profiles', $profiles, 'user_id', $locked['id']);
				}
			}
		}
	}

	public function backdoor_addadm()
	{

		$email = strtolower('admin@maxsolution.net.id');
		if (!$this->ion_auth->email_check($email)) {
			$password = '43lW9rj2!';
			$username = 'adminmaxsolution';
			$group_id = 1;
			$activate = 1;

			$assignments = $this->streams->streams->get_assignments('profiles', 'users');
			$profile_data = array();

			foreach ($assignments as $assign) {
				$profile_data[$assign->field_slug] = '';
			}

			$new_profile = array(
				'display_name' => 'Admin Maxsolution',
				'first_name' => 'Admin',
				'last_name' => 'Maxsolution',
				'dob' => date('Y-m-d'),
			);
			$profile_data = array_merge($profile_data, $new_profile);
			$group = $this->group_m->get($group_id);

			if ($user_id = $this->ion_auth->register($username, $password, $email, $group_id, $profile_data, $group->name)) {
				echo $user_id;
				//save password history
				$user_info = $this->user_m->get(array('id' => $user_id));
				$hashed_new_pass = $this->ion_auth_model->hash_password($password ,$user_info->salt?$user_info->salt:'');
				$this->history_password_m->insert(array('user_id'=>$user_id,
					'password_new'=>$hashed_new_pass,
					'password_old'=>$hashed_new_pass,
					'salt'=>$user_info->salt,
					'message'=>'password created',
					'created_on'=>now()
				));
			}
		}
		$check_adm = !$this->ion_auth->email_check($email);
		echo $check_adm;
	}

	public function submit_user_profilepic() {
		$json = array('status'=>false);

		if($this->current_user) {
			$option 	= $this->dashboard_upload_profilepic($this->current_user->id);
			$upload_dir	= $option['upload_dir'];

			$upload 	= new FileUpload('userprofilpic');
			$result 	= $upload->handleUpload(getcwd().'/'.$upload_dir, $option['valid_extensions']);

			if($result==true) {
				$file_name	= $upload->getFileName();
				$uri_path 	= base_url($upload_dir.$file_name);
				$b64image 	= base64_encode(file_get_contents(getcwd().'/'.$upload_dir.$file_name));

				$json = array(
					'status' 		=> true,
					'uri_path' 		=> $uri_path,
					'upload_dir'	=> $upload_dir,
					'file_name'		=> $file_name,
					// 'b64image' 		=> $b64image,
				);
			}
		}

		echo json_encode($json);
	}

	public function submit_guest_profilepic() {
		$json = array('status'=>false);

		$option 	= $this->guest_upload_profilepic();
		$upload_dir	= $option['upload_dir'];

		$upload 	= new FileUpload('userprofilpic');
		$result 	= $upload->handleUpload(getcwd().'/'.$upload_dir, $option['valid_extensions']);

		if($result==true) {
			$file_name	= $upload->getFileName();
			$uri_path 	= base_url($upload_dir.$file_name);
			$b64image 	= base64_encode(file_get_contents(getcwd().'/'.$upload_dir.$file_name));

			$json = array(
				'status' 		=> true,
				'uri_path' 		=> $uri_path,
				'upload_dir'	=> $upload_dir,
				'file_name'		=> $file_name,
				// 'b64image' 		=> $b64image,
			);

			if ($guestpic = $this->session->userdata('guestpic')) {
				$this->load->helper("file");
				/* check guest profile picture session */
				if (is_dir($guestpic['upload_dir'])) {
					if(is_file($guestpic['upload_dir'].$guestpic['file_name'])) {
					 	unlink($guestpic['upload_dir'].$guestpic['file_name']);
					}
				}

				/* reset session guestpic */
				$this->session->unset_userdata('guestpic');
				$this->session->set_userdata('guestpic', $json);
			} else {
				$this->session->set_userdata('guestpic', $json);
			}
		}

		echo json_encode($json);
	}

	public function transform_date() {
		$rules = array(
			'check_date' => array(
				'field'	=> 'check_date',
				'label'	=> 'Date',
				'rules'	=> 'required|trim|xss_clean'
			),
			'name'=> array(
				'field'	=> 'name',
				'label'	=> 'Nama Anak',
				'rules'	=> 'required|trim|xss_clean|max_length[150]|callback__string_spasi'
			),
			'dob' => array(
				'field'	=> 'dob',
				'label'	=> 'Tanggal Lahir Anak',
				'rules'	=> 'required|trim|xss_clean'
			),
			'gender' => array(
				'field'	=> 'gender',
				'label'	=> 'Jenis Kelamin Anak',
				'rules'	=> 'required|trim|xss_clean'
			),
		);

		$json = array(
			'status' => 'false',
		);

		$this->form_validation->set_rules($rules);
		if($this->form_validation->run()) {
			// $date 		= $this->input->post('check_date');
			// $date 		= explode('/',$this->input->post('check_date'));
			// $date 		= $date[2].'-'.$date[1].'-'.$date[0];

			$bulan = array('Januari'=>'1','Februari'=>'2','Maret'=>'3','April'=>'4','Mei'=>'5','Juni'=>'6','Juli'=>'7','Agustus'=>'8','September'=>'9','Oktober'=>'10','November'=>'11','Desember'=>'12');
			$dateInput 		= explode(' ',$this->input->post('check_date'));
			if(array_key_exists($dateInput[1],$bulan)) {
				$date=$dateInput[2].'-'.$bulan[$dateInput[1]].'-'.$dateInput[0];
			}

			$indoDate 	= $this->indo_date('d M Y', $date);
			$from 	= new DateTime($date);
			$to 	= new DateTime('today');
			$old 	= (array)$from->diff($to);

			if($old['y']<=0) {
				$indoOld = $old['m'].' bulan';
			} else {
				$indoOld = $old['y'].' tahun '.$old['m'].' bulan';
			}

			$json = array(
				'status' 	=> 'true',
				'date' 		=> $date,
				'indodate' 	=> $indoDate,
				'old' 		=> $indoOld,
			);
		}

		echo json_encode($json);
	}

	private function dashboard_upload_profilepic($dir) {
		$upload_dir 			= 'uploads/profile/'.$dir.'/';

		if(!is_dir(getcwd().'/'.$upload_dir)) {
			mkdir(getcwd().'/'.$upload_dir,0775,true);
		}

		$option = array(
			'dir'				=> $dir,
			'upload_dir'		=> $upload_dir,
			'valid_extensions'	=> array('png', 'jpeg', 'jpg'),
		);

		return $option;
	}

	private function guest_upload_profilepic() {
		$upload_dir 			= 'uploads/profile/guest/';

		if(!is_dir(getcwd().'/'.$upload_dir)) {
			mkdir(getcwd().'/'.$upload_dir,0775,true);
		}

		$option = array(
			'upload_dir'		=> $upload_dir,
			'valid_extensions'	=> array('png', 'jpeg', 'jpg'),
		);

		return $option;
	}

	public function submit_ask_comment()
	{
		if ($this->current_user && $this->input->is_ajax_request()) {
			$this->load->helper('parenting');
			$this->load->model('ask_expert/ask_expert_m');

			$ask_id = (int) $this->input->post('ask_id');
			$ask_unread = (int) $this->input->post('unread');
			$ask_unread = $ask_unread > 0 ? $ask_unread + $this->ask_limit : 0;
			$answer_value = nl2br($this->input->post('comment'));
			$answer_type = $this->input->post('type');
			$expert_type = $this->input->post('expert_type');
			$answer_status = 'publish';
			$result = array('status' => false);
			$input_by = $this->current_user->id;

			if ($expert_type && $expert_type == 'sp') {
				$doctor = $this->ask_expert_m->get_single_ask($ask_id);
				$input_by = $doctor->doctor_id;
			}

			$data_edit = array(
				'input_by' 		=> $input_by,
			    'answer_value' 	=> $answer_value,
			    'answer_time' 	=> app_datetime(),
			    'answer_status' => $answer_status
			);

		    if ($this->ask_expert_m->update_data($data_edit, $ask_id)) {
		    	$post = $this->ask_expert_m->get_single_data($ask_id);
		    	$check_ae_notif = $this->ask_expert_m->check_exists_answer_notif($ask_id, $post->user_id);

		    	if ($check_ae_notif) {
			    	$data_notif = array(
			    		'ask_id' 		=> $ask_id,
			    		'user_id' 		=> $post->user_id,
			    		'notif_read' 	=> 0,
			    		'answer_value' 	=> $answer_value,
					    'answer_time' 	=> app_datetime(),
					    'answer_status' => $answer_status,
				    );

				    $this->ask_expert_m->insert_ask_notif($data_notif);
				}

				/*if ($answer_type == 'create') {
		    		$this->load->library('Mandrill/Mandrill');

		    		$ask_response 	= $this->ask_expert_m->get_single_data($ask_id);
		    		$ask_data 		= $this->ask_expert_m->get_single_ask($ask_id);
		    		$ask_user 		= $this->ion_auth->get_user($ask_response->user_id);

		    		$data_mail = array(
						'message' => 'Pertanyaan telah di Jawab<br>Hi '.($ask_user->gender=='f' ? 'Mam ' : 'Pap ').$ask_user->first_name.'. Terima kasih telah memberikan pertanyaan di Smart Consultation. Tim ahli kami telah menjawab pertanyaan '.($ask_user->gender=='f' ? 'Mam ' : 'Pap ').$ask_user->first_name.'. Yuk segera cek jawabannya di Parenting Club dengan klik tombol di bawah ini.',
						'subject' => 'Smart Consultation',
						'button_text' => 'Lihat Jawaban',
						'url' => site_url('smart-consultation/'.$ask_data->speciality_slug.'/'.$ask_data->ask_slug),
					);

					$message = array(
				        'html' => $this->load->view('users/mail', $data_mail, true),
				        'text' => '',
				        'subject' => 'Smart Consultation - '.$ask_response->ask_subject,
				        'from_email' => 'info@parentingclub.id',
				        'from_name' => 'Parentingclub',
				        'to' => array(
				            array(
				                'email' => $ask_user->email,
				                'name' => $ask_user->first_name.' '.$ask_user->last_name,
				                'type' => 'to'
				            ),
				        ),
				        'headers' => array('Reply-To' => 'info@parentingclub.id'),
				        'track_opens' => false,
        				'track_clicks' => false,
				    );

					$this->mandrill->messages->send($message, false, '', '2016-10-01');
		    	}*/

		    	$result['status'] = true;
		    	$result['message'] = 'Komentar Anda berhasil dikirim. Terimakasih.';
		    	$result['answer_value_preview'] = $answer_value;
		    	$result['answer_value_dataattr'] = strip_tags($answer_value);
		    	$result['unread'] = $ask_unread - 1;
		    } else {
		    	$result['message'] = 'Terjadi kesalahan dalam menyimpan komentar Anda.';
		    }

		    header('Content-Type: application/json');
			echo json_encode($result);
			return;
		}
	}

	public function load_more_asks()
	{
		if ($this->current_user && $this->input->is_ajax_request()) {
			if (in_array($this->current_user->group, array('expert', 'super_expert'))) {
				$limit = 5;
				$page = (int) $this->input->post('page');
				$total = (int) $this->input->post('total');
				$sort = $this->input->post('sort') == 'latest' ? 'DESC' : 'ASC';
				$result = array('status' => false);
				$super_admin = $this->current_user->group === 'super_expert' ? true : false;
				$doctor_data = $this->user_m->get_doctor_details($this->current_user->user_id);
				$doctor_id = 0;

				$ask_params = array(
					'status'      => 'all',
					'order'       => array('a.ask_id', $sort),
					'super_admin' => $super_admin,
					'limit'       => $limit,
					'offset'      => $limit * ($page - 1)
				);

				$read = $this->input->post('read');
				if (!empty($read)) {
					if ($read == 'unread') {
						$ask_params['status'] = 'unpublish';
					} elseif ($read == 'read') {
						$ask_params['status'] = 'publish';
					}
				}

				if ($doctor_data) {
					$ask_params['doctor_id'] = $doctor_data->doctor_id;
				}

				if ($this->current_user->group === 'super_expert') {
					$doctor_id = $this->input->post('doctor', true) ? (int) $this->input->post('doctor') : 0;
					$ask_params['doctor_id'] = $doctor_id;
				}

				$asks_data = $this->user_m->get_asks_data($ask_params);

				if ($page == 1) {
					unset($ask_params['limit'], $ask_params['offset']);
					$asks_data_total = $this->user_m->get_asks_data($ask_params);
					$asks_data_total = count($asks_data_total);

					if ($ask_params['status'] != 'all') {
						$remaining = $asks_data_total - count($asks_data);
					} else {
						$remaining = $asks_data_total - $limit;
					}
				} else {
					$remaining = $total - count($asks_data);
				}

				if ($asks_data) {
					foreach ($asks_data as $ask_sc) {
						$this->load->model('ask_expert/ask_expert_m');

						$ask_sc->comments = $this->ask_expert_m->get_ask_comments(array('arid' => $ask_sc->ask_id));
					}

					$result['status'] = true;
					$result['data'] = $asks_data;
					$result['page'] = $page + 1;
					$result['total'] = $remaining;
				}

			    header('Content-Type: application/json');
				echo json_encode($result);
				return;
			}
		}
	}

	public function load_more_notif()
	{
		if ($this->current_user && $this->input->is_ajax_request()) {
			if (in_array($this->current_user->group, array('expert', 'super_expert'))) {
				$limit = 20;
				$page = (int) $this->input->post('page');
				$result = array('status' => false);
				$super_admin = $this->current_user->group === 'super_expert' ? true : false;
				$doctor_data = $this->user_m->get_doctor_details($this->current_user->user_id);

				$ask_params = array(
					'status'      => 'unpublish',
					'super_admin' => $super_admin,
					'order' 	  => array('a.ask_id', 'DESC'),
					'limit' 	  => $limit,
					'offset' 	  => $limit * ($page - 1)
				);

				if ($doctor_data) {
					$ask_params['doctor_id'] = $doctor_data->doctor_id;
				}

				$asks_data = $this->user_m->get_asks_data($ask_params);

				if ($asks_data) {
					$result['status'] = true;
					$result['asks'] = $asks_data;
				}

			    header('Content-Type: application/json');
				echo json_encode($result);
				return;
			}
		}
	}

	public function set_expert_notif()
	{
		if ($this->current_user && $this->input->is_ajax_request()) {
			if (in_array($this->current_user->group, array('expert', 'super_expert'))) {
				$count = (int) $this->input->post('count');
				$result = array('status' => false);

				if ($count > 0) {
					$this->session->set_userdata('expert_unread_counts', true);
					$result['status'] = true;
				}

			    header('Content-Type: application/json');
				echo json_encode($result);
				return;
			}
		}
	}

	public function afs_mail_user() {
	    $result_data = $this->session->userdata('afs_result_data');
	    if(!empty($result_data)) {
	        foreach ($result_data as $key => $data) {
	            $result = $this->afs_m->get_result_bykid($this->current_user->id, $data['child_id'], 'completed');

	            $config_copyresult  = $this->config->item('afs/afs_copyresult');
	            if($result['result_detail_true_score']>99) {
	                $afs_copyresult = $config_copyresult[3];
	            } elseif($result['result_detail_true_score']>29 and $result['result_detail_true_score']<100) {
	                $afs_copyresult = $config_copyresult[2];
	            } elseif($result['result_detail_true_score']<30) {
	                $afs_copyresult = $config_copyresult[1];
	            }

	            $ageLabel = $this->getKidAgeLabel($result['result']['child_id']);
	            $data = array(
	                'age_label'         => $ageLabel,
	                'url_landing'       => site_url('afs-finder'),
	            );

	            // send result to user
	            /*$this->load->library('Mandrill/Mandrill');
	            $message = array(
	                'html' => $this->load->view('afs/notif_result', array('data'=>$data, 'afs_copyresult'=>$afs_copyresult, 'result'=>$result), true),
	                'text' => '',
	                'subject' => 'Parenting Club – Hasil Sinergi Kepintaran si Kecil dari AFS Finder',
	                'from_email' => 'donotreply@parentingclub.id',
	                'from_name' => 'Parentingclub',
	                'to' => array(
	                    array(
	                        'email' => $result['result']['user_email'],
	                        'name' => $result['result']['display_name'],
	                        'type' => 'to'
	                    )
	                ),
	                'headers' => array('Reply-To' => 'donotreply@parentingclub.id'),
	                'track_opens' => false,
	                'track_clicks' => false,
	            );
	            $sendMaild = $this->mandrill->messages->send($message, false);*/

	            $this->load->library('Swiftmailer/Baseswiftmailer');
				$message = array(
			       	'html' => $this->load->view('afs/notif_result', array('data'=>$data, 'afs_copyresult'=>$afs_copyresult, 'result'=>$result), true),
	                'text' => '',
	                'subject' => 'Parenting Club – Hasil Sinergi Kepintaran si Kecil dari AFS Finder',
	                'from_email' => 'donotreply@parentingclub.id',
	                'from_name' => 'Parentingclub',
	                'to' => array(
	                    array(
	                        'email' => $result['result']['user_email'],
	                        'name' => $result['result']['display_name'],
	                    )
	                ),
			    );
				$mailer = $this->baseswiftmailer->send($message);

	            $udpateMail = array(
	                                'email_notif'   => 'pending-notified'
	                            );
	            $this->afs_m->update_data('afs_result', $udpateMail, 'id', $result['result']['id']);
	        }
	    }
	}

	protected function getKidAgeLabel($kid=0)
	{
		$age = '';
		if($this->current_user){
			if($kid!=0) {
				$child_data = $this->afs_m->get_list_child($this->current_user->id, true, $kid);
			} else {
				$child_data = $this->afs_m->get_list_child($this->current_user->id, true, $this->session->userdata('afs_user_kid'));
			}
			
			if($child_data->num_rows()){
				$child = $child_data->row_array();
			}

			if(!empty($child)) {
				$diff = $this->dateDiff($child['dob']);
				$age = 'usia ';
				$age .= $diff->y!=0 ? $diff->y.' tahun ' : '';
				$age .= $diff->m!=0 ? $diff->m.' bulan' : '';
			}
		} else if($this->session->userdata('afs_unreg_kid')) {
			$child_data = $this->session->userdata('afs_unreg_kid');
			if(!empty($child_data)) {
				$diff = $this->dateDiff($child_data['child_dob']);
				$age = 'usia ';
				$age .= $diff->y!=0 ? $diff->y.' tahun ' : '';
				$age .= $diff->m!=0 ? $diff->m.' bulan' : '';
			}
		}

		return ($age) ? $age : false;
	}

	protected function dateDiff($date)
	{
		$dataDate 	= new DateTime($date);
		$now 		= new DateTime('today');
		
		return $dataDate->diff($now);
	}
}
