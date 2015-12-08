<?php echo $this->Html->link(__('Add'),array('action'=>'add'),array('class'=>'btn btn-warning'));?>

<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<?php echo $this -> Session -> flash(); ?>
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('type'); ?></th>
			<th><?php echo $this->Paginator->sort('goal'); ?></th>
			<th><?php echo $this->Paginator->sort('target'); ?></th>
			<th><?php echo $this->Paginator->sort('date'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $count = 0; ?>
		<?php foreach ($salesGoals as $salesGoal): ?>
		<tr>
			<td><?php echo h($salesGoal['SalesGoal']['id']); ?>&nbsp;</td>
			<td><?php echo h($salesGoal['SalesGoal']['type']); ?>&nbsp;</td>
			<td><?php echo h($salesGoal['SalesGoal']['goal']); ?>&nbsp;</td>
			<td><?php echo h($salesGoal['SalesGoal']['target']); ?>&nbsp;</td>
			<td><?php echo h($salesGoal['SalesGoal']['date']); ?>&nbsp;</td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('action' => 'view', $salesGoal['SalesGoal']['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $salesGoal['SalesGoal']['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $salesGoal['SalesGoal']['id']), array('confirm' => __('Are you sure you want to delete # %s?', $salesGoal['SalesGoal']['id']))); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>