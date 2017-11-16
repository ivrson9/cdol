	<!-- Custom styles for this template -->
	<link href="/cdol/static/css/signin.css" rel="stylesheet">
	<script>
		$(document).ready(function() {
			$('form#feedInput').submit(function(e) {
				e.preventDefault();
				var form = $(this);

				$.ajax({
					url: '/cdol/user/findByEmail',
					data: form.serialize(),
					dataType: 'json',
					type: 'post',
					success: function (result) {
						$('#myModal').addClass("in");
						$('#myModal').find('#modalMessage').html("전송");
						$('#myModal').on('hide.bs.modal', function(e){
							// 이전페이지로
							window.location.href = '';
						});
					},
					error: function (request,status,error){
						alert(error);
						$("#debug").html("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
					}
				});
			});
		});
	</script>

	<div class="container">

		<form class="form-signin" id="feedInput" name="feedInput">
		<!-- action="/cdol/user/authentication<?=empty($returnURL) ? '' : '?returnURL='.rawurlencode($returnURL) ?>" method="POST"> -->
			<input type="hidden" name="returnURL" id="returnURL" value="<?=empty($returnURL) ? '' : rawurlencode($returnURL) ?>"/>
			<h2 class="form-signin-heading">Forgot Email/Password</h2>

			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="text" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>

			<input class="btn btn-lg btn-primary btn-block" type="submit" data-toggle="modal" data-target="#myModal" value="Send Email"/>
			<div>
				<a href="#"><h6>Forgot your email?</h6></a>
			</div>
		</form>

		<!-- Modal popUp -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog"
			aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Login</h4>
					</div>
					<div class="modal-body"><span id="modalMessage"></span></div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

	</div> <!-- /container -->
