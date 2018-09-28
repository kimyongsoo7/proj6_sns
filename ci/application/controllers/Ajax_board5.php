<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once(__DIR__ . '/Base_controller.php');
/** 
 * Ajax 처리 controller
 * 
 */
//class Ajax_board5 extends CI_Controller {
class Ajax_board5 extends Base_Controller {
    /*
    function __construct()
    {
        parent::__construct();
    }
     */
    
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
        //$name = $this->input->post("name");
        $name = post("name");
        echo $name."님 반갑습니다!";
    }
    
    public function ajax_comment_add()
    {
        //if( @$this->session->userdata('logged_in') == TRUE )
        //if( @$_SESSION['logged_in'] == TRUE )
        //{
            $this->load->model('board5_m');

            $table = post("table", TRUE);
            $board_id = post("board_id", TRUE);
//자바스크립트에서 encodeURIComponent로 인코딩한 값이 깨져서 디코딩 시킴, 얼뜻 보기론 따로 디코딩 안시켜도 된다고 했던것 같기도 함
            $comment_contents = rawurldecode(post("comment_contents", TRUE)); 
            if ( $comment_contents != '' )
            {
                $write_data = array(
                    'table' => $table,
                    'board_pid' => $board_id,
                    'subject' => '',
                    'contents' => $comment_contents,
                    'user_id' => 'TmpID'
                    //'user_id' => @$_SESSION['username']
                );

                $result = $this->board5_m->insert_comment($write_data);
                
                if ( $result )
                {
                    //글 작성 성공시 댓글 목록 만들어 화면 출력
                    $rs = $this->db
                                ->where('board_pid', $board_id)
                                ->order_by('board_id', 'desc')
                                ->get($table)
                                //->row_array();
?>
        <table cellspacing="0" cellpadding="0" class="table table-striped" id="comment_table">
<?php
foreach ($rs->result() as $lt)
{
?>
            <tr id="row_num_<?php echo $lt->board_id;?>">
                <th scope="row">
                    <?php echo $lt->user_id;?>
                </th>
                <td><?php echo $lt->contents;?></td>
                <td><?php echo $lt->reg_date;?></td>
                <td><a href="#" class="comment_delete" vals="<?php echo $lt->board_id;?>"><i class="icon-trash"></i>삭제</a></td>
            </tr>
<?php
}
?>
        </table>
<?php
                }
                else
                {
                    //글 실패시
                    echo "2000";
                }
            }
            else
            {
                //글 내용이 없을 경우
                echo "1000";
            }
        /*
        else
        {
            echo "9000"; //로그인 필요 에러
        }
         */
    }        
    
    
    public function ajax_comment_delete()
    {
        //if( @$_SESSION['logged_in'] == TRUE )
        //{
            $this->load->model('board5_m');
            
            $table = post("table", TRUE);
            $board_id = post("board_id", TRUE);
            
            //글 작성자가 본인인지 검증
            //$writer_id = $this->board5_m->writer_check($table, $board_id);
            
            /*
            if( $writer_id->user_id != @$_SESSION['username'] )
            {
                echo "8000"; //본인이 작성한 글이 아닙니다.
            }
            else
            {
             */
                $result = $this->board5_m->delete_content($table, $board_id);
                
                if ( $result )
                {
                    echo $board_id;
                }
                else
                {
                    //글 실패시
                    echo "2000";
                }
                
            //}
        /*    
        }
        else
        {
            echo "9000"; //로그인 필요 에러
        }
         */
    }
}

