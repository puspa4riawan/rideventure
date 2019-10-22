<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User controller for the users module (frontend)
 *
 * @author		 Phil Sturgeon
 * @author		MaxCMS Dev Team
 * @package		MaxCMS\Core\Modules\Users\Controllers
 */
class Api extends Public_Controller
{
	/**
	 * Constructor method
	 *
	 * @return \Users
	 */
	public function __construct()
	{
		parent::__construct();
        $this->load->model('profile_m');
        $this->load->model('user_m');
        $this->load->library('form_validation');
		// Load the required classes
		
	}

	/**
	 * Show the current user's profile
	 */
	public function LoginPGPC()
	{
		if($this->input->post('token_wyeth_api') && (config_item('token_wyeth_api') == $this->input->post('token_wyeth_api')) )
        {
            if($phone_number = $this->input->post('sPhoneNumber'))
            {
                $data_user = $this->profile_m->get_profile(array('phone'=>$phone_number));
                
                if($data_user)
                {
                    echo json_encode(array('status'=>1,'data'=>array('eways_id'=>$data_user->eways_id,'first_name'=>$data_user->first_name,'last_name'=>$data_user->last_name)));
                }
                else {
                     echo json_encode(array('status'=>0,'message'=>'users not exists'));
                }
            }
            else {
                echo json_encode(array('status'=>0,'message'=>'phone number is required'));
            }
        }
        else {
            echo json_encode(array('status'=>0,'message'=>'tokens invalid or not exists'));
        }
	}
    
    function _check_eways_id($value)
    {
        $data_user = $this->profile_m->get_profile(array('eways_id'=>$value));
        if($data_user)
        {
          return true;  
        }
        else {
            $this->form_validation->set_message('_check_eways_id','Eways Id Not Exists');
            return false;
        }
    }
    
    function _check_token_wyeth_api($value)
    {
        if($value ==config_item('token_wyeth_api'))
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message('_check_token_wyeth_api','tokens invalid or not exists');
            return false;
        }
    }
    
    public function UpdateMemberDetailPGPC()
    {
        //rules
        $rules = array(array(   'field'=>'eways_id',
                                'label'=>'eways id',
                                'rules'=>'required|trim|callback__check_eways_id'
                             ),
                       array(   'field'=>'token_wyeth_api',
                                'label'=>'token wyteh api',
                                'rules'=>'required|callback__check_token_wyeth_api'         
                            ),
                       array(   'field'=>'ChildName1',
                                'label'=>'ChildName1',
                                'rules'=>'trim'         
                            ),
                       array(   'field'=>'ChildName2',
                                'label'=>'ChildName2',
                                'rules'=>'trim'         
                            ),
                        array(   'field'=>'ChildName3',
                                'label'=>'ChildName3',
                                'rules'=>'trim'         
                            ),
                       'childdob1'=> array(   'field'=>'ChildDOB1',
                                'label'=>'ChildDOB1',
                                'rules'=>'trim'         
                            ),
                       'childdob2'=> array(   'field'=>'ChildDOB2',
                                'label'=>'ChildDOB2',
                                'rules'=>'trim'         
                            ),
                       'childdob3'=> array(   'field'=>'ChildDOB3',
                                'label'=>'ChildDOB3',
                                'rules'=>'trim'         
                            ),
                       'gender1'=> array(   'field'=>'Gender1',
                                'label'=>'Gender1',
                                'rules'=>'trim'         
                            ),
                       'gender2' =>array(   'field'=>'Gender2',
                                'label'=>'Gender2',
                                'rules'=>'trim'         
                            ),
                       'gender3' =>array(   'field'=>'Gender3',
                                'label'=>'Gender3',
                                'rules'=>'trim'         
                            ),
                       array(   'field'=>'Address1',
                                'label'=>'Address1',
                                'rules'=>'trim'         
                        ),
                        array(   'field'=>'Address2',
                                'label'=>'Address2',
                                'rules'=>'trim'         
                        ),
                         array(   'field'=>'Address3',
                                'label'=>'Address3',
                                'rules'=>'trim'         
                        ),
                         array(   'field'=>'CustDOB',
                                'label'=>'CustDOB',
                                'rules'=>'trim'         
                        )           
                        );
                        
        //validate dependencies
        if(($this->input->post('ChildName1')))
        {
            $rules['gender1']['rules'] .= '|required';
             $rules['childdob1']['rules'] .= '|required';
        }

        if(($this->input->post('ChildName2')))
        {
            $rules['gender2']['rules'] .= '|required';
             $rules['childdob2']['rules'] .= '|required';
        }
        
        if(($this->input->post('ChildName3')))
        {
            $rules['gender3']['rules'] .= '|required';
             $rules['childdob3']['rules'] .= '|required';
        }
        
        
        $this->form_validation->set_rules($rules);
        if($this->form_validation->run())
        {
            $data_children = $this->input->post();
             $data_children_new =array();
               if(!empty($data_children['ChildName1']))
               {
                   $dataExplode1 = explode(' ',$data_children['ChildDOB1']);
                   $dataExplode2 = explode('/',$dataExplode1[0]);
                     $data_children_new['name_kids_first']=$data_children['ChildName1'];
                     $data_children_new['tgl_kids_first']=$dataExplode2[1];
                     $data_children_new['bulan_kids_first']=$dataExplode2[0];
                     $data_children_new['tahun_kids_first']=$dataExplode2[2];
                     $data_children_new['jk_kids_first']=(strtolower($data_children['Gender1']) =='m' ? '1':'2' );
               }
               //second
               if(!empty($data_children['ChildName2']))
               {
                   $dataExplode1 = explode(' ',$data_children['ChildDOB2']);
                   $dataExplode2 = explode('/',$dataExplode1[0]);
                     $data_children_new['name_kids_second']=$data_children['ChildName2'];
                     $data_children_new['tgl_kids_second']=$dataExplode2[1];
                     $data_children_new['bulan_kids_second']=$dataExplode2[0];
                     $data_children_new['tahun_kids_second']=$dataExplode2[2];
                     $data_children_new['jk_kids_second']=(strtolower($data_children['Gender2']) =='m' ? '1':'2' );
               }
                //third
               if(!empty($data_children['ChildName3']))
               {
                   $dataExplode1 = explode(' ',$data_children['ChildDOB3']);
                   $dataExplode2 = explode('/',$dataExplode1[0]);
                     $data_children_new['name_kids_third']=$data_children['ChildName3'];
                     $data_children_new['tgl_kids_third']=$dataExplode2[1];
                     $data_children_new['bulan_kids_third']=$dataExplode2[0];
                     $data_children_new['tahun_kids_third']=$dataExplode2[2];
                     $data_children_new['jk_kids_third']=(strtolower($data_children['Gender3']) =='m' ? '1':'2' );
               }
               
               //update profile
               $data_new = array();
               if($data_children['Address1'])
               {
                   $data_new['address_line1'] = $data_children['Address1'];
               }
               if($data_children['Address2'])
               {
                   $data_new['address_line2'] = $data_children['Address2'];
               }
               if($data_children['Address3'])
               {
                   $data_new['address_line3'] = $data_children['Address3'];
               }
               
               if($data_children['CustDOB'])
               {
                   $dataDob = explode('-',$data_children['CustDOB']);
                   $data_new['tgl']                   = $dataDob[2];
                   $data_new['bulan']                 = $dataDob[1];
                   $data_new['tahun']                 = $dataDob[0];
               }
               if(count($data_new))
               {
                    $cond = array('eways_id'=>$data_children['eways_id']);
                    $this->profile_m->update_profile_custom($data_new,$cond);
               }
               
               if(count($data_children_new))
               {
                   $data_user = $this->profile_m->get_profile(array('eways_id'=>$value));
                   $this->db->where('user_id',$data_user->user_id);
                   $this->db->update('kids_user',$data_children_new);
               }
                
            echo json_encode(array('status'=>1,'eways_id'=>$data_children['eways_id']));
        }
        else {
            echo json_encode(array('status'=>0,'message'=>validation_errors()));
        }
    }


    public function UpdatePoint()
    {
         $rules = array(array(  'field'=>'eways_id',
                                'label'=>'eways id',
                                'rules'=>'required|trim|callback__check_eways_id'
                             ),
                       array(   'field'=>'token_wyeth_api',
                                'label'=>'token wyteh api',
                                'rules'=>'required|callback__check_token_wyeth_api'         
                            ),
                       array(   'field'=>'sPoint',
                                'label'=>'sPoint',
                                'rules'=>'trim|required'         
                            ),
                            
                       );
        
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run())
        {
           $this->profile_m->update_profile_custom(array('total_point'=>$this->input->post('sPoint')),array('eways_id'=>$this->input->post('eways_id')));  
        }
        else {
            echo json_encode(array('status'=>0,'message'=>validation_errors()));
        }
        
    }

    public function UpdateLastShipment()
    {
         $rules = array(array(  'field'=>'eways_id',
                                'label'=>'eways id',
                                'rules'=>'required|trim|callback__check_eways_id'
                             ),
                       array(   'field'=>'token_wyeth_api',
                                'label'=>'token wyteh api',
                                'rules'=>'required|callback__check_token_wyeth_api'         
                            ),
                       array(   'field'=>'data',
                                'label'=>'data',
                                'rules'=>'trim|required'         
                            ),
                            
                       );
                       
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run())
        {
            $data = json_decode($this->input->post('data'));
            if(is_array($data) && count($data))
            {
                $data_user = $this->profile_m->get_profile(array('eways_id'=>$this->input->post('eways_id')));
                $this->db->delete('default_last_shipment_history',array('eways_id'=>$this->input->post('eways_id')));
                foreach($data as $id=>$value)
                {
                    $new_value =  array();
                    foreach($value as $idx => $vals)
                    {
                       $new_value[strtolower($idx)] = $vals;
                    }
                    
                    if(! isset($value['eways_id']))
                    {
                        $new_value['eways_id'] = $data_user->eways_id;
                    }
                    
                    if(! isset($value['user_id']))
                    {
                       $new_value['user_id'] =  $data_user->user_id;
                    }
                    
                    $this->db->insert('default_last_shipment_history',$new_value);
                   
                }
                echo json_encode(array('status'=>1,'eways_id'=>$this->input->post('eways_id')));
            }
        }
        else
        {
            echo json_encode(array('status'=>0,'message'=>validation_errors()));
        }            
        
    }

    public function UpdateLastSubmitPoint()
    {
         $rules = array(array(  'field'=>'eways_id',
                                'label'=>'eways id',
                                'rules'=>'required|trim|callback__check_eways_id'
                             ),
                       array(   'field'=>'token_wyeth_api',
                                'label'=>'token wyteh api',
                                'rules'=>'required|callback__check_token_wyeth_api'         
                            ),
                       array(   'field'=>'data',
                                'label'=>'data',
                                'rules'=>'trim|required'         
                            ),
                            
                       );
                       
        $this->form_validation->set_rules($rules);
        
        if($this->form_validation->run())
        {
            $data = json_decode($this->input->post('data'));
            if(is_array($data) && count($data))
            {
                $data_user = $this->profile_m->get_profile(array('eways_id'=>$this->input->post('eways_id')));
                $this->db->delete('default_last_submit_point',array('eways_id'=>$this->input->post('eways_id')));
                foreach($data as $id=>$value)
                {
                    $new_value =  array();
                    foreach($value as $idx => $vals)
                    {
                       $new_value[strtolower($idx)] = $vals;
                    }
                    
                    if(! isset($value['eways_id']))
                    {
                        $new_value['eways_id'] = $data_user->eways_id;
                    }
                    
                    if(! isset($value['user_id']))
                    {
                       $new_value['user_id'] =  $data_user->user_id;
                    }
                    
                    $this->db->insert('default_last_submit_point',$new_value);
                  
                }
                
                echo json_encode(array('status'=>1,'eways_id'=>$this->input->post('eways_id')));
            }
        }
        else
        {
            echo json_encode(array('status'=>0,'message'=>validation_errors()));
        }     
    }

}
