<aside class="left-side sidebar-offcanvas">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<!-- search form -->
		<!-- <form action="#" method="get" class="sidebar-form">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="Search..."/>
				<span class="input-group-btn">
					<button type='submit' name='search' id='search-btn' class="btn btn-flat">
						<i class="fa fa-search"></i>
					</button> </span>
			</div>
		</form> -->
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu">
<!-- template -->
			<li class="treeview">
				<a href="#">
					<i class="fa fa-picture-o"></i><span><?php echo __('Template'); ?></span><i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					<li class="<?php echo $this->here==$this->webroot.'templates/form'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>templates/form"> <i class="fa fa-pencil-square"></i> <span><?php echo __('Form'); ?></span> </a>
					</li>
				</ul>
			</li>
			
			
<!-- logout -->
			<li>nbsps;</li>
			<li class="<?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>users/logout"> <i class="fa fa-lock"></i> <span>ログアウト</span> </a>
			</li>
		</ul>
	</section>
	<!-- /.sidebar -->
</aside>