<?php

class MY_Controller extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function render($view, $data=null) {
        $this->load->view('_parts/header');
        $this->load->view($view, $data);
        $this->load->view('_parts/footer');
    }

    public function pagination($url, $rowscount, $per_page) {
        $config = array();
        $config["base_url"] = base_url($url);
        $config["total_rows"] = $rowscount;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = 2;
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        if (count($_GET) > 0) {
            $config['suffix'] = '?' . http_build_query($_GET, '', "&");
            $config['first_url'] = $config['base_url'] . $config['suffix'];
        }

        $this->pagination->initialize($config);

        return $this->pagination->create_links();
    }

}
