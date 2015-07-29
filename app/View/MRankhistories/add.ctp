<div class="mRankhistories form">
<?php echo $this->Form->create('MRankhistory'); ?>
	<fieldset>
		<legend><?php echo __('Add M Rankhistory'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List M Rankhistories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Engines'), array('controller' => 'engines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Engine'), array('controller' => 'engines', 'action' => 'add')); ?> </li>
	</ul>
</div>
