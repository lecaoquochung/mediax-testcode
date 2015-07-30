<div class="rankkeywords index">
	<h2><?php echo __('Rankkeywords'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('ID'); ?></th>
			<th><?php echo $this->Paginator->sort('Keyword'); ?></th>
			<th><?php echo $this->Paginator->sort('google_jp'); ?></th>
			<th><?php echo $this->Paginator->sort('yahoo_jp'); ?></th>
			<th><?php echo $this->Paginator->sort('google_en'); ?></th>
			<th><?php echo $this->Paginator->sort('yahoo_en'); ?></th>
			<th><?php echo $this->Paginator->sort('bing'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($rankkeywords as $rankkeyword): ?>
	<tr>
		<td><?php echo h($rankkeyword['Rankkeyword']['ID']); ?>&nbsp;</td>
		<td><?php echo h($rankkeyword['Rankkeyword']['Keyword']); ?>&nbsp;</td>
		<td><?php echo h($rankkeyword['Rankkeyword']['google_jp']); ?>&nbsp;</td>
		<td><?php echo h($rankkeyword['Rankkeyword']['yahoo_jp']); ?>&nbsp;</td>
		<td><?php echo h($rankkeyword['Rankkeyword']['google_en']); ?>&nbsp;</td>
		<td><?php echo h($rankkeyword['Rankkeyword']['yahoo_en']); ?>&nbsp;</td>
		<td><?php echo h($rankkeyword['Rankkeyword']['bing']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $rankkeyword['Rankkeyword']['ID'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $rankkeyword['Rankkeyword']['ID'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $rankkeyword['Rankkeyword']['ID']), null, __('Are you sure you want to delete # %s?', $rankkeyword['Rankkeyword']['ID'])); ?>
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
		<li><?php echo $this->Html->link(__('New Rankkeyword'), array('action' => 'add')); ?></li>
	</ul>
</div>
