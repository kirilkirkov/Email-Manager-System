<?php

class Aliases_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function record_count($filter) {
        if (!empty($filter['serachaliases'])) {
            $this->db->like('local_part', $filter['serachaliases']);
        }
        return $this->db->count_all_results("aliases");
    }

    public function getAll($limit, $start, $filter) {
        if (!empty($filter['serachaliases'])) {
            $this->db->like('local_part', $filter['serachaliases']);
        }
        $query = $this->db->limit($limit, $start)
                ->get('aliases');
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
                ->get('aliases');
        $result = $query->row_array();
        if (!empty($result['recipients'])) {
            $result['recipients'] = explode(',', $result['recipients']);
        }
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return $result;
        }
    }

    public function setAlias($post) {
        $data = array(
            'local_part' => $post['local_part'],
            'domain' => $post['domain'],
            'recipients' => implode(',', $post['recipients'])
        );

        $this->db->replace('aliases', $data);

        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public function delalias($aliasanddomain) {
        foreach ($aliasanddomain as $val) {
            $arr = explode('@', $val);
            $where_arr = array(
                'local_part' => $arr[0],
                'domain' => $arr[1]
            );
            $this->db->where($where_arr)
                    ->delete('aliases');
        }
        if ($this->db->affected_rows() == 0) {
            return false;
        } else {
            return true;
        }
    }

}
