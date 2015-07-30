<div class="box admin_users_edit span12">
	<div class="navbar">
		<div class="navbar-inner">
			<h3 class="brand"><?php  echo __('Users'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php 
			App::import('Vendor', 'session_flash_message_box');
			echo session_flash_message_box::err($this);
		?>
		<?php echo $this->Form->create('User'); ?>
			<?php
			echo $this->Form->input('name');
			echo $this->Form->input('password',array('value'=>''));
			echo $this->Form->input('email');
		?>
		<?php echo $this->Form->end(__('Submit')); ?>
	</div>
	<div class="page_navigations">
		<div class="actions">
			<h3><?php echo __('Menu'); ?></h3>
			<ul>
				<!--<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Do you want to delete this user？', $this->Form->value('User.id'))); ?></li>-->
				<li><?php echo $this->Html->link(__('User List'), array('action' => 'index')); ?></li>
			</ul>
		</div>
	</div>
</div>