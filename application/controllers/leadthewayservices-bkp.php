<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LeadthewayServices extends CI_Controller {

	public $_uId;
	public $_userData;
	public $_assignData;
	public $_checkUser;

	public function __construct(){
        parent::__construct();

		$this->load->model('webservicesModel');
		$this->load->model('userModel');
		$this->load->model('ServicesModel');
		$this->load->model('eventsModel');

   }

	private $_headerData = array();
	private $_navData = array();
	private $_footerData = array();
	private $_jsonData = array();
	private $_finalData = array();

			/*************************** sign up code starts ***************************/
	
	public function image(){
		try{
			if($_FILES['file']['name'] == false || $_FILES['file']['name'] == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Image Missing";
			}else{
				  $imgName = time();
				  $imgPath = BASEPATH."../uploads/".$imgName;
				  $image = base_url().'uploads/'.$imgName;

				  if(move_uploaded_file($_FILES["file"]["tmp_name"],$imgPath.".jpg")){
					  $this->load->library('imagethumb');
					  $this->imagethumb->image($imgPath.".jpg",100,100);
					  $data = array(
								'image'=>$imgName."_thumb.jpg",
								'image_path'=>$image."_thumb.jpg"
							);
					  $this->_jsonData['status']="SUCCESS";
					  $this->_jsonData['message']="Image Inserted Successfully";
					  $this->_jsonData['data']=$data; 
				  }else{
					    $this->_jsonData['status']="FAILURE";
				 	 	$this->_jsonData['message']="Image can not be Inserted";
				  		$this->_jsonData['data']=''; 
				  }
				  
			}
				  echo json_encode($this->_jsonData);
		}catch(Exception $e){
				  $this->_jsonData['status']="FAILURE";
				  $this->_jsonData['message']="Error Occured";
				  $this->_jsonData['data']=$data; 
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'image',$_FILES);

	}

	public function signup(){
		$fb_id = $this->input->get_post('fb_id');
		$user_name = $this->input->get_post('user_name');
		$phone = $this->input->get_post('phone');
		$user_email = $this->input->get_post('user_email');
		$password = $this->input->get_post('password');
		
		//$user_image = $this->input->get_post('file');
		try{
			if($user_name == false || $user_name == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Name Missing";
			}else if($phone == false || $phone == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="phone Missing";
			}else if($user_email == false || $user_email == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Email Missing";
			}else if($password == false || $password == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Password Missing";
			}else{ 
					$checkUser = $this->userModel->checkUser($user_email);
					if(count($checkUser)>0){
						$this->_jsonData['status']="FAILURE";
						$this->_jsonData['message']="Email Already Exists";
					}else{
						$data = array(
								'fb_id'=>$fb_id,
								'user_name'=>$user_name,
								'phone'=>$phone,
								'user_email'=>$user_email,
								'password'=>base64_encode($password),
								'image'=>'http://developer.avenuesocial.com/azeemsal/leadtheway/uploads/nopicture.jpg'
							);
						$res = $this->userModel->addUser($data);
						$data['user_id'] = $res;
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="User Data Inserted Successfully";
						$this->_jsonData['data']=$data; 
					}
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'signup',$_FILES);
		
	}
	
	public function fbsignup(){
		$fb_id = $this->input->get_post('fb_id');
		$user_name = $this->input->get_post('user_name');
		$phone = $this->input->get_post('phone');
		$user_email = $this->input->get_post('user_email');
		
		//$user_image = $this->input->get_post('file');
		try{
			if($user_name == false || $user_name == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Name Missing";
			}else if($phone == false || $phone == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="phone Missing";
			}else if($user_email == false || $user_email == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Email Missing";
			}else{ 
					$checkUser = $this->userModel->checkUser($user_email);
					if(count($checkUser)>0){
						$this->_jsonData['status']="FAILURE";
						$this->_jsonData['message']="Email Already Exists";
					}else{
						$data = array(
								'fb_id'=>$fb_id,
								'user_name'=>$user_name,
								'phone'=>$phone,
								'user_email'=>$user_email,
								'image'=>'http://developer.avenuesocial.com/azeemsal/leadtheway/uploads/nopicture.jpg'
							);
						$res = $this->userModel->addUser($data);
						$data['user_id'] = $res;
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="User Data Inserted Successfully";
						$this->_jsonData['data']=$data; 
					}
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'fbsignup',$_FILES);
		
	}
	
	public function signin(){
		$user_email = $this->input->get_post('user_email');
		$password = $this->input->get_post('password');
		$fb_id = $this->input->get_post('fb_id');
		$device_id = $this->input->get_post('device_id');
		//$device = $this->input->get_post('device');

	try{
		if($fb_id!=""){
			$fbLogin = $this->userModel->fbLogin($fb_id);
			if(empty($fbLogin)){
                   $this->_jsonData['status']="SUCCESS";
                   $this->_jsonData['message']="User not found";
            }else{
                   $this->_jsonData['status']="SUCCESS";
                   $this->_jsonData['message']="User Logged In Successfully";
                   $this->_jsonData['data']=$fbLogin;
                }
		}else if($user_email == false || $user_email == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Email Missing";
			}else if($password == false || $password == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Password Missing";
			}else{
				$checkUser = $this->userModel->checklogin($user_email,base64_encode($password));
			if($checkUser !=""){
				$login = $this->userModel->login($user_email,base64_encode($password));
				$data = array(
							'user_id'=> $login['user_id'],
							'device_id'=>$device_id
						);
				
				$this->userModel->insertUserDeviceID($data);
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="User Logged In Successfully";
				$this->_jsonData['data']=$login; 
			}else{
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Email or Password donot match";
			}
		}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'signin',$_FILES);
		
	}
	
	public function trackLocation(){
		$user_id = $this->input->get_post('user_id');
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($lat == false || $lat == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Latitude Missing";
			}else if($long == false || $long == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Longitude Missing";
			}else{
				$data = array(
							'user_id'=>$user_id,
							'latitude'=>$lat,
							'longitude'=>$long
						);
				$res = $this->eventsModel->insertLocation($data);
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Data Inserted Successfully";
				$this->_jsonData['data']=$data;
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'trackLocation',$_FILES);
	} 
	
	public function getLocation(){
		$user_id = $this->input->get_post('user_id');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else{
				$res = $this->eventsModel->getLocation($user_id);
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Data Retreived Successfully";
				$this->_jsonData['data']=$res;
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getLocation',$_FILES);
	} 
	
	public function addFriends(){
		$user_id = $this->input->get_post('user_id');
		$phone = $this->input->get_post('phone');
		try{
			if($user_id == false || $user_id ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($phone == false || $phone == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Phone Number Missing";
			}else{
				$checkUser = $this->userModel->checkFriend($user_id,$phone);
				if($checkUser == 0){
						$data = array(
								'user_id'=>$user_id,
								'phone'=>$phone,
								'status'=>0,
								'datetime'=>date('Y-m-d H:i:s')
							);
						$res = $this->userModel->inviteFriends($data);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Friend Invited Successfully";
						$this->_jsonData['data']=$data; 
				}else{
					$this->_jsonData['status']="FAILURE";
					$this->_jsonData['message']="You both are already Connected";
				}
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'inviteFriends',$_FILES);
	}
	
	public function createEvent(){
		$user_id = $this->input->get_post('user_id');
		$event_name = $this->input->get_post('event_name');
		$event_type = $this->input->get_post('event_type');
		$event_date = $this->input->get_post('event_date');
		$event_time = $this->input->get_post('event_time');
		$description = $this->input->get_post('description');
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		$leadLat = $this->input->get_post('leadlat');	
		$leadLong = $this->input->get_post('leadlong');	
		
		try{
			if($user_id == false || $user_id ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($event_name == false || $event_name == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="event_name Missing";
			}else if($event_type == false || $event_type == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="event_type Missing";
			}else if($event_date == false || $event_date == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="event_date Missing";
			}else if($event_time == false || $event_time == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="event_time Missing";
			}else if($description == false || $description == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="description Missing";
			}else if($lat == false || $lat == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Latitude Missing";
			}else if($long == false || $long == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Longitude Missing";
			}else if($leadLat == false || $leadLat ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="leadLat Missing";
			}else if($leadLong == false || $leadLong ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="leadlong Missing";
			}else{
				if($event_type == 'public'){
					$data = array(
							'user_id'=>$user_id,
							'event_name'=>$event_name,
							'event_type'=>$event_type,
							'create_type'=>'events',
							'event_date'=>$event_date,
							'event_time'=>$event_time,
							'description'=>$description,
							'latitude'=>$lat,
							'longitude'=>$long
						);
					$res = $this->eventsModel->addEvent($data);
					$data['event_id'] = $res;
					$insert = array(
								'user_id'=>$data['user_id'],
								'event_id'=>$res,
								'leadLat'=>$leadLat,
								'leadLong'=>$leadLong
							);
					$result = $this->eventsModel->addEventLeadLatLong($insert);
				}else{
					$data = array(
							'user_id'=>$user_id,
							'event_name'=>$event_name,
							'event_type'=>$event_type,
							'create_type'=>'events',
							'event_date'=>$event_date,
							'event_time'=>$event_time,
							'description'=>$description,
							'latitude'=>$lat,
							'longitude'=>$long
						);
					$res = $this->eventsModel->addEvent($data);
					$data['event_id'] = $res;
					$insert = array(
								'user_id'=>$data['user_id'],
								'event_id'=>$res,
								'leadLat'=>$leadLat,
								'leadLong'=>$leadLong
							);
					$result = $this->eventsModel->addEventLeadLatLong($insert);
					$data = $this->input->get_post('invite');
					$data1 = json_decode($data,true);
					foreach($data1 as $dt){
					 	$this->userModel->addFollower($dt,$res);
					}
				}
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Event Created Successfully";
						$this->_jsonData['data']=$data; 
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'createEvent',$_FILES);
	}
	
	public function getEvents(){
		$user_id = $this->input->get_post('user_id');
		$phone = $this->input->get_post('phone');
		try{
			if($user_id =="" || $user_id == false){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else{
				$data = $this->eventsModel->getAllEvents($user_id,$phone);
				$j=0;
				foreach($data as $dt){
					$data[$j]['friends'] = $this->eventsModel->getEventFriendsByEventId($dt['event_id']);
					$j++;
				}
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Events Retreived Successfully";
				$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getEvents',$_FILES);
	}
	
	public function getAllEventsByEventId(){
		$event_id = $this->input->get_post('event_id');
		try{
			if($event_id == false || $event_id == ''){
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Event Id Missing";
			}else{
				$data = $this->eventsModel->getAllEventsByEventId($event_id);
				$j=0;
				foreach($data as $dt){
				$data[$j]['Followers'] = $this->eventsModel->getEventFriendsByEventId($dt['event_id']);
					$j++;
				}
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Event Followers Retreived Successfully";
				$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getAllEventsByEventId',$_FILES);
	
		
	}
	
	public function createRoute(){
		$user_id = $this->input->get_post('user_id');	
		//$friend_id = $this->input->get_post('friend_id');	
		$routeName = $this->input->get_post('event_name');	
		$routeType = $this->input->get_post('event_type');	
		$description = $this->input->get_post('description');	
		$latitude = $this->input->get_post('lat');	
		$longitude = $this->input->get_post('long');	
		$leadLat = $this->input->get_post('leadlat');	
		$leadLong = $this->input->get_post('leadlong');	
		try{
			if($user_id =="" || $user_id == false){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($routeName == false || $routeName ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="event_name Missing";
			}else if($routeType == false || $routeType ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="event_type Missing";
			}else if($description == false || $description ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="description Missing";
			}else if($latitude == false || $latitude ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Latitude Missing";
			}else if($longitude == false || $longitude ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Longitude Missing";
			}else if($leadLat == false || $leadLat ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="lead Latitude Missing";
			}else if($leadLong == false || $leadLong ==""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Lead Longitude Missing";
			}else{
				if($routeType == 'public'){
					$data = array(
							'user_id'=>$user_id,
							'event_name'=>$routeName,
							'event_type'=>$routeType,
							'create_type'=>'routes',
							'description'=>$description,
							'latitude'=>$latitude,
							'longitude'=>$longitude,
							'leadLat'=>$leadLat,
							'leadLong'=>$leadLong
					);
					$res = $this->eventsModel->addRoutes($data);
				}else{
					$data = array(
							'user_id'=>$user_id,
							'event_name'=>$routeName,
							'event_type'=>$routeType,
							'create_type'=>'routes',
							'description'=>$description,
							'latitude'=>$latitude,
							'longitude'=>$longitude,
							'leadLat'=>$leadLat,
							'leadLong'=>$leadLong
					);
					$res = $this->eventsModel->addRoutes($data);
					$data['event_id'] = $res;
					//$data['event_type'] = $routeType;
					//print_r($data['event_type']);
					$data = $this->input->get_post('invite');
					$data1 = json_decode($data,true);
					foreach($data1 as $dt){
						$this->userModel->addFollower($dt,$res);
					}
				}
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Route Created Successfully";
					$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'createRoute',$_FILES);
	}
	
	public function acceptFriendRoute(){
		$user_id = $this->input->get_post('user_id');
		$friend_id = $this->input->get_post('friend_id');
		$route_id = $this->input->get_post('route_id');		
		$lat = $this->input->get_post('lat');		
		$long = $this->input->get_post('long');		
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="follower Id Missing";
			}else if($route_id == false || $route_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Route Id Missing";
			}else{
					$this->userModel->acceptFriendRoute($user_id,$friend_id,$route_id,$lat,$long);
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Friend Route Accepted Successfully";
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'acceptFriendRoute',$_FILES);

	}
	
	public function rejectFriendRoute(){
		$user_id = $this->input->get_post('user_id');
		$friend_id = $this->input->get_post('friend_id');
		$route_id = $this->input->get_post('route_id');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Friend Id Missing";
			}else if($route_id == false || $route_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Route Id Missing";
			}else{
					$this->userModel->rejectFriendRoute($user_id,$friend_id,$route_id);
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Friend Route Rejected Successfully";
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'rejectFriendRoute',$_FILES);

	}

	public function getRoutes(){
		$user_id = $this->input->get_post('user_id');
		$phone = $this->input->get_post('phone');
		//$phones = json_decode($phone,true);
		//$data123 = array();
		try{
			if($user_id =="" || $user_id == false){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else{
				$data = $this->eventsModel->getAllRoutes($user_id,$phone);
				//echo '<pre>';print_r($data);
				$j=0;
				$data1 = array();
				foreach($data as $dt){
					$data1[$j]=$dt;
					$data1[$j]['LeadLatLongs'] = $this->eventsModel->getLeadLatLongs($dt['event_id']);
					$data1[$j]['Followers'] = $this->eventsModel->getRouteFriendsByRouteId($dt['event_id']);
					$j++;
				}
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Routes Retreived Successfully";
				$this->_jsonData['data']=$data1;
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getRoutes',$_FILES);
		
	}
	
	public function getAllRoutesByRouteId(){
		$route_id = $this->input->get_post('route_id');
		try{
			if($route_id == false || $route_id == ''){
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Route Id Missing";
			}else{
				$data = $this->eventsModel->getAllRoutesById($route_id);
				$j=0;
				foreach($data as $dt){
				$data[$j]['LeadLatLongs'] = $this->eventsModel->getLeadLatLongs($route_id);
				$data[$j]['Followers'] = $this->eventsModel->getRouteFriendsByRouteId($dt['event_id']);
					$j++;
				}
				//$res = $this->eventsModel->getAllRoutesByRouteId($route_id);
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Route Followers Retreived Successfully";
				$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getAllRoutesByRouteId',$_FILES);
	
		
	}
	
	public function addNumbers(){
		$data = $this->input->get_post('data');
		$data1 = json_decode($data,true);
		foreach($data1 as $dt){
			$number = $this->userModel->checkPhoneNumbers($dt['number']);
 			if($number==0){
				$this->userModel->addNumbers($dt);
			}
		}
			$this->_jsonData['status']="SUCCESS";
	 		$this->_jsonData['message']="Number Added successfully";
	 		$this->_jsonData['data']=$dt;
			echo json_encode($this->_jsonData);

		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'addNumbers',$_FILES);
			
	}

	public function getNumbers(){
		$data = $this->input->get_post('data');
		$data1 = json_decode($data,true);
		try{
				$data456 = array();
				//$dataxyz = array();
				//$dataccc = array();
				$phoneNumbers='';
				foreach($data1 as $dt)
		 		{
					$phoneNumbers=$phoneNumbers."'".$dt['number']."',";
					/*//echo $phoneNumbers;
					$datas = $this->userModel->getNumbers1($dt['number']);
					//echo '<pre>';print_r($datas);
					if($datas == 1){
						$data3[] = $this->userModel->getNumbers($dt['number']);
					}*/
		 		}
					
					//$this->_jsonData['status']="SUCCESS";
					//$this->_jsonData['message']="Numbers got Successfully";
					//$this->_jsonData['data456'] = $data3;

					 $phoneNumbers=substr($phoneNumbers,0,-1);
					 $data3 =array();
					 if($phoneNumbers != ''){
					 	$data3 = $this->userModel->getNumbers($phoneNumbers);
					 }
					 $this->_jsonData['status']="SUCCESS";
					 $this->_jsonData['message']="Number is App User";
					 $this->_jsonData['data456']=$data3;
					
				echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getNumbers',$_FILES);
	}
	
	public function followAccept(){
		$user_id = $this->input->get_post('user_id');
		try{
			if($user_id =="" || $user_id == false){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else{
				//$data = $this->userModel->followAcceptNumbers($user_id);
				//$j=0;
				//foreach($data as $dt){
				$data=$this->userModel->followAcceptNumbers2($user_id);
					//$j++;	
				//}
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Invitation Request Sent Successfully";
					$this->_jsonData['data']=$data;
			 }
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'followAccept',$_FILES);
	}
	
	public function inviteFriends(){
		$user_id = $this->input->get_post('user_id');
		$friend_id = $this->input->get_post('friend_id');
		$phone = $this->input->get_post('phone');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="friend_id Missing";
			}else if($phone == false || $phone == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Phone Number Missing";
			}else{
				$data = array(
							'user_id'=>$user_id,
							'friend_id'=>$friend_id,
							'phone'=>$phone,
							'status'=>'0',
							'datetime'=>date('Y-m-d H:i:s')
						);
				$res = $this->userModel->inviteFriends($data);
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Friend Invited Successfully";
				$this->_jsonData['data']=$data;
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
	}
		
	} 
	
	public function followRoute(){
		$user_id = $this->input->get_post('user_id');
		$route_id = $this->input->get_post('route_id');
		$friend_id = $this->input->get_post('friend_id');
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		$status = $this->input->get_post('status');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($route_id == false || $route_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Route Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Friend Id Missing";
			}else if($lat == false || $lat == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Latitude Is Missing";
			}else if($long == false || $long == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Longitude Is Missing";
			}else if($status == false || $status == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Status Is Missing";
			}else{
				if($status == 'public'){
					$checkFollower = $this->eventsModel->checkFollower($user_id,$route_id,$friend_id);
				//print_r($checkFollower);
					if($checkFollower == 0){
						$data = array(
									'user_id'=>$friend_id,
									'event_id'=>$route_id,
									'friend_id'=>$user_id,
									'latitude'=>$lat,
									'longitude'=>$long,
									'status'=>'accept'
								);
						//echo '<pre>';print_r($data);
						$res = $this->eventsModel->addRouteFriends($data);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Route Followed Successfully";
						$this->_jsonData['data']=$data;
					}else{
						$this->userModel->acceptFriendRoute($user_id,$friend_id,$route_id,$lat,$long);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Route Updated Successfully";
					}
				}else{
					$checkFollower = $this->eventsModel->checkFollower($user_id,$route_id,$friend_id);
				//print_r($checkFollower);
					if($checkFollower == 0){
						$data = array(
									'user_id'=>$friend_id,
									'event_id'=>$route_id,
									'friend_id'=>$user_id,
									'latitude'=>$lat,
									'longitude'=>$long
								);
						//echo '<pre>';print_r($data);
						$res = $this->eventsModel->addRouteFriends($data);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Route Followed Successfully";
						$this->_jsonData['data']=$data;
					}else{
						$this->userModel->acceptFriendRoute($user_id,$friend_id,$route_id,$lat,$long);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Route Updated Successfully";
					}
					
				}
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		
	} 
	
	public function followNearMeEvent(){
		$user_id = $this->input->get_post('user_id');
		$route_id = $this->input->get_post('route_id');
		$friend_id = $this->input->get_post('friend_id');
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($route_id == false || $route_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Route Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Friend Id Missing";
			}else if($lat == false || $lat == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Latitude Is Missing";
			}else if($long == false || $long == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Longitude Is Missing";
			}else{
				$checkFollower = $this->eventsModel->checkFollower($user_id,$route_id,$friend_id);
				if($checkFollower == 0){
					$data = array(
								'user_id'=>$friend_id,
								'event_id'=>$route_id,
								'friend_id'=>$user_id,
								'latitude'=>$lat,
								'longitude'=>$long,
								'status'=>'accept'
							);
					//echo '<pre>';print_r($data);exit;
					$res = $this->eventsModel->addRouteFriends($data);
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Near Me Event Followed Successfully";
					$this->_jsonData['data']=$data;
				}else{
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Event Already Added";
				}
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'followNearMeEvent',$_FILES);
	} 
	
	public function updateFollowLatLong(){
		$user_id = $this->input->get_post('user_id');
		$route_id = $this->input->get_post('route_id');
		$friend_id = $this->input->get_post('friend_id');
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($route_id == false || $route_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Route Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Friend Id Missing";
			}else if($lat == false || $lat == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Latitude Is Missing";
			}else if($long == false || $long == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Longitude Is Missing";
			}else{
					$data = array(
								'user_id'=>$user_id,
								'friend_id'=>$friend_id,
								'event_id'=>$route_id,
								'latitude'=>$lat,
								'longitude'=>$long
							);
					$res = $this->eventsModel->updateFollowerRoute($data);
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Route Updated Successfully";
					$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'updateFollowLatLong',$_FILES);
	} 

	public function updateLeadRouteLatLong(){
		$user_id = $this->input->get_post('user_id');
		$route_id = $this->input->get_post('route_id');
		$leadLat = $this->input->get_post('leadlat');
		$leadLong = $this->input->get_post('leadlong');
		try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($route_id == false || $route_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Route Id Missing";
			}else if($leadLat == false || $leadLat == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="lead Lat Is Missing";
			}else if($leadLong == false || $leadLong == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="lead Long Is Missing";
			}else{
					$data = array(
								'user_id'=>$user_id,
								'event_id'=>$route_id,
								'leadLat'=>$leadLat,
								'leadLong'=>$leadLong
						);
					//$res = $this->eventsModel->updateLeadRouteLatLong($data);
					$res = $this->eventsModel->insertLeadRouteLatLong($data);
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="Route Updated Successfully";
					$this->_jsonData['data']=$data;
			}
			echo json_encode($this->_jsonData);
		}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'updateLeadRouteLatLong',$_FILES);
	} 
	
	public function updateProfile(){
		 $imgData='';
		  if(isset($_REQUEST['data']))
		  {
		   $imgData = json_decode(stripslashes($_REQUEST["data"]),1);
		  }
		  
			
			if(count($imgData)>0){
				if(isset($imgData[0]['images']) != ''){
							$imgName                =    time().".png";   
							$imgPath                =    "./uploads/".$imgName;
							$imgData                =    $imgData[0]['images'];
							$data2                  =  	 str_replace("\\","",$imgData);
							$data2                  =  	 str_replace(" ","+",$data2);
							$data1                  =    base64_decode($data2);   
							$ret_img                =    file_put_contents($imgPath,$data1);       
						   // $data['images'] = $imgName;
				}else{
					$imgName = 'nopicture.jpg';
				}
			}
		   
		   
		$data['image'] = base_url()."uploads/".$imgName;
		$data['user_id'] = $this->input->get_post('user_id');
		$data['user_name'] = $this->input->get_post('user_name');
		$data['user_email'] = $this->input->get_post('user_email');
		
		
		//$data['image'] = $this->input->get_post('user_image');
	try{
			if($data['user_id'] == false || $data['user_id'] == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="user_id Missing";
			}else if($data['user_name'] == false || $data['user_name'] == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Name Missing";
			}else if($data['user_email'] == false || $data['user_email'] == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="user_email Missing";
			}else{
					$userData = $this->userModel->getUserData($data['user_id']);
					//echo '<pre>';
					//print_r($userData);
					if(count($userData)>0){
						$userData['user_name'] = $data['user_name'];
						$userData['user_email'] = $data['user_email'];
						$userData['image'] = $data['image'];						
						$this->userModel->updateUser($userData);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="User Data Updated Successfully";
						$this->_jsonData['data']=$userData; 
					}else{
						$this->_jsonData['status']="FAILURE";
						$this->_jsonData['message']="user not exits Exists";	
					}
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'updateProfile',$_FILES);
		
	}
	
	/*public function googleAuthenticate($username, $password, $source="Company-AppName-Version", $service="ac2dm") {   
					session_start();
					if( isset($_SESSION['google_auth_id']) && $_SESSION['google_auth_id'] != null)
						return $_SESSION['google_auth_id'];
				
					// get an authorization token
					$ch = curl_init();
					if(!$ch){
						return false;
					}
				
					curl_setopt($ch, CURLOPT_URL, "https://www.google.com/accounts/ClientLogin");
					$post_fields = "accountType=" . urlencode('HOSTED')
						. "&Email=" . urlencode($username)
						. "&Passwd=" . urlencode($password)
						. "&source=" . urlencode($source)
						. "&service=" . urlencode($service);
					curl_setopt($ch, CURLOPT_HEADER, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);   
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				
					// for debugging the request
					//curl_setopt($ch, CURLINFO_HEADER_OUT, true); // for debugging the request
				
					$response = curl_exec($ch);
				
					//var_dump(curl_getinfo($ch)); //for debugging the request
					
				
					curl_close($ch);
				
					if (strpos($response, '200 OK') === false) {
						return false;
					}
				
					// find the auth code
					preg_match("/(Auth=)([\w|-]+)/", $response, $matches);
				
					if (!$matches[2]) {
						return false;
					}
				
					$_SESSION['google_auth_id'] = $matches[2];
					return $matches[2];
				}
				
	public function sendMessageToPhone($authCode, $deviceRegistrationId, $msgType, $messageText) {
				
						$headers = array('Authorization: GoogleLogin auth=' . $authCode);
						$data = array(
							'registration_id' => $deviceRegistrationId,
							'collapse_key' => $msgType,
							'data.message' => $messageText //TODO Add more params with just simple data instead          
						);
						$ch = curl_init();
				
						curl_setopt($ch, CURLOPT_URL, "https://android.apis.google.com/c2dm/send");
						if ($headers)
						curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
						$response = curl_exec($ch);
						curl_close($ch);
						return $response;
					}*/

	public function userNotifications(){
		$user_id = $this->input->get_post('user_id');
	try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="user_id Missing";
			}else{
					$data = $this->userModel->getUserNotifications($user_id);
					//echo '<pre>';print_r($data);
					$j=0;
					$getDevices = $this->userModel->getDevice('users',array("user_id"=>$user_id));
					$device_id = $getDevices['device_id'];
					//$device_id = '7ac3ad8d4660e083706313e4fec9da1fb447e35848b40f97ce4228033c060ca1';
					foreach($data as $dt){
						$data[$j]['friends'] = $this->userModel->getFollowersByFollowerId($dt['event_id']);
						$followerName = $dt['UserName'];
						$eventName = $dt['event_name'];
						$msgStatus = $dt['status'];
						if($msgStatus == 'accept'){
							$this->_jsonData['status']="SUCCESS";
							//$this->_jsonData['message']='The <b>"'.$followerName.'"</b> has accepted your Request ';	
							$msg ='The "'.$followerName.'" has accepted your Request ';
							
						}else if($msgStatus == 'start'){
							$this->_jsonData['status']="SUCCESS";
							//$this->_jsonData['message']='The <b>"'.$followerName.'"</b> has sent you a Request ';	
							$msg ='The "'.$followerName.'" has sent you a Request';
						}else{
							$this->_jsonData['status']="SUCCESS";
							//$this->_jsonData['message']='The <b>"'.$followerName.'"</b> has rejected your Request ';	
							$msg ='The "'.$followerName.'" has rejected your Request ';
							
						}
						$this->userModel->sendNotification($device_id,$msg);
						$this->userModel->sendPushNotification($device_id,$passphrase='leadtheway',$msg,$badge=1);
						
						
						//print_r($msgStatus);
						//$notify = $this->sendpush();
					/*$test=$this->googleAuthenticate('masroor.ahmed@salsoft.net','itsmemasi','Leadtheway');
					$token=$test['token'];
					$deviceRegistrationId = 'APA91bFSQmKTimzss4o9zYY1rmHCOp9UyUn_jNYK3p9WpXTE3sxokRoZCA13GDWhFrcOOi0wHJXc-I8-PtaUgdt5Sn6q_pfxIU3Lr3ux7IMlfNrsoVr7ApyRMhOTgidORHUXvduLNpRvHLsDQV-2UuwCuS3Ti1MaWjs21ykoiIowXl11vWp2i7M';
					$msgType='Test';
					$msgText='Hello this is test message';
					$test1=$this->sendMessageToPhone($token,$deviceRegistrationId,$msgType,$msgText);*/
					
						$j++;
				}
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="User Notifications got Successfully";
					$this->_jsonData['data']=$data; 
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'userNotifications',$_FILES);
		
	}
	
	public function getUserOwnNotifications(){
		$user_id = $this->input->get_post('user_id');
	try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="user_id Missing";
			}else{
					$data = $this->userModel->getUsersOwnNotifications($user_id);
					/*$test=$this->googleAuthenticate('masroor.ahmed@salsoft.net','itsmemasi','Leadtheway');
					$token=$test['token'];
					$deviceRegistrationId = 'APA91bFSQmKTimzss4o9zYY1rmHCOp9UyUn_jNYK3p9WpXTE3sxokRoZCA13GDWhFrcOOi0wHJXc-I8-PtaUgdt5Sn6q_pfxIU3Lr3ux7IMlfNrsoVr7ApyRMhOTgidORHUXvduLNpRvHLsDQV-2UuwCuS3Ti1MaWjs21ykoiIowXl11vWp2i7M
';
					$msgType='Test';
					$msgText='Hello this is test message';
					$test1=$this->sendMessageToPhone($token,$deviceRegistrationId,$msgType,$msgText);*/
					$this->_jsonData['status']="SUCCESS";
					$this->_jsonData['message']="User Notifications got Successfully";
					$this->_jsonData['data']=$data; 
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getUserOwnNotifications',$_FILES);
		
	}
	
	public function getUserData(){
		$user_id = $this->input->get_post('user_id');

	try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else{
					$data = $this->userModel->getUserData($user_id);
					if(count($data)>0){
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="User Data Found Successfully";
						$this->_jsonData['data']=$data; 
					}else{
						$this->_jsonData['status']="FAILURE";
						$this->_jsonData['message']="No User Found";
					}
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getUserData',$_FILES);
		
	}
	
	public function getFriendRoutes(){
		$user_id = $this->input->get_post('user_id');
		$friend_id = $this->input->get_post('friend_id');
		$create_type = $this->input->get_post('create_type');
	try{
			if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else if($friend_id == false || $friend_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Friend Id Missing";
			}else if($create_type == false || $create_type == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="create_type Missing";
			}else{
					$data = $this->userModel->getFriendEvents($friend_id,$user_id,$create_type);
						$this->_jsonData['status']="SUCCESS";
						$this->_jsonData['message']="Friend Routes Found Successfully";
						$this->_jsonData['data']=$data; 
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
				$this->_jsonData['data']='';
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getFriendRoutes',$_FILES);
		
	}
	
	public function getAllNotifications(){
		$user_id = $this->input->get_post('user_id');
	try{
		if($user_id == false || $user_id == ""){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="User Id Missing";
			}else{

				$data = $this->eventsModel->getAllEventNotifications($user_id);
				$j=0;
					foreach($data as $dt){
						//echo '<pre>';
						//print_r($dt);
						$data[$j]['EventFriends'] = $this->userModel->getFollowersByFollowerId($dt['event_id']);
						$j++;
					}
				$data1 = $this->eventsModel->getAllRouteNotifications($user_id);
				$k=0;
					foreach($data1 as $dt1){
						//echo '<pre>';
						//print_r($dt);
						$data1[$k]['RouteFriends'] = $this->userModel->getFollowersByFollowerId($dt1['event_id']);
						$k++;
					}
				$data2 = $this->eventsModel->getAllRouteEventNotifications($user_id);
				//$data = $this->eventsModel->getAllEventNotifications();
				$this->_jsonData['status']="SUCCESS";
				$this->_jsonData['message']="Notifications Found Successfully";
				$this->_jsonData['events']=$data; 
				$this->_jsonData['routes']=$data1;
				$this->_jsonData['AllNotifications']=$data2; 
			}
		echo json_encode($this->_jsonData);
	}catch(Exception $e){
				$this->_jsonData['status']="FAILURE";
				$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getAllNotifications',$_FILES);
		
	}	

	/************************ for distance measure **********************/

	public function getDistance(){
		$lat = $this->input->get_post('lat');
		$long = $this->input->get_post('long');
		$distance = 6;
		//$data_latlon = array();

		try{
			if($lat == false || $lat == ''){
				$this->_jsonData['status']='SUCCESS';
				$this->_jsonData['message']="Latitude Missing";	
			}else if($long == false || $long == ''){
				$this->_jsonData['status']='SUCCESS';
				$this->_jsonData['message']="Longitude Missing";	
			}else{
				$latLong = $this->eventsModel->getAllLatLong($lat,$long,$distance);
				$j=0;
				$data1 = array();
				foreach($latLong as $dt){
					$data1[$j]=$dt;
					$data1[$j]['Followers'] = $this->eventsModel->getNearMeEventFollowers($dt['event_id']);
					$j++;
				}
				$this->_jsonData['status']='SUCCESS';
				$this->_jsonData['message']="Distance Measured Successfully";
				$this->_jsonData['data']=$data1;
				
			}
				echo json_encode($this->_jsonData);
		}catch(Exception $e){
			$this->_jsonData['status']=0;
			$this->_jsonData['message']="Error Occured";
		}
		$this->ServicesModel->createService($_REQUEST,$this->_jsonData,$_SERVER['SERVER_ADDR'],'getDistance',$_FILES);
		
	}

	/************************ for distance measure end **********************/
	
	/*public function sendpush(){

		//echo 'send push';
		$this->sendPushNotification('70231a1e8c85c5d67526027985dc9735fa1158844dac0b48e9a515dc86e59ac7','leadtheway','this is test',1);
	}*/
	
	
	
	//$passPhrase="leadtheway";



	
} // controller ends