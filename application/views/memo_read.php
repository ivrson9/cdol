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

	<title>내 쪽지함</title>

</head>
<body>

	<div class="container">
		<div class="memo">
			<h3 class="head">내 쪽지함</h3>

			<div class="table-responsive">
			<form onsubmit="return fmemoform_submit(this);" method="POST" id="fmemofor" name="fmemofor" autocomplete="off">
				<table class="table">
					<tr>
						<td width="50" style="vertical-align: middle; text-align: center;"><strong><sup>*</sup>Id : </strong></td>
						<td><?=$memo->send_id?></td>
					</tr>
					<tr>
						<td colspan="2"><?=$memo->memo?></td>
					</tr>
				</table>
			</form>
		</div>
		<div class="text-center">
			<a class="btn btn-default" href="javascript:history.back()" role="button" id="btn_submit">List</a>
			<a class="btn btn-success" href="" role="button" id="btn_submit">Reply</a>
    			<a class="btn btn-primary" href="javascript:window.close();" role="button" >Close</a>
    		</div>
	    	</div>
	</div>
</div>

</body>
</html>

