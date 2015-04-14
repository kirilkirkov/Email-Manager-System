<?php

class Domains_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function record_count() {
        return $this->db->count_all("domains");
    }

    public function getAll() {
        $query = $this->db->select('domain')->get("domains");
        foreach ($query->result_array() as $key=>$row) {
           $arr[$row['domain']]=$row['domain'];
        }
        return $arr;
    }

    public function setDomain($domain) {
        $data = array('domain' => $domain);
        $this->db->insert('domains', $data);
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function delDomain($domain) {
        $this->db->where_in('domain', $domain)
                ->delete('domains');
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

}
