<div class="engines index">
	<h2><?php echo __('Engines'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('Name'); ?></th>
			<th><?php echo $this->Paginator->sort('ShowName'); ?></th>
			<th><?php echo $this->Paginator->sort('Short'); ?></th>
			<th><?php echo $this->Paginator->sort('Code'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($engines as $engine): ?>
	<tr>
		<td><?php echo h($engine['Engine']['ID']); ?>&nbsp;</td>
		<td><?php echo h($engine['Engine']['Name']); ?>&nbsp;</td>
		<td><?php echo h($engine['Engine']['ShowName']); ?>&nbsp;</td>
		<td><?php echo h($engine['Engine']['Short']); ?>&nbsp;</td>
		<td><?php echo h($engine['Engine']['Code']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $engine['Engine']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $engine['Engine']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $engine['Engine']['ID']), null, __('Are you sure you want to delete # %s?', $engine['Engine']['ID'])); ?>
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
		<li><?php echo $this->Html->link(__('New Engine'), array('action' => 'add')); ?></li>
	</ul>
</div>
