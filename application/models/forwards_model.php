<?php

class Forwards_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function record_count($filter) {
        if (!empty($filter['serachforwards'])) {
            $this->db->like('local_part', $filter['serachforwards']);
        }
        return $this->db->count_all_results("userforward");
    }

    public function getAll($limit, $start, $filter) {
        if (!empty($filter['serachforwards'])) {
            $this->db->like('local_part', $filter['serachforwards']);
        }
        $query = $this->db->limit($limit, $start)->
                get('userforward');
        $result = $query->result_array();
        foreach ($result as $key => &$val) {
            $val['recipients'] = explode(',', $val['recipients']);
        }
        return $result;
    }

    public function getOne($domain, $user) {
        $where_arr = array(
            'domain' => $domain,
            'local_part' => $user
        );
        $query = $this->db->where($where_arr)
                ->get('userforward');
        $result = $query->row_array();
        if (!empty($result['recipients'])) {
            $result['recipients'] = explode(',', $result['recipients']);
        }
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            $result['domain'] = '@' . $result['domain'];
            return $result;
        }
    }

    public function setForward($post) {
        $div = explode('@', $post['local_part']);
        if (!in_array($post['local_part'], $post['recipients'])) {
            array_unshift($post['recipients'], $post['local_part']);
        }
        $data = array(
            'local_part' => $div[0],
            'domain' => $div[1],
            'recipients' => implode(',', $post['recipients'])
        );

        $this->db->replace('userforward', $data);

        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function delforward($forwardanddomain) {
        foreach ($forwardanddomain as $val) {
            $arr = explode('@', $val);
            $where_arr = array(
                'local_part' => $arr[0],
                'domain' => $arr[1]
            );
            $this->db->where($where_arr)
                    ->delete('userforward');
        }
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

}
