<?php
class ServicesModel extends CI_Model {
    public function __construct(){
        // Call the Model constructor
        parent::__construct();
    }
    
	public function getAllServices(){
		$sql="SELECT id,request,response,datetime,ip_address,files,`type` FROM services order by `datetime` desc limit 100;";
		$query=$this->db->query($sql);
		$data=$query->result_array();	
		return $data;
	}
	public function getAllServicesByType($type='signup'){
		$sql="SELECT id,request,response,datetime,ip_address,files,`type` FROM services where `type`='".$type."' order by `datetime` desc limit 100;";
		$query=$this->db->query($sql);
		$data=$query->result_array();	
		return $data;
	}
	public function createService($request,$response,$ipAddress,$type='',$files=array()){
		if(SERVICE_LOG==true){
			$data=array('request'=>json_encode($request),
						'response'=>json_encode($response),
						'ip_address'=>json_encode($ipAddress),
						'type'=>$type,
						'files'=>json_encode($files));
			if($this->db->insert('services', $data)){
				return true;
			}else{
				return false;
			}
		}
    }
}
?>