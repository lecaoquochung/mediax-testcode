<div class="box admin_students_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('CSV File Upload '); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php 
			App::import('Vendor', 'session_flash_message_box');
			echo session_flash_message_box::err($this);
		?>
<?php echo $this->Form->create('Upload',array('type'=>'file')); ?>
	<?php
		echo $this->Form->input('filename',array('type'=>'file'));
	?>
<!--<?php echo $this->Form->end(__('Submit')); ?>-->
<?php echo $this->Form->button(__('Submit'), array('onClick'=>'return confirmSubmit()')); ?>
</div>
<div>
<table cellpadding="0" cellspacing="0" class="table tableX">
	<tr>
		<th class="tbl2"><?php echo __('filename'); ?></th>
		<th class="tbl2"><?php echo __('created'); ?></th>
	</tr>
	<?php if(count($uploads)>0): ?>
	<?php foreach($uploads as $upload): ?>
	<tr>		
		<td><?php echo $upload['File']['filename'] ?></td>
		<td><?php echo $upload['File']['created'] ?></td>
	</tr>
	<?php endforeach ?>
	<?php endif ?>
</table>
</div>
<div class="page_navigations">
<div class="actions">
	<h3><?php echo __('Menu'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Joboffers'), array('action' => 'index')); ?></li>
	</ul>
</div>
</div>
</div>