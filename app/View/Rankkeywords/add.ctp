<div class="rankkeywords form">
<?php echo $this->Form->create('Rankkeyword'); ?>
	<fieldset>
		<legend><?php echo __('Add Rankkeyword'); ?></legend>
	<?php
		echo $this->Form->input('Keyword');
		echo $this->Form->input('google_jp');
		echo $this->Form->input('yahoo_jp');
		echo $this->Form->input('google_en');
		echo $this->Form->input('yahoo_en');
		echo $this->Form->input('bing');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Rankkeywords'), array('action' => 'index')); ?></li>
	</ul>
</div>
