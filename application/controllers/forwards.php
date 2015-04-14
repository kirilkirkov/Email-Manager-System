<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forwards extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
        $this->load->model('Forwards_model');
        $this->load->model('Domains_model');
        $this->load->model('Users_model');
    }

    public function index($page = 0) {
        $filter = array();
        if ($this->input->get('serachforwards')) {
            $filter['serachforwards'] = $this->input->get('serachforwards');
        }
        $rowscount = $this->Forwards_model->record_count($filter);
        $data = array();
        $data["links_pagination"] = $this->pagination('forwards', $rowscount, $this->num_rows);
        $data['allforwards'] = $this->Forwards_model->getAll($this->num_rows, $page, $filter);
        $this->render('forwards/forwards', $data);
    }

    public function add_edit_forward($domain = null, $user = null) {
        if (isset($domain) && isset($user)) {
            $this->form_validation->set_rules('local_part', 'Username', 'required|callback_validinUsers');
        } else {
            $this->form_validation->set_rules('local_part', 'Username', 'required|callback_validateEmail|callback_validinUsers|callback_uniqueUser');
        }
        $this->form_validation->set_rules('recipients', 'recipiens', 'required');

        if ($this->form_validation->run()) {
            $result = $this->Forwards_model->setForward($this->input->post());
            if ($result == true) {
                $this->session->set_flashdata('message', 'Forward is added');
            }
            redirect('forwards');
        }
        if (!isset($_POST['submit'])) {
            $_POST = $this->Forwards_model->getOne($domain, $user);
        }
        $data = array();
        $data["domains"] = $this->Domains_model->getAll();
        $this->render('forwards/add_edit_forward', $data);
    }

    public function validateEmail($email) {
        $pattern = "/^[a-zA-Z0-9\-\.\_\:]+\@[a-zA-Z0-9\-\.]+\.[a-zA-Z]+$/";
        if (!preg_match($pattern, $email)) {
            $this->form_validation->set_message('validateEmail', 'Invalid Email Address');
            return false;
        } else {
            return true;
        }
    }

    public function validinUsers($value) {
        $div = $this->divisionUserDomain($value);
        $value = $this->Users_model->getOne($div[1], $div[0]);
        if ($value != false) {
            return true;
        } else {
            $this->form_validation->set_message('validinUsers', 'This username is not in Users table');
            return false;
        }
    }

    public function uniqueUser($value) {
        $div = $this->divisionUserDomain($value);
        $value = $this->Forwards_model->getOne($div[0], $div[1]);
        if ($value != false) {
            $this->form_validation->set_message('uniqueUser', 'Forward is taken');
            return false;
        } else {
            return true;
        }
    }

    private function divisionUserDomain($value) {
        return explode('@', $value);
    }

    public function autocompleteReturn() {
        $result = $this->Users_model->getAutocomplete($this->input->get('term'));
        echo json_encode($result);
    }

    public function delforward() {
        $forwardanddomain = $this->input->post('check_list');
        if (!empty($forwardanddomain)) {
            $result = $this->Forwards_model->delforward($forwardanddomain);
            if ($result == true) {
                $this->session->set_flashdata('message', 'Delete Success');
            } else {
                $this->session->set_flashdata('message', 'Delete problem or this user is not in database');
            }
        } else {
            $this->session->set_flashdata('message', 'No Selected Items');
        }
        redirect('forwards');
    }

}
