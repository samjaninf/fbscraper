<?php

require_once("home.php"); // loading home controller

class event_search extends Home
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

        if($this->session->userdata('user_type') != 'Admin' && !in_array(5,$this->module_access))
        redirect('home/login_page', 'location'); 

        $this->load->library('Fb_search');       
    }

    public function index()
    {
        $this->event_search();
    }

    public function event_search()
    {
        $data['body'] = 'event_search/event_search_grid';
        $data['page_title'] = $this->lang->line("Event Search");

        $configured_or_not = $this->fb_search->app_id_secret_check();
        if($configured_or_not == 'not_configured'){
            $data['configured_or_not'] = 'not_configured';
        }
        else{
            $data['configured_or_not'] = 'configured';

            $redirect_url = base_url()."home/redirect_link";        
            $data['fb_login_button'] = $this->fb_search->login_for_user_access_token($redirect_url);

            $validatity = 'yes';            
            $where['where'] = array('user_id'=>$this->user_id,'status'=>'1');
            $access_token_info = $this->basic->get_data('facebook_config',$where,$select=array('user_access_token'));
            if(isset($access_token_info[0]['user_access_token']) && $access_token_info[0]['user_access_token'] != '')
            {                
                $access_token = 'yes';
                $validatity_time = $this->fb_search->access_token_validity_check();
                if(!$validatity_time)
                {
                    $validatity = 'no';
                }
            }
            else
            {
                $access_token = 'no';
            }
            $data['validatity'] = $validatity;
            $data['access_token'] = $access_token;
        }

        $this->_viewcontroller($data);
    }
    

    public function event_search_data()
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
            $this->session->set_userdata('event_search_keyword', $keyword);
            $this->session->set_userdata('event_search_name', $name);
            $this->session->set_userdata('event_search_from_date', $from_date);
            $this->session->set_userdata('event_search_to_date', $to_date);
        }

        // saving session data to different search parameter variables
        $search_keyword   = $this->session->userdata('event_search_keyword');
        $search_name   = $this->session->userdata('event_search_name');
        $search_from_date  = $this->session->userdata('event_search_from_date');
        $search_to_date = $this->session->userdata('event_search_to_date');

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

        $where_simple['user_id'] = $this->user_id;
        $where  = array('where'=>$where_simple);
        $order_by_str=$sort." ".$order;
        $offset = ($page-1)*$rows;
        $result = array();
        $table = "event_search";
        $info = $this->basic->get_data($table, $where, $select='', $join='', $limit=$rows, $start=$offset, $order_by=$order_by_str, $group_by='');
        
        $i = 0;
        foreach($info as $results){
            $result[$i]['id'] = $results['id'];
            $result[$i]['search_keyword'] = $results['search_keyword'];
            $result[$i]['name'] = $results['name'];
            $result[$i]['attending_count'] = $results['attending_count'];
            $result[$i]['interested_count'] = $results['interested_count'];
            $result[$i]['maybe_count'] = $results['maybe_count'];
            $result[$i]['noreply_count'] = $results['noreply_count'];
            $result[$i]['declined_count'] = $results['declined_count'];
            $result[$i]['searched_at'] = $results['searched_at'];
            $result[$i]['details'] = "<a class='label label-warning' href='".base_url()."event_search/event_details/".$results['id']."'><i class='fa fa-binoculars'></i> ".$this->lang->line('details')."</a>";
            $i++;
        }

        $total_rows_array = $this->basic->count_row($table, $where, $count="id", $join='');
        $total_result = $total_rows_array[0]['total_rows'];

        echo convert_to_grid_data($result, $total_result);
    }


    public function event_search_action()
    {
        $this->session->unset_userdata('event_search_completed');
        $this->session->unset_userdata('event_search_counting_search');
        //************************************************//
        $status=$this->_check_usage($module_id=5,$request=1);
       if($status=="2") 
        {
            echo "<div class='alert alert-warning text-center' style='background:#fffddd !important;color:#000 !important;'>".$this->lang->line("sorry, your bulk limit is exceeded for this module.")."<a style='color:#000 !important;' href='".site_url('payment/usage_history')."'>".$this->lang->line("click here to see usage log")."</a></div>";
            $this->session->set_userdata('event_search_completed',1);
            exit();
        }
        else if($status=="3") 
        {
            echo "<div class='alert alert-warning text-center' style='background:#fffddd !important;color:#000 !important;'>".$this->lang->line("sorry, your monthly limit is exceeded for this module.")."<a style='color:#000 !important;' href='".site_url('payment/usage_history')."'>".$this->lang->line("click here to see usage log")."</a></div>";
            $this->session->set_userdata('event_search_completed',1);
            exit();
        }
        //************************************************//

        $keyword=$this->input->post('keyword', true);
        $limit=$this->input->post('limit', true);        
        

        $download_id=$this->session->userdata('download_id');
        $fp = fopen("download/event_search/event_search_{$this->user_id}_{$download_id}.csv", "w");
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        $write_data=array();            
        $write_data[]="Keyword"; 
        $write_data[]="ID"; 
        $write_data[]="Event Name"; 
        $write_data[]="Place"; 
        $write_data[]="Start Time"; 
        $write_data[]="Attending Count"; 
        $write_data[]="Interested Count"; 
        $write_data[]="May be attend count"; 
        $write_data[]="Noreply Count"; 
        $write_data[]="Declined Count"; 
        $write_data[]="Searched Date"; 
        fputcsv($fp, $write_data);

        $str = "<table class='table table-bordered table-striped table-condensed'><tr><th>".$this->lang->line('sl')."</th><th>".$this->lang->line('event id')."</th><th>".$this->lang->line('event name')."</th><th>".$this->lang->line('location')."</th><th>".$this->lang->line('attending')."</th><th>".$this->lang->line('may be attend')."</th><th>".$this->lang->line('details')."</th></tr>";
        
        $event_search_data=$this->fb_search->event_search($keyword,$limit);

        // foreach($event_search_data as $value){
            $sl=0;
            foreach($event_search_data['data'] as $value1){
                foreach($value1 as $value2){

                    $insert_data['user_id'] = $this->user_id;
                    $insert_data['search_keyword'] = $keyword;
                    $insert_data['searched_at'] = date("Y-m-d");
                    $insert_data['deleted'] = '0';
                    if(isset($value2['description']))
                        $insert_data['description'] = addslashes($value2['description']);

                    if(isset($value2['name']))
                        $insert_data['name'] = $value2['name'];

                    if(isset($value2['place']))
                        $insert_data['place'] = json_encode($value2['place']);

                    if(isset($value2['start_time']))
                        $insert_data['start_time'] = $value2['start_time'];

                    if(isset($value2['id']))
                        $insert_data['event_id'] = $value2['id'];

                    if(isset($value2['can_guests_invite']))
                        $insert_data['can_guests_invite'] = $value2['can_guests_invite'];

                    if(isset($value2['cover']))
                        $insert_data['cover'] = json_encode($value2['cover']);

                    if(isset($value2['picture']))
                        $insert_data['picture'] = json_encode($value2['picture']);

                    if(isset($value2['declined_count']))
                        $insert_data['declined_count'] = $value2['declined_count'];

                    if(isset($value2['guest_list_enabled']))
                        $insert_data['guest_list_enabled'] = $value2['guest_list_enabled'];

                    if(isset($value2['interested_count']))
                        $insert_data['interested_count'] = $value2['interested_count'];

                    if(isset($value2['is_page_owned']))
                        $insert_data['is_page_owned'] = $value2['is_page_owned'];

                    if(isset($value2['is_viewer_admin']))
                        $insert_data['is_viewer_admin'] = $value2['is_viewer_admin'];

                    if(isset($value2['maybe_count']))
                        $insert_data['maybe_count'] = $value2['maybe_count'];
                    
                    if(isset($value2['noreply_count']))
                        $insert_data['noreply_count'] = $value2['noreply_count'];

                    if(isset($value2['owner']))
                        $insert_data['owner'] = json_encode($value2['owner']);

                    if(isset($value2['timezone']))
                        $insert_data['timezone'] = $value2['timezone'];

                    if(isset($value2['type']))
                        $insert_data['type'] = $value2['type'];

                    if(isset($value2['updated_time']))
                        $insert_data['updated_time'] = $value2['updated_time'];

                    if(isset($value2['attending_count']))
                        $insert_data['attending_count'] = $value2['attending_count'];

                    if($this->basic->insert_data('event_search', $insert_data)){

                        $insert_id = $this->db->insert_id();

                        $write_data=array();
                        $write_data[]=$keyword;

                        $ID = '';
                        if(isset($value2['id'])) $ID = $value2['id'];
                        $write_data[]=$ID;

                        $write_name = '';
                        if(isset($value2['name'])) $write_name = $value2['name'];
                        $write_data[]=$write_name;

                        $place_final = '';
                        if(isset($value2['place'])){
                            $location = $value2['place'];
                            
                            if(isset($location["name"])) $loc_name=$location["name"]; else $loc_name="";

                            if(isset($location["location"]) && is_array($location["location"]))
                            {
                                array_walk($location["location"], function(&$value, $key) {
                                $key=ucfirst($key);
                                $value = "{$key} : {$value}";
                                });
                                $place = implode('<br/>', $location["location"]);
                            }
                            else $place="";

                            $place_final=$place;
                        }
                        $write_data[]=str_replace("<br/>",", ", $place_final);

                        $start_time = '';
                        if(isset($value2['start_time'])) $start_time = $value2['start_time'];
                        $write_data[]=$start_time;

                        $attending_count = '';
                        if(isset($value2['attending_count'])) $attending_count = $value2['attending_count'];
                        $write_data[]=$attending_count;

                        $interested_count = '';
                        if(isset($value2['interested_count'])) $interested_count = $value2['interested_count'];
                        $write_data[]=$interested_count;

                        $maybe_count = '';
                        if(isset($value2['maybe_count'])) $maybe_count = $value2['maybe_count'];
                        $write_data[]=$maybe_count;

                        $noreply_count = '';
                        if(isset($value2['noreply_count'])) $noreply_count = $value2['noreply_count'];
                        $write_data[]=$noreply_count;

                        $declined_count = '';
                        if(isset($value2['declined_count'])) $declined_count = $value2['declined_count'];
                        $write_data[]=$declined_count;

                        $write_data[]=date("Y-m-d");
                        fputcsv($fp, $write_data);

                        $sl++;
                        $str .= "<tr>
                                    <td>".$sl."</td>
                                    <td>".$ID."</td>
                                    <td>".$write_name."</td>
                                    <td>".$place_final."</td>
                                    <td>".$attending_count."</td>
                                    <td>".$maybe_count."</td>
                                    <td><a target='_BLANK' href='".base_url()."event_search/event_details/{$insert_id}'><i class='fa fa-binoculars'></i> ".$this->lang->line('details')."</td>
                                </tr>";
                    }

                }
            }
        // }

        $str .= "</table>";

        fclose($fp);
        
        //******************************//
        // insert data to useges log table
        $this->_insert_usage_log($module_id=5,$request=1);   
        //******************************//

        echo $str;

    }

  

    public function event_search_download()
    {
        $all=$this->input->post("all");
        $table = 'event_search';
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

        $where['where'] = array('user_id'=>$this->user_id);

        $info = $this->basic->get_data($table, $where, $select ='', $join='', $limit='', $start=null, $order_by='id asc');
        $download_id=$this->session->userdata('download_id');
        $fp = fopen("download/event_search/event_search_{$this->user_id}_{$download_id}.csv", "w");
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        $write_data=array();            
        $write_data[]="Keyword"; 
        $write_data[]="Event Name"; 
        $write_data[]="Event ID"; 
        $write_data[]="Place"; 
        $write_data[]="Start Time"; 
        $write_data[]="Attending Count"; 
        $write_data[]="Interested Count"; 
        $write_data[]="May be attend Count"; 
        $write_data[]="No reply Count";
        $write_data[]="Declined Count";
        $write_data[]="Searched Date"; 
        fputcsv($fp, $write_data);


        foreach ($info as $row) 
        {
            $write_data=array();
            $write_data[]=$row["search_keyword"];  
            $write_data[]=$row["name"];  
            $write_data[]=$row["event_id"];

            $location=json_decode($row['place'],true);
            if(isset($location["name"])) $loc_name=$location["name"]; else $loc_name="";

            if(isset($location["location"]) && is_array($location["location"]))
            {
                array_walk($location["location"], function(&$value, $key) {
                $key=ucfirst($key);
                $value = "{$key} : {$value}";
                });
                $place = implode('<br/>', $location["location"]);
            }
            else $place="";

            $place_final=$place; 
            $write_data[]=str_replace("<br/>",", ", $place_final); 

            $write_data[]=$row["start_time"];  
            $write_data[]=$row["attending_count"];  
            $write_data[]=$row["interested_count"];  
            $write_data[]=$row["maybe_count"];  
            $write_data[]=$row["noreply_count"];
            $write_data[]=$row["declined_count"];
            $write_data[]=$row["searched_at"];
            fputcsv($fp, $write_data);
                
        }

        fclose($fp);
        $file_name = "download/event_search/event_search_{$this->user_id}_{$download_id}.csv";
        echo $file_name;
    }


    

    public function event_search_delete()
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
        $this->db->where('user_id', $this->user_id);
        $this->db->delete('event_search');
    }

   
    public function bulk_event_search_progress_count()
    { 
        $bulk_counting_search=$this->session->userdata('event_search_counting_search');
        $completed_search=$this->session->userdata('event_search_completed');
        
        $response['search_counting']=$bulk_counting_search;
        $response['search_completed']=$completed_search;
        
        echo json_encode($response);
        
    }


    public function event_details($id)
    {
        $data['body'] = 'event_search/event_details';
        $data['page_title'] = $this->lang->line("event search");
        $where['where'] = array('id'=>$id);
        $info = $this->basic->get_data("event_search",$where);
        $data['info'] = $info[0];
        $this->_viewcontroller($data);
    }

 

   

}
