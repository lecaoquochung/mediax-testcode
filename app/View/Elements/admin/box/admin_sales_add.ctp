<?php $this->assign('title', __('Admin Add Sale'));?>
<div class="box admin_sales span12">
<?php echo $this->Form->create('Sale'); ?>
	<div class="navbar">
		<div class="navbar-inner"><h3 class="brand"><?php  echo __('Admin Add Sale'); ?></h3></div>
	</div>
	<div class="section">
		<?php
			$current_year = date('Y');
			$min_year = $current_year;
			$max_year = $current_year+2;
			
			echo $this->Form->input('user_id');
			echo $this->Form->input('target_month', array('type'=>'date', 'dateFormat'=>'YM', 'minYear'=>$min_year, 'maxYear'=>$max_year, 'monthNames'=>Configure::read('monthNames')));
			echo $this->Form->input('target_sale');
		?>
		<?php echo $this->Form->end(__('Submit')); ?>
	</div>
</div>