<div class="box admin_students_edit span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Edit Joboffer'); ?></h3>
		</div>
	</div>
	<div class="section">
	<?php 
		App::import('Vendor', 'session_flash_message_box');
		echo session_flash_message_box::success($this);
	?>
<?php echo $this->Form->create('Joboffer'); ?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('company_id');
		echo $this->Form->input('status',array('empty'=>'', 'type'=>'select', 'options'=>array('0'=>__('No'),'1'=>__('Yes'))));
		echo $this->Form->input('accept_number');
		echo $this->Form->input('age');
		echo $this->Form->input('education_history');
		echo $this->Form->input('working_place');
		echo $this->Form->input('working_content');
		echo $this->Form->input('experience_need');
		echo $this->Form->input('income');
		echo $this->Form->input('employment_type');
		echo $this->Form->input('working_time');
		echo $this->Form->input('insurance');
		echo $this->Form->input('benefit');
		echo $this->Form->input('dayoff');
		echo $this->Form->input('year_dayoff');
		echo $this->Form->input('postcode');
		echo $this->Form->input('prefecture');
		echo $this->Form->input('city');
		echo $this->Form->input('address_no');
		echo $this->Form->input('building_name');
		echo $this->Form->input('contact');
	?>
	</fieldset>
<!--<?php echo $this->Form->end(__('Submit')); ?>-->
<?php echo $this->Form->button(__('Submit'), array('onClick'=>'return confirmSubmit()')); ?>
</div>
<!--
<div class="page_navigations">
<div class="actions">
	<h3><?php echo __('Menu'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Joboffers'), array('action' => 'index')); ?></li>
	</ul>
</div>
</div>
-->
</div>