<?php
require_once 'swift_required.php';

class Baseswiftmailer
{
	
    protected $mail_host;
    protected $mail_port;
    protected $mail_from_address;
    protected $mail_from_name;
    protected $mail_encryption;
    protected $mail_username;
    protected $mail_password;
	protected $to;
    protected $subject;
    protected $html_template;

	public function __construct()
	{
		$this->ci =& get_instance();
        $this->ci->config->load('email');
        $this->mail_host 				= $this->ci->config->item('mail_host');
        $this->mail_port 				= $this->ci->config->item('mail_port');
        $this->mail_from_email 			= $this->ci->config->item('mail_from_email');
        $this->mail_from_name 			= $this->ci->config->item('mail_from_name');
        $this->mail_encryption 			= $this->ci->config->item('mail_encryption');
        $this->mail_username 			= $this->ci->config->item('mail_username');
        $this->mail_password 			= $this->ci->config->item('mail_password');
        $this->mail_verify_peer 		= $this->ci->config->item('mail_verify_peer');
        $this->mail_verify_peer_name 	= $this->ci->config->item('mail_verify_peer_name');
        $this->mail_allow_self_signed 	= $this->ci->config->item('mail_allow_self_signed');
	}

	protected function init()
    {
        $transport = (new Swift_SmtpTransport(
        				$this->mail_host, 
        				$this->mail_port, 
        				$this->mail_encryption)
    				)
                    ->setUsername($this->mail_username)
                    ->setPassword($this->mail_password)
                    ->setStreamOptions(
                    	array(
                    		'ssl' => array(
                    			'allow_self_signed' => $this->mail_allow_self_signed,
                    			'verify_peer' 		=> $this->mail_verify_peer,
                    			'verify_peer_name' 	=> $this->mail_verify_peer_name,
                    		)
                    	)
                    );
 
        $mailer = new Swift_Mailer($transport);
        return $mailer;
    }

    public function to($data)
    {
        $dataTo = array();
        if(isset($data['to'])) {
        	foreach($data['to'] as $key=>$sendTo) {
	        	if(array_key_exists('name', $sendTo)) {
                    $email = trim($sendTo['email']);
                    $dataTo[$email]=$sendTo['name'];
                } else {
                    $dataTo[$key] = $sendTo['email'];
                }
            }
        }
        $this->to = $dataTo;
        return $this->to;
    }

    public function mail_from_email($data)
    {
        $this->mail_from_email 	= (isset($data['from_email'])) ? $data['from_email'] : $this->mail_from_email;
        return $this->mail_from_email;
    }

    public function mail_from_name($data)
    {
        $this->mail_from_name = (isset($data['from_name'])) ? $data['from_name'] : $this->mail_from_name;
        return $this->mail_from_name;
    }

    public function subject($data)
    {
        $this->subject = (isset($data['subject'])) ? $data['from_name'] : '';
        return $this->subject;
    }

    public function html_template($data)
    {
        if((isset($data['html']))) {
        	$this->html_template = $data['html'];
        } else {
        	$this->html_template = $data['text'];
        }
        return $this->html_template;
    }

	public function send($data = array())
	{
		$mailer 			= $this->init();
		$mail_from_email 	= $this->mail_from_email($data);
		$mail_from_name 	= $this->mail_from_name($data);
		$to 				= $this->to($data);
		$subject 			= $this->subject($data);
		$template 			= $this->html_template($data);
 
        $message = (new Swift_Message($subject))
                    ->setFrom($mail_from_email,$mail_from_name)
                    ->setTo($to)
                    ->setBody($template, 'text/html');
 
        $result = $mailer->send($message);
	}
}