<?php #echo $this->element($this->params['controller'] .'/header') ?>

<div class="row">
	<div class="col-xs-12">
		<div class="">
				<h2>キーワード数：<?php echo count($m_rankhistories); ?></h2>
				<!-- csv download -->
			<div class="box-body table-responsive no-padding">
				<!-- <table class="table"> -->
				<table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
					<thead>
						<tr>
							<th class=""><?php echo __('#'); ?></th>
							<th class=""><?php echo __('Keyword') .'/' .__('Url'); ?></th>
							<th class=""><?php echo __('GoogleJP'); ?></th>
							<th class=""><?php echo __('YahooJP'); ?></th>
							<th class=""><?php echo __('Company'); ?></th>
							<th class=""><?php echo __('Actions'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($m_rankhistories as $m_rankhistory): ?>
						<?php $rank = json_decode($m_rankhistory['MRankhistory']['rank'], True) ?>
						<?php #$params = json_decode($m_rankhistory['MRankhistory']['params'],true) ?>
						<tr style="background:<?php #echo $params['color'] ?>">
							<td><?php echo $m_rankhistory['Keyword']['ID']; ?></td>
<!-- keyword -->
							<td style="<?php echo !empty($m_rankhistory['Keyword']['nocontract'])?'color:red':'' ?>">
								<?php echo ( isset($m_rankhistory['Keyword']['limit_price']) && $m_rankhistory['Keyword']['limit_price'] != 0)? '<span class="label label-warning">上限:' .money_format('%n',$m_rankhistory['Keyword']['limit_price']) .'</span>' : ''; ?>
								<?php echo $this->Html->link($m_rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $m_rankhistory['Keyword']['ID']),array('style'=>(!empty($m_rankhistory['Keyword']['nocontract'])?'color:red':''))); ?>
								<span class="alert-danger"><?php echo (isset($m_rankhistory['Keyword']['rankend']) && $m_rankhistory['Keyword']['rankend'] != 0)? '(' .__('Keyword Cancel Estimate') .' ' .$m_rankhistory['Keyword']['rankend'] .')' : '';?></span>
								<?php 
									echo ($m_rankhistory['MRankhistory']['rank'] == '') ? 
									'<div class="new-line"></div>' .$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-sm btn-danger','KeyID'=>$m_rankhistory['Keyword']['ID'])) 
									.$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
									: ''; 
								?>&nbsp;
								<div class="new-line"></div>
								<!-- url -->
								<?php echo $m_rankhistory['Keyword']['Strict']==1 ? '<span class="label label-info">完全一致</span>' : '<span class="label label-default">通常一致</span>'; ?>
								<?php echo $this->Html->link($this->Text->truncate($m_rankhistory['Keyword']['Url'],30), $m_rankhistory['Keyword']['Url'], array('target'=>'_blank')); ?>&nbsp;
							</td>
<!-- GoogleJP mobile -->
							<td><?php echo $rank['google_jp']; ?></td>
<!-- YahooJP mobile -->
							<td><?php echo $rank['yahoo_jp']; ?></td>
<!-- company -->
							<td>
								<?php echo (isset($m_rankhistory['Keyword']['limit_price_group']) && $m_rankhistory['Keyword']['limit_price_group'] != 0) ? '<span class="label label-warning">グループ上限</span>' : ''; ?>
								<?php echo $this->Html->link($this->Text->truncate($user[$m_rankhistory['Keyword']['UserID']], 15), array('controller' => 'users', 'action' => 'view', $m_rankhistory['Keyword']['UserID'])); ?>
								<div class="new-line"></div>
							</td>
<!-- actions -->
							<td class="actions">
								<a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $m_rankhistory['Keyword']['ID'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Keyword') ?>"><i class="fa fa-edit"></i></a>
								<a href="javascript:void(0)" class="loadRankmobile label label-danger" keyid="<?php echo $m_rankhistory['Keyword']['ID'] ?>" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Load Rankmobile') ?>"><i class="fa fa-refresh"></i></a>
								<!-- <a href="<?php #echo Router::url(array('controller' => 'extras', 'action' => 'add', $m_rankhistory['Keyword']['ID'])) ?>" class="label label-info" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Add Extra') ?>"><i class="fa fa-plus"></i></a> -->
								<?php if(isset($m_rankhistory['Keyword']['rankend']) && $m_rankhistory['Keyword']['rankend'] != 0) : ?>
								<?php else: ?>
									<?php 
										// echo $this->Form->postLink(
											// $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle'=>'tooltip', 'rel'=>'tooltip', 'title'=>__('Set Keyword to nocontract list'))). "",
											// array('controller' => 'keywords', 'action' => 'nocontract', $m_rankhistory['Keyword']['ID'],($m_rankhistory['Keyword']['nocontract']==1?0:1)),
											// array('escape'=>false, 'class' => 'label label-danger'),
											// __('【%s】を未契約しますか？', $m_rankhistory['Keyword']['ID']),
											// array('class' => '')
										// );
									?>
								<?php endif ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
					<!-- total -->
					<?php 
						// @$total = money_format('%.2n',array_sum(@$total_price));
						// @$rankup_percentage = (count(@$total_price)) / count($m_rankhistories) * 100;
					?>
				</table>
			</div>
		</div><!-- box -->
	</div>
</div>

<?php #echo $this->Html->link(__('Set Endate to All Keyword'), '#myModalEnableKeyword', array('data-toggle'=>'modal','role'=>'button','class' => "btn btn-danger")); ?>
<?php #echo $this->element('modal/set_all_keyword_enddate', array()); ?>

<script type="text/javascript">
	$(document).ready(function(){
		//
		$('.loadRankmobile').click(function(){
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
		
		// tooltip
		// $("a[rel=tooltip]").tooltip({placement:'up'});
		$('[data-toggle="tooltip"]').tooltip({placement:'top'});
	})
</script>
