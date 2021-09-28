<?php
class Product
{


    private $table_name = "crypto_payments";

    public $payWallet;


    // create product
    function create($data)
    {

        //write query
        $query = dibi::query('INSERT INTO  ' . $this->table_name . ' %v', $data);

        if ($query)
        {
            return true;
        }
        else
        {
            return false;
        }

    }

    function readOne($invoiceID)
    {

        $query = dibi::fetch('SELECT * FROM ' . $this->table_name . ' WHERE invoiceID = ?', $invoiceID);
        return $query;

        
    }



    function readSingleProduct($invoiceID)
    {

        $query = dibi::fetch('SELECT * FROM ' . $this->table_name . ' WHERE invoiceID = ?', $invoiceID);
        return $query;
        
    }
	function update($data, $invoiceID)
    {

       dibi::query('UPDATE ' . $this->table_name . ' SET %a', $data, 'WHERE invoiceID = ?', $invoiceID);

    }
	


    




}
?>
