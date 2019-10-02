<?php
class AdminModel extends CI_Model {
	private $table;
	
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
		$this->load->library('memcached_library');
    }
	
 	 public function loginAdmin($userName='admin',$password='admin'){
			$this->db->select('id,user_name,password')->from('admin')->where('user_name',$userName,'password',$password);
			$query= $this->db->get();
			$data=$query->row_array();
			return $data;
		
	}
	
	public function countAllUsers($search=''){
		if($search==''){
			$this->db->select('count(user_id) as total')->from('user');
		}else{
			$this->db->select('count(user_id) as total')->from('user')->like('user_name',trim($search),'user_email',trim($search));
		}
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	public function getAllUsers($search='',$offSet=0,$limit=20){
		 if($search!=''){
			  $sql="select user_id,first_name,last_name,user_name,user_email,user_status,user_gender ,joined_date,user_birthdaydate from user where `user_name` like '%".trim($search)."%' or `user_email` like '%".trim($search)."%' order by `user_name` limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		 }else{
			$sql="select user_id,first_name,last_name,user_name,user_email,user_status,user_gender ,joined_date,user_birthdaydate from user   order by `user_name` limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		}
		
		return $data;
	}
	
	public function countAllBets($search=''){
		if($search==''){
			$this->db->select('count(bet_id) as total')->from('bet');
		}else{
			$this->db->select('count(bet_id) as total')->from('bet')->like('title',trim($search),'question',trim($search));
		}
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	public function getAllBets($search='',$offSet=0,$limit=20){
		 if($search!=''){
			  $sql="SELECT ct.category_name,bt.*,us.user_name AS creater_name,usa.user_name AS 	acceptor_name FROM bet bt  
JOIN category ct ON bt.category_id=ct.category_id 
JOIN `user` us ON us.user_id=bt.creater_id 
JOIN `user` usa ON usa.user_id=bt.acceptor_id where `title` like '%".trim($search)."%' or `question` like '%".trim($search)."%'  limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		 }else{
			$sql="SELECT ct.category_name,bt.*,us.user_name AS creater_name,usa.user_name AS acceptor_name FROM bet bt 
JOIN category ct ON bt.category_id=ct.category_id 
JOIN `user` us ON us.user_id=bt.creater_id 
JOIN `user` usa ON usa.user_id=bt.acceptor_id  order by `bet_id` limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		}
		
		return $data;
	}
	
	public function countAllAdds($search=''){
		if($search==''){
			$this->db->select('count(adds_id) as total')->from('adds');
		}else{
			$this->db->select('count(adds_id) as total')->from('adds')->like('image',trim($search));
		}
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	public function getAllAdds($search='',$offSet=0,$limit=20){
		 if($search!=''){
			  $sql="SELECT * from adds where `image` like '%".trim($search)."%' limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		 }else{
			$sql="SELECT * from adds  order by `adds_id` limit $offSet, $limit";
			$query=$this->db->query($sql);
			 $data=$query->result_array();
		}
		
		return $data;
	}
	
	public function InsertAdd($image_name)
	{
		$sql="insert into adds set add_image='".$image_name."' ,status='Active'";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
			}
	}
	
	public function changeStatus($id)
	{
		$sql="select status from adds where adds_id='".$id."'";
		$query=$this->db->query($sql);
		$data=$query->row_array();
		if($data['status']=='Active')
		{
		$query=$this->db->query("update adds set status='Deactive' where adds_id='".$id."'");
		return 'Deactive';
		}else{
		$query=$this->db->query("update adds set status='Active' where adds_id='".$id."'");
		return  'Active';
			}
	}
	
	public function betXpPoint($search='',$offSet=0,$limit=20)
	{
		$sql="Select * from bet_bonus_xp_point limit $offSet, $limit";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return $query->result_array();
		}else{
			return false;
			}
	}
	
	public function bet_bonus($data)
	{
		$sql="insert into bet_bonus_xp_point set from_coins='".$data['start_coin']."',
											to_coins='".$data['end_coin']."' ,
											bet_quentity='".$data['bet_quan']."' ,
											xp_point='".$data['xp_point']."' 
											";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
			}
	}
	
	public function get_bet_bonus($id)
	{
		$sql="select * from bet_bonus_xp_point where bonus_ex_id='".$id."' ";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	public function update_bet_bonus($data)
	{
		$sql="update bet_bonus_xp_point set from_coins='".$data['start_coin']."',
											to_coins='".$data['end_coin']."' ,
											bet_quentity='".$data['bet_quan']."' ,
											xp_point='".$data['xp_point']."' 
											where
											bonus_ex_id='".$data['id']."'
											";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
			}
	}
	
	
	public function betPoint($search='',$offSet=0,$limit=20)
	{
		$sql="Select * from bet_xp_point limit $offSet, $limit";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return $query->result_array();
		}else{
			return false;
			}
	}
	
	public function bet_point($data)
	{
		$sql="insert into bet_xp_point set from_coins='".$data['start_coin']."',
											to_coins='".$data['end_coin']."' ,
											win_xp_point='".$data['win_point']."' ,
											loss_xp_point='".$data['loss_point']."' 
											";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
			}
	}
	
	public function get_bet_point($id)
	{
		$sql="select * from bet_xp_point where win_poi_id='".$id."' ";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	public function update_bet_point($data)
	{
		$sql="update bet_xp_point set from_coins='".$data['start_coin']."',
											to_coins='".$data['end_coin']."' ,
											win_xp_point='".$data['win_point']."' ,
											loss_xp_point='".$data['loss_point']."' 
											where
											win_poi_id='".$data['id']."'
											";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
			}
	}
	
	public function voter_bonus()
	{
		$sql="select * from voter_bonus_point	";
		$query=$this->db->query($sql);
		return $query->result_array();
		
	}
	public function get_voter_point($id)
	{
		$sql="select * from voter_bonus_point where voter_b_point_id='".$id."' ";
		$query=$this->db->query($sql);
		return $query->row_array();
	}
	
	public function update_voter_point($data)
	{
		$sql="update voter_bonus_point set bonus_point='".$data['bonus_point']."'
											where
											voter_b_point_id='".$data['id']."'
											";
		$query=$this->db->query($sql);
		if($this->db->affected_rows())
		{
			return true;
		}else{
			return false;
			}
	}
	
	public function countAllvoterbonus($search=''){
		
		$this->db->select('count(voter_b_point_id) as total')->from('voter_bonus_point');
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}

	public function countbetpoint($search=''){
		
		$this->db->select('count(win_poi_id) as total')->from('bet_xp_point');
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
	
	public function countbetbonus($search=''){
		
		$this->db->select('count(bonus_ex_id) as total')->from('bet_bonus_xp_point');
		$query= $this->db->get();
		$data=$query->row_array();
		return $data['total'];
	}
}

?>