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
        
        $data['list'] = $this->board3_m->get_list($this->uri->segment(3), '', $start, $limit, $search_word);
        $this->load->view('board3/list_v', $data);
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