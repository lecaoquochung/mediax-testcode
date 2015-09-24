<aside class="left-side sidebar-offcanvas">
	<section class="sidebar">
		<ul class="sidebar-menu">
			
<!-- dashboard -->
			<li class="<?php echo $this->here==$this->webroot.'sales_keywords/dashboard'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>sales_keywords/dashboard"> <i class="fa fa-dashboard"></i> <span><?php echo __('Dashboard'); ?></span> <small class="badge pull-right bg-red" id=""></small> </a>
			</li>
			
<!-- contract -->
			<li class="treeview 
				<?php echo ($this->here==$this->webroot.'rankhistories' || $this->here==$this->webroot || $this->params['action']== 'service'|| $this->params['action']== 'kotei' || $this->params['action']== 'seika') ? 'active':''; ?>">
				<a href="#">
					<i class="fa fa-jpy"></i><span><?php echo __('Contract'); ?></span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<!-- keyword -->
					<li class="<?php echo ($this->here==$this->webroot.'rankhistories' || $this->here==$this->webroot)?'active':''?>">
						<a href="<?php echo $this->webroot?>rankhistories"> <i class="fa fa-check-square-o"></i> <span><?php echo __('All Keyword'); ?></span> <small class="badge pull-right bg-yellow" id="contract"></small></a>
					</li>
					<!-- kotei -->
					<li class="<?php echo $this->here==$this->webroot.'rankhistories/kotei'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>rankhistories/kotei"> <i class="fa fa-anchor"></i> <span><?php echo __('Kotei List'); ?></span> </a>
					</li>
					<!-- seika -->
					<li class="<?php echo $this->here==$this->webroot.'rankhistories/seika'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>rankhistories/seika"> <i class="fa fa-plus"></i> <span><?php echo __('Seika List'); ?></span> </a>
					</li>
					<!-- service -->
					<li class="<?php echo $this->here==$this->webroot.'rankhistories/service'?'active':''?>">
						<a href="<?php echo $this->webroot?>rankhistories/service"> <i class="fa fa-leaf"></i> <span><?php echo __('Free Service'); ?></span></a>
					</li>
					<!-- sales -->
					<li class="<?php echo ($this->here==$this->webroot.'rankhistories/sales' || $this->here==$this->webroot)?'active':''?>">
						<a href="<?php echo $this->webroot?>rankhistories/sales"> <i class="fa fa-check-square-o"></i> <span><?php echo __('Sales'); ?></span> <small class="badge pull-right bg-yellow" id="contract"></small></a>
					</li>
				</ul>
			</li>
			
<!-- keyword -->
			<li class="<?php echo $this->here==$this->webroot.'keywords'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>keywords"> <i class="fa fa-key"></i> <span><?php echo __('Keywords'); ?></span> <small class="badge pull-right bg-red" id=""></small> </a>
			</li>
			
<!-- mobile -->
			<!-- <li class="<?php echo $this->here==$this->webroot.'rankhistories/rankmobile'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>rankhistories/rankmobile"> <i class="fa fa-mobile"></i> <span><?php echo __('Rank Mobile'); ?></span> <small class="badge pull-right bg-red" id=""></small> </a>
			</li> -->
			
<!-- no contract -->
			<li class="<?php echo $this->here==$this->webroot.'rankhistories/nocontract'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>rankhistories/nocontract"> <i class="fa fa-exclamation-triangle"></i> <span><?php echo __('No Contract'); ?></span> <small class="badge pull-right bg-red" id="nocontract"></small> </a>
			</li>
			
<!-- cancel keyword -->
			<li class="<?php echo $this->here==$this->webroot.'keywords/kaiyakulist'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>keywords/kaiyakulist"> <i class="fa fa-eject"></i> <span><?php echo __('Kaiyaku List'); ?></span> </a>
			</li>
			
<!-- customer -->
			<li class="treeview">
				<a href="#">
					<i class="fa fa-building-o"></i><span><?php echo __('Customer'); ?></span><i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					<li class="<?php echo $this->here==$this->webroot.'users'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>users"> <i class="fa fa-user"></i> <span><?php echo __('Customer List'); ?></span> </a>
					</li>
					<li class="<?php echo $this->here==$this->webroot.'users/agent'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>users/agent"> <i class="fa fa-users"></i> <span><?php echo __('Agent List'); ?></span> </a>
					</li>
				</ul>
			</li>
			
<!-- tools -->
			<li class="treeview">
				<a href="#">
					<i class="fa fa-wrench"></i><span><?php echo __('Tools'); ?></span><i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					<li class="<?php echo $this->here==$this->webroot.'keywords/daily_update_ranks'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>keywords/daily_update_ranks"> <i class="fa fa-fire"></i> <span><?php echo __('Rank Check'); ?></span> </a>
					</li>
				</ul>
			</li>
			
<!-- report -->
			<li class="treeview">
				<a href="#">
					<i class="fa fa-folder"></i><span><?php echo __('Report'); ?></span><i class="fa fa-angle-left pull-right"></i>
				</a>
				
				<ul class="treeview-menu">
					<li class="<?php echo $this->here==$this->webroot.'rankhistories/report'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>rankhistories/report"> <i class="fa fa-folder-open"></i> <span><?php echo __('Rank'); ?></span> </a>
					</li>
				</ul>
			</li>

<!-- notice -->
			<li class="<?php echo $this->here==$this->webroot.'notices'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>notices"> <i class="fa fa-bullhorn"></i> <span><?php echo __('Notice'); ?></span> </a>
			</li>
			
<!-- system -->
			<?php if($this->Session->read('Auth.User.user.role')==1): ?>
			<li class="treeview <?php echo ($this->here==$this->webroot.'logs' || $this->here==$this->webroot.'users/admin' || $this->here==$this->webroot.'servers' ) ? 'active' : '' ?>">
			
				<a href="#">
					<i class="glyphicon glyphicon-cog"></i><span><?php echo __('System'); ?></span><i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li class="<?php echo $this->here==$this->webroot.'users/admin'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>users/admin" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <?php echo __('Admin'); ?></a>
					</li>
					<li class="<?php echo $this->here==$this->webroot.'logs'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>logs" style="margin-left: 10px;"><i class="fa fa-angle-double-right"></i> <?php echo __('Logs'); ?></a>
					</li>
					<li class="<?php echo $this->here==$this->webroot.'servers'?'active':'' ?>">
						<a href="<?php echo $this->webroot?>servers" style="margin-left: 10px;"><i class="fa fa-cloud"></i> <?php echo __('Servers'); ?></a>
					</li>
				</ul>
			</li>
			<?php endif; ?>
			
<!-- logout -->
			<li>nbsps;</li>
			<li class="<?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>">
				<a href="<?php echo $this->webroot?>users/logout"> <i class="fa fa-lock"></i> <span>ログアウト</span> </a>
			</li>
		</ul>
	</section>
</aside>