<?php
header('Access-Control-Allow-Origin: *');

require 'inc/init.php';
require 'inc/gateway.php';



$product  = new Product();

if (isset($_POST['a']) && $_POST['a'] == 'payment') {
    $wallet =  isset($_POST['wallet']) ? filter_var($_POST['wallet'], FILTER_SANITIZE_STRING) : "";
    $coin   =  isset($_POST['coin'])   ? filter_var($_POST['coin'], FILTER_SANITIZE_STRING) : ""; 
	$invoiceID   =  isset($_POST['invoiceID'])   ? filter_var($_POST['invoiceID'], FILTER_SANITIZE_STRING) : ""; 	
    
	$gateway = new ForgingblockGateway();
	$gateway->update_status($invoiceID);
	
    $product = $product->readOne($invoiceID);
	
	

    $txtID = is_null($product->txID) ? '' : sanitize_str($product->txID);
    $paid = 0;
    if ($product->status == 'paid') {
        $paid = 1;
        $message = '<div class="alert alert-success w-100" role="alert">
                    <h4 class="alert-heading">Payment Confirmed</h4>
                    <p>Payment ' . sanitize_float($product->amount) . ' ' . sanitize_str($coin) . '  has been received and confirmed, you will be redirected shortly.
                    <hr><a href="https://live.blockcypher.com/' . sanitize_str($coin) . '/tx/' .  $txtID . '" target="_blank">View transaction details</a>
                    </p>
                    </div>';
        
    } else if (($product->status == 'complete') || ($product->status == 'confirmed')) {
		$paid = 2;
        $message = '<div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">Payment Successfully Received!</h4>
                    <p>Payment ' . sanitize_float($product->amount) . ' ' . sanitize_str($coin) . ' has been received and pending confirmations, you dont need to do anything payment will be confirmed shortly after 1 bitcoin confirmations. <hr></p>

                    </div>';
    } else {
        $message = 'Awaiting payment...';
    }
    
    $resultData = array(
        'message' => $message,
        'paid' =>    $paid,
        'status' => 200
    );
    header('Content-type: application/json');
    echo json_encode($resultData);
    
} else {
    
    $resultData = array(
        "errors" => 'Bad request, no type specified.',
        'status' => 200
    );
    header('Content-type: application/json');
    echo json_encode($resultData);
}

?>