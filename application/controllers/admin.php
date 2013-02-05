<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * Main admin controller
 *
 * @author        Steve Montambeault
 * @license        Apache License v2.0
 */
class Admin extends Admin_Controller {

    public $data;
    
    function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $this->template->title(lang('cp_admin_title'))
            ->set_layout('default')
            ->build('admin/dashboard');
    }
 
    public function login()
    {
        $this->data['title'] = "Login";
        if(!$this->ion_auth->logged_in())
        {
            //validate form input
            $this->form_validation->set_rules('identity', 'Identity', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == true)
            {
                //check to see if the user is logging in
                //check for "remember me"
                $remember = (bool) $this->input->post('remember');

                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember))
                {
                    //if the login is successful
                    //redirect them back to the home page
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    redirect('admin', 'refresh');
                }
                else
                {
                    //if the login was un-successful
                    //redirect them back to the login page
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('admin/login', 'refresh'); //use redirects instead of loading views for compatibility with MY_Controller libraries
                }
            }
            else
            {
                //the user is not logging in so display the login page
                //set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['identity'] = array('name' => 'identity',
                    'id' => 'identity',
                    'type' => 'text',
                    'value' => $this->form_validation->set_value('identity'),
                );
                $this->data['password'] = array('name' => 'password',
                    'id' => 'password',
                    'type' => 'password',
                );
                $this->template
                    ->set_layout('login')
                    ->build('admin/login', $this->data);
            }
        }else{
            redirect('admin');
        }
    }
    
    public function logout()
    {
        $this->data['title'] = "Logout";

        //log the user out
        $logout = $this->ion_auth->logout();

        //redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect();
    }
    
}
/* end of file: admin.php*/
/* Location: ./application/controllers/admin.php */

