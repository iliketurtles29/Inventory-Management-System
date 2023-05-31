<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');

     //get products
     $show_table = 'products';
     $products = include('database/show.php');
     $products = json_encode($products);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Products - Billie Equipment</title>
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
                          <h1 class="section_header"><i class="fa-solid fa-square-plus"></i> Order Product</h1>   
                             
                            <div>
                                <form action="database/save-order.php" method="POST">
                                    
                                    <div class="alignRight">
                                        <button type="button" class="orderBtn orderProductBtn" id="orderProductBtn" onclick="enableButton2()"> Add Another Product</button>
                                    </div>
                                    
                                    <div id="orderProductLists">
                                        <p id="noData" style="color: #9f9f9f;">No product selected.</p>
                                    </div>

                                    <div class="alignRight marginTop20">
                                        <button type="submit" id="orderBtn" class="orderBtn submitOrderProductBtn">Submit Order</button>
                                    </div> 
                                </form>
                                    <script>
                                        // $(document).ready(function() {
                                        // $('#orderBtn').click(function(e) {
                                        //     e.preventDefault(); // Prevent form submission
                                            
                                        //     // Show confirmation dialog
                                        //     BootstrapDialog.confirm('Are you sure you want to submit order?', function(result) {
                                            
                                        //     if (result) {
                                        //         // If OK is clicked, submit the form
                                        //         $('form').submit();
                                        //     }
                                        //     });
                                        // });
                                        // });
                                </script>
                            </div>
                                    <?php 
                                    
                                    if(isset($_SESSION['response'])) {
                                        $response_message = $_SESSION['response']['message'];
                                        $is_success = $_SESSION['response']['success'];
                                    
                                    ?>
                                           <script>
                            Swal.fire(
                            'Success!',
                            'Product ordered Succesfully!',
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
    <?php include('partials/app-scripts.php'); ?>

<script>
       document.getElementById("orderBtn").disabled = true;
       document.getElementById("orderBtn").style.background = 'red';
    function enableButton2() {
            document.getElementById("orderBtn").disabled = false;
            document.getElementById("orderBtn").style.background = '#00ADB5';
        }


    var products = <?= $products; ?>;
    var counter = 0;
    function script(){
        var vm = this;

        let productOptions = '\
            <div>\
                <label for="product_name">PRODUCT NAME</label>\
                <select name="products[]" class="productNameSelect" id="product_name" required>\
                    <option value="">Select Product</option>\
                    INSERTPRODUCTHERE\
                </select>\
                    <button class = "appbtn removeOrderBtn">Remove</button>\
            </div>';
        //let supplierHtmlTemplate =
                                    // <div class="rowko">
                                    //         <div style="width: 50%;">
                                    //             <p class="supplierName">Supplier 1</p>
                                    //         </div>
                                    //         <div style="width: 50%;">
                                    //             <label for="quantity">Quantity: </label>
                                    //             <input type="number" class="appFormInput" id="quantity" placeholder=
                                    //             "Enter Quantity" name="quantity" required=""/>
                                    //         </div>
                                    //   </div>

        this.initialize = function(){ 
            this.registerEvents();
            this.renderProductOptions();
        },
        this.renderProductOptions = function(){
            console.log(products);
            let optionHtml = '';

            products.forEach((product) => {
                optionHtml += '<option value="'+ product.id +'">'+ product.product_name + '</option>';
            })
           
            productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
        },
        this.registerEvents = function(){
            document.addEventListener('click', function(e){
            targetElement = e.target;
            classList = targetElement.classList;

            // add new product order event
            if(targetElement.id === 'orderProductBtn'){
                document.getElementById('noData').style.display = 'none';
                let orderProductListsCointainer = document.getElementById('orderProductLists');
                

                orderProductLists.innerHTML += '\
                                <div  class="orderProductRow">\
                                '+ productOptions +'\
                                    <div class="suppliersRows" id="supplierRows_'+ counter +'" data-counter="' + counter +'">\</div>\
                                </div>';      
                                
                counter++;
           
            }

            //If remove button is clicked
            if(targetElement.classList.contains('removeOrderBtn')){
                let orderRow = targetElement
                    .closest('div.orderProductRow');
                
                //Remove element.
                orderRow.remove();
                console.log(orderRow);
            }
            
    });

        document.addEventListener('change', function(e){
            targetElement = e.target;
            classList = targetElement.classList;

            // Add suppliers row on product option change
            if(classList.contains('productNameSelect')){
                let pid = targetElement.value;

      
                let counterId = targetElement
                .closest('div.orderProductRow')
                .querySelector('.suppliersRows')
                .dataset.counter;

                    $.get('database/get-product-suppliers.php',{id: pid}, function(suppliers){
                        vm.renderSupplierRows(suppliers, counterId);

                        

                    }, 'json');             
                
            }
    });
    },
    this.renderSupplierRows = function(suppliers, counterId){
           let supplierRows = '';

           suppliers.forEach((supplier) => {
            supplierRows += '\
            <div class="rowko">\
             <div style="width: 50%;">\
              <p class="supplierName">'+ supplier.supplier_name +' 1</p>\
            </div>\
             <div style="width: 50%;">\
                <label for="quantity">Quantity: </label>\
                 <input type="number" class="appFormInput" id="quantity" required\
                 placeholder= "Enter Quantity" name="quantity['+ counterId +']['+ supplier.id +']" />\
            </div>\
            </div>';

           });

        // append to cointaner
        let supplierRowContainer = document.getElementById('supplierRows_' + counterId);
        supplierRowContainer.innerHTML = supplierRows;

    }

}
    (new script()).initialize();
</script>
</body>        
</html>