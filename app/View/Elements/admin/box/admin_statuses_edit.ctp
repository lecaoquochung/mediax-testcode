<div class="box admin_statuses_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Status'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Form->create('Status'); ?>
			<legend><?php echo __('Admin Edit Status'); ?></legend>
			<?php
				// #1 Session
				echo $this->Form->input('user_id',array('type'=>'hidden','value'=>$this->Session->read('Auth.User.admin.id')));
				echo $this->Form->input('flag',array('type'=>'select','options'=>Configure::read('FLAG')));
				echo $this->Form->input('end_date',array('type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'),'empty'=>true));
				echo $this->Form->input('price');
			?>
		<?php echo $this->Form->button(__('Submit'), array('onClick'=>'return confirmSubmit()')); ?>
	</div>
</div>