<div class="row">
	<div class="col-md-4">
        <!-- Warning box -->
        <div class="box box-solid box-warning">
            <div class="box-header">
                <h3 class="box-title"><?php echo __('Sales') ?></h3>
                <!-- <div class="box-tools pull-right">
                    <button class="btn btn-warning btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-warning btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div> -->
            </div>
            <div class="box-body">
                <!-- <?php echo __('Total') ?>: <code>.box.box-solid.box-warning</code> -->
                <h3>
                	<?php echo $this->Layout->MoneyFormat($monthly['sales']); ?>
                </h3>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    
    <div class="col-md-4">
        <!-- Danger box -->
        <div class="box box-solid box-danger">
            <div class="box-header">
                <h3 class="box-title"><?php echo __('Cost') ?></h3>
                <!-- <div class="box-tools pull-right">
                    <button class="btn btn-danger btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-danger btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div> -->
            </div>
            <div class="box-body">
                <!-- <?php echo __('Total') ?>: <code>.box.box-solid.box-danger</code> -->
                <h3>
                	<?php echo $this->Layout->MoneyFormat($monthly['cost']); ?>
                </h3>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
    
    	<div class="col-md-4">
        <!-- Success box -->
        <div class="box box-solid box-success">
            <div class="box-header">
                <h3 class="box-title"><?php echo __('Profit') ?></h3>
                <!-- <div class="box-tools pull-right">
                    <button class="btn btn-success btn-sm" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-success btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
                </div> -->
            </div>
            <div class="box-body">
                <!-- <?php echo __('Total') ?>: <code>.box.box-solid.box-success</code> -->
                <h3>
                	<?php echo $this->Layout->MoneyFormat($monthly['profit']); ?>
                </h3>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>

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
	            <div id="chart_pie" style="width: auto; height: 250px;"></div>
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
	            <div id="chart_bar" style="width: auto; height: 250px;"></div>
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
	            <div id="chart_line" style="width: auto; height: 350px;"></div>
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
          ['<?php echo __('Total') ?>', 'Yen'],
          <?php 
          	$monthly_sales = $monthly;
			unset($monthly_sales['sales']);
          	foreach 
          		($monthly_sales as $key => $value): echo '[' .'\''.__($key).'\'' .',' .$value .'], ';
          	endforeach;
          ?>
        ]);
		
		var formatter = new google.visualization.NumberFormat({
			prefix: '￥'
		});
		formatter.format(data, 1);
		
        var options = {
			title: '<?php echo __('Total') ?>',
			colors: ['red', '#109618'],
			pieSliceText: 'value',
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
			['<?php echo __('Day') ?>', '<?php echo __('Sales') ?>', '<?php echo __('Cost') ?>', '<?php echo __('Profit') ?>', '<?php echo __('Average') ?>'],
			<?php foreach ($weekly as $key => $value): $day = date('Y/m/') .(string)(date('d')-(count($weekly)-1-$key)); echo '[' .'"'.$day.'"' .',' .$value .',' .(array_sum(explode(',', $value)))/4 .'], '; endforeach; ?>
		]);
		
		var options = {
			title : '<?php echo __('Seika Performance') ?>',
			vAxis: {title: '<?php echo __('Total') ?>'},
			hAxis: {title: '<?php echo __('Day') ?>'},
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
	      data.addColumn('number', '<?php echo __('Day') ?>');
	      data.addColumn('number', '<?php echo __('Sales') ?>');
	      data.addColumn('number', '<?php echo __('Cost') ?>');
	      data.addColumn('number', '<?php echo __('Profit') ?>');
	
	      data.addRows([
	      	<?php foreach ($daily as $key => $value): echo '[' .($key+1) .',' .$value .'], '; endforeach; ?>
	      ]);
	
	      var options = {
	        hAxis: {
	          title: '<?php echo __('Day'); ?> '
	        },
	        vAxis: {
	          title: '<?php echo __('Total') ?>'
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