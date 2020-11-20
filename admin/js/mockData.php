
<script type="text/javascript">
const mockData = [
    <?php 

        foreach($database->getEvents() as $event){
            $color = $displayer->colorEvents();
            echo "
                {   
                    time: '".$event['date']."',
                    cls: '".$color."',
                    class_name: '".$event['name']."',
                    desc: '".$event['description']."',
                    ev_id: '".$event['id']."',
                    class_id: '".$event['class_id']."'
    
                },";
            }
    ?>

];
</script>