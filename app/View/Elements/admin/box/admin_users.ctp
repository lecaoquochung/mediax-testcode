<div class="box admin_users span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Users'); ?></h3>
		</div>
	</div>
	<div class="section">
		<div class="action_list">
			<div class="btn btn-info">
				<?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?>
			</div>
		</div>
		<?php 
			App::import('Vendor', 'session_flash_message_box');
			echo session_flash_message_box::success($this);
		?>
	<table cellpadding="0" cellspacing="0" class="table tableX">
	<tr>
			<!--<th class="tbl2"><?php echo $this->Paginator->sort('id'); ?></th>-->
			<th class="tbl4"><?php echo $this->Paginator->sort('name'); ?></th>
			<th class="tbl6"><?php echo $this->Paginator->sort('email'); ?></th>
			<th class="tbl2"><?php echo $this->Paginator->sort('User'); ?></th>
			<th class="tbl2"><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="tbl2"><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="tbl4 actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($users as $user): ?>
	<tr>
		<!--<td><?php echo h($user['User']['id']); ?>&nbsp;</td>-->
		<td><?php echo h($user['User']['name']);?>&nbsp;</td>
		<td><?php echo h($user['User']['email']); ?>&nbsp;</td>
		<td>
		<?php 
			if($user['User']['mark_user']==1){
				echo __('Admin');
			}else if($user['User']['mark_user']==2){
				echo __('User');
			}
		?>
		&nbsp;</td>
		<td><?php echo date('Y-m-d',strtotime(h($user['User']['created']))); ?>&nbsp;</td>
		<td><?php echo date('Y-m-d',strtotime(h($user['User']['modified']))); ?>&nbsp;</td>
		<td class="actions">
			<?php //echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
		<div class="icon">
			<span class="edit">
			<?php echo $this->Html->link(__('Edit'), array('admin'=>true,'controller'=>'users','action' => 'edit', $user['User']['id'])); ?>
			</span>
		</div>
						<div class="icon">
						<span class="del">
			<?php echo $user['User']['mark_user']==1?'':$this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), null, __('Do you want to delete this user?', $user['User']['id'])); ?>
						</span>
						</div>
		</td>
	</tr>
	<?php endforeach; ?>
	</table>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>

</div>