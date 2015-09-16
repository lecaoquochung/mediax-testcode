<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php echo $this->assign('title', __($this->params['controller'] .' ' .$this->params['action'])) ?></h3>
			</div>
			<?php echo $this -> Form -> create('Server', array('class' => 'KeywordAddForm')); ?>
			<?php echo $this -> Form -> input('id'); ?>
			<div class="box-body">
<!-- name -->
				<div class="form-group">
					<label for="InputName"><?php echo $this -> Html -> tag('span', __('Name')); ?></label>
					<?php echo $this -> Form -> input('name', array('type' => 'text', 'label' => FALSE, 'placeholder' => __('Enter Name'), 'class' => 'form-control')); ?>
				</div>
<!-- ip -->
				<div class="form-group">
					<label for="InputIp"><?php echo $this -> Html -> tag('span', __('IP')); ?></label>
					<?php echo $this -> Form -> input('ip', array('type' => 'text', 'label' => FALSE, 'placeholder' => __('Enter IP'), 'class' => 'form-control')); ?>
				</div>
<!-- api -->
				<div class="form-group">
					<label for="InputApi"><?php echo $this -> Html -> tag('span', __('API')); ?></label>
					<?php echo $this -> Form -> input('api', array('type' => 'text', 'label' => FALSE, 'placeholder' => __('Enter Api'), 'class' => 'form-control')); ?>
				</div>
<!-- memo -->
				<div class="form-group">
					<label for="InputMemo"><?php echo $this -> Html -> tag('span', __('Memo')); ?></label>
					<?php echo $this -> Form -> input('memo', array('type' => 'textarea', 'label' => FALSE, 'placeholder' => __('Enter Memo'), 'class' => 'form-control')); ?>
				</div>
<!-- form -->
				<?php echo $this->Form->button(__('Add Server'), array('class'=>'btn btn-warning', 'div'=>FALSE)); ?>
				<?php echo $this -> Form -> end(); ?>
			</div>
		</div>
	</div>
</div>