<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * 사용자인증 모델
 * 
 */
class Auth5_m extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * 아이디. 비밀번호 체크
     */
    function login($auth)
    {
            $array = array('username' => $auth['username'], 'password' => $auth['password']);
            $tb = 'users';
            
            $query = $this->db
                        ->where($array)
                        ->get($tb);
            if ( $query->num_rows() > 0 )
            {
                //맞는 데이터가 있다면 해당 내용 반환
                return $query->row();
            }
            else
            {
                //맞는 데이터가 없을 경우
                return FALSE;
            }
    }
}

