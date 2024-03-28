<?php

    include("config/db.php");
    include('./shared/constans.php');
    header('Content-type: application/json');
    http_response_code(200);

    // check permission token 
    include('./shared/auth.php');
    checkPermission();

    $reqBody = json_decode(file_get_contents('php://input'), true) ;

    $referencesId = isset($reqBody['references_id']) ? $reqBody['references_id'] : "" ;
    $merchantId = isset($reqBody['merchant_id']) ? $reqBody['merchant_id'] : "";

    if (empty($referencesId) || empty($merchantId)){
        http_response_code(400);
        $response["Status"] = 400;
        $response["Message"] = "Reference Id dan Merchant Id tidak boleh kosong.";
        echo json_encode($response);
        exit;
    }

    $query = "SELECT * from transaction WHERE references_id = '$referencesId' AND  merchant_id = '$merchantId'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $row = mysqli_fetch_object($result);
    mysqli_close($db);
    
    if (empty($row)){
        http_response_code(400);
        $response["Status"] = 400;
        $response["Message"] = "Data tidak ditemukan";
        echo json_encode($response);
        exit;
    }


    $response["Status"] = 400;
    $response["Message"] = "Success";
    $response["Data"] = array("references_id" => $row->references_id, "invoice_id" => $row->invoice_id, "status" => paymentStatus($row->payment_status)); 
    echo json_encode($response);
    exit;