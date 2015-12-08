<?php echo $this->Html->link(__('Add'),array('controller'=>'servers','action'=>'add'),array('class'=>'btn btn-warning'));?>

<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
	<?php echo $this -> Session -> flash(); ?>
	<thead>
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('code'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('ip'); ?></th>
			<th><?php echo $this->Paginator->sort('api'); ?></th>
			<th><?php echo $this->Paginator->sort('memo'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
		</tr>
	</thead>
	<tbody>
	<?php $count = 0; ?>
	<?php foreach ($servers as $server): ?>
		<tr>
			<td><?php echo h($server['Server']['id']); ?>&nbsp;</td>
			<td><?php echo h($server['Server']['code']); ?>&nbsp;</td>
			<td><?php echo h($server['Server']['name']); ?>&nbsp;</td>
			<td><?php echo h($server['Server']['ip']); ?>&nbsp;</td>
			<td><?php echo h($server['Server']['api']); ?>&nbsp;</td>
			<td><?php echo h($server['Server']['memo']); ?>&nbsp;</td>
			
			<td class="actions">
				<a href="<?php echo Router::url(array('controller' => 'servers', 'action' => 'edit', $server['Server']['id'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Server') ?>"><i class="fa fa-edit"></i></a>
				<?php 
					echo $this->Form->postLink(
						$this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('Delete'))). "",
						array('controller' => 'servers', 'action' => 'delete', $server['Server']['id']),
						array('escape'=>false, 'class' => 'label label-danger'),
						__('【%s】を削除しますか？', $server['Server']['id']),
						array('class' => '')
					);
				?>
			</td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
