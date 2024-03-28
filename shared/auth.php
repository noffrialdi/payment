<?php
include('./config/token.php');

/** 
 * Get header Authorization
 * */
function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

/**
 * get access token from header
 * */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

function checkPermission(){ 
    $reqBody = json_decode(file_get_contents('php://input'), true) ;

    $bearer = getBearerToken();
    $merchantId = isset($reqBody["merchant_id"]) ? $reqBody["merchant_id"] : "";
  
    if (empty($merchantId)){
        http_response_code(401);
        $response["Status"] = 401;
        $response["Message"] = "Merchant_id cannot be null";
        echo json_encode($response);
        exit;
    }

    $isValid = getToken($merchantId);
    if ($bearer != $isValid) {
        http_response_code(401);
        $response["Status"] = 401;
        $response["Message"] = "Not Permissionn";
        echo json_encode($response);
        exit;
    }
    

}
