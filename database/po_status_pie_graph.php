<?php
include('connection.php');
$statuses = ['pending', 'incomplete', 'complete'];

$results = [];

foreach($statuses as $status){

$stmt = $conn->prepare("SELECT COUNT(*) status_count FROM order_product WHERE order_product.status='". $status ."'");
$stmt->execute();
$row = $stmt->fetch();

$count = $row['status_count'];


$results[] = [
    'name' => strtoupper($status),
    'y' => (int) $count
];
}