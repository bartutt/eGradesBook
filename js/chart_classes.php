<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.setOnLoadCallback(drawClasses);

    function drawClasses() {
    var data = google.visualization.arrayToDataTable([
      ['Year', 'quantity', { role: 'style' }],
      <?php      
        if (!empty ($years)){
          foreach ($years as $year)
          echo "['".$year['years']."', ".$year['qty'].", 'color: orange; stroke-width: 4; opacity: 0.5'],";

        }else echo "['Empty', 0, 'color: orange; stroke-width: 4; opacity: 0.5']";
      ?>
      ]);
 

      var options = {
        title: 'Classes',
        legend: 'none',
        hAxis: {title: 'Year', titleTextStyle: {color: 'red'}}
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('chartClasses'));
      chart.draw(data, options);

        $(window).resize(function(){
        drawClasses();
        });
}
</script>
