<div class="salesKeywords index">
	<h2><?php echo __('Sales Keywords'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('keyword_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('keyword'); ?></th>
			<th><?php echo $this->Paginator->sort('rank'); ?></th>
			<th><?php echo $this->Paginator->sort('sales'); ?></th>
			<th><?php echo $this->Paginator->sort('cost'); ?></th>
			<th><?php echo $this->Paginator->sort('profit'); ?></th>
			<th><?php echo $this->Paginator->sort('limit'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('updated'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($salesKeywords as $salesKeyword): ?>
	<tr>
		<td><?php echo h($salesKeyword['SalesKeyword']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($salesKeyword['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $salesKeyword['Keyword']['ID'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($salesKeyword['User']['name'], array('controller' => 'users', 'action' => 'view', $salesKeyword['User']['id'])); ?>
		</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['keyword']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['rank']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['sales']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['cost']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['profit']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['limit']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['date']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['created']); ?>&nbsp;</td>
		<td><?php echo h($salesKeyword['SalesKeyword']['updated']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $salesKeyword['SalesKeyword']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salesKeyword['SalesKeyword']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $salesKeyword['SalesKeyword']['id']), null, __('Are you sure you want to delete # %s?', $salesKeyword['SalesKeyword']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Sales Keyword'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
