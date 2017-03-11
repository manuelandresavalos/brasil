<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Module_a extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view("module_a_view");
	}
}
