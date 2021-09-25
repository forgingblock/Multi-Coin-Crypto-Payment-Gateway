<?php
require 'inc/init.php';
require 'inc/gateway.php';

$product         = new Product();
$invoice_id = '';
$json_ipn_res = file_get_contents('php://input');	
if ($json_ipn_res) {	
	$jsonAr = json_decode($json_ipn_res, true);
	$invoice_id = $jsonAr['id'];
}

if (!empty($invoice_id))
{    
	$gateway = new ForgingblockGateway();
	$gateway->update_status($invoice_id);	
	echo "OK";
}
else
{
  exit('No transaction detected');
    
}

