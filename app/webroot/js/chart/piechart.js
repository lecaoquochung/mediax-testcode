 // pie chart
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart);
  function drawChart() {

    var data = google.visualization.arrayToDataTable([
      ['Rank', 'Keyword'],
      ['1~10',     11],
      ['11~20',      2],
      ['21~100',  2],
      ['圏外',    7]
    ]);

	var options = {
		title: '順位割合',
		// pieSliceTextStyle: {
			// color: 'black',
	  	// },
	  	slices: {
	  		0: {color: '#008d4c'}, 
	  		1: {color: '#e08e0b'}, 
	  		2: {color: '#f4543c'}, 
	  		3: {color: 'black'}, // white #f4f4f4
	  	}
	};

    var chart = new google.visualization.PieChart(document.getElementById('piechart'));

    chart.draw(data, options);
  }