<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<!-- Bootstrap core CSS -->
	<link href="/cdol/static/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="/cdol/static/lib/bootstrap/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<link href="/cdol/static/css/style.css" rel="stylesheet">

	<title>내 쪽지함</title>

</head>
<body>
	<div class="container">
		<div class="memo">
			<h3 class="head">내 쪽지함</h3>
			<ul class="nav nav-tabs">
				<li role="presentation" class=""><a href="/cdol/memo?kind=recv">받은 쪽지</a></li>
				<li role="presentation" class="active"><a href="/cdol/memo?kind=send">보낸 쪽지</a></li>
				<li role="presentation" class=""><a href="/cdol/memo/memo_form">쪽지 쓰기</a></li>
			</ul>

			<?php
			if(count($send_memo) == 0){
			?>
			<div class="none">자료가 없습니다.</div>
			<?php
			} else {
				foreach($send_memo as $entry){
			?>
			<div class="item">
				<div class="name">
					<span><?=$entry->send_id?></span>
					<span class="date"><?=$entry->send_date?></span>
				</div>

				<div class="content">
					<a href="/cdol/memo/memo_read?m_no=<?=$entry->m_no?>"><?=$entry->memo?></a>
				</div>
			</div>
			<?php
				}
			}
			?>
			<div class="text-align:center"></div>
			<div class="text-center">
	    			<a class="btn btn-primary" href="javascript:window.close();" role="button" >Close</a>
	    		</div>
	    	</div>
	    	<!-- end memo -->
	</div>
</body>
</html>

