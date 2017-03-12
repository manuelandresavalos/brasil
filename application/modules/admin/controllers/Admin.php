<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MX_Controller {

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

    public function managment_currency()
    {
        if (isset($this->session->userdata['logged_in'])) {
            $data['username'] = ($this->session->userdata['logged_in']['username']);
            $data['email'] = ($this->session->userdata['logged_in']['email']);

            $crud = new grocery_CRUD();
            $crud->set_table('currency_values')
                ->set_subject('CurrencyObject')
                ->columns('id','api','resource','udsars','udsbrl','datetime','api_request');
                //->display_as('customerName','Name')
                //->display_as('contactLastName','Last Name');
            $crud->fields('id','api','resource','udsars','udsbrl','datetime','api_request');
            //$crud->required_fields('customerName','contactLastName');
            //$crud->unset_jquery();
            $output = $crud->render();
            //$this->_example_output($output);
            $data['output'] = (array) $output;
            //var_dump($data);

            $meta_data['data'] = $data;
            $this->load->view('admin_managment_currency', $meta_data);

            //$this->load->view('admin_managment_users', $meta_data);
        } else {
            $this->load->view('Login');
        }
    }

    public function currency()
    {
        // Check if user is logged_in
        if (isset($this->session->userdata['logged_in'])) {
            $data['username'] = ($this->session->userdata['logged_in']['username']);
            $data['email'] = ($this->session->userdata['logged_in']['email']);
            $meta_data['data'] = $data;

            $this->load->view('Currency', $meta_data);
        } else {
            $this->load->view('Login');
        }
    }
}
