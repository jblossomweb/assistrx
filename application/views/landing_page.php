<!DOCTYPE HTML>
<!--
	Aerial by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php echo $title;?> - <?php echo $subtitle;?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="<?php echo $asset_path;?>css/ie/html5shiv.js"></script><![endif]-->
		<script src="<?php echo $asset_path;?>js/skel.min.js"></script>
		<script src="<?php echo $asset_path;?>js/init.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.pack.js"></script>

		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.css" />
		<link rel="stylesheet" href="<?php echo $asset_path;?>css/skel.css" />
		<link rel="stylesheet" href="<?php echo $asset_path;?>css/style.css" />
		<link rel="stylesheet" href="<?php echo $asset_path;?>css/style-wide.css" />

		<noscript>
			<link rel="stylesheet" href="<?php echo $asset_path;?>css/style-noscript.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="<?php echo $asset_path;?>css/ie/v9.css" /><![endif]-->
		<!--[if lte IE 8]><link rel="stylesheet" href="<?php echo $asset_path;?>css/ie/v8.css" /><![endif]-->

		<link rel="stylesheet" href="<?php echo $asset_path;?>css/custom.css" />
	</head>
	<body class="loading">
		<div id="wrapper">
			<div id="bg"></div>
			<div id="overlay"></div>
			<div id="main">

				<!-- Header -->
					<header id="header">
						<h1><?php echo $title;?></h1>
						<p><?php echo $subtitle;?></p>
						<p><a class="btn" href="<?php echo $button['href'];?>" alt="<?php echo $button['label'];?>" title="<?php echo $button['label'];?>"><?php echo $button['label'];?></a></p>
						<nav>
							<ul>
								<?php foreach ($links as $link): ?>
								<li><a alt="<?php echo $link['label']?>" title="<?php echo $link['label']?>" target="<?php echo $link['target']?>" href="<?php echo $link['href']?>" class="icon <?php echo $link['icon']?>"><span class="label"><?php echo $link['label']?></span></a></li>
								<?php endforeach; ?>
							</ul>
						</nav>
					</header>

					<!-- Footer -->
					<footer id="footer">
						<span class="copyright"><a class="fancybox fancybox.iframe" alt="Table Flipping" title="Table Flipping" href="http://www.youtube.com/embed/ySBTAMUVIFc?autoplay=1">(╯°□°）╯︵ ┻━┻</a>.</span>
					</footer>
				
			</div>
		</div>

	<script type="text/javascript">
		$(document).ready(function() {
			$(".fancybox").fancybox();
		});
	</script>
	</body>
</html>