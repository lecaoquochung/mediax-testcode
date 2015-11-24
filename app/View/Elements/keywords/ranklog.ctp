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
				<?php // echo $this->Html->link(__('CSV'), array('controller' => 'rankhistories', 'action' => 'csv_by_keyword',$keyword['Keyword']['ID']), array('class' => 'btn btn-success btn-sm')); ?>
				<?php // echo $this->Session->read('Auth.User.user.role')==2 ? $this->Html->link(__('Load Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger btn-sm','KeyID'=>$keyword['Keyword']['ID'])) .$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none')):''; ?>
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
			<?php echo $this->Html->link(__('1~10'), array('controller' => 'keywords', 'action' => '',$keyword['Keyword']['ID'], 10), array('class' => 'btn btn-success btn-sm')); ?>
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
					<th class="tbl3"><?php echo __('G'); ?></th>
                    <th class="tbl3"><?php echo __('Y'); ?></th>
                    <th class="tbl3"><?php echo __('G/Y'); ?></th>
					<th class="tbl3"><?php echo __('History Cache'); ?></th>
				</tr>
				<?php
					$graph_google = array();
					$graph_yahoo = array();
					$graph_date = array();
					$total_price = array();
				?>
				<?php foreach ($data_rankhistories as $rankhistory): $rank = json_decode($rankhistory['Ranklog']['rank'], true); ?>
				<?php $graph_date[] = "'".date('Y-m-d', strtotime($rankhistory['Ranklog']['rankdate']))."'";  ?>
				<tr>
					<td><?php echo date('Y-m-d', strtotime($rankhistory['Ranklog']['rankdate'])); ?>&nbsp;</td>
<!-- rank logs -->
<!-- google_jp -->
                    <td>
                        <?php echo isset($rank['google_jp'])?$rank['google_jp'] : $rank['google']; ?>&nbsp;
                    </td>
<!-- yahoo_jp -->
                    <td>
                        <?php echo isset($rank['yahoo_jp'])?$rank['yahoo_jp'] : $rank['yahoo']; ?>&nbsp;
                    </td>
<!-- Best Rank -->
                    <td>
                        <?php echo $this->Layout->bestRank($rank); ?>&nbsp;
                    </td>

<!--History Cache-->
					<td>
					<?php
						if ($keyword['Keyword']['Engine'] == 1) {
							$google_rank = $rank['google_jp'];
							$yahoo_rank = 0;
						} 
						elseif ($keyword['Keyword']['Engine'] == 2) {
							$google_rank = 0;
							$yahoo_rank = $rank['yahoo_jp'];
						}else {
							$google_rank = isset($rank['google_jp'])?$rank['google_jp']:$rank['google'];
							$yahoo_rank = isset($rank['yahoo_jp'])?$rank['yahoo_jp']:$rank['yahoo'];
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
						$count_date = $this->Layout->CountDate($rankhistory['Ranklog']['rankdate']);
						// Search engine google_jp & yahoo_jp. 3: Google/Yahoo 10: Google and Yahoo
						if ($keyword['Keyword']['Engine'] == 3 || $keyword['Keyword']['Engine'] == 10 || $keyword['Keyword']['Engine'] == 1 || $keyword['Keyword']['Engine'] == 2) {
							// google rank
							if ($google_rank > 0 && $google_rank <= 10 && $count_date <= $history_limit) {
								$google_cache_link = '/rankcache_new/' .$this->Layout->stripHyphen($rankhistory['Ranklog']['rankdate']) .'/' .md5(mb_convert_encoding($keyword['Keyword']['Keyword'] ."_google_jp", 'EUC-JP')) .'.html';
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
								$yahoo_cache_link = 'http://' .$_SERVER['SERVER_NAME'] .'/rankcache_new/' .$this->Layout->stripHyphen($rankhistory['Ranklog']['rankdate']) .'/' .md5(mb_convert_encoding($keyword['Keyword']['Keyword'] ."_yahoo_jp", 'EUC-JP')) .'.html';
								$cache_text .= '<a href="' .$yahoo_cache_link .'" target="_blank">キャッシュ</a>';
							} else if ($yahoo_rank > 0 && $yahoo_rank <= 10 && $count_date > $history_limit) {
								$cache_text = '保存期間対象外';
							} else {
								$cache_text .= ' - ';
							}
						} 
						
						// else { # Search engine: not google_jp & yahoo_jp
							// if (($rankhistory['Ranklog']['rank'] > 0 && $rankhistory['Ranklog']['rank'] <= 10) || ($rankhistory['Ranklog']['rank'] > 10 && in_array($keyid, $showcache))) {
								// $cache_link = '/rankcache_new/' .$rank['RankDate'] .'/' .md5($keyword['Keyword']['Keyword'] ."_yahoo_jp") .'.html';
								// if(isset($this->request->params['paging']['Rankhistory'])) {
									// $cache_text = '<a href="../../../..' .$cache_link .'" target="_blank">キャッシュ</a> / ';
								// }else {
									// $cache_text = '<a href="../../..' .$cache_link .'" target="_blank">キャッシュ</a> / ';
								// }
							// }
						// }
						echo $cache_text;
					?>
					</td>
<!-- price -->
				</tr>
				<?php endforeach; ?>
<!-- price with extra conditions -->
<!-- kakinbi -->
<!-- total -->
<!-- limit price -->
			</table>
			
<!--graph data-->
			<?php
				$graph_google = array();
				$graph_yahoo = array();
				$graph_date = array();
				foreach ($rankhistories as $rankhistory): $rank = json_decode($rankhistory['Ranklog']['rank'], true);
					$graph_date[] = "'".date('Y-m-d', strtotime($rankhistory['Ranklog']['rankdate']))."'";
					
					if ($keyword['Keyword']['Engine'] == 1) {
						$google_rank = $rank['google_jp'];
						$yahoo_rank = 0;
					} elseif ($keyword['Keyword']['Engine'] == 2) {
						$google_rank = 0;
						$yahoo_rank = $rank['yahoo_jp'];
					} else {
						$google_rank = isset($rank['google_jp'])?$rank['google_jp']:$rank['google'];
						$yahoo_rank = isset($rank['yahoo_jp'])?$rank['yahoo_jp']:$rank['yahoo'];
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