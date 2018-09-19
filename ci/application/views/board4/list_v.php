    <article id="board_area">
        <header>
            <h1></h1>
        </header>
        <table cellspacing="0" cellpadding="0" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">번호</th>
                    <th scope="col">제목</th>
                    <th scope="col">작성자</th>
                    <th scope="col">조회수</th>
                    <th scope="col">등록일</th>
                </tr>
            </thead>
            <tbody>
<?php
foreach ($list as $lt)
{
?>
                <tr>
                    <th scope="row">
                        <?php echo $lt->board_id;?>
                    </th>
                    <td><a rel="external" href="/<?php echo $this->uri->segment(1);?>/view/<?php echo $this->uri->segment(3);?>/board_id/<?php echo $lt->board_id;?>/page/<?php echo $page;?>"><?php echo $lt->subject;?></a></td>
                    <td><?php echo $lt->user_name;?></td>
                    <td><?php echo $lt->hits;?></td>
                    <td><time datetime="<?php mdate("%Y-%M-%j", human_to_unix($lt->reg_date));?>"><?php echo mdate("%M, %j, %Y", human_to_unix($lt->reg_date));?></time></td>
                </tr>
<?php                
}
?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3"></th>
                </tr>
            </tfoot>
        </table>
        <div>
            <p><a href="/board4/write/<?php echo $this->uri->segment(3);?>/page/<?php echo $this->uri->segment(5);?>" class="btn btn-success">쓰기</a></p>
        </div>
        <div>
        </div>
    </article>