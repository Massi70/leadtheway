<?php 
class settings_library{
	
	
    function settings_library()
    {
		$this->loader =& get_instance();
		$this->loader->load->model('settings_model');
		$prefs=$this->loader->settings_model->getAllSettings();
		foreach($prefs as $keys=>$pref)
		{
			define($pref['setting_key'],$pref['setting_value']);
		}		
	}
	

		
}

?>