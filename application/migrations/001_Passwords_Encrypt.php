<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Passwords_Encrypt extends CI_Migration {

    public function up() {
        $this->do_encrypt(255, true);
    }

    public function down() {
        $this->do_encrypt();
    }

    private function do_encrypt($varchar = 64, $do = false) {
        if ($do == true) {
            $this->table_modify($varchar);
        }
        $query = $this->db->select('login,decrypt,domain')->get('users');
        foreach ($query->result_array() as $key => &$val) {
            if ($do == true) {
                $val['decrypt'] = $this->encrypt->encode($val['decrypt']);
            }
            if ($do == false) {
                $val['decrypt'] = $this->encrypt->decode($val['decrypt']);
            }
            $arr = array(
                'decrypt' => $val['decrypt']
            );
            $this->db->where('login', $val['login'])
                    ->where('domain', $val['domain'])
                    ->update('users', $arr);
        }
        if ($do == false) {
            $this->table_modify($varchar);
        }
    }

    private function table_modify($varchar) {
        $this->db->query("ALTER TABLE users MODIFY COLUMN decrypt VARCHAR($varchar)");
    }

}
