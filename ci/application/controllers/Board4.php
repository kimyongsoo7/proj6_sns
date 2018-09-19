<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(__DIR__ . '/Base_controller.php');
/**
 * 게시판 메일 controller.
 */
//class Board4 extends CI_Controller {
class Board4 extends Base_Controller {
    
    function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->load->model('board4_m');
        $this->load->helper('form');
    }
    
    /**
     * index
     */
    public function index()
    {
        $this->lists();
    }
    
    /**
     * 사이트 헤더, 푸터를 자동으로 추가해준다.
     * 
     */
    public function _remap($method)
    {
        
        $this->load->view('header4_v');
        
        if( method_exists($this, $method) )
        {
            $this->{"{$method}"}();
        }
        
        
        $this->load->view('footer4_v');
    }
    
    /**
     * 목록
     */
    public function lists()
    {
        $this->output->enable_profiler(TRUE);
        //검색어 초기화
        $search_word = $page_url = '';
        $uri_segment = 5;
        /*
        //주소중에서 q(검색어) 세그먼트가 있는지 검사하기 위해 주소를 배열로 변환
        $uri_array = $this->segment_explode($this->uri->uri_string());
        
        if( in_array('q', $uri_array) ) {
            //주소에 검색어가 있을 경우의 처리, 즉 검색시
            $search_word = urldecode($this->url_explode($uri_array, 'q'));
        }
         */
        
        //게시판 목록을 불러오기 위한 offset, limit 값 가져오기
        $data['page'] = $page = $this->uri->segment($uri_segment, 1);
        
        $start = 0;
        $limit = 0;
        
        $data['list'] = $this->board4_m->get_list($this->uri->segment(3), '', $start, $limit);
        $this->load->view('board4/list_v', $data);
    }
    
    /**
     * 게시물 보기
     */
    function view()
    {
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(5);
        
        //게시판 이름과 게시물 번호에 해당하는 게시물 가져오기
        $data['views'] = $this->board4_m->get_view($table, $board_id);
        
        //view 호출
        $this->load->view('board4/view_v', $data);
    }
    
    /**
     * 게시물 쓰기
     */
    function write()
    {
        //경고창 헬퍼 로딩
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        //폼 검증 라이브러리 로드
        $this->load->library('form_validation');
        
        //폼 검증할 필드와 규칙 사전 정의
        $this->form_validation->set_rules('subject', '제목', 'required');
        $this->form_validation->set_rules('contents', '내용', 'required');
        
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
                //'subject' => $this->input->post('subject', TRUE),
                'subject' => post('subject', TRUE),
                //'contents' => $this->input->post('contents', TRUE),
                'contents' => post('contents', TRUE),
                'user_id' => '임시'
            );
            
            $result = $this->board4_m->insert_board($write_data);
            
            if ( $result )
            {
                //글 작성 성공시 게시판 목록으로
                alert('입력되었습니다.', '/board4/lists/'.$this->uri->segment(3).'/page/'.$pages);
                exit;
            }
            else
            {
                //글 실패시 게시판 목록으로
                alert('다시 입력해 주세요.', '/board4/lists/'.$this->uri->segment(3).'/page/'.$pages);
                exit;
            }
        }
        else
        {
            //쓰기폼 view 호출
            $this->load->view('board4/write_v');
        }
    }
    
    /**
     * url중 키값을 구분하여 값을 가져오도록.
     * 
     * @param Array $url : segment_explode 한 url값
     * @param String $key : 가져오려는 값의 key
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
    
    /**
     * HTTP의 URL을 "/"를 Delimiter로 사용하여 배열로 바꾸어 리턴한다.
     * 
     * @param string 대상이 있는 문자열
     * @return string[]
     * 
     */
    function segment_explode($seg)
    {
        //세그먼트 앞뒤 '/' 제거 후 uri를 배열로 반환
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

