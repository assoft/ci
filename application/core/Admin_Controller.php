<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin_Controller extends MY_Controller
{
	
	function __construct() {
		parent::__construct();
		
        $this->lang->load('admin');
            
        if ( ! self::_check_access())
        {
            //$this->session->set_flashdata('error', 'Hatalý Giriþ!');
            redirect('auth/login');

        }else{
                    // logic for template
        $this->template->set_layout('default', 'admin');
        $this->template
            ->set_partial('header', 'admin/partials/header')
            ->set_partial('metadata', 'admin/partials/metadata')
            ->set_partial('menu', 'admin/partials/menu')
            ->set_partial('aside', 'admin/partials/aside')
            ->set_partial('footer', 'admin/partials/footer');
	    }
    }
    
    private function _check_access()
    {
        $ignored_pages = array('admin/login', 'admin/logout');

        // Check if the current page is to be ignored
        $current_page = $this->uri->segment(1, '') . '/' . $this->uri->segment(2, 'index');

        // Dont need to log in, this is an open page
        if (in_array($current_page, $ignored_pages) || $this->ion_auth->is_admin())
        {
            return TRUE;
        }
        else if (!$this->ion_auth->logged_in())
        {
            redirect('admin/login');
        }
        else if(!$this->ion_auth->is_admin())
        {
            return FALSE;
        }
    }
    

}
/* End of file Public_Controller.php */
/* Location: ./application/core/Public_Controller.php */
