<div class="sidebar span2">
<ul class="nav nav-list bs-docs-sidenav affix-top">
	<li><a href="<?php echo $this->webroot?>admin" class="title_link" ><i class="icon-home"></i>TOP</a></li>
	<!--<li class="admin_statuses"><a href="<?php echo $this->webroot?>admin/statuses" class="title_link" ><i class="icon-home"></i>進捗一覧</a></li>-->
	<?php if( $this->Session->read('Auth.User.admin.root')==1 ){ ?>
		<li><a href="<?php echo $this->webroot?>admin/users" class="title_link" ><i class="icon-user"></i>管理者情報管理</a></li>
	<?php } ?>
	<li><a href="<?php echo $this->webroot?>admin/sales" class="title_link" ><i class="icon-user"></i>売上一覧</a></li>
	<li><a href="<?php echo $this->webroot?>admin/jobhunters" class="title_link" ><i class="icon-user"></i>求職者一覧</a></li>
	<li><a href="<?php echo $this->webroot?>admin/companies" class="title_link" ><i class="icon-calendar"></i>企業一覧</a></li>
	<li><a href="<?php echo $this->webroot?>admin/joboffers" class="title_link" ><i class="icon-lock"></i>求人一覧</a></li>
	<li><a href="<?php echo $this->webroot?>admin/users/logout" class="title_link" ><i class="icon-remove"></i>ログアウト</a></li>
</ul>
</div>