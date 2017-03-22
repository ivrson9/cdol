<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1 maximum-scale=1, user-scalable=no">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<!-- <link rel="icon" href="../../favicon.ico"> -->

	<title>Starter Template for Bootstrap</title>

	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<!-- ckEditor -->
 	<script type = "text/javascript" src = "/cdol/static/lib/ckeditor/ckeditor.js"></script>
	<!-- Bootstrap core CSS -->
	<link href="/cdol/static/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="/cdol/static/lib/bootstrap/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/cdol/static/css/dashboard.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/cdol/static/css/carousel.css" rel="stylesheet">

	<link href="/cdol/static/css/style.css" rel="stylesheet">

	<!-- Custom Fonts -->
    <link href="/cdol/static/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>
<body>
	<script>
		// 쪽지 창
		function win_memo(url){
			if (!url)
				url = g4_path + "/" + g4_bbs + "/memo.php";
			win_open(url, "winMemo", "left=50,top=50,width=620,height=460,scrollbars=1");
		}
		function win_open(url, name, option){
			var popup = window.open(url, name, option);
			popup.focus();
		}
	</script>
	<nav class="navbar navbar-fixed-top navbar-inverse">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/cdol/main">Cdol Site</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
<?php
foreach($service as $entry){
	if($entry->m_cnt == 0){ // 세부 메뉴가 없을 경우
?>
					<li><a href="/cdol<?=$entry->s_url?>"><?=$entry->s_title?></a></li>
<?php
	} else if($entry->m_cnt == 1) { // 세부 메뉴가 1개일 경우
		foreach($menu_list as $entry2){
			if($entry2->s_no == $entry->s_no){
?>
					<li><a href="/cdol<?=$entry2->m_url?>"><?=$entry->s_title?></a></li>
<?php
			}
		}
	} else { // 세부 메뉴가 있을경우(드롭박스)
?>

					<li class="dropdown">
						<a href="#" class="dropdown-toggle js-activated" data-toggle="dropdown" role="button" aria-expanded="false"><?=$entry->s_title?></a>
						<ul class="dropdown-menu">
<?php
		foreach($menu_list as $entry2){
			if($entry2->s_no == $entry->s_no){
?>
							<li><a href="/cdol<?=$entry2->m_url?>"><?=$entry2->m_title?></a></li>
<?php
			} // end if
		} // foreach(entry2)
?>
						</ul>
					</li>
<?php
	} // end else
} // foreach(entry)
?>
				</ul>

				<ul class="nav navbar-nav navbar-right">
<?php //echo $this->session->userdata('ip_address');
	if($this->session->userdata('is_login') == true){
?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$this->session->userdata('name')?> <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li>
									<a href="/cdol/user/profile"><i class="fa fa-fw fa-user"></i> Profile</a>
									</li>
								<li>
									<a href="javascript:win_memo('/cdol/memo');"><i class="fa fa-fw fa-envelope"></i> Inbox (<?=$meno_cnt?>)</a>
									</li>
<?php
		if($this->session->userdata('level') >= 4) {
?>
								<li>
									<a href="/cdol/adm/main"><i class="fa fa-fw fa-gear"></i> Administrator</a>
								</li>
<?php
		}
?>
									<li class="divider"></li>
								<li>
									<a href="/cdol/user/logout"><i class="fa fa-fw fa-sign-out"></i> Log Out</a>
								</li>
							</ul>
						</li>
<?php
	} else {
?>
						<li><a href="/cdol/user/login"><i class="fa fa-fw fa-sign-in"></i> Sign in</a></li>
<?php
	}
?>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</nav>

	<div class="container-fluid">
		<div class="row">
