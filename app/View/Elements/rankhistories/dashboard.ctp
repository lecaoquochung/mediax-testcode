<!--
Today
Keyword: 
Rank-in:
Cost:
Sales::
Profit:
-->

<?php 
	$total_cost = array();
	$total_sales = array();
	$total_profit = array();
	
	foreach ($rankhistories as $rankhistory) :
		$params = json_decode($rankhistory['Rankhistory']['params'],true);
		
		if ($rankhistory['Keyword']['Engine'] == 1) {
			$google_rank = $rankhistory['Rankhistory']['Rank'];
			$yahoo_rank = 0;
		} elseif ($rankhistory['Keyword']['Engine'] == 2) {
			$google_rank = 0;
			$yahoo_rank = $rankhistory['Rankhistory']['Rank'];
		} else {
			$ranks = explode('/', $rankhistory['Rankhistory']['Rank']);
			$google_rank = $ranks[0];
			@$yahoo_rank = $ranks[1];
		}
		
		if($google_rank==0 && $yahoo_rank!=0){
			$graph_google[] = 100;
			$graph_yahoo[] = $yahoo_rank; 
		} else if ($yahoo_rank==0 && $google_rank!=0){
			$graph_yahoo[] = 100;
			$graph_google[] = $google_rank;
		} else if ($google_rank == 0 && $yahoo_rank==0){
			$graph_google[] = 100;
			$graph_yahoo[] = 100;
		} else{
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
		
		// sales & profit
		if(count($data_extra)>0){
			ksort($data_extra);
			$key_extra = array_keys($data_extra);
			// cost
			$total_cost[$rankhistory['Keyword']['ID']] = $rankhistory['Keyword']['cost'];
			// sales
			$sales =  $data_extra[$key_extra[0]];
			$total_sales[$rankhistory['Keyword']['ID']] = $sales;
			// profile
			$profit = $data_extra[$key_extra[0]] - $rankhistory['Keyword']['cost'];
			$total_profit[$rankhistory['Keyword']['ID'] .$rankhistory['Keyword']['Keyword'] .$rankhistory['Rankhistory']['Rank']] = $profit;
		}else{
			foreach($extra as $key => $value) {
				if(($google_rank <= $key && $google_rank != 0) || ($yahoo_rank <= $key && $yahoo_rank != 0)){
					// cost
					$total_cost[$rankhistory['Keyword']['ID']] = $rankhistory['Keyword']['cost'];
					// sales
					$sales = isset($value) ? $value : 0;
					$total_sales[$rankhistory['Keyword']['ID']] = $sales;
					// profit
					$profit = isset($value) ? $value - $rankhistory['Keyword']['cost'] : 0;
					$total_profit[$rankhistory['Keyword']['ID'] .$rankhistory['Keyword']['Keyword'] .$rankhistory['Rankhistory']['Rank']] = $profit;
				}
			} 
		}
	endforeach;
	
	@$sum_cost = money_format('%.2n',array_sum(@$total_cost));
	@$sum_sales = money_format('%.2n',array_sum(@$total_sales));
	@$sum_profit = money_format('%.2n',array_sum(@$total_profit));
	@$rankup_percentage = (count(@$total_profit)) / count($rankhistories) * 100;
?>

<?php 
	
//	debug($total_cost);
//	debug($total_sales);
//	debug($total_profit);
?>

<div class="row">		
	<div class="col-sm-12">
		<!-- history data -->
		<?php echo $this -> Form -> create('Rankhistory', array('class' => 'form-search', 'id' => 'RankhistoryViewForm_list')); ?>
		<div class="form-group">
			<div class="controls row">
				<div class="input-group col-sm-8">
					<?php
					echo $this -> Form -> input('rankDate', array('div' => False,
					'label' => False,
					'class' => 'input-sm', 'type' => 'date', 'dateFormat' => 'YMD', 'monthNames' => Configure::read('monthNames'), 'maxYear' => date('Y'), 'minYear' => date('Y') - 1));
					echo '&nbsp';
					echo $this -> Form -> submit(__('Submit'), array('class' => 'btn btn-info btn-sm  icon-refresh', 'div' => False));
					?>
				</div>
			</div>
		</div>
		<?php echo $this->Form->end(); ?>	
	</div>

	キーワード数：<?php echo count($rankhistories); ?>
	
	<br/ >
	
	Rank-in: <?php echo count(@$total_profit); ?> (<?php echo round($rankup_percentage, 2) .'%';?>)
	
	<br />
	
	Sales: <?php echo $sum_sales; ?>
	
	<br />
	
	Cost: <?php echo $sum_cost; ?>
	
	<br />
	
	Profit: <?php echo $sum_profit; ?>
	
	<br />
	
	前日比利益額：
	
	<br />
	
	前日比率：
	
	<br />
	
	累計実績（利益）：

</div>


<script type="text/javascript">
	$(document).ready(function(){
//		
	})
</script>
