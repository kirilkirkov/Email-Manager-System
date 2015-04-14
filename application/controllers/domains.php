<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Domains extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Domains_model');
    }

    public function index() {
        $this->form_validation->set_rules('domain', 'Domain', 'required|callback_validateUrl|is_unique[domains.domain]');
        if ($this->form_validation->run()) {
            $result = $this->Domains_model->setDomain($this->input->post('domain'));
            if ($result == true) {
                $this->session->set_flashdata('message', 'Domain is added');
            }
            redirect('domains');
        }
        $data["domains"] = $this->Domains_model->getAll();
        $this->render('domains/domains', $data);
    }

    public function validateUrl($url) {
        $pattern = "/^[a-zA-Z0-9\-\.]+\.[a-zA-Z]+$/";
        if (!preg_match($pattern, $url)) {
            $this->form_validation->set_message('validateUrl', 'Invalid Url Address');
            return false;
        } else {
            return true;
        }
    }

    public function deldomain() {
        if ($this->input->post('delete') !== null) {
            $domain = $this->input->post('check_list');
            if (!empty($domain)) {
                $result = $this->Domains_model->delDomain($domain);
                if ($result == true) {
                    $this->session->set_flashdata('message', 'Delete Success');
                } else {
                    $this->session->set_flashdata('message', 'Delete problem');
                }
            } else {
                $this->session->set_flashdata('message', 'No Selected Items');
            }
            redirect('domains');
        }
    }

}
