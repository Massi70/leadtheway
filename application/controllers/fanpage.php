<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Index extends CI_Controller {

	public $_uId;

	public $_userData;

	public $_assignData;

	public function __construct(){

		parent :: __construct();

		$this->load->model('FacebookModel');

		$_userData=$this->FacebookModel->authenticate();

		$this->_uId=$_userData['id'];

		$this->_assignData=array('uId'=>$this->_uId,'userData'=>$_userData);	

	}

	public function index(){

		$this->load->view('header',$this->_assignData);

		$this->load->view('index');

		$this->load->view('footer');

	}

}

?>