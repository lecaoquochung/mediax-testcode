<div class="box admin_students span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('List Jobhunters'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php if(!isset($top_limit)) { ?>
			<!-- <?php echo $this->Form->create('Jobhunter',array('class'=>'form-search')); ?> -->
			<?php echo $this->Form->create('Jobhunter',array('url'=>array('controller'=>'jobhunters','action'=>'index'),'class'=>'form-search')); ?>
			<div class="input-append">
				<?php echo $this->Form->input('keyword',array('label'=>FALSE,'class'=>'span12 search-query', 'type'=>'text','div'=>FALSE)); ?>
				<?php echo $this->Form->button(__('Search'), array('class'=>'btn')); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		<?php } ?>
		<div class="action_list">
			<div class="btn btn-info">
				<?php echo $this->Html->link(__('Add Jobhunter'), array('action' => 'add')); ?>
			</div>
			<div class="btn btn-warning">
				<?php echo $this->Html->link(__('CSV File Upload'), array('controller'=>'jobhunters','action' => 'fileupload')); ?>
			</div>
		</div>
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::success($this);?>
		<table cellpadding="0" cellspacing="0" class="table tableX">
			<tr>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<!--<th><?php //echo $this->Paginator->sort('birthday'); ?></th>-->
				<th><?php echo $this->Paginator->sort('age'); ?></th>
				<th><?php echo $this->Paginator->sort('gender'); ?></th>
				<th><?php echo $this->Paginator->sort('phone'); ?></th>
				<?php if(!isset($top_limit)) { ?>
					<th class="tbl6 actions"><?php echo __('Actions'); ?></th>
				<?php } ?>
			</tr>
			<?php foreach ($jobhunters as $jobhunter): ?>
			<tr>
				<td><?php echo $this->Html->link($jobhunter['Jobhunter']['name'], array('controller'=>'jobhunters','action' => 'view', $jobhunter['Jobhunter']['id'])); ?></td>
				<!--<td><?php //echo h($jobhunter['Jobhunter']['birthday']); ?></td>-->
				<td><?php echo h($jobhunter['Jobhunter']['age']); ?></td>
				<td><?php echo h($jobhunter['Jobhunter']['gender']); ?></td>
				<td><?php echo h($jobhunter['Jobhunter']['phone']); ?></td>
				<?php if(!isset($top_limit)) { ?>
					<td class="actions">
						<div class="icon">
							<span class="edit">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $jobhunter['Jobhunter']['id'])); ?>
							</span>
						</div>
						<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $jobhunter['Jobhunter']['id']), null, __('Do you want to delete this jobhunter?', $jobhunter['Jobhunter']['id'])); ?>
						<div class="icon">
							<span class="add">
						<?php echo $this->Html->link(__('Add Status'), array('controller'=>'statuses', 'action' => 'add', $jobhunter['Jobhunter']['id'])); ?>
							</span>
						</div>
					</td>
				<?php } ?>
			</tr>
			<?php endforeach; ?>
		</table>
		<?php if(!isset($top_limit)) { ?>
		<div class="paging">
			<?php
				echo $this->Paginator->prev('< ' . __('Prev'), array(), null, array('class' => 'prev disabled'));
				echo $this->Paginator->numbers(array('separator' => ''));
				echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
			?>
		</div>
		<?php } ?>
	</div>
</div>