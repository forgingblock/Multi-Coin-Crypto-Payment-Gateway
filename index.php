<?php
require 'inc/init.php';
require 'inc/gateway.php';

$product = new product();

$gateway = new ForgingblockGateway();
$base_url = Config::get('app:url');

$notifyURL = $base_url.'notify.php';

//change following values
$data = array (
	"amount"=>1,
	"currency"=>"USD",
	"coin"=>"BTC",	
	"order_id"=>time(),	
	"notifyurl"=>$notifyURL,	
);
$gateway->get_qr($data);


?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <title>Custom Payment!</title> 
    <!-- Bootstrap CSS -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="assets/vendor/fontawesome/css/all.css" rel="stylesheet">
    <!--load all styles -->
  </head>
  <body>
<div class="container">
   
<div class="row">
  <div class="col-md-8 col-sm-12 mx-auto mt-5 card">
<?php 

echo $gateway->display_qrbox();  //display payment box
?>
</div>
</div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src='assets/js/jquery.min.js'></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    
    <!--Do not remove-->
    <script src="assets/js/clipboard.min.js"></script>
    <script src="assets/js/gateway.js"></script>

    
  </body>
</html>