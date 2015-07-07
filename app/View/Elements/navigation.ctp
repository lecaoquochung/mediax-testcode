<div class="sidebar span2">
	<div class="bs-docs-sidebar">
		<ul class="nav nav-list bs-docs-sidenav affix-top">
			<li style="font-family: 'Cinzel Decorative', cursive;">
				<span style="font-size: 18px;padding-left: 15px;display: inline-block; width: 123px;"><?php echo __('System Name') ?>X</span>
			</li>
			<li><a href="<?php echo $this->webroot?>rankhistories" class="title_link <?php echo $this->here==$this->webroot.'rankhistories'?'active':'' ?>" ><?php echo __('Keyword List'); ?>&nbsp;<span class="badge badge-important" id="contract"></span></a></li>
			<li><a href="<?php echo $this->webroot?>rankhistories/service" class="title_link <?php echo $this->here==$this->webroot.'rankhistories/service'?'active':'' ?>" ><?php echo __('Free Service'); ?>&nbsp;</a></li>
			<li><a href="<?php echo $this->webroot?>rankhistories/seika" class="title_link <?php echo $this->here==$this->webroot.'rankhistories/seika'?'active':'' ?>" ><?php echo __('Seika List'); ?></a></li>
			<li><a href="<?php echo $this->webroot?>rankhistories/kotei" class="title_link <?php echo $this->here==$this->webroot.'rankhistories/kotei'?'active':'' ?>" ><?php echo __('Kotei List'); ?></a></li>
			<li><a href="<?php echo $this->webroot?>rankhistories/rankcheck" class="title_link <?php echo $this->here==$this->webroot.'rankhistories/rankcheck'?'active':'' ?>" ><?php echo __('RankCheck List'); ?></a></li>
			<li><a href="<?php echo $this->webroot?>users" class="title_link <?php echo $this->here==$this->webroot.'users'?'active':'' ?>" ><?php echo __('Customer List'); ?></a></li>s
			<li><a href="<?php echo $this->webroot?>users/agent" class="title_link <?php echo $this->here==$this->webroot.'users/agent'?'active':'' ?>" ><?php echo __('Agent List'); ?></a></li>
			<li><a href="<?php echo $this->webroot?>rankhistories/nocontract" class="brand <?php echo $this->here==$this->webroot.'rankhistories/nocontract'?'active':'' ?>" ><?php echo __('Nocontract List'); ?>&nbsp;<span class="badge badge-important" id="nocontract"></span></a></li>
			<li><a href="<?php echo $this->webroot?>keywords/kaiyakulist" class="brand <?php echo $this->here==$this->webroot.'keywords/kaiyakulist'?'active':'' ?>" ><?php echo __('Kaiyaku List'); ?></a></li>
			<li><a href="<?php echo $this->webroot?>keywords/daily_update_ranks" class="title_link <?php echo $this->here==$this->webroot.'keywords/daily_update_ranks'?'active':'' ?>" ><?php echo __('Rank Check'); ?></a></li>
			<li><a href="<?php echo $this->webroot?>notices" class="title_link <?php echo $this->here==$this->webroot.'notices'?'active':'' ?>" ><?php echo __('Notice'); ?></a></li>
			<?php if($this->Session->read('Auth.User.user.role')==1): ?>
			<li><a href="<?php echo $this->webroot?>users/admin" class="title_link <?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>" ><?php echo __('Users') ?></a></li>
			<li><a href="<?php echo $this->webroot?>logs" class="title_link <?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>" ><?php echo __('Logs') ?></a></li>
			<?php endif; ?>
			<li><a href="<?php echo $this->webroot?>users/logout" class="title_link <?php echo $this->here==$this->webroot.'users/logout'?'active':'' ?>" >ログアウト</a></li>
		</ul>
	</div>
</div>