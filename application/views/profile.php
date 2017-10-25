
	<!-- Custom styles for this template -->
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
		<div class="container-fluid">
			<form class="form-signin" action="/cdol/user/register" method="POST">
				<fieldset>
					<h2 class="form-signin-heading">Profile</h2>

					<label for="inputEmail" class="col-md-2">Email address</label>
					<div class="col-md-4">
						<input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="Email address" required autofocus>
						<span id="email_chk" class="cap" style="color:red;display:none"><?php echo form_error('email');?></span>
					</div>
					<label for="inputNickname" class="col-md-2">Nickname</label>
					<div class="col-md-4">
						<input type="text" id="nickname" name="nickname" class="form-control" value="<?php echo set_value('nickname'); ?>" placeholder="Nickname" required>
						<span id="name_chk" class="cap" style="color:red;display:none"><?php echo form_error('nickname');?></span>
					</div>

					<label for="inputPassword" class="col-md-2">Password</label>
					<div class="col-md-4">
						<input type="password" id="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" placeholder="Password" required>
						<span id="pass_chk" class="cap" style="color:red;display:none"><?php echo form_error('password');?></span>
					</div>
					<label for="inputReword" class="col-md-2">Confirm Password</label>
					<div class="col-md-4">
						<input type="password" id="re_password" name="re_password" class="form-control" value="<?php echo set_value('re_password'); ?>" placeholder="Confirm Password" required>
						<span id="repass_chk" class="cap" style="color:red;display:none"><?php echo form_error('re_password');?></span>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="remember-me"/> Remember me
						</label>
					</div>

					<button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
				</fieldset>
			</form>
		</div>

		<script type="text/javascript">
	            if('<?php echo form_error('email');?>' != ''){
	                document.getElementById('email_chk').style.display = 'block';
	            }
	            if('<?php echo form_error('nickname');?>' != ''){
	                document.getElementById('name_chk').style.display = 'block';
	            }
	            if('<?php echo form_error('password');?>' != ''){
	                document.getElementById('pass_chk').style.display = 'block';
	            }
	            if('<?php echo form_error('re_password');?>' != ''){
	                document.getElementById('repass_chk').style.display = 'block';
	            }
        	</script>

	</div>
