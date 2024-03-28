<?php

    include("config/db.php");
    include('shared/constans.php');

    $filters = array_fill(0, 2, null);
    for($i = 1; $i < $argc; $i++) {
        $filters[$i - 1] = $argv[$i];
    }

    $referencesId = $filters[0];
    $paymentStatus = $filters[1]; 

    if (empty($referencesId) || empty($paymentStatus) ){
        echo "Parameter reference_id atau payment status tidak boleh kosong.";
        exit;
    }

    $constPaymentStatus = paymentStatus($paymentStatus);
    if (empty($constPaymentStatus)){
        echo "Payment status id : ".$paymentStatus." tidak ditemukan.";
        exit;
    }

    $query = "SELECT * from transaction WHERE references_id = '$referencesId'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $row = mysqli_fetch_object($result);
    if (empty($row)){
        echo "Reference Id : ".$referencesId." tidak ditemukan.";
        exit;
    }

    $query = "UPDATE transaction set payment_status = '$paymentStatus' WHERE references_id = '$referencesId'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    if ($result){
        echo "Berhasil update transaksi id : ".$referencesId." status transaksi : ".$constPaymentStatus;
    }

    mysqli_close($db);
    exit;