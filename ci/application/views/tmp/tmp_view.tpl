<form id="view_form" action="" method="post">
<table border="1">
    <tr>
        <td>제목 : {rs.content}</td>
    </tr>
    <tr>
        <td>만든날짜 : {rs.created_on}</td>
    </tr>
    <tr>
        <td>시행날짜 : {rs.due_date}</td>
    </tr>
    
    <tr>
    <input type="hidden" name="id_var" value="{id_var}">    
        <td>사용여부 : 
        <input type="radio" name="use" value="1" <!--{? rs.use=='1' }-->checked="checked" <!--{/}-->> 사용
            <input type="radio" name="use" value="0" <!--{? rs.use=='0' }-->checked="checked" <!--{/}-->> 비사용
        </td>
    </tr>
    
</table>
<table>
    <tr>
        <td><a href="/tmp/tmp_modify/{id_var}">수정</a></td>
        <td><a href="/tmp/tmp_delete/{id_var}">삭제</a></td>
        <td><a href="/tmp/tmp_list/">리스트</a></td>
    </tr>
</table>
</form> 
        
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
$(function() {
    $('input[type="radio"][name="use"]').change(function() {
        $(this).closest("form").submit();
    });
}); 

$('#view_form').on('submit', function(e) {                      // 폼 전송 이벤트가 발생
        e.preventDefault();                                     // 기본 동작을 취소한다
	var details = $('#view_form').serialize();              // 폼 데이터를 수집한다
        //$.post('form_ajax.php', details, function(data) {     // $.post() 메서드를 이용하여 데이터를 전송한다
	$.post('/tmp2/tmp_use/', details, function(data) {      // $.post() 메서드를 이용하여 데이터를 전송한다 -> 책 235p 참고
        //alert('vvv');
        //$('#view_form').html(data);                           // 결과를 출력한다.
        //alert(data);
        });
        
});


/*
$('#register').on('submit', function(e) {           // 폼 전송 이벤트가 발생
  e.preventDefault();                               // 기본 동작을 취소한다
  var details = $('#register').serialize();         // 폼 데이터를 수집한다
  $.post('register.php', details, function(data) {  // $.post() 메서드를 이용하여 데이터를 전송한다
    $('#register').html(data);                    // 결과를 출력한다
  });
});
*/
</script> 

