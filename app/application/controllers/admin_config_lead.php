<?php

require_once("home.php"); // including home controller

/**
* class config
* @category controller
*/
class admin_config_lead extends Home
{
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

        $this->user_id=$this->session->userdata('user_id');
        $this->important_feature();        
        $this->member_validity();
    }

    /**
    * load index method. redirect to config
    * @access public
    * @return void
    */
    public function index()
    {
        $this->lead_config();
    }

    /**
    * load config form method
    * @access public
    * @return void
    */
    public function lead_config()
    {                
        $data['body'] = "admin/config/edit_lead_config";
        $data['config_data'] = $this->basic->get_data("lead_config");       
        $data['page_title'] = $this->lang->line('lead settings');        
        $data['search_value_list'] = $this->_search_value_list();
        $this->_viewcontroller($data);
    }

    /**
    * method to edit config
    * @access public
    * @return void
    */
    public function edit_lead_config()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        if ($_POST) 
        {
            // validation
            $this->form_validation->set_rules('mailchimp_api_key',          '<b>'.$this->lang->line("mailchimp API key").'</b>',   		                                            'trim|xss_clean');
            $this->form_validation->set_rules('mailchimp_list_id',          '<b>'.$this->lang->line("mailchimp list ID").'</b>',                                                    'trim|xss_clean');;
            $this->form_validation->set_rules('search_limit',               '<b>'.$this->lang->line("frontend : maximum how many rows may come into search").'</b>',                'trim|xss_clean|integer');;
            $this->form_validation->set_rules('search_result_display_limit','<b>'.$this->lang->line("frontend : maximum how many rows will be displayed").'</b>',                   'trim|xss_clean|integer');;
            $this->form_validation->set_rules('subscriber_download_limit',  '<b>'.$this->lang->line("frontend : maximum how many rows can a user download").'</b>',                 'trim|xss_clean|integer');;
            $this->form_validation->set_rules('allowed_download_per_email', '<b>'.$this->lang->line("frontend : how many times a guest user can dowload using same email").'</b>',  'trim|xss_clean|integer');;
            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) 
            {
                return $this->lead_config();
            } 
            else 
            {
                // assign
                $mailchimp_api_key=addslashes(strip_tags($this->input->post('mailchimp_api_key', true)));
                $mailchimp_list_id=addslashes(strip_tags($this->input->post('mailchimp_list_id', true)));
                $search_limit=addslashes(strip_tags($this->input->post('search_limit', true)));
                $search_result_display_limit=addslashes(strip_tags($this->input->post('search_result_display_limit', true)));
                $subscriber_download_limit=addslashes(strip_tags($this->input->post('subscriber_download_limit', true)));
                $allowed_download_per_email=addslashes(strip_tags($this->input->post('allowed_download_per_email', true)));

                if($search_limit=="") $search_limit=600;
                if($search_result_display_limit=="") $search_result_display_limit=50;
                if($subscriber_download_limit=="") $subscriber_download_limit=150;
                if($allowed_download_per_email=="") $allowed_download_per_email=5;

                $insert_update_data=array("mailchimp_api_key"=>$mailchimp_api_key,"mailchimp_list_id"=>$mailchimp_list_id,"search_limit"=>$search_limit,"search_result_display_limit"=>$search_result_display_limit,"subscriber_download_limit"=>$subscriber_download_limit,"allowed_download_per_email"=>$allowed_download_per_email);

                if($this->basic->is_exist("lead_config",$where='',$select='id')) 
                $this->basic->update_data("lead_config",$where='',$insert_update_data);
                else $this->basic->insert_data("lead_config",$insert_update_data);
                  
                $this->session->set_flashdata('success_message', 1);
                redirect('admin_config_lead/lead_config', 'location');
            }
        }
    }

 


}
