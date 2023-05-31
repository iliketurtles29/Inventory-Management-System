<?php
    session_start();
    if(!isset($_SESSION['user'])) header('location: login.php');

    $show_table = 'suppliers';
    $suppliers = include('database/show.php');

?>

<!DOCTYPE html>
<html>

<head>
    <title>View Purchase Orders - Billie Equipment</title>
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
                         <h1 class="section_header"><i class="fa-solid fa-list-check"></i> List of Purchase Orders </h1>
                         <div class="section_content">
                         <div class="poListContainers"  style="overflow: auto">
                            <?php

                                    $stmt = $conn->prepare("
                                    SELECT order_product.id, order_product.product, products.product_name, order_product.quantity_ordered, users.first_name, order_product.batch,
                                        order_product.quantity_received, users.last_name, suppliers.supplier_name, order_product.status, order_product.created_at
                                        FROM order_product, suppliers, products, users
                                        WHERE
                                            order_product.supplier = suppliers.id 
                                                AND
                                            order_product.product = products.id
                                                AND
                                            order_product.created_by = users.id
                                        ORDER BY
                                            order_product.created_at DESC
                                                                          
                                    ");
                                    $stmt->execute();
                                    $purchase_orders = $stmt->FetchAll(PDO::FETCH_ASSOC); 
                                    
                                    $data = [];
                                    foreach($purchase_orders as $purchase_order){
                                        $data[$purchase_order['batch']][] = $purchase_order;
                                    }
                            ?>
                            <?php
                                foreach($data as $batch_id => $batch_pos){       
                            ?>
                                <div class="poList" id="container-<?= $batch_id?>">
                                    <p>Batch Number: <?= $batch_id?></p>
                                    <table class="content-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Quantity Ordered</th>
                                                <th>Quantity Received</th>
                                                <th>Supplier</th>
                                                <th>Status</th>
                                                <th>Ordered By</th>
                                                <th>Created Date</th>
                                                <th>Delivery History</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            foreach($batch_pos as $index => $batch_po){
                                            ?>
                                            <tr>
                                                <td> <?= $index + 1 ?></td>
                                                <td class="po_product"><?= $batch_po['product_name']?></td>
                                                <td class="po_qty_ordered"><?= $batch_po['quantity_ordered']?></td>
                                                <td class="po_qty_received"><?= $batch_po['quantity_received']?></td>
                                                <td class="po_qty_supplier"><?= $batch_po['supplier_name']?></td>
                                                <td class="po_qty_status"><span class="po-badge po-badge-<?= $batch_po['status']?>"><?= $batch_po['status']?></span></td>
                                                <td><?= $batch_po['first_name'] . ' ' . $batch_po['last_name']?></td>
                                                <td>
                                                    <?= $batch_po['created_at']?>
                                                    <input type="hidden" class="po_qty_row_id" value="<?= $batch_po['id'] ?>">
                                                    <input type="hidden" class="po_qty_row_productid" value="<?= $batch_po['product'] ?>">
                                                </td>
                                                <td>
                                                    <button class="appbtn appDeliveryHistory" data-id="<?= $batch_po['id'] ?>">Delivery History</button>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <div class="poOrderUpdateBtnContainer alignRight">
                                        <button class="appbtn updatePoBtn" data-id="<?= $batch_id?>">Update</button>
                                    </div>
                                </div>

                                <?php } ?>
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

    
    
    function script() {
        var vm = this;

        this.registerEvents = function(){
            document.addEventListener('click', function(e){

targetElement = e.target;
classList = targetElement.classList;


    if(classList.contains('updatePoBtn')){
    e.preventDefault();
    
    batchNumber = targetElement.dataset.id;
    batchNumberContainer = 'container-' + batchNumber;

    //get all order product records

            productList = document.querySelectorAll('#' + batchNumberContainer + ' .po_product');
            qtyOrderedList= document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_ordered');
            qtyReceivedList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_received');
            supplierList = document.querySelectorAll('#' + batchNumberContainer + ' .po_qty_supplier');
            statusList = document.querySelectorAll('#' + batchNumberContainer +  ' .po_qty_status');
            rowIds = document.querySelectorAll('#' + batchNumberContainer +  ' .po_qty_row_id');
            pIds = document.querySelectorAll('#' + batchNumberContainer +  ' .po_qty_row_productid');

    poListArr = [];
    for(i=0;i<productList.length;i++){
            poListArr.push({
                name: productList[i].innerText,
                qtyOrdered: qtyOrderedList[i].innerText,
                qtyReceived: qtyReceivedList[i].innerText,
                supplier: supplierList[i].innerText,
                status: statusList[i].innerText,
                id: rowIds[i].value,
                pid: pIds[i].value
            });
    }


    var poListHtml = '\
                        <table class="content-table" id="formTable_'+ batchNumber +'">\
                        <thead>\
                                <tr>\
                                    <th>Product Name</th>\
                                    <th>QTY Ordered</th>\
                                    <th>QTY Received</th>\
                                    <th>QTY Delivered</th>\
                                    <th>Supplier</th>\
                                    <th>Status</th>\
                                </tr>\
                            </thead>\
                            <tbody>';


                    poListArr.forEach((poList)=> {
                        poListHtml += '\
                                <tr>\
                                    <td class="po_product alignLeft">'+ poList.name +'</td>\
                                    <td class="po_qty_ordered ">'+ poList.qtyOrdered +'</td>\
                                    <td class="po_qty_received ">'+ poList.qtyReceived +'</td>\
                                    <td class="po_qty_delivered"><input type="number" value="0"/></td>\
                                    <td class="po_qty_supplier alignLeft">'+ poList.supplier +'</td>\
                                    <td>\
                                        <select class="po_qty_status">\
                                            <option value="pending" '+ (poList.status == 'pending' ? 'selected' : '') +'>pending</option>\
                                            <option value="incomplete" '+ (poList.status == 'incomplete' ? 'selected' : '') +'>incomplete</option>\
                                            <option value="complete" '+ (poList.status == 'complete' ? 'selected' : '') +'>complete</option>\
                                        </select>\
                                        <input type="hidden" class="po_qty_row_id" value="' +  poList.id +'">\
                                        <input type="hidden" class="po_qty_pid" value="' +  poList.pid +'">\
                                    </td>\
                                </tr>\
                        '; 

                        console.log(poList);

                    });
                    poListHtml += '</tbody></table>';            
                        
                            


    pName = targetElement.dataset.name;

    BootstrapDialog.confirm({
        type: BootstrapDialog.TYPE_PRIMARY,
        message: poListHtml,
        title: 'Update Purchase Order: Batch #: <strong>'+ batchNumber +'</strong>',
        callback: function(toAdd){
            if(toAdd){
        
                formTableContainer = 'formTable_' + batchNumber;

            //get all order product records
            qtyReceivedList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_received');
            qtyDeliveredList = document.querySelectorAll('#' + formTableContainer + ' .po_qty_delivered input');
            statusList = document.querySelectorAll('#' + formTableContainer +  ' .po_qty_status');
            rowIds = document.querySelectorAll('#' + formTableContainer +  ' .po_qty_row_id');
            qtyOrdered = document.querySelectorAll('#' + formTableContainer + ' .po_qty_ordered');
            pids = document.querySelectorAll('#' + formTableContainer + ' .po_qty_pid');
    
            poListArrForm = [];
            for(i=0;i<qtyDeliveredList.length;i++){
            poListArrForm.push({
                qtyReceive: qtyReceivedList[i].innerText,
                qtyDelivered: qtyDeliveredList[i].value,
                status: statusList[i].value,
                id: rowIds[i].value,  
                qtyOrdered: qtyOrdered[i].innerText,
                pid: pids[i].value
            }); 
    }
        
                //send request / update database.
                $.ajax({
                method: 'POST',
                data: {
                    payload: poListArrForm,
                },
                url: 'database/update-order.php',
                dataType: 'json',
                success: function(data){
                    message = data.message;
    
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

    //pindot deliver button
    if(classList.contains('appDeliveryHistory')){
        let id = targetElement.dataset.id;

        $.get('database/view-delivery-history.php', {id: id}, function(data){
            if(data.length){
                rows = ' ';
                
                data.forEach((row, id) =>{
                    receivedDate = new Date(row['date_received']);
                    rows += '\
                    <tr>\
                            <td>'+ (id + 1) +'</td>\
                            <td>'+ receivedDate.toUTCString() +'</td>\
                            <td>'+ row['qty_received'] +'</td>\
                        </tr>';
                });
                
                deliveryHistoryHtml = '<table class="deliveryHistoryTable">\
                   <thead>\
                        <tr>\
                          <th>#</th>\
                         <th>Date Received</th>\
                         <th>Qiantity Received</th>\
                        </tr>\
                    </thead>\
                    <tbody>'+ rows +' </tbody>\
                </table>';

                BootstrapDialog.show({
                    title: '<strong>Delivery Histories</strong>',
                    type: BootstrapDialog.TYPE_PRIMARY,
                    message: deliveryHistoryHtml
                });

            }else{
                BootstrapDialog.alert({
                    title: '<strong>No Delivery History</strong>',
                    type: BootstrapDialog.TYPE_INFO,
                    message: "No delivery history found on selected product."
                });      
            }

            console.log(data);
        }, 'json');
    }
    });
        
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