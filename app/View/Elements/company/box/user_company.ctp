<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Customer List');?></h3>
		</div>
	</div>
	<div class="section">
		<div class="common-button"><?php echo $this->Html->link(__('Add Company'), array('action' => 'add'), array('class' => "btn btn-warning")); ?></div>
		<table class="table tableX">
			<tr>
					<th><?php echo __('Id'); ?></th>
					<th class="tbl6"><?php echo __('Company'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Email'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
				<td><?php echo $this->Html->link($user['User']['company'], array('action' => 'view', $user['User']['id'])); ?></td>
				<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
				<td class="actions">
					<div class="keyword-add">
						<?php echo $this->Html->link(__('Add Keyword'), array('controller' => 'keywords' , 'action' => 'add', $user['User']['id']), array('class' => "btn btn-success")); ?>
				    </div>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>