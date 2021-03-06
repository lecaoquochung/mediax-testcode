<div class="box admin_companies_edit span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php echo __('Edit Company'); ?></h3>
		</div>
	</div>
	<div class="section">
<?php echo $this->Form->create('Company'); ?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('contact');
		echo $this->Form->input('name');
		echo $this->Form->input('furigana');
		echo $this->Form->input('working_time');
		echo $this->Form->input('welfare_facilities',array('empty'=>'', 'type'=>'select', 'options'=>array('0'=>__('No'),'1'=>__('Yes'))));
		echo $this->Form->input('benefit',array('empty'=>'', 'type'=>'select', 'options'=>array('0'=>__('No'),'1'=>__('Yes'))));
		echo $this->Form->input('dayoff');
		echo $this->Form->input('postcode');
		echo $this->Form->input('prefecture');
		echo $this->Form->input('city');
		echo $this->Form->input('address_no');
		echo $this->Form->input('building_name');
		echo $this->Form->input('billing_destination');
		echo $this->Form->input('phone');
	?>
<!--<?php echo $this->Form->end(__('Submit')); ?>-->
<?php echo $this->Form->button(__('Submit'), array('onClick'=>'return confirmSubmit()')); ?>
</div>
<div class="page_navigations">
<div class="actions">
	<h3><?php echo __('Menu'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Companies'), array('action' => 'index')); ?></li>
	</ul>
</div>
</div>
</div>
