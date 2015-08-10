<div class="row">
	<div class="col-md-6">
		<div class="box box-primary">
			<div class="box-header">
				<h3 class="box-title"><?php  echo __('Edit Keyword'); ?></h3>
			</div>
			<?php echo $this -> Session -> flash(); ?>
			<div class="box-body">
				<?php echo $this->Session->flash(); ?>
		<!-- common button -->
				<div class="common-button"></div>
				<?php echo $this->Form->create('Keyword'); ?>
				<?php echo $this->Form->input('ID'); ?>
				<table class="table tableX">
		<!-- user company -->
					<div class="form-group">
						<label for="InputUserID">
							<?php echo $this -> Html -> tag('span', __('Company')); ?>
						</label>
						<?php 
							echo $this->Form->input('UserID',array('class' => 'form-control', 'label' => FALSE, 'type' => 'select', 'options' => $users));
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
		<!-- cost -->
					<div class="form-group">
						<label for="InputPrice"><?php echo $this -> Html -> tag('span', __('Cost')); ?></label>
						<?php echo $this -> Form -> input('cost', array('type' => 'cost', 'label' => FALSE, 'placeholder' => __('Enter Cost'), 'class' => 'form-control')); ?>
					</div>
		<!-- price -->
					<div class="form-group">
						<label for="InputPrice"><?php echo $this -> Html -> tag('span', __('Price')); ?></label>
						<?php echo $this -> Form -> input('Price', array('type' => 'price', 'label' => FALSE, 'placeholder' => __('Enter Price'), 'class' => 'form-control')); ?>
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
		<!-- engine -->
					<div class="form-group">
						<label for="InputEngine"><?php echo $this -> Html -> tag('span', __('Engine')); ?></label>
						<?php echo $this -> Form -> input('Engine', array('label' => false, 'type' => 'select', 'options' => Configure::read('ENGINE'), 'class' => 'form-control')); ?>
					</div>
		<!-- g local -->
					<!-- <tr>
						<th>
							<?php echo $this->Html->tag('span', __('G Local')); ?>
						</th>
						<td>
							<?php echo $this->Form->input('g_local', array('label' => false, 'type' => 'select', 'options' => Configure::read('G_LOCAL'))); ?>
						</td>
					</tr> -->
					<div class="form-group">
						<label for="InputGlocal"><?php echo $this -> Html -> tag('span', __('Google Local')); ?></label>
						<?php echo $this -> Form -> input('g_local', array('label' => false, 'type' => 'select', 'options' => Configure::read('G_LOCAL'), 'class' => 'form-control')); ?>
					</div>
		<!-- option -->
					<div class="form-group">
						<div class="checkbox">
							<?php echo $this -> Form -> input('sales', array('class' => 'form-control', 'label' => False, 'div' => False)); ?>
							<span class="alert-default"><strong><?php echo __('Sales Lists') ?></strong></span>
						</div>
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
				</table>
					<?php echo $this->Form->button(__('Submit'), array('class'=>'btn btn-info', 'div'=>FALSE)); ?>
					<?php echo $this->Html->link(__('Company Detail'), array('controller' => 'users' , 'action' => 'view', $this->request->data['User']['id']), array('class' => "btn")); ?>
				<?php echo $this->Form->end(); ?>
				<?php echo $this->element('modal/cancel_keyword'); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		<?php if(isset($close_window)): ?>
		parent.location.reload(true);
		parent.$.fancybox.close();
		<?php endif; ?>
		$('.cancel_keyword').click(function() {
			var keyID = $(this).val();
			var Url = $('#KeywordUrl').val();
			$.ajax({
				url: '<?php echo $this->webroot ?>rankhistories/reset_rankend/',
				data: {keyID:keyID,Url:Url},
				type: 'POST',
				success: function(data) {
					$('.section .session_flash_message_box').remove();
					$('.section').prepend('<div class="session_flash_message_box success_box"><div class="message" id="flashMessage">キーワードの解約キャンセルは成功しました.</div></div>');
					window.location = "<?php echo $this->webroot?>rankhistories";
				}
			})
		})
	})
</script>
