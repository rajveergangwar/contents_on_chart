<?php
$data = variable_get('contents_on_chart_data');
$users = entity_load('user');
//print_r($users);
$userContent = array();
$chartArray = array();
foreach ($users as $key => $value) {
    $userContent[$value->uid] = array();
    $userContent[$value->uid]['username'] = $value->name;
}

foreach ($data['nodeData'] as $key => $value) {
    $userContent[$value['uid']][] = $value;
}

foreach ($userContent as $key => $value) {
    $chartArray['totalNodes'][$key]['totalNodes'] = (count($value) - 1);
    $chartArray['totalNodes'][$key]['username'] = $value['username'];
}
$chartType            =   isset($_GET['chartType'])?$_GET['chartType']:$data['chartType'];
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
                    text: "No of nodes published by users Y axis: Username , X axis:Node count"
                },
                animationEnabled: true,
                legend: {
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
                                {label: '<?php print $count['username'] ?>', y: <?php print $count['totalNodes'] ?>, legendText: '<?php print $cTypes; ?>'},
<?php } ?>

                        ]
                    }
                ]
            });

            chart.render();
        }
    </script>