<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {

	public function __construct()
    {
        parent::__construct();
        // Load uri helper
        $this->load->helper('url');

        // Load form helper
        $this->load->helper('form');

        // Load security helper
        $this->load->helper('security');

        // Load form validation library
        $this->load->library('form_validation');

        // Load session library
        $this->load->library('session');

        // Load database
        $this->load->database();

        // Load model
        $this->load->model('login_model');

        // Load Crud
        $this->load->library('grocery_CRUD');

        // Profiling output
        //$this->output->enable_profiler(TRUE);
    }

	public function index()
	{

	}

	// Check for user login process
    public function user_login_process()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
            //FALLARON VALIDACIONES
            if (isset($this->session->userdata['logged_in'])) {
                redirect('Admin', 'refresh');
            } else {
                $this->load->view('Login');
            }
        } else {
            $data   = array(
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password')
            );
            $result = $this->login_model->doLogin($data);
            if ($result == TRUE) {
                //LOGUEADO
                $username = $this->input->post('username');
                $result   = $this->login_model->read_user_information($username);
                if ($result != false) {
                    $session_data = array(
                        'username' => $result[0]->user_name,
                        'email' => $result[0]->user_email
                    );
                    // Add user data in session
                    $this->session->set_userdata('logged_in', $session_data);
                    redirect('Admin', 'refresh');
                }
            } else {
                //NO LOGUEADO
                $data = array(
                    'error_message' => 'Invalid Username or Password'
                );
                $this->load->view('Login', $data);
            }
        }
    }

    // Logout from admin page
    public function logout()
    {
        // Removing session data
        $sess_array = array(
            'username' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        //$data['message_display'] = 'Successfully Logout';
        //$this->load->view('Home', $data);
        redirect('Home', 'refresh');
    }
}
