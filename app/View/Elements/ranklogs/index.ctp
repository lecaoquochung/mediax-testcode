<?php echo $this->element('rank_header') ?>

<div class="row">
    <div class="col-xs-12">
        <div class="">
            <?php
            if ($this->params['pass']) {
                if ($this->params['pass'][1] == 10) {
                    $label = 'label label-info';
                } elseif (($this->params['pass'][1] == 20)) {
                    $label = 'label label-warning';
                } else {
                    $label = 'label label-default';
                }
            } else {
                $label = 'label label-default';
            }
            ?>
            <span class="<?php echo $label; ?>">キーワード数：<?php echo count($ranklogs); ?></span>
<!-- csv download -->
            <div class="box-body table-responsive no-padding">
<!-- <table class="table"> -->
                <table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class=""><?php echo __('#'); ?></th>
                            <th class=""><?php echo __('Keyword') . '/' . __('Url'); ?></th>
                            <th class=""><?php echo __('G'); ?></th>
                            <th class=""><?php echo __('Y'); ?></th>
                            <th class=""><?php echo __('G/Y'); ?></th>
                            <th class=""><?php echo __('-1 Day'); ?></th>
                            <th class=""><?php echo __('Company'); ?></th>
                            <th class=""><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ranklogs as $ranklog): $rank = json_decode($ranklog['Ranklog']['rank'], true); ?>
                        	<?php $params = json_decode($ranklog['Ranklog']['params'],true) ?>
                        	
                        	<?php 
                        		// rank today
                        		$bestRankToday = $this->Layout->bestRank($rank);
								$bestRankToday = $this->Layout->rankFlip($bestRankToday);
                        	
                        		// rank -1 Day
								if(isset($yesterday_ranklogs[$ranklog['Keyword']['ID']])){
									$rank_yesterday = json_decode($yesterday_ranklogs[$ranklog['Keyword']['ID']],true);
								}else{
									$rank_yesterday['google_jp'] = 0;
									$rank_yesterday['yahoo_jp'] = 0;
								}
								$bestRankYesterday = $this->Layout->bestRank($rank_yesterday);
								$bestRankYesterday = $this->Layout->rankFlip($bestRankYesterday);
								
								// rank -15 Days
							?>
                        	
                            <tr style="background:<?php echo $params['color'] ?>">
                                <td><?php echo $ranklog['Keyword']['ID']; ?></td>
<!-- keyword -->
                                <td style="<?php echo!empty($ranklog['Keyword']['nocontract']) ? 'color:red' : '' ?>">
                                    <?php echo ( isset($ranklog['Keyword']['limit_price']) && $ranklog['Keyword']['limit_price'] != 0) ? '<span class="label label-warning">上限:' . money_format('%n', $ranklog['Keyword']['limit_price']) . '</span>' : ''; ?>
                                    <?php echo $this->Html->link($ranklog['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'ranklog', $ranklog['Keyword']['ID']), array('style' => (!empty($ranklog['Keyword']['nocontract']) ? 'color:red' : ''))); ?>
                                    <span class="alert-danger"><?php echo (isset($ranklog['Keyword']['rankend']) && $ranklog['Keyword']['rankend'] != 0) ? '(' . __('Keyword Cancel Estimate') . ' ' . $ranklog['Keyword']['rankend'] . ')' : ''; ?></span>
                                    <?php echo ($ranklog['Keyword']['Penalty']) ? $this->Html->image('yellowcard.gif') : ''; ?>
                                    <?php
                                    echo ($ranklog['Ranklog']['rank'] == '') ?
                                            '<div class="new-line"></div>' . $this->Html->link(__('Load Today Rank'), 'javascript:void(0)', array('class' => 'loadRank btn btn-sm btn-danger', 'KeyID' => $ranklog['Keyword']['ID']))
                                            . $this->Html->image('loading.gif', array('class' => 'loading', 'style' => 'display:none')) : '';
                                    ?>&nbsp;
                                    <div class="new-line"></div>
<!-- url -->
                                    <?php echo $ranklog['Keyword']['Strict'] == 1 ? '<span class="label label-info">完全一致</span>' : '<span class="label label-default">通常一致</span>'; ?>
                                    <?php echo $this->Html->link($this->Text->truncate($ranklog['Keyword']['Url'], 30), $ranklog['Keyword']['Url'], array('target' => '_blank')); ?>&nbsp;
                                </td>
<!-- google_jp -->
                                <td>
                                    <?php echo isset($rank['google_jp'])?$rank['google_jp']:$rank['google']; ?>&nbsp;
                                </td>
<!-- yahoo_jp -->
                                <td>
                                    <?php echo isset($rank['yahoo_jp'])?$rank['yahoo_jp']:$rank['yahoo']; ?>&nbsp;
                                </td>
<!-- G/Y -->
                                <td>
                                    <span class="today"><?php echo $this->Layout->bestRank($rank); ?></span>&nbsp;
                                    <span class="arrow_row"><?php echo $params['arrow'] ?></span>
                                </td>
<!-- -1 Day -->
                                <td>
                                	<span class="yesterday">
									<?php
										if($bestRankToday > $bestRankYesterday){
											echo $bestRankToday != 0 ? '<span class="red-arrow"><i class="fa fa-fw fa-arrow-down"></i></span>' : '<span class="blue-arrow"><i class="fa fa-fw fa-arrow-up"></i></span>';
											echo (intval($bestRankToday)-intval($bestRankYesterday));
										}else if($bestRankYesterday > $bestRankToday){
											echo $bestRankToday != 0 ? '<span class="blue-arrow"><i class="fa fa-fw fa-arrow-up"></i></span>' : '<span class="red-arrow"><i class="fa fa-fw fa-arrow-down"></i></span>';
											echo (intval($bestRankYesterday) - intval($bestRankToday));
										}else if($bestRankToday==$bestRankYesterday){
											echo '<i class="fa fa-fw fa-minus"></i>' .'0';
										}
									?>
									</span>
                                </td>
<!-- -15 Days -->                                
<!-- company -->
                                <td>
                                    <?php echo (isset($ranklog['Keyword']['limit_price_group']) && $ranklog['Keyword']['limit_price_group'] != 0) ? '<span class="label label-warning">グループ上限</span>' : ''; ?>
                                    <?php echo $this->Html->link($this->Text->truncate($user[$ranklog['Keyword']['UserID']], 15), array('controller' => 'users', 'action' => 'ranklog', $ranklog['Keyword']['UserID'])); ?>
                                    <div class="new-line"></div>
                                </td>
<!-- actions -->
                                <td class="actions">
                                    <a href="<?php echo Router::url(array('controller' => 'keywords', 'action' => 'edit', $ranklog['Keyword']['ID'])) ?>" class="label label-warning" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Edit Keyword') ?>"><i class="fa fa-edit"></i></a>
                                    <a href="<?php echo Router::url(array('controller' => 'extras', 'action' => 'add', $ranklog['Keyword']['ID'])) ?>" class="label label-info" data-toggle="tooltip" rel="tooltip" title="<?php echo __('Add Extra') ?>"><i class="fa fa-plus"></i></a>
    <?php if (isset($ranklog['Keyword']['rankend']) && $ranklog['Keyword']['rankend'] != 0) : ?>
                                    <?php else: ?>
                                        <?php
                                        echo $this->Form->postLink(
                                                $this->Html->tag('i', '', array('class' => 'glyphicon glyphicon-remove', 'data-toggle' => 'tooltip', 'rel' => 'tooltip', 'title' => __('Set Keyword to nocontract list'))) . "", array('controller' => 'keywords', 'action' => 'nocontract', $ranklog['Keyword']['ID'], ($ranklog['Keyword']['nocontract'] == 1 ? 0 : 1)), array('escape' => false, 'class' => 'label label-danger'), __('【%s】を未契約しますか？', $ranklog['Keyword']['ID']), array('class' => '')
                                        );
                                        ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                                <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
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
        $('[data-toggle="tooltip"]').tooltip({placement: 'top'});

        // instant search
        $('#example').DataTable({
        	select: {
		        style: 'multi'
		    },
	        paging: false,
	        ordering:  true,
	        order: []
        });
        $('#table_id').DataTable();
    })
</script>
