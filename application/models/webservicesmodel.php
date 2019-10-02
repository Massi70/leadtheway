<?php
	class WebservicesModel extends CI_Model
	{
		private $table;
		public function __construct(){
		parent :: __construct();
	}


	function updateUser($data){	
		$conditions=array('user_id'=>$data['user_id']);
		$result = $this->db->update('users', $data,$conditions);	
		return $this->db->insert_id();
	}
	
	function getPassword($user_email){
		$this->db->select('password');	
		$sql = $this->db->get_where("users",array("user_email"=>$user_email));
		$res = $this->db->result_array();
		return $res;
	}
	
	function checkUserId($user_id)
	{
		$sql = $this->db->get_where("users",array("user_id"=>$user_id));
		$res = $sql->num_rows();
		return $res;
   }
	
	function getFriends($user_id){
		 $sql = "SELECT 
  CONCAT(
    '".base_url()."uploads/',
    u.user_image
  ) AS user_image,
  u.`user_id`,
  u.`user_name`,
  u.`phone_number`,
  f.`friend_id`,
  f.`status`,
  f.datetime,
   block_users.id AS block
FROM
  users AS u LEFT JOIN block_users ON block_users.user_id=u.user_id AND block_users.blocked_by=".$user_id." ,
  friends AS f  
WHERE (
    (
      u.`user_id` = f.`friend_id` 
      OR f.`user_id` = u.`user_id`
    ) 
    AND u.`user_id` != ".$user_id." 
    AND f.`status` = 1
  ) 
  AND (f.`user_id` = ".$user_id." 
    OR f.`friend_id` = ".$user_id.") 
ORDER BY `datetime` DESC " ;
			
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
	  	return $data;			
	}
	
	function getUserFriendRequest($user_id,$friend_id){
		$sql = "select id from friends where friend_id=$user_id and user_id=$friend_id and status=0;" ;	
		$query=$this->db->query($sql);
		$data=$query->row_array();    // fetches record from the user tables
	  	return $data;			
	}
	
	
	function checkFriend($user_id,$friend_id)
	{
		$sql = "select * from friends where (user_id = '".$user_id."' or friend_id = '".$user_id."') and (user_id = '".$friend_id."' or friend_id = '".$friend_id."')"; 
		$query = $this->db->query($sql);
		$res = $query->num_rows();
		return $res;
	
    }

	function addFriends($data){
		$result = $this->db->insert('friends', $data);	// insert data into `users` table	
		return $result;
	}
	
	function acceptFriendRequest($data){
		$conditions=array('id'=>$data['id']);
		$result = $this->db->update('friends', $data,$conditions);	// insert data into `users` table	
		return $result;
	}
	
	function deleteFriends($user_id,$friend_id){
		$result = $this->db->delete('friends', array('user_id'=>$user_id,'friend_id'=>$friend_id));	// insert data into `users` table	
		return $result;
	}
	
	function deleteFriendRequest($id){
		$result = $this->db->delete('friends', array('id'=>$id));	// insert data into `users` table	
		return $result;
	}
	
	function checkDelete($user_id,$friend_id)
	{
		$sql = "select * from friends where user_id = '".$user_id."' and friend_id = '".$friend_id."' "; 
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
    }
	
	function friendRequest($user_id){
		$sql = "SELECT CONCAT('".base_url()."uploads/',u.user_image) as user_image ,u.`user_id`, u.`user_name`,f.`friend_id`,f.`status`, u.`user_email`, DATE_FORMAT(`datetime`,'%d/%m/%Y %H:%i%p') as `datetime`	from users as u ,friends as f where u.user_id=f.`user_id` and f.friend_id=$user_id and f.status=0 order by `datetime` desc" ;
				
		$query=$this->db->query($sql);
		$data=$query->result_array();    // fetches record from the user tables
	  	return $data;		

	}
	
	function getSearchFriends($user_name,$user_id){
		
		$friendSql="SELECT CONCAT_WS(',', GROUP_CONCAT(DISTINCT user_id),GROUP_CONCAT(DISTINCT friend_id)) AS all_ids  FROM friends where (user_id=$user_id OR friend_id=$user_id)";
		$query=$this->db->query($friendSql);
		$dt=$query->row_array();
		if($dt['all_ids']==''){
			$dt['all_ids']=$user_id;
		}
		
		$sql="SELECT user_id, user_name, user_birthdaydate, user_email, phone_number, password, CONCAT('".base_url()."uploads/',user_image) as user_image,user_status from users where (`user_name` LIKE '%$user_name%' or user_email LIKE'%$user_name%') and user_id not in (".$dt['all_ids'].")";
		$query=$this->db->query($sql);
		$data=$query->result_array();  
		return $data;		
	}
	
	function addMessage($data){
		$result = $this->db->insert('messages', $data);	// insert data into `users` table	
		return $result;
	}
	
	function showMessages($threadId)
	{
		
		 $sql = "SELECT users.user_name,
		 		messages.message,
				messages.user_id,
		 		messages.sender_id,
				messages.id,
				messages.date_added, 
		 		CONCAT('".base_url()."uploads/',users.user_image) as user_image
		 		FROM messages,users
		 		WHERE (users.user_id=messages.sender_id)
				AND thread_id=$threadId 
				ORDER BY `date_added` desc
				";
		 
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
    }
	
	public function getThread($uId,$friendId){
		  $sql="select id,user1_id,user2_id from threads where 
		  (user1_id='".$uId."' or `user2_id`='".$uId."')
		  and (user1_id='".$friendId."' or `user2_id`='".$friendId."')";
		  $query = $this->db->query($sql);
		  $res = $query->row_array();
		  return $res;
		
	}
	
	public function insertThread($data){
		$result = $this->db->insert('threads', $data);	// insert data into `users` table	
		return $this->db->insert_id();
	}
	
	public function sendMessage($data){
        $result = $this->db->insert('message2', $data);
		return $result;
    }
	
	public function receiveMessage($user_id,$id){
		$sql = "select message2.id,message2.sender_id,users.user_name,
				CONCAT('".base_url()."uploads/',users.user_image) as user_image,
				 message2.message,message2.user_id,
				DATE_FORMAT(message2.date_added,'%d/%m/%Y %H:%i%p') as date_added from message2,users where message2.user_id = users.user_id
				and message2.user_id = '".$user_id."' order by date_added DESC
				";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
    }
	
	public function sentMessage($sender_id,$id){
		$sql = "select message2.id,message2.sender_id,users.user_name,
				CONCAT('".base_url()."uploads/',users.user_image) as user_image,
				 message2.message,message2.user_id, DATE_FORMAT(message2.date_added,'%d/%m/%Y %H:%i%p') as date_added
				 from message2,users where message2.user_id = users.user_id
				and message2.sender_id='".$sender_id."' order by date_added DESC
				";
		$query = $this->db->query($sql);
		$res = $query->result_array();
		return $res;
    }
	
	function deleteMessage($delete_id){
		$result = $this->db->delete('message2', array('id'=>$delete_id));	// insert data into `users` table	
		return $result;
	}
	
	public function getBlockUsers($user_id,$blocked_by){
		$sql = $this->db->get_where("block_users",array("user_id"=>$user_id,"blocked_by"=>$blocked_by));
		$res = $sql->num_rows();
		return $res;
	}
	
	public function insertBlockUsers($data){
		$this->db->insert('block_users', $data);	// insert data into `users` table	
	}

	public function deleteBlockUsers($user_id,$blocked_by){
		$result = $this->db->delete('block_users', array('user_id'=>$user_id,'blocked_by'=>$blocked_by));	// insert data into `users` table	
		return $result;
	}
	
	public function editPicture($data){
		$this->db->insert('edit_picture', $data);	// insert data into `users` table	
	}
	
	public function getUsersWhoBlockedMe($user_id){
		  $sql="SELECT blocked_by FROM block_users WHERE user_id=$user_id";
		  $query = $this->db->query($sql);
		  $res = $query->result_array();
		  return $res;
		
	}
	
	public function clearHistoryMessages($threadId){
		  $sql="update messages set `show`='0' where thread_id = '".$threadId."'";
		  $this->db->query($sql);
	}


}
?>