<script type="text/javascript">
   google.load("visualization", "1", {packages:["corechart"]});
google.setOnLoadCallback(drawChart1);
function drawChart1() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'quantity', { role: 'style' }],
    <?php
                    foreach ($database->getYears() as $year)
                        echo "['".$year['years']."', ".'20'.", 'color: orange'],";
                ?>

  ]);
 

  var options = {
    title: 'Classes',
    hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
 };

var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
  chart.draw(data, options);
}

$(window).resize(function(){
  drawChart1();
});
    </script>