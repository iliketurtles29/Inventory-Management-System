<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');



?>

<!DOCTYPE html>
<html>

<head>
    <title>Dashboard - Billie Equipment</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/fontawesome.min.css">
    <script src="fc.js"></script>

</head>
<body>
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
            <?php include('partials/app-topnav.php')?>
            <div id="reportsContainer">
                <div class="reportTypeContainerbox">
                    <div class="reportType">
                        <p>Export Products</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=product" class="reportExportbtn">Excel</a>
    
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Suppliers</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=supplier" class="reportExportbtn">Excel</a>
                            
                        </div>
                    </div>                 
                </div>
                <div class="reportTypeContainerbox">
                    <div class="reportType">
                        <p>Export Deliveries</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=delivery" class="reportExportbtn">Excel</a>
                           
                        </div>
                    </div>
                    <div class="reportType">
                        <p>Export Purchase Orders</p>
                        <div class="alignRight">
                            <a href="database/report_csv.php?report=purchase_orders" class="reportExportbtn">Excel</a>
                           
                        </div>
                    </div>                 
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"> </script>
</body>        
</html>