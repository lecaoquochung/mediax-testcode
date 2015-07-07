<div class="box admin_companies span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Companies'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Form->create('Company',array('class'=>'form-search')); ?>
		<div class="input-append">
		<?php echo $this->Form->input('keyword',array('label'=>FALSE,'class'=>'span12 search-query', 'type'=>'text','div'=>FALSE)); ?>
		<?php echo $this->Form->button(__('Search'), array('class'=>'btn')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
		<div class="action_list">
		<div class="btn btn-info">
		<?php echo $this->Html->link(__('Add Company'), array('action' => 'add')); ?>
		</div>
		<div class="btn btn-warning">
		<?php echo $this->Html->link(__('CSV File Upload'), array('action' => 'fileupload')); ?>
		</div>
		</div>
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::success($this); ?>
	<table cellpadding="0" cellspacing="0" class="table tableX">
	<tr>
		<th class="tbl5"><?php echo $this->Paginator->sort('name', __('Company Name')); ?></th>
		<th class="tbl3"><?php echo $this->Paginator->sort('contact',__('Contact')); ?></th>
		<th class="tbl3"><?php echo $this->Paginator->sort('prefecture',__('Prefecture')); ?></th>
		<th class="tbl3"><?php echo $this->Paginator->sort('city',__('City')); ?></th>
		<th class="tbl3"><?php echo $this->Paginator->sort('phone',__('Phone')); ?></th>
		<?php if(!isset($hide_paging)){ ?>
		<th class="tbl6 actions"><?php echo __('Actions'); ?></th>
		<?php } ?>
	</tr>
	<?php
	foreach ($companies as $company): ?>
	<tr>
		<td><?php echo $this->Html->link($company['Company']['name'], array('action' => 'view', $company['Company']['id'])); ?></td>
		<td><?php echo h($company['Company']['contact']); ?></td>
		<td><?php echo h($company['Company']['prefecture']); ?></td>
		<td><?php echo h($company['Company']['city']); ?></td>
		<td><?php echo h($company['Company']['phone']); ?></td>
		
		<?php if(!isset($hide_paging)){ ?>
		<td class="actions">
			<?php //echo $this->Html->link(__('View'), array('action' => 'view', $company['Company']['id'])); ?>
						<div class="icon">
							<span class="edit">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $company['Company']['id'])); ?>
							</span>
						</div>
						<div class="icon">
							<span class="del">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $company['Company']['id']), null, __('この企業情報を削除しますか？', $company['Company']['id'])); ?>
							</span>
						</div>
		</td>
		<?php } ?>
	</tr>
<?php endforeach; ?>
	</table>
	<?php if(!isset($hide_paging)){ ?>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
	<?php } ?>
</div>
</div>