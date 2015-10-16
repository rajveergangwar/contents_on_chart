<?php
$data = variable_get('contents_on_chart_data');
$nodeTypes = $extra;
$typesArray = array();
$chartArray = array();
$chartType = isset($_GET['chartType']) ? $_GET['chartType'] : $data['chartType'];
?>
<form class="form-inline" role="form" id="<?php print $form['#id'] ?>">
    <div class="form-group">
        <label for="pwd">Select Chart Type:</label>
        <select onchange="submitThisForm();" name="<?php print $form['chartType']['#name'] ?>">
            <?php foreach ($form['chartType']['#options'] as $key => $values) { ?>
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
                    text: "No of nodes in Content Types from date : <?php print $data['date']['from'] ?> ,  date to : <?php print $data['date']['to'] ?>"
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
                        indexLabel: "{y}",
                        theme:"theme2",
                        dataPoints: [
                        <?php foreach ($nodeTypes as $cTypes => $count) { ?>
                                {label: '<?php print $count['type'] ?>', y: <?php print $count['wid'] ?>, legendText: '<?php print $cTypes; ?>'},
                        <?php } ?>
                        ]
                    }
                ]
            });

            chart.render();
        }
    </script>