<?php //if (!defined('BASEPATH')) exit('No direct script access allowed');

//include_once(__DIR__ . '../Base_controller.php');
include_once(APPPATH . 'controllers/Base_controller.php');

/** 
 * 공동 게시판 모델 (이미지 포함)
 * 
 * 
 */
class Board5_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 게시물 목록 가져오기
     * 
     * @param string $table 게시판 테이블
     * @param string $type 중 게시물 수 또는 게시물 배열을 반환할 지를 결정하는 구분자
     * @param string $offset 게시물 가져올 순서
     * @param string $limit 한 화면에 표시할 게시물 갯수
     * @param string $search_word 검색어
     * @return array
     */
    function get_list($table='ci_board', $type='', $offset='', $limit='', $search_word='')
    {
        /*
        $sword = ' WHERE 1=1 ';
        
        if ( $search_word != '' )
        {
            //검색어가 있을 경우의 처리
            $sword = ' WHERE subject like "%'.$search_word.'%" or contents like "%'.$search_word.'%" ';
        }
        
        $limit_query = '';
        
        if ( $limit != '' OR $offset != '' )
        {
            //페이징이 있을 경우의 처리
            $limit_query = ' LIMIT '.$offset.', '.$limit;
        }
        
        $sql = "SELECT * FROM ".$table.$sword." AND board_pis = '0' ORDER BY board_id DESC".$limit_query;
        $query = $this->db->query($sql);
        
        if ( $type == 'count' )
        {
            //리스트를 반환하는 것이 아니라 전체 게시물의 갯수를 반환
            $result = $query->num_rows();
            
            //$this->db->count_all($table);
        }
        else
        {
            //게시물 리스트 반환
            $result = $query->result();
        }
        
        return $result;
         */
        
        if ( $search_word != '' )
        {
            if ( $limit != '' OR $offset != '' )
            {
                $query = $this->db
                            ->where('board_pid', '0')
                            ->like('subject', $search_word)
                            ->or_like('contents', $search_word)
                            ->order_by('board_id', 'desc')
                            ->get($table, $offset, $limit);
            }
            else
            {
                $query = $this->db
                            ->where('board_pid', '0')
                            ->like('subject', $search_word)
                            ->or_like('contents', $search_word)
                            ->order_by('board_id', 'desc')
                            ->get($table);
            }
        }
        else
        {
           if ( $limit != '' OR $offset != '' ) 
           {
               $query = $this->db
                            ->where('board_pid', '0')
                            ->order_by('board_id', 'desc')
                            ->get($table, $limit, $offset);
           }
           else
           {
               $query = $this->db
                            ->where('board_pid', '0')
                            ->order_by('board_id', 'desc')
                            ->get($table);
           }
        }
        
        if ( $type == 'count' )
        {
            $result = $query->num_rows();
        }
        else
        {
            $result = $query->result_array();
        }
        
        return $result;
        
    }
    
    function get_view($table, $id)
    {
        $this->db
                ->where('board_id', $id)
                ->set('hits', 'hits+1', FALSE)
                ->update($table);
        
        $result = $this->db
                ->where('board_id', $id)
                ->get($table)->row_array();
        
        return $result;
    }
    
    function delete_content($table, $no)
    {
        $delete_array = array(
            'board_id' => $no
        );
        
        $result = $this->db->delete($table, $delete_array);
        
        //결과 반환
        return $result;
    }
    
    function get_comment($table, $id)
    {
        $result = $this->db
                            ->where('board_pid', $id)
                            ->order_by('board_id', 'desc')
                            ->get($table)
                            ->result_array();
        
        return $result;
    }
    
    function insert_comment($arrays)
    {
        $insert_array = array(
            'board_pid' => $arrays['board_pid'],
            'user_id' => $arrays['user_id'],
            'user_name' => $arrays['user_id'],
            'subject' => $arrays['subject'],
            'contents' => $arrays['contents'],
            'reg_date' => date("Y-m-d H:i:s")
        );
        
        $this->db->insert($arrays['table'], $insert_array);
        
        $board_id = $this->db->insert_id();
        
        //결과 반환
        return $board_id;
    }
    
}

