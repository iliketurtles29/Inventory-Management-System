<?php

$supplier_name = isset($_POST['supplier_name']) ? $_POST['supplier_name'] : '';
$supplier_location = isset($_POST['supplier_location']) ? $_POST['supplier_location'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$contact_number = isset($_POST['contact_number']) ? $_POST['contact_number'] : '';
$person_incharge = isset($_POST['person_incharge']) ? $_POST['person_incharge'] : '';

$supplier_id = $_POST['sid'];

//Update the product record  
try{
    $sql = "UPDATE suppliers
            SET 
            supplier_name = ?, supplier_location = ?, email = ?, contact_number = ?, person_incharge = ?
            WHERE id=?";

include('connection.php');    
$stmt = $conn->prepare($sql);
$stmt->execute([$supplier_name, $supplier_location, $email, $contact_number, $person_incharge, $supplier_id]);


//delete the old files.
$sql = "DELETE FROM productsuppliers WHERE supplier=?";
$stmt = $conn->prepare($sql);
$stmt->execute([$supplier_id]);

 //loop through the suppliers directory.
 // get suppliers
 
    $products = isset($_POST['products']) ? $_POST['products'] : [];
    foreach($products as $product){
       $supplier_data = [

           'supplier_id' => $supplier_id, 
           'product_id'  => $product,
           'updated_at'  => date('y-m-d H:i:s'),
           'created_at'  => date('y-m-d H:i:s'),
       ];

       $sql = "INSERT INTO productsuppliers
                           (supplier, product, updated_at, created_at)
                    VALUES
                           (:supplier_id, :product_id, :updated_at, :created_at)";

          $stmt = $conn->prepare($sql);
          $stmt->execute($supplier_data);

    }


$response = [
    'success' => true,
    'message' => "<strong>$supplier_name</strong> Successfully Updated to the System." 
];
    
} catch (Exception $e){

    $response = [
        'success' => false,
        'message' => "Error Processing Your Request"
    ];
}

echo json_encode($response);
   