<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="viewport" content="width=device-width,initial-scale=1, user-scalable=no" />
        <title>CodeIgniter</title>
        <!--[if lt IE 9]>
        <script src="http://html5shiv.googleapis.com/svn/trunk/html5.js"></script>
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
                        <!--{? _SESSION.logged_in == true }-->
                        { _SESSION.username }님 환영합니다. <a href="/auth5/logout" class="btn">로그아웃</a>
                        <!--{:}-->
                        <a href="/auth5/login" class="btn btn-primary">로그인</a>
                        <!--{/}-->
                    </p>
                </blockquote>
            </header>
                    
                    <nav id="gnb">
                        <ul>
                            <li><a rel="external" href="/{seg_1_lay}/lists/{seg_3_lay}">Proj5</a></li>
                        </ul>
                    </nav>  
                    
                    {contents_for_layout}
                    
                    <footer id="footer">
                        <blockquote>
                            <p><a class="azubu" href="http://www.cikorea.net/" target="blank">사용자포험</a></p>
                            <small>Copyright by <em class="black"><a href="mailto:mold76@hanmail.net">LOUIS.KIM</a></small>
                        </blockquote>
                    </footer>
        </div>
    </body>
</html>