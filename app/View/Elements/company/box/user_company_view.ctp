<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
			<h3 class="brand">
				<?php  echo $user['User']['company'];?>
				<?php echo ($user['User']['agent'] == 0) ? '' : '(' .__('Agent') .')';?>
			</h3>
		</div>
	</div>
	<div class="section">
		<?php echo $this->Session->flash(); ?>
		<div class="keyword-add">
			<?php echo $this->Html->link(__('Edit Company'), array('controller' => 'users' , 'action' => 'edit', $user['User']['id']), array('class' => "btn btn-success")); ?>
		</div>
		<div class="keyword-add">
			<?php echo $this->Html->link(__('Add Keyword'), array('controller' => 'keywords' , 'action' => 'add', $user['User']['id']), array('class' => "btn btn-warning")); ?>
		</div>
		<div class="keyword-add">
			<?php echo ($user['User']['agent'] == 0) ? $this->Html->link(__('Agent Set'), array('controller' => 'users' , 'action' => 'agent_set', $user['User']['id']), array('class' => "btn")) : ''; ?>
		</div>
		<table class="table tableX">
			<tr>
				<th><?php echo __('Name'); ?></th>
				<td>
					<?php echo h($user['User']['name']); ?>&nbsp;
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
			<tr>
				<th><?php echo __('Fax'); ?></th>
				<td>
					<?php echo h($user['User']['fax']); ?>&nbsp;
				</td>
			</tr>
		</table>
		<a href="<?php echo FULL_BASE_URL .CLIENT_PATH ?>/users/autologin/<?php echo 'email:'.base64_encode($user['User']['email']) .'/pass:' .$user['User']['pwd']; ?>" class="label label-info" target="_blank"><?php echo __('Go to this client view') ?></a>
	</div>
</div>

<div class="box admin_statuses span12">
	<div class="navbar">
		<div class="navbar-inner">
			<h3 class="brand"><?php  echo __('Keyword');?></h3>
		</div>
	</div>
	<div class="section related">
<!-- kaiyaku set end date -->
		<div class="keyword-add">
			<?php echo $this->Html->link(__('Set Endate to All Keyword'), '#myModalEnableKeyword', array('data-toggle'=>'modal','role'=>'button','class' => "btn btn-danger")); ?>
		</div>
		<div class="new-line"></div>
<!-- search history form -->
		<?php 
			echo $this->Form->create('Rankhistory',array('class'=>'form-search'));
			$current_year = date('Y'); 
			echo $this->Form->input('rankDate',array('type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'), 'maxYear'=>$current_year, 'minYear'=>$current_year-2, 'div'=>FALSE)); 
			echo $this->Form->button(__('Choose'), array('class'=>'btn btn-success'));
			echo $this->Form->end();
		?>
		<?php if (!empty($user['Keyword'])): ?>
<!--hl start contract -->
		<?php $keywords = Hash::extract($user['Keyword'], '{n}[nocontract=0]');?>
		<span class="label label-success"><?php echo __('Contract Keyword'); ?></span>
		<span class=""><?php echo count($keywords); ?></span>
		<div class="fright">
			<span class="btn btn-default set_c_logic" company_id="<?php echo $this->request->params['pass'][0]; ?>">✔</span>
			<span class="btn btn-default unset_c_logic" company_id="<?php echo $this->request->params['pass'][0]; ?>">×</span>
		</div>
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
					<!-- group -->
					<?php echo ($keyword['limit_price_group'] != 0) ? '<span class="label label-warning">'.$keyword['limit_price_group'] .'</span>' : '' ?>
					<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
					<?php echo ($keyword['c_logic'] != 0) ? '<span class="label label-default">✔</span>' : '' ?>
					<br />
					<span class="kaiyaku"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
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

<?php $keywords_contract = $keywords; ?>
<!--hl contract limit price start group 1-->
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
					<span class="kaiyaku"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
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

<!--hl contract limit price start group 2 -->
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
					<span class="kaiyaku"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
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
<!-- id -->
				<td><?php echo $keyword['ID']; ?></td>
<!-- keyword -->
				<td>
					<?php echo $this->Html->link($keyword['keyword'], array('controller' => 'keywords', 'action' => 'view', $keyword['ID'])); ?>
					<br />
					<span class="kaiyaku"><?php echo ($keyword['rankend'] != 0 && $keyword['rankend'] <= date('Ymd')) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>
				</td>
<!-- url -->
				<td><?php echo $this->Html->link($keyword['Url'],$keyword['Url'], array('target'=>'_blank')); ?></td>
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
<!-- no contract -->
		<?php	$keywords = Hash::extract($user['Keyword'], '{n}[nocontract=1]');?>
		<span class="label label-inverse"><?php echo __('No Contract Keyword'); ?></span>
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
						<span class="kaiyaku"><?php echo ($keyword['rankend'] != 0) ? __('Keyword Cancel Date') .$keyword['rankend'] : ''; ?></span>  
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
				<?php endforeach; ?>
		</table>
	<?php endif; ?>
	</div>
</div>
<?php echo $this->element('modal/set_all_keyword_enddate', array('user_id' => $user['User']['id'], 'keywords' => Hash::extract($user['Keyword'], '{n}[nocontract=0]'))); ?>
<?php
	echo $this->Html->css('bootstrap-editable');
	echo $this->Html->script(array('jquery.mockjax','bootstrap-editable'));
?>
<script type="text/javascript">
$(document).ready(function(){
	//set_c_logic or unset_c_logic
	$('.set_c_logic, .unset_c_logic').click(function(){
		var company = $(this).attr('company_id');
		var value = 0;
		if($(this).hasClass('set_c_logic')){
			value = 1;
		}
		$.ajax({
			url:'<?php echo $this->webroot ?>keywords/set_all_c_logic',
			data:{value:value, company:company},
			type:'POST',
			sync: true,
			dataType: 'json',
			success:function(data){			
				window.location.reload(true);
			}
		})		
	});
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