<div class="box admin_users_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('New User'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::err($this);?>
<?php echo $this->Form->create('User'); ?>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('password');
		echo $this->Form->input('email');
		echo $this->Form->input('mark_user',array('type'=>'select','options'=>array('1'=>'Admin','2'=>'User')));
	?>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="page_navigations">
<!--
<div class="actions">
	<h3><?php echo __('Menu'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
-->
</div>
</div>