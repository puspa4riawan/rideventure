<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_Controller {

    var $groups;
	public function __construct() {
		parent::__construct();
		$this->load->model(array('article/article_m'));
        $this->groups = $this->db->get_where('groups',array('name' => 'subscriber'))->row('id');

        
	}

	public function index($slug = ''){
        
        $slug = $this->security->xss_clean($slug);

        if(!in_array($slug, array('dancow', 'koko', 'milo')) and !empty($slug)) {
            var_dump($slug);
            redirect();
        }
            
        $campaign_head = $slug;
        switch ($slug) {
            case 'koko':
                $color = 'theme-orange';
                $heading = 'Aktif Bersama Si Kecil';
                $campaign_head = 'Koko krunch';
                $main_banner = Asset::get_filepath_img('upload/figure/figure-heading-main-banner-koko.svg', true);
                break;

            case 'dancow':
                $color = 'theme-purple';
                $heading = 'Gizi Seimbang untuk Si Kecil';
                $main_banner = Asset::get_filepath_img('upload/figure/figure-heading-main-banner-dancow.svg', true);
                break;
                
            default:
                $slug = 'milo';
                $color = 'theme-green';
                $heading = 'Tumbuh Kembang Si Kecil';
                $main_banner = Asset::get_filepath_img('upload/figure/figure-heading-main-banner.svg', true);
                break;
        }
        

        $meta_title = 'Nestle for Healthier Kids';

        //get article by slug
        $this->db->where('status','live');
        $this->db->like('campaign',$slug,'both');
        $this->db->where('categories_id',1);
        $article_slug = $this->article_m->get_all_data('article');

        //get recipe by slug
        $this->db->where('status','live');
        $this->db->like('campaign',$slug,'both');
        $this->db->where('categories_id',2);
        $recipe_slug = $this->article_m->get_all_data('article');

		$this->template->title($meta_title)
            // ->set_metadata('robots', $meta_robots)
            // ->set_metadata('keywords', $meta_keyword)
            // ->set_metadata('description', $meta_desc)
            // ->set_metadata('og:type', $og_type)
            // ->set_metadata('og:image', $og_image)
            // ->set_metadata('og:title', $og_title)
            // ->set_metadata('og:description', $og_description)
            // ->set_metadata('og:url', $og_url)
            ->set('color', $color)
            ->set('campaign_slug',$slug)
            ->set('article_slug',$article_slug)
            ->set('recipe_slug',$recipe_slug)
            ->set('campaign_head', $campaign_head)
            ->set('heading', $heading)
            ->set('main_banner', $main_banner)
            ->set_layout('landing.html')
            ->build('public/landing');
    }

    public function subscriber()
    {
        if($this->input->is_ajax_request()) {

			$response = array(
				'status'	=>'error',
			);
			$validation = array(
				'email'	=> array(
					'field'	=> 'email',
					'label'	=> 'email',
					'rules'	=> 'trim|required|valid_email|max_length[100]|callback__string_email_tambahan'
				),
				'campaign'	=> array(
					'field'	=> 'campaign',
					'label'	=> 'campaign',
					'rules'	=> 'required|trim|xss_clean'
				),
			);

			$this->form_validation->set_rules($validation);
			if($this->form_validation->run()) {
                //recaptcha chek 
                $captcha_res = $this->input->post('recap_token');

                if(isset($captcha_res) && $captcha_res != ''){
                    $secret   = Settings::get('recaptcha_private_key');

                    $response = file_get_contents(
                        "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $captcha_res . "&remoteip=" . $_SERVER['REMOTE_ADDR']
                    );
                    // use json_decode to extract json response
                    $response = json_decode($response);

                    if ($response->success === false || $response->score <= 0.5) {
                        $message = array(
                            'status'=>'error', 'error'=> array('err' => '<p align="center" id="return_message">Data tidak bisa diterima karena alasan keamanan. </p>'));
                        echo json_encode($message);
                        return;
                    }
                }

                
                $succes_message = array(
                        'status'=>'success', 
                        'user'=> array(),
                        'message' => 'Terima kasih sudah berlangganan');

                
                $new_subscriber = array(
                    'email'         => $this->input->post('email'),
                    'password'      => password_hash(mt_rand(), PASSWORD_DEFAULT),
                    'salt'          => '0',
                    'group_id'      => $this->groups,
                    'created_on'    => strtotime(date('Y-m-d H:i:s')),
                    'last_login'    => strtotime(date('Y-m-d H:i:s')),
                    'campaign'      => $this->input->post('campaign') //nanti dibuat bisa isi banyak dengan separator ,

                );
                //cek email sudah ada apa tidak

                if(self::exist_subscriber($new_subscriber['email'])){
                    $exist_subscrib = $this->db->get_where('users',array('email' => $new_subscriber['email'],'group_id' => $this->groups))->row();
                    $old_campaign = explode(",",$exist_subscrib->campaign);
                    if(!in_array($new_subscriber['campaign'],$old_campaign)){
                        array_push($old_campaign, $new_subscriber['campaign']);
                        $new_campaign =  implode(',',$old_campaign);
                        $this->db->update('users',array('campaign'=> $new_campaign), "id = ".$exist_subscrib->id);
                        // $succes_message['user'] = $this->db->get_where('users',"id = ".$exist_subscrib->id);
                        echo json_encode($succes_message);
                        
                        return;
                    }else{
                        echo json_encode(array('status'=>'error', 'error'=> array('err' => '<p align="center" id="return_message">email ini sudah pernah berlangganan dengan campaign yang sama.</p>')));
                        return;
                    }
                }

                $this->db->insert('users', $new_subscriber);
                $user_id = $this->db->insert_id();
                // $succes_message['user'] = $this->db->get_where('users',array('id' => $user_id))->row();  
                
                if($user_id){
                    echo json_encode($succes_message);
                    return;
                }

            } else {
                foreach ($validation as $key => $fields) {
					$data[$fields['field']] = form_error($fields['field']);
				}

				echo json_encode(array('status'=>'error', 'error'=> $data));
				return;
            }
        }
    }
    
    private function exist_subscriber($email){
        $exist = false;
        $exist_user = $this->db->get_where('users',array('email' => $email, 'group_id' => $this->groups))->result();
        if($exist_user){
            $exist = true;
        }

        return $exist;
    }

    public function page_404() {
		// Untuk wyeth revamp (milestone)
		$this->output->set_status_header(404);

		$this->template
            ->title('404 Not Found')
            ->set_layout('error.html')
			->build('public/404');

		// request baru = page 404 redirect ke home
		// redirect();
    }
    
    public function _string_email_tambahan($string){
		if(preg_match('/[^a-zA-Z0-9_\.@]+/ism', $string)){
			$this->form_validation->set_message('_string_email_tambahan', 'Bagian %s invalid string');
			return FALSE;
		}else{
			return TRUE;
		}
	}
}
