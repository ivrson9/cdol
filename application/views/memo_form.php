<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8">

	<!-- Bootstrap core CSS -->
	<link href="/cdol/static/lib/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<link href="/cdol/static/lib/bootstrap/docs/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

	<link href="/cdol/static/css/style.css" rel="stylesheet">

	<script src="http://code.jquery.com/jquery-latest.js"></script>

	<title>쪽지 보내기</title>

</head>
<body>

	<script type="text/javascript">
		//<![CDATA[
		$(document).ready(function() {
			$("#btn_submit").click(function() {
				if (window.confirm("전송하시겠습니까?")) {
					$.ajax({
						type:'POST',
						url:'/cdol/memo/send_memo',
						dataType:'text',
						data:{
							'recv_id' : $('#me_recv_mb_id').val(),
							'me_memo': $('#me_memo').val()
						},
						success:function(result){
							if(result == 'null'){
								alert('존재하지 않는 아이디 입니다');
							} else {
								alert('전송되었습니다');
								self.location.reload();
							}
						}
					});
				}else{
					return false;
				}
			});
		});
		//]]>
	</script>

	<div class="container">
		<div class="memo">
			<h3 class="head">내 쪽지함</h3>
			<ul class="nav nav-tabs">
				<li role="presentation" class=""><a href="/cdol/memo?kind=recv">받은 쪽지</a></li>
				<li role="presentation" class=""><a href="/cdol/memo?kind=send">보낸 쪽지</a></li>
				<li role="presentation" class="active"><a href="/cdol/memo/memo_form">쪽지 쓰기</a></li>
			</ul>

			<div class="table-responsive">
			<form onsubmit="return fmemoform_submit(this);" method="POST" id="fmemofor" name="fmemofor" autocomplete="off">
				<table class="table">
					<tr>
						<td width="50" style="vertical-align: middle; text-align: center;"><strong><sup>*</sup>Id : </strong></td>
						<td><input type="text" id="me_recv_mb_id" name="me_recv_mb_id" maxlength="150" class="form-control" placeholder="Id" /></td>
					</tr>
					<tr>
						<td colspan="2"><textarea class="form-control col-sm-5" rows="9" cols="105" id="me_memo" name="me_memo" form="fmemofor" placeholder="내용" ></textarea></td>
					</tr>
				</table>
			</form>
		</div>
		<div class="text-center">
			<a class="btn btn-success" href="" role="button" id="btn_submit">Send</a>
    			<a class="btn btn-primary" href="javascript:window.close();" role="button" >Close</a>
    		</div>
	    	</div>
	</div>

</body>
</html>

