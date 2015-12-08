<div class="salesKeywords view">
<h2><?php echo __('Sales Keyword'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo $this->Html->link($salesKeyword['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $salesKeyword['Keyword']['ID'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($salesKeyword['User']['name'], array('controller' => 'users', 'action' => 'view', $salesKeyword['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Keyword'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['keyword']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Rank'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['rank']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Sales'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['sales']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Cost'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['cost']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Profit'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['profit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Limit'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['limit']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Date'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Updated'); ?></dt>
		<dd>
			<?php echo h($salesKeyword['SalesKeyword']['updated']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Sales Keyword'), array('action' => 'edit', $salesKeyword['SalesKeyword']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Sales Keyword'), array('action' => 'delete', $salesKeyword['SalesKeyword']['id']), null, __('Are you sure you want to delete # %s?', $salesKeyword['SalesKeyword']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Sales Keywords'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Sales Keyword'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
