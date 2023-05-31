<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $user = ($_SESSION['user']);

    include('database/po_status_pie_graph.php');

    include('database/delivery_history.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - Billie Equipment</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">

</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partials/app-topnav.php')?>
            <div class="dashboard_content">
                <div class="dashboard_content_main">
                    <figure class="highcharts-figure">
                        <div id="container" onclick="redirectToPage()" ></div>
                        <p class="highcharts-description">
                        This is a summary of the purchase orders by status.
                        </p>
                    </figure>
                </div>
                <div id="deliveryHistory">

                </div>
            </div>  
        </div>
    </div>
    <script src="js/script.js"> </script>
    <script src="js/chart/accessibility.js"></script>
    <script src="js/chart/export-data.js"></script>
    <script src="js/chart/exporting.js"></script>
    <script src="js/chart/highcharts.js"></script>
    <script>
        var graphData = <?= json_encode($results)?>; 
        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Purchase Orders by Status',
                align: 'left'
            },
            tooltip: {
                pointFormatter: function(){
                    var point = this,
                    series = point.series;
                    return `${point.name}: <b>${point.y}</b>`
                }

            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.y}'
                    }
                }
            },
            series: [{
                name: 'Status',
                colorByPoint: true,
                data: graphData
            }]
        });

        var lineCategories = <?= json_encode($line_categories) ?>;
        var lineData = <?= json_encode($line_data) ?>;





        Highcharts.chart('deliveryHistory', {
            chart:{
                type: 'spline'
            },
            title: {
            text: '‎ ‎ ‎ ‎ ‎ ‎ ‎ Delivery History ',
            align: 'left'
            },


            yAxis: {
                title: {  
                text: 'Product Delivered'
                }
            },

            xAxis: {
                categories: lineCategories
            },

            legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
            },

            plotOptions: {
            series: {
                label: {
                connectorAllowed: false
                },
            
            }
            },

            series: [{
            name: 'Product Delivered',
            data: lineData


            }],

            responsive: {
            rules: [{
                condition: {
                maxWidth: 500
                },
                chartOptions: {
                legend: {
                    layout: 'horizontal',
                    align: 'center',
                    verticalAlign: 'bottom'
                }
                }
            }]
            }

            });

        
    </script>

<script>
function redirectToPage() {
  window.location.href = "./view-order.php";
}
</script>

</body>        
</html>