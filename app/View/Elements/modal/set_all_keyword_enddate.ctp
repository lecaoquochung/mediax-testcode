<?php
global $current_year;
global $current_date;
?>
<div id="myModalEnableKeyword" class="modal modal-danger fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header warning">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				<h3 id="myModalLabel" class="alert alert-danger"><?php echo __('Set Endate to All Keyword'); ?></h3>
			</div>
			<div class="modal-body" style="height: 300px; overflow-y:scroll;">
				<?php echo $this -> Form -> create('Keyword', array('url' => array('controller' => 'keywords', 'action' => 'set_all_keyword_enddate'))); ?>
				<?php
					echo $this -> Form -> input('UserID', array('type' => 'hidden', 'value' => $user_id));
					echo $this -> Form -> input('nocontract', array('type' => 'hidden', 'value' => 0));
				?>
				<table class="table">
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('解約日')); ?>
						</th>
						<td>
							<?php
								if (empty($this -> request -> data['Keyword']['rankend']) || $this -> request -> data['Keyword']['rankend'] == 0) {
									$this -> request -> data['Keyword']['rankend'] = $current_date;
								}
								echo $this -> Form -> input('rankend', array('label' => FALSE, 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => $current_year + 1, 'minYear' => $current_year - 1, 'div' => FALSE, 'style' => 'width:auto;'));
							?>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('Keyword')); ?>
						</th>
						<td>
							<?php
								$keywords = Hash::combine($keywords, '{n}.ID', '{n}.keyword', '{n}.rankend');
								echo $this -> Form -> input('id', array('label' => false, 'type' => 'select', 'multiple' => 'checkbox', 'options' => @$keywords[0]));
							?>
						</td>
					</tr>
					<tr>
						<th>
							<?php echo $this -> Html -> tag('span', __('解約理由')); ?>
						</th>
						<td>
							<?php echo $this -> Form -> input('kaiyaku_reason', array('label' => false, 'type' => 'textarea', 'rows' => 5, 'cols' => 50)); ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="modal-footer" id="">
				<span class="alert-danger">※上記のチェックするキーワードは全て解約する</span>
				<!-- <input type="reset" /> -->
				<?php echo $this -> Form -> button(__('Check All'), array('type' => 'button', 'class' => 'btn btn-info btn-sm check_all_keyword')); ?>
				<?php echo $this -> Form -> button(__('Uncheck All'), array('type' => 'button', 'class' => 'btn btn-warning btn-sm reset_all_keyword')); ?>
				<?php echo $this -> Form -> button(__('Set Nocontract'), array('class' => 'btn btn-danger btn-sm')); ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		X = event.target.value;

		$('.check_all_keyword').click(function(e) {
			e.preventDefault();			
			$('input[id^="KeywordId"]').iCheck('check');
		})

		$('.reset_all_keyword').click(function(e) {
			e.preventDefault();
			$('input[id^="KeywordId"]').iCheck('uncheck');
		})
	})
</script>