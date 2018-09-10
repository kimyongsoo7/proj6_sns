<table border="1">
{@rs}
     <tr>
         <td>
             <a href="/tmp/tmp_view/{.id}">{.content}</a>
         </td>
         <td>
             
             {=substr(.created_on,0,4)}
             
         </td>
         <td>
             {.due_date}
         </td>
     </tr>
{/}    

</table>
<table>
<tr>
    <td>
        {? !_SESSION.username}
        <a href="https://www.facebook.com/v3.1/dialog/oauth?
           client_id={app_id}&
           redirect_uri={redir}&
           state={state}">로그인</a>
        {:}   
        <a href="/tmp/tmp_logout">로그아웃</a>   
        {/}
        <a href="/tmp/tmp_write">등록</a>
    </td>
</tr>
</table>