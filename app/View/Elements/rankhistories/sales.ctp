<?php #echo $this->element($this->params['controller'] .'/header') ?>

<div class="row">
	<div class="col-xs-12">
		<div class="">
				<?php 
					if($this->params['pass']) {
						if($this->params['pass'][1] == 10) {
							$label = 'label label-info';
						} elseif(($this->params['pass'][1] == 20)) {
							$label = 'label label-warning';
						} else {
							$label = 'label label-default';
						} 
					} else {
						$label = 'label label-default';
					}
				?>
				<span class="<?php echo $label; ?>">キーワード数：<?php echo count($rankhistories); ?></span>
				<!-- csv download -->
				<?php 
					echo $this->Html->link(__('CSV'), array(
						'controller' => 'rankhistories', 
						'action' => 'csv_all_keyword', 
						isset($this->params['pass'][1]) ? $this->params['pass'][1] : 1,
						isset($rankDate) ? $rankDate : date('Ymd'),
						1 // sales list
					)); 
				?>
			<div class="box-body table-responsive no-padding">
				<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
					<thead>
						<tr>
							<th class=""><?php echo __('#'); ?></th>
							<th class=""><?php echo __('Keyword') .'/' .__('Url'); ?></th>
							<th class="tbl2"><?php echo __('Rank') .__('PC'); ?></th>
							<th class=""><?php echo __('Company'); ?></th>
							<th class=""><?php echo __('Price'); ?></th>
							<th class=""><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($rankhistories as $rankhistory): ?>
						<?php $params = json_decode($rankhistory['Rankhistory']['params'],true) ?>
						<tr style="background:<?php echo $params['color'] ?>">
							<td><?php echo $rankhistory['Keyword']['ID']; ?></td>
							<!-- keyword -->
							<td style="<?php echo !empty($rankhistory['Keyword']['nocontract'])?'color:red':'' ?>">
								<?php echo ( isset($rankhistory['Keyword']['limit_price']) && $rankhistory['Keyword']['limit_price'] != 0)? '<span class="label label-warning">上限:' .money_format('%n',$rankhistory['Keyword']['limit_price']) .'</span>' : ''; ?>
								<?php echo $this->Html->link($rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID']),array('style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); ?>
								<span class="alert-danger"><?php echo (isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0)? '(' .__('Keyword Cancel Estimate') .' ' .$rankhistory['Keyword']['rankend'] .')' : '';?></span>
								<?php echo ($rankhistory['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
								<?php 
									echo ($rankhistory['Rankhistory']['Rank'] == '') ? 
									'<div class="new-line"></div>' .$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-sm btn-danger','KeyID'=>$rankhistory['Keyword']['ID'])) 
									.$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
									: ''; 
								?>&nbsp;
								<div class="new-line"></div>
								<!-- url -->
								<?php echo $rankhistory['Keyword']['Strict']==1 ? '<span class="label label-info">完全一致</span>' : '<span class="label label-default">通常一致</span>'; ?>
								<?php echo $this->Html->link($this->Text->truncate($rankhistory['Keyword']['Url'],30), $rankhistory['Keyword']['Url'], array('target'=>'_blank')); ?>&nbsp;
							</td>
							<!-- engine rank -->
							<td>
								<div style="float: left;" class="edit_inline" data-name="Rank" data-pk="<?php echo $rankhistory['Rankhistory']['ID']; ?>">
									<?php echo $rankhistory['Rankhistory']['Rank']; ?>&nbsp;
								</div>
								<span class="arrow_row"><?php echo $params['arrow'] ?></span>
								<div class="new-line" style="clear: both;"></div>
								<?php 
									global $list_engine;
									echo h(@$list_engine[$rankhistory['Keyword']['Engine']]);
								?>&nbsp;
							</td>
<!-- company -->
							<td>
								<?php echo (isset($rankhistory['Keyword']['limit_price_group']) && $rankhistory['Keyword']['limit_price_group'] != 0) ? '<span class="label label-warning">グループ上限</span>' : ''; ?>
								<?php echo $this->Html->link($this->Text->truncate($user[$rankhistory['Keyword']['UserID']], 15), array('controller' => 'users', 'action' => 'view', $rankhistory['Keyword']['UserID'])); ?>
								<div class="new-line"></div>
							</td>
<!-- price -->
							<td>
								<?php
									if ($rankhistory['Keyword']['Engine'] == 1) {
										$google_rank = $rankhistory['Rankhistory']['Rank'];
										$yahoo_rank = 0;
									} 
									elseif ($rankhistory['Keyword']['Engine'] == 2) {
										$google_rank = 0;
										$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
									}else {
										$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
										$google_rank = $ranks[0];
										@$yahoo_rank = $ranks[1];
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
									
									$data_extra = array();
									$extra_keyID = Hash::extract($extras,'{n}.Extra[KeyID='.$rankhistory['Keyword']['ID'].']');						
									$extra = Hash::combine($extra_keyID,'{n}.ExtraType','{n}.Price');
									foreach($extra as $key_extra => $value_extra) {
										if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
											$data_extra[$key_extra] = $value_extra;
										}
									}
									
									if(count($data_extra)>0){
										ksort($data_extra);
										$key_extra = array_keys($data_extra);
										$sales = $data_extra[$key_extra[0]] - $rankhistory['Keyword']['cost'];
										echo money_format('%.2n',$sales);
										$total_price[] = $sales;
									}else{
										foreach($extra as $key => $value) {
											if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
												$sales = isset($value) ? $value - $rankhistory['Keyword']['cost'] : 0;
												echo money_format('%.2n',isset($value) ? $value : 0);
												$total_price[] = $sales;
											}
										} 
									}
								?>
							</td>
<!-- actions -->
							<td class="actions">
								<a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $rankhistory['Keyword']['ID'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Keyword') ?>"><i class="fa fa-edit"></i></a>
								<a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'add', $rankhistory['Keyword']['ID'])) ?>" class="label label-info" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Add Extra') ?>"><i class="fa fa-plus"></i></a>
								<?php if(isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0) : ?>
								<?php else: ?>
									<?php 
										echo $this->Form->postLink(
											$this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('Set Keyword to nocontract list'))). "",
											array('controller' => 'keywords', 'action' => 'nocontract', $rankhistory['Keyword']['ID'],($rankhistory['Keyword']['nocontract']==1?0:1)),
											array('escape'=>false, 'class' => 'label label-danger'),
											__('【%s】を未契約しますか？', $rankhistory['Keyword']['ID']),
											array('class' => '')
										);
									?>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
					<!-- total -->
					<?php 
						@$total = money_format('%.2n',array_sum(@$total_price));
						@$rankup_percentage = (count(@$total_price)) / count($rankhistories) * 100;
					?>
					<tr>
						<td colspan="4" style="text-align:right;font-weight:bold">合計(<?php echo count(@$total_price) .'/' .count($rankhistories); ?>)</td>
						<td class="total">
							<h2><span class="label label-info">
								<?php echo $total; ?>
							</span></h2>
						</td>
						<td class="">
							<h2>
								<span class="label <?php echo $rankup_percentage<100?'label-danger':'label-success'; ?>">
									<?php echo round($rankup_percentage, 2) .'%';?>
								</span>
							</h2>
						</td>
					</tr>
					<tr>
					</tr>
				</table>
			</div>
		</div><!-- box -->
	</div>
</div>

<?php #echo $this->Html->link(__('Set Endate to All Keyword'), '#myModalEnableKeyword', array('data-toggle'=>'modal','role'=>'button','class' => "btn btn-danger")); ?>
<?php #echo $this->element('modal/set_all_keyword_enddate', array()); ?>

<?php echo $this -> Html -> script(array('bootstrap-editable')); ?>
<?php echo $this->Html->css(array('bootstrap-editable'));?>
<script type="text/javascript">
	$(document).ready(function(){
		//editables 
		$.fn.editable.defaults.mode = 'inline';
		$('.edit_inline').editable({
			   url: '<?php echo $this->webroot.'keywords/edit_inline' ?>',
			   type: 'text',
			   name: $(this).attr('name'),
			   title: 'Edit '+$(this).attr('name')
		});		
		//
		// $('.loadRank').click(function(){
			// var keyID = $(this).attr('KeyID');
			// var loading = $(this).next();
			// loading.show();
			// $.ajax({
				// url:'<?php echo $this->webroot ?>keywords/load_rank_one',
				// data:{keyID:keyID},
				// type:'POST',
				// success:function(data){
					// loading.hide();
					// window.location.reload(true);
				// }
			// })
		// })
		
		// tooltip
		// $("a[rel=tooltip]").tooltip({placement:'up'});
		$('[data-toggle="tooltip"]').tooltip({placement:'top'});
		
		// instant search
		// $('#example').DataTable({
			// paging: false,
			// ordering:  false
		// });
		// $('#table_id').DataTable();
	})
</script>
