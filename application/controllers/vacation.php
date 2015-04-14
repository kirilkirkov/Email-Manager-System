<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
date_default_timezone_set('Europe/Sofia');

class Vacation extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
        $this->load->model('Vacation_model');
        $this->load->model('Forwards_model');
        $this->load->model('Users_model');
        $this->load->helper('text');
    }

    public function index($page = 0) {
        $filter = array();
        if ($this->input->get('searchvacation')) {
            $filter['searchvacation'] = $this->input->get('searchvacation');
        }
        $rowscount = $this->Vacation_model->record_count($filter);
        $data = array();
        $data["links_pagination"] = $this->pagination('vacation', $rowscount, $this->num_rows);
        $data['allmessages'] = $this->Vacation_model->getAll($this->num_rows, $page, $filter);
        $this->render('vacation/vacation', $data);
    }

    public function add_edit_vacation($domain = null, $user = null) {
        $this->form_validation->set_rules('email', 'Username', 'required|callback_validateEmail|callback_validinUsers');
        $this->form_validation->set_rules('startdate', 'Start Date', 'required');
        $this->form_validation->set_rules('enddate', 'End Date', 'required');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run()) {
            $result = $this->Vacation_model->setVacation($this->input->post());
            if ($result == true) {
                $this->session->set_flashdata('message', 'Auto-Reply is added');
            }
            redirect('vacation');
        }
        if (!isset($_POST['submit'])) {
            $_POST = $this->Vacation_model->getOne($domain, $user);
        }
        $this->render('vacation/add_edit_vacation');
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
        $div = explode('@', $value);
        $value = $this->Users_model->getOne($div[1], $div[0]);
        if ($value != false) {
            return true;
        } else {
            $this->form_validation->set_message('validinUsers', 'This username is not in Users table');
            return false;
        }
    }

    public function autocompleteReturn() {
        $result = $this->Users_model->getAutocomplete($this->input->get('term'));
        echo json_encode($result);
    }

    public function delvacation() {
        $useranddomain = $this->input->post('check_list');
        if (!empty($useranddomain)) {
            $result = $this->Vacation_model->delVacation($useranddomain);
            if ($result == true) {
                $this->session->set_flashdata('message', 'Delete Success');
            } else {
                $this->session->set_flashdata('message', 'Delete problem or this user is not in database');
            }
        } else {
            $this->session->set_flashdata('message', 'No Selected Items');
        }
        redirect('vacation');
    }

}
