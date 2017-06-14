<?php  
include("Facebook/autoload.php");

	class Fb_search
	{
				
		public $user_id=""; 
		public $proxy_ip;
		public $proxy_auth_pass;
        public $app_id="";
		public $app_secret="";		
		public $user_access_token="";
		public $mailchimp_api_key=""; 
        public $mailchimp_list_id="";


	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
		$this->CI->load->helper('my_helper');
		$this->CI->load->library('session');
		$this->CI->load->model('basic');
		$this->user_id=$this->CI->session->userdata("user_id");

		if($this->user_id!="")
		{
			$facebook_config=$this->CI->basic->get_data("facebook_config",array("where"=>array("user_id"=>$this->user_id,"status"=>"1")));
			if(isset($facebook_config[0]))
			{			
				$this->app_id=$facebook_config[0]["api_id"];
				$this->app_secret=$facebook_config[0]["api_secret"];
				$this->user_access_token=$facebook_config[0]["user_access_token"];
			}
		}
		else
		{
			$facebook_config=$this->CI->basic->get_data($table="facebook_config",$where=array("where"=>array("users.user_type"=>"Admin","facebook_config.status"=>"1")),$select=array("facebook_config.*"),$join=array('users'=>"users.id=facebook_config.user_id,left"));
			if(isset($facebook_config[0]))
			{			
				$this->app_id=$facebook_config[0]["api_id"];
				$this->app_secret=$facebook_config[0]["api_secret"];
				$this->user_access_token=$facebook_config[0]["user_access_token"];
			}
		}


		$lead_config=$this->CI->basic->get_data("lead_config");
		if(isset($lead_config[0]))
		{			
			$this->mailchimp_api_key=$lead_config[0]["mailchimp_api_key"];
			$this->mailchimp_list_id=$lead_config[0]["mailchimp_list_id"];	
		}
		
	}
	
	
	
	function login_for_user_access_token($redirect_url=""){
	
		session_start();
		
		$fb = new Facebook\Facebook([
		  'app_id' => $this->app_id, // Replace {app-id} with your app id
		  'app_secret' => $this->app_secret,
		  'default_graph_version' => 'v2.2',
		]);
		
		// $redirect_url='http://webprogrammings.net/api/facebook_login/latest/callback.php';

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl($redirect_url, $permissions);
	
		return '<a href="' . htmlspecialchars($loginUrl) . '">Log in with Facebook!</a>';	
	}
	
	
	public function login_callback(){
			session_start();
			
			$fb = new Facebook\Facebook([
			  'app_id' => $this->app_id, // Replace {app-id} with your app id
			  'app_secret' => $this->app_secret,
			  'default_graph_version' => 'v2.2',
			]);
			
			$response=array();
				
			$helper = $fb->getRedirectLoginHelper();
				try {
				  $accessToken = $helper->getAccessToken();
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  
				  $response['status']="error";
				  $response['message']= $e->getMessage();
				  
				  return $response;
				  
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
					$response['status']="error";
				    $response['message']= $e->getMessage();
					return $response;
				}
				
		 $response['status']="success";
		 $response['message']= (string) $accessToken;
		 
		 return $response;
		
	}
	
	public function app_id_secret_check()
	{
		if($this->app_id == '' || $this->app_secret == '') return 'not_configured';
	}
	
	function access_token_validity_check(){

		// $access_token=$this->user_access_token;
		// $client_id=$this->app_id;
		// $result=array();
		// $url="https://graph.facebook.com/v2.6/oauth/access_token_info?client_id={$client_id}&access_token={$access_token}";
		
		//  $headers = array("Content-type: application/json");
		 	 
		//  $ch = curl_init();
		//  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	 //     curl_setopt($ch, CURLOPT_URL, $url);
		//  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	 //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	 //     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	 //     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	 //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	 //     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		//  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		//  $st=curl_exec($ch); 
		 
		//  $result=json_decode($st,TRUE);

		//  if(!isset($result["expires_in"])) $result["expires_in"]=0;
		 
		//  return $result;



		$input_token  = $this->user_access_token;

        if($input_token=="") 
        return false;


        $url="https://graph.facebook.com/debug_token?input_token={$input_token}&access_token={$input_token}";
       
        $headers = array("Content-type: application/json"); 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		$results=curl_exec($ch); 

		$result = json_decode($results,TRUE);


        if(isset($result["data"]["is_valid"]) && $result["data"]["is_valid"]) 
        {
            return true;
        } 
        else 
        {
            return false;
        }   
		 
	}
	
	
	
	public function create_long_lived_access_token($short_lived_user_token){
	
		$app_id=$this->app_id;
		$app_secret=$this->app_secret;
		$short_token=$short_lived_user_token;
		
		$url="https://graph.facebook.com/v2.6/oauth/access_token?grant_type=fb_exchange_token&client_id={$app_id}&client_secret={$app_secret}&fb_exchange_token={$short_token}";
		
		$headers = array("Content-type: application/json");
		 	 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	     curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		 $st=curl_exec($ch); 
		 $result=json_decode($st,TRUE);
		 
		 return $result;
		 
	}
	
	
	
	function page_search($keyword,$limit="",$video=0){
		
		$keyword=urlencode($keyword);
		$access_token=$this->app_id."|".$this->app_secret;


		if($video){
			$video_str=",videos{description,embed_html}";
			$limit_per_call=30;
		}
		else{
			$video_str="";
			$limit_per_call=100;
		}
		
		$url="https://graph.facebook.com/v2.6/search?q={$keyword}&type=page&access_token={$access_token}&fields=phone,id,name,emails,website,likes{id,name,link,cover},about,founded,category,location,posts.limit(5){permalink_url,message,story,created_time,id,picture,shares},cover,is_verified,mission,start_info,username,talking_about_count,link,is_published,contact_address,fan_count,picture{$video_str}&limit={$limit_per_call}";
		 
		 
		 $headers = array("Content-type: application/json");
			 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	     curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		 $st=curl_exec($ch); 		 
		 $results=json_decode($st,TRUE);
			 
		 
		 if(!is_array($results) || !isset($results['data'])) return array("data"=>array());

		 $final_result[0]=$results['data'];
		 $total_found = count($final_result[0]);
		 $this->CI->session->set_userdata('page_search_counting_search',$total_found);
		 
		 
		 $next_page= isset($results['paging']['next']) ? $results['paging']['next']:"" ;
		 
		 for($i=1;$i<=5;$i++){
		 
		 	if(!$next_page || $limit<$total_found){
		 		$this->CI->session->set_userdata('page_search_counting_search',$total_found);
		 		$this->CI->session->set_userdata('page_search_completed',1);
				break;
		 	}
		 
		 	$next_page_result	= $this->facebook_api_call($next_page);
			$final_result[$i]=isset($next_page_result['data']) ? $next_page_result['data']:array();
			$total_found += count($final_result[$i]);
			$next_page= isset($next_page_result['paging']['next']) ? $next_page_result['paging']['next']:"" ;

			$this->CI->session->set_userdata('page_search_counting_search',$total_found);
		 }
		
		$this->CI->session->set_userdata('page_search_completed',1);
		$response['total_found']=$total_found;
		$response['data']=$final_result;
		
		return $response;
		
	}
	
	
	public function event_search($keyword,$limit=""){
		
		$keyword=urlencode($keyword);
		$access_token=$this->user_access_token;
		$limit_str="";
		
				
		$url="https://graph.facebook.com/v2.6/search?q={$keyword}&type=event&access_token={$access_token}&fields=description,name,place,start_time,id,can_guests_invite,category,cover,declined_count,end_time,guest_list_enabled,interested_count,is_page_owned,is_viewer_admin,maybe_count,noreply_count,owner,parent_group,ticket_uri,timezone,type,updated_time,picture,attending_count&limit=100";
	
	 
		 $headers = array("Content-type: application/json");
			 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	     curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		 $st=curl_exec($ch);

		 $results=json_decode($st,TRUE);
		 if(!is_array($results) || !isset($results['data'])) return array("data"=>array());
		 
		 $final_result[0]=$results['data'];
		 $total_found = count($final_result[0]);

		 $this->CI->session->set_userdata('event_search_counting_search',$total_found); 
		 
		 
		 $next_page= isset($results['paging']['next']) ? $results['paging']['next']:"" ;
		 
		 for($i=1;$i<=5;$i++){
		 
		 	if(!$next_page || $limit<$total_found){
		 		$this->CI->session->set_userdata('event_search_counting_search',$total_found);
		 		$this->CI->session->set_userdata('event_search_completed',1);
				break;
		 	}
		 
		 	$next_page_result	= $this->facebook_api_call($next_page);
			$final_result[$i]=isset($next_page_result['data']) ? $next_page_result['data']:array();
			$total_found += count($final_result[$i]);
			$next_page= isset($next_page_result['paging']['next']) ? $next_page_result['paging']['next']:"" ;
			$this->CI->session->set_userdata('event_search_counting_search',$total_found);
		 }
		 
		$this->CI->session->set_userdata('event_search_completed',1);

		$response['total_found']=$total_found;
		$response['data']=$final_result;
		
		return $response;
	
	}
	
	
	
	
	public function group_search($keyword,$limit=""){
		
		$keyword=urlencode($keyword);
		$access_token=$this->user_access_token;
		$limit_str="";
		
		
				
		$url="https://graph.facebook.com/v2.6/search?q={$keyword}&type=group&access_token={$access_token}&fields=cover,id,link,description,email,icon,member_request_count,name,owner,parent,privacy,picture,updated_time&limit=100";
	 
		 $headers = array("Content-type: application/json");
			 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	     curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		 $st=curl_exec($ch); 
		
		 $results=json_decode($st,TRUE);
		 if(!is_array($results) || !isset($results['data'])) return array("data"=>array());

		 $final_result[0]=$results['data'];
		 $total_found = count($final_result[0]);

		 $this->CI->session->set_userdata('group_search_counting_search',$total_found);	 
		 
		 $next_page= isset($results['paging']['next']) ? $results['paging']['next']:"" ;
		 
		 for($i=1;$i<=5;$i++){
		 
		 	if(!$next_page || $limit<$total_found){
		 		$this->CI->session->set_userdata('group_search_counting_search',$total_found);
				$this->CI->session->set_userdata('group_search_completed',1);
				break;
		 	}
		 
		 	$next_page_result	= $this->facebook_api_call($next_page);
			$final_result[$i]=isset($next_page_result['data']) ? $next_page_result['data']:array();
			$total_found += count($final_result[$i]);
			$next_page= isset($next_page_result['paging']['next']) ? $next_page_result['paging']['next']:"" ;

			$this->CI->session->set_userdata('group_search_counting_search',$total_found);
		 }
		
		$this->CI->session->set_userdata('group_search_completed',1); 
		$response['total_found']=$total_found;
		$response['data']=$final_result;
		
		return $response;

	}
	
	
	public function user_search($keyword,$limit=""){
		
		$keyword=urlencode($keyword);
		$access_token=$this->user_access_token;
		$limit_str="";
		
		
		if($limit)
			$limit_str="&limit={$limit}";
				
		$url="https://graph.facebook.com/v2.6/search?q={$keyword}&type=user&access_token={$access_token}&fields=id,name,about,cover,education,email,gender,hometown,inspirational_people,install_type,interested_in,is_verified,languages,last_name,link,locale,location,meeting_for,middle_name,political,quotes,religion,relationship_status,timezone,website,picture,work&limit=100";
		
	 
		 $headers = array("Content-type: application/json");
			 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	     curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		   
		 $st=curl_exec($ch); 
		
		 $results=json_decode($st,TRUE);
		 if(!is_array($results) || !isset($results['data'])) return array("data"=>array());

		 $final_result[0]=$results['data'];
		 $total_found = count($final_result[0]);
		 
		 $this->CI->session->set_userdata('user_search_counting_search',$total_found);
		 
		 
		 $next_page= isset($results['paging']['next']) ? $results['paging']['next']:"" ;
		 
		 for($i=1;$i<=5;$i++){
		 
		 	if(!$next_page || $limit<$total_found){
		 		$this->CI->session->set_userdata('user_search_counting_search',$total_found);
		 		$this->CI->session->set_userdata('user_search_completed',1);
				break;
		 	}
		 
		 	$next_page_result	= $this->facebook_api_call($next_page);
			$final_result[$i]=isset($next_page_result['data']) ? $next_page_result['data']:array();
			$total_found += count($final_result[$i]);
			$next_page= isset($next_page_result['paging']['next']) ? $next_page_result['paging']['next']:"" ;
			$this->CI->session->set_userdata('user_search_counting_search',$total_found);
		 }
		 
		$this->CI->session->set_userdata('user_search_completed',1);
		$response['total_found']=$total_found;
		$response['data']=$final_result;
		
		return $response;

	}
	
	
	public function location_search($keyword,$latitude,$longitude,$distance,$limit="",$video=0){
			
	
		$keyword=urlencode($keyword);
		$access_token=$this->app_id."|".$this->app_secret;
		$limit_str="";
		$center=$latitude.",".$longitude;
		if($limit)
			$limit_str="&limit={$limit}";


		if($video){
			$video_str=",videos{description,embed_html}";
			$limit_per_call=30;
		}
		else{
			$video_str="";
			$limit_per_call=100;
		}


		
			
		$url="https://graph.facebook.com/v2.6/search?q={$keyword}&type=place&access_token={$access_token}&fields=id,name,emails,website,likes{id,name,link,cover},about,founded,category,location,posts.limit%285%29{permalink_url,message,story,created_time,id},cover,is_verified,talking_about_count,link,is_published,fan_count,phone{$video_str}&center={$center}&distance={$distance}&limit={$limit_per_call}";
					
	 
		 $headers = array("Content-type: application/json");
			 
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	     curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
	     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
	     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
	     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
		 
		 $st=curl_exec($ch); 
			
		 $results=json_decode($st,TRUE);
		 if(!is_array($results) || !isset($results['data'])) return array("data"=>array());
		 
		 $final_result[0]=$results['data'];
		 $total_found = count($final_result[0]);
		 $this->CI->session->set_userdata('location_search_counting_search',$total_found);
		 
		 
		 $next_page= isset($results['paging']['next']) ? $results['paging']['next']:"" ;
		 
		 for($i=1;$i<=5;$i++){
		 
		 	if(!$next_page || $limit<$total_found){
		 		$this->CI->session->set_userdata('location_search_counting_search',$total_found);
		 		$this->CI->session->set_userdata('location_search_completed',1);
				break;
		 	}
		 
		 	$next_page_result	= $this->facebook_api_call($next_page);
			$final_result[$i]=isset($next_page_result['data']) ? $next_page_result['data']:array();
			$total_found += count($final_result[$i]);
			$next_page= isset($next_page_result['paging']['next']) ? $next_page_result['paging']['next']:"" ;

			$this->CI->session->set_userdata('location_search_counting_search',$total_found);
		 }
		
		$this->CI->session->set_userdata('location_search_completed',1);
		$response['total_found']=$total_found;
		$response['data']=$final_result;
		
		return $response;

	


	}
	
	
	
	 public function facebook_api_call($url){
		
	 		 $headers = array("Content-type: application/json");
			 
			 $ch = curl_init();
			  
			 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		     curl_setopt($ch, CURLOPT_URL, $url);
			 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
		     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
		     curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
		     curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
		     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
		     curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
			 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
			   
			 $st=curl_exec($ch); 
			 
			 return  $results=json_decode($st,TRUE);	 
	}


	function syncMailchimp($data='') 
 	{
        $apikey = $this->mailchimp_api_key; // They key is generated at mailchimps controlpanel under settings.
        $apikey_explode = explode('-',$apikey); // The API ID is the last part of your api key, after the hyphen (-), 
        if(is_array($apikey_explode) && isset($apikey_explode[1])) $api_id=$apikey_explode[1];
        else $api_id="";
        $listId = $this->mailchimp_list_id; //  example: us2 or us10 etc.

        if($apikey=="" || $api_id=="" || $listId=="" || $data=="") exit();
      
        $auth = base64_encode( 'user:'.$apikey );
		
        $insert_data=array
        (
			'email_address'  => $data['email'],
			'status'         => 'subscribed', // "subscribed","unsubscribed","cleaned","pending"
			'merge_fields'  => array('FNAME'=>$data['firstname'],'LNAME'=>'','CITY'=>'','MMERGE5'=>"Subscriber")	
	    );
			
		$insert_data=json_encode($insert_data);
 	
		$url="https://".$api_id.".api.mailchimp.com/3.0/lists/".$listId."/members/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: Basic '.$auth));
        curl_setopt($ch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $insert_data);                                                                                                           
        $result = curl_exec($ch);
    }



			
	
}
	
	
