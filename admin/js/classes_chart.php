<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawChart1);


  function drawChart1() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'quantity', { role: 'style' }],
    <?php
        foreach ($database->getClassesQty() as $year_qty)
          echo "['".$year_qty['years']."', ".$year_qty['qty'].", 'color: orange; stroke-width: 4; opacity: 0.5'],";
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