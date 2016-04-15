<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
	<link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
    <link href="<?php echo base_url()?>css/stylesheet.css" rel="stylesheet">
    <link rel="shortcut icon" href="<?php echo base_url()?>images/logoutama.png">
    <style>
    	body {
		    background: url(<?php echo base_url();?>/images/bg_login.jpg);
		    background-size: 100% 100%;
   		    background-repeat: no-repeat;
		}
    </style>
  </head>

  <body >

    <div class="login-container">
        <div class="login-header bordered">
             <img src="<?php echo base_url();?>images/logoutama.png" style="height:50px;width:40px;margin:0px"> &nbsp; Login Pegawai 
        </div>
        <form id="logform" name="logform" action="<?php echo base_url() ?>home/loginact" method="post">
            <div class="login-field">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" class="form-control input-sm" placeholder="Username">
                <i class="icon-user"></i>
            </div>
            <div class="login-field">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control input-sm" id="password" placeholder="Password">
                <i class="icon-lock"></i>
            </div>
 			<hr>
            <div class="login-button clearfix">
                <button type="submit" style="width:100px" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-lock"></i>  Login</button>
                &nbsp; <button type="reset" style="width:100px" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-refresh"></i>  Reset</button>
            </div>
        </form>
        <hr>
        <img style="height:40px;width:40px" src="<?php echo base_url();?>images/krom.png"> &nbsp;  Best View With Google Chrome
    </div>

    <div id="forgot-pw" class="modal hide fade" tabindex="-1" data-width="760">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icon-remove"></i></button>
            <h3>Forgot your password?</h3>
        </div>
        <div class="modal-body">
            <div class="row-fluid">
                <div class="span12">
                    <div class="form_row">
                        <label class="field_name">Email address</label>
                        <div class="field">
                            <div class="row-fluid">
                                <div class="span8">
                                    <input type="text" class="span12" name="email" placeholder="example@domain.com">
                                </div>
                                <div class="span4">
                                    <a href="#" class="btn btn-block blue">Reset password</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
  </body>
</html>
