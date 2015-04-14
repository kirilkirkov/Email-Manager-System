<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aliases extends MY_Controller {

    private $num_rows = 20;

    public function __construct() {
        parent::__construct();
        $this->load->model('Aliases_model');
        $this->load->model('Domains_model');
    }

    public function index($page = 0) {
        $filter = array();
        if ($this->input->get('serachaliases')) {
            $filter['serachaliases'] = $this->input->get('serachaliases');
        }
        $rowscount = $this->Aliases_model->record_count($filter);
        $data = array();
        $data["links_pagination"] = $this->pagination('aliases', $rowscount, $this->num_rows);
        $data['allaliases'] = $this->Aliases_model->getAll($this->num_rows, $page, $filter);
        $this->render('aliases/aliases', $data);
    }

    public function add_edit_alias($domain = null, $user = null) {
        if (isset($domain) && isset($user)) {
            $this->form_validation->set_rules('local_part', 'Alias', 'required');
        } else {
            $this->form_validation->set_rules('local_part', 'Alias', 'required|callback_uniqueUser[' . $this->input->post('domain') . ']');
        }
        $this->form_validation->set_rules('recipients', 'recipiens', 'required');
        if ($this->form_validation->run()) {
            $result = $this->Aliases_model->setAlias($this->input->post());
            if ($result == true) {
                $this->session->set_flashdata('message', 'Alias is added');
            }
            redirect('aliases');
        }
        if (!isset($_POST['submit'])) {
            $_POST = $this->Aliases_model->getOne($domain, $user);
        }
        $data = array();
        $data["domains"] = $this->Domains_model->getAll();
        $this->render('aliases/add_edit_alias', $data);
    }

    public function uniqueUser($user, $domain) {
        $value = $this->Aliases_model->getOne($domain, $user);
        if ($value != false) {
            $this->form_validation->set_message('uniqueUser', 'Alias is taken');
            return false;
        } else {
            return true;
        }
    }

    public function delalias() {
        $aliasanddomain = $this->input->post('check_list');
        if (!empty($aliasanddomain)) {
            $result = $this->Aliases_model->delalias($aliasanddomain);
            if ($result == true) {
                $this->session->set_flashdata('message', 'Delete Success');
            } else {
                $this->session->set_flashdata('message', 'Delete problem or this user is not in database');
            }
        } else {
            $this->session->set_flashdata('message', 'No Selected Items');
        }
        redirect('aliases');
    }

}
