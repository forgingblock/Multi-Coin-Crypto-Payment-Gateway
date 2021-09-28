<?php

use Whoops\Handler\Handler;

/**
 *  Convert special characters to HTML entities.
 *
 * @param  string  $value
 * @return string
 */

if(!function_exists('fomat_output')){

        function fomat_output($value, int $strip = 0)
        {
            
            $value = trim($value);
            $value = cleanString($value);
            $value = htmlspecialchars($value, ENT_QUOTES);
            
            if ($strip == 1) {
                $string = stripslashes($value);
            }
            $value = str_replace('&amp;#', '&#', $value);
            return $value;
        }

}

/**
 *  Search and replace the content.
 *
 * @param  string  $value
 * @return string
 */

if(!function_exists('cleanString')){
   
    function cleanString(string $value)
    {
        return $value = preg_replace("/&#?[a-z0-9]+;/i", "", $value);
    }

}

/**
 * Convert a value to non-negative integer.
 * 
 * @param  mixed $value
 * @return int
 */

if(!function_exists('absint')){

    function absint($value)
    {
        return abs(intval($value));
    }

}

/**
 * Return the given object.
 *
 * @param  mixed  $object
 * @return mixed
 */

if(!function_exists('with')){


    function with($object)
    {
        return $object;
    }


}



/**
 * Generate a more truly "random" alpha-numeric string.
 *
 * @param  int  $length
 * @return string
 */

if(!function_exists('random')){

    function random($length = 16)
    {
        $string = '';
        
        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            
            $bytes = random_bytes($size);
            
            $string .= substr(str_replace(array(
                '/',
                '+',
                '='
            ), '', base64_encode($bytes)), 0, $size);
        }
        
        return $string;
    }
}

/**
 * Generate a "random" alpha-numeric string.
 *
 * Should not be considered sufficient for cryptography, etc.
 *
 * @deprecated since version 1.3. Use the "random" method directly.
 *
 * @param  int  $length
 * @return string
 */

if(!function_exists('quickRandom')){


        function quickRandom($length = 16)
        {
            if (PHP_MAJOR_VERSION > 5) {
                return random($length);
            }
            
            $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
            return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
        }


}

/**
 * Get the current url.
 *
 * @return string
 */

if(!function_exists('get_current_url')){

    function get_current_url()
    {
        $https = !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off';
        return ($https ? 'https://' : 'http://') . (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'] . '@' : '') . (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'] . ($https && $_SERVER['SERVER_PORT'] === 443 || $_SERVER['SERVER_PORT'] === 80 ? '' : ':' . $_SERVER['SERVER_PORT']))) . $_SERVER['REQUEST_URI'];
    }
}








/**
 * Sanitizes a string key.
 *
 * @param string $key String key
 * @return string Sanitized key
 */

if(!function_exists('sanitize_key')){

    function sanitize_key($key)
    {
        $key = strtolower($key);
        $key = preg_replace('/[^a-z0-9_\-]/', '', $key);
        
        return $key;
    }

}
/**
 * Sanitize a String
 *
 * @param  string  $value
 * @return string
 */


if(!function_exists('sanitize_str')){

    function sanitize_str(string $string)
    {
        $string = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }

}

/**
 * Validate an Integer Number
 *
 * @param  string  $value
 * @return string
 */
if(!function_exists('sanitize_int')){

    function sanitize_int(string $string)
    {
        $string = filter_var($string, FILTER_VALIDATE_INT);
        return $string;
    }

}



/**
 * Validate a float Number
 *
 * @param  string  $value
 * @return string
 */

if(!function_exists('sanitize_float')){

    function sanitize_float(string $string)
    {
        $string = filter_var($string, FILTER_VALIDATE_FLOAT);
        return $string;
    }

}

/**
 * check is_null() 
 *
 * @param  string  $value
 * @return string
 */

if(!function_exists('check_null')){

    function check_null($var) 
    { 
        return (is_null($var) ? "True" : "Flase"); 
    } 

}

/**
 * Get the url to the asset file
 *
 * @param   string  $path
 * @return  string
 */

if(!function_exists('asset_url')){

    function asset_url($path = '')
    {

        $asset_path = 'assets/'.$path;

        return Config::get('app:url').'/'.$asset_path;
    }

}

/**
 * Redirect to given URL.
 *
 * @param  string  $url
 * @return void
 */
if(!function_exists('redirect_to')){

    function redirect_to($url)
    {
       
        if (headers_sent()) {
            echo '<html><body onload="redirect_to(\''.$url.'\');"></body>'.
                '<script type="text/javascript">function redirect_to(url) {window.location.href = url}</script>'.
                '</body></html>';
        } else {
            header('Location:' . $url);
        }

        exit;
    }

}

/**
 * Get timeAgo 
 *
 * @param   string  $datetime
 * @return  json
 */
if(!function_exists('time_elapsed_string')){

    function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : '1 sec ago';
    }

}

/**
 * Multi-coin get rates and supported coins
 *
 * @param   string $amount
 * @return  json rates, coins
 */

if(!function_exists('api_coins')){

    function api_coins(int $amount){
        global $convert;
        
        $data= array();
        $coins = Config::get('app:coins');
        foreach ($coins as $key => $coin)
        {
            if ($key == 'btc') {
                $rateNow = $convert->toBtc($amount, 'USD');
            }else{
                $rate = $convert->toBtc($amount, 'USD');
                $rateNow = to_currency(strtoupper($key), $rate);
            }
            $data [] = [
            'coin' => $key,
            'name' => $coin,
            'rate' => $rateNow,
            'coin_logo' => 'assets/img/'.$key.'.png',
        ];

        }

        return $data;

    }

}



if (!function_exists('coin_format')) {
    
    function coin_format(int $amount = 50, string $coin ='btc'){
        global $convert;

        if ($coin != 'btc') {
            $rateNow = $convert->toBtc($amount, 'USD');
        }else{
            $rate = $convert->toBtc($amount, 'USD');
            $rateNow = to_currency(strtoupper($coin), $rate);
        }

        return sprintf('%.8f', $rateNow);
    }
}



if (!function_exists('startExceptionHandling')) {

        function startExceptionHandling($whoops){

           if (Config::get('app:debug')) {
                    if (isAjaxRequest()) {
                        $handler = (new \Whoops\Handler\JsonResponseHandler)->addTraceToOutput(true);
                    } else {
                        $handler =  new \Whoops\Handler\PrettyPageHandler;
                    }
                } else {
                    $handler = new PlainDisplayer;
                }

               $whoops->pushHandler($handler);
               $whoops->register();


        }

}


if (!function_exists('isAjaxRequest')) {

/**
     * Check if is an AJAX request.
     *
     * @return bool
     */
    function isAjaxRequest()
    {
        return (!empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }


}
