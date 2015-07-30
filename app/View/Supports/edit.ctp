<div class="container">
<div class="row">
<div class="supports form">
<?php echo $this->Form->create('Support'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Support'); ?></legend>
	<?php
		echo $this->Form->input('id',array('type'=>'hidden'));
		echo $this->Form->input('jobhunter_id',array('type'=>'hidden'));
		echo $this->Form->input('label',array('div'=>FALSE,'label'=>FALSE,'class'=>'input-small','type'=>'select','options'=>Configure::read('SUPPORT_LABEL')));
		$current_year = date('Y');
		echo $this->Form->input('date',array('type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'), 'maxYear'=>$current_year+1, 'minYear'=>$current_year));
		echo $this->Form->input('note');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
</div>
</div>
<script type="text/javascript">
	<?php if(isset($success)){ ?>
		window.opener.location.reload(); // this does not work
		self.close();							
	<?php } ?>
</script>