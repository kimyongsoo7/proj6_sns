<?php //if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(__DIR__ . '/Base_controller.php');

/** 
 * 게시판 메인 controller.
 */
class Board5 extends Base_Controller {
    
    public $layout = 'board5';
    public $libraries = array('pagination');
    public $helpers = array('form');
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
        $seg_3 = $this->uri->segment(3);
        $seg_5 = $this->uri->segment(5);
        $seg_7 = $this->uri->segment(7);
        
        $this->assign('result',$result);
        $this->assign('seg_3', $seg_3);
        $this->assign('seg_5', $seg_5);
        $this->assign('seg_7', $seg_7);
        $this->assign('rs_co', $rs_co);
        
        $this->tpl_name = 'view';
        
        //$this->output->enable_profiler(TRUE);
        
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

