<?php 
	global $current_year; 
	global $current_date;
?>
<div class="box admin_statuses_add span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Cancel Keyword'); ?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Form->create('Keyword'); ?>
			<?php echo $this->Form->input('ID');?>
			<table class="table tableX">
				<tr>
	                <th>
	                     <?php echo $this->Html->tag('span',__('Keyword')); ?>
	                </th>
	                <td>
						<?php echo $this->Form->input('Keyword',array('type' => 'text', 'label' => FALSE, 'readonly' => TRUE));?>
	                </td>
				</tr>
				<tr>
	                <th>
	                     <?php echo $this->Html->tag('span','URL'); ?>
	                </th>
	                <td>
						<?php echo $this->Form->input('Url', array('label' => FALSE, 'readonly' => TRUE));?>
	                </td>
				</tr>
				<tr>
	                <th>
	                     <?php echo $this->Html->tag('span',__('Cancel Date')); ?>
	                </th>
	                <td>
						<?php 
							if(empty($this->request->data['Keyword']['rankend']) || $this->request->data['Keyword']['rankend'] == 0 ){
								$this->request->data['Keyword']['rankend'] = $current_date;
								echo $this->Form->input('rankend',array('label' => FALSE, 'type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'), 'maxYear'=>$current_year+1, 'minYear'=>$current_year, 'div'=>FALSE, 'style' => 'width:auto;')); 
							} else {
								echo '<div class="cancel_contract">';
								#The Keyword contract has been cancel
								echo (!empty($this->request->data['Keyword']['rankend']))?
								__('Keyword Cancel Date') .' ' .$this->request->data['Keyword']['rankend'] .' ' .$this->Form->button(__('Cancel Reset'),array('type'=>'button','class'=>'btn btn-danger cancel_keyword','value'=>$this->request->data['Keyword']['ID'])):
								'';
								echo '</div>';
							}
						?>
	                </td>
				</tr>
				<tr>
	                <th>
	                     <?php echo $this->Html->tag('span',__('Cancel Reason')); ?>
	                </th>
	                <td>
						<?php echo $this->Form->input('kaiyaku_reason',array('label' => false, 'type'=>'textarea'));?>
	                </td>
				</tr>
			</table>
		<?php echo $this->Form->end(__('Submit')); ?>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.cancel_keyword').click(function(){
        var keyID = $(this).val();
        $.ajax({
            url:'<?php echo $this->webroot ?>rankhistories/reset_rankend/' +keyID,
            success:function(data){
                $('.section .session_flash_message_box').remove();
                $('.section').prepend('<div class="session_flash_message_box success_box"><div class="message" id="flashMessage">キーワードの解約キャンセルは成功しました.</div></div>');
				window.location.reload(true);
            }
        })
    })
})
</script>