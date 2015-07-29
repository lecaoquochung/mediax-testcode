<?php //debug($users); ?>
<div class="box admin_sales span12">
	<div class="navbar">
		<div class="navbar-inner"><h3 class="brand"><?php  echo __('Sales'); ?></h3></div>
	</div>
	<div class="section">
		<?php App::import('Vendor', 'session_flash_message_box'); echo session_flash_message_box::success($this);?>
		<div class="action_list">
			<?php if(!isset($top_limit)){ ?>
			<div class="btn btn-success"><?php echo $this->Html->link(__('This Month Sales'),array('controller'=>'sales','action'=>'index')); ?></div>
			<div class="">
			<?php 
				$current_year = date('Y');
				$min_year = $current_year-1;
				$max_year = $current_year+2;
				
				echo $this->Form->create('Sale',array('type'=>'get'));
				/*echo $this->Form->input('target_month', array(
					'div'=>FALSE,
					'type'=>'date',
					'dateFormat'=>'YM',
					'minYear'=>$min_year,
					'maxYear'=>$max_year,
					'monthNames'=>Configure::read('monthNames'),
					'after'=> 	$this->Form->input('target_month2', array(
									'type'=>'date',
									'label'=>'~',
									'dateFormat'=>'YM',
									'minYear'=>$min_year,
									'maxYear'=>$max_year, 
									'monthNames'=>Configure::read('monthNames'),
									'div'=>false
								))
				));*/
				echo $this->Form->input('target_month', array('div'=>FALSE,'type'=>'date', 'dateFormat'=>'YM', 'minYear'=>$min_year, 'maxYear'=>$max_year, 'monthNames'=>Configure::read('monthNames')));
				
				echo $this->Form->button(__('表示'), array('style'=>'margin-top: -10px; margin-left: 10px;'));
				echo $this->Form->end();
			?>
			</div>
			<?php } ?>
			<div class="btn btn-info">
				<?php echo $this->Html->link(__('Set Target Sale'), array('controller'=>'sales', 'action' => 'add')); ?>
			</div>
		</div>
		<table cellpadding="0" cellspacing="0" class="table tableX">
			<tr>
				<th><?php echo $this->Paginator->sort('user_id'); ?></th>
				<th><?php echo __('Sale Status'); ?></th>
				<th><?php echo $this->Paginator->sort('target_sale'); ?></th>
				<th><?php echo __('Diff'); ?></th>
				<!--<th class="actions"><?php echo __('Actions'); ?></th>-->
			</tr>
			<?php foreach ($users as $user): ?>
			<tr>
				<td><?php echo $user['User']['name']; ?></td>
				<td><?php echo isset($user['User']['sales_status'])?$user['User']['sales_status']:0 ?>&nbsp;</td>
				<td><?php echo isset($sales[$user['User']['id']])?$sales[$user['User']['id']]:0; ?>&nbsp;</td>
				<td><?php 
						$diff = isset($sales[$user['User']['id']])?($user['User']['sales_status'] - $sales[$user['User']['id']]):0; 
						echo $diff<=0?'<span class="text-error">'.$diff.'</span>':$diff;
					?>&nbsp;
				</td>
				<!--<td class="actions">
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['Sale']['id'])); ?>
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['Sale']['id']), null, __('Are you sure you want to delete # %s?', $user['Sale']['id'])); ?>
				</td>-->
			</tr>
			<?php endforeach; ?>
		</table>
		<?php if(!isset($top_limit)){ ?>
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
