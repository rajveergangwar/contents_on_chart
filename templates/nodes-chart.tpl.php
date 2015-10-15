<?php
$data = variable_get('contents_on_chart_data');
$nodeTypes = node_type_get_names();
$typesArray = array();
$chartArray = array();
foreach ($nodeTypes as $key => $value) {
    $typesArray[$key] = array();
}
foreach ($typesArray as $nodeTypeKey => $nodeTypeValue) {
    foreach ($data['nodeData'] as $key => $value) {
        if ($value['type'] == $nodeTypeKey) {
            $typesArray[$nodeTypeKey][] = $value;
        }
    }
}

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
                            <?php foreach ($chartArray['totalNodes'] as $cTypes => $count) { ?>
                                {label: '<?php print $cTypes ?>', y: <?php print $count ?> , legendText:'<?php print $cTypes; ?>'},
                        <?php } ?>

                        ]
                    }
                ]
            });

            chart.render();
        }
    </script>