<div class="extras index">
	<h2><?php echo __('Extras'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('KeyID'); ?></th>
			<th><?php echo $this->Paginator->sort('ExtraType'); ?></th>
			<th><?php echo $this->Paginator->sort('Price'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($extras as $extra): ?>
	<tr>
		<td><?php echo h($extra['Extra']['ID']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($extra['Keyword']['ID'], array('controller' => 'keywords', 'action' => 'view', $extra['Keyword']['ID'])); ?>
		</td>
		<td><?php echo h($extra['Extra']['ExtraType']); ?>&nbsp;</td>
		<td><?php echo h($extra['Extra']['Price']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $extra['Extra']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $extra['Extra']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $extra['Extra']['ID']), null, __('Are you sure you want to delete # %s?', $extra['Extra']['ID'])); ?>
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
		<li><?php echo $this->Html->link(__('New Extra'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Keywords'), array('controller' => 'keywords', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Keyword'), array('controller' => 'keywords', 'action' => 'add')); ?> </li>
	</ul>
</div>
