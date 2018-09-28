<?php

include_once(__DIR__ . '/Base_controller.php');
/* 
 * 사용자 인증 controller.
 */
class Auth5 extends Base_Controller {
    
    /*
    public $layout = 'board5';
    public $libraries = array('pagination', 'form_validation');
    public $helpers = array('form', 'alert');
    public $models = array('board5_m');
    */
    public $layout = 'board5';
    public $libraries = array('form_validation');
    public $helpers = array('alert','form');
    public $models = array('auth5_m');
    
    /**
     * 주소에서 메소드가 생략되었을 때 실행되는 기본 메소드
     */
    public function index()
    {
        $this->login();
    }
    
    public function _remap($method)
    {
        if( method_exists($this, $method) )
        {
            $this->{"{$method}"}();
        }
    }
    
    /**
     * 로그인 처리
     */
    public function login()
    {
        //폼 검증 라이브러리 로드
        //$this->load->library('form_validation');
        
        //$this->load->helper('alert');
        
        //폼 검증할 필드와 규칙 사전 정의
        $this->form_validation->set_rules('username', '아이디', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', '비밀번호', 'required');
        
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        if ( $this->form_validation->run() == TRUE )
        {
            $auth_data = array(
                'username' => post('username', TRUE),
                'password' => post('password', TRUE)
            );
            
            $result = $this->auth5_m->login($auth_data);
            
            if ( $result )
            {
                //세션 생성
                /*
                $newdata = array(
                    'username' => $result->username,
                    'email' => $result->email,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($newdata);
                */
                $_SESSION['username'] = $result->username;
                $_SESSION['email'] = $result->email;
                $_SESSION['logged_in'] = TRUE;
                
                alert('로그인 되었습니다.', '/board5/lists/ci_board/page/1');
                exit;
            }
            else
            {
                //실패시
                alert('아이디나 비밀번호를 확인해 주세요.', '/board5/lists/ci_board/page/1');
                exit;
            }
        }
        else
        {
            $attributes = array('class' => 'form-horizontal', 'id' => 'auth_login');
            $form_open = form_open('/auth5/login', $attributes);
            $setv_user = set_value('username');
            $setv_pass = set_value('password');
            $validation_errors = validation_errors();
            
            $this->assign('form_open', $form_open);
            $this->assign('setv_user', $setv_user);
            $this->assign('setv_pass', $setv_pass);
            $this->assign('validation_errors', $validation_errors);
            
            $this->tpl_name = 'login';
            
            //쓰기폼 view 호출
            //$this->load->view('auth5/login_v');
            
        }
    }
    
    public function logout()
    {
        //$this->load->helper('alert');
        //$this->session->sess_destroy();
        session_destroy();
        
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        alert('로그아웃 되었습니다.', '/board5/lists/ci_board/page/1');
        exit;
    }
}

