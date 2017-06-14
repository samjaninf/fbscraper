<?php

require_once("home.php"); // loading home controller

class page_search_guest extends Home
{

    public $user_id;    
    
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');       
 
        $this->user_id=$this->session->userdata('user_id');
        set_time_limit(0);

        $this->important_feature();

        $this->member_validity();

        if($this->session->userdata('user_type') != 'Admin' && !in_array(1,$this->module_access))
        redirect('home/login_page', 'location');

        $this->load->library('Fb_search');
    }

    public function index()
    {
        $this->page_search_guest();
    }

    public function page_search_guest()
    {
        $data['body'] = 'page_search_guest/page_search_guest_grid';
        $data['page_title'] = $this->lang->line("Page Search");

        $configured_or_not = $this->fb_search->app_id_secret_check();
        if($configured_or_not == 'not_configured'){
            $data['configured_or_not'] = 'not_configured';
        }
        else{
            $data['configured_or_not'] = 'configured';
            $where['where'] = array('user_id'=>$this->user_id,'status'=>'1');
            $access_token_info = $this->basic->get_data('facebook_config',$where,$select=array('user_access_token'));
            if(isset($access_token_info[0]['user_access_token']) && $access_token_info[0]['user_access_token'] != '')
                $access_token = 'yes';
            else{
                $redirect_url = base_url()."home/redirect_link";        
                $data['fb_login_button'] = $this->fb_search->login_for_user_access_token($redirect_url);
                $access_token = 'no';
            }
            $data['access_token'] = $access_token;
        }

        $this->_viewcontroller($data);
    }
    

    public function page_search_guest_data()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        redirect('home/access_forbidden', 'location');
        

        $page = isset($_POST['page']) ? intval($_POST['page']) : 15;
        $rows = isset($_POST['rows']) ? intval($_POST['rows']) : 5;
        $sort = isset($_POST['sort']) ? strval($_POST['sort']) : 'id';
        $order = isset($_POST['order']) ? strval($_POST['order']) : 'DESC';

        $name = trim($this->input->post("name", true));
        $keyword = trim($this->input->post("keyword", true));

        $from_date = trim($this->input->post('from_date', true));        
        if($from_date) $from_date = date('Y-m-d', strtotime($from_date));

        $to_date = trim($this->input->post('to_date', true));
        if($to_date) $to_date = date('Y-m-d', strtotime($to_date));


        // setting a new properties for $is_searched to set session if search occured
        $is_searched = $this->input->post('is_searched', true);


        if ($is_searched) 
        {
            // if search occured, saving user input data to session. name of method is important before field
            $this->session->set_userdata('page_search_guest_keyword', $keyword);
            $this->session->set_userdata('page_search_guest_name', $name);
            $this->session->set_userdata('page_search_guest_from_date', $from_date);
            $this->session->set_userdata('page_search_guest_to_date', $to_date);
        }

        // saving session data to different search parameter variables
        $search_keyword   = $this->session->userdata('page_search_guest_keyword');
        $search_name   = $this->session->userdata('page_search_guest_name');
        $search_from_date  = $this->session->userdata('page_search_guest_from_date');
        $search_to_date = $this->session->userdata('page_search_guest_to_date');

        // creating a blank where_simple array
        $where_simple=array();
        
        if ($search_name)    $where_simple['name like '] = "%".$search_name."%";
        if ($search_keyword)    $where_simple['search_keyword like '] = $search_keyword."%";
        if ($search_from_date) 
        {
            if ($search_from_date != '1970-01-01') 
            $where_simple["searched_at >="]= $search_from_date;
            
        }
        if ($search_to_date) 
        {
            if ($search_to_date != '1970-01-01') 
            $where_simple["searched_at <="]=$search_to_date;
            
        }

        // $where_simple['user_id'] = $this->user_id;
        $where  = array('where'=>$where_simple);
        $order_by_str=$sort." ".$order;
        $offset = ($page-1)*$rows;
        $result = array();
        $table = "page_search_guest";
        $info = $this->basic->get_data($table, $where, $select='', $join='', $limit=$rows, $start=$offset, $order_by=$order_by_str, $group_by='');
        
        $i = 0;
        foreach($info as $results){
            $result[$i]['id'] = $results['id'];
            $result[$i]['search_keyword'] = $results['search_keyword'];
            $result[$i]['name'] = $results['name'];
            $result[$i]['fan_count'] = $results['fan_count'];
            $result[$i]['website'] = $results['website'];
            $result[$i]['phone'] = $results['phone'];
            $result[$i]['founded'] = $results['founded'];
            $result[$i]['category'] = $results['category'];
            if($results['is_verified'] == '1')
                $result[$i]['is_verified'] = "<span class='label label-success'>Verified</span>";
            else
                $result[$i]['is_verified'] = "<span class='label label-danger'>Not Verified</span>";
            $result[$i]['searched_at'] = $results['searched_at'];

            $page_emails = json_decode($results['emails']);
            if(!empty($page_emails)){
                $page_emails = implode(',', $page_emails);
            }
            $result[$i]['emails'] = $page_emails;
            $result[$i]['details'] = "<a class='label label-warning' href='".base_url()."page_search_guest/page_details/".$results['id']."'><i class='fa fa-binoculars'></i>".$this->lang->line('details')."</a>";
            $i++;
        }

        $total_rows_array = $this->basic->count_row($table, $where, $count="id", $join='');
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($result, $total_result);
    }


    public function page_search_guest_download()
    {
        $all=$this->input->post("all");
        $table = 'page_search_guest';
        $where=array();
        if($all==0)
        {
            $selected_grid_data = $this->input->post('info', true);
            $json_decode = json_decode($selected_grid_data, true);
            $id_array = array();
            foreach ($json_decode as  $value) 
            {
                $id_array[] = $value['id'];
            }
            $where['where_in'] = array('id' => $id_array);
        }

        // $where['where'] = array('user_id'=>$this->user_id);

        $info = $this->basic->get_data($table, $where, $select ='', $join='', $limit='', $start=null, $order_by='id asc');
        $download_id=$this->session->userdata('download_id');
        $fp = fopen("download/page_search_guest/page_search_guest_{$this->user_id}_{$download_id}.csv", "w");
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        $write_data=array();            
        $write_data[]="Keyword"; 
        $write_data[]="ID"; 
        $write_data[]="Page Name"; 
        $write_data[]="Fan Count"; 
        $write_data[]="Website"; 
        $write_data[]="Phone"; 
        $write_data[]="Founded At"; 
        $write_data[]="Category"; 
        $write_data[]="Is Verified";
        $write_data[]="Email";
        $write_data[]="Link";
        $write_data[]="Location";
        $write_data[]="Searched Date"; 
        fputcsv($fp, $write_data);


        foreach ($info as $row) 
        {
            $write_data=array();
            $write_data[]=$row["search_keyword"];  
            $write_data[]=$row["page_id"];  
            $write_data[]=$row["name"];  
            $write_data[]=$row["fan_count"];  
            $write_data[]=$row["website"];  
            $write_data[]=$row["phone"];  
            $write_data[]=$row["founded"];  
            $write_data[]=$row["category"];  
            $write_data[]=$row["is_verified"];
            $emails = json_decode($row['emails']);
            if(!empty($emails))
                $email = $emails[0];
            else $email = '';
            $write_data[]=$email;
            $write_data[]=$row["link"];

            $location=json_decode($row['location'],true);
            if(isset($location["latitude"]))  unset($location["latitude"]);
            if(isset($location["longitude"])) unset($location["longitude"]);
            if(is_array($location))
            {
                array_walk($location, function(&$value, $key) {
                $key=ucfirst($key);
                $value = "{$key} : {$value}";
                });
                $location =  "<br/>".implode('<br>', $location);
            }
            else $location="";
            $write_data[]=$location;
            
            $write_data[]=$row["searched_at"];
            fputcsv($fp, $write_data);
                
        }

        fclose($fp);
        $file_name = "download/page_search_guest/page_search_guest_{$this->user_id}_{$download_id}.csv";
        echo $file_name;
    }


    

    public function page_search_guest_delete()
    {
        $all=$this->input->post("all");

        if($all==0)
        {
            $selected_grid_data = $this->input->post('info', true);
            $json_decode = json_decode($selected_grid_data, true);
            $id_array = array();
            foreach ($json_decode as  $value) 
            {
                $id_array[] = $value['id'];
            }     
            $this->db->where_in('id', $id_array);
        }
        $this->db->where('id > ', 0);
        $this->db->delete('page_search_guest');
    }



    public function page_details($id=0)
    {
        if($id==0) exit();
        $data['body'] = 'page_search_guest/page_details_guest';
        $data['page_title'] = $this->lang->line("page search by guest");
        $where['where'] = array('id'=>$id);
        $info = $this->basic->get_data("page_search_guest",$where);
        $data['info'] = $info[0];
        $this->_viewcontroller($data);
    }

 

   

}
