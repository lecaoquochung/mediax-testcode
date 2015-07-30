<div class="row">
	<?php echo $this->Session->flash(); ?>
	<div class="col-xs-6">
		<table class="table table-bordered table-hover dataTable">
			<tr>
				<th>
					<h2 class="title-header"><!-- text-light-blue -->
						<?php echo __('Company'); ?>
					</h2>
				</th>
				<td>
					<h2 class="title-header"><!-- text-light-blue -->
						<?php  echo $user['User']['company'];?>
						<?php echo ($user['User']['agent'] == 0) ? '' : '(' .__('Agent') .')';?>
						<a class="btn btn-info btn-sm" href="<?php echo Router::url(array('controller' => 'users' , 'action' => 'edit', $user['User']['id'])); ?>" role="button"><?php echo __('Edit Company') ?></a>
						<?php if($user['User']['agent'] == 0): ?>
							<a class="btn btn-default btn-sm" href="<?php echo Router::url(array('controller' => 'users' , 'action' => 'agent_set', $user['User']['id'])); ?>" role="button"><?php echo __('Agent Set') ?></a>
						<?php endif; ?>
					</h2>
				</td>
			</tr>
			<tr>
				<th>
					<h4><?php echo __('Name'); ?></h4>
				</th>
				<td>
					<h4><?php echo h($user['User']['name']); ?>&nbsp;</h4>
				</td>
			</tr>
			<tr>
				<th><?php echo __('Email'); ?></th>
				<td>
					<?php echo h($user['User']['email']); ?>&nbsp;
				</td>
			</tr>
			<tr>
				<th><?php echo __('Tel'); ?></th>
				<td>
					<?php echo h($user['User']['tel']); ?>&nbsp;
				</td>
			</tr>
			<!-- <tr>
				<th><?php echo __('Fax'); ?></th>
				<td>
					<?php echo h($user['User']['fax']); ?>&nbsp;
				</td>
			</tr> -->
		</table>
		
		<div class="new-line">&nbsp;</div>
		
		<a href="<?php echo FULL_BASE_URL .CLIENT_PATH ?>/users/autologin/<?php echo 'email:'.base64_encode($user['User']['email']) .'/pass:' .$user['User']['pwd']; ?>" class="label label-default" target="_blank"><?php echo __('Go to this client view') ?></a>
	</div>
</div>

<div class="row">
	<div class="col-xs-6">
		<h2 class="title-header"><!-- text-light-blue -->
			<?php  echo __('Keyword');?>
			<a class="btn btn-warning btn-sm" href="<?php echo Router::url(array('controller' => 'keywords' , 'action' => 'add', $user['User']['id'])); ?>" role="button"><?php echo __('Add Keyword') ?></a>
			<!-- kaiyaku set end date -->
			<?php echo $this->Html->link(__('Set Endate to All Keyword'), '#', array('data-toggle'=>'modal', 'data-target' => '#myModalEnableKeyword','role'=>'button','class' => "btn btn-danger btn-sm")); ?>
		</h2>
	</div>
	<div class="col-xs-6">
		<h2 class="title-header"><!-- text-light-blue -->
		<!-- search history form -->
		<?php echo $this -> Form -> create('Rankhistory', array('class' => 'form-search', 'id' => '')); ?>
		<div class="form-group">
			<div class="controls row">
				<div class="input-group col-sm-8">
				<?php 
					$current_year = date('Y'); 
					echo $this->Form->input('rankDate',array(
						'class' => 'input-sm',
						'div'=>False,
						'label' => False,
						'type'=>'date' ,
						'dateFormat'=>'YMD',
						'monthNames'=>Configure::read('monthNames'), 
						'maxYear'=>$current_year, 
						'minYear'=>$current_year-2, 
					)); 
					echo '&nbsp';
					echo $this->Form->button(__('Choose'), array('class'=>'btn btn-info btn-sm', 'div' => True));
				?>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>
		</h2>
	</div>
</div>