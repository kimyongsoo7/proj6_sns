<?php if (!defined('BASEPATH')) exit('No direct script access allowed');







class Board3_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    function get_list($table='ci_board', $type='', $offset='', $limit='', $search_word='')
    {
        $sword= ' WHERE 1=1 ';
        
        if ( $search_word != '' )
        {
            
            $sword = ' WHERE subject like "%'.$search_word.'%" or contents like "%'.$search_word.'%" ';
        }    
        
        $limit_query = '';
        
        if ( $limit != '' OR $offset != '' )
        {
            
            $limit_query = ' LIMIT '.$offset.', '.$limit;
        }
        
        $sql = "SELECT * FROM ".$table.$sword." AND board_pid = '0' ORDER BY board_id DESC".$limit_query;
        $query = $this->db->query($sql);
        
        if ( $type == 'count' )
        {
            
            $result = $query->num_rows();
            
            //$this->db->count_all($table);
        }
        else
        {
            
            $result = $query->result();
        }
        
        return $result;
    }
    
    
    
    
    
    
    
    
}