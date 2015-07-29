<?php echo $this->element($this->params['controller'] .'/mobile_header') ?>

<div class="row">
	<div class="col-xs-12">
		<div class="">
			<h3><div class="label label-default">キーワード数：<?php echo count($rankhistories); ?></div></h3>
			<div class="box-body table-responsive no-padding">
				<!-- <table class="table"> -->
				<table class="table table-hovers">
					<thead>
						<tr>
							<th class="tbl0"><?php echo __('Keyword') .'/' .__('Url'); ?></th>
							<th class="tbl1"><?php echo __('Company'); ?></th>
							<th class=""><?php echo __('#'); ?></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($rankhistories as $rankhistory): ?>
						<?php $params = json_decode($rankhistory['Rankhistory']['params'],true) ?>
						<tr style="background:<?php echo $params['color'] ?>">
							<td style="<?php echo !empty($rankhistory['Keyword']['nocontract'])?'color:red':'' ?>">
								<?php echo ( isset($rankhistory['Keyword']['limit_price']) && $rankhistory['Keyword']['limit_price'] != 0)? '<span class="label label-warning">上限:' .money_format('%n',$rankhistory['Keyword']['limit_price']) .'</span>' : ''; ?>
<!-- keyword -->
								<h4>
								<?php 
									echo $this->Html->link($this->Text->truncate($rankhistory['Keyword']['Keyword'],10), array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID']),array('style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':'')));
								?>
								</h4>
								
								<span class="kaiyaku"><?php echo (isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0)? '(' .__('Keyword Cancel Estimate') .' ' .$rankhistory['Keyword']['rankend'] .')' : '';?></span>
								<?php echo ($rankhistory['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
								<?php 
									echo ($rankhistory['Rankhistory']['Rank'] == '') ? 
									'<div class="new-line"></div>' .$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$rankhistory['Keyword']['ID'])) 
									.$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
									: ''; 
								?>
<!-- company -->
								<h5>
									<?php echo (isset($rankhistory['Keyword']['limit_price_group']) && $rankhistory['Keyword']['limit_price_group'] != 0) ? '<span class="label label-warning">グループ上限</span>' : ''; ?>
								</h5>
								<h5>
									<?php echo $this->Html->link($this->Text->truncate($user[$rankhistory['Keyword']['UserID']], 10), array('controller' => 'users', 'action' => 'view', $rankhistory['Keyword']['UserID'])); ?>
								</h5>

<!-- url -->
								<h5>
									<?php echo $rankhistory['Keyword']['Strict']==1 ? '<span class="label label-info">完全一致</span>' : '<span class="label label-default">通常一致</span>'; ?>
									<?php echo $this->Html->link($this->Text->truncate($rankhistory['Keyword']['Url'],15), $rankhistory['Keyword']['Url'], array('target'=>'_blank')); ?>&nbsp;
								</h5>

							</td>
							
							<td>
								<!-- rank -->
								<h3>
								<?php echo $rankhistory['Rankhistory']['Rank'];?>
								<span class="arrow_row"><?php echo $params['arrow'] ?></span>
								</h3>
								<?php 
									global $list_engine;
									echo h(@$list_engine[$rankhistory['Keyword']['Engine']]);
								?>&nbsp;
							</td>
							<td><?php echo $rankhistory['Keyword']['ID']; ?></td>
						</tr>
					<?php endforeach; ?>
					</tbody>
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
