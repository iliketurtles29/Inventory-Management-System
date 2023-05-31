<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');

    $show_table = 'suppliers';
    $suppliers = include('database/show.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>View Suppliers - Billie Equipment</title>
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
                         <h1 class="section_header"><i class="fa-solid fa-list-check"></i> List of Suppliers </h1>
                         <div class="section_content">
                            <div class="poListContainers">

                            </div>
                            <div class="users">
                                <table class="content-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Supplier Name</th>
                                            <th>Supplier Location </th>
                                            <th>Email</th>
                                            <th>Contact number</th>
                                            <th>Person in Charge</th>
                                            <th>Products</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($suppliers as $index => $supplier){ ?>
                                        <tr>
                                            <td><?= $index + 1 ?></td>  
                                            <td>
                                                <?= $supplier['supplier_name']?>
                                            </td>
                                            <td><?= $supplier['supplier_location'] ?></td>
                                            <td><?= $supplier['email'] ?></td>
                                            <td><?= $supplier['contact_number'] ?></td>
                                            <td><?= $supplier['person_incharge'] ?></td>
                                            <td>  
                                                <?php  

                                                    $product_list = '-';
                                                    $sid = $supplier['id'];
                                                    $stmt = $conn->prepare("
                                                    SELECT product_name 
                                                        FROM products, productsuppliers
                                                        WHERE 
                                                            productsuppliers.supplier = $sid
                                                                AND
                                                            productsuppliers.product = products.id
                                                           
                                                    ");
                                                    $stmt->execute();
                                                    $row = $stmt->FetchAll(PDO::FETCH_ASSOC); 

                                                    if($row){
                                                        $product_arr = array_column($row, 'product_name');
                                                        $product_list = '<li>' . implode("</li><li>", $product_arr);
                                                    }
                                                   
                                                    echo $product_list;    
                                              ?>
                                            </td>
                                            <td>
                                                <?php
                                                     $uid = $supplier['created_by'];
                                                     $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                     $stmt->execute();
                                                     $row = $stmt->Fetch(PDO::FETCH_ASSOC); 
                                                     $created_by_name = $row['first_name']. ' ' . $row['last_name'];
                                                     echo $created_by_name;
                                                ?>
                                                

                                            </td>
                                            <td> <?= date('F d, Y', strtotime($supplier['created_at'])) ?></td>
                                            <td> 
                                                <a href="" class="updateSupplier" data-sid="<?= $supplier['id']?>" > <i class="fa fa-user-pen"></i>Edit</a>
                                                <a href="" class="deleteSupplier" data-name="<?= $supplier['supplier_name'] ?>"  data-sid="<?= $supplier['id']?>"> <i class="fa-solid fa-trash-can"></i> Delete</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <p class="userCount"><?= count($suppliers)?> Supplier</p>
                            </div>
                         </div>        
                    </div>
                </div>
               </div>
            </div>
        </div>
    </div>

<?php 

include('partials/app-scripts.php'); 

$show_table = 'products';
$products = include('database/show.php');
$products_arr = [];

foreach($products as $product){
    $products_arr[$product['id']] = $product['product_name'];
    
}

$products_arr = json_encode($products_arr);



?>
<script>
    var productsList = <?= $products_arr ?>;
    
    
    function script() {
        var vm = this;

        this.registerEvents = function(){
            document.addEventListener('click', function(e){

                targetElement = e.target;
                classList = targetElement.classList;


                if(classList.contains('deleteSupplier')){

                   e.preventDefault();
                   
                   sId = targetElement.dataset.sid;
                   supplierName = targetElement.dataset.name;

                   BootstrapDialog.confirm({
                    type: BootstrapDialog.TYPE_DANGER,
                    title: 'Delete Supplier',  
                    message: 'Are you sure you want to delete <strong>' +  supplierName + '<strong>?',
                    title: 'Delete product',
                    callback: function(isDelete){
                        if(isDelete){
                            $.ajax({
                            method: 'POST',
                            data: {
                                id: sId,
                                table: 'suppliers'
                            },
                            url: 'database/delete.php',
                            dataType: 'json',
                            success: function(data){
                                message = data.success ?
                                    supplierName + ' Successfully deleted!' : 'Error Processing request!';


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

                if(classList.contains('updateSupplier')){

                    e.preventDefault();

                    sId = targetElement.dataset.sid;
                    vm.showEditDialog(sId);           
                }
            });


            document.addEventListener('submit', function(e){
                e.preventDefault();
                targetElement = e.target;

                if(targetElement.id === 'editSupplierForm'){

                    vm.saveUpdatedData(targetElement);
                  
                }
                 
            });

            // $('#editProductForm').on('submit', function(e){
            //     e.preventDefault();
            // });
        },

        this.saveUpdatedData = function(form){
         
            $.ajax({
                                method: 'POST',
                                data: {
                                    supplier_name: document.getElementById('supplier_name').value, 
                                    supplier_location: document.getElementById('supplier_location').value, 
                                    email: document.getElementById('email').value,
                                    contact_number: document.getElementById('contact_number').value,
                                    person_incharge: document.getElementById('person_incharge').value,
                                    products: $('#products').val(),
                                    sid: document.getElementById('sid').value
                                },
                                url: 'database/update-supplier.php',
                                dataType: 'json',
                                success: function(data){
                                    BootstrapDialog.alert({
                                        type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                        message: data.message,
                                        callback:function(){
                                            if(data.success) location.reload();
                                        }
                                    });
                        
                                }
                            });
        },

        this.showEditDialog = function(id){
            
            $.get('database/get-supplier.php', {id: id}, function(supplierDetails){

               
                let curProducts = supplierDetails['products'];
                let productOptions = '';

                for(const[pId, pName] of Object.entries(productsList)){
                   selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
                   productOptions += "<option "+ selected +" value='"+ pId + "'>"+ pName + "</option>";
                }

           

                BootstrapDialog.confirm({
                        title: 'Update <strong> ' + supplierDetails.supplier_name + '</strong>',
                        message: '\<form action="database/add.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\
                        <div class="appFormInputContainer">\
                            <label for="supplier_name">Supplier Name</label>\
                            <input type="text" class="appFormInput" id="supplier_name"  value ="'+ supplierDetails.supplier_name +'" placeholder="Enter Supplier Name..." name="supplier_name" />\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="supplier_location">Location</label>\
                            <input type="text" class="appFormInput" id="supplier_location" value ="'+ supplierDetails.supplier_location +'" placeholder="Enter Supplier Location." \
                            name="supplier_location">\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="email">Email</label>\
                            <input type="text" class="appFormInput" id="email" value ="'+ supplierDetails.email +'" placeholder="Enter Supplier Email." \
                            name="email">\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="contact_number">Contact Number</label>\
                            <input type="text" class="appFormInput" id="contact_number" value ="'+ supplierDetails.contact_number +'" placeholder="Enter Contact Number." \
                            name="contact_number">\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="person_incharge">Person in Charge</label>\
                            <input type="text" class="appFormInput" id="person_incharge" value ="'+ supplierDetails.person_incharge +'" placeholder="Enter Person in Charge." \
                            name="person_incharge">\
                        </div>\
                        <div class="appFormInputContainer">\
                            <label for="description">Products</label>\
                            <select name="products[]" id="products" multiple="">\
                                <option value="">Select Products</option>\
                                '+ productOptions + '\
                            </select>\
                        </div>\
                            <input type="hidden" name="sid" id="sid" value="'+ supplierDetails.id +'"/>\
                            <input type="submit" value="submit" id="editSupplierSubmitBtn" class="hidden"/>\
                        </form>\
                        ',

                        callback: function(isUpdate){
                                if(isUpdate){
                                    
                                    document.getElementById('editSupplierSubmitBtn').click();
                                    
                            }
                        }
                    });


            }, 'json');


            
        },



        this.initialize = function(){
            this.registerEvents();
        }
        
    }
    var script = new script;
    script.initialize();

</script>
<script>
</script>
</body>        
</html>