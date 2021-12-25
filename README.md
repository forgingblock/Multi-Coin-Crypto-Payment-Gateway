# Multi-Coin-Crypto-Payment-Gateway
PHP cryptocurrency payment processor based on ForgingBlock API

![image](https://user-images.githubusercontent.com/3922791/138219914-61e07daf-7b14-4587-bf03-6df517821f96.png)


## Requirements
PHP 5.6.0 and later.

## Installation
you can download the [latest release](https://github.com/forgingblock/Multi-Coin-Crypto-Payment-Gateway)

## Create Database
Open a MySql client (phpMyAdmin, etc.), create a new database (and user) and import database.sql

## Configuration
edit inc/config.php and set those
```php
'app' => array(
        'debug' => true,    
		'forgingblock_token' => '',        
		'forgingblock_trade' => '',        		
		'forgingblock_env' => 'test',		
        'url' => 'http://localhost/forgingblock-multicoin/',		        
        'expiring_time' => 43200,        
        'timezone' => 'UTC',            
    ),
    
    //Mysql Database connection
    'mysql' => array(                
        'database' => 'forgingblock_mcrypto',
        'username' => '',               
        'password' => '',        
        'hostname' => 'localhost',        
        'prefix' => '',                
        'driver' => 'mysqli',                
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci'
    )
```

## Usage
Simple usage edit index.php
```php
$data = array (
	"amount"=>1,
	"currency"=>"USD",
	"coin"=>"BTC",	
	"order_id"=>'T0001',	
	"notifyurl"=>$notifyURL,	
);
//for tether coins use like this "coin"=>"eth-token/USDT",	
```
