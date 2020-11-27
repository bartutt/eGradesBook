<?php 
  
    $class_attendance = $database->getClassAttendance($_GET['class_id'], $database->getCurrentYear());    

?>

<script type="text/javascript">
  google.load("visualization", "1", {packages:["corechart"]});
  google.charts.setOnLoadCallback(drawClassDetails);

    function drawClassDetails() {

      var data = google.visualization.arrayToDataTable([
        ['Month', 'Presention', { role: 'style' }],
        <?php 

          if (!empty ($class_attendance)){
            foreach($class_attendance as $att){
                $pr_presention = $att['present'] / $att['percent'] * 100;
                  echo "['".$att['month']."', ".$pr_presention.", 'color: green; stroke-width: 2; opacity: 0.5'],";
              }
          
          }else echo "['Empty', 0, 'color: green; stroke-width: 2; opacity: 0.5']";
          
          ?>
        ]);

        var options = {
        title: 'Attendance',
        legend: 'none',
        hAxis: {title: 'Month', titleTextStyle: {color: 'red'}},
        vAxis: {
            minValue: 0,
            maxValue: 100,
            format: '#\'%\''
        } 
    };

      var chart = new google.visualization.ColumnChart(document.getElementById('chartClassDetails'));
            chart.draw(data, options);

            $(window).resize(function(){
            drawClassDetails();
            });
}
</script>