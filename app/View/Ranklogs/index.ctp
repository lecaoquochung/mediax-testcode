<div class="ranklogs index">
	<h2><?php echo __('Ranklogs'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<thead>
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('keyword_id'); ?></th>
			<th><?php echo $this->Paginator->sort('engine_id'); ?></th>
			<th><?php echo $this->Paginator->sort('keyword'); ?></th>
			<th><?php echo $this->Paginator->sort('url'); ?></th>
			<th><?php echo $this->Paginator->sort('rank'); ?></th>
			<th><?php echo $this->Paginator->sort('rankdate'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($ranklogs as $ranklog): ?>
	<tr>
		<td><?php echo h($ranklog['Ranklog']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($ranklog['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $ranklog['Keyword']['ID'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($ranklog['Engine']['ID'], array('controller' => 'engines', 'action' => 'view', $ranklog['Engine']['ID'])); ?>
		</td>
		<td><?php echo h($ranklog['Ranklog']['keyword']); ?>&nbsp;</td>
		<td><?php echo h($ranklog['Ranklog']['url']); ?>&nbsp;</td>
		<td><?php echo h($ranklog['Ranklog']['rank']); ?>&nbsp;</td>
		<td><?php echo h($ranklog['Ranklog']['rankdate']); ?>&nbsp;</td>
		<td><?php echo h($ranklog['Ranklog']['created']); ?>&nbsp;</td>
		<td><?php echo h($ranklog['Ranklog']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $ranklog['Ranklog']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $ranklog['Ranklog']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $ranklog['Ranklog']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $ranklog['Ranklog']['id']))); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</tbody>
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
		<li><?php echo $this->Html->link(__('New Ranklog'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Engines'), array('controller' => 'engines', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Engine'), array('controller' => 'engines', 'action' => 'add')); ?> </li>
	</ul>
</div>
