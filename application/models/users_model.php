<?php

class Users_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function record_count($filter) {
        if (!empty($filter['searchuser'])) {
            $this->db->like('users.name', $filter['searchuser']);
            $this->db->or_like('users.login', $filter['searchuser']);
        }
        return $this->db->count_all_results("users");
    }

    public function getAll($limit, $start, $filter) {
        if (!empty($filter['searchuser'])) {
            $this->db->like('users.name', $filter['searchuser']);
            $this->db->or_like('users.login', $filter['searchuser']);
        }
        $query = $this->db->limit($limit, $start)
                ->get('users');
        $result = $query->result_array();
        foreach ($result as $key => &$val) {
            $val['decrypt'] = $this->encrypt->decode($val['decrypt']);
        }
        return $result;
    }

    public function add_edit_user($post) {
        $inputs = array(
            'name' => $post['name'],
            'login' => $post['login'],
            'decrypt' => $this->encrypt->encode($post['decrypt']),
            'domain' => $post['domain'],
            'password' => md5($post['decrypt']),
            'home' => '/var/mail/' . $post['domain'] . '/' . $post['login'] . '',
            'uid' => '26'
        );

        $this->db->replace('users', $inputs);

        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function getOne($domain, $user) {
        $where_arr = array(
            'domain' => $domain,
            'login' => $user
        );
        $query = $this->db->where($where_arr)
                ->get('users');
        $result = $query->row_array();
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            $result['decrypt'] = $this->encrypt->decode($result['decrypt']);
            return $result;
        }
    }

    public function getAutocomplete($value) {
    	$val=array();
        $query = $this->db->select('login,domain')->
                like('login', $value)->
                limit(5)->
                get('users');
        foreach ($query->result_array() as $val) {
            $values[] = $val['login'] . '@' . $val['domain'];
        }
         return $values;
    }

    public function deluser($useranddomain) {
        foreach ($useranddomain as $val) {
            $arr = explode('@', $val);
            $where_arr = array(
                'login' => $arr[0],
                'domain' => $arr[1]
            );
            $this->db->where($where_arr)
                    ->delete('users');
        }
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

}
