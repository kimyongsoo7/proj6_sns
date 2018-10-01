<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(__DIR__ . '/Base_controller.php');

/** 
 * 게시판 메인 controller.
 */
class Board5 extends Base_Controller {
    
    public $layout = 'board5';
    public $libraries = array('pagination', 'form_validation');
    public $helpers = array('form', 'alert');
    public $models = array('board5_m');
    
    
    /**
     * 주소에서 메소드가 생략되었을 때 실행되는 기본 메소드
     */
    public function index()
    {
        $this->lists();
    }
    
    /**
     * _remap
     */
    public function _remap($method)
    {
        if( method_exists($this, $method) )
        {
            $this->{"{$method}"}();
        }
    }
    
    /**
     * 목록 불러오기
     */
    public function lists()
    {
        $this->output->enable_profiler(TRUE);
        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 5;
        
        //주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
        $uri_array = $this->segment_explode($this->uri->uri_string());
        
        if( in_array('q', $uri_array) ) {
            //주소에 검색어가 있을 경우의 처리, 즉 검색시
            $search_word = urldecode($this->url_explode($uri_array, 'q'));
            
            //페이지네이션용 주소
            $page_url = '/q/'.$search_word;
            $uri_segment = 7;
        }
        
        //페이지네이션 라이브러리 로딩 추가
        //$this->load->library('pagination');
        
        //페이지네이션 설정
        $config['base_url'] = '/board5/lists/ci_board'.$page_url.'/page/';
        $config['total_rows'] = $this->board5_m->get_list($this->uri->segment(3), 'count', '', '', $search_word);
        $config['per_page'] = 5;
        $config['uri_segment'] = $uri_segment;
        
        //페이지네이션 초기화
        $this->pagination->initialize($config);
        //페이징 링크를 생성하여 view에서 사용할 변수에 할당
        $data['pagination'] = $this->pagination->create_links();
        
        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);
        
        if ( $page > 1 )
        {
            $start = (($page/$config['per_page'])) * $config['per_page'];
        }
        else
        {
            $start = ($page-1) * $config['per_page'];
        }
        
        $limit = $config['per_page'];
        
        $seg_1 = $this->uri->segment(1);
        $seg_3 = $this->uri->segment(3);
        $seg_5 = $this->uri->segment(5);
        $result = $this->board5_m->get_list($this->uri->segment(3), '', $start, $limit, $search_word);
        
        $this->assign('result', $result);
        $this->assign('seg_1', $seg_1);
        $this->assign('seg_1_lay', $seg_1, true);       //레이아웃 변수값
        $this->assign('seg_3', $seg_3);
        $this->assign('seg_3_lay', $seg_3, true);       //레이아웃 변수값
        $this->assign('seg_5', $seg_5);
        
        $this->assign('pagination', $data['pagination']);
        $this->assign('page', $page);
        
        $this->tpl_name = 'lists';
        
    }
    
    /**
     * 게시물 보기
     */
    function view()
    {
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(5);
        
        //게시판 이름과 게시물 번호에 해당하는 게시물 가져오기
        //$data['views'] = $this->board5_m->get_view($table, $board_id);
        $result = $this->board5_m->get_view($table, $board_id);
        
        //게시판 이름과 게시물 번호에 해당하는 댓글 리스트 가져오기
        //$data['comment_list'] = $this->board5_m->get_comment($table, $board_id);
        $rs_co = $this->board5_m->get_comment($table, $board_id);
        $seg_1 = $this->uri->segment(1);
        $seg_3 = $this->uri->segment(3);
        $seg_5 = $this->uri->segment(5);
        $seg_7 = $this->uri->segment(7);
        
        $this->assign('result',$result);
        $this->assign('seg_1_lay', $seg_1, true);       //레이아웃 변수값
        $this->assign('seg_3', $seg_3);
        $this->assign('seg_3_lay', $seg_3, true);       //레이아웃 변수값
        $this->assign('seg_5', $seg_5);
        $this->assign('seg_7', $seg_7);
        $this->assign('rs_co', $rs_co);
        
        $this->tpl_name = 'view';
        
        $this->output->enable_profiler(TRUE);
        
    }
    
    /**
     * 게시물 쓰기
     */
    function write()
    {
        //경고창 헬퍼 로딩
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        if( @$_SESSION['logged_in'] == TRUE )
        {
            //폼 검증 라이브러리 로드
            //$this->load->library('form_validation');
        
            //폼 검증할 필드와 규칙 사전 정의
            $this->form_validation->set_rules('subject', '제목', 'required');
            $this->form_validation->set_rules('contents', '내용', 'required');
        
            //form_open 함수 템플릿 언더바에서 사용하기 위해 처리
            $attributes = array('class' => 'form-horizontal', 'id' => 'write_action');
            $form_open = form_open('board5/write/ci_board', $attributes);
        
            if ( $this->form_validation->run() == TRUE )
            {
                //주소중에서 page 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
                $uri_array = $this->segment_explode($this->uri->uri_string());
            
                if( in_array('page', $uri_array) )
                {
                    $pages = urldecode($this->url_explode($uri_array, 'page'));
                }
                else
                {
                    $pages = 1;
                }
            
                $write_data = array(
                    'table' => $this->uri->segment(3),
                    'subject' => post('subject', TRUE),
                    'contents' => post('contents', TRUE),
                    //'user_id' => 'tmpID'
                    'user_id' => $_SESSION['username']
                );
            
                $result = $this->board5_m->insert_board($write_data);
            
                if ( $result )
                {
                    //글 작성 성공시 게시판 목록으로
                    alert('입력되었습니다.', '/board5/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                }
                else
                {
                    //글 실패시 게시판 목록으로
                    alert('다시 입력해 주세요.', '/board5/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                }
            }
            else
            {
                //쓰기폼 view 호출
                //$this->load->view('board5/write_v');
                
                //set_value 함수 템플릿 언더바에서 사용하기 위한 처리
                $set_subj = set_value("subject");
                $set_cont = set_value("contents"); 
                
                $validation_errors = validation_errors();
                $this->assign('form_open', $form_open);
                $this->assign('set_subj', $set_subj);
                $this->assign('set_cont', $set_cont);
                $this->assign('validation_errors', $validation_errors);
                
                //레이아웃 변수값들
                $seg_1 = $this->uri->segment(1);
                $seg_3 = $this->uri->segment(3);
                $this->assign('seg_1_lay', $seg_1, true);       //레이아웃 변수값
                $this->assign('seg_3_lay', $seg_3, true);       //레이아웃 변수값
                
                $this->tpl_name = 'write';
            }
        }
        else
        {
            alert('로그인 후 작성하세요', '/auth5/login/');
            exit;
        }
    }
    
    /**
     * 게시물 수정
     */
    function modify()
    {
        //경고창 헬퍼 로딩
        //$this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        //주소중에서 page 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
        $uri_array = $this->segment_explode($this->uri->uri_string());
        
        if( in_array('page', $uri_array) )
        {
            $pages = urldecode($this->url_explode($uri_array, 'page'));
        }
        else
        {
            $pages = 1;
        }
        
        if( @$_SESSION['logged_in'] == TRUE )
        {
            //수정하려는 글의 작성자가 본인인지 검증
            $writer_id = $this->board5_m->writer_check($this->uri->segment(3), $this->uri->segment(5));

            if( $writer_id->user_id != $_SESSION['username'] )
            {
                alert('본인이 작성한 글이 아닙니다.', '/board5/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$pages);
                exit;
            }
            
            //폼 검증할 필드와 규칙 사전 정의
            $this->form_validation->set_rules('subject', '제목', 'required');
            $this->form_validation->set_rules('contents', '내용', 'required');
        
            //form_open 함수 템플릿 언더바에서 사용하기 위한 처리
            $form_open = form_open('/board5/modify/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5), array('id'=>'write_action', 'class'=>'form-horizontal'));
        
            //set_value 함수 템플릿 언더바에서 사용하기 위한 처리
            $setv_subj = set_value("subject");
            $setv_cont = set_value('contents');
        
            if ( $this->form_validation->run() == TRUE )
            {
                if ( !post('subject', TRUE) AND !post('contents', TRUE) )
                {
                    //글 내용이 없을 경우, 프로그램단에서 한번 더 체크
                    alert('비정상적인 접근입니다.', '/board5/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                }
            
                //var_dump($_POST);
                $modify_data = array(
                    'table' => $this->uri->segment(3),
                    'board_id' => $this->uri->segment(5),
                    'subject' => post('subject', TRUE),
                    'contents' => post('contents', TRUE)
                );
            
                $result = $this->board5_m->modify_board($modify_data);
            
                if ( $result )
                {
                    //글 작성 성공시 게시판 목록으로
                    alert('수정되었습니다.', '/board5/lists/'.$this->uri->segment(3).'/page/'.$pages);
                    exit;
                }
                else
                {
                    //글 수정 실패시 글 내용으로
                    alert('다시 수정해 주세요.', '/board5/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$pages);
                    exit;
                }
            }
            else
            {
                //게시물 내용 가져오기
                //$data['views'] = $this->board5_m->get_view($this->uri->segment(3), $this->uri->segment(5));
            
                //쓰기폼 view 호출
                //$this->load->view('board5/modify_v', $data);
            
                $validation_errors = validation_errors();
            
                $seg_1 = $this->uri->segment(1);
                $seg_3 = $this->uri->segment(3);
                $seg_5 = $this->uri->segment(5);
                $result = $this->board5_m->get_view($this->uri->segment(3), $this->uri->segment(5));
            
                $this->assign('seg_3',$seg_3);
                $this->assign('seg_5',$seg_5);
                $this->assign('result',$result);
                $this->assign('form_open',$form_open);
                $this->assign('seg_1_lay', $seg_1, true);       //레이아웃 변수값
                $this->assign('seg_3_lay', $seg_3, true);       //레이아웃 변수값
                
                $this->assign('setv_subj',$setv_subj);
                $this->assign('setv_cont',$setv_cont);
                $this->assign('validation_errors',$validation_errors);
            
                $this->tpl_name = 'modify';
            }
        }
        else
        {
            alert('로그인후 수정하세요', '/auth5/login/');
            exit;
        }
    }
    
    /**
     * 게시물 삭제
     */
    function delete()
    {
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        if( @$_SESSION['logged_in'] == TRUE )
        {
            //삭제하려는 글의 작성자가 본인인지 검증
            $table = $this->uri->segment(3);
            $board_id = $this->uri->segment(5);
            
            $writer_id = $this->board5_m->writer_check($table, $board_id);
        
            if( $writer_id->user_id != $_SESSION['username'] )
            {
                alert('본인이 작성한 글이 아닙니다.', '/board5/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$this->uri->segment(7));
                exit;
            }
            
            //게시물 번호에 해당하는 게시물 삭제
            $return = $this->board5_m->delete_content($this->uri->segment(3), $this->uri->segment(5));
        
            //게시물 목록으로 돌아가기
            if ( $return )
            {
                //삭제가 성공한 경우
                alert('삭제되었습니다.', '/board5/lists/'.$this->uri->segment(3).'/page/'.$this->uri->segment(7));
            }
            else
            {
                //삭제가 실패한 경우
                alert('삭제 실패하였습니다.', '/board5/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$this->uri->segment(7));
            }
        }
        else
        {
            alert('로그인후 삭제하세요', '/auth5/login/');
            exit;
        }    
    }
    
    /**
     * url중 키값을 구분하여 값을 가져오도록.
     * 
     * @param Array $url : segment_explode 한 url값
     * @param String $key : 가져오래는 값의 key
     * @return String $url[$k] : 리턴값
     */
    function url_explode($url, $key)
    {
        $cnt = count($url);
        for($i=0; $cnt>$i; $i++)
        {
            if($url[$i] ==$key)
            {
                $k = $i+1;
                return $url[$k];
            }
        }
    }
    
    function segment_explode($seg)
    {
        
        $len = strlen($seg);
        if(substr($seg, 0, 1) == '/')
        {
            $seg = substr($seg, 1, $len);
        }
        $len = strlen($seg);
        if(substr($seg, -1) == '/')
        {
            $seg = substr($seg, 0, $len-1);
        }
        $seg_exp = explode("/", $seg);
        return $seg_exp;
    }
}

