<div class="salesGoals form">
<?php echo $this->Form->create('SalesGoal'); ?>
	<fieldset>
		<legend><?php echo __('Edit Sales Goal'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('type');
		echo $this->Form->input('goal');
		echo $this->Form->input('target');
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('SalesGoal.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('SalesGoal.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Sales Goals'), array('action' => 'index')); ?></li>
	</ul>
</div>
