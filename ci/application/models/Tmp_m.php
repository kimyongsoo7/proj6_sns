<?php

class Tmp_m extends CI_Model
{
    
    function __construct() {
        parent::__construct();
        
        //$this->load->helper(array('url'));
    }
    
    function get_view($table, $id)
    {
        $rs = $this->db
                    ->where('id', $id)
                    ->get($table)
                    ->row_array();
        
        return $rs;
    }
}
