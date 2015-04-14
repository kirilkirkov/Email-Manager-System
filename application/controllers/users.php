<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
        $this->load->model('Users_model');
        $this->load->model('Domains_model');
    }

    public function index($page = 0) {
        $filter = array();
        if ($this->input->get('searchuser')) {
            $filter['searchuser'] = $this->input->get('searchuser');
        }
        $rowscount = $this->Users_model->record_count($filter);
        $data["links_pagination"] = $this->pagination('users', $rowscount, $this->num_rows);
        $data["getusers"] = $this->Users_model->getAll($this->num_rows, $page, $filter);
        $this->render('users/users', $data);
    }

    public function add_edit_user($domain = null, $user = null) {
        $this->form_validation->set_rules('name', 'Username');
        if ($domain!==null && $user!==null) {
            $this->form_validation->set_rules('login', 'Username', 'required');
        } else {
            $this->form_validation->set_rules('login', 'Username', 'required|callback_uniqueUser[' . $this->input->post('domain') . ']');
        }
        $this->form_validation->set_rules('decrypt', 'Password', 'required');
        $this->form_validation->set_rules('domain', 'Domain', 'required');
        if ($this->form_validation->run()) {
            $result = $this->Users_model->add_edit_user($this->input->post());
            if ($result == true) {
                $this->session->set_flashdata('message', 'User is added');
            }
            redirect('users');
        }
        if (!isset($_POST['submit'])) {
            $_POST = $this->Users_model->getOne($domain, $user);
        }
        $data = array();
        $data["domains"] = $this->Domains_model->getAll();
        $this->render('users/add_edit_user', $data);
    }

    public function uniqueUser($user, $domain) {
        $value = $this->Users_model->getOne($domain, $user);
        if ($value != false) {
            $this->form_validation->set_message('uniqueUser', 'Username is Taken');
            return false;
        } else {
            return true;
        }
    }

    public function deluser() {
        $useranddomain = $this->input->post('check_list');
        if (!empty($useranddomain)) {
            $result = $this->Users_model->deluser($useranddomain);
            if ($result == true) {
                $this->session->set_flashdata('message', 'Delete Success');
            } else {
                $this->session->set_flashdata('message', 'Delete problem or this user is not in database');
            }
        } else {
            $this->session->set_flashdata('message', 'No Selected Items');
        }
        redirect('users');
    }

}
