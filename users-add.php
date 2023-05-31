<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $_SESSION['table'] = 'users';
    $_SESSION['redirect_to'] = 'users-add.php';

    $show_table = 'users';
    $users = include('database/show.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Add Users - Billie Equipment</title>
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
                        <h1 class="section_header"><i class="fa-solid fa-square-plus"></i> Add User </h1>        
                <div id="userAddFormContainer">  
                    <form action="database/add.php" style="margin-top: -110px !important;" onSubmit="return checkPassword(this)" method="POST" class="appForm">
                        <div class="appFormInputContainer">
                            <label for="first_name">First name</label>
                            <input type="text" class="appFormInput" id="first_name" name="first_name" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="last_name">Last name</label>
                            <input type="text" class="appFormInput" id="last_name" name="last_name" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="email">Email</label>
                            <input type="email" class="appFormInput" id="email" name="email" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="bday">Birthdate</label>
                            <input type="date" style="font-size: 1.5rem" class="appFormInput" id="bday" name="bday" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="contact_number">Contact Number</label>
                            <input type="text" class="appFormInput" id="contact_number" name="contact_number" required/>
                        </div>
                        
                        <div class="appFormInputContainer">
                            <label for="password">Password</label>
                            <input type="password" class="appFormInput" id="password" name="password" required/>
                        </div>
                        <div class="appFormInputContainer">
                            <label for="confirmPassword">Confirm Password</label>
                            <input type="password" class="appFormInput" id="confirmPassword" name="confirmPassword" required/>
                        </div>
                        <button type="submit" class="appBtn" id="appBtn"><i class="fa-solid fa-plus"></i> Add User</button>
                    </form>
                    <script>
                        function checkPassword(form) {
                            const password = form.password.value;
                            const confirmPassword = form.confirmPassword.value;

                            if (password != confirmPassword) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Password did not match!'})
                                return false;
                             
                        }else {
                            }
                           }
                            </script>
                    <?php 
                            
                        if(isset($_SESSION['response'])) {
                            $response_message = $_SESSION['response']['message'];
                            $is_success = $_SESSION['response']['success'];
                        
                        ?>
                        <script>
                            Swal.fire(
                            'Success!',
                            'User added Succesfully!',
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