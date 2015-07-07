<?php
global $current_year;
?>
<div class="box admin_statuses_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Add Keyword'); ?></h3>
		</div>
	</div>
	<div class="section keywords form">
		<?php echo $this -> Session -> flash(); ?>
		<?php echo $this -> Form -> create('Keyword', array('class' => 'KeywordAddForm')); ?>
			<?php echo $this -> Form -> input('ID'); ?>
			<table class="table tableX">
<!-- user company -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Company')); ?>
					</th>
					<td>
						<?php
						if (!isset($this -> request -> params['pass'][0])) {
							echo $this -> Form -> input('UserID', array('label' => FALSE, 'type' => 'select', 'options' => $users));
						} else {
							echo $users[$this -> request -> params['pass'][0]];
							echo $this -> Form -> input('UserID', array('label' => FALSE, 'type' => 'hidden', 'options' => $users, 'value' => $this -> request -> params['pass'][0]));
						}
						?>
					</td>
				</tr>
<!-- keyword -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Keyword')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('Keyword', array('type' => 'text', 'label' => FALSE)); ?>
					</td>
				</tr>
<!-- url -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', 'URL'); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('Url', array('label' => FALSE)); ?>
					</td>
				</tr>
<!-- strict: domain or url -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Strict')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('Strict', array('label' => false, 'type' => 'select', 'options' => Configure::read('STRICT'))); ?>
					</td>
				</tr>
<!-- seika	-->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Seika')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('seika', array('label' => false, 'type' => 'select', 'options' => Configure::read('SEIKA'))); ?>
					</td>
				</tr>
<!-- nocontract: keiyaku mikeiyaku rankcheck -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Nocontract')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('nocontract', array('label' => false, 'type' => 'select', 'options' => Configure::read('NOCONTRACT'))); ?>
					</td>
				</tr>
<!-- price -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Price')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('Price', array('label' => false, 'type' => 'text', 'div' => FALSE, 'value' => 0)); ?>
						<?php echo $this -> Html -> tag('span', __('Yen')); ?>
					</td>
				</tr>
<!-- limit price -->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Limit Price')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('limit_price', array('label' => false, 'type' => 'text', 'div' => FALSE, 'value' => 0)); ?>
						<?php echo $this -> Html -> tag('span', __('Yen')); ?>
					</td>
				</tr>
<!-- limit price group-->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Limit Price Group')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('limit_price_group', array('label' => false, 'div' => false, 'type' => 'select', 'options' => Configure::read('MULTI_PRICE_GROUP'))); ?>
						<span class="text"><strong><?php echo __('Set group price limit') ?></strong></span>
					</td>
				</tr>
<!-- engine	-->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Engine')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('Engine', array('label' => false, 'type' => 'select', 'options' => Configure::read('ENGINE'))); ?>
					</td>
				</tr>
<!-- g local -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('G Local')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('g_local', array('label' => false, 'type' => 'select', 'options' => Configure::read('G_LOCAL'))); ?>
				</td>
			</tr>
<!-- rank start: keiyaku start-->
				<tr>
					<th>
						<?php echo $this -> Html -> tag('span', __('Rank Start')); ?>
					</th>
					<td>
						<?php echo $this -> Form -> input('rankstart', array('label' => false, 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => $current_year, 'minYear' => $current_year + 1, 'div' => FALSE, 'style' => 'width:auto;')); ?>
					</td>
				</tr>
<!-- option -->
				<tr>
					<th>
						<?php echo $this->Html->tag('span', __('Option')); ?>
					</th>
					<td>
						<?php echo $this->Form->input('service', array('type' => 'checkbox', 'label' => false, 'div' => FALSE)); ?>
						<span class="alert alert-warning"><strong><?php echo __('Check this box if keyword is Free Service') ?></strong></span>
						<br />
						<?php echo $this->Form->input('penalty', array('label' => false, 'div' => FALSE)); ?>
						<span class="alert-danger"><strong><?php echo __('Check this box if keyword is marking as penalty in Search Engine') ?></strong></span>
					</td>
				</tr>
			</table>
		<?php echo $this -> Form -> end(__('Add Keyword')); ?>
	</div>
</div>