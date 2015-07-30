<?php $list_status = Configure::read('FLAG');?>
<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('Statuses');?></h3>
		</div>
	</div>
	<div class="section">
		<?php if(!isset($top_limit)) { ?>
			<?php echo $this->Form->create('Status',array('class'=>'form-search')); ?>
			<div class="input-append">
			<?php echo $this->Form->input('keyword',array('label'=>FALSE,'class'=>'span12 search-query', 'type'=>'text','div'=>FALSE)); ?>
			<?php echo $this->Form->button(__('Search'), array('class'=>'btn')); ?>
			</div>
			<?php echo $this->Form->end(); ?>
		<?php } ?>
		<?php echo $this->element('status_menu'); ?>
		<div class="action_list">
		<div class="btn btn-info"><?php echo $this->Html->link(__('New Status'), array('controller'=>'statuses', 'action' => 'add')); ?>
		</div>
		</div>
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::success($this);?>
		<table cellpadding="0" cellspacing="0" class="table tableX">
			<tr>
				<th class="tbl2"><?php echo $this->Paginator->sort('user_id'); ?></th>
				<th class="tbl2"><?php echo __('Jobhunter'); ?></th>
				<th class="tbl2"><?php echo $this->Paginator->sort('flag'); ?></th>
				<th class="tbl2"><?php echo __('Company'); ?></th>
				<th class="tbl2"><?php echo __('Interview Date'); ?></th>
				<th class="tbl2"><?php echo __('Price'); ?></th>
				<?php //if(!isset($top_limit)) { ?>
					<th class="tbl4 actions"><?php echo __('Actions'); ?></th>
				<?php //} ?>
				<th class="tbl2"></th>
			</tr>
			<?php
			foreach ($statuses as $status): ?>
				<tr>
					<td><?php echo $this->Layout->getUser(array('User.id'=>$status['Status']['user_id']),'name'); ?></td>
					<td><?php echo $this->Html->link($status['Jobhunter']['name'], array('controller'=>'jobhunters', 'action' => 'view', $status['Jobhunter']['id'])); ?></td>
					<td><?php echo $status['Status']['flag']!=0?h($list_status[$status['Status']['flag']]):"新規追加"; ?></td>
					<td><?php echo $this->Html->link($status['Joboffer']['company_name'], array('controller'=>'joboffers', 'action' => 'view', $status['Status']['joboffer_id'])); ?></td>					
					<td><?php echo $status['Status']['end_date']; ?></td>
					<td><?php echo isset($status['Status']['price'])?$status['Status']['price']:'<p class="muted">'.__('Not set').'</p>'; ?></td>
					<?php //if(!isset($top_limit)) { ?>
					<td class="actions" id="<?php echo h($status['Status']['id']); ?>">
						<?php echo $this->element('flag', array('status'=>$status)); ?>
						<!-- Modal -->
						<?php echo $this->element('modal/set_sale_price', array('id'=>$status['Status']['id'])); ?>
					</td>
					<td>
						<div class="icon">
							<span class="edit"><?php echo $this->Html->link(__('Edit'), array('controller'=>'statuses', 'action' => 'edit', $status['Status']['id'])); ?></span>
						</div>
						<div class="icon">
							<span class="del"><?php echo $this->Form->postLink(__('Delete'), array('controller'=>'statuses', 'action' =>'delete', $status['Status']['id']), null, __('この進捗情報を削除しますか？', $status['Status']['id'])); ?></span>
						</div>
					</td>
					<?php //} ?>
				</tr>
			<?php endforeach; ?>
		</table>
		<?php if(!isset($top_limit)) { ?>
			<div class="paging">
				<?php
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
			</div>
		<?php } ?>
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
		
		//
		$('.set_price').click(function(){
			var id = $(this).parent().attr('id');
//			alert(id);
//			#16
			var flag = 21;
			var price = $('#StatusPrice').val();
			if(flag!=0){
				$.ajax({
					url: '<?php echo $this->webroot ?>statuses/updateStatus',
					data:{
						id:id,
						flag:flag,
						price:price
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