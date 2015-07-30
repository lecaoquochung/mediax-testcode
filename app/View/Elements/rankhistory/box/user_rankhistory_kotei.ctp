<div class="box admin_statuses span12">
    <div class="navbar">
        <div class="navbar-inner">
            <h3 class="brand"><?php echo __('Rankhistory'); ?></h3>
        </div>
    </div>
    <div class="section">
	<?php echo $this->Session->flash(); ?>
<!-- description -->
	<div class="description-box">
		<div class="new-line"><strong>マーク説明</strong></div>
		<i class="icon-edit"></i>
		<?php echo __('Keywork information edit'); ?>
		<br />
		<i class="icon-plus"></i>
		<?php echo __('Keywork add more details'); ?>
		<br />
		<span class="btn-warning"><i class="icon-remove"></i></span>
		<?php echo __('Set Keyword to nocontract list'); ?>
	</div>
<!-- search form -->
	<?php echo $this->Form->create('Rankhistory',array('class'=>'form-search')); ?>
        <?php
        	$current_year = date('Y'); 
        	echo $this->Form->input('rankDate',array('type'=>'date' ,'dateFormat'=>'YMD','monthNames'=>Configure::read('monthNames'), 'maxYear'=>$current_year, 'minYear'=>$current_year-2, 'div'=>FALSE)); 
       	?>
        <?php echo $this->Form->button(__('Choose'), array('class'=>'btn btn-success')); ?>
	<!-- <div class="input-append">
		<?php echo $this->Form->input('keyword',array('label'=>FALSE,'class'=>'span3 search-query', 'type'=>'text','div'=>FALSE)); ?>
		<?php echo $this->Form->button(__('Search'), array('class'=>'btn')); ?>
	</div> -->
	<?php echo $this->Form->end(); ?>
<!-- button -->
		<div class="common-button">
			<?php echo $this->Html->link(__('全件'), array('action' => '/kotei'), array('class' => "btn")); ?>
			<?php echo $this->Html->link(__('1~10'), array( 'rankrange', 10), array('class' => "btn btn-info")); ?>
			<?php echo $this->Html->link(__('11~20'), array( 'rankrange', 20), array('class' => "btn btn-warning")); ?>
			<?php echo $this->Html->link(__('21~100'), array( 'rankrange', 100), array('class' => "btn")); ?>
			<?php echo $this->Html->link(__('圏外'), array( 'rankrange', 1000), array('class' => "btn")); ?>
			<?php echo $this->Html->link(__('Add Keyword'), array('controller' => 'keywords' , 'action' => 'add'), array('class' => "btn btn-danger")); ?>
		</div>
		<?php 
			if($this->params['pass']) {
				if($this->params['pass'][1] == 10) {
					$label = 'label label-info';
				} elseif(($this->params['pass'][1] == 20)) {
					$label = 'label label-warning';
				} else {
					$label = 'label';
				} 
			} else {
				$label = 'label';
			}
		?>
		<span class="<?php echo $label; ?>">キーワード数：<?php echo count($rankhistories); ?></span>
<!-- csv download -->
		<?php echo $this->Html->link(__('CSV'), array('controller' => 'rankhistories', 'action' => 'csv_kotei_keyword', isset($this->params['pass'][1])?$this->params['pass'][1]:'')); ?>
<!-- table -->
		<table class="table tableX">
            <tr>
                <th class="tbl1"><?php echo __('KeyID'); ?></th>
                <th class="tbl4"><?php echo __('Company'); ?></th>
                <th class="tbl5"><?php echo __('Keyword') .'/' .__('Url'); ?></th>
                <th class="tbl2"><?php echo __('Rank'); ?></th>
                <th class="tbl2"><?php echo __('Price'); ?></th>
                <th class="actions tbl2"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($rankhistories as $rankhistory): ?>
				<?php $params = json_decode($rankhistory['Rankhistory']['params'],true) ?>
				<tr style="background:<?php echo $params['color'] ?>">
<!-- id -->
                    <td><?php echo $rankhistory['Keyword']['ID']; ?></td>
<!-- user company -->
                    <td>
                        <?php echo $this->Html->link($user[$rankhistory['Keyword']['UserID']], array('controller' => 'users', 'action' => 'view', $rankhistory['Keyword']['UserID'])); ?>
                    </td>
<!-- keyword -->
                    <td style="<?php echo !empty($rankhistory['Keyword']['nocontract'])?'color:red':'' ?>">
                    	<?php echo $this->Html->link($rankhistory['Keyword']['Keyword'], array('controller' => 'keywords', 'action' => 'view', $rankhistory['Keyword']['ID']),array('style'=>(!empty($rankhistory['Keyword']['nocontract'])?'color:red':''))); ?>
						<br />
                        <span class="kaiyaku"><?php echo (isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0)? '(' .__('Keyword Cancel Estimate') .' ' .$rankhistory['Keyword']['rankend'] .')' : '';?></span>
						<?php echo ($rankhistory['Keyword']['Penalty'])? $this->Html->image('yellowcard.gif') : '';?>
						<?php 
							echo ($rankhistory['Rankhistory']['Rank'] == '') ? 
							'<div class="new-line"></div>' .$this->Html->link(__('Load Today Rank'), 'javascript:void(0)',array('class'=>'loadRank btn btn-danger','KeyID'=>$rankhistory['Keyword']['ID'])) 
							.$this->Html->image('loading.gif',array('class'=>'loading','style'=>'display:none'))
							: ''; 
						?>&nbsp;
                    	<div class="new-line"></div>
                    	<?php echo $rankhistory['Keyword']['Strict']==1 ? '<span class="label label-info">完全一致</span>' : '<span class="label label-default">通常一致</span>'; ?>
<!-- url -->
                    	<?php echo $this->Html->link($this->Text->truncate($rankhistory['Keyword']['Url'],30), $rankhistory['Keyword']['Url']); ?>&nbsp;
                    </td>
<!-- engine rank -->
                    <td>
						<?php 
							global $list_engine;
							echo h($list_engine[$rankhistory['Keyword']['Engine']]); 
						?>&nbsp;
                    	<?php 
							echo $rankhistory['Rankhistory']['Rank'];
						?>&nbsp;
                        <span class="arrow_row"><?php echo $params['arrow'] ?></span>
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
                        <div class="btn-group">
							<i class="icon-edit">
                       			<?php echo $this->Html->link(__('Edit'), array('controller' => 'keywords', 'action' => 'edit', $rankhistory['Keyword']['ID'])); ?>
                        	</i>
						</div>
						<div class="btn-group">
							<i class="icon-plus">
                       			<?php echo $this->Html->link(__('Extra'), array('controller' => 'extras', 'action' => 'add', $rankhistory['Keyword']['ID'])); ?>
                        	</i>
						</div>
						<?php if(isset($rankhistory['Keyword']['rankend']) && $rankhistory['Keyword']['rankend'] != 0) : ?>
	                            
	                	<?php else: ?>
						<div class="btn-warning" style="float: right;">
							<i class="icon-remove">
								<?php echo $this->Html->link(__('Set Nocontract'), array('controller' => 'keywords', 'action' => 'nocontract', $rankhistory['Keyword']['ID'],($rankhistory['Keyword']['nocontract']==1?0:1))); ?>
							</i>
						</div>
	                    <?php endif ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php 
            	$total = money_format('%.2n',array_sum($total_price));
				$rankup_percentage = (count($total_price)) / count($rankhistories) * 100;
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
</div>	
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