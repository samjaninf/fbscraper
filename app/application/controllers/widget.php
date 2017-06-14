<?php
require_once("home.php");

class widget extends Home
{
    public function __construct()
    {
        parent::__construct();   
    }

    public function index()
    {
        $this->page_search_widget_list();
    }   


    public function page_search_widget_list()
    {
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');   

        if ($this->session->userdata('user_type')!= 'Admin') {
            redirect('home/login', 'location');
        }

        $this->load->database();
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->set_theme('flexigrid');
        $crud->set_table('widget');
        $crud->order_by('id','desc');
        $crud->set_subject($this->lang->line("widget")." : ".$this->lang->line("page search"));
        $crud->where('user_id',$this->session->userdata('user_id'));
        $crud->where('deleted',"0");

        $crud->fields('domain_name','border','width','height','background','color','icon_color','input_border_color','button_style');

        $crud->required_fields('domain_name','border','width','height','background','color','icon_color','button_style','input_border_color');

        $crud->columns('domain_name','border','width','height','background','color','icon_color','button_style','input_border_color');



        $crud->display_as('domain_name', $this->lang->line('domain name'));
        $crud->display_as('border', $this->lang->line('frame border'));
        $crud->display_as('width', $this->lang->line('frame width'));
        $crud->display_as('height', $this->lang->line('frame height'));
        $crud->display_as('background', $this->lang->line('frame background HEX'));
        $crud->display_as('color', $this->lang->line('text color HEX'));
        $crud->display_as('input_border_color', $this->lang->line('input border color HEX'));
        $crud->display_as('icon_color', $this->lang->line('icon color HEX'));
        $crud->display_as('button_style', $this->lang->line('button style'));


        $crud->unset_read();
        $crud->unset_print();
        $crud->unset_export();

        $images_url_code = base_url("plugins/grocery_crud/themes/flexigrid/css/images/code.png");
        $crud->add_action($this->lang->line('get widget embed code'),$images_url_code, 'widget/get_iframe_code');

        $crud->callback_field('border',array($this,'border_callback'));
        $crud->callback_field('width',array($this,'width_callback'));
        $crud->callback_field('height',array($this,'height_callback'));
        $crud->callback_field('background',array($this,'background_callback'));
        $crud->callback_field('color',array($this,'color_callback'));
        $crud->callback_field('input_border_color',array($this,'input_border_color_callback'));
        $crud->callback_field('icon_color',array($this,'icon_color_callback'));
        $crud->callback_field('button_style',array($this,'button_style_callback'));

        $crud->callback_after_insert(array($this, 'insert_user_id'));
        $crud->callback_after_update(array($this, 'update_domain_name'));

        $output = $crud->render();
        $data['output']=$output;
        $data['page_title'] = $this->lang->line("widget");
        $data['crud']=1;

        $this->_viewcontroller($data);
    }

    public function insert_user_id($post_array, $primary_key)
    {
        $id = $primary_key;
        $user_id = $this->session->userdata("user_id");
        $where = array('id'=>$id);
        $table = 'widget';
        $data = array('user_id'=>$user_id);
        $this->basic->update_data($table, $where, $data);

        $domain_name=strtolower(get_domain_only($post_array["domain_name"]));
        $where = array('id'=>$id);
        $table = 'widget';
        $data = array('domain_name'=>$domain_name);
        $this->basic->update_data($table, $where, $data);

        return true;
    }

    public function update_domain_name($post_array, $primary_key)
    {
        $id = $primary_key;
        $domain_name=strtolower(get_domain_only($post_array["domain_name"]));
        $where = array('id'=>$id);
        $table = 'widget';
        $data = array('domain_name'=>$domain_name);
        $this->basic->update_data($table, $where, $data);
        return true;
    }

 

    function border_callback($value, $row)
    {
        if ($value == '') 
        $value = '0px';
        return '<input id="field-border" type="text" maxlength="50" value="'.$value.'" name="border">';
    }
    function width_callback($value, $row)
    {
        if ($value == '') 
        $value = '100%';
        return '<input id="field-width" type="text" maxlength="50" value="'.$value.'" name="width">';
    }
    function height_callback($value, $row)
    {
        if ($value == '') 
        $value = '400px';
        return '<input id="field-height" type="text" maxlength="50" value="'.$value.'" name="height">';
    }
    function background_callback($value, $row)
    {
        if ($value == '') 
        $value = '#FFFFFF';
        return '<input id="field-background" type="color" maxlength="50" value="'.$value.'" name="background">';
    }
    function color_callback($value, $row)
    {
        if ($value == '') 
        $value = '#000000';
        return '<input id="field-color" type="color" maxlength="50" value="'.$value.'" name="color">';
    }
    function input_border_color_callback($value, $row)
    {
        if ($value == '') 
        $value = '#CCCCCC';
        return '<input id="field-input_border_color" type="color" maxlength="50" value="'.$value.'" name="input_border_color">';
    }
    function icon_color_callback($value, $row)
    {
        if ($value == '') 
        $value = '#1B809E';
        return '<input id="field-icon_color" type="color" maxlength="50" value="'.$value.'" name="icon_color">';
    }

    function button_style_callback($value, $row)
    {
        if ($value == '') 
        $value = 'primary';

        $styles=$this->basic->get_enum_values($table="widget",$column="button_style");
        $option=array();
        foreach($styles as $row)
        $option[trim($row)]=trim($row);
        
        return form_dropdown('button_style',$option, $value, 'class="form-control" id="field-button_style"');
    }


    public function get_iframe_code($id=0)
    {
        if ($this->session->userdata('logged_in') != 1)
        redirect('home/login_page', 'location');   

        if ($this->session->userdata('user_type')!= 'Admin') {
            redirect('home/login', 'location');
        }

        $user_id=$this->session->userdata("user_id");
        if($id==0 || !$this->basic->is_exist("widget",array("id"=>$id,"deleted"=>"0","user_id"=>$user_id)))
        exit();

        $table = 'widget';
        $where['where'] = array('id' => $id);
        $data["info"] = $this->basic->get_data($table, $where);
        $data['body'] = 'widget/page_search_iframe';
        $data['page_title'] =  $this->lang->line("widget");
        $this->_viewcontroller($data);
    }



    public function page_search_widget($user_id=0,$id=0,$widget_type="page_search")
    {
   
        $ref="";
        if(isset($_SERVER['HTTP_REFERER']))
        $ref= $_SERVER['HTTP_REFERER'];

        $domain_name=strtolower(get_domain_only($ref));

        if($user_id==0 || $user_id=="" || $id==0 || $id=="" || $widget_type!="page_search")  
        {        
            echo "No widget found.";
            exit();
        }

        if($domain_name!=strtolower(get_domain_only(site_url())))        
        {
            if(!$this->basic->is_exist("widget",array("domain_name"=>$domain_name,"user_id"=>$user_id,"id"=>$id,"deleted"=>"0")) || !$this->basic->is_exist("users",array("id"=>$user_id,"user_type"=>"Admin","status"=>"1","deleted"=>"0"))) 
            {
                echo "No widget found.";
                exit();
            }
        }

        $widget_data=$this->basic->get_data("widget",array("where"=>array("id"=>$id)));
        if(isset($widget_data[0])) $info=$widget_data[0];
        else
        {
            echo "No widget found.";
            exit();
        }

        $this->session->set_userdata("user_id",$user_id);
        if($this->session->userdata('download_id_front')=="")
        $this->session->set_userdata('download_id_front', md5(time()).$this->_random_number_generator(10));

        $data=array();
        $data["info"]=$info;
        $this->session->unset_userdata("output");



        $this->load->view("widget/page_search_widget",$data);

    }


    public function bulk_page_search_progress_count()
    { 
        $bulk_counting_search=$this->session->userdata('page_search_counting_search');
        $completed_search=$this->session->userdata('page_search_completed');
        
        $response['search_counting']=$bulk_counting_search;
        $response['search_completed']=$completed_search;
        
        echo json_encode($response);        
    }

    public function page_search_widget_action()
    {
      
        $this->load->library('fb_search');
        $keyword=$this->input->post('keyword', true);
        $email_id=$this->input->post("email");
        $name=$this->input->post("name");

        if($keyword=="" || $email_id=="" || $name=="") 
        exit();
  
        $download_id=$this->session->userdata('download_id_front');
        $fp = fopen("download/page_search/page_search_{$download_id}.csv", "w");
        fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
        
        $write_data=array();            
        $write_data[]="Keyword"; 
        $write_data[]="Page Name"; 
        $write_data[]="Fan Count"; 
        $write_data[]="Website"; 
        $write_data[]="Phone"; 
        $write_data[]="Founded At"; 
        $write_data[]="Category"; 
        $write_data[]="Is Verified";
        $write_data[]="Email";
        $write_data[]="Searched Date"; 
        fputcsv($fp, $write_data);

        $this->session->unset_userdata('page_search_completed');
        $this->session->unset_userdata('page_search_counting_search');
        $page_search_data=$this->fb_search->page_search($keyword);

        $count_val=0;
        if(is_array($page_search_data) && isset($page_search_data['data']) && count($page_search_data['data'])>0)
        $count_val = count($page_search_data['data'][0]);
        
        $str="<h3 class='text-center'>".$count_val." ".$this->lang->line("results found")."</h3><hr/>";


        if(isset($page_search_data['data'][0]) && count($page_search_data['data'][0])==0) $str="0";

 
        foreach($page_search_data['data'] as $value1)
        {
            
            foreach($value1 as $value2)
            {
                $insert_data['search_keyword'] = $keyword;
                $insert_data['user_id'] = $this->session->userdata("user_id");
                $insert_data['searched_at'] = date("Y-m-d");
                if(isset($value2['phone']))
                    $insert_data['phone'] = $value2['phone'];

                if(isset($value2['page_id']))
                    $insert_data['page_id'] = $value2['page_id'];

                if(isset($value2['name']))
                    $insert_data['name'] = $value2['name'];

                if(isset($value2['emails']))
                    $insert_data['emails'] = json_encode($value2['emails']);

                if(isset($value2['website']))
                    $insert_data['website'] = $value2['website'];

                if(isset($value2['likes']))
                    $insert_data['likes'] = json_encode($value2['likes']);

                if(isset($value2['about']))
                    $insert_data['about'] = $value2['about'];

                if(isset($value2['founded']))
                    $insert_data['founded'] = $value2['founded'];

                if(isset($value2['category']))
                    $insert_data['category'] = $value2['category'];

                if(isset($value2['location']))
                    $insert_data['location'] = json_encode($value2['location']);

                if(isset($value2['posts']))
                    $insert_data['posts'] = json_encode($value2['posts']);

                if(isset($value2['cover']))
                    $insert_data['cover'] = json_encode($value2['cover']);

                if(isset($value2['picture']))
                    $insert_data['picture'] = json_encode($value2['picture']);

                if(isset($value2['is_always_open']))
                    $insert_data['is_always_open'] = $value2['is_always_open'];

                if(isset($value2['is_community_page']))
                    $insert_data['is_community_page'] = $value2['is_community_page'];

                if(isset($value2['is_verified']))
                    $insert_data['is_verified'] = $value2['is_verified'];

                if(isset($value2['mission']))
                    $insert_data['mission'] = $value2['mission'];

                if(isset($value2['start_info']))
                    $insert_data['start_info'] = json_encode($value2['start_info']);

                if(isset($value2['username']))
                    $insert_data['username'] = $value2['username'];

                if(isset($value2['talking_about_count']))
                    $insert_data['talking_about_count'] = $value2['talking_about_count'];
                
                if(isset($value2['link']))
                    $insert_data['link'] = $value2['link'];

                if(isset($value2['is_published']))
                    $insert_data['is_published'] = $value2['is_published'];

                if(isset($value2['is_unclaimed']))
                    $insert_data['is_unclaimed'] = $value2['is_unclaimed'];

                if(isset($value2['can_post']))
                    $insert_data['can_post'] = $value2['can_post'];

                if(isset($value2['can_checkin']))
                    $insert_data['can_checkin'] = $value2['can_checkin'];

                if(isset($value2['fan_count']))
                    $insert_data['fan_count'] = $value2['fan_count'];

                if($this->basic->insert_data('page_search', $insert_data))
                {
                    $insert_id = $this->db->insert_id();
                    $write_data=array();
                    $write_data[]=$keyword;
                    $write_name = '';

                    if(isset($value2['name'])) $write_name = $value2['name'];
                    $write_data[]=$write_name;

                    $fan_count = '';
                    if(isset($value2['fan_count'])) $fan_count = $value2['fan_count'];
                    $write_data[]=$fan_count;

                    $website = '';
                    if(isset($value2['website'])) $website = $value2['website'];
                    $write_data[]=$website;

                    $phone = '';
                    if(isset($value2['phone'])) $phone = $value2['phone'];
                    $write_data[]=$phone;

                    $founded = '';
                    if(isset($value2['founded'])) $founded = $value2['founded'];
                    $write_data[]=$founded;

                    $category = '';
                    if(isset($value2['category'])) $category = $value2['category'];
                    $write_data[]=$category;

                    $is_verified = '';
                    if(isset($value2['is_verified'])) $is_verified = $value2['is_verified'];
                    $write_data[]=$is_verified;
                    
                    $emails = array();
                    if(isset($value2['emails']))
                        $emails = $value2['emails'];
                    if(!empty($emails))
                        $email = $emails[0];
                    else $email = '';
                    $write_data[]=$email;
                    $write_data[]=date("Y-m-d");
                    fputcsv($fp, $write_data);
                    
                }

            }
        }

        if($str!="0")
        $str .= "</table>";

        fclose($fp);
        
        //******************************//
        // insert data to useges log table
        $this->_insert_usage_log($module_id=1,$request=1);   
        //******************************//

        $lead_config=$this->basic->get_data("lead_config");
        if(is_array($lead_config) && isset($lead_config[0]))
        $allowed_download_per_email=$lead_config[0]["allowed_download_per_email"];
        else $allowed_download_per_email=10; 

        $product=$this->config->item('product_name');
        $subject=$product." | "."Page Search Result";
        $download_link="<a href='".base_url().'download/page_search/page_search_'.$this->session->userdata('download_id_front').'.csv'."'>Download Page Search Result</a>";
        $message="Hello {$name}, <br/> Thank you for using {$product}.<br/> Please follow the link to download your search result: {$download_link}<br/><br/><br/>{$product}";
        $data=array("firstname"=>$name,"email"=>$email_id);
        
        if($this->basic->is_exist($table="leads",$where=array("email"=>$email_id,"no_of_search >="=>$allowed_download_per_email),$select="id"))
        $ret_val= "0"; // crossed limit
         
        else if($this->basic->is_exist($table="leads",$where=array("email"=>$email_id,"no_of_search <"=>$allowed_download_per_email),$select="id"))
        {
            $this->basic->execute_complex_query("UPDATE leads SET name='".$name."',no_of_search=no_of_search+1,date_time='".date("Y-d-m G:i:s")."' WHERE email='".$email_id."'");
            $ret_val= "1"; // updated               
        }
        else 
        {
            $this->basic->insert_data("leads",array("name"=>$name,"email"=>$email_id,"date_time"=>date("Y-d-m G:i:s")));            
            $this->fb_search->syncMailchimp($data);
            $ret_val= "2"; // inserted
        }

        if($ret_val=="1" || $ret_val=="2")
        $this->_mail_sender($from = '', $to = $email_id, $subject, $message, $mask = $product, $html = 1);


        $str2="";
        if($ret_val=="0")
        {
            $str2= "<div class='alert alert-danger text-center'>".$this->lang->line('you can not download more result using this email, download quota is crossed')."</div>";
        }                   
        else
        {
            $str2= "<div class='alert alert-success text-center'>".$this->lang->line('a email has been sent to your email')."</div>";
        }

        echo $output=$str2.$str;
        // $this->session->set_userdata("output",$output);

        // return $this->page_search_widget($this->session->userdata('user_id'),$this->session->userdata('domain_name'));
    }

  

    
}
