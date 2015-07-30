<?php echo $this->element($this->params['controller'] .'/header') ?>

<!-- chart -->

<div class="row">
	<div class="col-md-12">
		<!-- LINE CHART -->
		<div class="box box-info">
			<!-- <div class="box-header">
				<h3 class="box-title"><?php echo __('Line Chart'); ?></h3>
			</div> -->
			<div class="box-body chart-responsive">
				 <div id="line_top_x"></div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
		
	</div>
</div>

<div class="row">
	<div class="col-md-6">
		<!-- AREA CHART -->
		<div class="box box-primary">
			<!-- <div class="box-header">
				<h3 class="box-title"><?php echo __('Area Chart'); ?></h3>
			</div> -->
			<div class="box-body chart-responsive">
				<div id="piechart" style="width: 500px; height: 500px;"></div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
	<div class="col-md-6">
		<!-- COLUMN CHART -->
		<div class="box box-primary">
			<!-- <div class="box-header">
				<h3 class="box-title"><?php echo __('Colum Chart'); ?></h3>
			</div> -->
			<div class="box-body chart-responsive">
				<div id="columnchart_material" style="width: 500px; height: 500px;"></div>
			</div><!-- /.box-body -->
		</div><!-- /.box -->
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="box">
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
				<?php echo $this->Html->link(__('CSV'), array('class' => 'label' , 'controller' => 'rankhistories', 'action' => 'csv_all_keyword', isset($this->params['pass'][1])?$this->params['pass'][1]:'')); ?>
			<div class="box-body table-responsive no-padding">
				<!-- table -->
				<table class="table">
					<tr>
						<th class=""><?php echo __('KeyID'); ?></th>
						<th class=""><?php echo __('Keyword') .'/' .__('Url'); ?></th>
						<th class="tbl2"><?php echo __('Rank'); ?></th>
						<th class=""><?php echo __('Company'); ?></th>
						<th class=""><?php echo __('Price'); ?></th>
						<th class=""><?php echo __('Actions'); ?></th>
					</tr>
					<?php foreach ($rankhistories as $rankhistory): ?>
						<?php $params = json_decode($rankhistory['Rankhistory']['params'],true) ?>
						<tr style="background:<?php echo $params['color'] ?>">
							<td><?php echo $rankhistory['Keyword']['ID']; ?></td>
							<!-- keyword -->
							<td style="<?php echo !empty($rankhistory['Keyword']['nocontract'])?'color:red':'' ?>">
								<?php echo $rankhistory['Keyword']['limit_price'] != 0 ? '<span class="label label-warning">上限:' .money_format('%n',$rankhistory['Keyword']['limit_price']) .'</span>' : ''; ?>
								<?php echo $this->Html->link($rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID']),array('style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); ?>
								<span class="kaiyaku"><?php echo (isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0)? '(' .__('Keyword Cancel Estimate') .' ' .$rankhistory['Keyword']['rankend'] .')' : '';?></span>
								<?php echo ($rankhistory['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
								<?php 
									echo ($rankhistory['Rankhistory']['Rank'] == '') ? 
									'<div class="new-line"></div>' .$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$rankhistory['Keyword']['ID'])) 
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
								<?php
									echo $rankhistory['Rankhistory']['Rank'];
									
									// Show yahoo rank
									// if (strpos($rankhistory['Rankhistory']['Rank'], '/') == False) {
										// echo $rankhistory['Rankhistory']['Rank'];
									// } else {
										// $rank = explode('/', $rankhistory['Rankhistory']['Rank']);
										// if(@$rank[0] == 0): echo @$rank[1] .'/' .@$rank[1];
										// else: echo @$rank[0] .'/' .@$rank[1];
										// endif;
									// }
								?>&nbsp;
								<?php 
									global $list_engine;
									echo h(@$list_engine[$rankhistory['Keyword']['Engine']]);
								?>&nbsp;
								<span class="arrow_row"><?php echo $params['arrow'] ?></span>
							</td>
							<!-- company -->
							<td>
								<?php echo $rankhistory['Keyword']['limit_price_group'] != 0 ? '<span class="label label-warning">グループ上限</span>' : ''; ?>
								<?php echo $this->Html->link($this->Text->truncate($user[$rankhistory['Keyword']['UserID']], 13), array('controller' => 'users', 'action' => 'view', $rankhistory['Keyword']['UserID'])); ?>
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
										echo money_format('%.2n',$data_extra[$key_extra[0]]);
										$total_price[] = $data_extra[$key_extra[0]];
									}else{
										foreach($extra as $key => $value) {
											if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
												echo money_format('%.2n',isset($value) ? $value : 0);
												$total_price[] = isset($value) ? $value : 0;
											}
										} 
									}
								?>
							</td>
							<!-- actions -->
							<td class="actions">
								<a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $rankhistory['Keyword']['ID'])) ?>" class=""><i class="fa fa-edit"></i></a>
								<a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'add', $rankhistory['Keyword']['ID'])) ?>" class=""><i class="fa fa-plus"></i></a>
								<?php if(isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0) : ?>
								<?php else: ?>
									<?php 
										// echo $this->Form->postLink('', 
											// array('controller' => 'keywords', 'action' => 'nocontract', $rankhistory['Keyword']['ID'],($rankhistory['Keyword']['nocontract']==1?0:1)),
											// array('class' => 'label-danger'),
											// __('【%s】を未契約しますか？', $rankhistory['Keyword']['ID'])
										// ); 
									?>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach; ?>
					<?php 
						@$total = money_format('%.2n',array_sum(@$total_price));
						@$rankup_percentage = (count(@$total_price)) / count($rankhistories) * 100;
					?>
					<tr>
						<td colspan="4" style="text-align:right;font-weight:bold">合計</td>
						<td class="total">
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
					</tr>	
				</table>
			</div>
		</div><!-- box -->
	</div>
</div>

<?php #echo $this->Html->link(__('Set Endate to All Keyword'), '#myModalEnableKeyword', array('data-toggle'=>'modal','role'=>'button','class' => "btn btn-danger")); ?>
<?php #echo $this->element('modal/set_all_keyword_enddate', array()); ?>

<script type="text/javascript">
$(document).ready(function(){
	$('.loadRank').click(function(){
		var keyID = $(this).attr('KeyID');
		var loading = $(this).next();
		loading.show();
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