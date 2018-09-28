    <article id="board_area">
        <header>
            <h1></h1>
        </header>
<?php
//$attributes = array('class' => 'form-horizontal', 'id' => 'auth_login');
//echo form_open('/auth5/login', $attributes);
?>
    {form_open}
    <fieldset>
        <legend>로그인</legend>
        <div class="control-group">
            <label class="control-label" for="input01">아이디</label>
            <div class="controls">
                <input type="text" class="input-xlarge" id="input01" name="username" value="{setv_user}">
                <p class="help-block"></p>
            </div>
                <label class="control-label" for="input02">비밀번호</label>
                <div class="controls">
                    <input type="password" class="input-xlarge" id="input02" name="password" value="{setv_pass}">
                    <p class="help-block"></p>
                </div>
                    
                <div class="controls">
                    <p class="help-block">{validation_errors}</p>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">확인</button>
                    <button class="btn" onclick="document.location.reload()">취소</button>
                </div>
        </div>
    </fieldset>
    </form>
    </article>