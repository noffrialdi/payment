<?php


function paymentStatus($id = 0){
    $payment = array(0 => "Pending", 1 => "Paid" , 2 => "Failed", 3 => "Expired");
    return isset($payment[$id]) ? $payment[$id] : "";
}