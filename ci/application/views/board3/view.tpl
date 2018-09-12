	
            <article id="board_area">
		<header>
			<h1></h1>
		</header>
		<table cellspacing="0" cellpadding="0" class="table table-striped">
			<thead>
				<tr>
					<th scope="col">{result.subject}</th>
					<th scope="col">이름 : {result.user_name}</th>
					<th scope="col">조회수 : {result.hits}</th>
					<th scope="col">등록일 : {result.reg_date}</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<th colspan="4">
                                            {result.contents}
					</th>
				</tr>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="4">
                                            <a href="/board3/lists/{seg_3}/page/{seg_7}" class="btn btn-primary">목록</a> <a href="/board3/modify/{seg_3}/board_id/{seg_5}/page/{seg_7}" class="btn btn-warning">수정</a> <a href="/board3/delete/{seg_3}/board_id/{seg_5}/page/{seg_7}" class="btn btn-danger">삭제</a> <a href="/board3/write/{seg_3}/page/{seg_7}" class="btn btn-success">쓰기</a></th>
				</tr>
			</tfoot>
		</table>

	</article>