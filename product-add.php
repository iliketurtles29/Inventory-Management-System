<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $_SESSION['table'] = 'products';
    $_SESSION['redirect_to'] = 'product-add.php';
    $user = ($_SESSION['user']);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Products - Billie Equipment</title>
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
                        <h1 class="three"><i class="fa-solid fa-square-plus"></i> Create Product </h1>        
                <div id="userAddFormContainer">  
                    <form action="database/add.php" method="POST" class="appForm" enctype="multipart/form-data">
                        <div class="appFormInputContainer">
                            <label for="product_name"> Product Name</label>
                            <input type="text" class="appFormInput" id="product_name" placeholder=
                            " Enter Product Name" name="product_name" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="description"> Description</label>
                            <textarea class="appFormInput productTextAreaInput" id="description" placeholder=" Enter Product Description" name="description" required></textarea>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="description"> Suppliers</label>
                            <select name="suppliers[]" id="suppilersSelect" multiple="" required>
                                <option value="">Select Supplier</option required>
                                <?php

                                    $show_table = 'suppliers';
                                    $suppliers = include('database/show.php');

                                    foreach($suppliers as $supplier){
                                        echo "<option value='" . $supplier['id'] . "'>" . $supplier['supplier_name'] . "</option> " ;
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="product_name">Product Image</label>
                            <input type="file" name="img" required/>
                        </div>      
                        <button type="submit" id="appBtn" class="appBtn"><i class="fa-solid fa-plus"></i> Create Product</button>
                    </form>
                           <script>
                                // $(document).ready(function() {
                                // $('#appBtn').click(function(e) {
                                //     e.preventDefault(); // Prevent form submission
                                    
                                //     // Show confirmation dialog
                                //     BootstrapDialog.confirm('Are you sure you want to submit the form?', function(result) {
                                //         if (result) {
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
                            'Product added Succesfully!',
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
</body>        
</html>