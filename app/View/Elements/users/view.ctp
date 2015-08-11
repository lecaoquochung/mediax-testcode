<?php echo $this->element($this->params['controller'] .'/header') ?>

<div class="row">
	<div class="col-xs-12">
		<div class="">
			<?php if (!empty($user['Keyword'])): ?>
			<!--hl start contract -->
			<?php $keywords = Hash::extract($user['Keyword'], '{n}[nocontract=0]');?>
			<h3><span class="label label-success"><?php echo __('Contract Keyword'); ?></span></h3>
			
			<table class="table table-hover dataTable">
				<tr>
					<th class="tbl1"><?php echo __('ID'); ?></th>
					<th class="tbl4"><?php echo __('Keyword'); ?></th>
					<th class="tbl5"><?php echo __('Url'); ?></th>
					<th class="tbl2"><?php echo __('Google/Yahoo'); ?></th>
					<th class="tbl1"><?php echo __('Price'); ?></th>
					<th class="tbl2"><?php echo __('Rankstart'); ?></th>
					<th class="tbl2"><?php echo __('Rankend'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				<?php $i = 0; foreach ($keywords as $keyword): ?>
				<?php if($keyword['rankend'] == 0 || $keyword['rankend'] > date('Ymd', strtotime('-1 month' .date('Ymd')))) { ?>
				<tr>
	<!-- id -->
					<td><?php echo $keyword['ID']; ?></td>
	<!-- keyword -->
					<td>
						<!-- group -->
						<?php echo ($keyword['limit_price_group'] != 0) ? '<span class="label label-warning">'.$keyword['limit_price_group'] .'</span>' : '' ?>
						<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
						<br />
						<span class="alert-danger"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
					</td>
	<!-- url -->
					<td><?php echo $this->Html->link($this->Text->truncate($keyword['Url'], configure::read('TRUNCATE_URL')),$keyword['Url'], array('target'=>'_blank')); ?></td>
	<!-- rank -->
					<td>
						<?php 
							echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $rankhistory[$keyword['ID']] :  
								$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$keyword['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
							; 
						?>
					</td>
	<!-- price -->
					<td>
						<?php
							if ($keyword['Engine'] == 1) {
								$google_rank = $rankhistory[$keyword['ID']];
								$yahoo_rank = 0;
							} 
							elseif ($keyword['Engine'] == 2) {
								$google_rank = 0;
								$yahoo_rank = $rankhistory[$keyword['ID']];
							}else {
								@$ranks = explode('/', $rankhistory[$keyword['ID']]);
								$google_rank = @$ranks[0];
								$yahoo_rank = @$ranks[1];
							}
							
							if($google_rank==0 && $yahoo_rank!=0){
								$graph_google[] = 100;
								$graph_yahoo[] = $yahoo_rank; 
							}else if ($yahoo_rank==0 && $google_rank!=0){
								$graph_yahoo[] = 100;
								$graph_google[] = $google_rank;
							}else if ($google_rank == 0 && $yahoo_rank==0){
								$graph_google[] = 100;
								$graph_yahoo[] = 100;
							}else{
								$graph_google[] = $google_rank;
								$graph_yahoo[] = $yahoo_rank;
							}   					
							
							$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$keyword['ID'].']');
							$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
							
							$data_extra = array();		
							foreach($extra as $key_extra => $value_extra) {
								if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
									$data_extra[$key_extra] = $value_extra;
								}
							}
							
							if(count($data_extra)>0){
								ksort($data_extra);
								$key_extra = array_keys($data_extra);
								echo $data_extra[$key_extra[0]];
								$total_price[] = $data_extra[$key_extra[0]];
							}else{
								foreach($extra as $key => $value) {
									if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
										echo isset($value) ? $value : 0;
										$total_price[] = isset($value) ? $value : 0;
									}
								} 
							}
						?>
					</td>
	<!-- rank start date -->
					<td><?php echo isset($keyword['Duration'][0]['StartDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['StartDate'])) : __('No Data'); ?></td>
	<!-- rank end date -->
					<td><?php echo isset($keyword['Duration'][0]['EndDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['EndDate'])) : __('No Data'); ?></td>
	<!-- action -->
					<td class="actions">
						<!-- <div class="btn-group">
							<i class="icon-edit">
								<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])); ?>
							</i>
						</div>
						<div class="btn-group">
							<i class="icon-plus">
								<?php echo $this->Html->link(__('Extra'), array('controller' => 'extras', 'action' => 'add', $keyword['ID'])); ?>
							</i>
						</div> -->
						<a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Keyword') ?>"><i class="fa fa-edit"></i></a>
						<a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'add', $keyword['ID'])) ?>" class="label label-info" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Add Extra') ?>"><i class="fa fa-plus"></i></a>
						<?php if(isset($keyword['rankend']) && $keyword['rankend'] != 0) : ?>
						<?php else: ?>
							<?php 
								echo $this->Form->postLink(
									$this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('Set Keyword to nocontract list'))). "",
									array('controller' => 'keywords', 'action' => 'nocontract', $keyword['ID'],($keyword['nocontract']==1?0:1)),
									array('escape'=>false, 'class' => 'label label-danger'),
									__('【%s】を未契約しますか？', $keyword['ID']),
									array('class' => '')
								);
							?>
						<?php endif ?>
					</td>
				</tr>
				<?php } ?>
				<?php endforeach; ?>
	<!-- total -->
				 <?php 
					@$total = money_format('%.2n',array_sum(@$total_price));
					$rankup_percentage = (count(@$total_price)) / count($keywords) * 100;
				?>
				<tr>
					<td colspan="4" style="text-align:right;font-weight:bold">合計</td>
					<td class="price">
						<span class="label label-info">
							<?php echo $total; ?>
						</span>
					</td>
					<td class="">
						<span class="label <?php echo $rankup_percentage<100?'badge-important':'label-info'; ?>">
						<?php 
							echo round($rankup_percentage, 2) .'%';
							// echo '(' .count($total_price) .'/' . count($rankhistories) .')';
						?>
						</span>
					</td>
					<td colspan="3" </td>
				</tr>
			</table>
		</div>
	</div>
</div>

<!--hl contract limit price start group 1-->
<div class="row">
	<div class="col-xs-12">
		<div class="">
		<?php $keywords_contract = $keywords; ?>
		<?php #if( !empty($user['User']['limit_price_multi'])) : ?>
				<?php $keywords = Hash::extract($keywords_contract, '{n}[limit_price_group=1]'); $total_price1 = array()?>
				<span class="label label-warning"><?php echo __('Limit Price Group') .'1'; ?></span>
				<span data-type="text" data-name="limit_price_multi" data-pk="<?php echo $user['User']['id']; ?>" data-title="SET LIMIT PIRCE GROUP" class="limit_price_multi" style="color:red;font-weight:bold;">
					<?php echo !empty($user['User']['limit_price_multi'])? money_format('%.0n', $user['User']['limit_price_multi']):money_format('%.0n', 0) ?>
				</span>
				<table class="table tableX">
					<tr>
						<th class="tbl1"><?php echo __('ID'); ?></th>
						<th class="tbl4"><?php echo __('Keyword'); ?></th>
						<th class="tbl5"><?php echo __('Url'); ?></th>
						<th class="tbl2"><?php echo __('Google/Yahoo'); ?></th>
						<th class="tbl1"><?php echo __('Price'); ?></th>
						<th class="tbl2"><?php echo __('Rankstart'); ?></th>
						<th class="tbl2"><?php echo __('Rankend'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					<?php $i = 0; foreach ($keywords as $keyword): ?>
					<?php if($keyword['rankend'] == 0 || $keyword['rankend'] > date('Ymd', strtotime('-1 month' .date('Ymd')))) { ?>
					<tr>
		<!-- id -->
						<td><?php echo $keyword['ID']; ?></td>
		<!-- keyword -->
						<td>
							<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
							<br />
							<span class="alert-danger"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
						</td>
		<!-- url -->
						<td><?php echo $this->Html->link($this->Text->truncate($keyword['Url'], configure::read('TRUNCATE_URL')),$keyword['Url'], array('target'=>'_blank')); ?></td>
		<!-- rank -->
						<td>
							<?php 
								echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $rankhistory[$keyword['ID']] :  
									$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$keyword['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
								; 
							?>
						</td>
		<!-- price -->
						<td>
							<?php
								if ($keyword['Engine'] == 1) {
									$google_rank = $rankhistory[$keyword['ID']];
									$yahoo_rank = 0;
								} 
								elseif ($keyword['Engine'] == 2) {
									$google_rank = 0;
									$yahoo_rank = $rankhistory[$keyword['ID']];
								}else {
									$ranks = explode('/', @$rankhistory[$keyword['ID']]);
									$google_rank = @$ranks[0];
									$yahoo_rank = @$ranks[1];
								}
								
								if($google_rank==0 && $yahoo_rank!=0){
									$graph_google[] = 100;
									$graph_yahoo[] = $yahoo_rank; 
								}else if ($yahoo_rank==0 && $google_rank!=0){
									$graph_yahoo[] = 100;
									$graph_google[] = $google_rank;
								}else if ($google_rank == 0 && $yahoo_rank==0){
									$graph_google[] = 100;
									$graph_yahoo[] = 100;
								}else{
									$graph_google[] = $google_rank;
									$graph_yahoo[] = $yahoo_rank;
								}
								
								$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$keyword['ID'].']');						
								$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
								
								$data_extra = array();		
								foreach($extra as $key_extra => $value_extra) {
									if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
										$data_extra[$key_extra] = $value_extra;
									}
								}
								
								if(count($data_extra)>0){
									ksort($data_extra);
									$key_extra = array_keys($data_extra);			
									echo $data_extra[$key_extra[0]];
									$total_price1[] = $data_extra[$key_extra[0]];
								}else{
									foreach($extra as $key => $value) {
										if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
											echo isset($value) ? $value : 0;
											$total_price1[] = isset($value) ? $value : 0;
										}
									} 
								}
							?>
						</td>
		<!-- rank start date -->
						<td><?php echo isset($keyword['Duration'][0]['StartDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['StartDate'])) : __('No Data'); ?></td>
		<!-- rank end date -->
						<td><?php echo isset($keyword['Duration'][0]['EndDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['EndDate'])) : __('No Data'); ?></td>
		<!-- action -->
						<td class="actions">
							<a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Keyword') ?>"><i class="fa fa-edit"></i></a>
							<a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'add', $keyword['ID'])) ?>" class="label label-info" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Add Extra') ?>"><i class="fa fa-plus"></i></a>
							<?php if(isset($keyword['rankend']) && $keyword['rankend'] != 0) : ?>
							<?php else: ?>
								<?php 
									echo $this->Form->postLink(
										$this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('Set Keyword to nocontract list'))). "",
										array('controller' => 'keywords', 'action' => 'nocontract', $keyword['ID'],($keyword['nocontract']==1?0:1)),
										array('escape'=>false, 'class' => 'label label-danger'),
										__('【%s】を未契約しますか？', $keyword['ID']),
										array('class' => '')
									);
								?>
							<?php endif ?>
						</td>
					</tr>
					<?php } ?>
					<?php endforeach; ?>
		<!-- total -->
					 <?php 
						@$total = money_format('%.2n',array_sum(@$total_price1));
						@$rankup_percentage = (count($total_price1)) / count($keywords) * 100;
					?>
		<!-- price percentage -->
					<tr>
						<td colspan="4" style="text-align:right;font-weight:bold">合計</td>
						<td class="price">
							<span class="label label-info">
								<?php echo $total; ?>
							</span>
						</td>
						<td class="">
							<span class="label <?php echo $rankup_percentage<100?'badge-important':'label-info'; ?>">
							<?php 
								echo round($rankup_percentage, 2) .'%';
							?>
							</span>
						</td>
						<td class="limit_or_not_group1" keyID="<?php echo implode('-',Hash::extract($keywords,'{n}.ID')) ?>" limit_price="<?php echo $user['User']['limit_price_multi'] ?>">
							<span class="label badge-important group1"></span>
						</td>
						<td colspan="2" </td>
					</tr>
					<tr>
						<td colspan="6"></td>
						<td class="show_price">
							<span class="total btn btn-warning group1"></span>
						</td>
						<td colspan="2" </td>
					</tr>
				</table>
		<?php #endif; ?><!--hl end group 1 -->
		</div>
	</div>
</div>

<!--hl contract limit price start group 2 -->
<div class="row">
	<div class="col-xs-12">
		<div class="">		
		<?php if( !empty($user['User']['limit_price_multi2'])) : ?>
				<?php $keywords = Hash::extract($keywords_contract, '{n}[limit_price_group=2]'); $total_price1 = array()?>
				<span class="label label-warning"><?php echo __('Limit Price Group') .'2'; ?></span>
				<span data-type="text" data-name="limit_price_multi2" data-pk="<?php echo $user['User']['id']; ?>" data-title="SET LIMIT PIRCE GROUP" class="limit_price_multi2" style="color:red;font-weight:bold;">
					<?php echo !empty($user['User']['limit_price_multi2'])? money_format('%.0n', $user['User']['limit_price_multi2']):money_format('%.0n', 0) ?>
				</span>
				<table class="table tableX">
					<tr>
						<th class="tbl1"><?php echo __('ID'); ?></th>
						<th class="tbl4"><?php echo __('Keyword'); ?></th>
						<th class="tbl5"><?php echo __('Url'); ?></th>
						<th class="tbl2"><?php echo __('Google/Yahoo'); ?></th>
						<th class="tbl1"><?php echo __('Price'); ?></th>
						<th class="tbl2"><?php echo __('Rankstart'); ?></th>
						<th class="tbl2"><?php echo __('Rankend'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					<?php $i = 0; foreach ($keywords as $keyword): ?>
					<?php if($keyword['rankend'] == 0 || $keyword['rankend'] > date('Ymd', strtotime('-1 month' .date('Ymd')))) { ?>
					<tr>
		<!-- id -->
						<td><?php echo $keyword['ID']; ?></td>
		<!-- keyword -->
						<td>
							<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
							<br />
							<span class="alert-danger"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
						</td>
		<!-- url -->
						<td><?php echo $this->Html->link($this->Text->truncate($keyword['Url'], configure::read('TRUNCATE_URL')),$keyword['Url'], array('target'=>'_blank')); ?></td>
		<!-- rank -->
						<td>
							<?php 
								echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $rankhistory[$keyword['ID']] :  
									$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$keyword['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
								; 
							?>
						</td>
		<!-- price -->
						<td>
							<?php
								if ($keyword['Engine'] == 1) {
									$google_rank = $rankhistory[$keyword['ID']];
									$yahoo_rank = 0;
								} 
								elseif ($keyword['Engine'] == 2) {
									$google_rank = 0;
									$yahoo_rank = $rankhistory[$keyword['ID']];
								}else {
									$ranks = explode('/', $rankhistory[$keyword['ID']]);
									$google_rank = $ranks[0];
									$yahoo_rank = $ranks[1];
								}
								
								if($google_rank==0 && $yahoo_rank!=0){
									$graph_google[] = 100;
									$graph_yahoo[] = $yahoo_rank; 
								}else if ($yahoo_rank==0 && $google_rank!=0){
									$graph_yahoo[] = 100;
									$graph_google[] = $google_rank;
								}else if ($google_rank == 0 && $yahoo_rank==0){
									$graph_google[] = 100;
									$graph_yahoo[] = 100;
								}else{
									$graph_google[] = $google_rank;
									$graph_yahoo[] = $yahoo_rank;
								}
								
								$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$keyword['ID'].']');
								$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
								
								$data_extra = array();		
								foreach($extra as $key_extra => $value_extra) {
									if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
										$data_extra[$key_extra] = $value_extra;
									}
								}
								
								if(count($data_extra)>0){
									ksort($data_extra);
									$key_extra = array_keys($data_extra);
									echo $data_extra[$key_extra[0]];
									$total_price1[] = $data_extra[$key_extra[0]];
								}else{
									foreach($extra as $key => $value) {
										if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
											echo isset($value) ? $value : 0;
											$total_price1[] = isset($value) ? $value : 0;
										}
									} 
								}
							?>
						</td>
		<!-- rank start date -->
						<td><?php echo isset($keyword['Duration'][0]['StartDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['StartDate'])) : __('No Data'); ?></td>
		<!-- rank end date -->
						<td><?php echo isset($keyword['Duration'][0]['EndDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['EndDate'])) : __('No Data'); ?></td>
		<!-- action -->
						<td class="actions">
							<div class="btn-group">
								<i class="icon-edit">
									<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])); ?>
								</i>
							</div>
							<div class="btn-group">
								<i class="icon-plus">
									<?php echo $this->Html->link(__('Extra'), array('controller' => 'extras', 'action' => 'add', $keyword['ID'])); ?>
								</i>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php endforeach; ?>
		<!-- total -->
					 <?php 
						$total = money_format('%.2n',array_sum($total_price1));
						$rankup_percentage = (count($total_price1)) / count($keywords) * 100;
					?>
		<!--hl price percentage -->
					<tr>
						<td colspan="4" style="text-align:right;font-weight:bold">合計</td>
						<td class="price">
							<span class="label label-info">
								<?php echo $total; ?>
							</span>
						</td>
						<td class="">
							<span class="label <?php echo $rankup_percentage<100?'badge-important':'label-info'; ?>">
							<?php 
								echo round($rankup_percentage, 2) .'%';
							?>
							</span>
						</td>
						<td class="limit_or_not_group2" keyID="<?php echo implode('-',Hash::extract($keywords,'{n}.ID')) ?>" limit_price="<?php echo $user['User']['limit_price_multi2'] ?>">
							<!--hl 上限お知らせ 　-->
							<span class="label badge-important group2"></span>
						</td>
						<td colspan="2" </td>
					</tr>
					<tr>
						<td colspan="6"></td>
						<!--hl 請求Price -->
						<td class="show_price">
							<span class="total btn btn-warning group2"></span>
						</td>
						<td colspan="2" </td>
					</tr>
				</table>
		<?php endif; ?><!--hl end group 2 -->
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="">			
		<!--hl contract limit price start group 3-->
		<?php if( !empty($user['User']['limit_price_multi3'])): ?>
				<?php $keywords = Hash::extract($keywords_contract, '{n}[limit_price_group=3]'); $total_price1 = array()?>
				<span class="label label-warning"><?php echo __('Limit Price Group') .'3'; ?></span>
				<span data-type="text" data-name="limit_price_multi3" data-pk="<?php echo $user['User']['id']; ?>" data-title="SET LIMIT PIRCE GROUP" class="limit_price_multi3" style="color:red;font-weight:bold;">
					<?php echo !empty($user['User']['limit_price_multi3'])? money_format('%.0n', $user['User']['limit_price_multi3']):money_format('%.0n', 0) ?>
				</span>
				<table class="table tableX">
					<tr>
						<th class="tbl1"><?php echo __('ID'); ?></th>
						<th class="tbl4"><?php echo __('Keyword'); ?></th>
						<th class="tbl5"><?php echo __('Url'); ?></th>
						<th class="tbl2"><?php echo __('Google/Yahoo'); ?></th>
						<th class="tbl1"><?php echo __('Price'); ?></th>
						<th class="tbl2"><?php echo __('Rankstart'); ?></th>
						<th class="tbl2"><?php echo __('Rankend'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					<?php $i = 0; foreach ($keywords as $keyword): ?>
					<?php if($keyword['rankend'] == 0 || $keyword['rankend'] > date('Ymd', strtotime('-1 month' .date('Ymd')))) { ?>
					<tr>
						<td><?php echo $keyword['ID']; ?></td>
						<td>
							<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
							<br />
							<span class="alert-danger"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
						</td>
						<td><?php echo $this->Html->link($keyword['Url'],$keyword['Url'], array('target'=>'_blank')); ?></td>
						<td>
							<?php 
								echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $rankhistory[$keyword['ID']] :  
									$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$keyword['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
								; 
							?>
						</td>
						<td>
							<?php
								if ($keyword['Engine'] == 1) {
									$google_rank = $rankhistory[$keyword['ID']];
									$yahoo_rank = 0;
								} 
								elseif ($keyword['Engine'] == 2) {
									$google_rank = 0;
									$yahoo_rank = $rankhistory[$keyword['ID']];
								}else {
									$ranks = explode('/', $rankhistory[$keyword['ID']]);
									$google_rank = $ranks[0];
									$yahoo_rank = $ranks[1];
								}
								
								if($google_rank==0 && $yahoo_rank!=0){
									$graph_google[] = 100;
									$graph_yahoo[] = $yahoo_rank; 
								}else if ($yahoo_rank==0 && $google_rank!=0){
									$graph_yahoo[] = 100;
									$graph_google[] = $google_rank;
								}else if ($google_rank == 0 && $yahoo_rank==0){
									$graph_google[] = 100;
									$graph_yahoo[] = 100;
								}else{
									$graph_google[] = $google_rank;
									$graph_yahoo[] = $yahoo_rank;
								}
								
								$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$keyword['ID'].']');
								$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
								
								$data_extra = array();		
								foreach($extra as $key_extra => $value_extra) {
									if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
										$data_extra[$key_extra] = $value_extra;
									}
								}
								
								if(count($data_extra)>0){
									ksort($data_extra);
									$key_extra = array_keys($data_extra);
									echo $data_extra[$key_extra[0]];
									$total_price1[] = $data_extra[$key_extra[0]];
								}else{
									foreach($extra as $key => $value) {
										if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
											echo isset($value) ? $value : 0;
											$total_price1[] = isset($value) ? $value : 0;
										}
									} 
								}
							?>
						</td>
						<td><?php echo isset($keyword['Duration'][0]['StartDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['StartDate'])) : __('No Data'); ?></td>
						<td><?php echo isset($keyword['Duration'][0]['EndDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['EndDate'])) : __('No Data'); ?></td>
						<td class="actions">
							<div class="btn-group">
								<i class="icon-edit">
									<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])); ?>
								</i>
							</div>
							<div class="btn-group">
								<i class="icon-plus">
									<?php echo $this->Html->link(__('Extra'), array('controller' => 'extras', 'action' => 'add', $keyword['ID'])); ?>
								</i>
							</div>
						</td>
					</tr>
					<?php } ?>
					<?php endforeach; ?>
		<!-- total -->
					 <?php 
						$total = money_format('%.2n',array_sum($total_price1));
						$rankup_percentage = (count($total_price1)) / count($keywords) * 100;
					?>
					<tr>
						<td colspan="4" style="text-align:right;font-weight:bold">合計</td>
						<td class="price">
							<span class="label label-info">
								<?php echo $total; ?>
							</span>
						</td>
						<td class="">
							<span class="label <?php echo $rankup_percentage<100?'badge-important':'label-info'; ?>">
							<?php 
								echo round($rankup_percentage, 2) .'%';
							?>
							</span>
						</td>
						<td class="limit_or_not_group3" keyID="<?php echo implode('-',Hash::extract($keywords,'{n}.ID')) ?>" limit_price="<?php echo $user['User']['limit_price_multi3'] ?>">
							<span class="label badge-important group3"></span>
						</td>
						<td colspan="2" </td>
					</tr>
					<tr>
						<td colspan="6"></td>
						<td class="show_price">
							<span class="total btn btn-warning group3"></span>
						</td>
						<td colspan="2" </td>
					</tr>
				</table>
		<?php endif; ?><!--hl end group 3 -->
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="">	
		<!-- no contract -->
				<?php	$keywords = Hash::extract($user['Keyword'], '{n}[nocontract=1]');?>
				<h3><span class="label label-default"><?php echo __('No Contract Keyword'); ?></span></h3>
				<table class="table tableX">
					<tr>
						<th class="tbl1"><?php echo __('ID'); ?></th>
						<th class="tbl4"><?php echo __('Keyword'); ?></th>
						<th class="tbl5"><?php echo __('Url'); ?></th>
						<th class="tbl3"><?php echo __('Google/Yahoo'); ?></th>
						<th class="tbl3"><?php echo __('Rankstart'); ?></th>
						<th class="tbl3"><?php echo __('Rankend'); ?></th>
						<th class="actions"><?php echo __('Actions'); ?></th>
					</tr>
					<?php
						$i = 0;
						foreach ($keywords as $keyword): ?>
						<tr>
							<td><?php echo $keyword['ID']; ?></td>
							<td>
								<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
								<br />
								<span class="alert-danger"><?php echo ($keyword['rankend'] != 0) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>  
							</td>
							<td><?php echo $this->Html->link($keyword['Url'],$keyword['Url'], array('target'=>'_blank')); ?></td>
							<td>
								<?php 
									echo isset($rankhistory[$keyword['ID']])?$rankhistory[$keyword['ID']] : 
										$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$keyword['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
									; 
								?>
							</td>
							<td><?php echo isset($keyword['Duration'][0]['StartDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['StartDate'])) : __('No Data'); ?></td>
							<td><?php echo isset($keyword['Duration'][0]['EndDate']) ? strftime('%Y-%m-%d', strtotime($keyword['Duration'][0]['EndDate'])) : __('No Data'); ?></td>
							<td class="actions">
								<a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $keyword['ID'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Keyword') ?>"><i class="fa fa-edit"></i></a>
								<a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'add', $keyword['ID'])) ?>" class="label label-info" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Add Extra') ?>"><i class="fa fa-plus"></i></a>
								<?php if(isset($keyword['rankend']) && $keyword['rankend'] != 0) : ?>
								<?php else: ?>
									<?php 
										echo $this->Form->postLink(
											$this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('Set Keyword to nocontract list'))). "",
											array('controller' => 'keywords', 'action' => 'nocontract', $keyword['ID'],($keyword['nocontract']==1?0:1)),
											array('escape'=>false, 'class' => 'label label-danger'),
											__('【%s】を未契約しますか？', $keyword['ID']),
											array('class' => '')
										);
									?>
								<?php endif ?>
							</td>
						</tr>
						<?php endforeach; ?>
				</table>
			<?php endif; ?>
		</div>
	</div>
</div>

<?php echo $this->element('modal/set_all_keyword_enddate', array('user_id' => $user['User']['id'], 'keywords' => Hash::extract($user['Keyword'], '{n}[nocontract=0]'))); ?>

<?php
	echo $this->Html->css('bootstrap-editable');
	echo $this->Html->script(array('jquery.mockjax','bootstrap-editable'));
?>

<script type="text/javascript">
	$(document).ready(function(){
		// limit or not group 1
		$.ajax({
			url:'<?php echo $this->webroot ?>users/limit_or_not',
			data:{keyID:$('.limit_or_not_group1').attr('KeyID'),limit_price:$('.limit_or_not_group1').attr('limit_price')},
			type:'POST',
			sync: true,
			dataType: 'json',
			success:function(data){			
				$('.limit_or_not_group1 .group1').html(data.limit_or_not);
				$('.show_price .group1').html(data.limit_price);
			}
		})
		
		// limit or not group 2
		$.ajax({
			url:'<?php echo $this->webroot ?>users/limit_or_not',
			data:{keyID:$('.limit_or_not_group2').attr('KeyID'),limit_price:$('.limit_or_not_group2').attr('limit_price')},
			type:'POST',
			sync: true,
			dataType: 'json',
			success:function(data){
				$('.limit_or_not_group2 .group2').html(data.limit_or_not);
				$('.show_price .group2').html(data.limit_price);
			}
		})
		
		// limit or not group 3
		$.ajax({
			url:'<?php echo $this->webroot ?>users/limit_or_not',
			data:{keyID:$('.limit_or_not_group3').attr('KeyID'),limit_price:$('.limit_or_not_group3').attr('limit_price')},
			type:'POST',
			sync: true,
			dataType: 'json',
			success:function(data){
				$('.limit_or_not_group3 .group3').html(data.limit_or_not);
				$('.show_price .group3').html(data.limit_price);
			}
		})
		
		// set limit price multi
		$.fn.editable.defaults.mode = 'inline';
	
		$('.limit_price_multi').editable({  
			url: '<?php echo $this->webroot ?>users/limit_price_multi',		
			display: function(value) {
	
			},
			validate: function(value) {
				if(!is_number($.trim(value))) {
					return 'This field is numberic.';
				}
			},
			ajaxOptions: {
				type: 'post'
			},
			success: function(response, newValue) {
				window.location.reload(true);
			}
		});
		
		function is_number(num) {
			var numberRegex = /^[+-]?\d+(\.\d+)?([eE][+-]?\d+)?$/;
			return numberRegex.test(num);
		}
		
		// load rank
		$('.loadRank').click(function(){
			var keyID = $(this).attr('KeyID');
			console.log(keyID);
			var loading = $(this).next();
			loading.show();
			$('.loadRank').hide();
			$.ajax({
				url:'<?php echo $this->webroot ?>keywords/load_rank_one',
				data:{keyID:keyID},
				type:'POST',
				success:function(data){
					loading.hide();
					window.location.reload(true);
				}
			})
		})
	})
</script>