<?php

require_once("home.php"); // including home controller

/**
* class config
* @category controller
*/
class dashboard extends Home
{

    public $user_id;
    /**
    * load constructor method
    * @access public
    * @return void
    */
    public function __construct()
    {
        parent::__construct();

        if ($this->session->userdata('logged_in')!= 1) {
            redirect('home/login_page', 'location');
        }

        $this->important_feature();
        
        $this->user_id=$this->session->userdata('user_id');

        $this->member_validity();
    }

    /**
    * load index method. redirect to config
    * @access public
    * @return void
    */
    public function index()
    {
        $this->user_dashboard();
    }


    public function user_dashboard()
    {

        if($this->session->userdata("user_type")=="Member")
        {
            $package_info=$this->session->userdata("package_info");              
            $package_name="No Package";
            if(isset($package_info["package_name"]))  $package_name=$package_info["package_name"];
            $validity="0";
            if(isset($package_info["validity"]))  $validity=$package_info["validity"];
            $price="0";
            if(isset($package_info["price"]))  $price=$package_info["price"];
            $data['package_name']=$package_name;
            $data['validity']=$validity;
            $data['price']=$price;
        }
        $data['payment_config']=$this->basic->get_data('payment_config');

        $data['body'] = "dashboard/user_dashboard";
        $data['page_title'] = $this->lang->line('dashboard');

        if($this->session->userdata("user_type")=="Member")
            $where['where'] = array('user_id'=>$this->user_id,'searched_at'=>date("Y-m-d"));
        else
            $where['where'] = array('searched_at'=>date("Y-m-d"));


        
        $where_page_search_email_count['where'] = array('searched_at'=>date("Y-m-d"));
        
        $where_page_search_email_count['where_not_in'] = array('emails'=>array('','["<<not-applicable>>"]'));
        $select_page_search_email_count = array();
        $select_page_search_email_count = array('distinct(emails) as email');

        $page_search_emails = $this->basic->get_data("page_search",$where_page_search_email_count,$select_page_search_email_count);
        $page_search_emails_guest = $this->basic->get_data("page_search_guest",$where_page_search_email_count,$select_page_search_email_count);


        $where_page_search_email_count_guest['where'] = array("date_format(date_time,'%Y-%m-%d') >="=>date("Y-m-d"));
        $where_page_search_email_count_guest['where_not_in'] = array('email'=>array('','["<<not-applicable>>"]'));
        $select_page_search_email_count_guest = array();
        $select_page_search_email_count_guest = array('distinct(email) as email');

        $lead_emails = $this->basic->get_data("leads",$where_page_search_email_count_guest,$select_page_search_email_count_guest);


        
        $total_email_found = array(
            0 => array(
                "value" => count($page_search_emails),
                "color" => "#F39C12",
                "highlight" => "#F39C12",
                "label" => $this->lang->line("emails from page search"),
                ),
            1 => array(
                "value" => count($lead_emails),
                "color" => "#b56969",
                "highlight" => "#b56969",
                "label" => $this->lang->line("emails from guest user"),
                ),
            2 => array(
                "value" => count($page_search_emails_guest),
                "color" => "#22264b",
                "highlight" => "#22264b",
                "label" => $this->lang->line("emails from guest search"),
                ),
            );
        $data['page_search_emails'] = count($page_search_emails);
        $data['lead_emails'] = count($lead_emails);
        $data['page_search_emails_guest'] = count($page_search_emails_guest);

        $data['total_email_found'] = json_encode($total_email_found);

        $total_page_search_result = $this->basic->get_data("page_search",$where,$select=array('distinct(name) as name'));
        $total_page_search = $this->basic->get_data("page_search",$where,$select=array('distinct(search_keyword) as keyword'));

        $total_event_search_result = $this->basic->get_data("event_search",$where,$select=array('distinct(name) as name'));
        $total_event_search = $this->basic->get_data("event_search",$where,$select=array('distinct(search_keyword) as keyword'));

        $total_location_search_result = $this->basic->get_data("location_search",$where,$select=array('distinct(name) as name'));
        $total_location_search = $this->basic->get_data("location_search",$where,$select=array('distinct(search_keyword) as keyword'));

        $total_group_search_result = $this->basic->get_data("group_search",$where,$select=array('distinct(name) as name'));
        $total_group_search = $this->basic->get_data("group_search",$where,$select=array('distinct(search_keyword) as keyword'));

        $total_user_search_result = $this->basic->get_data("user_search",$where,$select=array('distinct(name) as name'));
        $total_user_search = $this->basic->get_data("user_search",$where,$select=array('distinct(search_keyword) as keyword'));

        $bar_chart_data = array(
            0 => array(
                'search_type' => $this->lang->line("Page Search"),
                'total_search' => count($total_page_search),
                'total_result_found' => count($total_page_search_result)
                ),
            1 => array(
                'search_type' => $this->lang->line("Event Search"),
                'total_search' => count($total_event_search),
                'total_result_found' => count($total_event_search_result)
                ),
            2 => array(
                'search_type' => $this->lang->line("Page Search By Location"),
                'total_search' => count($total_location_search),
                'total_result_found' => count($total_location_search_result)
                ),
            3 => array(
                'search_type' => $this->lang->line("Group Search"),
                'total_search' => count($total_group_search),
                'total_result_found' => count($total_group_search_result)
                ),
            4 => array(
                'search_type' => $this->lang->line("User Search"),
                'total_search' => count($total_user_search),
                'total_result_found' => count($total_user_search_result)
                )
            );

        $data['bar_chart_data'] = json_encode($bar_chart_data);


        $page_search = $this->basic->get_data('page_search',$where,$select=array('id','search_keyword','name'),$join='',$limit=10,$start=NULL,$order_by='id desc');
        $data['page_search'] = $page_search;

        $event_search = $this->basic->get_data('event_search',$where,$select=array('id','search_keyword','name'),$join='',$limit=10,$start=NULL,$order_by='id desc');
        $data['event_search'] = $event_search;

        $page_search_by_location = $this->basic->get_data('location_search',$where,$select=array('id','search_keyword','name'),$join='',$limit=10,$start=NULL,$order_by='id desc');
        $data['location_search'] = $page_search_by_location;

        $group_search = $this->basic->get_data('group_search',$where,$select=array('id','search_keyword','name'),$join='',$limit=10,$start=NULL,$order_by='id desc');
        $data['group_search'] = $group_search;

        $user_search = $this->basic->get_data('user_search',$where,$select=array('id','search_keyword','name'),$join='',$limit=10,$start=NULL,$order_by='id desc');
        $data['user_search'] = $user_search;



        $this->_viewcontroller($data);
    }





}
