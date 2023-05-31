<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $_SESSION['table'] = 'suppliers';
    $_SESSION['redirect_to'] = 'supplier-add.php';
    $user = ($_SESSION['user']);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Supplier - Billie Equipment</title>
    <?php include('partials/app-header-scripts.php'); ?>
    <!-- <script src="fc.js"></script> --> 

</head>

<body> 
    <div id="dashboardMainContainer">
        <?php include('partials/app-sidebar.php') ?>
        <div class="dashboard_content_container" id="dashboard_content_container">
        <?php include('partials/app-topnav.php') ?>
            <div class="dashboard_content">
               <div class="dashboard_content_main">
                <div class="row">
                    <div class="column column-12 twelve">  
                        <h1 class="section_header"><i class="fa-solid fa-square-plus"></i> Add Supplier </h1>        
                <div id="userAddFormContainer" style="margin-top: 50px !important;">  
                    <form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
                        <div class="appFormInputContainer">
                            <label for="supplier_name">Supplier Name</label>
                            <input type="text" class="appFormInput" id="supplier_name" placeholder="Enter Supplier Name..." name="supplier_name" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="supplier_location">Location</label>
                            <input type="text" class="appFormInput" id="supplier_location" placeholder="Enter Supplier Location." 
                            name="supplier_location" required>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="contact_number">Contact Number</label>
                            <input type="number" class="appFormInput" id="contact_number" placeholder="Enter Contact Number." 
                            name="contact_number" required>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="person_incharge">Person in Charge</label>
                            <input type="text" class="appFormInput" id="person_incharge" placeholder="Enter Person in Charge" 
                            name="person_incharge" required>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="email">Email</label>
                            <input type="email" class="appFormInput" id="email" placeholder="Enter Supplier Email." 
                            name="email" required>
                        </div>
                        <button type="submit" class="appBtn" id="appBtn"><i class="fa-solid fa-plus"></i> Add Supplier</button>
                    </form>
                    <script>
                                // $(document).ready(function() {
                                // $('#appBtn').click(function(e) {
                                //     e.preventDefault(); // Prevent form submission
                                    
                                //     // Show confirmation dialog
                                //     BootstrapDialog.confirm('Are you sure you want to submit the form?', function(result) {
                                //     if (result) {
                                //         // If OK is clicked, submit the form
                                //         $('form').submit();
                                //     }
                                //     });
                                // });
                                // });
                            </script>
                    <?php 
                        
                        
                        if(isset($_SESSION['response'])) {
                            $response_message = $_SESSION['response']['message'];
                            $is_success = $_SESSION['response']['success'];
                        
                        ?>
                              <script>
                            Swal.fire(
                            'Success!',
                            'Supplier added Succesfully!',
                            'success'
                            )
</script>
                    <?php unset($_SESSION['response']); } ?>


                    </div>
                </div>
                
                </div>
               </div>
            </div>
        </div>
    </div>
    <?php include('partials/app-scripts.php'); ?>


<script>  
    var script = new script;
    script.initialize();
</script>
<script>
    
</script>
</body>        
</html>