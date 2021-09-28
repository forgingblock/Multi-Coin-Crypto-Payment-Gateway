<?php


class ForgingblockGateway
{
	var $forgingblock;
	var $coin;
	var $coin_fullname;
	var $coin_logo;
	var $coin_amount;
	var $invoiceID;
	var $coin_wallet;
	var $currency;
	var $amount;
	
	function __construct(){
		$trade = Config::get('app:forgingblock_trade');
		$token = Config::get('app:forgingblock_token');
		$tmode = Config::get('app:forgingblock_env');
		$this->forgingblock = new \ForgingblockAPI($tmode);	
		$this->forgingblock->SetValue('trade',  $trade);
		$this->forgingblock->SetValue('token', $token);		
	}
		
    function get_qr($data)
	{	
		global $database;
        global $db;
        global $product;
		
		$this->forgingblock->SetValue('amount', round($data['amount'], 2));								
		$this->forgingblock->SetValue('currency',$data['currency']);		
		$this->forgingblock->SetValue('notification', $data['notifyurl']);
		$this->forgingblock->SetValue('order', $data['order_id']);
		$resar = $this->forgingblock->CreateInvoice();			
		$this->invoiceID = $resar['id'];
		$Resstatus  = $this->forgingblock->GetStatus($this->invoiceID, $data['coin']);
		
		$this->coin_wallet = $Resstatus['btcAddress'];
		$this->coin_amount = $Resstatus['orderAmount'];
		$this->currency = $data['currency'];
		$this->amount = $data['amount'];
		$this->coin = $data['coin'];
		$this->coin_fullname = sanitize_str(ucfirst($this->forgingblock->CoinFullName()));
		$this->coin_logo = sanitize_str($this->forgingblock->coinLogo());
			
		if (isset($this->coin_wallet)) {
            $paymentID = quickRandom(15);			            			          
            
            $prdata = [
                'user_id'   => 1, 
                'invoiceID' => $this->invoiceID,
                'productID' => $paymentID,
                'amount_coin'    => $this->coin_amount,
                'amount'    => $this->amount, 
				'currency'    => $this->currency, 				                
                'address' => $this->coin_wallet,
                'coinLabel'      => $this->coin,
                'invoiceCreatedDate'   => $Resstatus['invoiceCreatedDate'],
                'txDate' => date('Y-m-d H:i:s'),

             ];   
                
            if ($product->create($prdata)) {            
                $product = $product->readOne($this->invoiceID);               
            }
            
            else {
                throw new \Exception('unable to create product table');
            }
            
        } else {
            throw new \Exception('unabel to conncat api ');
        }
		
		
		return $Resstatus;						
		
	}
	
	function update_status ($invoiceID)	
	{
		global $database;
        global $db;
        global $product;
		
		$CheckStatus = $product->readOne($invoiceID);
    
    	if (!$CheckStatus)
    	{
        	return;
    	}
		if (($CheckStatus->status == 'complete') || ($CheckStatus->status == 'confirmed') || ($CheckStatus->status == 'expired')) {
				return;
		}
		
		$this->forgingblock->SetValue('invoice', $invoiceID);		
		$resar = $this->forgingblock->CheckInvoiceStatus();		
		$payment_status = $this->forgingblock->GetInvoiceStatus();
	
	

	
	// set product property values
        $data = [            
			'amount_paid'         => $resar['realAmount'],
            'txID'         => $invoiceID,
            'txConfirmed'   => date('Y-m-d H:i:s'),
            'txDate'        => date('Y-m-d H:i:s'),
            'status'        => $payment_status,

         ];   

        // update the product
        $product->update($data, $invoiceID);
	
		
	}
	
    function display_qrbox()
    {        
        
		
		
        $box = '<div class="panel panel-default" id="PaymentBox_' . sanitize_str($this->coin_wallet) . '">
            <div class="panel-body mb-5">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <h3><span class="text text-warning"><img src="' . $this->coin_logo . '" width="32"></span> ' . $this->coin_fullname . ' Payment Box</h3>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        ' . $this->QRCode() . '
                    </div>
                    <div class="col-sm-8 col-md-8 col-lg-8 p-2">
                        <h3>Send <b><span id="amount">' . $this->coin_amount . '</span> <span id="coin">' . sanitize_str(strtoupper($this->coin)) . '</span></b> <img class="copyImg copy-img" id="copyImg" src="assets/img/copy.svg" data-clipboard-target="#amount"  data-toggle="tooltip" data-placement="top" title="Copy"></h3>

                        <br/><span id="copyWallet" class="copyWallet" data-original-title="Copy Wallet" data-clipboard-target="#address" data-placement="bottom" data-toggle="tooltip">
						<input type="hidden" id="invoiceID" value="'.$this->invoiceID.'">						
						<input type="text" id="address" class="form-control" value="' . sanitize_str($this->coin_wallet) . '"></span><spam class="display-hide" id="wallet">' . sanitize_str($this->coin_wallet) . '</spam>
                        or scan QR Code with your mobile device<br/><br/>
                        <small>If you send any other ' . sanitize_str(strtoupper($this->coin)) . ' amount, payment system will ignore it!</small>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12">
                        <center> <div id="paymentStat">
                                    <span class="text text-info"><i class="fa fa-spin fa-spinner"></i> Awaiting payment...</span>
                                </div></center>
                                <p class="card-text" id="tips"></p>
                    </div>
                </div>
            </div>
        </div>
        ';
        return $box;
    }
    
    function QRCode()    
	{                
        
        return '<img data-toggle="tooltip" data-placement="bottom" title="QR Code - Bitcoin address and sum you can scan with a mobile phone camera. Open Bitcoin Wallet, click on camera icon, point the camera at the code, and you\'re done" src="https://chart.googleapis.com/chart?chs=500x500&cht=qr&chl=' . strtolower($this->coin_fullname) . ':' . sanitize_str($this->coin_wallet) . '?amount=' . ($this->coin_amount) . '&choe=UTF-8" class="img-responsive qr-display">';
    }
    
}

?>