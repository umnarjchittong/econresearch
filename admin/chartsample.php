<!doctype html>
<?php
// require('../vendor/autoload.php');
// require('../core.php');
// $fnc = new web;

// include("../fusioncharts/fusioncharts.php");
?>

<?php
   // Include the ../src/fusioncharts.php file that contains functions to embed the charts./
   include("../fusioncharts/fusioncharts.php");
?>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.0.2 -->
    <link rel="stylesheet" href="../vendor/twbs/bootstrap/dist/css/bootstrap.min.css">

    <!-- Custom styles for this template -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:wght@100;300&display=swap" rel="stylesheet">

    <script src="resources/js/fusioncharts.js"></script>
    <script src="resources/js/themes/fusioncharts.theme.fusion.js"></script>

</head>

<body>

    <?php
    // Chart Configuration stored in Associative Array
    $arrChartConfig = array(
        "chart" => array(
            "caption" => "Countries With Most Oil Reserves [2017-18]",
            "subCaption" => "In MMbbl = One Million barrels",
            "xAxisName" => "Country",
            "yAxisName" => "Reserves (MMbbl)",
            "numberSuffix" => "K",
            "theme" => "fusion"
        )
    );
    // An array of hash objects which stores data
    $arrChartData = array(
        ["Venezuela", "290"],
        ["Saudi", "260"],
        ["Canada", "180"],
        ["Iran", "140"],
        ["Russia", "115"],
        ["UAE", "100"],
        ["US", "30"],
        ["China", "30"]
    );
    $arrLabelValueData = array();
    // Pushing labels and values
    for ($i = 0; $i < count($arrChartData); $i++) {
        array_push($arrLabelValueData, array(
            "label" => $arrChartData[$i][0], "value" => $arrChartData[$i][1]
        ));
    }
    $arrChartConfig["data"] = $arrLabelValueData;
    // JSON Encode the data to retrieve the string containing the JSON representation of the data in the array.
    $jsonEncodedData = json_encode($arrChartConfig);
    // chart object
    $Chart = new FusionCharts("column2d", "MyFirstChart", "700", "400", "chart-container", "json", $jsonEncodedData);
    // Render the chart
    $Chart->render();
    ?>
    <center>
        <div id="chart-container">Chart will render here!</div>
    </center>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="../vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>