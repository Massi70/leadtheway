<?php

class EventsModel extends CI_Model
	{
		private $table;
		public function __construct(){
		parent :: __construct();
	}
	
		//////////////////***************** Start Events ***********////////////////////
	
	public function insertLocation($data){
		$result = $this->db->insert('event_location', $data);	// insert data into `users` table
		return $result;
    }

	public function getLocation($user_id){
		$sql = "select e.user_id,e.latitude,e.longitude,u.user_name from event_location as e, 	users as u where e.user_id = u.user_id and u.user_id = '".$user_id."'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }

	public function addEvent($data){
		$result = $this->db->insert('events',$data);
		return $this->db->insert_id();
	}
	
	public function addEventLeadLatLong($insert){
		$result = $this->db->insert('leadlatlongs',$insert);
		return $this->db->insert_id();
	}
	
	
	public function getAllEvents($user_id,$phone){
		$sql = "(select e.user_id, e.event_id, e.event_name, e.event_type,
					e.description, e.create_type, e.latitude, e.longitude, 
					e.leadLat, e.leadLong from `events` as e 
					inner join event_friends as e_f on e_f.event_id=e.event_id 
					where (e.user_id in($user_id)  or e_f.friend_id=$user_id )
					and e_f.status !='reject' and e.create_type='events' 
					group by e.event_id order by e.event_id desc)
				
				union (select e.user_id, e.event_id, e.event_name, e.event_type,
					e.description, e.create_type, e.latitude, e.longitude, 
					e.leadLat, e.leadLong from `events` as e where e.event_type='public' 
					and	e.create_type='events' 
					group by e.event_id order by e.event_id desc )";
			
	/*	$sql = "select GROUP_CONCAT(user_id) as ids from users where phone in(".$phone.")";
		$query = $this->db->query($sql);
		$data2 = $query->row_array();
		
		$allIds=$user_id.",".$data2['ids'];
		
		$sql = "select e.user_id,
				e.event_id,
				e.event_name,
				e.event_type,
				e.description,
				e.create_type,
				e.latitude,
				e.longitude,
				e.leadLat,
				e.leadLong
				from events as e left join event_friends as e_f on e_f.event_id=e.event_id 
				where (e.user_id in($allIds)  or e_f.friend_id=$user_id )
				and	e.create_type='events' 
				and e_f.status !='reject' group by e.event_id"; 
		*/		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }
	
	public function getEventFriendsByEventId($event_id){
		$sql = "select ef.user_id,ef.friend_id,u.user_name,ef.event_id,ef.latitude,ef.longitude,ef.status
				 from event_friends as ef 
				 left join users as u on ef.friend_id=u.user_id
				 where ef.event_id = '".$event_id."' and ef.status != 'reject'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;

    }
	
	public function getAllEventsByEventId($event_id){
		$sql = "select user_id,event_id,event_name,create_type,event_type,description,
		event_date,event_time,status,latitude,longitude,leadLat,leadLong from `events` 
		where event_id = ".$event_id." and create_type = 'events'";
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }
	
	
	//////////////////***************** End Events ***********////////////////////
	
	//////////////////***************** Start Routes ***********////////////////////
	
	function addRoutes($data){
		$result = $this->db->insert('events', $data);	// insert data into `users` table	
		return $this->db->insert_id();
	}
	
	public function getAllRoutes($user_id,$phone){
		
	/*	$sql = "select GROUP_CONCAT(user_id) as ids from users where phone in(".$phone.")";
		$query = $this->db->query($sql);
		$data2 = $query->row_array();*/
		
		//$allIds=$user_id.",".$data2['ids'];
		
	$sql = "(select e.user_id, e.event_id, e.event_name, e.event_type,
					e.description, e.create_type, e.latitude, e.longitude 
					from `events` as e 
					inner join event_friends as e_f on e_f.event_id=e.event_id 
					where (e.user_id in($user_id)  or e_f.friend_id=$user_id )
					and e_f.status !='reject' and e.create_type='routes' 
					group by e.event_id order by e.event_id desc)
				
				union (select e.user_id, e.event_id, e.event_name, e.event_type,
					e.description, e.create_type, e.latitude, e.longitude 
					from `events` as e where e.event_type='public' 
					and	e.create_type='routes' 
					group by e.event_id order by e.event_id desc )"; 
	/*	$sql="SELECT e.event_id,e.user_id,ef.friend_id,ef.user_id,ef.status,e.event_type from events as e,event_friends as ef 
where ((e.event_id=ef.event_id and ef.friend_id=$user_id and ef.status!='reject' and e.event_type='private') or (e.event_type='public' or e.user_id in ($user_id)) ) 
and e.create_type='routes' group by e.event_id";*/
		
	/*	$sql = "select e.user_id,
				e.event_id,
				e.event_name,
				e.event_type,
				e.description,
				e.create_type,
				e.latitude,
				e.longitude,
				e.leadLat,
				e.leadLong
				from events as e left join event_friends as e_f on e_f.event_id=e.event_id 
				where (e.user_id in($allIds)  or e_f.friend_id=$user_id 
				and e.event_type='private') or e.event_type='public'  
				and	e.create_type='routes' 
				and (e_f.status !='reject') 
				group by e.event_id "; 
		
		*/
		/* extra added line in the above query 
		
		and e.event_type='private') or e.event_type='public'  
		
		*/
		
		
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }
	
	public function getAllRoutesById($route_id){
			
		$sql = "select user_id,event_id,event_name,create_type,event_type,description,
				event_date,event_time,status,latitude,longitude from `events` 
				where event_id = '".$route_id."' and create_type = 'routes'";
		/*$sql = "SELECT e.user_id ,e.event_id,e.event_name,e.create_type,e.event_type,e.description, 
					e.event_date,e.event_time,e.status,e.latitude,e.longitude,
					ll.leadlat as LeadLat,ll.leadlong as LeadLong
					
					from `events` as e
					left join leadlatlongs as ll on ll.event_id = e.event_id 
					and ll.user_id = e.user_id
					where e.event_id = '".$route_id."' and e.create_type = 'routes'";*/
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }
	
	public function getLeadLatLongs($route_id){
			
		/*$sql = "select user_id,event_id,event_name,create_type,event_type,description,
				event_date,event_time,status,latitude,longitude from `events` 
				where event_id = '".$route_id."' and create_type = 'routes'";*/
		
		$sql = "SELECT ll.leadlat as LeadLat,ll.leadlong as LeadLong
					
					from `events` as e
					left join leadlatlongs as ll on ll.event_id = e.event_id 
					and ll.user_id = e.user_id
					where e.event_id = '".$route_id."' and e.create_type = 'routes' 
					order by ll.id desc";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }
	
	public function getAllRoutesByRouteId($route_id){
		 $sql = "SELECT event_id,user_id,event_name,event_type,description,event_date,event_time,
		 			latitude,longitude,status from `events` where event_id = '".$route_id."' 
		 			and create_type='routes' and status = '1' order by user_id desc ";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;
    }
	
	public function addRouteFriends($data){	
		$result = $this->db->insert('event_friends', $data);	// insert data into `users` table
		//return $this->db->insert_id();
   }
   
   	public function getRouteFriendsByRouteId($event_id){
		$sql = "select ef.user_id,ef.friend_id,u.user_name,ef.event_id,ef.latitude,ef.longitude,ef.status
					from event_friends as ef  
					left join users as u on ef.friend_id=u.user_id
					where ef.event_id = '".$event_id."' and ef.status != 'reject'";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;

   }
   
    public function getNearMeEventFollowers($event_id){
		$sql = "select ef.friend_id,ef.event_id,ef.status from event_friends as ef where 
				ef.event_id = '".$event_id."' ";
		$query = $this->db->query($sql);
		$data = $query->result_array();
		return $data;

   }
   
   
   public function checkEventStatus($route_id){
	$sql = "select event_id,user_id,event_name,event_type,status from events
				where event_id = '".$route_id."' and create_type = 'events'
				and event_type = 'public'"; 
		$query = $this->db->query($sql);
		$res = $query->num_rows();
		return $res;
    }
	
	
	public function checkFollower($user_id,$route_id,$friend_id){
		$sql = "select id,user_id,friend_id,event_id,latitude,longitude from event_friends where user_id = '".$friend_id."' and event_id = '".$route_id."' and friend_id = '".$user_id."' "; 
		$query = $this->db->query($sql);
		$res = $query->num_rows();
		return $res;
    }
	
	public function updateFollowerRoute($data){
		$sql = "update event_friends set latitude = '".$data['latitude']."' , longitude = '".$data['longitude']."' 
						where user_id = '".$data['friend_id']."' and event_id = '".$data['event_id']."' 
						and friend_id = '".$data['user_id']."' "; 
		$this->db->query($sql);

    }
	

	function updateLeadRouteLatLong($data){
		$sql = "update events set leadLat = '".$data['leadLat']."' , leadLong = '".$data['leadLong']."' 
					where user_id = '".$data['user_id']."' and event_id = '".$data['event_id']."'"; 
		$this->db->query($sql);

    }
	
	function insertLeadRouteLatLong($data){
		$this->db->insert('leadlatlongs',$data);
    }
	
	function getAllLatLong($lat,$long,$distance=6){
		/*$sql = "select e.event_id,e.event_name,e.event_type,u.user_id,u.user_name,u.image,
				e.event_date,e.event_time,e.description,e.latitude,e.longitude,
				((ACOS(SIN('".$lat."' * PI() / 180) * SIN(latitude * PI() / 180) 
				+ COS('".$lat."' * PI() / 180) * COS(latitude * PI() / 180) 
				* COS(('".$long."' - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) 
				AS `distance` from events as e,users as u
				where e.user_id = u.user_id and e.create_type = 'events'
				group by e.event_id having distance<=$distance order by distance asc";*/
				
		$sql ="SELECT e.event_id,e.event_name,e.event_type,u.user_id,u.user_name,
				u.image as UserImage,e.event_date,e.event_time,e.description,e.latitude,
				e.longitude,ef.status,
				((ACOS(SIN('".$lat."' * PI() / 180) * SIN(e.latitude * PI() / 180) 
				+ COS('".$lat."' * PI() / 180) * COS(e.latitude * PI() / 180) 
				* COS(('".$long."' - e.longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) 
				AS `distance` from  `events` as e,event_friends as ef
				
				left join users as u on ef.user_id=u.user_id
				
				where e.event_id=ef.event_id and e.create_type = 'events'
				and (ef.status != 'reject')
				group by e.event_id 
				having distance<=$distance order by distance asc";


		$query = $this->db->query($sql);	
		$data = $query->result_array();
		return $data;
		
	}	
	
	function getAllEventNotifications($user_id){
		/* $sql = "SELECT e.event_id,e.user_id,e.event_name,e.event_type,e.description,
				e.create_type,ef.friend_id,ef.`status` from `events` as e,event_friends as ef 
					where e.user_id != '".$user_id."' and e.create_type = 'events' 
					and (ef.status = 'start') group by e.event_id
					order by e.event_id desc limit 0,2 "; */
					
			$sql =" select ef.id,ef.friend_id,e.user_id,e.event_id,u.user_name as UserName,
						u.image as UserImage,e.event_name,e.event_type,e.description,
						ef.status from `events` as e ,event_friends as ef
						left join users as u on u.user_id = ef.user_id
						where e.event_id = ef.event_id
						and ef.friend_id = '".$user_id."'
						and e.create_type = 'events'
											
						and (ef.status = 'start')
						group by e.event_id
						order by e.event_id desc
						limit 0,2 ";
		$query = $this->db->query($sql);	
		$data = $query->result_array();
		return $data;
		
	}
	
	function getAllRouteNotifications($user_id){
		$sql = "select ef.id,ef.friend_id,e.user_id,e.event_id,u.user_name as UserName,
					u.image as UserImage,e.event_name,e.event_type,e.description,
					ef.status from `events` as e ,event_friends as ef
					left join users as u on u.user_id = ef.user_id
					where e.event_id = ef.event_id
					and ef.friend_id = '".$user_id."'
					and e.create_type = 'routes'
					
					and (ef.status = 'start')
					group by e.event_id
					order by e.event_id desc
					limit 0,2";
		$query = $this->db->query($sql);	
		$data = $query->result_array();
		return $data;
		
	}	
	
	
	function getAllRouteEventNotifications($user_id){
	/*$sql = "select e.user_id,e.event_id,u.user_name as UserName,u.image as UserImage,
				e.event_name,e.event_type,
				e.description,e.latitude,e.longitude,e.leadLat,e.leadLong,
				ef.event_id,ef.friend_id,ef.user_id,
				ef.status from `events` as e ,event_friends as ef
				
				left join users as u on u.user_id = ef.user_id
				
				where e.event_id = ef.event_id
				group by e.event_id 
				order by e.event_id desc limit 0,2";*/
				
		$sql =	"select e.user_id,e.event_id,u.user_name as UserName,
					u.image as UserImage,e.event_name,e.event_type,e.description,
					ef.status from `events` as e ,event_friends as ef
					
					left join users as u on u.user_id = ef.user_id
					where e.event_id = ef.event_id
					
					and ef.friend_id = '".$user_id."' 
					
					and (ef.status = 'start')
					group by e.event_id
					order by e.event_id desc limit 0,2";
				
				
		$query = $this->db->query($sql);	
		$data = $query->result_array();
		return $data;
				
	}
	
	
	
	
	
	

	//////////////////***************** End Routes ***********////////////////////
		


}

?>