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
            <?php
	            // echo $this->Html->link(__('CSV'), array(
	                // 'controller' => 'rankhistories',
	                // 'action' => 'csv_all_keyword',
	                // isset($this->params['pass'][1]) ? $this->params['pass'][1] : 1,
	                // isset($ranklogDate) ? $ranklogDate : date('Ymd')));
            ?>
            <div class="box-body table-responsive no-padding">
<!-- <table class="table"> -->
                <table id="example" class="display nowrap dataTable dtr-inline" cellspacing="0" width="100%" role="grid" aria-describedby="example_info" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class=""><?php echo __('#'); ?></th>
                            <th class=""><?php echo __('Keyword') . '/' . __('Url'); ?></th>
                            <th class=""><?php echo __('GoogleJP'); ?></th>
                            <th class=""><?php echo __('YahooJP'); ?></th>
                            <th class=""><?php echo __('G/Y'); ?></th>
                            <th class=""><?php echo __('Company'); ?></th>
                            <!-- <th class=""><?php echo __('Price'); ?></th> -->
                            <th class=""><?php echo __('Actions'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ranklogs as $ranklog): $rank = json_decode($ranklog['Ranklog']['rank'], true); ?>
                        	<?php $params = json_decode($ranklog['Ranklog']['params'],true) ?>
                            <tr style="background:<?php echo $params['color'] ?>">
                                <td><?php echo $ranklog['Keyword']['ID']; ?></td>
<!-- keyword -->
                                <td style="<?php echo!empty($ranklog['Keyword']['nocontract']) ? 'color:red' : '' ?>">
                                    <?php echo ( isset($ranklog['Keyword']['limit_price']) && $ranklog['Keyword']['limit_price'] != 0) ? '<span class="label label-warning">上限:' . money_format('%n', $ranklog['Keyword']['limit_price']) . '</span>' : ''; ?>
                                    <?php echo $this->Html->link($ranklog['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $ranklog['Keyword']['ID']), array('style' => (!empty($ranklog['Keyword']['nocontract']) ? 'color:red' : ''))); ?>
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
                                    <?php echo isset($rank['google_jp'])?$rank['google_jp']:'-'; ?>&nbsp;
                                </td>
<!-- yahoo_jp -->
                                <td>
                                    <?php echo isset($rank['yahoo_jp'])?$rank['yahoo_jp']:'-'; ?>&nbsp;
                                </td>
<!-- G/Y -->
                                <td>
                                    <?php echo $this->Layout->bestRank($rank); ?>&nbsp;
                                    <span class="arrow_row"><?php echo $params['arrow'] ?></span>
                                </td>
<!-- company -->
                                <td>
                                    <?php echo (isset($ranklog['Keyword']['limit_price_group']) && $ranklog['Keyword']['limit_price_group'] != 0) ? '<span class="label label-warning">グループ上限</span>' : ''; ?>
                                    <?php echo $this->Html->link($this->Text->truncate($user[$ranklog['Keyword']['UserID']], 15), array('controller' => 'users', 'action' => 'view', $ranklog['Keyword']['UserID'])); ?>
                                    <div class="new-line"></div>
                                </td>
<!-- price -->
                                <!-- <td>
                                    <?php
	                                    // $ranklog_tmp = json_decode($ranklog['Ranklog']['rank'],true);
	                                    // if ($ranklog['Keyword']['Engine'] == 1) {
	                                        // $google_rank = $ranklog_tmp['google_jp'];
	                                        // $yahoo_rank = 0;
	                                    // } elseif ($ranklog['Keyword']['Engine'] == 2) {
	                                        // $google_rank = 0;
	                                        // $yahoo_rank = $ranklog_tmp['yahoo_jp'];
	                                    // } else {
	                                        // $google_rank = $ranklog_tmp['google_jp'];
	                                        // @$yahoo_rank = $ranklog_tmp['yahoo_jp'];
	                                    // }
// 	
	                                    // if ($google_rank == 0 && $yahoo_rank != 0) {
	                                        // $graph_google[] = 100;
	                                        // $graph_yahoo[] = $yahoo_rank;
	                                    // } else if ($yahoo_rank == 0 && $google_rank != 0) {
	                                        // $graph_yahoo[] = 100;
	                                        // $graph_google[] = $google_rank;
	                                    // } else if ($google_rank == 0 && $yahoo_rank == 0) {
	                                        // $graph_google[] = 100;
	                                        // $graph_yahoo[] = 100;
	                                    // } else {
	                                        // $graph_google[] = $google_rank;
	                                        // $graph_yahoo[] = $yahoo_rank;
	                                    // }
// 	
	                                    // $data_extra = array();
	                                    // $extra_keyID = Hash::extract($extras, '{n}.Extra[KeyID=' . $ranklog['Keyword']['ID'] . ']');
	                                    // $extra = Hash::combine($extra_keyID, '{n}.ExtraType', '{n}.Price');
	                                    // foreach ($extra as $key_extra => $value_extra) {
	                                        // if (($google_rank <= $key_extra && $google_rank != 0) || ($yahoo_rank <= $key_extra && $yahoo_rank != 0)) {
	                                            // $data_extra[$key_extra] = $value_extra;
	                                        // }
	                                    // }
// 	
	                                    // if (count($data_extra) > 0) {
	                                        // ksort($data_extra);
	                                        // $key_extra = array_keys($data_extra);
	                                        // echo money_format('%.2n', $data_extra[$key_extra[0]]);
	                                        // $total_price[] = $data_extra[$key_extra[0]];
	                                    // } else {
	                                        // foreach ($extra as $key => $value) {
	                                            // if (($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)) {
	                                                // echo money_format('%.2n', isset($value) ? $value : 0);
	                                                // $total_price[] = isset($value) ? $value : 0;
	                                            // }
	                                        // }
	                                    // }
                                    ?>
                                </td> -->
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
<!-- total -->
                    <!-- <tr>
                    	 <?php
		                    // @$total = money_format('%.2n', array_sum(@$total_price));
		                    // @$ranklogup_percentage = (count(@$total_price)) / count($ranklogs) * 100;
	                    ?>
                        <td colspan="4" style="text-align:right;font-weight:bold">合計</td>
                        <td class="total">
                            <h2><span class="label label-info">
                   			 <?php // echo $total; ?>
                                </span></h2>
                        </td>
                        <td class="">
                            <h2>
                            	<span class="label <?php // echo $ranklogup_percentage < 100 ? 'label-danger' : 'label-success'; ?>">
                                    <?php // echo round($ranklogup_percentage, 2) . '%'; ?>
                                </span>
                        	</h2>
                        </td>
                    </tr> -->
                </table>
            </div>
        </div><!-- box -->
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
        // $('#example').DataTable({
        // paging: false,
        // ordering:  false
        // });
        // $('#table_id').DataTable();
    })
</script>
