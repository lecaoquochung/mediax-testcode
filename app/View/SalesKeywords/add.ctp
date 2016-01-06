<div class="salesKeywords form">
<?php echo $this->Form->create('SalesKeyword'); ?>
	<fieldset>
		<legend><?php echo __('Add Sales Keyword'); ?></legend>
	<?php
		echo $this->Form->input('keyword_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('keyword');
		echo $this->Form->input('rank');
		echo $this->Form->input('sales');
		echo $this->Form->input('cost');
		echo $this->Form->input('profit');
		echo $this->Form->input('limit');
		echo $this->Form->input('date');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Sales Keywords'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
