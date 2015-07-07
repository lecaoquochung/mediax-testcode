<?php $list_status = Configure::read('FLAG');?>
<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Statuses');?></h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->element('status_menu'); ?>
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::success($this);?>
		<table cellpadding="0" cellspacing="0" class="table tableX">
			<tr>
				<th class="tbl2"><?php echo __('user_id'); ?></th>
				<th class="tbl2"><?php echo __('Jobhunter'); ?></th>
				<th class="tbl2"><?php echo __('flag'); ?></th>
				<th class="tbl2"><?php echo __('Company'); ?></th>
				<th class="tbl3 actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php
			foreach ($statuses as $status): ?>
				<tr>
					<td><?php echo $this->Layout->getUser(array('User.id'=>$status['Status']['user_id']),'name'); ?></td>
					<td><?php echo $this->Html->link($status['Jobhunter']['name'], array('controller'=>'jobhunters', 'action' => 'view', $status['Jobhunter']['id'])); ?></td>
					<td><?php echo $status['Status']['flag']!=0?h($list_status[$status['Status']['flag']]):"新規追加"; ?></td>
					<td><?php echo $this->Html->link($status['Joboffer']['company_name'], array('controller'=>'joboffers', 'action' => 'view', $status['Status']['joboffer_id'])); ?></td>					
					<td class="actions" id="<?php echo h($status['Status']['id']); ?>">
						<div class="btn btn-danger">
						<?php echo $this->element('flag', array('status'=>$status)); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('controller'=>'statuses', 'action' =>'delete', $status['Status']['id']), null, __('この進捗情報を削除しますか？', $status['Status']['id'])); ?>
						</div>
					</td>
				</tr>
			<?php endforeach; ?>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('.actions .btn').click(function(){
			var id = $(this).parent().attr('id');
			var flag = $(this).attr('flag');
			if(flag!=0){
				$.ajax({
					url: '<?php echo $this->webroot ?>statuses/updateStatus',
					data:{
						id:id,
						flag:flag
					},
					type:'post',
					async:true,
					success:function(res){
						window.location.reload();
					},
					dataType:'json'
				}); 	
			}			
		})
	})
</script>