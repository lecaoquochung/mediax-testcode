<?php $support_label = Configure::read('SUPPORT_LABEL');?>
<div class="box admin_students span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('List Supports'); ?></h3>
		</div>
	</div>
	<div class="section">
	<table cellpadding="0" cellspacing="0" class="table tableX">
	<tr>
		<th><?php echo __('User created'); ?></th>
		<th><?php echo __('Jobhunter'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Date'); ?></th>
		<th><?php echo __('Support Note'); ?></th>
		<th class="tbl6 actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($supports as $support): ?>
		<?php if(!empty($support['Support']['action'])) { ?>
		<tr <?php echo empty($support['Support']['view'])?'style="font-weight:bold"':'' ?>>
			<!--<td><?php echo $this->Html->link($support['User']['name'], array('controller'=>'user', 'action' => 'view', $support['User']['id'])); ?></td>-->
			<td><?php echo $support['User']['name']; ?></td>
			<td><?php echo $this->Html->link($support['Jobhunter']['name'], array('controller'=>'jobhunters', 'action' => 'view', $support['Jobhunter']['id'])); ?></td>
			<td><?php echo h($support_label[$support['Support']['label']]); ?></td>
			<td><?php echo h($support['Support']['date']); ?></td>
			<td><?php echo h($support['Support']['note']); ?></td>
			<td class="actions">
				<div class="btn btn-danger">
				<?php echo empty($support['Support']['view'])?$this->Html->link(__('Check'), array('controller'=>'supports','action' => 'check',$support['Support']['id'])):''; ?>
				</div>
			</td>
		</tr>
		<?php } ?>
	<?php endforeach; ?>
	</table>
</div>
</div>