<div class="ranklogs form">
<?php echo $this->Form->create('Ranklog'); ?>
	<fieldset>
		<legend><?php echo __('Edit Ranklog'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('keyword_id');
		echo $this->Form->input('engine_id');
		echo $this->Form->input('keyword');
		echo $this->Form->input('url');
		echo $this->Form->input('rank');
		echo $this->Form->input('rankdate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Ranklog.id')), array('confirm' => __('Are you sure you want to delete # %s?', $this->Form->value('Ranklog.id')))); ?></li>
		<li><?php echo $this->Html->link(__('List Ranklogs'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Engines'), array('controller' => 'engines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Engine'), array('controller' => 'engines', 'action' => 'add')); ?> </li>
	</ul>
</div>
