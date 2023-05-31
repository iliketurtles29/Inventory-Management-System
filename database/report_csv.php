<?php
    $type = $_GET['report'];
    $file_name = '.xls';

    $mapping_filenames = [
        'supplier' => 'Supplier Report',
        'product' => 'Product Report',
        'purchase_orders' => 'Purchase order Report',
        'delivery' => 'Delivery Report'
    ];
    

    $file_name = $mapping_filenames[$type] . '.xls';
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"$file_name\"");
 
    include('connection.php');


    //PRODUCT REPORT
    if($type === 'product'){
        $stmt = $conn->prepare("SELECT * FROM products INNER JOIN users ON products.created_by = users.id ORDER BY products.created_at DESC");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $products = $stmt->fetchAll();
        // var_dump($products);
        // die;

        $is_header = true;
        foreach($products as $product){
            $product['created_by'] = $product['first_name'] . ' ' . $product['last_name'];
            unset($product['first_name'], $product['last_name'],  $product['password'], $product['email']);
            if($is_header){
                $row = array_keys($product);
                $is_header = false;
                echo implode("\t", $row) . "\n";
            
            }

            array_walk($product, function(&$str){
                $str = preg_replace("/\t/", "//t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

            });

            echo implode("\t", $product) . "\n";
        }

    }

    //SUPPLIERS REPORT
    if($type === 'supplier'){
        $stmt = $conn->prepare("SELECT suppliers.id as sid, suppliers.created_at as 'created at', users.first_name, users.last_name, suppliers.supplier_location, suppliers.email, suppliers.contact_number, suppliers.person_incharge,
        suppliers.created_by FROM suppliers INNER JOIN users ON suppliers.created_by = users.id ORDER BY suppliers.created_at DESC");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $suppliers = $stmt->fetchAll();
        // var_dump($products);
        // die;
        $is_header = true;
        foreach($suppliers as $supplier){
            $supplier['created_by'] = $supplier['first_name'] . ' ' . $supplier['last_name'];
            unset($supplier['first_name'], $supplier['last_name']);

            if($is_header){
                $row = array_keys($supplier);
                $is_header = false;
                echo implode("\t", $row) . "\n";
            
            }

            array_walk($supplier, function(&$str){
                $str = preg_replace("/\t/", "//t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

            });

            echo implode("\t", $supplier) . "\n";
        }

    }

    //ORDER REPORT
    if($type === 'purchase_orders'){
        $stmt = $conn->prepare("SELECT order_product.id, order_product.quantity_ordered, order_product.quantity_received, 
        order_product.quantity_remaining, order_product.status, order_product.batch, users.first_name, users.last_name, suppliers.supplier_name, order_product.created_at as 'order product created at' 
        FROM order_product INNER JOIN users ON order_product.created_by = users.id INNER JOIN suppliers ON order_product.supplier = suppliers.id ORDER BY order_product.batch DESC");
        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $order_products = $stmt->fetchAll();
        // var_dump($products);
        // die;


        //GROUP BY BATCH
        $pos = [];
        foreach($order_products as $order_product){
            $pos[$order_product['batch']][] = $order_product;
        }
    
        $is_header = true;

        foreach($pos as $order_products){
             foreach($order_products as $order_product){
            $order_product['created_by'] = $order_product['first_name'] . ' ' . $order_product['last_name'];
            unset($order_product['first_name'], $order_product['last_name']);

            if($is_header){
                $row = array_keys($order_product);
                $is_header = false;
                echo implode("\t", $row) . "\n";
            
            }

            array_walk($order_product, function(&$str){
                $str = preg_replace("/\t/", "//t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

            });

            echo implode("\t", $order_product) . "\n";
        }
        echo "\n";
    }   
}
    //DELIVERIES REPORT

    if($type === 'delivery'){
        $stmt = $conn->prepare("SELECT date_received, qty_received , first_name, last_name, products.product_name, supplier_name, batch
        FROM order_product_history, order_product, users, suppliers, products
        WHERE
            order_product_history.order_product_id = order_product.id 
        AND
            order_product.created_by = users.id 
        AND
            order_product.supplier = suppliers.id
        AND
            order_product.product = products.id
        ORDER BY order_product.batch DESC");

        $stmt->execute();
        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $deliveries = $stmt->fetchAll();

        $delivery_by_batch = [];
        foreach($deliveries as $delivery){
            $delivery_by_batch[$delivery['batch']][] = $delivery;
        }
    
        $is_header = true;

        foreach($delivery_by_batch as $deliveries){
             foreach($deliveries as $delivery){
            $delivery['created_by'] = $delivery['first_name'] . ' ' . $delivery['last_name'];
            unset($delivery['first_name'], $delivery['last_name']);

            if($is_header){
                $row = array_keys($delivery);
                $is_header = false;
                echo implode("\t", $row) . "\n";
            
            }

            array_walk($delivery, function(&$str){
                $str = preg_replace("/\t/", "//t", $str);
                $str = preg_replace("/\r?\n/", "\\n", $str);
                if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';

            });

            echo implode("\t", $delivery) . "\n";
        }
        echo "\n";
    }   
}


       

 