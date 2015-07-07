<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
			<h3 class="brand"><?php echo __(Inflector::singularize($this->params['controller']) .' ' .$this->params['action']); ?></h3>
		</div>
	</div>
	<div class="section company form">
		<?php echo $this -> Form -> create('User'); ?>
		<?php echo $this -> Form -> input('id'); ?>
		<?php echo $this->Element('users/form_admin') ?>
		<?php echo $this -> Form -> end(__('Submit')); ?>
	</div>
</div>