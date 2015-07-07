<div class="supports form">
<?php echo $this->Form->create('Support'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Support'); ?></legend>
	<?php
		echo $this->Form->input('jobhunter_id');
		echo $this->Form->input('label');
		echo $this->Form->input('date');
		echo $this->Form->input('note');
		echo $this->Form->input('action');
		echo $this->Form->input('view');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Supports'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Jobhunters'), array('controller' => 'jobhunters', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Jobhunter'), array('controller' => 'jobhunters', 'action' => 'add')); ?> </li>
	</ul>
</div>
