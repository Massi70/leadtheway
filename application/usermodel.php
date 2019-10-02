<?php

class UserModel extends CI_Model {

	private $table;

    public function __construct(){

        // Call the Model constructor

        parent::__construct();

		$this->load->library('memcached_library');

		

    }

	

    public function getUserData($uId,$refresh=0){

		$key=APP_NAME.'user-'.$uId;

		$data = $this->memcached_library->get($key);

	

		if($refresh==1){

			$data =false;

		}

		if($data==false){

			$this->db->select('user_id,first_name,last_name,user_name,user_email,user_status,user_gender,user_image,user_coins')->from('user')->where('user_id',$uId);

			$query= $this->db->get();

			$data=$query->row_array();

			$this->memcached_library->set($key,$data);

		}

		return $data;

	}

	

	public function createUser($data){

		if($this->db->insert('user', $data)){

			 $userId=$this->db->insert_id() ;

			 $this->getUserData($userId,1);

		 	 return  $userId;

		}else{

			return false;

		}

    }

	

	public function getCategory()

	{

		$key=APP_NAME.'get_cat';

		$data = $this->memcached_library->get($key);

	 

		if($data==false){

			$query=$this->db->query("select category_id,category_name from category");

			$data=$query->result_array();

			$this->memcached_library->set($key,$data);

		}

		return $data;

	}

	public function submit_bet($data)

	{

		$query=$this->db->query("select category_id from category where category_name='".$data['category']."'");

		$res=$query->row_array();

		$this->db->query("insert into bet
							set
							`title`='".$data['title']."',
							`category_id`='".$res['category_id']."',
							`question`='".$data['question']."',
							`answer_type`='".$data['answer_title']."',
							`my_answer`='".$data['my_answer']."',
							`your_answer`='".$data['your_answer']."',
							`wager`='".$data['wager']."',
							`acceptor_id`='".$data['aceptor_id']."',
							`creater_id`='".$data['creater_id']."',
							`post`='".$data['post']."',
							`time_limit`='".$data['timelimit']."',
							`expiration`='".$data['expire']."',
							`tount_friend`='".$data['tount_friend']."',
							`bet_status`='pending',
							`datetime`=CURDATE()
							");

			if($this->db->affected_rows()){

				$query=$this->db->query("select * from user where user_id='".$data['creater_id']."' ");

				$res_1=$query->row_array();

				$coins = $res_1['user_coins']-$data['wager'];

				// update creater  wager 

				$this->db->query("update user set user_coins='".$coins."' where user_id='".$data['creater_id']."'  ");
				//// get last bet id 
				$query=$this->db->query("select * from bet where creater_id='".$data['creater_id']."' and  acceptor_id='".$data['aceptor_id']."' order by bet_id DESC");
				$res=$query->row_array();
				//// submit notification 
				$post ='new_bet';
				if($data['post']=='forum'){
					$post ='general_bet';
				}
				$this->db->query("insert into notification
							set
							`user_id`='".$data['aceptor_id']."',
							`sender_id`='".$data['creater_id']."',
							`type`='".$post."',
							`bet_id`='".$res['bet_id']."',
							`status`='0',
							`datetime`=SYSDATE()
							");
				if($this->db->affected_rows()){
					return $res['category_id'];
				}
			}
	}
	/// for submit bet history 
	public function submit_bet_histroy($data)
	{
		$sql ="select bet_id from bet where acceptor_id='".$data['aceptor_id']."' and creater_id='".$data['creater_id']."' and wager='".$data['wager']."' order by bet_id DESC  limit 1";
		$query=$this->db->query($sql);
		$res=$query->row_array();
		$this->db->query("insert into bet_history
							set
							`bet_id`='".$res['bet_id']."',
							`wager`='".$data['wager']."',
							`acceptor_id`='".$data['aceptor_id']."',
							`creater_id`='".$data['creater_id']."',
							`datetime`=CURDATE()
							");
			if($this->db->affected_rows()){
				///// 
					return true;
			}
	}
	
	public function update_bet_histroy($data)

	{

		$sql ="update bet_history set type='refund' where  acceptor_id='".$data['acceptor_id']."' and creater_id='".$data['creater_id']."' and wager='".$data['wager']."'   and bet_id='".$data['bet_id']."'";

		$query=$this->db->query($sql);

		//$this->db->affected_rows()

		//$res=$query->row_array();

		// get creater id detail 

		$query=$this->db->query("select * from user where user_id='".$data['creater_id']."' ");

		$res_1=$query->row_array();

		$coins = $res_1['user_coins']+$data['wager'];

		// update creater  wager 

				$this->db->query("update user set user_coins='".$coins."' where user_id='".$data['creater_id']."'  ");

		if($this->db->affected_rows()){

				///// 

					return true;

				

			}

	}

	

	public function getBetNotifiCount($user_id)

	{

		$res=array();

		$query=$this->db->query("SELECT COUNT(n.notification_id) as countNotifiId  FROM notification AS n WHERE n.user_id='".$user_id."' AND n.status=0");

		$res['all_notification']=$query->row_array();

		$query=$this->db->query("SELECT COUNT(n.notification_id) as countNotifiId FROM notification AS n WHERE n.user_id='".$user_id."' AND `type`='proposed_bet' AND n.status=0

 ");

 		$res['proposed_bet'] = $query->row_array();

		$query=$this->db->query("SELECT COUNT(n.notification_id) as countNotifiId FROM notification AS n WHERE n.user_id='".$user_id."' AND `type`='new_bet' AND n.status=0

 ");

 		$res['new_bet']=$query->row_array();

		

 		$query=$this->db->query("SELECT COUNT(n.notification_id) as countNotifiId  FROM notification AS n WHERE n.user_id='".$user_id."' AND `type`='general_bet' AND n.status=0

 ");

 		$res['general_bet']=$query->row_array();

		return $res;

		

	}

	

	public function getNotifications($data1)

	{

		$offSet =$data1['offSet'] ;

		$limit = $data1['limit'];

		$key=APP_NAME.'get_notification';

		$data = $this->memcached_library->get($key);

		if($data==false){

		

					$sql ="SELECT

			  n.bet_id,

			  n.datetime,

			  n.notification_id,

			  n.sender_id,

			  n.status,

			  n.type,

			  n.user_id,

			  u.first_name AS rec_f_name ,u.last_name  AS rec_l_name,

			  su.first_name AS sen_f_name  ,su.last_name AS sen_l_name ,

			  b.bet_id,b.bet_status,b.acceptor_id,b.creater_id,b.expiration,b.title,b.question

			FROM notification AS n,

			  `user` AS u,

			  `user` AS su , bet AS b 

			WHERE u.user_id=n.user_id AND su.user_id=n.sender_id AND b.bet_id=n.bet_id AND ";

			if($data1['title']=='Notification' || $data1['title']=='General Forum Bets'){

					$sql.= " ( n.user_id = '".$data1['user_id']."' OR n.sender_id= '".$data1['user_id']."') ";

			}else{

					$sql.= " n.user_id = '".$data1['user_id']."'  ";

			} 

			if($data1['title']=='General Forum Bets'){

				$sql.= " AND n.type='general_bet'";

			}if($data1['title']=='New Bets Requests'){

				$sql.= " AND n.type='new_bet'";

			}

			if($data1['title']=='Proposed Bets'){

				$sql.= " AND n.type='proposed_bet'";

			}

			$sql.= " GROUP BY n.bet_id ORDER BY n.bet_id DESC ,n.status ASC limit $offSet, $limit  ";

			

			$query=$this->db->query($sql);

			$data=$query->result_array();

			$this->memcached_library->set($key,$data);

			

		}

    		

			/*if($this->db->affected_rows()){

				//// get last bet id 

				$query=$this->db->query("select * from bet where creater_id='".$data['creater_id']."' and  acceptor_id='".$data['aceptor_id']."' order by bet_id DESC");

				$res=$query->row_array();

				//// submit notification 

				$post ='new_bet';

				if($data['post']=='forum'){

					$post ='general_bet';

				}

				$this->db->query("insert into notification

							set

							`user_id`='".$data['aceptor_id']."',

							`sender_id`='".$data['creater_id']."',

							`type`='".$post."',

							`bet_id`='".$res['bet_id']."',

							`status`='0',

							`datetime`=SYSDATE()

							");

				if($this->db->affected_rows()){

					///// 

					return true;

					

				}

				

			}*/

		return $data;

	}

	

	public function getNotificationsCount($data1)

	{

		$sql ="SELECT

			  count(n.bet_id) as betCount

			FROM notification AS n,

			  `user` AS u,

			  `user` AS su , bet AS b 

			WHERE u.user_id=n.user_id AND su.user_id=n.sender_id AND b.bet_id=n.bet_id AND ";

			if($data1['title']=='Notification' || $data1['title']=='General Forum Bets'){

					$sql.= " ( n.user_id = '".$data1['user_id']."' OR n.sender_id= '".$data1['user_id']."') ";

			}else{

					$sql.= " n.user_id = '".$data1['user_id']."'  ";

			} 

			if($data1['title']=='General Forum Bets'){

				$sql.= " AND n.type='general_bet'";

			}

			if($data1['title']=='New Bets Requests'){

				$sql.= " AND n.type='new_bet'";

			}

			if($data1['title']=='Proposed Bets'){

				$sql.= " AND n.type ='proposed_bet'";

			}

			//echo $sql;

			$query=$this->db->query($sql);

			$data  = $query->row_array();

			return $data['betCount'];

	}

	

	//// get notification by  id

	

	public function getNotifiByID($data1)

	{

		

		$key=APP_NAME.'get_notification_detail';

		$data = $this->memcached_library->get($key);

		if($data==false){

		

					$sql ="SELECT

			  n.bet_id,

			  n.datetime,

			  n.notification_id,

			  n.sender_id,

			  n.status,

			  n.type,

			  n.user_id,

			  u.first_name AS rec_f_name ,u.last_name  AS rec_l_name,

			  su.first_name AS sen_f_name  ,su.last_name AS sen_l_name ,

			  b.bet_id,b.bet_status,b.acceptor_id,b.creater_id,b.expiration,b.title,b.question

			FROM notification AS n,

			  `user` AS u,

			  `user` AS su , bet AS b 

			WHERE u.user_id=n.user_id AND su.user_id=n.sender_id AND b.bet_id=n.bet_id AND ";

			if($data1['title']=='Notification' || $data1['title']=='General Forum Bets'){

					$sql.= " ( n.user_id = '".$data1['user_id']."' OR n.sender_id= '".$data1['user_id']."') ";

			}else{

					$sql.= " n.user_id = '".$data1['user_id']."'  ";

			} 

			if($data1['title']=='General Forum Bets'){

				$sql.= " AND n.type='general_bet'";

			}if($data1['title']=='New Bets Requests'){

				$sql.= " AND n.type='new_bet'";

			}

			if($data1['title']=='Proposed Bets'){

				$sql.= " AND n.type='proposed_bet'";

			}

			$sql.= " and n.bet_id = '".$data1['bet_id']."' GROUP BY n.bet_id ORDER BY n.bet_id DESC ,n.status ASC ";

			

			$query=$this->db->query($sql);

			$data=$query->result_array();

			$this->memcached_library->set($key,$data);

			

		}

    		

			/*if($this->db->affected_rows()){

				//// get last bet id 

				$query=$this->db->query("select * from bet where creater_id='".$data['creater_id']."' and  acceptor_id='".$data['aceptor_id']."' order by bet_id DESC");

				$res=$query->row_array();

				//// submit notification 

				$post ='new_bet';

				if($data['post']=='forum'){

					$post ='general_bet';

				}

				$this->db->query("insert into notification

							set

							`user_id`='".$data['aceptor_id']."',

							`sender_id`='".$data['creater_id']."',

							`type`='".$post."',

							`bet_id`='".$res['bet_id']."',

							`status`='0',

							`datetime`=SYSDATE()

							");

				if($this->db->affected_rows()){

					///// 

					return true;

					

				}

				

			}*/

		return $data;

	}

	

	///// update notification 

	

	public function updateNotifi($data)

	{

		$this->db->query("update notification set status=1,datetime=SYSDATE() where  notification_id='".$data['notification_id']."' ");

		

		if($this->db->affected_rows()){

				//// get last bet id 

			return true;

		}

		

		

	}

	

	

	public function getBets($user_id,$cat_id)

	{

		$key=APP_NAME.'get_bat';

		$data = $this->memcached_library->get($key);

	 

		if($data==false){

			

			/*$query1=$this->db->query(" SELECT bet_id,expiration,`datetime` FROM bet WHERE acceptor_id='".$user_id."' AND bet_status!='expire' AND bet_status!='approved' and bet_status!='voting end' ");

			$data1=$query1->result_array();

			foreach($data1 as $res)

			{

				if(strtotime(date('d-M-Y')) > strtotime(date('d-M-Y',strtotime($res['datetime']."+".$res['expiration'] ."day"))))

				{

			$this->db->query("update bet set bet_status='expire' where acceptor_id='".$user_id."' and bet_id='".$res['bet_id']."' ");

				}

			}*/

			$sql ="SELECT us.user_name,bt.bet_id,bt.question,bt.datetime,bt.expiration ,bt.wager,bt.creater_id,bt.category_id FROM bet bt JOIN `user` us ON bt.creater_id=us.user_id WHERE (bt.acceptor_id='".$user_id."' OR bt.creater_id='".$user_id."') AND bet_status!='expire' AND bet_status!='approved' and bet_status!='voting end' and bet_status!='delete'";

			if($cat_id!=9){

				$sql.= " and category_id='".$cat_id."'";

			}

			

			//$sql.="ORDER BY bt.bet_id DESC ";

			$query=$this->db->query($sql);

			$data=$query->result_array();

			$this->memcached_library->set($key,$data);

			

		}

		return $data;

		

	}

	

	public function updateBet($user_id,$bet_id)

	{

		$this->db->query("update bet set bet_status='approved',datetime=SYSDATE() where acceptor_id='".$user_id."' and bet_id='".$bet_id."' ");

		

		if($this->db->affected_rows()){

				// get bet  detail

				$query=$this->db->query("select * from bet where  bet_id='".$bet_id."' ");

				$result=$query->row_array();

				

				// get creater id detail 

				

				/*$query=$this->db->query("select * from user where user_id='".$result['creater_id']."' ");

				$res_1=$query->row_array();

				$coins = $res_1['user_coins']-$result['wager'];

				// update creater 

				$this->db->query("update user set user_coins='".$coins."' where user_id='".$result['creater_id']."'  ");*/

				

				// get acceptor id detail 

				

				$query=$this->db->query("select * from user where user_id='".$result['acceptor_id']."' ");

				$res_1=$query->row_array();

				

				$coins = $res_1['user_coins']-$result['wager'];

				// update creater 

				$this->db->query("update user set user_coins='".$coins."' where user_id='".$result['acceptor_id']."'  ");

				

				$this->db->query("insert into bet_history

							set

							`bet_id`='".$result['bet_id']."',

							`wager`='".$result['wager']."',

							`acceptor_id`='".$result['acceptor_id']."',

							`creater_id`='".$result['creater_id']."',

							`datetime`=CURDATE()

				");

				

				

				

				//// get last bet id 

				$query=$this->db->query("select * from notification where bet_id='".$bet_id."'");

				$res=$query->row_array();

				//// submit notification 

				$this->db->query("update notification

							set

							`user_id`='".$res['user_id']."',

							`sender_id`='".$res['sender_id']."',

							`type`='".$res['type']."',

							`bet_id`='".$bet_id."',

							`status`='0',

							`datetime`=SYSDATE()

							where 

							`bet_id`='".$bet_id."'

							");

				if($this->db->affected_rows()){

					///// 

					return true;

					

				}

				

			}

	}

	

	public function getAllBets($cat_id,$user_id,$data1)

	{

		$offSet =isset($data1['offSet']) ? $data1['offSet'] : 0;

		$limit = isset($data1['limit']) ? $data1['limit'] : 2;

		$key=APP_NAME.'get_allbet';

		$result = $this->memcached_library->get($key);

		if($result==false){

		

		/*$query1=$this->db->query("SELECT bet_id,time_limit,datetime FROM bet WHERE bet_status='approved' and category_id='".$cat_id."' ");

			$data1=$query1->result_array();

			foreach($data1 as $res)

			{

				if(strtotime(date('d-M-Y')) > strtotime(date('d-M-Y',strtotime($res['datetime']."+".$res['time_limit'] ."day"))))

				{

			$this->db->query("update bet set bet_status='voting end' where bet_id='".$res['bet_id']."' ");

				}

			}*/

		$sql = "SELECT bt.creater_id,bt.acceptor_id,bt.bet_id,bt.category_id,bt.question,bt.my_answer,bt.answer_type,bt.your_answer,bt.wager,us.user_name AS acceptor_name,usa.user_name AS creator_name,(SELECT answer_type FROM vote WHERE bet_id=bt.bet_id AND user_id='".$user_id."')AS vote_answer FROM bet bt JOIN `user` us ON bt.acceptor_id=us.user_id JOIN `user` usa ON bt.creater_id=usa.user_id WHERE bet_status='approved' and bet_status!='delete' ";

		if($cat_id!=9){

			$sql.= "  and bt.category_id='".$cat_id."'";

		}

		$sql.=" ORDER BY bt.bet_id desc";

		$sql.= " limit $offSet, $limit";

		

		$query=$this->db->query($sql);

		$result=$query->result_array();

		$this->memcached_library->set($key,$result);

	}

		return $result;

	}

	

	/// get All Bets count 

	

	public function getAllBetsCount($cat_id,$user_id)

	{

		

		 $sql ="SELECT  count(bt.bet_id)  as count_all_bets, (SELECT answer_type FROM vote WHERE bet_id=bt.bet_id AND user_id='".$user_id."')AS vote_answer FROM bet bt JOIN `user` us ON bt.acceptor_id=us.user_id JOIN `user` usa ON bt.creater_id=usa.user_id WHERE bet_status='approved' ";

		if($cat_id!=9){

			$sql.= "  and bt.category_id='".$cat_id."'";

		}

		

		

		$query=$this->db->query($sql);

		$data =$query->row_array();

		return $data['count_all_bets'];

	

}

	

	public function detailBet($bet_id,$user_id)

	{

		$key=APP_NAME.'get_detailbet';

		$result = $this->memcached_library->get($key);

		if($result==false){

			$query=$this->db->query("SELECT bt.bet_id,bt.creater_id,bt.acceptor_id,bt.category_id,bt.question,bt.my_answer,bt.answer_type,bt.your_answer,bt.wager,us.user_name AS acceptor_name,usa.user_name AS creator_name,(SELECT answer_type FROM vote WHERE bet_id=bt.bet_id AND user_id='".$user_id."')AS vote_answer FROM bet bt JOIN `user` us ON bt.acceptor_id=us.user_id JOIN `user` usa ON bt.creater_id=usa.user_id where bt.bet_id='".$bet_id."'");

			$result=$query->row_array();

			$this->memcached_library->set($key,$result);

			}

		return $result;

	}

	

	public function getSpecBet($bet_id)

	{

		$key=APP_NAME.'get_specifbet';

		$result = $this->memcached_library->get($key);

		if($result==false){

			$query=$this->db->query("SELECT * from bet where bet_id='".$bet_id."'");

			$result=$query->row_array();

			$this->memcached_library->set($key,$result);

			}

		return $result;

	}

	

	public function submitRepropseBet($data){

		if(is_numeric($data['category_id'])){

			$category_id=$data['category_id'];

			}else{

		$query=$this->db->query("select category_id from category where category_name='".$data['category_id']."'");

		$res=$query->row_array();

		$category_id=$res['category_id'];

		}

		$this->db->query("update bet

							set

							`title`='".$data['title']."',

							`category_id`='".$category_id."',

							`question`='".$data['question']."',

							`answer_type`='".$data['answer_title']."',

							`my_answer`='".$data['my_answer']."',

							`your_answer`='".$data['your_answer']."',

							`wager`='".$data['wager']."',

							`acceptor_id`='".$data['aceptor_id']."',

							`creater_id`='".$data['creater_id']."',

							`post`='".$data['post']."',

							`time_limit`='".$data['timelimit']."',

							`expiration`='".$data['expire']."',

							`tount_friend`='".$data['tount_friend']."',

							`bet_status`='pending',

							`datetime`=SYSDATE()

							where 

							`bet_id`='".$data['bet_id']."'

							");

			if($this->db->affected_rows()){

				/// insert  mentain creater history

				$this->db->query("insert into bet_history

							set

							`bet_id`='".$data['bet_id']."',

							`wager`='".$data['wager']."',

							`acceptor_id`='".$data['aceptor_id']."',

							`creater_id`='".$data['creater_id']."',

							`datetime`=CURDATE()

							");

			

				$query=$this->db->query("select * from user where user_id='".$data['creater_id']."' ");

				$res_1=$query->row_array();

				$coins = $res_1['user_coins']-$data['wager'];

				// update creater  wager 

				$this->db->query("update user set user_coins='".$coins."' where user_id='".$data['creater_id']."'  ");

			

			//// get last bet id 

			$query=$this->db->query("select * from notification where bet_id='".$data['bet_id']."'");

			$res=$query->row_array();

			//// submit notification 

			$post ='proposed_bet';

			if($data['post']=='forum'){

				$post ='general_bet';

			}

			$this->db->query("update notification

						set

						`user_id`='".$data['aceptor_id']."',

						`sender_id`='".$data['creater_id']."',

						`type`='".$post."',

						`bet_id`='".$data['bet_id']."',

						`status`='0',

						`datetime`=SYSDATE()

						where 

						`bet_id`='".$data['bet_id']."'

					");

			if($this->db->affected_rows()){

					///// 

					return true;

					

				}

				

			}

		}

		

	public function MyBets($user_id,$cat_id,$data)

	{

		$offSet =isset($data['offSet']) ? $data['offSet'] : 0;

		$limit = isset($data['limit']) ? $data['limit'] : 2;

		$key=APP_NAME.'get_mybet';

		$result = $this->memcached_library->get($key);

		

		if($result==false){

			

		 $sql= "SELECT bt.bet_id,bt.creater_id,bt.acceptor_id,bt.category_id,bt.question,bt.my_answer,bt.answer_type,

bt.your_answer,bt.wager,us.user_name AS acceptor_name,usa.user_name AS creator_name 

,(SELECT COUNT(vote_id)AS my_answer FROM vote WHERE bet_id=bt.bet_id AND answer_type='my_answer')AS my_answer_vote,

(SELECT COUNT(vote_id)AS my_answer FROM vote WHERE bet_id=bt.bet_id AND answer_type='your_answer')AS your_answer_vote FROM bet bt JOIN `user` us ON bt.acceptor_id=us.user_id JOIN `user` usa 

ON bt.creater_id=usa.user_id WHERE(bt.creater_id='".$user_id."' 

OR bt.acceptor_id='".$user_id."' OR bt.bet_id IN(SELECT bet_id FROM vote WHERE user_id='".$user_id."' ";

		if($cat_id!=9){

			$sql.= "AND category_id='".$cat_id."'";

		}

		$sql.= " ) )";

		if($cat_id!=9){

			$sql.= " AND bt.category_id='".$cat_id."' ";

		}

		$sql.= " AND bet_status='approved' order by bt.bet_id desc limit $offSet, $limit ";

		//echo $sql;

		$query=$this->db->query($sql);

		$result=$query->result_array();

		#end voting bets

		$this->memcached_library->set($key,$result);

		}

		return $result;

	}

	

	

	public function MyBetsCount($user_id,$cat_id)

	{

		$sql= "SELECT count(bt.bet_id) as count_all_bets,bt.category_id,bt.question,bt.my_answer,bt.answer_type,

bt.your_answer,bt.wager,us.user_name AS acceptor_name,usa.user_name AS creator_name 

,(SELECT COUNT(vote_id)AS my_answer FROM vote WHERE bet_id=bt.bet_id AND answer_type='my_answer')AS my_answer_vote,

(SELECT COUNT(vote_id)AS my_answer FROM vote WHERE bet_id=bt.bet_id AND answer_type='your_answer')AS your_answer_vote FROM bet bt JOIN `user` us ON bt.acceptor_id=us.user_id JOIN `user` usa 

ON bt.creater_id=usa.user_id WHERE(bt.creater_id='".$user_id."' 

OR bt.acceptor_id='".$user_id."' OR bt.bet_id IN(SELECT bet_id FROM vote WHERE user_id='".$user_id."'  ";

		if($cat_id!=9){

			$sql.= "AND category_id='".$cat_id."'";

		}

		$sql.= " ) )";

		if($cat_id!=9){

			$sql.= " AND bt.category_id='".$cat_id."' ";

		}

		$sql.= " AND bet_status='approved' ";

			//echo $sql;

			$query=$this->db->query($sql);

			$data =$query->row_array();

			return $data['count_all_bets'];

	}

	

	public function vote($data)

	{

		$query=$this->db->query("select vote_id from vote where user_id='".$data['user_id']."' and bet_id='".$data['bet_id']."' ");

		if($query->num_rows()<1){

		#check vote count

		$query1=$this->db->query("SELECT COUNT(*) as today_vote FROM vote WHERE user_id='".$data['user_id']."' AND `datetime`=CURDATE()");

		$result=$query1->row_array();

		if($result['today_vote']<10){

		$query=$this->db->query("insert into vote set 

										user_id='".$data['user_id']."',

										bet_id='".$data['bet_id']."',

										category_id='".$data['cat_id']."',

										answer_type='".$data['answer_type']."',

										datetime=CURDATE()

										");

			if($this->db->affected_rows())

			{

				#check voter no of days

			$query=$this->db->query("SELECT COUNT(DISTINCT(`datetime`)) as days ,(SELECT COUNT(*) FROM voting_range_daily) AS total_days FROM vote WHERE user_id='".$data['user_id']."' ");

		 $check_day=$query->row_array();

		if($check_day['days']>=$check_day['total_days']){

			$days=$check_day['total_days'];

			}else{

				$days=$check_day['days'];

				}

		$query=$this->db->query("SELECT * FROM voting_range_daily WHERE days='".$days."' ");

		$xp_point=$query->row_array();

		$query=$this->db->query("INSERT into bet_vote_history set user_id='".$data['user_id']."' ,xp_point='".$xp_point['xp_point']."',type='voter'");

			return true;

			}

			else{

				return false;

			}

		}

		else{

			return false;

			}

		}else{

			return false;

			}

	}

	

	public function getTotalVoter($bet_id)

	{

		$query=$this->db->query("select count(vote_id)as total_voter from vote where bet_id='".$bet_id."'");

		return $query->row_array();

	}

	

	public function deleteBets($bet_id)

	{

		$this->db->query("update bet set bet_status='delete',datetime=SYSDATE() where  bet_id='".$bet_id."' ");

		

		if($this->db->affected_rows()){

				//// get last bet id 

				$query=$this->db->query("select * from notification where bet_id='".$bet_id."'");

				$res=$query->row_array();

				//// submit notification 

				$this->db->query("update notification

							set

							`user_id`='".$res['user_id']."',

							`sender_id`='".$res['sender_id']."',

							`type`='".$res['type']."',

							`bet_id`='".$bet_id."',

							`status`='0',

							`datetime`=SYSDATE()

							where 

							`bet_id`='".$bet_id."'

							");

				if($this->db->affected_rows()){

					///// 

					return true;

					

				}

				

			}

		//$query=$this->db->query("delete from bet where bet_id='".$bet_id."'");

		

	}

	

	public function user_coins($user_id)

	{

	//$query=$this->db->query("select user_coins from user where user_id='".$user_id."'");

	$query=$this->db->query("SELECT user_coins,COUNT(bt.winner) AS total_win FROM `user` us 

							JOIN bet bt 

							ON bt.winner=us.user_id 

							WHERE user_id='".$user_id."' ");

	return $query->row_array();	

	}

	public function lost_bet($user_id)

	{

		$query=$this->db->query("SELECT COUNT(*) as lost_bet FROM bet 

								WHERE bet_status='voting end' AND  				                    			creater_id='".$user_id."' || acceptor_id='".$user_id."' ");

		return $query->row_array();	

	}

	public function avater($user_id)

	{

	$key=APP_NAME.'get_avater';

	$result = $this->memcached_library->get($key);

	if($result==false){

	//$query=$this->db->query("select * from avater");

	$query=$this->db->query("SELECT * FROM avater WHERE image_id NOT IN (SELECT image_id FROM user_avater WHERE user_id='".$user_id."') ");

	$result=$query->result_array();	

	$this->memcached_library->set($key,$result);

		}

		return $result;

	}

	

	public function buy_avater($user_id,$avater_id,$cost)

	{

		$query=$this->db->query("select user_coins from user  where user_id='".$user_id."'");

		$result=$query->row_array();

		$coin=$result['user_coins']-$cost;

		if($coin >= 0){

		$query=$this->db->query("update user set user_coins='".$coin."' where user_id='".$user_id."' ");

		

	$query=$this->db->query("insert into user_avater set user_id='".$user_id."' ,image_id='".$avater_id."', datetime=SYSDATE() ");

	return true;

		}else{

			return false;

			}

	}

	

	public function my_avater($user_id)

	{

	$query=$this->db->query("SELECT av.images,av.name,av.cost FROM user_avater ua JOIN avater av ON ua.image_id=av.image_id WHERE ua.user_id='".$user_id."'");

	return $query->result_array();

	}

	

	public function getSearchBets($user_id,$cat_id,$value)

	{

			$query=$this->db->query("SELECT us.user_name,bt.bet_id,bt.question,bt.datetime,bt.expiration ,bt.wager,bt.creater_id,bt.category_id FROM bet bt JOIN `user` us ON bt.creater_id=us.user_id WHERE (bt.acceptor_id='".$user_id."' OR bt.creater_id='".$user_id."') AND bet_status!='expire' AND bet_status!='approved' and bet_status!='voting end' and category_id='".$cat_id."' AND bt.question LIKE '%$value%'");

			return $query->result_array();

	}

	

	public function getPendingBets($user_id,$cat_id)

	{

			$sql ="SELECT us.user_name,bt.bet_id,bt.question,bt.datetime,bt.expiration ,bt.wager,bt.creater_id,bt.category_id FROM bet bt JOIN `user` us ON bt.creater_id=us.user_id WHERE (bt.acceptor_id='".$user_id."' OR bt.creater_id='".$user_id."') AND bet_status!='expire' AND bet_status!='approved' and bet_status!='voting end'  ";

			if($cat_id!=9){

				$sql.=" and category_id='".$cat_id."' ";

			}

			$query=$this->db->query($sql);

			return $query->result_array();

	}

	

	public function user_avaters($user_id)

	{

		$query=$this->db->query("SELECT av.images,av.image_id FROM user_avater ua JOIN avater av ON ua.image_id=av.image_id WHERE ua.user_id='".$user_id."' ");

		return $query->result_array();

	}

	

	public function avater_change($image_id,$user_id)

	{

		$query=$this->db->query("select images from avater where image_id='".$image_id."'");

		$image=$query->row_array();

		$query=$this->db->query("update user set user_image='".$image['images']."' where user_id='".$user_id."'");

		return $image;

	}

	

	public function getUserCoin($user_id)

	{

		$query=$this->db->query("select user_coins from user where user_id='".$user_id."'");

		return $query->row_array();

	}

	

	public function update_coin($user_id,$coin)

	{

		$query=$this->db->query("update user set user_coins='".$coin."' where user_id='".$user_id."'");

	}

	

	public function banner_image()

	{

	$query=$this->db->query("select adds_id,add_image from adds where status!='Deactive'");	

	return $query->result_array();

	}

	public function topBetter($category_id)

	{

		$sql ="SELECT us.user_name,bt.*,COUNT(bt.winner)AS win_bet,(SELECT COUNT(*) FROM bet WHERE creater_id=bt.winner ";

		if($category_id!=9){

			$sql.= " AND category_id='".$category_id."'";

		}

		$sql.=" )AS total_bet FROM bet bt

						JOIN `user` us ON us.user_id=bt.winner 

						WHERE ";

		if($category_id!=9){

			$sql.= " category_id='".$category_id."' AND ";

		}

		$sql.=" bt.bet_status='voting end' AND bt.winner>'0' GROUP BY bt.winner  		                        ORDER BY bt.winner ASC ";

		

		$query=$this->db->query($sql);	

	return $query->result_array();

	}

	public function xp_point($user_id)
	{
		$query=$this->db->query("SELECT SUM(xp_point)AS xp_point FROM bet_vote_history WHERE user_id='".$user_id."'");	
		return $query->row_array();
	}

	public function get_level($user_id,$cat_id)

	{

		

		$query = $this->db->query("SET @rownum := 0");

		$query = $this->db->query("SELECT * FROM (

		SELECT *,@rownum := @rownum + 1 AS `level` FROM (

		SELECT user_id,category_id,SUM(xp_point) AS points FROM bet_vote_history GROUP BY category_id,user_id ) dat 

		WHERE dat.category_id = ".$cat_id." ORDER BY points DESC ) AS abc

		WHERE user_id = ".$user_id."");

		return $query->row_array();

		/*$query = $this->db->query("SET @rownum := 0");

		$query = $this->db->query("SELECT *,(@rownum := @rownum + 1) AS rank FROM (

SELECT user_id,category_id,SUM(xp_point) AS points FROM bet_vote_history GROUP BY category_id,user_id ) dat 

WHERE dat.category_id = 2 ORDER BY points DESC");

#print_r($query);

#exit;

		$result=$query->result_array();

		print_r($result);

		$abc = array_search("100000273991610",$result[0]);

		print_r($abc);

		exit;

		

		$query=$this->db->query("SELECT SUM(bvh.xp_point) AS total_xp_point

							FROM bet_vote_history bvh

							WHERE bvh.user_id='".$user_id."'

							AND bvh.category_id='".$cat_id."' ");	

			

			$result=$query->row_array();

			if($result['total_xp_point']!='')

			{   

				$result=$result['total_xp_point'];

				}else{

					$result=0;

				}

					$query=$this->db->query("SELECT  `level` FROM `level` 

										WHERE  end_level_xp >= $result

										AND

										 start_level_xp <= $result 

										 AND 

										 category_id=$cat_id");

					return $query->row_array();*/

	}

	#**************************

	#cron job vopting end

	#**************************

	public function CronjobVotingEnd()

	{

		$query1=$this->db->query("SELECT bet_id,time_limit,datetime FROM bet WHERE bet_status='approved' ");

			$data1=$query1->result_array();

			#update bet_status

			foreach($data1 as $res)

			{

				if(strtotime(date('d-M-Y')) > strtotime(date('d-M-Y',strtotime($res['datetime']."+".$res['time_limit'] ."day"))))

				{

			$this->db->query("update bet set bet_status='voting end' where bet_id='".$res['bet_id']."' ");

				}

			}

			#get all bet whose bet_status is voting end

			$query2=$this->db->query("select bet_id,category_id,creater_id,acceptor_id,wager from bet where bet_status='voting end'");

			$data2=$query2->result_array();

			foreach($data2 as $res2){

				#count my answer vote

				$result1=$this->db->query("select count(*)as myanswer from vote where bet_id='".$res2['bet_id']."' and answer_type='my_answer'");

				$Count_MyAnswer=$result1->row_array();

				$result2=$this->db->query("select count(*)as youranswer from vote where bet_id='".$res2['bet_id']."' and answer_type='your_answer'");

				$Count_YourAnswer=$result2->row_array();

				#check  who will win

				//if($Count_MyAnswer['myanswer']==0 && $Count_YourAnswer['youranswer']==0){

				//}else

				

				

				///  get bet_xp_point  and  mentain  bet_vote_history

				

				$xpRange=$this->db->query("select * from bet_xp_point where from_coins<='".$res2['wager']."' and to_coins>='".$res2['wager']."'"

				);

				$xpRange=$xpRange->row_array();

				$winner_wager =$res2['wager']*2;

				if($Count_MyAnswer['myanswer']>$Count_YourAnswer['youranswer'])

				{

					////  if   winner and loss history  mentain + set xp-points 

					

					$this->db->query("update bet set winner='".$res2['creater_id']."' where bet_id='".$res2['bet_id']."'");	

				

					$winnerId = $res2['creater_id'];

					$losserId = $res2['acceptor_id'];

					$winner_answer='my_answer';

				}else if($Count_MyAnswer['myanswer']<$Count_YourAnswer['youranswer']){

					$this->db->query("update bet set winner='".$res2['acceptor_id']."' where bet_id='".$res2['bet_id']."'");	

					

					$winnerId = $res2['acceptor_id'];

					$losserId = $res2['creater_id'];

					$winner_answer='your_answer';

				}

				

				//** winner  and  losser batting history  mentain 

				//**  update winner total coins 

				

				///  winner histroy

				$sql="insert into bet_vote_history set

					 user_id='".$winnerId."' ,

					 xp_point='".$xpRange['win_xp_point']."' ,

					 coins='".$winner_wager."' ,

					 type='better' ,

					 bet_id='".$res2['bet_id']."' ,

					 category_id='".$res2['category_id']."'";

				$this->db->query($sql);	

				///  losser histroy

				$sql="insert into bet_vote_history set

					 user_id='".$losserId."' ,

					 xp_point='".$xpRange['loss_xp_point']."' ,

					 coins=0,

					 type='better' ,

					 bet_id='".$res2['bet_id']."' ,

					 category_id='".$res2['category_id']."'";

				$this->db->query($sql);

				///  update user winner coins

				$users=$this->db->query("select * from `user` where user_id='".$winnerId."'");

				$usersData=$users->row_array();

				$winner_wager_total=$usersData['user_coins']+$winner_wager;

				$this->db->query("update `user` set user_coins='".$winner_wager_total."'  where user_id='".$winnerId."'");

				//** winner  and losser  batting  bonus  points 

				$bonusPoints=$this->db->query("SELECT * FROM bet_bonus_xp_point WHERE from_coins<='".$res2['wager']."' AND to_coins>='".$res2['wager']."'");

				$bonusPoints=$bonusPoints->row_array();

				

				

				/// get user total win

				$winCount=$this->db->query("SELECT COUNT(bet_id) as  betCount FROM bet  WHERE  winner='".$winnerId."' AND wager

BETWEEN '".$bonusPoints['from_coins']."' AND '".$bonusPoints['to_coins']."'");

				if($winCount['betCount']==$bonusPoints['bet_quentity']){

					

					///    get bet_vote history   for  update 

					$getHistory=$this->db->query("SELECT * FROM bet_vote_history WHERE user_id='".$winnerId."' AND bet_id='".$res2['bet_id']."'  and  type='better' and category_id='".$res2['category_id']."'");

					$getHistory=$getHistory->row_array();

					$xPoint=$getHistory['xp_point']+$bonusPoints['xp_point'];

					$sql="update  bet_vote_history set

							 xp_point='".$xPoint."' where id='".$getHistory['id']."'";

					$this->db->query($sql);	

					

					

					

				}

							

				//** winner voter  section 

				// get  voter bonus points from voter_bonus_point

				

				$voter_bonus_point = $this->db->query("SELECT * FROM voter_bonus_point  ORDER BY voter_b_point_id  DESC LIMIT 1");

				$voter_bonus_point=$voter_bonus_point->row_array();

				

				$voters=$this->db->query("SELECT * FROM vote WHERE bet_id='".$res2['bet_id']."' AND category_id='".$res2['category_id']."' AND answer_type='".$winner_answer."'");

				$voters=$voters->result_array();

				$v=0;

				foreach($voters as $vote){

					///// get  voter  count 

					$voterCount=$this->db->query("SELECT COUNT(DISTINCT(`datetime`)) AS days  FROM vote WHERE user_id='".$vote['user_id']."'");

					$voterCount=$voterCount->row_array();

					

					// calculate voter points

					$voterBonus = $voterCount['days']*$voter_bonus_point['bonus_point'];

					

					

					///  get  voter detail from bet_vote_history

					$get_vote_history = $this->db->query("SELECT * FROM bet_vote_history WHERE user_id='".$vote['user_id']."' AND bet_id='".$res2['bet_id']."'  and  type='voter' and category_id='".$res2['category_id']."'");

					$get_vote_history=$get_vote_history->row_array();

					

					//  add voter xp point 

					

					$vXpoint = $get_vote_history['xp_point']+$voterBonus;

					

					// update this 

					$sql="update  bet_vote_history set

							 xp_point='".$vXpoint."' where id='".$get_vote_history['id']."'";

					$this->db->query($sql);	

					$v++;

				}

				

				

				

				

			}

		

		}

		

	public function CronBetExpire()

	{

		$query1=$this->db->query(" SELECT bet_id,expiration,`datetime` FROM bet WHERE  bet_status='pending' ");

			$data1=$query1->result_array();

			foreach($data1 as $res)

			{

				if(strtotime(date('d-M-Y')) > strtotime(date('d-M-Y',strtotime($res['datetime']."+".$res['expiration'] ."day"))))

				{

			$this->db->query("update bet set bet_status='expire' where bet_id='".$res['bet_id']."' ");

				}

			}

		

	}

		

/*	public function getAllUsers($search='',$offSet=0,$limit=20){

		 if($search!=''){

			  $sql="select id,firstname,lastname,user_name,email,password,status,user_name,gender,picture,status from users where `user_name` like '%".trim($search)."%' or `email` like '%".trim($search)."%' order by `user_name` limit $offSet, $limit";

			$query=$this->db->query($sql);

			 $data=$query->result_array();

		 }else{

			$sql="select id,firstname,lastname,user_name,email,password,status,user_name,gender,picture,status from users   order by `user_name` limit $offSet, $limit";

			$query=$this->db->query($sql);

			 $data=$query->result_array();

		}

		

		return $data;

	}

	

	public function countAllUsers($search=''){

		if($search==''){

			$this->db->select('count(id) as total')->from('users');

		}else{

			$this->db->select('count(id) as total')->from('users')->like('user_name',trim($search),'email',trim($search));

		}

		$query= $this->db->get();

		$data=$query->row_array();

		return $data['total'];

	}*/

	

  /*  public function updateUser($data){

       $conditions=array('id'=>$data['id']);

       if($this->db->update('users', $data, $conditions)){

			$this->getUserData($data['id'],1);

			return true;

		}else{

			return false;

		}

    }*/

	/****************************************

		CSV Function

	***************************************/

	/*public function createCsv($filePath='users.csv',$sql){

			$sql.=" limit 200000";

			$this->load->dbutil();

			$query = $this->db->query($sql);

		 	$ret=$this->dbutil->csv_from_result($query); 

			if(file_exists($filePath)){

				unlink($filePath);

			}

			

			$fp = fopen($filePath,'w+');

			$j=0;

			fputs($fp,$ret);

        	fclose($fp);	

			return true;

	}*/

	

}

?>