<?php $support_label = Configure::read('SUPPORT_LABEL'); $list_status = Configure::read('FLAG');?>
<div class="box admin_students span12">
	<div class="navbar">
		<div class="navbar-inner">
		<h3 class="brand"><?php  echo __('List Jobhunters'); ?></h3>
		</div>
	</div>
	<?php foreach($jobhunter['Support'] as $support): ?>
	<table class="table tableX rireki">
		<tr>
			<td class="tbl3"><?php echo $this->Layout->getUser(array('User.id'=>$support['user_id']),'name'); ?></td>
			<td class="tbl1"><?php echo h($support_label[$support['label']]); ?></td>
			<td class="tbl1"><?php echo h($support['date']); ?></td>
			<td class="tbl4"><?php echo h($support['note']); ?></td>
			<td class="tbl4">
				<div class="btn btn-danger"><?php echo $this->Form->postLink(__('Action'), array('controller'=>'supports','action' => 'action', $support['id']), null, __('Are you sure you want to set to top?', $support['id'])); ?></div>
						<div class="icon">
							<span class="edit">
				<a href="javascript:void(0)" data-url="<?php echo Router::url(array('controller'=>'supports','action' => 'edit', $support['id'])) ?>" class="edit_support"><?php echo __('Edit')?></a>
							</span>
						</div>
						<div class="icon">
							<span class="del">
				<?php echo $this->Form->postLink(__('Delete'), array('controller'=>'supports','action' => 'delete', $support['id']), null, __('Are you sure you want to delete # %s?', $support['id'])); ?>
							</span>
						</div>
			</td>
		</tr>
	</table>
	<?php endforeach; ?>
	<div class="section">
		<table class="table tableX">
			<tr><th><?php echo __('Name'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['name']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Furigana'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['furigana']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Email'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['email']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Mobile Email'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['mobile_email']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Birthday'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['birthday']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Age'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['age']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Gender'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['gender']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Address'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['address']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Phone'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['phone']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Last Education'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['last_education']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Marriage'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['marriage']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Job Change'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['job_change']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Experience'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['experience']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Certificate'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['certificate']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Certificate Comment'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['certificate_comment']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Income'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['income']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Introduce'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['introduce']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Company Name'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['company_name']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Industry'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['industry']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Working Period'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['working_period']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Employment Type'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['employment_type']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Position'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['position']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Woking Content'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['woking_content']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Top1 Employment Type'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['top1_employment_type']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Top1 Job'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['top1_job']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Top1 Workingplace'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['top1_workingplace']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Top1 Income'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['top1_income']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Top1 Characteristic'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['top1_characteristic']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Personal Type'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['personal_type']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Created Csv'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['created_csv']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Modified Csv'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['modified_csv']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Register'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['register']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Contact'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['contact']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Postcode'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['postcode']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Prefecture'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['prefecture']); ?>
				
			</td></tr>
			<tr><th><?php echo __('City'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['city']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Address No'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['address_no']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Building Name'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['building_name']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Station'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['station']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Time To Station'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['time_to_station']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Memo'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['memo']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Created'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['created']); ?>
				
			</td></tr>
			<tr><th><?php echo __('Modified'); ?></th>
			<td>
				<?php echo h($jobhunter['Jobhunter']['modified']); ?>
				
			</td></tr>
		</table>
	</div>
	<?php foreach($statuses as $status): ?>
	<table class="table tableX slog">
		<tr class="tbl20">
		<th class="tbl10"><span><?php echo $status['Joboffer']['company_name'] ?></span>進捗ログ一覧</th>
		<th></th>
		<th></th>
		</tr>
		<?php foreach($status['Slog'] as $slog): ?>
		<tr class="tbl20">
			<td class="tbl6"><?php echo$status['User']['name']; ?></td>
			<td class="tbl6"><?php echo $slog['created']; ?></td>
			<td class="tbl6"><?php echo $list_status[$slog['flag']]; ?></td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php endforeach; ?>
</div>
<script type="text/javascript">
$(document).ready(function(){	
	$('.edit_support').click(function(){
		window.open($(this).attr('data-url'),'編集','width=550,height=600,location=no');
	})
})
</script>