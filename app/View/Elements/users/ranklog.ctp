<?php echo $this->element($this->params['controller'] .'/header') ?>

<div class="row">
<!-- graph -->
	<div class="col-xs-12">
	    <!-- interactive chart -->
	    <div class="box box-primary">
	        <div class="box-header">
	            <i class="fa fa-bar-chart-o"></i>
	            <h3 class="box-title"><?php echo __('Rank') ?>(Demo)</h3>
	            <div class="box-tools pull-right">
	            </div>
	        </div>
	        <div class="box-body">
	            <div id="chart_line" style="width: auto; height: 350px;"></div>
	        </div>
	    </div>
	</div>

	<div class="col-xs-12">
		<div class="">
			<?php if (!empty($user['Keyword'])): ?>
			<!--hl start contract -->
			<?php $keywords = Hash::extract($user['Keyword'], '{n}[nocontract=0]');?>
			<h3><span class="label label-success"><?php echo __('Contract Keyword'); ?></span></h3>
			<?php 
				// echo $this->Form->postLink(
					// __('Download CSV'),
					// array('controller' => 'keywords', 'action' => 'exportCsvById'),
					// array(
						// 'data'=>array('ids'=>implode('-',Hash::extract($keywords, '{n}.ID'))),
						// 'escape'=>false, 
						// 'class' => ''
					// )
				// );
			?>			
			<table class="table table-hover dataTable">
				<tr>
					<th class="tbl1"><?php echo __('ID'); ?></th>
					<th class="tbl4"><?php echo __('Keyword'); ?></th>
					<th class="tbl5"><?php echo __('Url'); ?></th>
					<th class="tbl2"><?php echo __('G/Y'); ?></th>
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
							echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $this->Layout->bestRankJson($rankhistory[$keyword['ID']]):'-' 
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
			</table>
		</div>
	</div>
</div>

<!--hl contract limit price start group 1-->
<div class="row">
	<div class="col-xs-12">
		<div class="">
		<?php $keywords_contract = $keywords; ?>
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
						<th class="tbl2"><?php echo __('G/Y'); ?></th>
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
							echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $this->Layout->bestRankJson($rankhistory[$keyword['ID']]):'-' 
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
						<th class="tbl2"><?php echo __('G/Y'); ?></th>
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
							echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $this->Layout->bestRankJson($rankhistory[$keyword['ID']]):'-' 
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
		<?php endif; ?>
<!--hl end group 2 -->

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
						<th class="tbl2"><?php echo __('G/Y'); ?></th>
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
<!-- rank -->
						<td>
							<?php 
								echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $this->Layout->bestRankJson($rankhistory[$keyword['ID']]):'-' 
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
						<th class="tbl3"><?php echo __('G/Y'); ?></th>
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
<!-- rank -->
							<td>
								<?php 
									echo (isset($rankhistory[$keyword['ID']]) && $rankhistory[$keyword['ID']]!='') ? $this->Layout->bestRankJson($rankhistory[$keyword['ID']]):'-' 
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

<!-- daily line chart -->
<script type="text/javascript">
  	google.load('visualization', '1', {packages: ['corechart', 'line']});
	google.setOnLoadCallback(drawTrendlines);
	
	function drawTrendlines() {
	      var data = new google.visualization.DataTable();
	      data.addColumn('number', '<?php echo __('Day') ?>');
	      data.addColumn('number', '<?php echo __('Rank') ?>');
	      data.addRows([
	      	<?php foreach ($graph as $key => $value): echo '[' .($key+1) .',' .$value .'], '; endforeach; ?>
	      ]);
	
	      var options = {
	        hAxis: {
	        	direction: -1,
	          	title: '<?php echo __('Period'); ?> '
	        },
	        vAxis: {
	        	direction: -1,
	          	title: '<?php echo __('Rank') ?>',
	          	viewWindow: {
	          		// max: 100,
	          	},
	          	gridlines: {
	          		count: 10,
	          	}
	        },
	        colors: ['orange', 'red', '#109618'],
	        trendlines: {
	          // 0: {type: 'exponential', color: '#333', opacity: 1},
	          // 1: {type: 'linear', color: '#111', opacity: .3}
	        }
	      };
	
	      var chart = new google.visualization.LineChart(document.getElementById('chart_line'));
	      chart.draw(data, options);
    }
</script>