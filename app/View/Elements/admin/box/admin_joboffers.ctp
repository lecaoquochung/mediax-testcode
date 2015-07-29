<div class="box admin_students span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('List Joboffers'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Form->create('Joboffer',array('class'=>'form-search')); ?>
		<div class="input-append">
		<?php echo $this->Form->input('keyword',array('label'=>FALSE,'class'=>'span12 search-query', 'type'=>'text','div'=>FALSE)); ?>
		<?php echo $this->Form->button(__('Search'), array('class'=>'btn')); ?>
		</div>
		<?php echo $this->Form->end(); ?>
		<div class="action_list">
		<div class="btn btn-info">
		<?php echo $this->Html->link(__('Add Joboffer'), array('action' => 'add')); ?>
		</div>
		<div class="btn btn-warning">
		<?php echo $this->Html->link(__('CSV File Upload'), array('action' => 'fileupload')); ?>
		</div>
		</div>
		<?php 
			App::import('Vendor', 'session_flash_message_box');
			echo session_flash_message_box::success($this);
		?>
	<table cellpadding="0" cellspacing="0" class="table tableX">
	<tr>
		<th class="tbl1"><?php echo $this->Paginator->sort('company_name'); ?></th>
		<th class="tbl2"><?php echo $this->Paginator->sort('prefecture'); ?></th>
		<th class="tbl6"><?php echo $this->Paginator->sort('working_content'); ?></th>
		<th class="tbl1"><?php echo $this->Paginator->sort('contact'); ?></th>
		<!--<th><?php echo $this->Paginator->sort('created'); ?></th>-->
		<?php if(!isset($hide_paging)){ ?>
		<th class="tbl2 actions"><?php echo __('Actions'); ?></th>
		<?php } ?>
	</tr>
	<?php
	foreach ($joboffers as $joboffer): ?>
	<tr>
		<td>
			<?php 
				if(isset($joboffer['Company']['name']))	{
					echo  $this->Html->link($joboffer['Company']['name'],array('action' => 'view', $joboffer['Joboffer']['id'])); 
				} else if (isset($joboffer['Joboffer']['company_name'])) {
					echo  $this->Html->link($joboffer['Joboffer']['company_name'],array('action' => 'view', $joboffer['Joboffer']['id'])); 
				}
			?>
		</td>
		<td><?php echo h($joboffer['Joboffer']['prefecture']); ?></td>
		<td><?php echo h($joboffer['Joboffer']['working_content']); ?></td>
		<td><?php echo h($joboffer['Joboffer']['contact']); ?></td>
		<!--<td><?php echo h($joboffer['Joboffer']['created']); ?></td>-->
		<?php if(!isset($hide_paging)){ ?>
		<td class="actions">
						<div class="icon">
							<span class="edit">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $joboffer['Joboffer']['id'])); ?>
							</span>
						</div>
						<div class="icon">
							<span class="del">
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $joboffer['Joboffer']['id']), null, __('Do you want to delete this joboffer?', $joboffer['Joboffer']['id'])); ?>
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
		echo $this->Paginator->prev('< ' . __('Prev'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('Next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
	<?php } ?>
</div>
</div>