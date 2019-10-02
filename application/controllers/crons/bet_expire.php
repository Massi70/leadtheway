<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Bet_Expire extends CI_Controller {
	
	public $_uId;
	public $_userData;
	public $_assignData;
	public $_checkUser;
	
	public function __construct(){
		parent :: __construct();
		$this->load->model('userModel');
		//$this->load->model('FacebookModel');
		
		//$_userData=$this->FacebookModel->authenticate();
		//$this->_checkUser=$_userData['check_user'];
		//$this->_uId=$_userData['user_data']['user_id'];
		//$this->_assignData=array('userData'=>$_userData['user_data']);
	}
	
	public function index(){
		
	$this->userModel->CronBetExpire();
	}

}