<div class="row">
	
	<div class="col-xs-4">
	    <!-- interactive chart -->
	    <div class="box box-primary">
	        <div class="box-header">
	            <i class="fa fa-bar-chart-o"></i>
	            <h3 class="box-title"><?php echo __('Monthly') ?></h3>
	            <div class="box-tools pull-right">
	                <!-- Real time
	                <div class="btn-group" id="realtime" data-toggle="btn-toggle">
	                    <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
	                    <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
	                </div> -->
	            </div>
	        </div>
	        <div class="box-body">
	            <div id="chart_pie" style="width: auto; height: 300px;"></div>
	        </div>
	    </div>
	</div>
	
	<div class="col-xs-8">
	    <!-- interactive chart -->
	    <div class="box box-primary">
	        <div class="box-header">
	            <i class="fa fa-bar-chart-o"></i>
	            <h3 class="box-title"><?php echo __('Weekly') ?></h3>
	            <div class="box-tools pull-right">
	                <!-- Real time
	                <div class="btn-group" id="realtime" data-toggle="btn-toggle">
	                    <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
	                    <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
	                </div> -->
	            </div>
	        </div>
	        <div class="box-body">
	            <div id="chart_bar" style="width: auto; height: 300px;"></div>
	        </div>
	    </div>
	
	</div>
	
</div>

<div class="row">
	<div class="col-xs-12">
	    <!-- interactive chart -->
	    <div class="box box-primary">
	        <div class="box-header">
	            <i class="fa fa-bar-chart-o"></i>
	            <h3 class="box-title"><?php echo __('Daily') ?></h3>
	            <div class="box-tools pull-right">
	                <!-- Real time
	                <div class="btn-group" id="realtime" data-toggle="btn-toggle">
	                    <button type="button" class="btn btn-default btn-xs active" data-toggle="on">On</button>
	                    <button type="button" class="btn btn-default btn-xs" data-toggle="off">Off</button>
	                </div> -->
	            </div>
	        </div>
	        <div class="box-body">
	            <div id="chart_line" style="width: auto; height: 420px;"></div>
	        </div>
	    </div>
	
	</div>
</div>

<!-- monthly pie chart -->
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Amount', 'Yen'],
          <?php foreach ($monthly as $key => $value): echo '[' .'\''.$key.'\'' .',' .$value .'], '; endforeach; ?>
          // ['Sales',     20], ['Cost',      5], ['Profit',  15],
        ]);

        var options = {
			title: 'Total Amount',
			colors: ['orange', 'red', '#109618'],
        };

        var chart = new google.visualization.PieChart(document.getElementById('chart_pie'));

        chart.draw(data, options);
      }
    </script>

<!-- weekly bar chart -->
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
		// Some raw data (not necessarily accurate)
		var data = google.visualization.arrayToDataTable([
			['Day', 'Sales', 'Cost', 'Profit', 'Average'],
			<?php foreach ($weekly as $key => $value): echo '[' .($key+1) .',' .$value .',' .(array_sum(explode(',', $value)))/4 .'], '; endforeach; ?>
		]);
		
		var options = {
			title : 'Seika Performance',
			vAxis: {title: 'Amount'},
			hAxis: {title: 'Day'},
			colors: ['orange', 'red', '#109618', 'black'],
			seriesType: 'bars',
			series: {3: {type: 'line'}}
		};
		
		var chart = new google.visualization.ComboChart(document.getElementById('chart_bar'));
		chart.draw(data, options);
	}
</script>

<!-- daily line chart -->
<script type="text/javascript">
  	google.load('visualization', '1', {packages: ['corechart', 'line']});
	google.setOnLoadCallback(drawTrendlines);
	
	function drawTrendlines() {
	      var data = new google.visualization.DataTable();
	      data.addColumn('number', 'Day');
	      data.addColumn('number', 'Sales');
	      data.addColumn('number', 'Cost');
	      data.addColumn('number', 'Profit');
	
	      data.addRows([
	      	<?php foreach ($daily as $key => $value): echo '[' .($key+1) .',' .$value .'], '; endforeach; ?>
	      ]);
	
	      var options = {
	        hAxis: {
	          title: 'Day'
	        },
	        vAxis: {
	          title: 'Amount'
	        },
	        colors: ['orange', 'red', '#109618'],
	        trendlines: {
	          0: {type: 'exponential', color: '#333', opacity: 1},
	          1: {type: 'linear', color: '#111', opacity: .3}
	        }
	      };
	
	      var chart = new google.visualization.LineChart(document.getElementById('chart_line'));
	      chart.draw(data, options);
    }
</script>