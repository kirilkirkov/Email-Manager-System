<?php

class Vacation_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function record_count($filter) {
        if (!empty($filter['searchvacation'])) {
            $this->db->like('email', $filter['searchvacation']);
        }
        return $this->db->count_all_results("vacation");
    }

    public function getAll($limit, $start, $filter) {
        if (!empty($filter['searchvacation'])) {
            $this->db->like('email', $filter['searchvacation']);
        }
        $query = $this->db->limit($limit, $start)
                ->get('vacation');
        return $query->result_array();
    }

    public function getOne($domain, $user) {
        $where_arr = array(
            'domain' => $domain,
            'email' => $user
        );
        $query = $this->db->where($where_arr)
                ->get('vacation');
        $result = $query->row_array();
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            $result['domain'] = '@' . $result['domain'];
            $result['startdate'] = date('m/d/Y', $result['startdate']);
            $result['enddate'] = date('m/d/Y', $result['enddate']);
            return $result;
        }
    }

    public function setVacation($post) {
        $div = explode('@', $post['email']);
        if (isset($post['active'])) {
            $post['active'] = 1;
        } else {
            $post['active'] = 0;
        }
        $data = array(
            'email' => $div[0],
            'domain' => $div[1],
            'startdate' => strtotime($post['startdate']),
            'enddate' => strtotime($post['enddate']),
            'subject' => $post['subject'],
            'message' => $post['message'],
            'created' => date('Y-m-d H:m:s', time()),
            'active' => $post['active']
        );

        $this->db->replace('vacation', $data);
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function delVacation($useranddomain) {
        foreach ($useranddomain as $val) {
            $arr = explode('@', $val);
            $where_arr = array(
                'email' => $arr[0],
                'domain' => $arr[1]
            );
            $this->db->where($where_arr)
                    ->delete('vacation');
        }
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

}
