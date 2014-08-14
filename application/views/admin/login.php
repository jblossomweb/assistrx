<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login - <?php echo ENVIRONMENT; ?></title>
		<meta name="description" content="description">
		<meta name="author" content="John Blossom">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="/assets/devoops/plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="/assets/devoops/css/style.css" rel="stylesheet">
		<link href="/assets/css/admin/font.css" rel="stylesheet">
		<link href="/assets/css/admin/style.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
		<link rel="apple-touch-icon-precomposed" href="/apple-touch-icon-precomposed.png">
		<link rel="shortcut icon" href="/favicon.ico">

	</head>
<body>
<div class="container-fluid">
	<div id="page-login" class="row">
		<div class="col-xs-12 col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="box">
				<div class="box-content">
					<div class="text-center">
						<h3 class="page-header"><img src="/assets/images/logo.png" width="25">&nbsp;<span class="font-myriad">AssistRx Admin Login</span></h3>
					</div>
					<div id="login-console"></div>
					<div class="form-group">
						<label class="control-label">Username</label>
						<input type="text" class="form-control" name="username" tabindex="1" />
					</div>
					<div class="form-group">
						<label class="control-label">Password</label>
						<input type="password" class="form-control" name="password" tabindex="2" />
					</div>
					<div class="text-center">
						<a id="btnLogin" style="cursor:pointer;" class="btn btn-primary" tabindex="3">Sign in</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type='text/javascript' src="//wurfl.io/wurfl.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/js/admin/login.js"></script>

</body>
</html>
