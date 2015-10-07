<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo $this->assign('title', __($this->params['controller'] .' ' .$this->params['action'])) ?></h3>
			</div>
			<?php echo $this -> Form -> create('SalesGoal', array('class' => 'KeywordAddForm')); ?>
			<?php echo $this -> Form -> input('id'); ?>
			<div class="box-body">
<!-- type -->
				<div class="form-group">
					<label for="InputCode"><?php echo $this -> Html -> tag('span', __('Type')); ?></label>
					<?php echo $this -> Form -> input('type', array('label' => false, 'type' => 'select', 'options' => Configure::read('sales_goals.seika'), 'class' => 'form-control')); ?>
				</div>
<!-- goal -->
				<div class="form-group">
					<label for="InputName"><?php echo $this -> Html -> tag('span', __('Goal')); ?></label>
					<?php echo $this -> Form -> input('goal', array('type' => 'text', 'label' => FALSE, 'placeholder' => __('Enter Goal'), 'class' => 'form-control')); ?>
				</div>
<!-- target -->
				<div class="form-group">
					<label for="InputIp"><?php echo $this -> Html -> tag('span', __('Target')); ?></label>
					<?php echo $this -> Form -> input('target', array('type' => 'text', 'label' => FALSE, 'placeholder' => __('Enter Target'), 'class' => 'form-control')); ?>
					<?php 
						// echo $this->Form->input('target', array(
							// 'div' => TRUE,
							// 'label' => FALSE,
							// 'class'=>'input-sm',
							// 'type'=>'date',
							// 'dateFormat'=>'YM',
							// 'minYear'=> date('Y'),
							// 'maxYear'=> date('Y')+1,
							// 'monthNames'=>Configure::read('monthNames'),
						// ));
					?>
				</div>
<!-- form -->
				<?php echo $this->Form->button(__('Add Seika Goal'), array('class'=>'btn btn-warning', 'div'=>FALSE)); ?>
				<?php echo $this -> Form -> end(); ?>
			</div>
		</div>
	</div>
</div>