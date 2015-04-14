<?php

class Migrate extends CI_Controller {

    public function index() {
        $this->load->library('migration');

        if ($this->migration->version(2) === FALSE) {
            show_error($this->migration->error_string());
        } else {
            echo 'Ready';
        }
    }

}
