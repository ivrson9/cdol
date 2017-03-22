    <!-- Custom styles for this template -->
    <link href="/cdol/static/css/signin.css" rel="stylesheet">

    <div class="container">
        <!-- <?php echo validation_errors(); ?>  -->
        <form class="form-signin" action="/cdol/user/register" method="POST">
            <fieldset>
                <h2 class="form-signin-heading">Sign up</h2>

                <label for="inputEmail" class="sr-only">Email address</label>
                <input type="text" id="email" name="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="Email address" required autofocus>
                <span id="email_chk" class="cap" style="color:red;display:none"><?php echo form_error('email');?></span>

                <label for="inputNickname" class="sr-only">Nickname</label>
                <input type="text" id="nickname" name="nickname" class="form-control" value="<?php echo set_value('nickname'); ?>" placeholder="Nickname" required>
                <span id="name_chk" class="cap" style="color:red;display:none"><?php echo form_error('nickname');?></span>

                <label for="inputPassword" class="sr-only">Password</label>
                <input type="password" id="password" name="password" class="form-control" value="<?php echo set_value('password'); ?>" placeholder="Password" required>
                <span id="pass_chk" class="cap" style="color:red;display:none"><?php echo form_error('password');?></span>

                <label for="inputReword" class="sr-only">Confirm Password</label>
                <input type="password" id="re_password" name="re_password" class="form-control" value="<?php echo set_value('re_password'); ?>" placeholder="Confirm Password" required>
                <span id="repass_chk" class="cap" style="color:red;display:none"><?php echo form_error('re_password');?></span>

                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember-me"/> Remember me
                    </label>
                </div>

                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign up</button>
            </fieldset>
        </form>

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

    </div> <!-- /container -->
