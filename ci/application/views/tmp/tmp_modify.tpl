<form method="post" action="" id="write_action">
<table border="1">
    <tr>
        <td>제목 : <input type="text" name="content" id="input01" value="{rs.content}" size="15"> </td>
    </tr>
    <tr>
        <td>시행날짜 : <input type="text" name="due_date" id="input02" value="{rs.due_date}" size="10"> </td>
    </tr>
    <tr>
        <td>사용여부 : <input type="radio" name="use" value="1" id="input03" <!--{? rs.use=='1' }-->checked="checked" <!--{/}--> > 사용
            <input type="radio" name="use" value="0" id="input04" <!--{? rs.use=='0' }-->checked="checked" <!--{/}-->> 비사용
        </td>
    </tr>
    <tr>
        <td>
            <input type="submit" value="전송">
        </td>
    </tr>
</table>
<table>
    <tr>
        <td><a href="/tmp/tmp_list/">리스트</a></td>
    </tr>
</table>
</form>    