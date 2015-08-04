<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Upload Keyword csv'); ?></h3>
			</div>
			<?php echo $this -> Session -> flash(); ?>
			<?php echo $this -> Form -> create('Upload', array('class' => 'KeywordAddForm','type' => 'file')); ?>
			<div class="box-body">
<!-- keyword -->
			<div class="form-group">
				<label for="InputKeyword"><?php echo $this -> Html -> tag('span', __('Csv')); ?></label>
				<?php echo $this -> Form -> input('csv', array('type' => 'file', 'label' => FALSE, 'class' => 'form-control')); ?>
			</div>
			<?php echo $this->Form->button(__('Upload'), array('class'=>'btn btn-warning', 'div'=>FALSE)); ?>
			<?php echo $this -> Form -> end(); ?>
		</div>
	</div>
</div>