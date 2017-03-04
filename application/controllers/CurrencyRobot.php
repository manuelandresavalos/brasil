<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CurrencyRobot extends CI_Controller {

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
        $this->load->model('currency_robot');
    }

	public function index()
	{
		$this->getInfoFromApis();
	}

    public function getInfoFromApis()
    {
        $this->currency_robot->getInfoFromApis();
    }
}