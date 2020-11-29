<?php 

$dbhandle = new mysqli('localhost','root','','mhtour');
echo $dbhandle->connect_error;

$query = "SELECT Country, sum(Visits) FROM visitors group by Country";
$res = $dbhandle->query($query);

?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Country', 'Visits'],
          
          <?php 
		while($row=$res->fetch_assoc())
		{
			echo "['".$row['Country']."',".$row['sum(Visits)']."],";
		}
          ?>

        ]);

        var options = {
          title: 'Visits From Countries',
          is3D:true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
    }
    </script>
  </head>
  <body>
    <div id="piechart" style="width: 900px; height: 500px;"></div>
  </body>
</html>
