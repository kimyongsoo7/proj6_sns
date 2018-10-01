        <article id="board_area">
            <header>
                <h1></h1>
            </header>
    
            <!--<form class="form-horizontal" method="post" action="/board5/write/ci_board" id="write_action">-->
            {form_open}
                <fieldset>
                    <legend>게시물 쓰기</legend>
                    <div class="control-group">
                        <label class="control-label" for="input01">제목</label>
                        <div class="controls">
                            <input type="text" class="input-xlarge" id="input01" name="subject" value="{set_subj}">
                            <p class="help-block">게시물의 제목을 써주세요.</p>
                        </div>
                            <label class="control-label" for="input02">내용</label>
                            <div class="controls">
                                <textarea class="input-xlarge" id="input02" name="contents" rows="5">{set_cont}</textarea>
                                <p class="help-block">게시물의 내용을 써주세요.</p>
                            </div>
                                
                            <div class="controls">
                                <p class="help-block">{validation_errors}</p>
                            </div>
                            
                            <div class="form-actions">
                                <button type="submit" class="btn btn-primary" id="write_btn">작성</button>
                                <button class="btn" onclick="document.location.reload()">취소</button>
                            </div>
                    </div>
                </fieldset>
            </form>
        </article>