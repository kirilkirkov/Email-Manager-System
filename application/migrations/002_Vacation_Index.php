<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Vacation_Index extends CI_Migration {

    public function up() {
        $this->db->query('DROP INDEX `PRIMARY` ON vacation');
        $this->db->query('ALTER TABLE vacation ADD PRIMARY KEY (email,domain)');
    }

    public function down() {
        $this->db->query('DROP INDEX `PRIMARY` ON vacation');
        $this->db->query('ALTER TABLE vacation ADD PRIMARY KEY (email)');
    }

}
