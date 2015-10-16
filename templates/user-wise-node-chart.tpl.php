<?php
$data = variable_get('contents_on_chart_data');
$users = entity_load('user');
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
print '<ul class="content_on_charts">';
foreach($extra['tabs'] as $links) {
    print '<li>'.$links.'</li>';
}
print '<ul>';
?>
<form class="form-inline" role="form" id="<?php print $form['#id'] ?>">
  <div class="form-group">
    <label for="pwd">Select Chart Type:</label>
    <select onchange="submitThisForm();" name="<?php print $form['chartType']['#name'] ?>">
        <?php foreach($form['chartType']['#options'] as $key=>$values ) { ?>
        <option><?php print $values ?></option>
        <?php } ?>
    </select>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
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
                        indexLabel: "{y}",
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