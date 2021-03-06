<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SB Admin - Bootstrap Admin Template</title>

	<script src="http://code.jquery.com/jquery-latest.js"></script>

	<!-- Bootstrap Core CSS -->
	<link href="/cdol/static/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="/cdol/static/css/sb-admin.css" rel="stylesheet">

	<!-- Morris Charts CSS -->
	<link href="/cdol/static/css/plugins/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="/cdol/static/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

</head>
<body>
	<script language="javascript">
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

		function addLoadEvent(func){
			var oldonload = window.onload;
			if(typeof window.onload != 'function'){
				window.onload = func;
			}else{
				window.onload = function(){
					oldonload();
					func();
				};
			}

		}

		window.onload = function() {
			var tmp = '<?=$this->uri->segment(2)?>';
			if(tmp == 'services' || tmp == 'menus' || tmp == 'boards' || tmp == 'pages'){
				$("#management").addClass("in");
			}

			$("#<?=$this->uri->segment(2)?>").addClass("active");
		}
	    	// function head_onload(){
	    	// 	var tmp = '<?=$this->uri->segment(2)?>';
	    	// 	if(tmp == 'services' || tmp == 'menus' || tmp == 'boards' || tmp == 'pages'){
	    	// 		document.getElementById('management').className="collaps in";
	    	// 	}
	    	// 	document.getElementById('<?=$this->uri->segment(2)?>').className="active";
	    	// }

	    	// addLoadEvent(head_onload);
		// $(document).ready(function() {
		//     $("a.dropdown-toggle").dropdown("toggle");
		// });Event(head_onload);
	// $(document).ready(function() {
	//     $("a.dropdown-toggle").dropdown("toggle");
	// });
	</script>

	<div id="wrapper">

		<!-- Navigation -->
		<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="main">Administrator</a>
			</div>
			<!-- Top Menu Items -->
			<ul class="nav navbar-right top-nav">
				<li class="dropdown">
					<a href="/cdol/main"><i class="fa fa-home"></i> Home</a>
				</li>
				<?php
				if($this->session->userdata('is_login') == true){
					?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$this->session->userdata('name')?> <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li>
								<a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
							</li>
							<li>
								<a href="javascript:win_memo('/cdol/memo');"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="/cdol/user/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
							</li>
						</ul>
					</li>
					<?php
				} else {
					?>
					<li>
						<li><a href="/cdol/user/login">Sign in</a></li>
					</li>
					<?php
				}
				?>
			</ul>
			<!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav side-nav">
					<li id="main">
						<a href="/cdol/adm/main"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
					</li>
					<li>
						<a href="javascript:;" data-toggle="collapse" data-target="#management"><i class="fa fa-fw fa-table"></i> Management <span class="fa fa-fw fa-caret-down"></span></a>
						<ul id="management" class="collapse">
							<li id="services">
								<a href="/cdol/adm/services"> Services</a>
							</li>
							<li id="menus">
								<a href="/cdol/adm/menus"> Menus</a>
							</li>
							<!-- <li id="pages">
							<a href="/cdol/adm/pages"> Pages</a>
							</li> -->
							<li id="boards">
								<a href="/cdol/adm/boards"> Boards</a>
							</li>
						</ul>
					</li>
					<li id="users">
						<a href="/cdol/adm/users"><i class="fa fa-fw fa-user"></i> Users</a>
					</li>
					<li>
						<a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Charts</a>
					</li>
					<li>
						<a href="forms.html"><i class="fa fa-fw fa-edit"></i> Forms</a>
					</li>
					<li>
						<a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Bootstrap Elements</a>
					</li>
					<li>
						<a href="bootstrap-grid.html"><i class="fa fa-fw fa-wrench"></i> Bootstrap Grid</a>
					</li>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</nav>

