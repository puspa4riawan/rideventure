<?php defined('BASEPATH') or die('No Direct Scrip Access Allowed');

require_once (__DIR__.'/lib/nusoap.php');

class Wyeth_api
{
    function __construct()
    {
        $this->ci =& get_instance();
        $this->client = new nusoap_client(__DIR__.'/WyethWS.wsdl', 'wsdl','', '', '', '');   
    }
    
    function checkUserExists($phone_number)
    {
            $param =array('sPhoneNumber'=>$phone_number);
            $result = $this->client->call('LoginPGPC', $param, '', '', false, true);
            if($this->getData($result))
            {
                $data = array_shift($result);
                
                if($data['IsSuccess'] == 0)
                {
                    $this->ci->session->flashdata('api_wyeth_error',$data['Reason']);
                    return false;
                }
                else {
                    $this->ci->session->set_userdata('userIdWyeth',$data['UserId']);
                    return $data['UserId'];
                }
            }
            else
            {
               
                return false;
            }
    }
    
    function getUserInfo($member_id)
    {
          $param =array('sMemberId'=>$member_id);
          $result = $this->client->call('GrabMemberDetailPGPC', $param, '', '', false, true);
           if($this->getData($result))
            {
                $data = array_shift($result);
                
                if($data['IsSuccess'] == 0)
                {
                    $this->ci->session->flashdata('api_wyeth_error',$data['Reason']);
                    return false;
                }
                else {
                   
                    return $data;
                }
            }
            else
            {
                return false;
            }
        
    }
    
    function getLastRedeem($member_id)
    {
         $param =array('MemberId'=>$member_id);
          $result = $this->client->call('GetLastRedeem', $param, '', '', false, true);
           $result1 = array_shift($result);
           $data = array_shift($result1);
           
           return $data;
              
           
    }
    
     function getLastShipment($member_id)
    {
         $param =array('MemberId'=>$member_id);
          $result = $this->client->call('GetLastShipment', $param, '', '', false, true);
           $result1 = array_shift($result);
           $data = array_shift($result1);
           
           return $data;
    }
    
    function getLastSubmitPoint($member_id)
    {
         $param =array('MemberId'=>$member_id);
          $result = $this->client->call('GetLastSubmit', $param, '', '', false, true);
           $result1 = array_shift($result);
           $data = array_shift($result1);
           
           return $data;
    }
    
    function reqSMSCode($member_id)
    {
         $param =array('sMemberId'=>$member_id);
          $result = $this->client->call('SentMemberIdValidasiPGPC', $param, '', '', false, true);
           if($this->getData($result))
            {
                $data =array_shift($result);
                
                if($data['IsSuccess'] == 0)
                {
                    $this->ci->session->flashdata('api_wyeth_error',$data['Reason']);
                    return false;
                }
                else {
                   
                    return $data['MemberId'];
                }
            }
            else
            {
                return false;
            }
    }
    
    function verifySMSCode($member_id,$code)
    {
        $param = array('sMemberId' =>$member_id,'sUniqueCode'=>$code);
        $result = $this->client->call('SentUniqueCodePGPC', $param, '', '', false, true);
           if($this->getData($result))
            {
                $data =array_shift($result);
                
                if($data['IsSuccess'] == 0)
                {
                    $this->ci->session->flashdata('api_wyeth_error',$data['Reason']);
                    return false;
                }
                else {
                   
                    return $data['MemberId'];
                }
            }
            else
            {
                return false;
            }
    }
    
    function getPoint($member_id)
    {
        $param = array('userid' =>$member_id);
        $result = $this->client->call('PointMember', $param, '', '', false, true);
           if($this->getData($result))
            {
                $data =array_shift($result);
                
                if($data['IsSuccess'] == 0)
                {
                    $this->ci->session->flashdata('api_wyeth_error',$data['Reason']);
                    return false;
                }
                else {
                   
                    return $data['sPoint'];
                }
            }
            else
            {
                return false;
            }
    }
    
    
    
    private function getData($result)
    {
        if ($this->client->fault) {
          //   var_dump($result);
            return false;
        } else {
            // Check for errors
            $err = $this->client->getError();
            if ($err) {
            //    var_dump($err);
              return false;
            } else {
                // Display the result
               return $result;
            }
        }
    }
}
