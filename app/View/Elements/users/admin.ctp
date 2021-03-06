<div class="row">
	<div class="col-md-12">
		<?php echo $this->Session->flash(); ?>
		<div class="box-header">
			<?php echo $this -> Html -> link(__('Add Admin'), array('action' => 'add_admin'), array('class' => "btn btn-warning")); ?>
		</div>
		<table class="table">
			<tr>
					<th><?php echo __('#'); ?></th>
					<th><?php echo __('Name'); ?></th>
					<th><?php echo __('Email'); ?></th>
					<th><?php echo __('Role'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['name']); ?>&nbsp;</td>
				<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
				<td><?php $user_role  = Configure::read('User.role'); echo $user_role[$user['User']['role']]; ?>&nbsp;</td>
				<td class="actions">
					<div class="keyword-add">
						<?php echo $user['User']['role']!=1? $this -> Html -> link(__('Edit'), array('controller' => 'users', 'action' => 'edit_admin', $user['User']['id']), array('class' => "btn btn-success")):''; ?>
						<?php echo $user['User']['role']!=1? $this->Form->postLink('Delete', array( 'action' => 'delete', $user['User']['id']), array('class' => 'btn btn-danger'), __('【%s】を削除しますか？', $user['User']['email'])):''; ?>
					</div>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>