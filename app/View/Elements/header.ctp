<header class="header">
	<a href="<?php echo $this->webroot; ?>" class="logo"><?php echo __('System Name') ?>X </a>
	<nav class="navbar navbar-static-top" role="navigation">
		<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </a>
		<div class="navbar-right">
			<ul class="nav navbar-nav">
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="glyphicon glyphicon-user"></i> <span><?php echo $this->Session->read('Auth.User.user.name')?><i class="caret"></i></span> </a>
					<ul class="dropdown-menu">
						<li class="user-header bg-light-blue">
							<!-- <img src="<?php echo $this->webroot ?>" class="img-circle" alt="User Image" /> -->
							<p>
								<?php echo __('Hello') ?>,
								<?php echo $this->Session->read('Auth.User.user.name') ?>
								<!-- <small>Member since Nov. 2012</small> -->
							</p>
						</li>
						<!-- <li class="user-body">
							<div class="col-xs-4 text-center">
								<a href="#">Followers</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Sales</a>
							</div>
							<div class="col-xs-4 text-center">
								<a href="#">Friends</a>
							</div>
						</li>
						<li class="user-footer">
							<div class="pull-left">
								<a href="#" class="btn btn-default btn-flat">Profile</a>
							</div>
							<div class="pull-right">
								<a href="#" class="btn btn-default btn-flat">Sign out</a>
							</div>
						</li> -->
					</ul>
				</li>
			</ul>
		</div>
	</nav>
</header>