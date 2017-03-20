<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Map_Search extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->view("map_search_view");
	}
}
