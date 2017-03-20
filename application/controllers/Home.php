<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {

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

        //$this->load->module('my_modulo/my_controller_modulo/my_metodo_modulo');
        /*
            Ej: module/controller/method
            Si el nombre del modulo coincide con el controller se puede escribir así...
                banner/banner/index
                ó
                banner/banner
                ó
                banner
            $this->load->module('my_modulo/my_controller_modulo/my_metodo_modulo');
        */

        $this->load->module('map_search');
        $this->map_search->index();

        $this->load->module('module_a/module_a/');
        $this->module_a->index();

        $this->load->module('module_b/module_b');
        $this->module_b->index();

        $this->load->module('module_c');
        $this->module_c->index();

        //Si llamo a mi modulo como se muestra bajo, puedo cargarlo sin tener que hacer un output (un echo) y meterno en una variable
        //Eso nos permite rellenar un array $modules y pasarle como parametro a otro modulo igual que pasamos $data a las vistas.
        //modules::run('module_c/module_c/');
	}
}
