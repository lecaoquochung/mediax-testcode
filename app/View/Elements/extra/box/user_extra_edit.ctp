<div class="box admin_statuses_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Edit Extra'); ?></h3>
		</div>
	</div>
	<div class="section extras form">
	<?php echo $this->Form->create('Extra'); ?>
		<?php
			echo $this->Form->input('ID');
			echo $this->Form->input('KeyID');
			echo $this->Form->input('ExtraType');
			echo $this->Form->input('Price');
		?>
	<?php echo $this->Form->end(__('Submit')); ?>
	</div>
</div>