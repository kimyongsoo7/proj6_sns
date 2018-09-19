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
}

