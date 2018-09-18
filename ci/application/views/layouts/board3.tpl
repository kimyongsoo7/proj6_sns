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
	<link rel='stylesheet' href="/bbs/include/css/bootstrap.css" />
</head>
<body>
<div id="main">

	<header id="header" data-role="header" data-position="fixed"><!-- Header Start -->
		<blockquote>
			<p>만들면서 배우는 CodeIgniter</p>
			<small>실행 예제</small>
			<p>
                    <!--{? _SESSION.logged_in == true }-->
                        { _SESSION.username }님 환영합니다. <a href="/auth/logout" class="btn">로그아웃</a>
                    <!--{:}-->
                            <a href="/auth/login" class="btn btn-primary">로그인</a>
                    <!--{/}-->
                        </p>
		</blockquote>
	</header><!-- Header End -->

	<nav id="gnb"><!-- gnb Start -->
		<ul>
			<li>게시판 프로젝트</li>
		</ul>
	</nav><!-- gnb End -->
        
        
        {contents_for_layout}
        

	<footer id="footer">
		<blockquote>
			<p><a class="azubu" href="http://www.cikorea.net/" target="blank">CodeIgniter한국사용자포럼</a></p>
			<small>Copyright by <em class="black"><a href="mailto:advisor@cikorea.net">Louis</a></small>
		<blockquote>
	</footer>

</div>

</body>
</html>        