<div class="box admin_students_add span12">
	<div class="navbar"><div class="navbar-inner"><h3 class="brand"><?php  echo __('Add Jobhunter'); ?></h3></div></div>
	<div class="section">
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::err($this); ?>
		<?php echo $this->Form->create('Jobhunter'); ?>
		<?php
			echo $this->Form->input('Support.label',array('div'=>FALSE,'label'=>__('Support History'),'class'=>'input-small','type'=>'select','options'=>Configure::read('SUPPORT_LABEL')));
			echo $this->Form->input('Support.date',array('div'=>FALSE,'label'=>FALSE,'type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames')));
			echo $this->Form->input('Support.note',array('div'=>FALSE,'label'=>FALSE));
		?>
		<?php
			echo $this->Form->input('name');
			echo $this->Form->input('furigana');
			echo $this->Form->input('email');
			echo $this->Form->input('mobile_email');
			echo $this->Form->input('birthday', array('dateFormat'=>'YMD', 'empty'=>true,'monthNames'=>Configure::read('monthNames'), 'minYear'=>1900, 'maxYear'=>date('Y',strtotime('now'))));
			echo $this->Form->input('age');
			echo $this->Form->input('gender');
			echo $this->Form->input('address');
			echo $this->Form->input('phone');
			echo $this->Form->input('last_education');
			echo $this->Form->input('marriage',array('empty'=>'', 'type'=>'select', 'options'=>array('0'=>__('No'),'1'=>__('Yes'))));
			echo $this->Form->input('job_change');
			echo $this->Form->input('experience',array('empty'=>'', 'type'=>'select', 'options'=>array('0'=>__('No'),'1'=>__('Yes'))));
			echo $this->Form->input('certificate');
			echo $this->Form->input('certificate_comment');
			echo $this->Form->input('income');
			echo $this->Form->input('introduce');
			echo $this->Form->input('company_name');
			echo $this->Form->input('industry');
			echo $this->Form->input('working_period');
			echo $this->Form->input('employment_type');
			echo $this->Form->input('position');
			echo $this->Form->input('woking_content');
			echo $this->Form->input('top1_employment_type');
			echo $this->Form->input('top1_job');
			echo $this->Form->input('top1_workingplace');
			echo $this->Form->input('top1_income');
			echo $this->Form->input('top1_characteristic');
			echo $this->Form->input('personal_type');
			echo $this->Form->input('register',array('empty'=>'', 'type'=>'select', 'options'=>array('0'=>__('No'),'1'=>__('Yes'))));
			echo $this->Form->input('contact');
			echo $this->Form->input('postcode');
			echo $this->Form->input('prefecture');
			echo $this->Form->input('city');
			echo $this->Form->input('address_no');
			echo $this->Form->input('building_name');
			echo $this->Form->input('station');
			echo $this->Form->input('time_to_station');
			echo $this->Form->input('memo');
		?>
		<?php echo $this->Form->button(__('Submit'), array('onClick'=>'return confirmSubmit()')); ?>
	</div>
	<div class="page_navigations">
		<div class="actions">
			<h3><?php echo __('Menu'); ?></h3>
			<ul><li><?php echo $this->Html->link(__('List Jobhunters'), array('action' => 'index')); ?></li></ul>
		</div>
	</div>
</div>