<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<script src="http://code.jquery.com/jquery-latest.js"></script>

	<!-- Bootstrap core CSS -->
	<link href="/cdol/static/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="/cdol/static/lib/bootstrap/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<link href="/cdol/static/css/style.css" rel="stylesheet">

	<title>내 쪽지함</title>

</head>
<body>
	<script>
		// 전체선택
		function checkbox_select(){
			var chk_all = document.getElementById("chk_all");
			var chk = document.getElementsByName("chk");

			if(chk_all.checked == true){
				for(i = 0 ; i < chk.length ; i++){
					chk[i].checked = true;
				}
			} else {
				for(i = 0 ; i < chk.length ; i++){
					chk[i].checked = false;
				}
			}
		}

		$(document).ready(function (){
                // 메모 삭제
                $("#del_btn").click(function() {
                	var length = $("input:checkbox[name='chk']:checked").length;
                	var del_list = new Array();
                	$(":checkbox[name='chk']:checked").each(function(index){
                		del_list[index] = $(this).val();
                	});
                	if (window.confirm("메모을 삭제하시겠습니까?")) {
                		$.post('/cdol/memo/memo_del', {
                			del_list: del_list,
                			length: length,
                			isDel: true
                		}, function(data){
                			self.location.reload();
                		});
                	}else{
                		return false;
                	}
			});
		});
	</script>
	<div class="container">
		<div class="memo">
			<h3 class="head">내 쪽지함</h3>
			<ul class="nav nav-tabs">
				<li role="presentation" class="active"><a href="/cdol/memo?kind=recv">받은 쪽지</a></li>
				<li role="presentation" class=""><a href="/cdol/memo?kind=send">보낸 쪽지</a></li>
				<li role="presentation" class=""><a href="/cdol/memo/memo_form">쪽지 쓰기</a></li>
			</ul>

			<?php
			if(count($recv_memo) == 0){
				?>
				<div class="none">자료가 없습니다.</div>
				<?php
			} else {
				foreach($recv_memo as $entry){
					?>
					<div class="item">
						<div class="checkbox">
							<input type="checkbox" name="chk" value="<?=$entry->m_no?>" style="margin:0">
						</div>
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
			<div class="all_check">
				<input type="checkbox" onclick="checkbox_select();" id="chk_all">
				<span>전체선택</span>
			</div>
			<div class="func">
				<div class="del">
					<a class="btn btn-danger btn-xs" role="button" id="del_btn">선택삭제</a>
				</div>
			</div>
			<div class="text-align:center"></div>
			<div class="text-center">
				<a class="btn btn-primary" href="javascript:window.close();" role="button" >Close</a>
			</div>
		</div>
		<!-- end memo -->
	</div>
	<!-- end container -->
</body>
</html>

