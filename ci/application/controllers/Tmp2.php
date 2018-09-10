<?php

include_once(__DIR__ . '/Base_controller.php');

class Tmp2 extends Base_Controller {

    //public $layout = 'default';
    public $libraries = array();
    public $helpers = array();
    public $models = array();
    
    function __construct() {
            parent::__construct();
            
            $this->load->helper(array('url'));
    }
    
    public function tmp_use() {
        $use = $this->input->post('use', TRUE);
        $id_var = post('id_var', TRUE);
        
        $this->load->helper('alert');
        
            $modify_data = array(
                'id' => $id_var, 
                'use' => $use
            );
            
            $rs = $this->db
                            ->where('id', $id_var)
                            ->update('items', $modify_data);
   }
}    