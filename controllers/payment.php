<?php
   
    include("config/db.php");
    include_once('shared/generate.php');
    include_once('shared/constans.php');
    header('Content-type: application/json');

    // check permission token 
    include('shared/auth.php');
    checkPermission();


    $reqBody = json_decode(file_get_contents('php://input'), true) ;
    $method = $_SERVER['REQUEST_METHOD'];

    $response = array("Status" => 200, "Message" => "Success" ,  "Data" => array());
    header('Content-type: application/json');
    

    // ==== payload ======//
    $invoiceId = isset($reqBody["invoice_id"]) ? $reqBody["invoice_id"] : "";;
    $itemName = isset($reqBody["item_name"]) ? $reqBody["item_name"] : "";
    $amount = isset($reqBody["amount"]) ? $reqBody["amount"] : 0;
    $customerName = isset($reqBody["customer_name"]) ? $reqBody["customer_name"] : "";
    $merchantId = isset($reqBody["merchant_id"]) ? $reqBody["merchant_id"] : "";
    
    if ($method  != "POST"){
        http_response_code(400);
        echo "Not Allowed method";
        exit;
    }

    if (empty($merchantId) || empty($customerName)){
        http_response_code(400);
        $response["Status"] = 400;
        $response["Message"] = "Merchant id atau customer name tidak boleh kosong";
        echo json_encode($response);
        exit;
    }
    
    
    $paymentReq = isset($reqBody["payment_type"]) ? $reqBody["payment_type"] : "" ;
    $paymentTypes = array("virtual_account", "credit_card");
    if (!in_array($paymentReq, $paymentTypes)){
        http_response_code(400);
        $response["Status"] = 400;
        $response["Message"] = "Payment type tidak ditemukan.";
        echo json_encode($response);
        exit;
    }

    $numberVa = " - ";
    if ($paymentReq == "virtual_account"){
        $numberVa = randomAlphaNum();
    }

    if (!empty($invoiceId)){
        $query = "SELECT invoice_id from transaction where invoice_id = '$invoiceId' ";
        $result = mysqli_query($db, $query) or die(mysqli_error($db));
        if ($result->num_rows > 0){
            http_response_code(400);
            $response["Status"] = 400;
            $response["Message"] = "Invoice Id sudah sudah tersedia";
            echo json_encode($response);
            exit;
        }
    }

   
    $datetime = date('Y-m-d h:i:s');
    $id = genUUID();
    $referenceId = 'TR-'.mt_rand();

    $query = "INSERT INTO transaction (id, invoice_id, item_name, amount, payment_type, customer_name, number_va, created_time, merchant_id, references_id) VALUES ( '$id', '$invoiceId', '$itemName', '$amount','$paymentReq', '$customerName','$numberVa','$datetime', '$merchantId', '$referenceId' )";
    $resultQuery = mysqli_query($db, $query) or die(mysqli_error($db));
    mysqli_close($db);
    
    $response["Data"] = array("references_id" => $invoiceId, "number_va"=> $numberVa, "status" => paymentStatus());
    echo json_encode($response);



