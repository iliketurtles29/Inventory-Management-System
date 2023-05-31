<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');
    $_SESSION['table'] = 'users';
    $user = ($_SESSION['user']);

    $show_table = 'users';
    $users = include('database/show.php');
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="/images/kai.jpg">
    <title>View Users - Billie Equipment</title>
    <?php include('partials/app-header-scripts.php'); ?>
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
                         <h1 class="section_header"><i class="fa-solid fa-list-check"></i> List of users </h1>
                         <div class="section_content">
                            <div class="users">
                                <table class="content-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First name</th>
                                            <th>Last name</th>
                                            <th>Email</th>
                                            <th>Birthdate</th>
                                            <th>Contact Number</th>
                                            <th>Date created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($users as $index => $user ) { ?>
                                            <tr>
                                            <td><?= $index + 1 ?></td>
                                            <td class="firstName"><?= $user['first_name'] ?></td>
                                            <td class="lastName"><?= $user['last_name'] ?></td>
                                            <td class="email"><?= $user['email'] ?></td>
                                            <td><?= date('F d, Y', strtotime( $user['bday'] ))?></td>
                                            <td class="contact_number"><?= $user['contact_number'] ?></td>
                                            <td><?= date('F d, Y', strtotime( $user['created_at'] ))?></td>
                                            <td>
                                                <a href="" class="updateUser" data-userid="<?= $user['id']?>"> <i class="fa fa-user-pen"></i> Edit</a>
                                                <a href="" class="deleteUser" data-userid="<?= $user['id']?>" data-fname="<?= $user['first_name'] ?>" data-lname="<?= $user['last_name']?>"> <i class="fa-solid fa-trash-can"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <p class="userCount"><?= count($users)?> Users</p>
                            </div>
                         </div>        
                    </div>
                </div>
               </div>
            </div>
        </div>
    </div>

<?php include('partials/app-scripts.php'); ?>

<script>
    function script(){

        this.initialize = function(){
            this.registerEvents();
        },

        this.registerEvents = function(){
            document.addEventListener('click', function(e){
                targetElement = e.target;
                classList = targetElement.classList;


                if(classList.contains('deleteUser')){
                   e.preventDefault();
                   
                   userId = targetElement.dataset.userid;
                   fname = targetElement.dataset.fname;
                   lname = targetElement.dataset.lname;
                   fullName = fname + ' ' + lname;
                //    Swal.fire({
                //         title: 'Are you sure?',
                //         text: "You won't be able to revert this!",
                //         icon: 'warning',
                //         showCancelButton: true,
                //         confirmButtonColor: '#3085d6',
                //         cancelButtonColor: '#d33',
                //         confirmButtonText: 'Yes, delete it!'
                //     }) .then((result) => {
                //         if (result.isConfirmed) {
                //             $.ajax({
                //             method: 'POST',
                //             data: {
                //                 id: userId,
                //                 table: 'users'
                //             },
                //             url: 'database/delete.php',
                //             dataType: 'json',
                //         });
                //             Swal.fire(
                //             'Deleted!',
                //             'Your file has been deleted.',
                //             'success',
                //             ) .then((ok) =>{
                //                 if(ok.isConfirmed){
                //                     location.reload();
                //                 }
                //         })
                //     }
                        
                //         })
                // }
                   BootstrapDialog.confirm({
                    type: BootstrapDialog.TYPE_DANGER,

                    message: 'Are you sure you want to delete <strong>' + fullName+ '<strong>?',
                    title: 'Delete User',
                    callback: function(isDelete){
                        if(isDelete){
                            $.ajax({
                            method: 'POST',
                            data: {
                                id: userId,
                                table: 'users'
                            },
                            url: 'database/delete.php',
                            dataType: 'json',
                            success: function(data){
                                message = data.success ?
                                    fullName + ' Successfully deleted!' : 'Error Processing request!';


                                    BootstrapDialog.alert({
                                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                            message: message,
                                            callback: function(){
                                               if(data.success) location.reload();
                                            }
                                        });
                                }
                        });
                        } 
                    }
                   });
                }
                if(classList.contains('updateUser')){
                    e.preventDefault();

                    firstName = targetElement.closest('tr').querySelector('td.firstName').innerHTML;
                    lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
                    email = targetElement.closest('tr').querySelector('td.email').innerHTML;
                    bday = targetElement.closest('tr').querySelector('td.bday')
                    contact_number = targetElement.closest('tr').querySelector('td.contact_number').innerHTML;
                    userId = targetElement.dataset.userid;

                    BootstrapDialog.confirm({
                        title: 'Update ' + firstName + ' ' + lastName,
                        message: '<form>\
                        <div class="form-group">\
                            <label for="firstName">First Name:</label>\
                            <input type="text" class="form-control" id="firstName" value="'+ firstName +'">\
                         </div>\
                         <div class="form-group">\
                            <label for="lastName">Last Name:</label>\
                            <input type="text" class="form-control" id="lastName" value="'+ lastName +'">\
                         </div>\
                         <div class="form-group">\
                            <label for="email">Email address:</label>\
                            <input type="email" class="form-control" id="emailUpdate" value="'+ email +'">\
                         </div>\
                         <div class="form-group">\
                            <label for="bday">Birthdate</label>\
                            <input type="date" class="form-control" id="bdayUpdate" value="'+ bday +'">\
                         </div>\
                         <div class="form-group">\
                            <label for="contact_number">Contact Number</label>\
                            <input type="number" class="form-control" id="contact_numberUpdate" value="'+ contact_number +'">\
                         </div>\
                        </form>',
                        callback: function(isUpdate){
                                if(isUpdate){
                                    $.ajax({
                                method: 'POST',
                                data: {
                                    userId: userId,
                                    f_name: document.getElementById('firstName').value,
                                    l_name: document.getElementById('lastName').value,
                                    email: document.getElementById('emailUpdate').value,
                                    bday: document.getElementById('bdayUpdate').value,
                                    contact_number: document.getElementById('contact_numberUpdate').value,
                                    
                                },
                                url: 'database/update-user.php',
                                dataType: 'json',
                                success: function(data){
                                    if(data.success){
                                        BootstrapDialog.alert({
                                            type: BootstrapDialog.TYPE_SUCCESS,
                                            message: data.message,
                                            callback: function(){
                                                location.reload();
                                            }
                                        });
                                    } else
                                        BootstrapDialog.alert({
                                            type: BootstrapDialog.TYPE_DANGER,
                                            message: data.message,
                                        });
                                }
                            });
                            }
                        }
                    });
                }
            });
        }
    }

    var script = new script;
    script.initialize();
</script>
</body>        
</html>