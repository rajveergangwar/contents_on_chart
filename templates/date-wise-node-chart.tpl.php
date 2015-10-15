<?php
$data = variable_get('contents_on_chart_data');
$typesArray = array();
$chartArray = array();
$dateFrom   = strtotime($data['date']['from']);
$dateTo     = strtotime($data['date']['to']);
for ($i=$dateFrom; $i<=$dateTo; $i+=86400) { 
    $nextDateTimeStamp      =   $i+86400;   
    foreach ($data['nodeData'] as $key => $value) {
        if ($value['created']>=$i && $value['created']<=$nextDateTimeStamp) {
            $typesArray[date('d M Y',$i)][] = $value;
        }
    }
}
?>
<?php
foreach ($typesArray as $key => $value) {
    $chartArray['totalNodes'][$key] = count($value);
}
$form = drupal_get_form('contents_on_chart_only_type_form');
print '<form id="'.$form['#id'].'" onchange="submitThisForm()" >'; 
print render($form['chartType']);
print render($form['submit']);
print '</form>';
$chartType            =   isset($_GET['chartType'])?$_GET['chartType']:$data['chartType'];
?>
<div id="chartContainer" style="height: 300px; width: 100%;">
    <script type="text/javascript">
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "No of nodes in Content Types from date : <?php print $data['date']['from'] ?> ,  date to : <?php print $data['date']['to'] ?>"
                },
                animationEnabled: true,
                legend:{
                        verticalAlign: "center",
                        horizontalAlign: "left",
                        fontSize: 15,
                        fontFamily: "Helvetica",
                        markerType: "circle",
                        legendText: "circle"
                },
                data: [
                    {
                        type: "<?php print contents_on_chart_verify_chartType($chartType) ?>",
                        theme: "theme2",
                        showInLegend: false,
                        dataPoints: [
                            <?php foreach ($chartArray['totalNodes'] as $dateHas => $count) { ?>
                                {label: '<?php print $dateHas; ?>', y: <?php print $count ?> , legendText:'<?php print $dateHas; ?>'},
                    <?php } ?>

                        ]
                    }
                ]
            });

            chart.render();
        }
    </script>
    
  