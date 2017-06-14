<?php
require_once("home.php");

class native_api extends Home
{
    public $user_id;
    
    public function __construct()
    {
        parent::__construct();   
        $this->user_id=$this->session->userdata("user_id");    

        $this->important_feature();
        $this->periodic_check();
    }


    public function index()
    {
       $this->get_api();
    }

    public function _api_key_generator()
    {
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');

        if($this->session->userdata('user_type') != 'Admin')
        redirect('home/login_page', 'location');

        $val=$this->session->userdata("user_id")."-".substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 7 ).time()
        .substr(str_shuffle('abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ23456789') , 0 , 7 );
        return $val;
    }

    public function get_api()
    {
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');

        if($this->session->userdata('user_type') != 'Admin')
        redirect('home/login_page', 'location');
        $data['body'] = "api/native_api";
        $data['page_title'] = 'API';
        $api_data=$this->basic->get_data("native_api",array("where"=>array("user_id"=>$this->session->userdata("user_id"))));
        $data["api_key"]="";
        if(count($api_data)>0) $data["api_key"]=$api_data[0]["api_key"];
        $this->_viewcontroller($data);
    }

    public function get_api_action()
    { 
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login', 'location');

        if($this->session->userdata('user_type') != 'Admin')
        redirect('home/login_page', 'location');

        $api_key=$this->_api_key_generator(); 
        if($this->basic->is_exist("native_api",array("api_key"=>$api_key)))
        $this->get_api_action();

        $user_id=$this->session->userdata("user_id");        
        if($this->basic->is_exist("native_api",array("user_id"=>$user_id)))
        $this->basic->update_data("native_api",array("user_id"=>$user_id),array("api_key"=>$api_key));
        else $this->basic->insert_data("native_api",array("api_key"=>$api_key,"user_id"=>$user_id));
            
        redirect('native_api/get_api', 'location');
    }



    public function send_notification($api_key="")
    {
        if ($api_key=="") exit();
        $user_id=substr($api_key, 0, 1);

        if(!$this->basic->is_exist("native_api",array("api_key"=>$api_key,"user_id"=>$user_id)))
        {
            echo "API Key does not match with any user.";
            exit();
        }   

        if(!$this->basic->is_exist("users",array("id"=>$user_id,"status"=>"1","deleted"=>"0","user_type"=>"Admin")))
        {
            echo "Invalid user.";
            exit();
        }     

        $current_date = date("Y-m-d");
        $tenth_day_before_expire = date("Y-m-d", strtotime("$current_date + 10 days"));
        $one_day_before_expire = date("Y-m-d", strtotime("$current_date + 1 days"));
        $one_day_after_expire = date("Y-m-d", strtotime("$current_date - 1 days"));

        // echo $tenth_day_before_expire."<br/>".$one_day_before_expire."<br/>".$one_day_after_expire;

        //send notification to members before 10 days of expire date
        $where = array();
        $where['where'] = array(
            'user_type !=' => 'Admin',
            'expired_date' => $tenth_day_before_expire
            );
        $info = array();
        $value = array();
        $info = $this->basic->get_data('users',$where,$select='');
        $from = "";
        $mask = $this->config->item('product_name');
        $subject = "Payment Notification";
        foreach ($info as $value) 
        {
            $message = "Dear {$value['first_name']} {$value['last_name']},<br/> your account will expire after 10 days, Please pay your fees.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
            $to = $value['email'];
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=0);
        }

        //send notificatio to members before 1 day of expire date
        $where = array();
        $where['where'] = array(
            'user_type !=' => 'Admin',
            'expired_date' => $one_day_before_expire
            );
        $info = array();
        $value = array();
        $info = $this->basic->get_data('users',$where,$select='');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $subject = "Payment Notification";
        foreach ($info as $value) {
            $message = "Dear {$value['first_name']} {$value['last_name']},<br/> your account will expire tomorrow, Please pay your fees.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
            $to = $value['email'];
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=0);
        }

        //send notificatio to members after 1 day of expire date
        $where = array();
        $where['where'] = array(
            'user_type !=' => 'Admin',
            'expired_date' => $one_day_after_expire
            );
        $info = array();
        $value = array();
        $info = $this->basic->get_data('users',$where,$select='');
        $from = $this->config->item('institute_email');
        $mask = $this->config->item('product_name');
        $subject = "Payment Notification";
        foreach ($info as $value) {
            $message = "Dear {$value['name']},<br/> your account has been expired, Please pay your fees for continuity.<br/><br/>Thank you,<br/><a href='".base_url()."'>{$mask}</a> team";
            $to = $value['email'];
            $this->_mail_sender($from, $to, $subject, $message, $mask, $html=0);
        }

    }



    
}
