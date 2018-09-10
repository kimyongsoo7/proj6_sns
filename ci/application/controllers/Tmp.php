<?php

include_once(__DIR__ . '/Base_controller.php');

class Tmp extends Base_Controller {
    
    public $layout = 'default';
    public $libraries = array();
    public $helpers = array();
    public $models = array();
    
    function __construct() {
            parent::__construct();
            
            $this->load->helper(array('url'));
    }
    
    public function tmp_list() {
        
        @$user_id = $_SESSION["username"];
        
        if(isset($user_id)) {
            echo '사용자: '.$user_id.'<br>';
        }
        
        $rs = $this->db
                    ->get('items')
                    ->result_array();
        
        $this->assign('rs', $rs);
        
        $app_id = '203127107066050';
        $redir = 'http://localhost/tmp/tmp_list/';
        $state = '';
        $sec_id = 'ca035ee675d6c63f60c2e2dad49685d5';
        $fb_url2 = 'https://graph.facebook.com/v3.1/oauth/access_token?';
        $app_sec = $app_id.'|'.$sec_id;
        
        
        $this->assign('app_id', $app_id);
        $this->assign('redir', $redir);
        $this->assign('state', $state);
        
        $this->tpl_name = 'tmp_list';
        
        $g_code = get('code', TRUE);
        
        if(isset($g_code)) {
            
            // 액세스 토큰 가져오기
            $url = "https://graph.facebook.com/v3.1/oauth/access_token?client_id=".$app_id."&redirect_uri=".$redir."&client_secret=".$sec_id."&code=".$g_code;        //호출대상 URL
            $ch = curl_init(); //파라미터:url -선택사항
            curl_setopt($ch,CURLOPT_URL,$url); //여기선 url을 변수로
            curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
            //curl_setopt ($ch, CURLOPT_SSLVERSION,3); // SSL 버젼 (https 접속시에 필요)
            curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch,CURLOPT_NOSIGNAL, 1);
            //curl_setopt($ch,CURLOPT_POST, 1); //Method를 POST로 지정.. 이 라인이 아예 없으면 GET
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
    
            $data = curl_exec($ch);
            $curl_errno = curl_errno($ch);
            $curl_error = curl_error($ch);
            curl_close($ch);
            
            $data_array = json_decode($data, true);
            @$token = $data_array["access_token"];
            if(isset($token)) {
                $_SESSION["token"] = $token;
            }
            
            
            // 사용자 정보 얻기
            $url = "https://graph.facebook.com/debug_token?input_token=".$token."&access_token=".$app_sec;
            //echo '$url='.$url.'<br>';
            $ch2 = curl_init(); //파라미터:url -선택사항
            curl_setopt($ch2,CURLOPT_URL,$url); //여기선 url을 변수로
            curl_setopt ($ch2, CURLOPT_SSL_VERIFYPEER, FALSE); // 인증서 체크같은데 true 시 안되는 경우가 많다.
            //curl_setopt ($ch2, CURLOPT_SSLVERSION,3); // SSL 버젼 (https 접속시에 필요)
            curl_setopt($ch2,CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2,CURLOPT_NOSIGNAL, 1);
            //curl_setopt($ch2,CURLOPT_POST, 1); //Method를 POST로 지정.. 이 라인이 아예 없으면 GET
            curl_setopt ($ch2, CURLOPT_RETURNTRANSFER, 1); // 결과값을 받을것인지
    
            $data2 = curl_exec($ch2);
            $curl_errno = curl_errno($ch2);
            $curl_error = curl_error($ch2);
            
            curl_close($ch2);
            
            $info_array = json_decode($data2, true);
            @$fb_user_id = $info_array["data"]["user_id"];
            
            if(isset($fb_user_id)) {
                $_SESSION["username"] = $fb_user_id;
            }  
            
        }    
            
    }
    
    public function tmp_view($id) {
        
        //$id = $this->uri->segment(3);
        
        $rs = $this->db
                    ->where('id', $id)
                    ->get('items')
                    ->row_array();
      
        $this->assign('rs', $rs);
        $this->assign('id_var', $id);
        
        $this->tpl_name = 'tmp_view';
        
    }
    
    public function tmp_write() {
        
        $this->load->helper('alert');
        
        @$user_id = $_SESSION["username"];
            
            if(!$user_id) {
                alert('로그인해 주세요.', '/tmp/tmp_list/');
                exit;
            }
        
        if( $_POST ) {
            
            $content = $this->input->post('content', TRUE);
            $created_on = date("Y-m-d");
            $due_date = $this->input->post('due_date', TRUE);
            $use = $this->input->post('use', TRUE);
            
            $data = array(
                'content' => $content,
                'created_on' => $created_on,
                'due_date' => $due_date,
                'use' => $use,
                'user_id' => $user_id
            );
            
            $this->db
                    ->insert('items', $data);
            
            redirect('/tmp/tmp_list/');
            exit;
                    
        } else {
            $this->tpl_name = 'tmp_write';

        }
    }
    
    public function tmp_modify($id) {
        
        //$id = $this->uri->segment(3);
        $this->load->helper('alert');
        
        @$user_id = $_SESSION["username"];
        
        if( $_POST ) {
            
            $modify_data = array(
                'id' => $id, 
                //'content' => $this->input->post('content', TRUE),
                'content' => post('content', TRUE),
                'due_date' => $this->input->post('due_date', TRUE),
                'use' => $this->input->post('use', TRUE)
            );
            
            $rs = $this->db
                            ->where('id', $id)
                            ->update('items', $modify_data);
            
            redirect('/tmp/tmp_list/');
            exit;
            
        } else {
            
            $rs = $this->db
                            ->where('id', $id)
                            ->get('items')
                            ->result_array();
            foreach($rs as $row) {
                $article_id = $row["user_id"];
            }
            
            if($user_id != $article_id) {
                alert_back('본인글만 수정이 가능합니다.');
                exit;
            }
            
            $this->assign('rs', $rs);
            $this->tpl_name = 'tmp_modify';
            
        }
    }
    
    public function tmp_delete($id) {
        
        //$id = $this->uri->segment(3);
        $this->load->helper('alert');
        @$user_id = $_SESSION["username"];
        
        $rs = $this->db
                        ->where('id', $id)
                        ->get('items')
                        ->row_array();
        $article_id = $rs["user_id"];
        
        if($article_id != $user_id) {
            alert_back('본인글만 삭제가 가능합니다.');
            exit;
        }
        
        $this->db
                ->where('id', $id)
                ->delete('items');
        
        redirect('/tmp/tmp_list/');
        exit;
    }
    
    public function tmp_login() {
        
        $this->load->helper('alert');
        
        if( $_POST ) { 
        
            $auth_data = array(
                'username' => post('username', TRUE),
                'password' => post('password', TRUE)
            );
        
            $rs = $this->db
                        ->where('username', $auth_data["username"], 'password', $auth_data["password"])
                        ->get('users')
                        ->row_array();
            
            $rs_ =  $this->db
                        ->where('username', $auth_data["username"], 'password', $auth_data["password"])
                        ->get('users');
            
            //echo $rs_->num_rows();
            if($rs_->num_rows() > 0) {
            
                $newdata = array(
                           'username'=> $rs["username"],
                           'email' => $rs["email"],
                           'logged_in' => TRUE
                );
                
                $_SESSION["username"] = $rs["username"];
                $_SESSION["email"] = $rs["email"];
                $_SESSION["logged_in"] = TRUE;
            
                alert('로그인 되었습니다.', '/tmp/tmp_list/');
                exit;
            
            } else {
                alert('아이디나 비밀번호를 확인해 주세요.', '/tmp/tmp_list/');
                exit;
            }
            
            $this->assign('rs', $rs);
        
        } else {
            $this->tpl_name = 'tmp_login';
        }
    }
    
    public function tmp_logout() {
        
        $this->load->helper('alert');
        
        $redir = "http://localhost/tmp/tmp_list/";
        $url = "https://www.facebook.com/logout.php?next=".$redir."&access_token=".$_SESSION["token"];
        
        session_destroy();
        replace($url); exit;
        
     }
     
     
}

