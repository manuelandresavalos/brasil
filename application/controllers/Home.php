<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        // Load uri helper
        $this->load->helper('url');

        // Load form helper
        $this->load->helper('form');

        // Profiling output
        //$this->output->enable_profiler(TRUE);
    }

	public function index()
	{
		$this->load->view('Home');
	}
}
