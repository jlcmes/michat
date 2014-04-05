<?php
	$this->assign('title','MICHAT Secure Example');
	$this->assign('nav','secureexample');

	$this->display('_Header.tpl.php');
?>

<div class="container">

	<?php if ($this->feedback) { ?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">×</button>
			<?php $this->eprint($this->feedback); ?>
		</div>
	<?php } ?>
	
	<!-- #### this view/tempalate is used for multiple pages.  the controller sets the 'page' variable to display differnet content ####  -->
	
	<?php if ($this->page == 'login') { ?>
	
		<div class="hero-unit">
			<h1>Login </h1>
			<p>
				<?php if (isset($this->currentUser)) { ?>
				<p>You are currently logged in as '<strong><?php $this->eprint($this->currentUser->Username); ?></strong>'</p>
					<?php if ($this->currentUser->Username === "admin") { ?>
					<ul>
						<li><a href="./friendships">Friendships</a></li>
						<li><a href="./messages">Messages</a></li>
						<li><a href="./users">Users</a></li>
					</ul><br>
					<?php } ?>	
					<a href="logout" class="btn btn-primary btn-large">Logout</a>
				<?php } else { ?>
					<p>Please login as administrator to enter to the backend (admin/123) or as user. You can use the sample user (user1/123) or create a new one from the "Users" page logged as admin.</p>
				<?php } ?>				
			</p>
		</div>
	
			<?php if (!isset($this->currentUser)) { ?>
				<form class="well" method="post" action="login">
					<fieldset>
					<legend>Enter your credentials</legend>
						<div class="control-group">
						<input id="username" name="username" type="text" placeholder="Username..."/>
						</div>
						<div class="control-group">
						<input id="password" name="password" type="password" placeholder="Password..."/>
						</div>
						<div class="control-group">
						<button type="submit" class="btn btn-primary">Login</button>
						</div>
					</fieldset>
				</form>
			<?php } ?>
	
	<?php } else { ?>
		<div class="hero-unit">
			<h1>Login </h1>
			<p>
				<p>You are currently logged in as '<strong><?php $this->eprint($this->currentUser->Username); ?></strong>'</p>
				<?php if ((isset($this->currentUser)) && ($this->currentUser->Username === "admin")) { ?>				
				<ul>
					<li><a href="./friendships">Friendships</a></li>
					<li><a href="./messages">Messages</a></li>
					<li><a href="./users">Users</a></li><br>
				</ul><br>
				<?php } ?>
				<a href="logout" class="btn btn-primary btn-large">Logout</a>
			</p>
		</div>

	<?php } ?>

</div> <!-- /container -->

<?php
	$this->display('_Footer.tpl.php');
?>