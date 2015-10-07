<div class="salesGoals view">
<h2><?php echo __('Sales Goal'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Goal'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['goal']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Target'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['target']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($salesGoal['SalesGoal']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sales Goal'), array('action' => 'edit', $salesGoal['SalesGoal']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sales Goal'), array('action' => 'delete', $salesGoal['SalesGoal']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $salesGoal['SalesGoal']['id']))); ?> </li>
		<li><?php echo $this->Html->link(__('List Sales Goals'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sales Goal'), array('action' => 'add')); ?> </li>
	</ul>
</div>
