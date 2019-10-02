 <?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
* Router Class
*
* Extends CI Router
*
* @author     Original by EllisLab - extension by CleverIgniters
* @see        http://codeigniter.com
*/

class MY_Router extends CI_Router {
    
    /**
     * Constructor
     *
     * @access    public
     */
    function MY_Router()
    {
        parent::CI_Router();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Validate Routing Request
     *
     * @access    public
     */
    function _validate_request($segments)
    {
        // Does the requested controller exist in the root folder?
        if (file_exists(APPPATH.'controllers/'.$segments[0].EXT))
        {
            return $segments;
        }

        // Is the controller in a sub-folder?
        if (is_dir(APPPATH.'controllers/'.$segments[0]))
        {        
            // Set the directory and remove it from the segment array
            $this->set_directory($segments[0]);
            $segments = array_slice($segments, 1);
            
            if (count($segments) > 0)
            {
                // Does the requested controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$segments[0].EXT))
                {
                    show_404($this->fetch_directory().$segments[0]);
                }
            }
            else
            {
                $this->set_class($this->default_controller);
                $this->set_method('index');
            
                // Does the default controller exist in the sub-folder?
                if ( ! file_exists(APPPATH.'controllers/'.$this->fetch_directory().$this->default_controller.EXT))
                {
                    $this->directory = '';
                    return array();
                }
            
            }

            return $segments;
        }
        
        // attempt to load user profile
        if(isset($segments[0]) && sizeof($segments) == 1) {
            return array('users', 'profile', $segments[0]);
        }
        
        // Can't find the requested controller...
        show_404($segments[0]);
    }
}
?>  