<?php
        echo "admin loco";
        $this->load->view('admin_html_start');
        $this->load->view('admin_head');
        $this->load->view('admin_body_start');

        //AdminLTE
        $this->load->view('admin_body_main_header',  $data);
        $this->load->view('admin_body_main_sidebar');
        $this->load->view('admin_home');
        $this->load->view('admin_body_main_footer');
        $this->load->view('admin_body_control_sidebar');

        //End rendering
        $this->load->view('admin_body_end');
        $this->load->view('admin_html_end');
?>