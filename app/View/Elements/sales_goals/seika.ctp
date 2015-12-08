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
				<?php 
					echo $this->Form->postLink(
						$this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('削除'))). "",
						array('action' => 'delete', $salesGoal['SalesGoal']['id']),
						array('escape'=>false, 'class' => 'label label-danger'),
						__('この目標 「# %s」を削除しますか？', $salesGoal['SalesGoal']['id']),
						array('class' => '')
					);
				?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>