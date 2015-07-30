// https://google-developers.appspot.com/chart/interactive/docs/gallery/columnchart
google.load("visualization", "1", {packages:["bar"]});
      google.setOnLoadCallback(drawChart1);
      function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['日付', '売上'],
          ['1', 58000],
          ['2', 60000],
          ['3', 45000],
          ['4', 50000],
          ['5', 62000],
          ['6', 62000],
          ['7', 62000],
        ]);

        var options = {
          chart: {
            title: 'MEDIAX Performance',
            subtitle: 'Profit: 1-5',
          },
          bar: { groupWidth: "10%" },
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, options);
      }