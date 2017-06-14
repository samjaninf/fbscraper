<?php if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
* @category controller
* class home
*/
class home extends CI_Controller
{

    /**
    * load constructor
    * @access public
    * @return void
    */
    public $module_access;
    public $language;
    public $is_rtl;

    public $is_ad_enabled;
    public $is_ad_enabled1;
    public $is_ad_enabled2;
    public $is_ad_enabled3;
    public $is_ad_enabled4; 

    public $ad_content1;
    public $ad_content1_mobile;
    public $ad_content2;
    public $ad_content3;
    public $ad_content4;

    public function __construct()
    {
        parent::__construct();
        set_time_limit(0);
        $this->load->helpers('my_helper');

        $this->is_rtl=FALSE;
        $this->language="";
        $this->_language_loader();

        $this->is_ad_enabled=false;
        $this->is_ad_enabled1=false;
        $this->is_ad_enabled2=false;
        $this->is_ad_enabled3=false;
        $this->is_ad_enabled4=false; 

        $this->ad_content1="";
        $this->ad_content1_mobile="";
        $this->ad_content2="";
        $this->ad_content3="";
        $this->ad_content4="";

		ignore_user_abort(TRUE);

        $seg = $this->uri->segment(2);
        if ($seg!="installation" && $seg!= "installation_action") {
            if (file_exists(APPPATH.'install.txt')) {
                redirect('home/installation', 'location');
            }
        }

        if (!file_exists(APPPATH.'install.txt')) {
            $this->load->database();
            $this->load->model('basic');
        	
            $this->_time_zone_set();
            $this->load->library('upload');
            $this->upload_path = realpath(APPPATH . '../upload');
			$query = 'SET SESSION group_concat_max_len=9990000000000000000';
       		$this->db->query($query);
            $query="SET SESSION sql_mode = ''";
            $this->db->query($query);

            if(function_exists('ini_set'))
            ini_set('memory_limit', '-1');
        

            $ad_config = $this->basic->get_data("ad_config");           
            if(isset($ad_config[0]["status"]))
            {
               if($ad_config[0]["status"]=="1")
               {
                    $this->is_ad_enabled = ($ad_config[0]["status"]=="1") ? true : false; 
                    if($this->is_ad_enabled) 
                    {
                        $this->is_ad_enabled1 = ($ad_config[0]["section1_html"]=="" && $ad_config[0]["section1_html_mobile"]=="") ? false : true; 
                        $this->is_ad_enabled2 = ($ad_config[0]["section2_html"]=="") ? false : true; 
                        $this->is_ad_enabled3 = ($ad_config[0]["section3_html"]=="") ? false : true; 
                        $this->is_ad_enabled4 = ($ad_config[0]["section4_html"]=="") ? false : true;

                        $this->ad_content1          = htmlspecialchars_decode($ad_config[0]["section1_html"],ENT_QUOTES);
                        $this->ad_content1_mobile   = htmlspecialchars_decode($ad_config[0]["section1_html_mobile"],ENT_QUOTES);
                        $this->ad_content2          = htmlspecialchars_decode($ad_config[0]["section2_html"],ENT_QUOTES);
                        $this->ad_content3          = htmlspecialchars_decode($ad_config[0]["section3_html"],ENT_QUOTES);
                        $this->ad_content4          = htmlspecialchars_decode($ad_config[0]["section4_html"],ENT_QUOTES);
                    }
               }

            }
            else
            {
                $this->is_ad_enabled  = true;   
                $this->is_ad_enabled1 = true;
                $this->is_ad_enabled2 = true;
                $this->is_ad_enabled3 = true;
                $this->is_ad_enabled4 = true;

                $this->ad_content1="<img src='".base_url('assets/images/placeholder/reserved-section-1.png')."'>";
                $this->ad_content1_mobile="<img src='".base_url('assets/images/placeholder/reserved-section-1-mobile.png')."'>";
                $this->ad_content2="<img src='".base_url('assets/images/placeholder/reserved-section-2.png')."'>";
                $this->ad_content3="<img src='".base_url('assets/images/placeholder/reserved-section-3.png')."'>";
                $this->ad_content4="<img src='".base_url('assets/images/placeholder/reserved-section-4.png')."'>";

            }

            if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') != 'Admin')
            {
                $package_info=$this->session->userdata("package_info");
                $module_ids='';
                if(isset($package_info["module_ids"])) $module_ids=$package_info["module_ids"];
                $this->module_access=explode(',', $module_ids);
            }

        }

    }




    public function _insert_usage_log($module_id=0,$usage_count=0,$user_id=0)
    {

        if($module_id==0 || $usage_count==0) return false;
        if($user_id==0) $user_id=$this->session->userdata("user_id");
        if($user_id==0 || $user_id=="") return false;

        $usage_month=date("n");
        $usage_year=date("Y");
        $where=array("module_id"=>$module_id,"user_id"=>$user_id,"usage_month"=>$usage_month,"usage_year"=>$usage_year);

        $insert_data=array("module_id"=>$module_id,"user_id"=>$user_id,"usage_month"=>$usage_month,"usage_year"=>$usage_year,"usage_count"=>$usage_count);
        
        if($this->basic->is_exist("view_usage_log",$where))
        {
        	$this->db->set('usage_count', 'usage_count+'.$usage_count, FALSE);
			$this->db->where($where);
			$this->db->update('usage_log');
        }
        else $this->basic->insert_data("usage_log",$insert_data);

        return true;
    }


    public function _check_usage($module_id=0,$request=0,$user_id=0)
    {
        
        if($module_id==0 || $request==0) return "0";
        if($user_id==0) $user_id=$this->session->userdata("user_id");
        if($user_id==0 || $user_id=="") return false;

        $usage_month=date("n");
        $usage_year=date("Y");
        $info=$this->basic->get_data("view_usage_log",$where=array("where"=>array("usage_month"=>$usage_month,"usage_year"=>$usage_year,"module_id"=>$module_id,"user_id"=>$user_id)));
        $usage_count=0;
        if(isset($info[0]["usage_count"]))
        $usage_count=$info[0]["usage_count"];

        $monthly_limit=array();
        $module_ids=array();

        if($this->session->userdata("package_info")!="")
        {
            $package_info=$this->session->userdata("package_info");  
            if($this->session->userdata('user_type') == 'Admin') return "1"; 
        }
        else
        {
            $package_data = $this->basic->get_data("users", $where=array("where"=>array("users.id"=>$user_id)),"package.*,users.user_type",array('package'=>"users.package_id=package.id,left"));
            $package_info=array();
            if(array_key_exists(0, $package_data))
            $package_info=$package_data[0];   
            if($package_info['user_type'] == 'Admin') return "1";     
        }

        if(isset($package_info["monthly_limit"])) $monthly_limit=json_decode($package_info["monthly_limit"],true);
        if(isset($package_info["module_ids"]))    $module_ids=explode(',', $package_info["module_ids"]);

        $return = "0";
        if(in_array($module_id, $module_ids) && $monthly_limit[$module_id] > 0 && $monthly_limit[$module_id]<($request+$usage_count))
         $return = "3"; // montly limit crossed | 0 means unlimited
        else  $return = "1"; //success  

        return $return;     
    }

    

    public function print_limit_message($module_id=0,$request=0)
    {
        $status=$this->_check_usage($module_id,$request);
        if($status=="2") 
        {
        	echo $this->lang->line("sorry, your bulk limit is exceeded for this this module.")."<a href='".site_url('usage_history')."'>".$this->lang->line("click here to see usage log")."</a>";
        	exit();
        }
        else if($status=="3") 
        {
        	echo $this->lang->line("sorry, your monthly limit is exceeded for this this module.")."<a href='".site_url('usage_history')."'>".$this->lang->line("click here to see usage log")."</a>";
        	exit();
        }
      
    }




    public function _language_loader()
    {       

        if(!$this->config->item("language") || $this->config->item("language")=="")
        $this->language="english";
        else $this->language=$this->config->item('language');

        if($this->session->userdata("selected_language")!="")
        $this->language = $this->session->userdata("selected_language");
        else if(!$this->config->item("language") || $this->config->item("language")=="") 
        $this->language="english";
        else $this->language=$this->config->item('language');

        if($this->language=="arabic")
        $this->is_rtl=TRUE;

        if (file_exists(APPPATH.'language/'.$this->language.'/front_lang.php'))
        $this->lang->load('front', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/sidebar_lang.php'))
        $this->lang->load('sidebar', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/common_lang.php'))
        $this->lang->load('common', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/message_lang.php'))
        $this->lang->load('message', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/admin_lang.php'))
        $this->lang->load('admin', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/calendar_lang.php'))
        $this->lang->load('calendar', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/date_lang.php'))
        $this->lang->load('date', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/db_lang.php'))
        $this->lang->load('db', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/email_lang.php'))
        $this->lang->load('email', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/form_validation_lang.php'))
        $this->lang->load('form_validation', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/ftp_lang.php'))
        $this->lang->load('ftp', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/imglib_lang.php'))
        $this->lang->load('imglib', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/migration_lang.php'))
        $this->lang->load('migration', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/number_lang.php'))
        $this->lang->load('number', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/pagination_lang.php'))
        $this->lang->load('pagination', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/profiler_lang.php'))
        $this->lang->load('profiler', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/unit_test_lang.php'))
        $this->lang->load('unit_test', $this->language);
        
        if (file_exists(APPPATH.'language/'.$this->language.'/upload_lang.php'))
        $this->lang->load('upload', $this->language);     

        if (file_exists(APPPATH.'language/'.$this->language.'/widget_dashboard_lang.php'))
        $this->lang->load('widget_dashboard', $this->language);  

        if (file_exists(APPPATH.'language/'.$this->language.'/captcha_lang.php'))
        $this->lang->load('captcha', $this->language);  

        if (file_exists(APPPATH.'language/'.$this->language.'/page_insight_lang.php'))
        $this->lang->load('page_insight', $this->language); 
        
        if (file_exists(APPPATH.'language/'.$this->language.'/misc_lang.php'))
        $this->lang->load('misc', $this->language);    

        if (file_exists(APPPATH.'language/'.$this->language.'/misc2_lang.php'))
        $this->lang->load('misc2', $this->language);    
    }

    /**
    * method to install software
    * @access public
    * @return void
    */
    public function installation()
    {
        if (!file_exists(APPPATH.'install.txt')) {
            redirect('home/login', 'location');
        }
        $data = array("body" => "page/install", "page_title" => "Install Package","language_info" => $this->_language_list());
        $this->_front_viewcontroller($data);
    }

    /**
    * method to installation action
    * @access public
    * @return void
    */
    public function installation_action()
    {
        if (!file_exists(APPPATH.'install.txt')) {
            redirect('home/login', 'location');
        }

        if ($_POST) {
            // validation
            $this->form_validation->set_rules('host_name',               '<b>Host Name</b>',                   'trim|required|xss_clean');
            $this->form_validation->set_rules('database_name',           '<b>Database Name</b>',               'trim|required|xss_clean');
            $this->form_validation->set_rules('database_username',       '<b>Database Username</b>',           'trim|required|xss_clean');
            $this->form_validation->set_rules('database_password',       '<b>Database Password</b>',           'trim|xss_clean');
            $this->form_validation->set_rules('app_username',            '<b>Admin Panel Login Email</b>',     'trim|required|valid_email|xss_clean');
            $this->form_validation->set_rules('app_password',            '<b>Admin Panel Login Password</b>',  'trim|required|xss_clean');
            $this->form_validation->set_rules('institute_name',          '<b>Company Name</b>',                'trim|xss_clean');
            $this->form_validation->set_rules('institute_address',       '<b>Company Address</b>',             'trim|xss_clean');
            $this->form_validation->set_rules('institute_mobile',        '<b>Company Phone / Mobile</b>',      'trim|xss_clean');
            $this->form_validation->set_rules('language',                '<b>Language</b>',                    'trim');

            // go to config form page if validation wrong
            if ($this->form_validation->run() == false) {
                return $this->installation();
            } else {
                $host_name = addslashes(strip_tags($this->input->post('host_name', true)));
                $database_name = addslashes(strip_tags($this->input->post('database_name', true)));
                $database_username = addslashes(strip_tags($this->input->post('database_username', true)));
                $database_password = addslashes(strip_tags($this->input->post('database_password', true)));
                $app_username = addslashes(strip_tags($this->input->post('app_username', true)));
                $app_password = addslashes(strip_tags($this->input->post('app_password', true)));
                $institute_name = addslashes(strip_tags($this->input->post('institute_name', true)));
                $institute_address = addslashes(strip_tags($this->input->post('institute_address', true)));
                $institute_mobile = addslashes(strip_tags($this->input->post('institute_mobile', true)));
                $language = addslashes(strip_tags($this->input->post('language', true)));

                $con=@mysqli_connect($host_name, $database_username, $database_password);
                if (!$con) {
                    $this->session->set_userdata('mysql_error', "Could not conenect to MySQL.");
                    return $this->installation();
                }
                if (!@mysqli_select_db($con,$database_name)) {
                    $this->session->set_userdata('mysql_error', "Database not found.");
                    return $this->installation();
                }
                mysqli_close($con);

                 // writing application/config/my_config
                  $app_my_config_data = "<?php ";
                $app_my_config_data.= "\n\$config['default_page_url'] = '".$this->config->item('default_page_url')."';\n";
                $app_my_config_data.= "\$config['product_name'] = '".$this->config->item('product_name')."';\n";
                $app_my_config_data.= "\$config['product_short_name'] = '".$this->config->item('product_short_name')."' ;\n";
                $app_my_config_data.= "\$config['product_version'] = '".$this->config->item('product_version')." ';\n\n";
                $app_my_config_data.= "\$config['institute_address1'] = '$institute_name';\n";
                $app_my_config_data.= "\$config['institute_address2'] = '$institute_address';\n";
                $app_my_config_data.= "\$config['institute_email'] = '$app_username';\n";
                $app_my_config_data.= "\$config['institute_mobile'] = '$institute_mobile';\n";
                $app_my_config_data.= "\$config['developed_by'] = '".$this->config->item('developed_by')."';\n";
                $app_my_config_data.= "\$config['developed_by_href'] = '".$this->config->item('developed_by_href')."';\n";
                $app_my_config_data.= "\$config['developed_by_title'] = '".$this->config->item('developed_by_title')."';\n";
                $app_my_config_data.= "\$config['developed_by_prefix'] = '".$this->config->item('developed_by_prefix')."' ;\n";
                $app_my_config_data.= "\$config['support_email'] = '".$this->config->item('support_email')."' ;\n";
                $app_my_config_data.= "\$config['support_mobile'] = '".$this->config->item('support_mobile')."' ;\n";
                $app_my_config_data.= "\$config['time_zone'] = '' ;\n";                
                $app_my_config_data.= "\$config['language'] = '$language';\n";
                $app_my_config_data.= "\$config['sess_use_database'] = TRUE;\n";
                $app_my_config_data.= "\$config['sess_table_name'] = 'ci_sessions';\n";
                file_put_contents(APPPATH.'config/my_config.php', $app_my_config_data, LOCK_EX);
                  //writting  application/config/my_config

                  //writting application/config/database
                $database_data = "";
                $database_data.= "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n
                    \$active_group = 'default';
                    \$active_record = true;
                    \$db['default']['hostname'] = '$host_name';
                    \$db['default']['username'] = '$database_username';
                    \$db['default']['password'] = '$database_password';
                    \$db['default']['database'] = '$database_name';
                    \$db['default']['dbdriver'] = 'mysqli';
                    \$db['default']['dbprefix'] = '';
                    \$db['default']['pconnect'] = TRUE;
                    \$db['default']['db_debug'] = TRUE;
                    \$db['default']['cache_on'] = FALSE;
                    \$db['default']['cachedir'] = '';
                    \$db['default']['char_set'] = 'utf8';
                    \$db['default']['dbcollat'] = 'utf8_general_ci';
                    \$db['default']['swap_pre'] = '';
                    \$db['default']['autoinit'] = TRUE;
                    \$db['default']['stricton'] = FALSE;";
                file_put_contents(APPPATH.'config/database.php', $database_data, LOCK_EX);
                  //writting application/config/database

                  // loding database library, because we need to run queries below and configs are already written

                $this->load->database();
                $this->load->model('basic');
                  // loding database library, because we need to run queries below and configs are already written

                  // dumping sql
                $dump_file_name = 'initial_db.sql';
                $dump_sql_path = 'assets/backup_db/'.$dump_file_name;
                $this->basic->import_dump($dump_sql_path);
                  // dumping sql

                  //generating hash password for admin and updaing database
                $app_password = md5($app_password);
                $this->basic->update_data($table = "users", $where = array("user_type" => "Admin"), $update_data = array("mobile" => $institute_mobile, "email" => $app_username, "password" => $app_password, "name" => $institute_name, "status" => "1", "deleted" => "0", "address" => $institute_address));
                  //generating hash password for admin and updaing database

                  //deleting the install.txt file,because installation is complete
                  if (file_exists(APPPATH.'install.txt')) {
                      unlink(APPPATH.'install.txt');
                  }
                  //deleting the install.txt file,because installation is complete
                  redirect('home/login');
            }
        }
    }


    /**
    * method to index page
    * @access public
    * @return void
    */
    public function index()
    {
        // $this->login_page();
        $this->_site_viewcontroller();
    }

    
    /**
    * method to set time zone
    * @access public
    * @return void
    */
    public function _time_zone_set()
    {
       $time_zone = $this->config->item('time_zone');
        if ($time_zone== '') {
            $time_zone="Europe/Dublin";
        }
        date_default_timezone_set($time_zone);
    }


    /**
    * method to show time zone list
    * @access public
    * @return array
    */    
    public function _time_zone_list()
    {
        $all_time_zone=array(
            'Kwajalein'                    => 'GMT -12.00 Kwajalein',
            'Pacific/Midway'                => 'GMT -11.00 Pacific/Midway',
            'Pacific/Honolulu'                => 'GMT -10.00 Pacific/Honolulu',
            'America/Anchorage'            => 'GMT -9.00  America/Anchorage',
            'America/Los_Angeles'            => 'GMT -8.00  America/Los_Angeles',
            'America/Denver'                => 'GMT -7.00  America/Denver',
            'America/Tegucigalpa'            => 'GMT -6.00  America/Tegucigalpa',
            'America/New_York'                => 'GMT -5.00  America/New_York',
            'America/Caracas'                => 'GMT -4.30  America/Caracas',
            'America/Halifax'                => 'GMT -4.00  America/Halifax',
            'America/St_Johns'                => 'GMT -3.30  America/St_Johns',
            'America/Argentina/Buenos_Aires'=> 'GMT +-3.00 America/Argentina/Buenos_Aires',
            'America/Sao_Paulo'            =>' GMT -3.00  America/Sao_Paulo',
            'Atlantic/South_Georgia'        => 'GMT +-2.00 Atlantic/South_Georgia',
            'Atlantic/Azores'                => 'GMT -1.00  Atlantic/Azores',
            'Europe/Dublin'                => 'GMT 	   Europe/Dublin',
            'Europe/Belgrade'                => 'GMT +1.00  Europe/Belgrade',
            'Europe/Minsk'                    => 'GMT +2.00  Europe/Minsk',
            'Asia/Kuwait'                    => 'GMT +3.00  Asia/Kuwait',
            'Asia/Tehran'                    => 'GMT +3.30  Asia/Tehran',
            'Asia/Muscat'                    => 'GMT +4.00  Asia/Muscat',
            'Asia/Yekaterinburg'            => 'GMT +5.00  Asia/Yekaterinburg',
            'Asia/Kolkata'                    => 'GMT +5.30  Asia/Kolkata',
            'Asia/Katmandu'                => 'GMT +5.45  Asia/Katmandu',
            'Asia/Dhaka'                    => 'GMT +6.00  Asia/Dhaka',
            'Asia/Rangoon'                    => 'GMT +6.30  Asia/Rangoon',
            'Asia/Krasnoyarsk'                => 'GMT +7.00  Asia/Krasnoyarsk',
            'Asia/Brunei'                    => 'GMT +8.00  Asia/Brunei',
            'Asia/Seoul'                    => 'GMT +9.00  Asia/Seoul',
            'Australia/Darwin'                => 'GMT +9.30  Australia/Darwin',
            'Australia/Canberra'            => 'GMT +10.00 Australia/Canberra',
            'Asia/Magadan'                    => 'GMT +11.00 Asia/Magadan',
            'Pacific/Fiji'                    => 'GMT +12.00 Pacific/Fiji',
            'Pacific/Tongatapu'            => 'GMT +13.00 Pacific/Tongatapu'
        );

        return $all_time_zone;
    }

    /**
    * method to disable cache
    * @access public
    * @return void
    */
    public function _disable_cache()
    {
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    /**
    * method to
    * @access public
    * @return void
    */     
    public function access_forbidden()
    {
        $this->load->view('page/access_forbidden');
    }

    /**
    * method to load front viewcontroller
    * @access public
    * @return void
    */
    public function _front_viewcontroller($data=array())
    {
        // $this->_disable_cache();
        if (!isset($data['body'])) {
            $data['body']=$this->config->item('default_page_url');
        }
    
        if (!isset($data['page_title'])) {
            $data['page_title']="";
        }

        $this->load->view('front/theme_front', $data);
    }

    
    public function _viewcontroller($data=array())
    {
        if (!isset($data['body'])) {
            $data['body']=$this->config->item('default_page_url');
        }
    
        if (!isset($data['page_title'])) {
            $data['page_title']="Admin Panel";
        }

        if (!isset($data['crud'])) {
            $data['crud']=0;
        }
        // fetch all pending student queries to show in admin notification area
        //$data['student_query_notifications']=$this->_admin_notifications();
        $data["language_info"] = $this->_language_list();
        $this->load->view('admin/theme/theme', $data);
    }



    public function _site_viewcontroller($data=array())
    {
        if (!isset($data['page_title'])) {
            $data['page_title']="";
        }
        if (!isset($data['body'])) {
            $data['body']="site/index";
        }

        $config_data=array();
        $price=0;
        $currency="USD";
        $config_data=$this->basic->get_data("payment_config");
        if(array_key_exists(0,$config_data)) 
        {          
            $currency=$config_data[0]['currency'];
        }
        $data['price']=$price;
        $data['currency']=$currency;




        $config_data_captcha=array();
        $recaptcha_site_key="";
        $recaptcha_secret_key="";
        $config_data_captcha=$this->basic->get_data("connectivity_config");
        if(array_key_exists(0,$config_data_captcha)) 
        {          
            $recaptcha_site_key=$config_data_captcha[0]['recaptcha_site_key'];
            $recaptcha_secret_key=$config_data_captcha[0]['recaptcha_secret_key'];
        }
        $data['recaptcha_site_key']=$recaptcha_site_key;
        $data['recaptcha_secret_key']=$recaptcha_secret_key;



        //catcha for contact page
        $this->load->helper('captcha');
        $random_number = $this->_random_number_generator(4);
        $vals = array(
                 'word' => $random_number,
                 'img_path' => './download/captcha/',
                 'img_url' => base_url().'download/captcha/',
                 'img_width' => 150,
                 'img_height' => 45,
                 'expiration' => 7200
                );
        $data['captcha'] = create_captcha($vals);
        $this->session->set_userdata('captchaWord',$data['captcha']['word']);

        $data["language_info"] = $this->_language_list();
        $data["payment_package"]=$this->basic->get_data("package",$where=array("where"=>array("is_default"=>"0","price > "=>0,"validity >"=>0)),$select='',$join='',$limit='',$start=NULL,$order_by='CAST(`price` AS SIGNED)');         
        $data["default_package"]=$this->basic->get_data("package",$where=array("where"=>array("is_default"=>"1","validity >"=>0,"price"=>"Trial")));        

        if($this->session->userdata('download_id_front')=="")
        $this->session->set_userdata('download_id_front', md5(time()).$this->_random_number_generator(10));

        if($data['body']=="site/index")
        $data["recent_search"]=$this->basic->get_data($table="page_search_guest",$where='',$select=array("search_keyword","searched_at","count(id) as total_count"),$join='',$limit='25',$start=NULL,$order_by='id DESC',$group_by='search_keyword');

        $this->load->view('site/site_theme', $data);
    }



    public function login_page()
    {
        if (file_exists(APPPATH.'install.txt')) {
            redirect('home/installation', 'location');
        }

        if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Admin') {
            redirect('dashboard/index', 'location');
        }
        if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Member') {
            redirect('dashboard/index', 'location');
        }
                
        $this->load->view('page/login');
    }
    
    public function login() //loads home view page after login (this )
    {
        if (file_exists(APPPATH.'install.txt')) {
            redirect('home/installation', 'location');
        }

        if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Admin') {
         redirect('dashboard/index', 'location');
        }
        if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Member') {
            redirect('dashboard/index', 'location');
        }



        $this->form_validation->set_rules('username', '<b>'.$this->lang->line("email").'</b>', 'trim|required|xss_clean|valid_email');
        $this->form_validation->set_rules('password', '<b>'.$this->lang->line("password").'</b>', 'trim|required|xss_clean');

        if ($this->form_validation->run() == false) {
            $this->load->view('page/login');
        } else {
            $username = $this->input->post('username', true);
            $password = md5($this->input->post('password', true));

            $table = 'users';
            $where['where'] = array('email' => $username, 'password' => $password, "deleted" => "0","status"=>"1");

            $info = $this->basic->get_data($table, $where, $select = '', $join = '', $limit = '', $start = '', $order_by = '', $group_by = '', $num_rows = 1);

            $count = $info['extra_index']['num_rows'];
            
            if ($count == 0) {
                $this->session->set_flashdata('login_msg', $this->lang->line("invalid email or password"));
                redirect(uri_string());
            } else {
                $username = $info[0]['name'];
                $user_type = $info[0]['user_type'];
                $user_id = $info[0]['id'];

                $this->session->set_userdata('logged_in', 1);
                $this->session->set_userdata('username', $username);
                $this->session->set_userdata('user_type', $user_type);
                $this->session->set_userdata('user_id', $user_id);
                $this->session->set_userdata('download_id', time());
                $this->session->set_userdata('expiry_date',$info[0]['expired_date']);

                $package_info = $this->basic->get_data("package", $where=array("where"=>array("id"=>$info[0]["package_id"])));
                $package_info_session=array();
                if(array_key_exists(0, $package_info))
                $package_info_session=$package_info[0];
                $this->session->set_userdata('package_info', $package_info_session);

                if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Admin') {
                 redirect('dashboard/index', 'location');
                }
                if ($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') == 'Member') {
                    redirect('dashboard/index', 'location');
                }
            }
        }
    }


    /**
    * method to load logout page
    * @access public
    * @return void
    */
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('home/login_page', 'location');
    }

    /**
    * method to generate random number
    * @access public
    * @param int
    * @return int
    */
    public function _random_number_generator($length=6)
    {
        $rand = substr(uniqid(mt_rand(), true), 0, $length);
        return $rand;
    }

  

    /**
    * method to load forgor password view page
    * @access public
    * @return void
    */
    public function forgot_password()
    {
        $data['body']='page/forgot_password';
        $data['page_title']=$this->lang->line("password recovery");
        $this->_front_viewcontroller($data);
    }

    /**
    * method to generate code
    * @access public
    * @return void
    */
    public function code_genaration()
    {
        $email = trim($this->input->post('email'));
        $result = $this->basic->get_data('users', array('where' => array('email' => $email)), array('count(*) as num'));

        if ($result[0]['num'] == 1) {
            //entry to forget_password table
            $expiration = date("Y-m-d H:i:s", strtotime('+1 day', time()));
            $code = $this->_random_number_generator();
            $url = "<a href='".site_url().'home/password_recovery'."'>".site_url().'home/password_recovery'."</a>";

            $table = 'forget_password';
            $info = array(
                'confirmation_code' => $code,
                'email' => $email,
                'expiration' => $expiration
                );

            if ($this->basic->insert_data($table, $info)) {
                //email to user
                $message = "<p>".$this->lang->line('to reset your password please perform the following steps')." : </p>
                            <ol>
                                <li>".$this->lang->line("go to this url")." : ".$url."</li>
                                <li>".$this->lang->line("enter this code")." : ".$code."</li>
                                <li>".$this->lang->line("reset your password")."</li>
                            <ol>
                            <h4>".$this->lang->line("link and code will be expired after 24 hours")."</h4>";


                $from = $this->config->item('institute_email');
                $to = $email;
                $subject = $this->config->item('product_name')." | ".$this->lang->line("password recovery");
                $mask = $subject;
                $html = 1;
                $this->_mail_sender($from, $to, $subject, $message, $mask, $html);
            }
        } else {
            echo 0;
        }
    }

    /**
    * method to password recovery
    * @access public
    * @return void
    */
    public function password_recovery()
    {
        $data['body']='page/password_recovery';
        $data['page_title']=$this->lang->line("password recovery");
        $this->_front_viewcontroller($data);
    }

    /**
    * method to check recovery
    * @access public
    * @return void
    */
    public function recovery_check()
    {
        if ($_POST) {
            $code=trim($this->input->post('code', true));
            $newp=md5($this->input->post('newp', true));
            $conf=md5($this->input->post('conf', true));

            $table='forget_password';
            $where['where']=array('confirmation_code'=>$code,'success'=>0);
            $select=array('email','expiration');

            $result=$this->basic->get_data($table, $where, $select);

            if (empty($result)) {
                echo 0;
            } else {
                foreach ($result as $row) {
                    $email=$row['email'];
                    $expiration=$row['expiration'];
                }

                $now=time();
                $exp=strtotime($expiration);

                if ($now>$exp) {
                    echo 1;
                } else {
                    $student_info_where['where'] = array('email'=>$email);
                    $student_info_select = array('id');
                    $student_info_id = $this->basic->get_data('users', $student_info_where, $student_info_select);
                    $this->basic->update_data('users', array('id'=>$student_info_id[0]['id']), array('password'=>$newp));
                    $this->basic->update_data('forget_password', array('confirmation_code'=>$code), array('success'=>1));
                    echo 2;
                }
            }
        }
    }


    /**
    * method to sent mail
    * @access public
    * @param string
    * @param string
    * @param string
    * @param string
    * @param string
    * @param int
    * @param int
    * @return boolean
    */
    function _mail_sender($from = '', $to = '', $subject = '', $message = '', $mask = "", $html = 0, $smtp = 1)
    {
        if ($to!= '' && $subject!='' && $message!= '') 
        {     

            if ($smtp == '1') {
                $where2 = array("where" => array('status' => '1','deleted' => '0'));
                $email_config_details = $this->basic->get_data("email_config", $where2, $select = '', $join = '', $limit = '', $start = '', $group_by = '', $num_rows = 0);

                if (count($email_config_details) == 0) {
                    $this->load->library('email');
                } else {
                    foreach ($email_config_details as $send_info) {
                        $send_email = trim($send_info['email_address']);
                        $smtp_host = trim($send_info['smtp_host']);
                        $smtp_port = trim($send_info['smtp_port']);
                        $smtp_user = trim($send_info['smtp_user']);
                        $smtp_password = trim($send_info['smtp_password']);
                    }

            /*****Email Sending Code ******/
                $config = array(
                  'protocol' => 'smtp',
                  'smtp_host' => "{$smtp_host}",
                  'smtp_port' => "{$smtp_port}",
                  'smtp_user' => "{$smtp_user}", // change it to yours
                  'smtp_pass' => "{$smtp_password}", // change it to yours
                  'mailtype' => 'html',
                  'charset' => 'utf-8',
                  'newline' =>  "\r\n",
                  'smtp_timeout' => '30'
                 );

                    $this->load->library('email', $config);
                }
            } /*** End of If Smtp== 1 **/

            if (isset($send_email) && $send_email!= "") {
                $from = $send_email;
            }
            $this->email->from($from, $mask);
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);
            if ($html == 1) {
                $this->email->set_mailtype('html');
            }

            if ($this->email->send()) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }


    /**
    * method to get email provider
    * @access public
    * @return array
    */
    public function get_email_providers()
    {
        $table='email_provider';
        $results=$this->basic->get_data($table);
        $email_provider=array();
        foreach ($results as $row) {
            $email_provider[$row['id']]=$row['provider_name'];
        }
        return $email_provider;
    }

    /**
    * method to get social networks
    * @access public
    * @return array
    */
    public function get_social_networks()
    {
        $table='social_network';
        $results=$this->basic->get_data($table);
        $social_network=array();
        foreach ($results as $row) {
            $social_network[$row['social_network_name']]=$row['social_network_name'];
        }
        return $social_network;
    }

    /**
    * method to get search engines
    * @access public
    * @return array
    */
    public function get_searche_engines()
    {
        $table='searh_engine';
        $results=$this->basic->get_data($table);
        $searh_engine=array();
        foreach ($results as $row) {
            $searh_engine[$row['search_engine_name']]=$row['search_engine_name'];
        }
        return $searh_engine;
    }

    public function download_page_loader()
    {
        $this->load->view('page/download');
    }


    public function read_text_file()
    {
    	
        if ( isset($_FILES['file_upload']) && $_FILES['file_upload']['size'] != 0 && ($_FILES['file_upload']['type'] =='text/plain' || $_FILES['file_upload']['type'] =='text/csv' || $_FILES['file_upload']['type'] =='text/csv' || $_FILES['file_upload']['type'] =='text/comma-separated-values' || $_FILES['file_upload']['type']='text/x-comma-separated-values')) 
        {
        
            $ext=array_pop(explode('.', $_FILES['file_upload']['name']));          
            $file_name = "tmp_".md5(time()).".".$ext;
            $config = array(
                "allowed_types" => "*",
                "upload_path" => "./upload/tmp/",
                "file_name" => $file_name,
                "overwrite" => true
            );
            $this->upload->initialize($config);
            $this->load->library('upload', $config);
            $this->upload->do_upload('file_upload');
            $path = realpath(FCPATH."upload/tmp/".$file_name);
            $read_handle=fopen($path, "r");
            $context ='';

            while (!feof($read_handle)) 
            {
                $information = fgetcsv($read_handle);
                if (!empty($information)) 
                {
                    foreach ($information as $info) 
                    {
                        if (!is_numeric($info)) 
                        $context.=$info."\n";                       
                    }
                }
            }
            $context = trim($context, "\n");
            echo $context;
        } 
        else 
        {
            echo "0";
        }
        
    }



    public function get_country_names()
    {
        $array_countries = array (
          'AF' => 'AFGHANISTAN',
          'AX' => 'ÅLAND ISLANDS',
          'AL' => 'ALBANIA',
          
          'DZ' => 'ALGERIA (El Djazaïr)',
          'AS' => 'AMERICAN SAMOA',
          'AD' => 'ANDORRA',
          'AO' => 'ANGOLA',
          'AI' => 'ANGUILLA',
          'AQ' => 'ANTARCTICA',
          'AG' => 'ANTIGUA AND BARBUDA',
          'AR' => 'ARGENTINA',
          'AM' => 'ARMENIA',
          'AW' => 'ARUBA',
          
          'AU' => 'AUSTRALIA',
          'AT' => 'AUSTRIA',
          'AZ' => 'AZERBAIJAN',
          'BS' => 'BAHAMAS',
          'BH' => 'BAHRAIN',
          'BD' => 'BANGLADESH',
          'BB' => 'BARBADOS',
          'BY' => 'BELARUS',
          'BE' => 'BELGIUM',
          'BZ' => 'BELIZE',
          'BJ' => 'BENIN',
          'BM' => 'BERMUDA',
          'BT' => 'BHUTAN',
          'BO' => 'BOLIVIA',
          
          'BA' => 'BOSNIA AND HERZEGOVINA',
          'BW' => 'BOTSWANA',
          'BV' => 'BOUVET ISLAND',
          'BR' => 'BRAZIL',

          'BN' => 'BRUNEI DARUSSALAM',
          'BG' => 'BULGARIA',
          'BF' => 'BURKINA FASO',
          'BI' => 'BURUNDI',
          'KH' => 'CAMBODIA',
          'CM' => 'CAMEROON',
          'CA' => 'CANADA',
          'CV' => 'CAPE VERDE',
          'KY' => 'CAYMAN ISLANDS',
          'CF' => 'CENTRAL AFRICAN REPUBLIC',
          'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE (formerly Zaire)',
          'CL' => 'CHILE',
          'CN' => 'CHINA',
          'CX' => 'CHRISTMAS ISLAND',
          
          'CO' => 'COLOMBIA',
          'KM' => 'COMOROS',
          'CG' => 'CONGO, REPUBLIC OF',
          'CK' => 'COOK ISLANDS',
          'CR' => 'COSTA RICA',
          'CI' => 'CÔTE D\'IVOIRE (Ivory Coast)',
          'HR' => 'CROATIA (Hrvatska)',
          'CU' => 'CUBA',
          'CW' => 'CURAÇAO',
          'CY' => 'CYPRUS',
          'CZ' => 'ZECH REPUBLIC',
          'DK' => 'DENMARK',
          'DJ' => 'DJIBOUTI',
          'DM' => 'DOMINICA',
          'DC' => 'DOMINICAN REPUBLIC',
          'EC' => 'ECUADOR',
          'EG' => 'EGYPT',
          'SV' => 'EL SALVADOR',
          'GQ' => 'EQUATORIAL GUINEA',
          'ER' => 'ERITREA',
          'EE' => 'ESTONIA',
          'ET' => 'ETHIOPIA',
          'FO' => 'FAEROE ISLANDS',

          'FJ' => 'FIJI',
          'FI' => 'FINLAND',
          'FR' => 'FRANCE',
          'GF' => 'FRENCH GUIANA',
          
          'GA' => 'GABON',
          'GM' => 'GAMBIA, THE',
          'GE' => 'GEORGIA',
          'DE' => 'GERMANY (Deutschland)',
          'GH' => 'GHANA',
          'GI' => 'GIBRALTAR',
          // 'GB' => 'UNITED KINGDOM',
          'GR' => 'GREECE',
          'GL' => 'GREENLAND',
          'GD' => 'GRENADA',
          'GP' => 'GUADELOUPE',
          'GU' => 'GUAM',
          'GT' => 'GUATEMALA',
          'GG' => 'GUERNSEY',
          'GN' => 'GUINEA',
          'GW' => 'GUINEA-BISSAU',
          'GY' => 'GUYANA',
          'HT' => 'HAITI',
          
          'HN' => 'HONDURAS',
          'HK' => 'HONG KONG (Special Administrative Region of China)',
          'HU' => 'HUNGARY',
          'IS' => 'ICELAND',
          'IN' => 'INDIA',
          'ID' => 'INDONESIA',
          'IR' => 'IRAN (Islamic Republic of Iran)',
          'IQ' => 'IRAQ',
          'IE' => 'IRELAND',
          'IM' => 'ISLE OF MAN',
          'IL' => 'ISRAEL',
          'IT' => 'ITALY',
          'JM' => 'JAMAICA',
          'JP' => 'JAPAN',
          'JE' => 'JERSEY',
          'JO' => 'JORDAN (Hashemite Kingdom of Jordan)',
          'KZ' => 'KAZAKHSTAN',
          'KE' => 'KENYA',
          'KI' => 'KIRIBATI',
          'KP' => 'KOREA (Democratic Peoples Republic of [North] Korea)',
          'KR' => 'KOREA (Republic of [South] Korea)',
          'KW' => 'KUWAIT',
          'KG' => 'KYRGYZSTAN',
          
          'LV' => 'LATVIA',
          'LB' => 'LEBANON',
          'LS' => 'LESOTHO',
          'LR' => 'LIBERIA',
          'LY' => 'LIBYA (Libyan Arab Jamahirya)',
          'LI' => 'LIECHTENSTEIN (Fürstentum Liechtenstein)',
          'LT' => 'LITHUANIA',
          'LU' => 'LUXEMBOURG',
          'MO' => 'MACAO (Special Administrative Region of China)',
          'MK' => 'MACEDONIA (Former Yugoslav Republic of Macedonia)',
          'MG' => 'MADAGASCAR',
          'MW' => 'MALAWI',
          'MY' => 'MALAYSIA',
          'MV' => 'MALDIVES',
          'ML' => 'MALI',
          'MT' => 'MALTA',
          'MH' => 'MARSHALL ISLANDS',
          'MQ' => 'MARTINIQUE',
          'MR' => 'MAURITANIA',
          'MU' => 'MAURITIUS',
          'YT' => 'MAYOTTE',
          'MX' => 'MEXICO',
          'FM' => 'MICRONESIA (Federated States of Micronesia)',
          'MD' => 'MOLDOVA',
          'MC' => 'MONACO',
          'MN' => 'MONGOLIA',
          'ME' => 'MONTENEGRO',
          'MS' => 'MONTSERRAT',
          'MA' => 'MOROCCO',
          'MZ' => 'MOZAMBIQUE (Moçambique)',
          'MM' => 'MYANMAR (formerly Burma)',
          'NA' => 'NAMIBIA',
          'NR' => 'NAURU',
          'NP' => 'NEPAL',
          'NL' => 'NETHERLANDS',
          'AN' => 'NETHERLANDS ANTILLES (obsolete)',
          'NC' => 'NEW CALEDONIA',
          'NZ' => 'NEW ZEALAND',
          'NI' => 'NICARAGUA',
          'NE' => 'NIGER',
          'NG' => 'NIGERIA',
          'NU' => 'NIUE',
          'NF' => 'NORFOLK ISLAND',
          'MP' => 'NORTHERN MARIANA ISLANDS',
          'ND' => 'NORWAY',
          'OM' => 'OMAN',
          'PK' => 'PAKISTAN',
          'PW' => 'PALAU',
          'PS' => 'PALESTINIAN TERRITORIES',
          'PA' => 'PANAMA',
          'PG' => 'PAPUA NEW GUINEA',
          'PY' => 'PARAGUAY',
          'PE' => 'PERU',
          'PH' => 'PHILIPPINES',
          'PN' => 'PITCAIRN',
          'PL' => 'POLAND',
          'PT' => 'PORTUGAL',
          'PR' => 'PUERTO RICO',
          'QA' => 'QATAR',
          'RE' => 'RÉUNION',
          'RO' => 'ROMANIA',
          'RU' => 'RUSSIAN FEDERATION',
          'RW' => 'RWANDA',
          'BL' => 'SAINT BARTHÉLEMY',
          'SH' => 'SAINT HELENA',
          'KN' => 'SAINT KITTS AND NEVIS',
          'LC' => 'SAINT LUCIA',
          
          'PM' => 'SAINT PIERRE AND MIQUELON',
          'VC' => 'SAINT VINCENT AND THE GRENADINES',
          'WS' => 'SAMOA (formerly Western Samoa)',
          'SM' => 'SAN MARINO (Republic of)',
          'ST' => 'SAO TOME AND PRINCIPE',
          'SA' => 'SAUDI ARABIA (Kingdom of Saudi Arabia)',
          'SN' => 'SENEGAL',
          'RS' => 'SERBIA (Republic of Serbia)',
          'SC' => 'SEYCHELLES',
          'SL' => 'SIERRA LEONE',
          'SG' => 'SINGAPORE',
          'SX' => 'SINT MAARTEN',
          'SK' => 'SLOVAKIA (Slovak Republic)',
          'SI' => 'SLOVENIA',
          'SB' => 'SOLOMON ISLANDS',
          'SO' => 'SOMALIA',
          'ZA' => 'ZAMBIA (formerly Northern Rhodesia)',
          'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
          'SS' => 'SOUTH SUDAN',
          'ES' => 'SPAIN (España)',
          'LK' => 'SRI LANKA (formerly Ceylon)',
          'SD' => 'SUDAN',
          'SR' => 'SURINAME',
          'SJ' => 'SVALBARD AND JAN MAYE',
          'SZ' => 'SWAZILAND',
          'SE' => 'SWEDEN',
          'CH' => 'SWITZERLAND (Confederation of Helvetia)',
          'SY' => 'SYRIAN ARAB REPUBLIC',
          'TW' => 'TAIWAN ("Chinese Taipei" for IOC)',
          'TJ' => 'TAJIKISTAN',
          'TZ' => 'TANZANIA',
          'TH' => 'THAILAND',
          'TL' => 'TIMOR-LESTE (formerly East Timor)',
          'TG' => 'TOGO',
          'TK' => 'TOKELAU',
          'TO' => 'TONGA',
          'TT' => 'TRINIDAD AND TOBAGO',
          'TN' => 'TUNISIA',
          'TR' => 'TURKEY',
          'TM' => 'TURKMENISTAN',
          'TC' => 'TURKS AND CAICOS ISLANDS',
          'TV' => 'TUVALU',
          'UG' => 'UGANDA',
          'UA' => 'UKRAINE',
          'AE' => 'UNITED ARAB EMIRATES',
          'US' => 'UNITED STATES',
          'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
          'UK' => 'UNITED KINGDOM',
          'UY' => 'URUGUAY',
          'UZ' => 'UZBEKISTAN',
          'VU' => 'VANUATU',
          'VA' => 'VATICAN CITY (Holy See)',
          'VN' => 'VIET NAM',
          'VG' => 'VIRGIN ISLANDS, BRITISH',
          'VI' => 'VIRGIN ISLANDS, U.S.',
          'WF' => 'WALLIS AND FUTUNA',
          'EH' => 'WESTERN SAHARA (formerly Spanish Sahara)',
          'YE' => 'YEMEN (Yemen Arab Republic)',
          'ZW' => 'ZIMBABWE'
        );
        return $array_countries;
    }

    public function get_language_names()
    {
        $array_languages = array(
        'ar-XA'=>'Arabic',
        'bg'=>'Bulgarian',
        'hr'=>'Croatian',
        'cs'=>'Czech',
        'da'=>'Danish',
        'de'=>'German',
        'el'=>'Greek',
        'en'=>'English',
        'et'=>'Estonian',
        'es'=>'Spanish',
        'fi'=>'Finnish',
        'fr'=>'French',
        'ga'=>'Irish',
        'hr'=>'Hindi',
        'hu'=>'Hungarian',
        'he'=>'Hebrew',
        'ja'=>'Japanese',
        'ko'=>'Korean',
        'lv'=>'Latvian',
        'lt'=>'Lithuanian',
        'nl'=>'Dutch',
        'no'=>'Norwegian',
        'pl'=>'Polish',
        'pt'=>'Portuguese',
        'sv'=>'Swedish',
        'ro'=>'Romanian',
        'ru'=>'Russian',
        'sr-CS'=>'Serbian',
        'sk'=>'Slovak',
        'sl'=>'Slovenian',
        'th'=>'Thai',
        'tr'=>'Turkish',
        'uk-UA'=>'Ukrainian',
        'zh-chs'=>'Chinese (Simplified)',
        'zh-cht'=>'Chinese (Traditional)'
        );
        return $array_languages;
    }


    function _language_list() 
     {
        
         $language = array
         (
            "bengali"   =>array('country_code'=>'bd','label'=>'Bengali'),          
            "dutch"     =>array('country_code'=>'nl','label'=>'Dutch'),          
            "english"   =>array('country_code'=>'us','label'=>'English'),          
            "french"    =>array('country_code'=>'fr','label'=>'French'),          
            "german"    =>array('country_code'=>'de','label'=>'German'),          
            "greek"     =>array('country_code'=>'gr','label'=>'Greek'),          
            "italian"   =>array('country_code'=>'it','label'=>'Italian'),          
            "portuguese"=>array('country_code'=>'br','label'=>'Portuguese'),          
            "russian"   =>array('country_code'=>'ru','label'=>'Russian'),          
            "spanish"   =>array('country_code'=>'es','label'=>'Spanish'),
            "turkish"   =>array('country_code'=>'tr','label'=>'Turkish')
         );
         return $language;
     }

     public function language_changer()
    {
        $language=$this->input->post("language");
        $this->session->set_userdata("selected_language",$language);
    }

    function _search_value_list() 
     {
        
         $search_value_list = array
         (
            "150"   =>"150",        
            "300"   =>"300",        
            "450"   =>"450",        
            "600"   =>"600"        
         );
         return $search_value_list;
     }

     function _payment_package() 
     {
        $payment_package=$this->basic->get_data("package",$where=array("where"=>array("is_default"=>"0","price > "=>0)),$select='',$join='',$limit='',$start=NULL,$order_by='price');         
        $return_val=array();
        $config_data=$this->basic->get_data("payment_config");
        $currency=$config_data[0]["currency"];
        foreach ($payment_package as $row) 
        {
            $return_val[$row['id']]=$row['package_name']." : Only @".$currency." ".$row['price']." for ".$row['validity']." days";
        }
        return $return_val;
     }

     // function _get_user_modules() 
     // {
     //    $result=$this->basic->get_data("users",array("where"=>array("id"=>$this->session->userdata("user_id"))));
     //    $package_id=$result[0]["package_id"];
     //    $module_ids=$this->basic->execute_query('SELECT m.id as module_id FROM modules m JOIN package p ON FIND_IN_SET(m.id,p.module_ids) > 0 WHERE p.id='.$package_id);      
     //    $return_val=implode(',', array_column($module_ids, 'module_id'));
     //    $return_val=explode(',',$return_val);
     //    return $return_val;
     // }


    function real_ip()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
          $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
          $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
          $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }



    // website function
    public function sign_up()
    {
        $data['body'] = 'page/sign_up';
        $data['page_title']=$this->lang->line("sign up");
        $data['num1']=$this->_random_number_generator(2);
        $data['num2']=$this->_random_number_generator(2);
        $captcha= $data['num1']+ $data['num2'];
        $this->session->set_userdata("sign_up_captcha",$captcha);
        $this->_front_viewcontroller($data);
    }

    public function sign_up_action()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }
        if($_POST) {
            $this->form_validation->set_rules('name', '<b>'.$this->lang->line("name").'</b>', 'trim|required|xss_clean');
            $this->form_validation->set_rules('email', '<b>'.$this->lang->line("email").'</b>', 'trim|required|xss_clean|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('mobile', '<b>'.$this->lang->line("mobile").'</b>', 'trim|xss_clean');
            $this->form_validation->set_rules('password', '<b>'.$this->lang->line("password").'</b>', 'trim|required|xss_clean');
            $this->form_validation->set_rules('confirm_password', '<b>'.$this->lang->line("confirm password").'</b>', 'trim|required|xss_clean|matches[password]');
            $this->form_validation->set_rules('captcha', '<b>'.$this->lang->line("captcha").'</b>', 'trim|required|xss_clean|integer');

            if($this->form_validation->run() == FALSE)
            {
                $this->sign_up();
            }
            else 
            {
                $captcha = $this->input->post('captcha', TRUE);
                if($captcha!=$this->session->userdata("sign_up_captcha"))
                {
                    $this->session->set_userdata("sign_up_captcha_error",$this->lang->line("invalid captcha"));
                    return $this->sign_up();

                }

                $name = $this->input->post('name', TRUE);
                $email = $this->input->post('email', TRUE);
                $mobile = $this->input->post('mobile', TRUE);
                $password = $this->input->post('password', TRUE);

                // $this->db->trans_start();

                $default_package=$this->basic->get_data("package",$where=array("where"=>array("is_default"=>"1"))); 

                if(is_array($default_package) && array_key_exists(0, $default_package))
                {
                    $validity=$default_package[0]["validity"];
                    $package_id=$default_package[0]["id"];

                    $to_date=date('Y-m-d');
                    $expiry_date=date("Y-m-d",strtotime('+'.$validity.' day',strtotime($to_date)));
                }

                $code = $this->_random_number_generator();
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'mobile' => $mobile,
                    'password' => md5($password),
                    'user_type' => 'Member',
                    'status' => '0',
                    'activation_code' => $code,
                    'expired_date'=>$expiry_date,
                    'package_id'=>$package_id
                    );

                if ($this->basic->insert_data('users', $data)) {
                    //email to user
                    $url = site_url()."home/account_activation";
                    $url_final="<a href='".$url."' target='_BLANK'>".$url."</a>";
                    $message = "<p>".$this->lang->line("to activate your account please perform the following steps")."</p>
                                <ol>
                                    <li>".$this->lang->line("go to this url").":".$url_final."</li>
                                    <li>".$this->lang->line("enter this code").":".$code."</li>
                                    <li>".$this->lang->line("activate your account")."</li>
                                <ol>";


                    $from = $this->config->item('institute_email');
                    $to = $email;
                    $subject = $this->config->item('product_name')." | ".$this->lang->line("account activation");
                    $mask = $subject;
                    $html = 1;
                    $this->_mail_sender($from, $to, $subject, $message, $mask, $html);

                    $this->session->set_userdata('reg_success',1);
                    return $this->sign_up();

                }

            }

        }
    }

    public function account_activation()
    {
        $data['body']='page/account_activation';
        $data['page_title']=$this->lang->line("account activation");
        $this->_front_viewcontroller($data);
    }

    public function account_activation_action()
    {
        if ($_POST) {
            $code=trim($this->input->post('code', true));
            $email=$this->input->post('email', true);

            $table='users';
            $where['where']=array('activation_code'=>$code,'email'=>$email,'status'=>"0");
            $select=array('id');

            $result=$this->basic->get_data($table, $where, $select);

            if (empty($result)) {
                echo 0;
            } else {
                foreach ($result as $row) {
                    $user_id=$row['id'];
                }

                $this->basic->update_data('users', array('id'=>$user_id), array('status'=>'1'));
                echo 2;
                
            }
        }
    }

   


    public function email_contact()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            redirect('home/access_forbidden', 'location');
        }

        if ($_POST) 
        {
            $redirect_url=site_url("home#contact");

            $this->form_validation->set_rules('email',                    '<b>'.$this->lang->line("email").'</b>',              'trim|required|valid_email');
            $this->form_validation->set_rules('subject',                  '<b>'.$this->lang->line("message subject").'</b>',    'trim|required');
            $this->form_validation->set_rules('message',                  '<b>'.$this->lang->line("message").'</b>',            'trim|required');
            $this->form_validation->set_rules('captcha',                  '<b>'.$this->lang->line("captcha").'</b>',            'trim|required');

            if ($this->form_validation->run() == false) 
            {
                return $this->index();
            } 
            else 
            {
                $captcha = $this->input->post('captcha', TRUE);
                $word = $this->session->userdata('captchaWord');
                if($captcha != $word)
                {
                   $this->session->set_userdata("contact_captcha_error",$this->lang->line("invalid captcha"));
                   redirect($redirect_url, 'location');
                   exit();
                }


                $email = $this->input->post('email', true);
                $subject = $this->config->item("product_name")." | ".$this->input->post('subject', true);
                $message = $this->input->post('message', true);

                $this->_mail_sender($from = $email, $to = $this->config->item("institute_email"), $subject, $message, $mask = $from,$html=1);
                $this->session->set_userdata('mail_sent', 1);

                redirect($redirect_url, 'location');
            }
        }
    }

    // website function



    function get_general_content($url,$proxy="")
    {        
        $ch = curl_init(); // initialize curl handle
       /* curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);*/
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");
        curl_setopt($ch, CURLOPT_AUTOREFERER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 7);
        curl_setopt($ch, CURLOPT_REFERER, 'http://'.$url);
        curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// allow redirects
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_TIMEOUT, 50); // times out after 50s
        curl_setopt($ch, CURLOPT_POST, 0); // set POST method

     
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_COOKIEJAR, "my_cookies.txt");
        curl_setopt($ch, CURLOPT_COOKIEFILE, "my_cookies.txt");
        
        $content = curl_exec($ch); // run the whole process
        
        curl_close($ch);
        
        return $content;            
    }


    public function member_validity()
    {
        if($this->session->userdata('logged_in') == 1 && $this->session->userdata('user_type') != 'Admin') {
            $where['where'] = array('id'=>$this->session->userdata('user_id'));
            $user_expire_date = $this->basic->get_data('users',$where,$select=array('expired_date'));
            $expire_date = strtotime($user_expire_date[0]['expired_date']);
            $current_date = strtotime(date("Y-m-d"));
            $package_data=$this->basic->get_data("users",$where=array("where"=>array("users.id"=>$this->session->userdata("user_id"))),$select="package.price as price",$join=array('package'=>"users.package_id=package.id,left"));
            if(is_array($package_data) && array_key_exists(0, $package_data))
            $price=$package_data[0]["price"];
            if($price=="Trial") $price=1;
            if ($expire_date < $current_date && ($price>0 && $price!=""))
            redirect('payment/member_payment_history','Location');
        }
    }
    


    public function important_feature(){

         if(file_exists(APPPATH.'config/licence.txt') && file_exists(APPPATH.'core/licence.txt')){
            $config_existing_content = file_get_contents(APPPATH.'config/licence.txt');
            $config_decoded_content = json_decode($config_existing_content, true);

            $core_existing_content = file_get_contents(APPPATH.'core/licence.txt');
            $core_decoded_content = json_decode($core_existing_content, true);

            if($config_decoded_content['is_active'] != md5($config_decoded_content['purchase_code']) || $core_decoded_content['is_active'] != md5(md5($core_decoded_content['purchase_code']))){
              redirect("home/credential_check", 'Location');
            }
            
        } else {
            redirect("home/credential_check", 'Location');
        }

    }


    public function credential_check()
    {
        $data['body'] = 'front/credential_check';
        $data['page_title'] = "Credential Check";
        $this->_front_viewcontroller($data);
    }

    public function credential_check_action()
    {
        $domain_name = $this->input->post("domain_name",true);
        $purchase_code = $this->input->post("purchase_code",true);
        $only_domain = get_domain_only($domain_name);
        // $only_domain = "xeroneit.ne";
       
       $response=$this->code_activation_check_action($purchase_code,$only_domain);

       echo $response;

    }


    

    public function code_activation_check_action($purchase_code,$only_domain)
    {

        $url = "http://xeroneit.net/development/envato_license_activation/purchase_code_check.php?purchase_code={$purchase_code}&domain={$only_domain}&item_name=sitespy";

        $credentials = $this->get_general_content($url);
        $decoded_credentials = json_decode($credentials);
        if($decoded_credentials->status == 'success'){
            $content_to_write = array(
                'is_active' => md5($purchase_code),
                'purchase_code' => $purchase_code,
                'item_name' => $decoded_credentials->item_name,
                'buy_at' => $decoded_credentials->buy_at,
                'licence_type' => $decoded_credentials->license,
                'domain' => $only_domain,
                'checking_date'=>date('Y-m-d')
                );
            $config_json_content_to_write = json_encode($content_to_write);
            file_put_contents(APPPATH.'config/licence.txt', $config_json_content_to_write, LOCK_EX);

            $content_to_write['is_active'] = md5(md5($purchase_code));
            $core_json_content_to_write = json_encode($content_to_write);
            file_put_contents(APPPATH.'core/licence.txt', $core_json_content_to_write, LOCK_EX);

            return json_encode("success");

        } else {
            if(file_exists(APPPATH.'core/licence.txt')) unlink(APPPATH.'core/licence.txt');
            return json_encode($decoded_credentials);
        }
    }

    public function periodic_check()
    {

        $today= date('d');

        if($today%7==0)
        {

          if(file_exists(APPPATH.'config/licence.txt') && file_exists(APPPATH.'core/licence.txt'))
          {
                $config_existing_content = file_get_contents(APPPATH.'config/licence.txt');
                $config_decoded_content = json_decode($config_existing_content, true);
                $last_check_date= $config_decoded_content['checking_date'];
                $purchase_code  = $config_decoded_content['purchase_code'];
                $base_url = base_url();
                $domain_name    = get_domain_only($base_url);

                if( strtotime(date('Y-m-d')) != strtotime($last_check_date))
                $this->code_activation_check_action($purchase_code,$domain_name);     
               
            }
        }
    }


    public function page_search_action()
    {
        
        $this->load->library('fb_search');
        $keyword=$this->input->post('keyword', true);
        $captcha_val=$this->input->post('captcha_val', true);

        $config_data_captcha=array();
        $recaptcha_site_key="";
        $recaptcha_secret_key="";
        $config_data_captcha=$this->basic->get_data("connectivity_config");
        if(array_key_exists(0,$config_data_captcha)) 
        {          
            $recaptcha_site_key=$config_data_captcha[0]['recaptcha_site_key'];
            $recaptcha_secret_key=$config_data_captcha[0]['recaptcha_secret_key'];
        }

        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$recaptcha_secret_key.'&response='.$captcha_val);
        $responseData = json_decode($verifyResponse);
        if(!$responseData->success)
        {
            echo "<div class='alert alert-warning text-center'>Invalid captcha.</div>";
            exit();
        }


        $lead_config=$this->basic->get_data("lead_config");

        if(is_array($lead_config) && isset($lead_config[0]))
        {
            $limit=$lead_config[0]["search_limit"];   
            $display_limit=$lead_config[0]["search_result_display_limit"];   
            $download_limit=$lead_config[0]["subscriber_download_limit"]; 
        }
        else
        {
            $limit=600;   
            $display_limit=50;   
            $download_limit=150; 
        }  

        $download_id=$this->session->userdata('download_id_front');
        $fp = fopen("download/page_search/page_search_{$download_id}.csv", "w");
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
        $write_data[]="Talking About Count";
        $write_data[]="Location";
        $write_data[]="Searched Date"; 
        fputcsv($fp, $write_data);


        $this->session->unset_userdata('page_search_completed');
        $this->session->unset_userdata('page_search_counting_search');
        $this->session->set_userdata('page_search_keyword',$keyword);
        $page_search_data=$this->fb_search->page_search($keyword,$limit);

    
        if(is_array($page_search_data) && isset($page_search_data['data']) && count($page_search_data['data'])>0)
        $str = "<table class='small-font table table-bordered table-striped table-condensed'><tr><th>".$this->lang->line('sl')."</th><th>".$this->lang->line('page name')."</th><th>".$this->lang->line('email')."</th><th>".$this->lang->line('website')."</th><th>".$this->lang->line('phone')."</th><th>".$this->lang->line('location')."</th><th>".$this->lang->line('fan count')."</th>"."<th>".$this->lang->line('founded')."</th><th>".$this->lang->line('talking about count')."</th><th>".$this->lang->line('details')."</th></tr>";
        else $str="0"; // no data found


        if(isset($page_search_data['data'][0]) && count($page_search_data['data'][0])==0) $str="0";

        $sl1=0;
        $sl2=0;
        foreach($page_search_data['data'] as $value1)
        {
            
            foreach($value1 as $value2)
            {
                $insert_data['search_keyword'] = $keyword;
                $insert_data['searched_at'] = date("Y-m-d");
                if(isset($value2['phone']))
                    $insert_data['phone'] = $value2['phone'];

                if(isset($value2['id']))
                    $insert_data['page_id'] = $value2['id'];

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

                if($this->basic->insert_data('page_search_guest', $insert_data))
                {
                    $insert_id = $this->db->insert_id();
                    $write_data=array();
                    $write_data[]=$keyword;

                    $ID = '';
                    if(isset($value2['id'])) $ID = $value2['id'];
                    $write_data[]=$ID;

                    $write_name = '';
                    $sl1++;

                    if($sl1<=$download_limit)
                    {
                        $link='';
                        if(isset($value2['link'])) $link = $value2['link'];

                        if(isset($value2['location'])){
                            $location = $value2['location'];
                            if(is_array($location))
                            {
                                array_walk($location, function(&$value, $key) {
                                $key=ucfirst($key);
                                $value = "{$key} : {$value}";
                                });
                                $location =  implode(',', $location);
                            }
                            else $location="";                            
                        }
                        else $location = '';

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

                        $talking_about_count = '';
                        if(isset($value2['talking_about_count'])) $talking_about_count = $value2['talking_about_count'];
                        $write_data[]=$talking_about_count;
                        

                        $write_data[]=$location;

                        $write_data[]=date("Y-m-d");
                        fputcsv($fp, $write_data);
                    }

                    $sl2++;
                    if($sl2<=$display_limit)
                    {
                        $link='';
                        if(isset($value2['link'])) $link = $value2['link'];

                        if(isset($value2['location'])){
                            $location = $value2['location'];
                            if(isset($location["latitude"]))  unset($location["latitude"]);
                            if(isset($location["longitude"])) unset($location["longitude"]);
                            if(is_array($location))
                            {
                                array_walk($location, function(&$value, $key) {
                                $key=ucfirst($key);
                                $value = "{$key} : {$value}";
                                });
                                $location =  implode('<br/>', $location);
                            }
                            else $location="";                            
                        }
                        else $location = '';

                        $write_name="";
                        if(isset($value2['name'])) $write_name = $value2['name'];

                        $fan_count = '';
                        if(isset($value2['fan_count'])) $fan_count = $value2['fan_count'];

                        $website = '';
                        if(isset($value2['website'])) $website = $value2['website'];

                        $phone = '';
                        if(isset($value2['phone'])) $phone = $value2['phone'];

                        $founded = '';
                        if(isset($value2['founded'])) $founded = $value2['founded'];

                        $category = '';
                        if(isset($value2['category'])) $category = $value2['category'];

                        $is_verified = '';
                        if(isset($value2['is_verified'])) $is_verified = $value2['is_verified'];

                        $emails = array();
                        if(isset($value2['emails']))
                            $emails = $value2['emails'];
                        if(!empty($emails))
                            $email = $emails[0];
                        else $email = '';

                        $talking_about_count = '';
                        if(isset($value2['talking_about_count'])) $talking_about_count = $value2['talking_about_count'];


                        $str .= "<tr>
                                <td>".$sl2."</td>
                                <td><a target='_BLANK' href='".$link."'>".$write_name."</a></td>
                                <td>".$email."</td>
                                <td>".$website."</td>
                                <td>".$phone."</td>
                                <td>".$location."</td>
                                <td>".$fan_count."</td>
                                <td>".$founded."</td>
                                <td>".$talking_about_count."</td>
                                <td><a target='_BLANK' href='".base_url()."home/page_details/{$insert_id}'> <i class='fa fa-binoculars'></i> ".$this->lang->line('details')."</td>
                            </tr>";
                    }
                }

            }
        }

        if($str!="0")
        $str .= "</table>";

        fclose($fp);

        echo $str;

    }

    public function bulk_page_search_progress_count()
    { 
        $bulk_counting_search=$this->session->userdata('page_search_counting_search');
        $completed_search=$this->session->userdata('page_search_completed');
        $page_search_keyword=$this->session->userdata('page_search_keyword');
        
        $response['search_counting']=$bulk_counting_search;
        $response['search_completed']=$completed_search;
        $response['page_search_keyword']=$page_search_keyword;
        
        echo json_encode($response);
        
    }

    public function send_download_link()
    {
        if($_POST)
        {
            $lead_config=$this->basic->get_data("lead_config");
            if(is_array($lead_config) && isset($lead_config[0]))
            $allowed_download_per_email=$lead_config[0]["allowed_download_per_email"];
            else $allowed_download_per_email=10;  
            
            $email=$this->input->post("email");
            $name=$this->input->post("name");
            $product=$this->config->item('product_name');
            $subject=$product." | "."Page Search Result";
            $download_link="<a href='".base_url().'download/page_search/page_search_'.$this->session->userdata('download_id_front').'.csv'."'>Download Page Search Result</a>";
            $message="Hello {$name}, <br/> Thank you for using {$product}.<br/> Please follow the link to download your search result: {$download_link}<br/><br/><br/>{$product}";
            $this->load->library('fb_search');
            $data=array("firstname"=>$name,"email"=>$email);
            
            
            if($this->basic->is_exist($table="leads",$where=array("email"=>$email,"no_of_search >="=>$allowed_download_per_email),$select="id"))
            $ret_val= "0"; // crossed limit
             
            else if($this->basic->is_exist($table="leads",$where=array("email"=>$email,"no_of_search <"=>$allowed_download_per_email),$select="id"))
            {
                $this->basic->execute_complex_query("UPDATE leads SET name='".$name."',no_of_search=no_of_search+1,date_time='".date("Y-d-m G:i:s")."' WHERE email='".$email."'");
                $ret_val= "1"; // updated               
            }
            else 
            {
                $this->basic->insert_data("leads",array("name"=>$name,"email"=>$email,"date_time"=>date("Y-d-m G:i:s")));            
                $this->fb_search->syncMailchimp($data);
                $ret_val= "2"; // inserted
            }

            if($ret_val=="1" || $ret_val=="2")
            $this->_mail_sender($from = '', $to = $email, $subject, $message, $mask = $product, $html = 1);

            echo $ret_val;
            
        }
    }

  
    public function redirect_link()
    {
        $this->load->library('Fb_search');
        $access_token = $this->fb_search->login_callback();
        if($access_token['status'] == 'error'){
            $data['error'] = 1;
            $data['message'] = $access_token['message'];
            $data['body'] = "page/redirect_link";
            $this->_viewcontroller($data);
        } else {
            $access_token = $this->fb_search->create_long_lived_access_token($access_token['message']);
            $user_id = $this->session->userdata('user_id');
            $where = array('user_id'=>$user_id,'status'=>'1');
            $update_data = array('user_access_token'=>$access_token['access_token']);

            if($this->basic->update_data('facebook_config',$where,$update_data)){
                $data['error'] = 0;
                $data['message'] = "Successfully Loged in. You can search now.";
            }
            else{
                $data['error'] = 1;
                $data['message'] = "Something wrong, please try again";
            }

            $data['body'] = "page/redirect_link";
            $this->_viewcontroller($data);
        }
    }

    public function page_details($id=0)
    {
        if($id==0) exit();
        $info=$this->basic->get_data("page_search_guest",array("where"=>array("id"=>$id)));
        $data['info']=$info[0];
        $data["body"]="site/page_details";
        $this->_site_viewcontroller($data);
    }

   
    
}


