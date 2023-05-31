<?php
    $data = $_POST;
    $user_id = (int)$data['userId'];
    $first_name = $data['f_name'];
    $last_name = $data['l_name'];
    $email = $data['email'];
    $bday = $data['bday'];
    $contact_number = $data['contact_number'];


    try{
        $sql = "UPDATE users SET email=?, first_name=?, last_name=?, bday=?, contact_number=? WHERE id=?";
        
        include('connection.php');
        $conn->prepare($sql)->execute([$email, $first_name, $last_name, $bday, $contact_number, $user_id]); 

        echo json_encode([
            'success' => true,
            'message' => $first_name . ' ' . $last_name . ' Succesfully Updated.'
        ]);

        } catch(PDOException $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error processing your Request.'
            ]);
        }