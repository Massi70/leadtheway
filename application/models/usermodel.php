<?php

class UserModel extends CI_Model {
	private $table;
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }
	
	function getUserData($user_id)
	{
		$sql="SELECT user_id, fb_id, user_name, user_email, phone, password,status,
		image from users where user_id='".$user_id."' ";
		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	return 	$data;
    }
	
	function updateUser($data){	
		$conditions=array('user_id'=>$data['user_id']);
		$result = $this->db->update('users', $data,$conditions);
		//return $this->db->insert_id();
	}
	
	public function checkUser($user_email){
		$sql = "select user_id,user_name,user_email,password,
				CONCAT('".base_url()."uploads/',image) as image,status from users 
				where user_email='".$user_email."'";
		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	return 	$data;
   }
   
   	public function checklogin($user_email,$password){
		$sql = $this->db->get_where("users",array("user_email"=>$user_email,"password"=>$password));
		$res = $sql->num_rows();
		return $res;
   }

	public function login($user_email,$password){
		$sql = "SELECT user_id, user_name, user_email, phone, password,
		 CONCAT('".base_url()."uploads/',image) as image , status, device_id from users
		 where user_email ='".$user_email."' and password = '".$password."'" ;

		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	return $data;			
   }   
   
    public function fbLogin($fb_id){
		$sql = $this->db->query('select * from users where fb_id="'.$fb_id.'"');
		$res = $sql->row_array();
		return $res;
   } 
   
   function insertUserDeviceID($data){	
   		//print_r($data);
		//$result = $this->db->insert('devices', $data);
		//return $this->db->insert_id();
		$sql = "update users set device_id = '".$data['device_id']."' where user_id = ".$data['user_id']."";
		$this->db->query($sql);
	}

		
    public function addUser($data){	
		$result = $this->db->insert('users', $data);	// insert data into `users` table
		return $this->db->insert_id();
   }
   
	function checkFriend($user_id,$phone)
	{
		$sql = "select * from friends where user_id = '$user_id' and phone = '$phone' "; 
		$query = $this->db->query($sql);
		$res = $query->num_rows();
		return $res;
    }
	
	function getUserInvitation($user_id,$phone){
		$sql = "select id from friends where user_id=$user_id and phone=$phone and status=0";	
		$query=$this->db->query($sql);
		$data=$query->row_array();
		return $data;			
	}
	
	public function inviteFriends($data){
		$result = $this->db->insert('friends',$data);
		return $this->db->insert_id();
    }
	
	function acceptFriendInvitation($data,$id){
		$conditions=array('id'=>$data['id']);
		$result = $this->db->update('friends', $data,$conditions);
		return $result;
	}
	
	function deleteFriendInvitation($id){
		$result = $this->db->delete('friends', array('id'=>$id));	
		return $result;
	}
	
	function addNumbers($dt){
		$this->db->insert('numbers', $dt);
	}
	
	function getAllNumbers(){
		$sql = "SELECT id,user_id,name,number,status from numbers";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	function checkPhoneNumber($number){
		 $sql = $this->db->get_where("users",array("phone"=>$number));
		 $res = $sql->num_rows();
		 return $res;
    }
	
	function checkPhoneNumbers($number){
		 $sql = $this->db->get_where("numbers",array("number"=>$number));
		 $res = $sql->num_rows();
		 return $res;
    }
	
	function getNumbers($phone){	
		$sql = "select user_id,user_name,phone,image,status from users where phone in(".$phone.")";
		$query = $this->db->query($sql);
		$data2 = $query->result_array();
		return $data2;
	}
	
	function getNumbers1($phone){	
		$sql = "select user_id,user_name,phone,image,status from users where phone in(".$phone.")";
		$query = $this->db->query($sql);
		$data2 = $query->num_rows();
		return $data2;
	}
	
	function followAcceptNumbers2($user_id){	
		$sql = "SELECT numbers.id,numbers.name,numbers.number,numbers.user_id 
					from numbers,users where numbers.number = users.phone and numbers.user_id = '".$user_id."'";
		$query = $this->db->query($sql);
		$data2 = $query->result_array();
		return $data2;
	}
	
	function addFollower($data1,$res){
		//$this->db->insert('event_friends',$data1);	
		$sql = "insert into event_friends values(null,'".$data1['user_id']."','".$res."',
				'".$data1['friend_id']."','start',0,0,'unread')";
		$this->db->query($sql);
		
	}
	
	function getUserRouteRequest($user_id,$friend_id,$route_id){
		$sql = "select id from event_friends where user_id='".$user_id."' 
			and friend_id='".$friend_id."' and event_id = '".$route_id."' status='start'" ;	
		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	return $data;			
	}
	
	function acceptFriendRoute($user_id,$friend_id,$route_id,$lat,$long){
		//$conditions=array('id'=>$data['id']);
		//$result = $this->db->update('following', $data,$conditions);	// insert data into `users` table	
		//return $result;
		$sql = "update event_friends set status = 'accept', latitude = '".$lat."',
			 longitude = '".$long."' where user_id = '".$friend_id."' 
			and friend_id = '".$user_id."' and event_id = '".$route_id."' and status = 'start' ";
		$this->db->query($sql);
	}
	
	
	function rejectFriendRoute($user_id,$friend_id,$route_id){
		 $sql="update event_friends set status = 'reject' where user_id = '".$friend_id."'
			and friend_id = '".$user_id."' and event_id = '".$route_id."'";
		$this->db->query($sql);
	}
	
	function getUserNotifications($user_id){
		
		$sql = "select ef.id as NotificationId,e.user_id,e.event_id,u.user_name as UserName,u.image as UserImage,
					e.event_name,e.event_type,
					e.description,e.latitude,e.longitude,lll.leadLat,lll.leadLong,
					ef.event_id,ef.friend_id,ef.user_id,ef.status, u1.user_name as FollowerName
					from `events` as e 
					left join event_friends as ef on ef.event_id = e.event_id
					left join users as u on u.user_id = ef.user_id
					INNER JOIN users AS u1 ON u1.user_id = ef.friend_id
					left JOIN leadlatlongs as lll on lll.event_id = e.event_id
					where e.event_id = ef.event_id
					and (e.user_id = '".$user_id."' or ef.friend_id = '".$user_id."')
					and ef.notify = 'unread'
					group by e.event_id";
		
		/* below working query before the addition of table leadlatlongs in db and above the revised query*/
		
		/*$sql = "select e.user_id,e.event_id,u.user_name as UserName,u.image as UserImage,
				e.event_name,e.event_type,
				e.description,e.latitude,e.longitude,e.leadLat,e.leadLong,
				ef.event_id,ef.friend_id,ef.user_id,
				ef.status from `events` as e ,event_friends as ef
				
				left join users as u on u.user_id = ef.user_id
				
				where e.event_id = ef.event_id
				and (e.user_id = '".$user_id."' or ef.friend_id = '".$user_id."')
				group by e.event_id"; */
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	public function updateNotifications($id){
		$sql = "update event_friends set notify = 'read' 
					where id = '".$id."'";		
		$query = $this->db->query($sql);
	}
	
	function getUsersOwnNotifications($user_id){
		$sql = "select e.user_id,e.event_id,u.user_name as UserName,
					u.image as UserImage,e.event_name,e.event_type,
					ef.status from `events` as e ,event_friends as ef
					
					left join users as u on u.user_id = ef.user_id
					where e.event_id = ef.event_id
					
					and ef.friend_id = '".$user_id."' 
					and e.user_id != ef.friend_id
					and ef.status = 'start'
					group by e.event_id"; 
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
		
	}
	
/*	function getUsersFriendNotifications($user_id,$friend_id){
		$sql = "select e.user_id,e.event_id,u.user_name as UserName,
					e.event_name,e.event_type,
					ef.friend_id,ef.status from `events` as e ,event_friends as ef
					
					left join users as u on u.user_id = ef.user_id
					where e.event_id = ef.event_id
					
					and ef.friend_id = '".$friend_id."' and ef.user_id = '".$user_id."'
					and e.user_id != ef.friend_id
					and ef.status = 'start'
					group by e.event_id "; 
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
		
	}*/
	
	
	public function getFollowersByFollowerId($event_id){
		$sql = "select ef.user_id,ef.friend_id,ef.event_id,ef.latitude,ef.longitude,ef.status,
				u.user_id,u.user_name as FriendName, u.image as FollowerImage
				from event_friends as ef,users as u
				where ef.user_id = u.user_id
				and ef.status !='start'
				and ef.event_id = '".$event_id."' and ef.status != 'reject'";		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	/*public function getFriendRoutes($user_id){
		$sql = "SELECT event_id,user_id,event_name,event_type,create_type,description,
				latitude,longitude,`status`,leadLat,leadLong from `events`
 				where user_id = '".$user_id."' and create_type = 'routes'";		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}*/
	
	public function getFriendEvents($user_id,$friend_id,$createType){
		
		$sql = "SELECT events.event_id,
				events.user_id,
				events.event_name,
				events.event_type,
				events.create_type,
				events.description,
				events.latitude,
				events.longitude,
				event_friends.status,
				if(event_friends.friend_id is null,0,1) as event_join_status  from `events`
				left join event_friends on event_friends.event_id = events.event_id 
				and event_friends.friend_id = '".$friend_id."'
				where events.user_id = '".$user_id."' and create_type = '".$createType."'
				and (event_friends.status != 'reject' or event_friends.status is null)";
		
		
		/* below working query before the addition of table leadlatlongs in db and above the revised query*/
			
		/*$sql = "SELECT events.event_id,
				events.user_id,
				events.event_name,
				events.event_type,
				events.create_type,
				events.description,
				events.latitude,
				events.longitude,
				events.leadLat,
				events.leadLong,
				event_friends.status,
				if(event_friends.friend_id is null,0,1) as event_join_status  from `events`
				left join event_friends on event_friends.event_id = events.event_id 
				and event_friends.friend_id = '".$friend_id."'
				where events.user_id = '".$user_id."' and create_type = '".$createType."'
				and (event_friends.status != 'reject' or event_friends.status is null)";	*/	
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
	}
	
	function sendNotification($device_id,$message) {
		/*echo $device_id;
		echo "<br>";
		echo $message;*/
		
		// note: you have to specify API key in config before
		$this->load->library('gcm');
		// simple adding message. You can also add message in the data,
		// but if you specified it with setMesage() already
		// then setMessage's messages will have bigger priority
		$msg = $this->gcm->setMessage($message);
		//var_dump($message);
		
		// add recepient or few
		$this->gcm->addRecepient($device_id);
		//var_dump($device_id);
		// set additional data
		//$this->gcm->setData($params);
		// also you can add time to live
		$this->gcm->setTtl(500);
		// and unset in further
		//$this->gcm->setTtl(false);
		
		// set group for messages if needed
		//$this->gcm->setGroup('Test');
		// or set to default
		//$this->gcm->setGroup(false);
		// send
		return $this->gcm->send();
	}
	
	function getDevice($friend_id){
		// friend_id
		//$sql = $this->db->get_where($table,$condition);
		//$res = $sql->row_array();
		//return $res;
		$sql = "select user_id,device_id,user_name from users where user_id = '".$friend_id."'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
		
	}
	
	/*function sendIOSNotification($device_id,$parsedAlert, $params, $badge) {
		// load models
			$lib = $this->load->library('apn');		
		$message = $parsedAlert;
		
			// load library
			var_dump($lib);exit;
			$this->apn->payloadMethod = 'enhance'; // you can turn on this method for debuggin purpose
			$this->apn->connectToPush();
			//$params = array_merge($params,array('sound' => $user->ringtone));
			
			// adding custom variables to the notification
			$this->apn->setData($params);
		
			$send_result = $this->apn->sendMessage(trim($device_id), $message, /*badge*/  //$badge, /*sound*/ 'default'  );
			//$this->apn->disconnectPush();
	//}
	
	function sendPushNotification($deviceToken,$passphrase,$msg,$badge){
	//var_dump($deviceToken);
	//var_dump($passphrase);
		$ctx = stream_context_create();
		stream_context_set_option($ctx, 'ssl', 'local_cert', 'certificate.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		
	//	echo 'Connected to APNS' . PHP_EOL;
		
		// Create the payload body
		 $body['aps'] = array(
			'alert' => $msg,
			'sound' => 'default'
			);
		
		// Encode the payload as JSON
		$payload = json_encode($body);
		
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		if (!$result){
			//echo 'Message not delivered' . PHP_EOL;
		}else{
			//echo 'Message successfully delivered' . PHP_EOL;
		}
		// Close the connection to the server
		fclose($fp);
		return $result;
		
	}
		
	/*function logOut($user_id){
		$sql = "update users set status = '0' where user_id = '".$user_id."'";
		$this->db->query($sql);
	}*/
	


}

?>