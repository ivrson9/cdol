	<!-- Custom styles for this template -->
	<link href="/cdol/static/css/signin.css" rel="stylesheet">

	<div class="container">

		<form class="form-signin" action="/cdol/user/authentication<?=empty($returnURL) ? '' : '?returnURL='.rawurlencode($returnURL) ?>" method="POST">
			<h2 class="form-signin-heading">Please sign in</h2>

			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="text" id="email" name="email" class="form-control" placeholder="Email address" required autofocus>

			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="password" name="password" class="form-control" placeholder="Password" required>

			<div class="checkbox">
				<label>
					<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			<div>
				<a href="/cdol/user/register"><h4>Sign up</h4></a>
			</div>
		</form>

	</div> <!-- /container -->
