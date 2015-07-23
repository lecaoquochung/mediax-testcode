<div class="box admin_statuses_add span12">
	<div class="navbar">
		<div class="navbar-inner">
			<h3 class="brand"><?php echo __('Edit Keyword'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Session->flash(); ?>
<!-- common button -->
		<div class="common-button"></div>
		<?php echo $this->Form->create('Keyword'); ?>
		<?php echo $this->Form->input('ID'); ?>
		<table class="table tableX">
<!-- user company -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span',__('Company')); ?>
				</th>
				<td>
					<?php 
						echo $this->Form->input('UserID',array('label' => FALSE, 'type' => 'select', 'options' => $users));
					?>
				</td>
			</tr>
<!-- keyword -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Keyword')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('Keyword', array('type' => 'text', 'label' => FALSE)); ?>
					 <?php 
						if (!empty($this->request->data['Keyword']['rankend']) && $this->request->data['Keyword']['rankend'] != 0) {
							echo '<div class="cancel_contract">';
							echo (!empty($this->request->data['Keyword']['rankend'])) ? $this->Form->button(__('Cancel Reset'), array('type' => 'button', 'class' => 'btn btn-danger cancel_keyword', 'value' => $this->request->data['Keyword']['ID'])) : '';
							echo '<br />';
							echo (!empty($this->request->data['Keyword']['rankend'])) ?
								__('Keyword Cancel Date') . ' ' . $this->request->data['Keyword']['rankend']:
								'';
							echo '<br />';
							echo (!empty($this->request->data['Keyword']['kaiyaku_reason'])) ? $this->request->data['Keyword']['kaiyaku_reason']:'';
							echo '</div>';
						} else {
							echo ($this->request->data['Keyword']['nocontract'] != 1) ?'<a href="#myModalStatus" role="button" class="btn btn-mini btn-warning" data-toggle="modal">' . __("Cancel Keyword") . '</a>' : '';	
						}
					?>
				</td>
			</tr>
<!-- url -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', 'URL'); ?>
				</th>
				<td>
					<?php echo $this->Form->input('Url', array('label' => FALSE)); ?>
				</td>
			</tr>
<!-- strict: domain or url -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span',__('Strict')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('Strict',array('label' => false, 'type'=>'select', 'options'=>Configure::read('STRICT')));?>
				</td>
			</tr>
<!-- seika	-->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Seika')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('seika', array('label' => false, 'type' => 'select', 'options' => Configure::read('SEIKA'))); ?>
				</td>
			</tr>
<!-- nocontract: keiyaku mikeiyaku rankcheck -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Nocontract')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('nocontract', array('label' => false, 'type' => 'select', 'options' => Configure::read('NOCONTRACT'))); ?>
				</td>
			</tr>
<!-- price -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Price')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('Price', array('label' => false, 'type' => 'text', 'div' => FALSE)); ?>
					<?php echo $this->Html->tag('span', __('Yen')); ?>
				</td>
			</tr>
<!-- limit price -->
			 <tr>
				<th>
					<?php echo $this->Html->tag('span', __('Keyword Limit Price')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('limit_price', array('required' => False, 'label' => false, 'type' => 'text', 'div' => FALSE)); ?>
					<?php echo $this->Html->tag('span', __('Yen')); ?>
				</td>
			</tr>
<!-- limit price group-->
			 <tr>
				<th>
					<?php echo $this->Html->tag('span', __('Limit Price Group')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('limit_price_group', array('label' => false, 'div' => false, 'type' => 'select', 'options' => Configure::read('MULTI_PRICE_GROUP'))); ?>
					<span class="text"><strong><?php echo __('Set group price limit') ?></strong></span>
				</td>
			</tr>
<!-- engine -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Engine')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('Engine', array('label' => false, 'type' => 'select', 'options' => Configure::read('ENGINE'))); ?>
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
<!-- penalty mark -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Penalty')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('penalty', array('label' => false, 'div' => FALSE)); ?>
					<span class="alert-danger"><strong><?php echo __('Check this box if keyword is marking as penalty in Search Engine') ?></strong></span>
				</td>
			</tr>
<!-- c_logic -->
			<tr>
				<th>
					<?php echo $this->Html->tag('span', __('Raking by company')); ?>
				</th>
				<td>
					<?php echo $this->Form->input('c_logic', array('label' => false, 'div' => FALSE)); ?>
					<span class="alert-warning"><strong><?php echo __('Keyword Ranking will be checked by company logic Server') ?></strong></span>
				</td>
			</tr>
		</table>
			<?php echo $this->Form->button(__('Submit'), array('class'=>'btn btn-info', 'div'=>FALSE)); ?>
			<?php echo $this->Html->link(__('Company Detail'), array('controller' => 'users' , 'action' => 'view', $this->request->data['User']['id']), array('class' => "btn")); ?>
		<?php echo $this->Form->end(); ?>
		<?php echo $this->element('modal/cancel_keyword'); ?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
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
