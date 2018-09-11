<?php

class Tmp_m extends CI_Model
{
    
    function __construct() {
        parent::__construct();
        
        //$this->load->helper(array('url'));
    }
    
    function get_list($table)
    {
        $rs = $this->db
                    ->get($table)
                    ->result_array();
        
        return $rs;
    }
    
    function get_view($table, $id)
    {
        $rs = $this->db
                    ->where('id', $id)
                    ->get($table)
                    ->row_array();
        
        return $rs;
    }
    
    function insert_board($arrays)
    {
        $rs = $this->db
                    ->insert('items', $arrays);
        
        return $rs;
    }
    
    function modify_board($id, $arrays)
    {
        $rs = $this->db
                        ->where('id', $id)
                        ->update('items', $arrays);
        
        //echo '$rs='.$rs.'<br>';
        //exit;
        return $rs;
        
    }
    
    function delete_content($id)
    {
        $rs = $this->db
                ->where('id', $id)
                ->delete('items');
        
        return $rs;
    }
}
