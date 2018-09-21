<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
        <title>CodeIgniter</title>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <link rel="stylesheet" href="/include/css/bootstrap.css" />
    </head>
    <body>
        <div id="main">
            
            <header id="header" data-role="header" data-position="fixed">
                <blockquote>
                    <p>CodeIgniter</p>
                    <small>예제</small>
                    <p>
<?php
//if( @$this->session->userdata['logged_in'] == TRUE )
if( @$_SESSION["logged_in"] == TRUE )
{
?>
    <?php //echo $this->session->userdata['username']?>
    <?PHP echo $_SESSION["username"];?>님 환영합니다. <a href="/auth2/logout" class="btn">로그아웃</a>
<?php                        
} else {
?>
    <a href="/auth2/login" class="btn btn-primary">로그인</a>
<?php
}
?>
                    </p>
                </blockquote>
            </header>
            
            <nav id="gnb">
                <ul>
                    <li><a rel="external" href="/<?php echo $this->uri->segment(1);?>/lists/<?php echo $this->uri->segment(3);?>">Proj4</a></li>
                </ul>
            </nav>