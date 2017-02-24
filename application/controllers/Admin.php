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

        // Profiling output
        //$this->output->enable_profiler(TRUE);
    }

	public function index()
	{
		$this->load->view('Admin');
	}
}
