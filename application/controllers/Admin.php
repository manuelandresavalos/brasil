<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

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
        $this->load->model('login_database');

        // Load Crud
        $this->load->library('grocery_CRUD');

        // Profiling output
        //$this->output->enable_profiler(TRUE);
    }

	public function index()
	{
		// Check if user is logged_in
		if (isset($this->session->userdata['logged_in'])) {
			$data['username'] = ($this->session->userdata['logged_in']['username']);
			$data['email'] = ($this->session->userdata['logged_in']['email']);
            $meta_data['data'] = $data;

            $this->load->view('Admin', $meta_data);
		} else {
			$this->load->view('Login');
		}
	}

    public function managment_users()
    {
        if (isset($this->session->userdata['logged_in'])) {
            $data['username'] = ($this->session->userdata['logged_in']['username']);
            $data['email'] = ($this->session->userdata['logged_in']['email']);

            $crud = new grocery_CRUD();
            $crud->set_table('customers')
                ->set_subject('Customer')
                ->columns('customerName','contactLastName','phone','city','country','creditLimit')
                ->display_as('customerName','Name')
                ->display_as('contactLastName','Last Name');
            $crud->fields('customerName','contactLastName','phone','city','country','creditLimit');
            $crud->required_fields('customerName','contactLastName');
            //$crud->unset_jquery();
            $output = $crud->render();
            //$this->_example_output($output);
            $data['output'] = (array) $output;
            //var_dump($data);

            $meta_data['data'] = $data;
            $this->load->view('admin_managment_users', $meta_data);

            //$this->load->view('admin_managment_users', $meta_data);
        } else {
            $this->load->view('Login');
        }
    }

















	// Check for user login process
    public function user_login_process()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
        if ($this->form_validation->run() == FALSE) {
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
            $result = $this->login_database->login($data);
            if ($result == TRUE) {
                $username = $this->input->post('username');
                $result   = $this->login_database->read_user_information($username);
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
