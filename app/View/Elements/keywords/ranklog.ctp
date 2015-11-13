<?php global $current_date; global $current_first_date; global $current_year; $group_rank = array();$group_extra = array() ?>
<div class="row">
	<div class="col-xs-12">
		<div class="">
			<?php echo $this->Session->flash(); ?>
			<?php $keyword_type = $this->Layout->keywordType($keyword['Keyword']['seika'], $keyword['Keyword']['service'], $keyword['Keyword']['nocontract']); ?>
			<div class="col-md-6 alert alert-<?php echo $keyword_type['class'] ?>">
				<h4>
					<?php echo $this->Html->link($keyword['User']['company'], array('controller' => 'users', 'action' => 'view', $keyword['User']['id'])); ?>
				</h4>
				<?php 
					echo ($today_rank == 0) ? 
						$this->Html->link(
						__('Load Today Rank'), 
						'javascript:void(0)',
						array('class'=>'loadRank btn btn-danger', 'KeyID'=>$keyword['Keyword']['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none')) : '';
				?>
				<h3>
					<span class="label label-<?php echo $keyword_type['class'] ?>"><?php echo __($keyword_type['text']) ?></span>
					<?php echo $this->Html->link($keyword['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'edit', $keyword['Keyword']['ID'])); ?>
					<span class="kaiyaku">
					<?php
						if($keyword['Keyword']['rankend'] != 0){
							if($keyword['Keyword']['rankend'] < date('Ymd')) {
								echo __('Keyword Cancel Date') .' ' .$keyword['Keyword']['rankend'];
							} else {
								echo __('Keyword Cancel Estimate') .' ' .$keyword['Keyword']['rankend'];
							}
						}
					?>
				</h3>
				
				</span>
				<h5><?php echo $this->Html->link($this->Text->truncate($keyword['Keyword']['Url'], 35), $keyword['Keyword']['Url'], array('target' => '_blank')); ?></h5>
			</div>
			<div class="col-md-4 navbar-right">
				<!-- load rank -->
				<?php echo $this->Html->link(__('CSV'), array('controller' => 'rankhistories', 'action' => 'csv_by_keyword',$keyword['Keyword']['ID']), array('class' => 'btn btn-success btn-sm')); ?>
				<?php echo $this->Session->read('Auth.User.user.role')==2 ? $this->Html->link(__('Load Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger btn-sm','KeyID'=>$keyword['Keyword']['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none')):''; ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="">
			<!-- rank data history -->
			<div class="col-md-6">
				<span class="label label-default"><?php echo __('History rank data'); ?></span>
				<?php echo $this->Form->create('Rankhistory',array('class'=>'form-search','id'=>'RankhistoryViewForm_list')); ?>
				<?php echo $this->Form->input('data_rank_history',array('type'=>'hidden','value'=>1));?>
				<?php 
					echo $this->Form->input('RankDate_list', array(
						'div' => FALSE,
						'label' => FALSE,
						'class'=>'input-sm',
						'type'=>'date',
						'dateFormat' => 'YM',
						'monthNames'=>Configure::read('monthNames'),
						'maxYear'=> $current_year,
						'minYear'=>$current_year-2
					));
				?>
				<?php 
					echo $this->Form->input('show_by_year', array(
						'div' => FALSE,
						'label' => __('Show Year'),
						'type' => 'checkbox',
						'value' => 1
					));
				?>
				<?php echo '&nbsp'; ?>
				<?php echo $this->Form->submit('実行',array('class'=>'btn btn-info btn-sm', 'div' => FALSE)); ?>
				<?php echo $this->Form->end() ?>
			</div>
		
			<div class="col-md-6">
				<?php if(!isset($this->request->params['named']['page'])) : ?>
				<span class="label label-info"><?php echo __('Choose date range'); ?></span>
				<?php echo $this->Form->create('Rankhistory',array('class'=>'form-search')); ?>
				<?php 
					echo $this->Form->input('RankDate1', array(
						'div' => FALSE,
						'label' => FALSE,
						'class'=>'input-sm',
						'type'=>'date',
						'dateFormat'=>'YMD',
						'minYear'=>$current_year-2,
						'maxYear'=>$current_year,
						'monthNames'=>Configure::read('monthNames'),
						'after'=>$this->Form->input('RankDate2', array(
							'type'=>'date',
							'label'=>'~',
							'class'=>'input-sm',
							'dateFormat'=>'YMD',
							'minYear'=>$current_year-2,
							'maxYear'=>$current_year, 
							'monthNames'=>Configure::read('monthNames'),
							'div'=> False
						))
					));
				?>
				<?php echo $this->Form->button(__('Choose'), array('class'=>'btn btn-info btn-sm', 'div'=>FALSE)); ?>
				<?php echo $this->Form->end(); ?>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-12">
		<div class="newline">&nbsp;</div>
		<div class="col-md-6">
			<?php echo $this->Html->link(__('1~10'), array('controller' => 'keywords', 'action' => 'view',$keyword['Keyword']['ID'], 10), array('class' => 'btn btn-success btn-sm')); ?>
			<?php echo $this->Html->link(__('キーワード特別条件'), array('controller' => 'extras', 'action' => 'add', $keyword['Keyword']['ID']), array('class' => 'btn btn-warning btn-sm')); ?>
		</div>
	</div>
</div>
	
<div class="row">
	<div class="col-xs-12">
		<div class="">
			<!-- table -->
			<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
				<tr>
					<th class="tbl3"><?php echo __('RankDate'); ?> <span class="label label-default"><?php echo count($data_rankhistories).'日' ?></span></th>
					<th class="tbl3">
						<?php 
							global $list_engine;
							echo h($list_engine[$keyword['Keyword']['Engine']]);
						?>
					</th>
					<th class="tbl3"><?php echo __('History Cache'); ?></th>
					<th class="tbl3"><?php echo __('Price'); ?></th>
				</tr>
				<?php
					$graph_google = array();
					$graph_yahoo = array();
					$graph_date = array();
					$total_price = array();
				?>
				<?php foreach ($data_rankhistories as $rankhistory): ?>
				<?php $graph_date[] = "'".date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate']))."'";  ?>
				<tr>
					<td><?php echo date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate'])); ?>&nbsp;</td>
					<!-- rank logs -->
					<td>
						<span 
							class="set_inline_rank"
							data-type="text" 
							data-name="Rank" 
							data-pk="<?php echo $keyword['Keyword']['ID']; ?>,<?php echo $rankhistory['Rankhistory']['RankDate']; ?>,<?php echo $rankhistory['Rankhistory']['Rank']; ?>,<?php echo $this->Session->read('Auth.User.user.email'); ?>,<?php echo $this->here; ?>,"
							data-title="Input Rank"
						>
							<?php echo h($rankhistory['Rankhistory']['Rank']); ?>
						</span>
					</td>
					<td>
					<?php
						if ($keyword['Keyword']['Engine'] == 1) {
							$google_rank = $rankhistory['Rankhistory']['Rank'];
							$yahoo_rank = 0;
						} 
						elseif ($keyword['Keyword']['Engine'] == 2) {
							$google_rank = 0;
							$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
						}else {
							$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
							$google_rank = $ranks[0];
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
					 
						$cache_text = "";
						$history_limit = 90;
						$count_date = $this->Layout->CountDate($rankhistory['Rankhistory']['RankDate']);
						// Search engine google_jp & yahoo_jp. 3: Google/Yahoo 10: Google and Yahoo
						if ($keyword['Keyword']['Engine'] == 3 || $keyword['Keyword']['Engine'] == 10 || $keyword['Keyword']['Engine'] == 1 || $keyword['Keyword']['Engine'] == 2) {
							// google rank
							if ($google_rank > 0 && $google_rank <= 10 && $count_date <= $history_limit) {
								$google_cache_link = '/rankcache_new/' . $rankhistory['Rankhistory']['RankDate'] .'/' .md5(mb_convert_encoding($keyword['Keyword']['Keyword'] ."_google_jp", 'EUC-JP')) .'.html';
								if(isset($this->request->params['paging']['Rankhistory'])) {
									$cache_text = '<a href="../../../..' .$google_cache_link .'" target="_blank">キャッシュ</a> / ';
								}else{
									$cache_text = '<a href="../../..' .$google_cache_link .'" target="_blank">キャッシュ</a> / ';
								}
							} else if ($google_rank > 0 && $google_rank <= 10 && $count_date > $history_limit) {
								$cache_text = '保存期間対象外';
							} else {
								$cache_text = ' - / ';
							}
							
							// yahoo rank
							if ($yahoo_rank > 0 && $yahoo_rank <= 10 && $count_date <= $history_limit) {
								$yahoo_cache_link = 'http://' .$_SERVER['SERVER_NAME'] .'/rankcache_new/' .$rankhistory['Rankhistory']['RankDate'] .'/' .md5(mb_convert_encoding($keyword['Keyword']['Keyword'] ."_yahoo_jp", 'EUC-JP')) .'.html';
								$cache_text .= '<a href="' .$yahoo_cache_link .'" target="_blank">キャッシュ</a>';
							} else if ($yahoo_rank > 0 && $yahoo_rank <= 10 && $count_date > $history_limit) {
								$cache_text = '保存期間対象外';
							} else {
								$cache_text .= ' - ';
							}
						} else { # Search engine: not google_jp & yahoo_jp
							if (($rankhistory['Rankhistory']['Rank'] > 0 && $rankhistory['Rankhistory']['Rank'] <= 10) || ($rankhistory['Rankhistory']['Rank'] > 10 && in_array($keyid, $showcache))) {
								$cache_link = '/rankcache_new/' .$rank['RankDate'] .'/' .md5($keyword['Keyword']['Keyword'] ."_yahoo_jp") .'.html';
								if(isset($this->request->params['paging']['Rankhistory'])) {
									$cache_text = '<a href="../../../..' .$cache_link .'" target="_blank">キャッシュ</a> / ';
								}else {
									$cache_text = '<a href="../../..' .$cache_link .'" target="_blank">キャッシュ</a> / ';
								}
							}
						}
						echo $cache_text;
					?>
					</td>
					<td class="price">
						<?php
							$data_extra = array();		
							foreach($extra as $key_extra => $value_extra) {
								if(($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)){
									$data_extra[$key_extra] = $value_extra;
								}
							}
					
							if(count($data_extra)>0){
								ksort($data_extra);
								$key_extra = array_keys($data_extra);
									$sales = $data_extra[$key_extra[0]] - $keyword['Keyword']['cost'];
									echo $total_price[] = $sales;
									$group_extra[$key_extra[0]][] = $data_extra[$key_extra[0]];
									$group_rank[$rankhistory['Rankhistory']['Rank']][] = $data_extra[$key_extra[0]];
							}else{
								foreach($extra as $key => $value) {
									if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
										$sales = isset($value) ? $value - $keyword['Keyword']['cost'] : 0;
										echo $total_price[] = $sales;
										$group_rank[$rankhistory['Rankhistory']['Rank']][] = isset($value) ? $value : 0;
										$group_extra[$key][] = $value;
									}
								}
							}
						?>
					</td>
				</tr>
				<?php endforeach; ?>
				<!-- price with extra conditions -->
				<?php 
					if(count($group_extra)>0):
						ksort($group_extra);
						$kakinbi = 0;
						foreach($group_extra as $key_group_extra=>$value_group_extra):
							$kakinbi += count($value_group_extra);
				 ?>
				<tr>
					<td colspan="3" class="price-left no-boder"><?php echo $key_group_extra.'位保証 : ' .count($value_group_extra).'日'.' x '.money_format('%.0n', $value_group_extra[0]) ?></td>
					<td colspan="1" class="price-bold no-boder"><?php echo money_format('%.0n',array_sum($value_group_extra) - count($value_group_extra)*$keyword['Keyword']['cost']); ?></td>
				</tr>	 
				 <?php
						endforeach;
					endif
				 ?>
				<!-- kakinbi -->
				 <tr>
					<td colspan="3" class="price-left">課金日数</td>
					<td class="price"><span class="total"><?php echo isset($kakinbi)?$kakinbi.'日':'0日' ;?></span></td>
				</tr>
				<!-- total -->
				<tr>
					<td class="price"><span class="total"></td>
					<td colspan="2" style="text-align:right;font-weight:bold">合計</td>
					<td class="price">
						<span class="total">
							<?php
								@$percentage =  round(array_sum($total_price)* 100/$keyword['Keyword']['limit_price'], 2);
								$color_percentage = $percentage < 100 ? 'red' : 'blue';
								 
								echo '<span class="">' .money_format('%n',array_sum($total_price)) .'</span>'; 
							?>&nbsp;
				<!-- percentage -->
							<?php
								echo isset($keyword['Keyword']['limit_price']) ? '<span style="color:'.$color_percentage .'">' .$percentage.'%</span>' : '0%'; 
							?>
						</span>
					</td>
				</tr>
				<!-- limit price -->
				<tr>
					<td colspan="3" style="text-align:right;font-weight:bold">上限</td>
					<td class="price">
						<span data-type="text" data-name="limit_price" data-pk="<?php echo $keyword['Keyword']['ID']; ?>" data-title="Input Limit Price" id="set_limit_price" class='total <?php echo $percentage>=100?'btn btn-warning':''; ?>'>
							<?php echo isset($keyword['Keyword']['limit_price']) ? money_format('%n', $keyword['Keyword']['limit_price']) : __('Input Limit Price');?>
						</span>
						<span class="label badge-important"><?php echo $percentage >=100? '上限達成 ' : '';?></span>
					</td>
				</tr>
			</table>
			
			<!--graph data-->
			<?php
				$graph_google = array();
				$graph_yahoo = array();
				$graph_date = array();
				foreach ($rankhistories as $rankhistory):
					$graph_date[] = "'".date('Y-m-d', strtotime($rankhistory['Rankhistory']['RankDate']))."'";
					
					if ($keyword['Keyword']['Engine'] == 1) {
						$google_rank = $rankhistory['Rankhistory']['Rank'];
						$yahoo_rank = 0;
					} elseif ($keyword['Keyword']['Engine'] == 2) {
						$google_rank = 0;
						$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
					} else {
						$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
						$google_rank = $ranks[0];
						$yahoo_rank = @$ranks[1];
					}
					
					if($google_rank==0 && $yahoo_rank!=0) {
						$graph_google[] = 100;
						$graph_yahoo[] = $yahoo_rank; 
					}else if ($yahoo_rank==0 && $google_rank!=0) {
						$graph_yahoo[] = 100;
						$graph_google[] = $google_rank;
					}else if ($google_rank == 0 && $yahoo_rank==0) {
						$graph_google[] = 100;
						$graph_yahoo[] = 100;
					}else {
						$graph_google[] = $google_rank;
						$graph_yahoo[] = $yahoo_rank;
					}
				endforeach; 
			?>
			<!--graph-->
			<div id="graph" style="height: 400px; margin: auto"></div>
		</div>
	</div>
</div>

<?php
	echo $this->Html->css('bootstrap-editable');
	echo $this->Html->script(array('jquery.mockjax','bootstrap-editable'));
?>
<script type="text/javascript">
	$(document).ready(function(){
		// set limit price
		$.fn.editable.defaults.mode = 'inline';

		$('#set_limit_price').editable({
			url: '<?php echo $this->webroot ?>keywords/set_limit_price',
			display: function(value) {
	
			},
			ajaxOptions: {
				type: 'post'
			},
			success: function(response, newValue) {
				window.location.reload(true);
			}
		});
		
		// set inline rank
		<?php if($this->Session->read('Auth.User.user.role') == 2): ?>
		$('.set_inline_rank').editable({
			url: '<?php echo $this->webroot ?>keywords/set_inline_rank',
			display: function (value) {
			
			},
			ajaxOptions: {
				type: 'post'
			},
			success: function (response, newValue) {
				window.location.reload(true);
			}
		});
		<?php endif; ?>
		
		// load rank
		$('.loadRank').click(function(){
			var keyID = $(this).attr('KeyID');
			$('.loading').show();
			$.ajax({
				url:'<?php echo $this->webroot ?>keywords/load_rank_one',
				data:{keyID:keyID},
				type:'POST',
				success:function(data){
				$('.loading').hide();
					window.location.reload(true);
				}
			})
		})
	})
</script>

<script type="text/javascript">
	$(function () {
		$('#graph').highcharts({
			title: {
				text: '<?php echo __("Rank History"); ?>',
				x: 0 //center
			},
			subtitle: {
				text: '<?php echo __("Choose upper date range to show Rank History"); ?>',
				x: 0
			},
			xAxis: {
				categories: [<?php echo implode(', ',$graph_date) ?>],
				reversed: true
			},
			yAxis: {
				title: {
					text: '<?php echo __("Rank"); ?>'
				},
				plotLines: [{
					value: 0,
					width: 1,
					color: '#808080',
				}],
				reversed: true,
				max: 100,
				min: 1
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				borderWidth: 0
			},
			series: [{
				name: 'Google',
				data: [<?php echo implode(', ',$graph_google) ?>],
			}, {
				name: 'Yahoo',
				data: [<?php echo implode(', ',$graph_yahoo) ?>],
				color: 'red'
			}]
		});
	});
</script>