<?php $this->assign('title', __('Extra Add'));?>
<?php if(isset($this->params['pass'][1]) && !empty($this->params['pass'][1])): ?>
	<?php echo $this->element('extra/box/user_extra_add'.'_'.$this->params['pass'][1]) ?>
<?php else: ?>
		<div id="admin_users">
			<?php echo $this->element('navigation'); ?>
			<div class="main span10">
				<?php echo $this->element('extra/box/user_extra_add') ?>
			</div>
		</div>
<?php endif;?>