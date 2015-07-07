<div class="engines form">
<?php echo $this->Form->create('Engine'); ?>
	<fieldset>
		<legend><?php echo __('Edit Engine'); ?></legend>
	<?php
		echo $this->Form->input('ID');
		echo $this->Form->input('Name');
		echo $this->Form->input('ShowName');
		echo $this->Form->input('Short');
		echo $this->Form->input('Code');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Engine.ID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Engine.ID'))); ?></li>
		<li><?php echo $this->Html->link(__('List Engines'), array('action' => 'index')); ?></li>
	</ul>
</div>
