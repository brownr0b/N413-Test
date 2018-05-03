<?php
class Simple_model extends CI_Model {
    public function __construct(){
        parent::__construct();
//Autoload is being used to create the db connection
    }

    public function get_records() {
        $sql = "SELECT * from advanced ";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
}