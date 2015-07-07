<?php
global $current_year;
?>
<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Add Keyword'); ?></h3>
			</div>
			<?php echo $this -> Session -> flash(); ?>
			<?php echo $this -> Form -> create('Keyword', array('class' => 'KeywordAddForm')); ?>
			<?php echo $this -> Form -> input('ID'); ?>
			<div class="box-body">
<!-- user company -->
				<div class="form-group">
					<label for="InputUserID"><?php echo $this -> Html -> tag('span', __('Company')); ?></label>
					<?php
					if (!isset($this -> request -> params['pass'][0])) {
						echo $this -> Form -> input('UserID', array('label' => FALSE, 'type' => 'select', 'options' => $users, 'class' => 'form-control'));
					} else {
						echo $users[$this -> request -> params['pass'][0]];
						echo $this -> Form -> input('UserID', array('label' => FALSE, 'type' => 'hidden', 'options' => $users, 'value' => $this -> request -> params['pass'][0], 'class' => 'form-control'));
					}
					?>
				</div>
<!-- keyword -->
				<div class="form-group">
					<label for="InputKeyword"><?php echo $this -> Html -> tag('span', __('Keyword')); ?></label>
					<?php echo $this -> Form -> input('Keyword', array('type' => 'keyword', 'label' => FALSE, 'placeholder' => __('Enter Keyword'), 'class' => 'form-control')); ?>
				</div>
<!-- url -->
				<div class="form-group">
					<label for="InputUrl"><?php echo $this -> Html -> tag('span', __('URL')); ?></label>
					<?php echo $this -> Form -> input('Url', array('type' => 'url', 'label' => FALSE, 'placeholder' => __('Enter Url'), 'class' => 'form-control')); ?>
				</div>
<!-- strict: domain or url -->
				<div class="form-group">
					<label for="InputStrict"><?php echo $this -> Html -> tag('span', __('Strict')); ?></label>
					<?php echo $this -> Form -> input('Strict', array('label' => false, 'type' => 'select', 'options' => Configure::read('STRICT'), 'class' => 'form-control')); ?>
				</div>
<!-- seika	-->
				<div class="form-group">
					<label for="InputSeika"><?php echo $this -> Html -> tag('span', __('Seika')); ?></label>
					<?php echo $this -> Form -> input('seika', array('label' => false, 'type' => 'select', 'options' => Configure::read('SEIKA'), 'class' => 'form-control')); ?>
				</div>
<!-- nocontract: keiyaku mikeiyaku rankcheck -->
				<div class="form-group">
					<label for="InputSeika"><?php echo $this -> Html -> tag('span', __('Nocontract')); ?></label>
					<?php echo $this -> Form -> input('nocontract', array('label' => false, 'type' => 'select', 'options' => Configure::read('NOCONTRACT'), 'class' => 'form-control')); ?>
				</div>
<!-- price -->
				<div class="form-group">
					<label for="InputPrice"><?php echo $this -> Html -> tag('span', __('Price')); ?></label>
					<?php echo $this -> Form -> input('Price', array('value' => 0, 'type' => 'price', 'label' => FALSE, 'placeholder' => __('Enter Price'), 'class' => 'form-control')); ?>
				</div>
<!-- limit price -->
				<div class="form-group">
					<label for="InputLimitPrice"><?php echo $this -> Html -> tag('span', __('Limit Price')); ?></label>
					<?php echo $this -> Form -> input('limit_price', array('type' => 'limit_price', 'label' => FALSE, 'placeholder' => __('Enter Limit Price'), 'class' => 'form-control')); ?>
				</div>
<!-- limit price group-->
				<div class="form-group">
					<label for="InputLimitPriceGroup"><?php echo $this -> Html -> tag('span', __('Limit Price Group')); ?></label>
					<?php echo $this -> Form -> input('limit_price_group', array('label' => false, 'div' => false, 'type' => 'select', 'options' => Configure::read('MULTI_PRICE_GROUP'), 'class' => 'form-control')); ?>
				</div>
<!-- engine	-->
				<div class="form-group">
					<label for="InputEngine"><?php echo $this -> Html -> tag('span', __('Engine')); ?></label>
					<?php echo $this -> Form -> input('Engine', array('label' => false, 'type' => 'select', 'options' => Configure::read('ENGINE'), 'class' => 'form-control')); ?>
				</div>
<!-- g local -->
				<div class="form-group">
					<label for="InputGlocal"><?php echo $this -> Html -> tag('span', __('Google Local')); ?></label>
					<?php echo $this -> Form -> input('g_local', array('label' => false, 'type' => 'select', 'options' => Configure::read('G_LOCAL'), 'class' => 'form-control')); ?>
				</div>
<!-- rank start: keiyaku start-->
				<div class="form-group">
					<label for="InputRankStart"><?php echo $this -> Html -> tag('span', __('Rank Start')); ?></label>
					<?php
						echo $this -> Form -> input('rankstart', array('class' => 'input-sm', 'div' => FALSE, 'label' => FALSE, 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => $current_year, 'minYear' => $current_year + 1, 'style' => 'width:auto;'));
					?>
				</div>
<!-- option -->
				<div class="form-group">
					<div class="checkbox">
						<?php echo $this -> Form -> input('mobile', array('class' => 'form-control', 'label' => False, 'div' => False)); ?>
						<span class="alert-success"><strong><?php echo __('Check Rank Mobile') ?></strong></span>
					</div>
					<div class="checkbox">
						<?php echo $this -> Form -> input('service', array('class' => 'form-control', 'type' => 'checkbox', 'label' => False, 'div' => False)); ?>
						<span class="alert-warning"><strong><?php echo __('Check this box if keyword is Free Service') ?></strong></span>
					</div>
					<div class="checkbox">
						<?php echo $this -> Form -> input('penalty', array('class' => 'form-control', 'label' => False, 'div' => False)); ?>
						<span class="alert-danger"><strong><?php echo __('Check this box if keyword is marking as penalty in Search Engine') ?></strong></span>
					</div>
				</div>
			<?php echo $this->Form->button(__('Add Keyword'), array('class'=>'btn btn-warning', 'div'=>FALSE)); ?>
			<?php echo $this -> Form -> end(); ?>
		</div>
	</div>
</div>