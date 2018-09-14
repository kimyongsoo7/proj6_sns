<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(__DIR__ . '/Base_controller.php');

/** 
 * Ajax 처리 controller.
 * 
 * 
 */
//class Ajax_board extends CI_Controller {
class Ajax_board extends Base_Controller {    
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Ajax 테스트
     */
    public function test()
    {
        
        $this->load->view('ajax/test_v');
    }
    
    public function ajax_action()
    {
      echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
      $name = $this->input->post("name");
      echo $name."님 반갑습니다!";
    }
    
    public function ajax_comment_add()
    {
            
            $this->load->model('board3_m');
            
            $table = $this->input->post("table", TRUE);
            $board_id = $this->input->post("board_id", TRUE);
            $comment_contents = $this->input->post("comment_contents", TRUE);
            
            if ( $comment_contents != '')
            {
                $write_data = array(
                    'table' => $table,
                    'board_pid' => $board_id,
                    'subject' => '',
                    'contents' => $comment_contents,
                    //'user_id' => $this->session->userdata('username')
                    'user_id' => 'louis'
                );
                
                $result = $this->board3_m->insert_comment($write_data);
                
                if ( $result )
                {
                    
                    $sql = "SELECT * FROM ".$table." WHERE board_pid = '".$board_id."' ORDER BY board_id DESC";
                    $query = $this->db->query($sql);
?>
<table cellspacing="0" cellpadding="0" class="table table-striped" id="comment_table">
<?php
foreach ($query->result() as $lt)
{
?>
    <tr id="row_num_<?php echo $lt->board_id;?>">
        <th scope="row">
            <?php echo $lt->user_id;?>
        </th>
        <td><?php echo $lt->contents;?></a></td>
        <td><time datetime="<?php echo mdate("%y-%M-%j", human_to_unix($lt->reg_date));?>"><?php echo $lt->reg_date;?></time></td>
        <td><a href="#" class="comment_delete" vals="<?php echo $lt->board_id;?>"><i class="icon-trash"></i>삭제1</a></td>
    </tr>
<?php    
}
?>
    
</table>
<?php
                }
                else
                {
                   
                    echo "2000";
                }
                
            }
            else
            {
                
                echo "1000";
            }
            
    }
    
    public function ajax_comment_delete()
    {
        //alert('ccc');
       
        $this->load->model('board3_m');
        
        $table = $this->input->post("table", TRUE);
        $board_id = $this->input->post("board_id", TRUE);
        
        $result = $this->board3_m->delete_content($table, $board_id);
        
        if ( $result )
        {
            echo $board_id;
        }
        else
        {
            echo "2000";
        }
         /* */        
    }
    
}    
    





































