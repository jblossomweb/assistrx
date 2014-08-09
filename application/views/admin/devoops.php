<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Admin - <?php echo ENVIRONMENT; ?></title>
		<meta name="description" content="description">
		<meta name="author" content="John Blossom">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../assets/devoops/plugins/bootstrap/bootstrap.css" rel="stylesheet">
		<link href="../assets/devoops/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet">
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.css" rel="stylesheet">
		<link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
		<link href="../assets/devoops/plugins/fancybox/jquery.fancybox.css" rel="stylesheet">
		<link href="../assets/devoops/plugins/fullcalendar/fullcalendar.css" rel="stylesheet">
		<link href="../assets/devoops/plugins/xcharts/xcharts.min.css" rel="stylesheet">
		<link href="../assets/devoops/plugins/select2/select2.css" rel="stylesheet">
		<link href="../assets/devoops/css/style.min.css" rel="stylesheet">
		<link href="../assets/css/flat.audio.css" rel="stylesheet">
		<link href="../assets/css/admin/font.css" rel="stylesheet">
		<link href="../assets/css/admin/style.css" rel="stylesheet">
		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
				<script src="http://getbootstrap.com/docs-assets/js/html5shiv.js"></script>
				<script src="http://getbootstrap.com/docs-assets/js/respond.min.js"></script>
		<![endif]-->
	</head>
<body>
<!--Start Header-->
<div id="screensaver">
	<canvas id="canvas"></canvas>
	<i class="fa fa-lock" id="screen_unlock"></i>
</div>
<div id="modalbox">
	<div class="devoops-modal">
		<div class="devoops-modal-header">
			<div class="modal-header-name">
				<span>Basic table</span>
			</div>
			<div class="box-icons">
				<a class="close-link">
					<i class="fa fa-times"></i>
				</a>
			</div>
		</div>
		<div class="devoops-modal-inner">
		</div>
		<div class="devoops-modal-bottom">
		</div>
	</div>
</div>
<header class="navbar">
	<div class="container-fluid expanded-panel">
		<div class="row">
			<div id="logo" class="col-xs-12 col-sm-2">
				<a href="/admin"><img src="/assets/images/logo.png" />&nbsp;<span class="font-myriad">AssistRx Admin</span></a>
			</div>
			<div id="top-panel" class="col-xs-12 col-sm-10">
				<div class="row">
					<div class="col-xs-8 col-sm-4">
						<a style="cursor:pointer;" class="show-sidebar">
						  <i class="fa fa-bars"></i>
						</a>
					</div>
					<div class="col-xs-4 col-sm-8 top-panel-right">
						<ul class="nav navbar-nav pull-right panel-menu">
							<li class="hidden-xs">
								<a>
									<i class="fa fa-hdd-o"></i>
									<span class="badge"><?php echo ENVIRONMENT; ?></span>
								</a>
							</li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
									<div class="avatar">
										<img src="../assets/images/admin/thumbs/<?php echo $admin_thumb; ?>" class="img-rounded" alt="avatar" />
									</div>
									<i class="fa fa-angle-down pull-right"></i>
									<div class="user-mini pull-right">
										<span class="welcome">Welcome,</span>
										<span><?php echo $admin_fname; ?></span>
									</div>
								</a>
								<ul class="dropdown-menu">
									<li>
										<a href="#">
											<i class="fa fa-user"></i>
											<span class="hidden-sm text">Profile</span>
										</a>
									</li>
									<li>
										<a href="#">
											<i class="fa fa-cog"></i>
											<span class="hidden-sm text">Settings</span>
										</a>
									</li>
									<li>
										<a href="/admin/logout">
											<i class="fa fa-power-off"></i>
											<span class="hidden-sm text">Logout</span>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
<!--End Header-->
<!--Start Container-->
<div id="main" class="container-fluid">
	<div class="row">
		<div id="sidebar-left" class="col-xs-2 col-sm-2">
			<ul class="nav main-menu">
				<li>
					<a class="ajax-link" href="/admin/ajax/dashboard" class="active">
						<i class="fa fa-dashboard"></i>
						<span class="hidden-xs">Dashboard</span>
					</a>
				</li>
				<?php /* todo: setup admin_user privledges, load these as admin_modules */ ?>
				<li class="dropdown">
					<a class="dropdown-toggle" style="cursor:pointer;">
						<i class="fa fa-users"></i>
						<span class="hidden-xs">Patients</span>
					</a>
					<ul class="dropdown-menu">
						<li>
                            <a class="ajax-link" href="/admin/ajax/patients">
                                <i class="fa fa-list"></i>
                                <span class="hidden-xs">List</span>
                            </a>
                        </li>
						<li>
                            <a class="ajax-link" href="/admin/ajax/patients/add">
                                <i class="fa fa-plus"></i>
                                <span class="hidden-xs">Add New</span>
                            </a>
                        </li>
					</ul>
				</li>
				<li class="dropdown">
					<a class="dropdown-toggle" style="cursor:pointer;">
						<i class="fa fa-file-text-o"></i>
						<span class="hidden-xs">Reports</span>
					</a>
					<ul class="dropdown-menu">
						<li>
                            <a class="ajax-link" href="/admin/ajax/reports/songs">
                                <i class="fa fa-music"></i>
                                <span class="hidden-xs">Chosen Songs</span>
                            </a>
                        </li>
						<li>
                            <a class="ajax-link" href="/admin/ajax/reports/genres">
                                <i class="fa fa-headphones"></i>
                                <span class="hidden-xs">Age Genres</span>
                            </a>
                        </li>
					</ul>
				</li>

			</ul>
		</div>
		<!--Start Content-->
		<div id="content" class="col-xs-12 col-sm-10">
			<div class="preloader">
				<img src="../assets/devoops/img/devoops_getdata.gif" class="devoops-getdata" alt="preloader"/>
			</div>
			<div id="ajax-content"></div>
		</div>
		<!--End Content-->
	</div>
</div>
<!--End Container-->
<?php /* jQuery (necessary for Bootstrap's JavaScript plugins) */ ?>
<script src="../assets/devoops/plugins/jquery/jquery-2.1.0.min.js"></script>
<script src="../assets/devoops/plugins/jquery-ui/jquery-ui.min.js"></script>
<?php /* Include all compiled plugins (below), or include individual files as needed */ ?>
<script src="../assets/devoops/plugins/bootstrap/bootstrap.min.js"></script>
<script src="../assets/devoops/plugins/justified-gallery/jquery.justifiedgallery.min.js"></script>
<script src="../assets/devoops/plugins/tinymce/tinymce.min.js"></script>
<script src="../assets/devoops/plugins/tinymce/jquery.tinymce.min.js"></script>
<script src="../assets/js/handlebars-v1.3.0.js"></script>

<?php /* requires handlebars */ ?>
<?php $this->load->view('admin/templates');?>

<?php /* <script src="//malsup.github.io/jquery.form.js"></script> */ ?>
<script src="../assets/js/jquery.form.min.js"></script>

<?php /* All functions for this theme + document.ready processing */ ?>
<script src="../assets/devoops/js/devoops.js"></script>
<?php /* sample: <script src="../assets/devoops/js/devoops-constants.js"></script> */ ?>
<script src="../assets/js/admin/devoops-constants.js"></script>
<script src="../assets/devoops/js/devoops-ready.js"></script>
</body>
</html>
