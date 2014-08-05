<div>
	<h3>AssistRx Administrator</h3>
	<p>
		Dear <?php echo $fname;?> <?php echo $lname;?>,
	</p>
	<p>
		You are now an Administrator on <?php echo ENVIRONMENT; ?>.
		<ul>
			<li>username: <?php echo $username;?></li>
			<li>password: <?php echo $password;?></li>
		</ul>
	</p>
	<p>
		Please record your password in a safe place.<br>
		To login, click <a href="<?php echo $login_url;?>">here</a>.
	</p>
</div>