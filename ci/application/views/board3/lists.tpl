	<script>
            $(document).ready(function(){
                $("#search_btn").click(function(){
                    if($("#q").val() == ''){
                        alert('검색어를 입력해주세요.');
                        return false;
                    } else {
                        var act = '/board3/lists/ci_board/q/'+$("#q").val()+'/page/1';
                        $("#bd_search").attr('action', act).submit();
                    }
                });
            });
            
            function board_search_enter(form) {
                var keycode = window.event.keyCode;
                if(keycode == 13) $("#search_btn").click();
            }
        </script>
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
{@result}
				<tr>
					<th scope="row">
                                                {.board_id}
					</th>
					<td><a rel="external" href="/{seg_1}/view/{seg_3}/board_id/{.board_id}/page/{page}">{.subject}</a></td>
					<td>{.user_name}</td>
					<td>{.hits}</td>
                                        <td>{=substr(.reg_date, 0, -3)} </td>
				</tr>
{/}

			</tbody>
			<tfoot>
				<tr>
					<th colspan="5">{pagination}</th>
				</tr>
			</tfoot>
		</table>
            <div><p><a href="/board3/write/{seg_3}/page/{seg_5}" class="btn btn-success">쓰기</a></p></div>
		<div>
                        <form id="bd_search" method="post" class="well form-search" action="/board3/lists/ci_board">
				<i class="icon-search"></i> <input type="text" name="search_word" id="q" onkeypress="board_search_enter(document.q);" class="input-medium search-query" /> <input type="button" value="검색" id="search_btn" class="btn btn-primary" />
			</form>
		</div>
	</article>
