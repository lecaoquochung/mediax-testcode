<div class="rankhistories form">
<?php echo $this->Form->create('Rankhistory'); ?>
	<fieldset>
		<legend><?php echo __('Edit Rankhistory'); ?></legend>
	<?php
		echo $this->Form->input('ID');
		echo $this->Form->input('KeyID');
		echo $this->Form->input('Url');
		echo $this->Form->input('Rank');
		echo $this->Form->input('RankDate');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Rankhistory.ID')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Rankhistory.ID'))); ?></li>
		<li><?php echo $this->Html->link(__('List Rankhistories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
