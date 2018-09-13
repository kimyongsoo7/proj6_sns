<?php if (!defined('BASEPATH')) exit('No direct script access allowed');







class Board3_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    
    
    
    
    
    
    
    
    
    
    
    function get_list($table='ci_board', $type='', $offset='', $limit='', $search_word='')
    {
      /*   
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
        */
     
    
        // 모델부분 AR로 변환
        if ( $search_word != '' )
        {
            if ( $limit != '' OR $offset != '' ) {
                $this->db->like('subject', $search_word);
                $this->db->or_like('contents', $search_word);
                $this->db->order_by("board_id", "desc");
                $query = $this->db->get($table, $offset, $limit);
            }
            else
            {
                $this->db->like('subject', $search_word);
                $this->db->or_like('contents', $search_word);
                $this->db->order_by("board_id", "desc");
                $query = $this->db->get($table);
            }
        } 
        else
        {
            if ( $limit != '' OR $offset != '' )
            {
                $this->db->order_by("board_id", "desc");
                $query = $this->db->get($table, $limit, $offset);
            }    
            else
            {
                $this->db->order_by("board_id", "desc");
                $query = $this->db->get($table);
            }    
        }
        
        if ( $type == 'count' )
        {
            $result = $query->num_rows();
        }
        else
        {
            //$result = $query->result();
            $result = $query->result_array();
        }
        
        return $result;
        
    }
    
    
    
    
    
    
    
    
    
    function get_view($table, $id)
    {
        /*
        $sql0 = "UPDATE ".$table." SET hits=hits+1 WHERE board_id='".$id."'";
        $this->db->query($sql0);
        
        $sql = "SELECT * FROM ".$table." WHERE board_id='".$id."'";
        $query = $this->db->query($sql);
        
        
        $result = $query->row();
        
        return $result;
        */
        
        $this->db->where('board_id', $id);
        $this->db->set('hits', 'hits+1', FALSE);
        $query = $this->db->update($table);
        
        $this->db->where('board_id', $id);
        $result = $this->db->get($table)->row_array();
        
        return $result;
    }
    
    
    
    
    
    
   
    
    function insert_board($arrays)
    {
        $insert_array = array(
            'board_pid' => 0,
            'user_id' => $arrays['user_id'],
            'user_name' => $arrays['user_id'],
            'subject' => $arrays['subject'],
            'contents' => $arrays['contents'],
            'reg_date' => date("Y-m-d H:i:s")
        );
        
        $result = $this->db->insert($arrays['table'], $insert_array);
        
        return $result;
    }
    
    
    
    
    
    
    
    
    
    function modify_board($arrays)
    {
        $modify_array = array(
            'subject' => $arrays['subject'],
            'contents' => $arrays['contents']
        );
        
        $where = array(
            'board_id' => $arrays['board_id']
        );
        
        $result = $this->db->update($arrays['table'], $modify_array, $where);
        
        
        return $result;
    }
    
    function delete_content($table, $no)
    {
        $delete_array = array(
            'board_id' => $no
        );
        
        $result = $this->db->delete($table, $delete_array);
        
        return $result;
    }
    
}