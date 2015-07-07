<div class="row">
	<div class="col-xs-12">
		<div class="box">
			<?php echo $this->Session->flash(); ?>
			<div class="box-header"></div>
			<div class="box-body table-responsive no-padding">
				<!-- table -->
				<table class="table table-striped">
					<tr>
						<th><?php echo $this->Paginator->sort('#'); ?></th>
						<th><?php echo $this->Paginator->sort('log'); ?></th>
						<th><?php echo $this->Paginator->sort('ip'); ?></th>
						<th><?php echo $this->Paginator->sort('created'); ?></th>
					</tr>
					<?php foreach ($logs as $log): ?>
						<tr>
							<td><?php echo h($log['Log']['id']); ?>&nbsp;</td>
							<td><?php 
									// $log_json = json_decode($log['Log']['log'], True);
									// echo h($log_json['pk']); 
									echo $log['Log']['log'];
								?>&nbsp;
							</td>
							<td><?php echo in_array($log['Log']['ip'], Configure::read('Server.ip'))? $log['Log']['ip'] : '<span class="label label-danger">' .$log['Log']['ip'] .'</span>' ?>&nbsp;</td>
							<td><?php echo h($log['Log']['created']); ?>&nbsp;</td>
						</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div><!-- box -->
	</div>
</div>