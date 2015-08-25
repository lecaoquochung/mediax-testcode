<div class="row">
	<div class="col-md-6">
		<?php echo $this -> Form -> create('User'); ?>
		<?php echo $this -> Form -> input('id'); ?>
		<?php echo $this->Element('users/form_admin') ?>
		<?php echo $this -> Form -> end(__('Submit')); ?>
	</div>
</div>