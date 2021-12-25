<?php
$GLOBALS['config'] = array(
    
    'app' => array(
        'debug' => true,    
		'forgingblock_token' => '',        
		'forgingblock_trade' => '',        		
		'forgingblock_env' => 'test',		
        'url' => 'http://localhost/forgingblock-multicoin/',		        
        'expiring_time' => 43200,
        'color_scheme' => 'blue',
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
    
);

class Config
{
    
    public static function get($index)
    {
        global $config;
        $index = explode(':', $index);
        return self::getValue($index, $config);
    }
   
    private static function getValue($index, $value)
    {
        if (is_array($index) and count($index)) {
            $current_index = array_shift($index);
        }
        if (is_array($index) and count($index) and is_array($value[$current_index]) and count($value[$current_index])) {
            return self::getValue($index, $value[$current_index]);
        } else {
            return $value[$current_index];
        }
    }
}
