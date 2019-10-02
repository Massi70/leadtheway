<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Facebook2 extends CI_Controller {

	public function __construct()

	{

        parent::__construct();

		$this->load->model('FacebookModel');		

	}

	public function redirect(){

		redirect(REDIRECT_URL);

	}



}