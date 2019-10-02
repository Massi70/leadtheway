<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Index extends CI_Controller {
	public $_uId;
	public $_userData;
	public $_assignData;
	public $_checkUser;
	
	public function __construct(){
		parent :: __construct();
		$this->load->model('userModel');
		$this->load->model('FacebookModel');
		
		$_userData=$this->FacebookModel->authenticate();
		$this->_checkUser=$_userData['check_user'];
		$this->_uId=$_userData['user_data']['user_id'];
		$this->_assignData=array('userData'=>$_userData['user_data']);
	}
	
	public function postStatus(){
						$uid = "1600554126"; //User's Facebook ID, set the value as "me" if publishing on logged in user's wall
				$ufname = "Masroor Ahmed"; // User's Full name on Facebook
				$attachment = array(
				'message'=> "I do test, @[".$uid.":1:".$ufname."]!",
				);
				$post = $this->FacebookModel->postStatus($uid,$attachment);
				var_dump($post);
	}
	public function index(){
		
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$data['limit']='5';
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		$data['category_id'] = isset($_REQUEST['category_id']) ? $_REQUEST['category_id'] : '1';
		
		$data['user_id']=$this->_uId;
		$data['user_data']=$this->_assignData;
		$header_data['banner_image']=$this->userModel->banner_image();
		$data['category']=$this->userModel->getCategory();
		$data['getbets']=$this->userModel->getBets($this->_uId,$data['category_id']);
		
		////  get bets for display in top
		$data['getAllBets']=$this->userModel->getAllBets($data['category_id'],$this->_uId,$data);
		$data['getAllBetsCount']=$this->userModel->getAllBetsCount($data['category_id'],$this->_uId,$data);
		
		$paging=$pagination->create($data['page'],base_url().'index/?category_id='.$data['category_id'] ,$data['getAllBetsCount'] ,'allBetDiv' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
		$data['paging']=$paging['html'];
		
		if($ajax!=1){
			$this->load->view('header',$header_data);
			$this->load->view('home',$data);
			$this->load->view('footer');	
		}else{
			$this->load->view('allBetPage',$data);
		}
		
	}
	
	public function submit_bet()
	{
		$data['aceptor_id']=$this->uri->segment(3);
		$data['creater_id']=$this->_uId;
		$data['title']= $this->input->post('title');
		$data['category']= $this->input->post('category');
		$data['question']= $this->input->post('question');
		$data['answer_title']= $this->input->post('answer_type');
		
		if($this->input->post('answer_type')=='Text'){
			$data['my_answer']= $this->input->post('my_answer');
			$data['your_answer']= $this->input->post('your_answer');
		}elseif($this->input->post('answer_type')=='Image'){
			$data['my_answer']= $this->input->post('my_image');
			$data['your_answer']= $this->input->post('your_image');
			}else{
				$data['my_answer']= $this->input->post('my_video');
				$data['your_answer']= $this->input->post('your_video');
				}
	
		$data['wager']= $this->input->post('wager');
		$data['post']= $this->input->post('post');
		$data['timelimit']= $this->input->post('timelimit');
		$data['expire']= $this->input->post('expire');
		$data['tount_friend']= $this->input->post('tount_friend');
		
		
		$res = $this->userModel->submit_bet($data);
		
		 $this->userModel->submit_bet_histroy($data);
		
		if($res)
		{
			//return true;
			$this->acceptBet($res);
			}else{
				return false;
				}
	}
	
	public function submit_repropse_bet()
	{
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$data['limit']='5';
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		//$data['category_id']=$this->uri->segment(3);
		
		
		
		$data['user_id']=$this->_uId;
				
		$data['aceptor_id']=$this->input->post('creator_id');
		$data['creater_id']=$this->_uId;
		
		$data['title']= $this->input->post('title');
	    $data['category_id']= $this->input->post('category');
		$data['question']= $this->input->post('question');
		$data['answer_title']= $this->input->post('answer_type');
		
		if($this->input->post('answer_type')=='Text'){
		$data['my_answer']= $this->input->post('my_answer');
		$data['your_answer']= $this->input->post('your_answer');
		}elseif($this->input->post('answer_type')=='Image'){
			$data['my_answer']= $this->input->post('my_image');
			$data['your_answer']= $this->input->post('your_image');
			}else{
				$data['my_answer']= $this->input->post('my_video');
				$data['your_answer']= $this->input->post('your_video');
				}
	
		$data['wager']= $this->input->post('wager');
		$data['post']= $this->input->post('post');
		$data['timelimit']= $this->input->post('timelimit');
		$data['expire']= $this->input->post('expire');
		$data['tount_friend']= $this->input->post('tount_friend');
		$data['category_id']=$this->input->post('category_id');
		$data['bet_id']= $this->input->post('bet_id');
		
		/// bet old  creater detail 
		$bet_old_data=$this->userModel->getSpecBet($this->input->post('bet_id'));
		///  mentain history //and refund wager
		$this->userModel->update_bet_histroy($bet_old_data);
		
		$this->userModel->submitRepropseBet($data);
		//if($res)
		//{
		
		$data['category']=$this->userModel->getCategory();
		//$data['getAllBets']=$this->userModel->getAllBets($data['category_id'],$this->_uId);
		$data['getbets']=$this->userModel->getBets($this->_uId,$data['category_id']);
		
		
		
		////  get bets for display  in top
		$data['getAllBets']=$this->userModel->getAllBets($data['category_id'],$this->_uId,$data);
		$data['getAllBetsCount']=$this->userModel->getAllBetsCount($data['category_id'],$this->_uId,$data);
		
		$paging=$pagination->create($data['page'],base_url().'index/acceptBet/'.$data['category_id'] ,$data['getAllBetsCount'] ,'allDiv' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
		$data['paging']=$paging['html'];
		
		
		$data['user_data']=$this->_assignData;
		
		// get user coins
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		
		
		$this->load->view('accept_bet_ajax',$data);
			//}else{
				//return false;
				//}
	}
	
	function uploadPicture()
	{
		//print_r($_FILES['UploadMyImage']['name']);
		$config['upload_path'] = './images/bet_images/';
				$config['allowed_types'] = 'gif|jpg|png';
				$config['max_size'] = '1024';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$this->load->library('upload', $config);
				$this->upload->do_upload('UploadMyImage');
				$data=	$this->upload->data();
				echo  $data['file_name'];
	}
	
	function uploadVideo()
	{
				$config['upload_path'] = './images/bet_images/';
				$config['allowed_types'] = 'mov|mp4';
				$config['max_size'] = '0';
				$config['max_width'] = '0';
				$config['max_height'] = '0';
				$this->load->library('upload', $config);
				$this->upload->do_upload('UploadMyVideo');
				$data=	$this->upload->data();
				echo  $data['file_name'];
			
	}
	
	function acceptBet($category_id='')
	{	
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$data['limit']='5';
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		
		if($this->uri->segment(3)<10){
			$data['category_id']=$this->uri->segment(3);}else{
				$data['category_id']=$category_id;
				$data['after_bet']='after';
				}
		//$data['category_id']=$this->uri->segment(3);
		$bet_id= isset($_REQUEST['bet_id']) ? $_REQUEST['bet_id'] : '';
		$data['user_id']=$this->_uId;
		$this->userModel->updateBet($this->_uId,$bet_id);
		$data['category']=$this->userModel->getCategory();
		////  get bets for display  in top
		$data['getAllBets']=$this->userModel->getAllBets($data['category_id'],$this->_uId,$data);
		$data['getAllBetsCount']=$this->userModel->getAllBetsCount($data['category_id'],$this->_uId,$data);
		
		$paging=$pagination->create($data['page'],base_url().'index/acceptBet/'.$data['category_id'] ,$data['getAllBetsCount'] ,'allDiv' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
		$data['paging']=$paging['html'];
		
		//$data['getAllBets']=$this->userModel->getAllBets($this->uri->segment(3),$this->_uId);
		$data['getbets']=$this->userModel->getBets($this->_uId,$data['category_id']);
		
		////  user Data 
		/// get user date
		$data['user_data']=$this->_assignData;
		
		// get user coins
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		
		//array('userData'=>$_userData['user_data']);
		
		////
		if($ajax!=1){
			$this->load->view('accept_bet_ajax',$data);
		}else{
			$this->load->view('accept_bet_page',$data);
		}
	}
	
	function acceptMyBet()
	{	
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$data['limit']='5';
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		$data['category_id']=$this->uri->segment(3);
		$bet_id= isset($_REQUEST['bet_id']) ? $_REQUEST['bet_id'] : '';
		$this->userModel->updateBet($this->_uId,$bet_id);
		$data['user_id']=$this->_uId;
				
		$data['category']=$this->userModel->getCategory();
		
		
		////  get bets for display  in top
		$data['my_bets']=$this->userModel->getAllBets($data['category_id'],$this->_uId,$data);
		$data['my_bets_count']=$this->userModel->getAllBetsCount($data['category_id'],$this->_uId,$data);
		
		$paging=$pagination->create($data['page'],base_url().'index/myBet?cat_id='.$data['category_id'] ,$data['my_bets_count'] ,'allbet_Div' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
		$data['paging']=$paging['html'];
		
		//$data['my_bets']=$this->userModel->getAllBets($this->uri->segment(3),$this->_uId);
		$data['getbets']=$this->userModel->getBets($this->_uId,$this->uri->segment(3));
		
		/// get user date
		$data['user_data']=$this->_assignData;
		
		// get user coins
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		
		/// notification
		
		/// xp point
		
		$data['xp_point']=$this->userModel->xp_point($this->_uId);
		
		$data['user_notification_count']=$this->userModel->getBetNotifiCount($this->_uId);
		$this->load->view('my_bet',$data);
	}
	
	function deleteMyBet()
	{
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$data['limit']='5';
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		$data['category_id']=$this->uri->segment(3);
		$bet_id= isset($_REQUEST['bet_id']) ? $_REQUEST['bet_id'] : '';
		$type= isset($_REQUEST['type']) ? $_REQUEST['type'] : '';
		$data['user_id']=$this->_uId;
		//$this->userModel->updateBet($this->_uId,$bet_id);
		$data['category']=$this->userModel->getCategory();
		$this->userModel->deleteBets($bet_id);
		$data['getbets']=$this->userModel->getBets($this->_uId,$this->uri->segment(3));
		
		/// get user date
		$data['user_data']=$this->_assignData;
		
		// get user coins
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		
		$data['lost_bet']=$this->userModel->lost_bet($this->_uId);
		
		$data['xp_point']=$this->userModel->xp_point($this->_uId);
		
		if($type=='home'){
			////  get bets for display  in top
			$data['getAllBets']=$this->userModel->getAllBets($data['category_id'],$this->_uId,$data);
			$data['getAllBetsCount']=$this->userModel->getAllBetsCount($data['category_id'],$this->_uId,$data);
			
			$paging=$pagination->create($data['page'],base_url().'index/acceptBet/'.$data['category_id'] ,$data['getAllBetsCount'] ,'allDiv' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
			$data['paging']=$paging['html'];
			//$data['getAllBets']=$this->userModel->getAllBets($this->uri->segment(3),$this->_uId);
			
			/// get user date
			$data['user_data']=$this->_assignData;
		
			// get user coins
			$data['user_coins']=$this->userModel->user_coins($this->_uId);
		
			//array('userData'=>$_userData['user_data']);
			
			
			$this->load->view('accept_bet_ajax',$data);
		}else{
			$data['my_bets']=$this->userModel->getAllBets($data['category_id'],$this->_uId,$data);
			$data['my_bets_count']=$this->userModel->getAllBetsCount($data['category_id'],$this->_uId,$data);
			
			$paging=$pagination->create($data['page'],base_url().'index/myBet/?cat_id='.$data['category_id'] ,$data['my_bets_count'] ,'allbet_Div' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
			$data['paging']=$paging['html'];
			
			//$data['my_bets']=$this->userModel->getAllBets($this->uri->segment(3),$this->_uId);
			/// notification
		
			$data['user_notification_count']=$this->userModel->getBetNotifiCount($this->_uId);
				if($ajax!=1){
					$this->load->view('my_bet',$data);
				}else{
					$this->load->view('my_bet_page',$data);
				}
			}
	}
	
	function detailBet()
	{	
	   // $bet_id=$this->uri->segment(3);
		//$category_id=$this->uri->segment(4);
		$data['user_id']=$this->_uId;
		$data['detailbets']=$this->userModel->detailBet($this->uri->segment(3),$this->_uId);
		$data['gettopbets']=$this->userModel->topBetter($this->uri->segment(4));
		$this->load->view('detail_bet_ajax',$data);
	}
	
	function create_bet()
	{
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		$data['lost_bet']=$this->userModel->lost_bet($this->_uId);
		$data['category']=$this->userModel->getCategory();
		$this->load->view('create_bet',$data);
	}
	
	function repropse()
	{
		$bet_id=$_REQUEST['bet_id'];
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		$data['category_id']=$_REQUEST['cat_id'];
		$data['category']=$this->userModel->getCategory();
		$data['bet_data']=$this->userModel->getSpecBet($bet_id);
		$this->load->view('bet_popup',$data);
	}
	
	function myBet()
	{
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$data['limit']='5';
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
	    $data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		$data['category_id'] = isset($_REQUEST['cat_id']) ? $_REQUEST['cat_id'] : '1';
		
		$data['category']=$this->userModel->getCategory();
		$data['user_id']=$this->_uId;
		$data['user_data']=$this->_assignData;
		
		// get user coins
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		// get lost bet
		$data['lost_bet']=$this->userModel->lost_bet($this->_uId);
		// get xp point
		$data['xp_point']=$this->userModel->xp_point($this->_uId);
		////  get bets for display  in top
		$data['my_bets']=$this->userModel->MyBets($this->_uId,$data['category_id'],$data);
		$data['my_bets_count']=$this->userModel->MyBetsCount($this->_uId,$data['category_id']);
		
		$paging=$pagination->create($data['page'],base_url().'index/myBet/?cat_id='.$data['category_id'] ,$data['my_bets_count'] ,'allbet_Div' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
		$data['paging']=$paging['html'];
		
		//$data['my_bets']=$this->userModel->MyBets($this->_uId,$data['category_id']);
		
		$data['getbets']=$this->userModel->getBets($this->_uId,$data['category_id']);
		
		
		/// notification
		
		$data['user_notification_count']=$this->userModel->getBetNotifiCount($this->_uId);
		
		if($ajax!=1){
			
			$this->load->view('my_bet',$data);
		}else{
			$this->load->view('my_bet_page',$data);
		}
		
	}
	
	function vote()
	{
		$data['bet_id']=$_REQUEST['bet_id'];
		$data['cat_id']=$_REQUEST['cat_id'];
		$data['answer_type']=$_REQUEST['answer_type'];
		$data['user_id']=$this->_uId;
		$res=$this->userModel->vote($data);
		if($res){
			echo 1;
			}else{
				echo  0;
				}
	}
	
	function edit_avator()
	{
		$data['user_id']=$this->_uId;
		$data['user_data']=$this->_assignData;
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		$data['lost_bet']=$this->userModel->lost_bet($this->_uId);
		$data['avater']=$this->userModel->avater($this->_uId);
		
		$data['xp_point']=$this->userModel->xp_point($this->_uId);
		$data['my_avater']=$this->userModel->my_avater($this->_uId);
		$data['user_avaters']=$this->userModel->user_avaters($this->_uId);
		$data['user_notification_count']=$this->userModel->getBetNotifiCount($this->_uId);
		$this->load->view('bet_avater',$data);
	}
	
	function buy_avater()
	{
		$data['user_id']=$this->_uId;
		$cost=$_REQUEST['cost'];
		$data['user_data']=$this->_assignData;
		$buy_avater=$this->userModel->buy_avater($this->_uId,$this->uri->segment(3),$cost);
		$data['user_coins']=$this->userModel->user_coins($this->_uId);
		// get lost bet
		$data['user_avaters']=$this->userModel->user_avaters($this->_uId);
		$data['lost_bet']=$this->userModel->lost_bet($this->_uId);
		$data['avater']=$this->userModel->avater($this->_uId);
		$data['my_avater']=$this->userModel->my_avater($this->_uId);
		$data['xp_point']=$this->userModel->xp_point($this->_uId);
		if($buy_avater){
		$this->load->view('bet_avater',$data);
		}else{
			echo 0;
			}
	}
	
	function search_bet()
	{
		$value=$_REQUEST['value'];
		$data['category_id']=$_REQUEST['category_id'];
		$data['user_id']=$this->_uId;
		$data['getbets']=$this->userModel->getSearchBets($this->_uId,$data['category_id'],$value);
		$this->load->view('search_data',$data);
	}
	
	function pending_bet()
	{
		$data['category_id']=$_REQUEST['category_id'];
		$data['user_id']=$this->_uId;
		// pri_pending function 
		//$data['getbets']=$this->userModel->getPendingBets($this->_uId,$data['category_id']);
		$data['getbets']=$this->userModel->getBets($this->_uId,$data['category_id']);
		$this->load->view('search_data',$data);	
	}
	
	// show all  notification with respect to  title
	
	function open_notification()
	{
		$this->load->helper('pagination_helper');
		$pagination=Pagination_helper::getInstance();
		$ajax= isset($_REQUEST['ajax']) ? $_REQUEST['ajax'] : '0';
		$data['title'] = $_REQUEST['title'];
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['user_id']=$this->_uId;
		$data['user_data']=$this->_assignData;
		$data['user_notification_count']=$this->userModel->getBetNotifiCount($this->_uId);
		$data['limit']='5';
		$data['page'] =($data['page']==false) ? 1 : $data['page']; 
		$data['offSet'] = ($data['page']>1) ? ($data['page']-1)* $data['limit'] : 0;
		$data['notification_count']=$this->userModel->getNotificationsCount($data);
		$data['notification']=$this->userModel->getNotifications($data);
		$paging=$pagination->create($data['page'],base_url().'index/open_notification/?title='.$data['title'] ,$data['notification_count'] ,'show_notifi_div' ,base_url().'images/ajax-loader.gif','paging_spinner',$data['limit']);
		$data['paging']=$paging['html'];
			
		if($ajax!=1){
			$this->load->view('notification',$data);	
		}else{
			$this->load->view('show_notifi',$data);			
		}
	}
	
	// read notification is status is 0 then update notification status also
	
	function readNotification()
	{
		$data['title'] = $_REQUEST['title'];
		$data['page'] = isset($_REQUEST['page']) ? $_REQUEST['page'] : '1';
		$data['notification_id'] = isset($_REQUEST['notification_id']) ? $_REQUEST['notification_id'] : 0;
		$data['bet_id'] = isset($_REQUEST['bet_id']) ? $_REQUEST['bet_id'] : 0;
		$data['status'] = isset($_REQUEST['status']) ? $_REQUEST['status'] : 0;
		$data['user_id']=$this->_uId;
		if($data['status']==0){
			$this->userModel->updateNotifi($data);
		}
		$data['notification']=$this->userModel->getNotifiByID($data);
		$this->load->view('read_ok',$data);	
		
	}
	
	function compare_ranking()
	{
		$this->load->view('ranking');	
	}
	
	function avater_change()
	{
		$value=$this->uri->segment(3);
		$result=$this->userModel->avater_change($value,$this->_uId);
		echo  $result['images'];
	}
	
	function getUserCoin()
	{
		$result=$this->userModel->getUserCoin($this->_uId);
		echo $result['user_coins'];
	}
	
	function top_better()
	{
		$data['category_id']=$this->input->get_post('category_id');
		$data['top_better']='top_better';
		$data['gettopbets']=$this->userModel->topBetter($data['category_id']);
		$this->load->view('search_data',$data);	
		
	}
}