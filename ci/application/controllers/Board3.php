<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(__DIR__ . '/Base_controller.php');



//class Board3 extends CI_Controller {
class Board3 extends Base_Controller {    
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('board3_m');
        $this->load->helper('form');
    }
    
    
    
    
    public function index()
    {
        $this->lists();
    }
    
    
    
    
    
    public function _remap($method)
    {
        
        $this->load->view('header_v');
        
        if( method_exists($this, $method) )
        {
            $this->{"{$method}"}();
        }
        
        
        $this->load->view('footer_v');
    }
    
    
    
    
    public function lists()
    {
        $this->output->enable_profiler(TRUE);
        
        $search_word = $page_url = '';
        $uri_segment = 5;
        
        
        $uri_array = $this->segment_explode($this->uri->uri_string());
        
        if( in_array('q', $uri_array) ) {
            
            $search_word = urldecode($this->url_explode($uri_array, 'q'));
            
            
            $page_url = '/q/'.$search_word;
            $uri_segment = 7;
        }
        
        
        $this->load->library('pagination');
        
        $config['base_url'] = '/board3/lists/ci_board'.$page_url.'/page/';
        $config['total_rows'] = $this->board3_m->get_list($this->uri->segment(3), 'count', '', '', $search_word);
        $config['per_page'] = 5;
        $config['uri_segment'] = $uri_segment;
        
        $this->pagination->initialize($config);
        
        $data['pagination'] = $this->pagination->create_links();
        
        
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
        
        /*
        $data['list'] = $this->board3_m->get_list($this->uri->segment(3), '', $start, $limit, $search_word);
        $this->load->view('board3/list_v', $data);
        */
        
        $seg_1 = $this->uri->segment(1);
        $seg_3 = $this->uri->segment(3);
        $seg_5 = $this->uri->segment(5);
        $result = $this->board3_m->get_list($this->uri->segment(3), '', $start, $limit, $search_word);
        
        $this->assign('result', $result);
        $this->assign('seg_1', $seg_1);
        $this->assign('seg_3', $seg_3);
        $this->assign('seg_5', $seg_5);
        
        $this->assign('pagination', $data['pagination']);
        $this->assign('page', $page);
        
        $this->tpl_name = 'lists';
        
       
        
    }
    
    
    
    
    function view()
    {
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(5);
        
        /*
        $data['views'] = $this->board3_m->get_view($table, $board_id);
        
        $this->load->view('board3/view_v', $data);
        */
     
        $this->output->enable_profiler(TRUE);
        
        $result = $this->board3_m->get_view($table, $board_id);
        
        $seg_3 = $this->uri->segment(3);
        $seg_5 = $this->uri->segment(5);
        $seg_7 = $this->uri->segment(7);
        
        $this->assign('result', $result);
        $this->assign('seg_3', $seg_3);
        $this->assign('seg_5', $seg_5);
        $this->assign('seg_7', $seg_7);
        
        $this->tpl_name = 'view';
    }
    
    
    
    
    
    
    
    
    function write()
    {
        
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('subject', '제목', 'required');
        $this->form_validation->set_rules('contents', '내용', 'required');

        //form_open 함수 템플릿 언더바에서 사용하기 위해 처리
        $attributes = array('class' => 'form-horizontal', 'id' => 'write_action');
        //form_open('board3/write/ci_board', $attributes);        
        $form_open = form_open('board3/write/ci_board', $attributes);
        
        
        if ( $this->form_validation->run() == TRUE )
        {
            
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
                'subject' => $this->input->post('subject', TRUE),
                'contents' => $this->input->post('contents', TRUE),
                //'user_id' => $this->session->userdata('username')
                'user_id' => '울랄라'    
            );
            
            $result = $this->board3_m->insert_board($write_data);
            
            if ( $result )
            {
                
                alert('입력되었습니다.', '/board3/lists/'.$this->uri->segment(3).'/page/'.$pages);
                exit;
            }
            else
            {
                
                alert('다시 입력해 주세요.', '/board3/lists/'.$this->uri->segment(3).'/page/'.$pages);
                exit;
            }
        }
        else
        {
            
            //$this->load->view('board3/write_v');
            
            $this->assign('form_open', $form_open);
            
            $this->tpl_name = 'write';
            
        }
    }
    
    function modify()
    {
        
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        $uri_array = $this->segment_explode($this->uri->uri_string());
        
        if( in_array('page', $uri_array) )
        {
            $pages = urldecode($this->url_explode($uri_array, 'page'));
        }
        else
        {
            $pages = 1;
        }
        
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('subject', '제목', 'required');
        $this->form_validation->set_rules('contents', '내용', 'required');
        
        //form_open 함수 템플릿 언더바에서 사용하기 위해 처리
        $form_open = form_open('/board3/modify/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5), array('id'=>'write_action', 'class'=>'form-horizontal'));
        
        //set_value 함수 템플릿 언더바에서 사용하기 위해 처리
        $setv_subj = set_value("subject");
        $setv_cont = set_value("contents");
        
        if ( $this->form_validation->run() == TRUE )
        {
            if ( !$this->input->post('subject', TRUE) AND !$this->input->post('contents', TRUE) )
            {
                
                alert('비정상적인 접근입니다.', '/board3/lists/'.$this->uri->segment(3).'/page/'.$pages);
                exit;
            }
            
            $modify_data = array(
                'table' => $this->uri->segment(3),
                'board_id' => $this->uri->segment(5),
                'subject' => $this->input->post('subject', TRUE),
                'contents' => $this->input->post('contents', TRUE)
            );
            
            $result = $this->board3_m->modify_board($modify_data);
            
            if ( $result )
            {
                
                alert('수정되었습니다.', '/board3/lists/'.$this->uri->segment(3).'/page/'.$pages);
                exit;
            }
            else
            {
                alert('다시 수정해 주세요.', '/board3/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$pages);
                exit;
            }
        }
        else
        {
            /*
            $data['views'] = $this->board3_m->get_view($this->uri->segment(3), $this->uri->segment(5));
            
            $this->load->view('board3/modify_v', $data);
            */
            $seg_3 = $this->uri->segment(3);
            $seg_5 = $this->uri->segment(5);
            $result = $this->board3_m->get_view($this->uri->segment(3), $this->uri->segment(5));
            
            $this->assign('seg_3', $seg_3);
            $this->assign('seg_5', $seg_5);
            $this->assign('result', $result);
            $this->assign('form_open', $form_open);
            
            $this->assign('setv_subj', $setv_subj);
            $this->assign('setv_cont', $setv_cont);
            
            $this->tpl_name = 'modify';
        }
        
    }
    
    function delete()
    {
        
        $this->load->helper('alert');
        echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
        
        $table = $this->uri->segment(3);
        $board_id = $this->uri->segment(5);
        
        $return = $this->board3_m->delete_content($this->uri->segment(3), $this->uri->segment(5));
        
        if ( $return )
        {
            alert('삭제되었습니다.', '/board3/lists/'.$this->uri->segment(3).'/page/'.$this->uri->segment(7));
        }
        else
        {
            alert('삭제 실패하였습니다.', '/board3/view/'.$this->uri->segment(3).'/board_id/'.$this->uri->segment(5).'/page/'.$this->uri->segment(7));
        }
    }
    
    
    function url_explode($url, $key)
    {
        $cnt = count($url);
        for($i=0; $cnt>$i; $i++ )
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