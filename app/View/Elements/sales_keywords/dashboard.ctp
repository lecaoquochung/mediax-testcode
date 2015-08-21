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
	            <div id="chart_line" style="width: auto; height: 500px;"></div>
	        </div><!-- /.box-body-->
	    </div><!-- /.box -->
	
	</div><!-- /.col -->
</div>

<div class="row">
	<div class="col-xs-12">
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
	            <div id="chart_bar" style="width: auto; height: 500px;"></div>
	        </div><!-- /.box-body-->
	    </div><!-- /.box -->
	
	</div><!-- /.col -->
</div>

<div class="col-md-6">
    <!-- Bar chart -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-bar-chart-o"></i>
            <h3 class="box-title">Bar Chart</h3>
        </div>
        <div class="box-body">
        	<!-- chart -->
        </div><!-- /.box-body-->
    </div><!-- /.box -->

    <!-- Donut chart -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-bar-chart-o"></i>
            <h3 class="box-title">Donut Chart</h3>
        </div>
        <div class="box-body">
            <!-- chart -->
        </div><!-- /.box-body-->
    </div><!-- /.box -->
</div>

<!-- line chart -->
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
	        [1, 43050, 500, 42550],   
	        [2, 43050, 500, 42550],  
	        [3, 43050, 500, 42550],   
	        [4,  43050, 500, 42550],
	        [5,  43050, 500, 42550],
	        [6,  43050, 500, 42550],
	        [7,  43050, 500, 42550],
	        [8,  43050, 500, 42550],
	        [9,  43050, 500, 42550],
	        [10,  43050, 500, 42550],
	        [11,  43050, 500, 42550],
	        [11,  43050, 500, 42550],
	        [13,  43050, 500, 42550],
	        [14,  43050, 500, 42550],
	        [15,  43050, 500, 42550],
	        [16,  43050, 500, 42550],
	        [17,  43050, 500, 42550],
	        [18,  43050, 500, 42550],
	        [19,  43050, 500, 42550],
	        [20,  43050, 500, 42550],
	        [21,  43050, 500, 42550],
	        [22,  43050, 500, 42550],
	        [23,  43050, 500, 42550],
	        [24,  43050, 500, 42550],
	        [25,  43050, 500, 42550],
	        [26,  43050, 500, 42550],
	        [27,  43050, 500, 42550],
	        [28,  43050, 500, 42550],
	        [29,  43050, 500, 42550],
	        [30,  43050, 500, 42550],
	      ]);
	
	      var options = {
	        hAxis: {
	          title: 'Day'
	        },
	        vAxis: {
	          title: 'Amount'
	        },
	        colors: ['blue', 'red', 'green'],
	        trendlines: {
	          // 0: {type: 'exponential', color: '#333', opacity: 1},
	          // 1: {type: 'linear', color: '#111', opacity: .3}
	        }
	      };
	
	      var chart = new google.visualization.LineChart(document.getElementById('chart_line'));
	      chart.draw(data, options);
    }
</script>

<!-- bar chart -->
<script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
		// Some raw data (not necessarily accurate)
		var data = google.visualization.arrayToDataTable([
		 ['Month', 'Sales', 'Cost', 'Profit', 'Average'],
		 ['01',  165,      938,         522,		614.6],
		 ['02',  135,      1120,        599,       682],
		 ['03',  157,      1167,        587,       623],
		 ['04',  139,      1110,        615,       609.4],
		 ['05',  139,      1110,        615,       609.4],
		 ['06',  139,      1110,        615,       609.4],
		 ['07',  139,      1110,        615,       609.4],
		  ]);
		
		var options = {
		  title : 'SEO Seika Performance',
		  vAxis: {title: 'Amount'},
		  hAxis: {title: 'Day'},
		  seriesType: 'bars',
		  series: {3: {type: 'line'}}
		};
		
		var chart = new google.visualization.ComboChart(document.getElementById('chart_bar'));
		chart.draw(data, options);
	}
</script>

<?php 
	debug($salesKeywords)
?>