<?php
class Validation {
	/**
	 * http://www.mxmasters.com.br/comunidade/viewtopic.php?f=50&t=4581
	 */
    public static function isCPF($CPF){
        $CPF = preg_replace("/[^0-9]/", "", $CPF);
        if (strlen($CPF) <> 11){
	    	return false;
	    }
        $digitoUm = 0;
        $digitoDois = 0;
        
        for($i = 0, $x = 10; $i <= 8; $i++, $x--){
            $digitoUm += $CPF[$i] * $x;
        }
        for($i = 0, $x = 11; $i <= 9; $i++, $x--){
            if(str_repeat($i, 11) == $CPF){
                return false;
            }
            $digitoDois += $CPF[$i] * $x;
        }
        
        $calculoUm  = (($digitoUm%11) < 2) ? 0 : 11-($digitoUm%11);
        $calculoDois = (($digitoDois%11) < 2) ? 0 : 11-($digitoDois%11);
        if($calculoUm <> $CPF[9] || $calculoDois <> $CPF[10]){
            return false;
        }
        return true;
    }
    
    /**
     * http://codigofonte.uol.com.br/codigo/php/validacao/validar-numero-do-cnpj
     */
    public static function isCNPJ($cnpj){
	    $cnpj     = preg_replace('/[^0-9]/', '', $cnpj);
        if(strlen($cnpj) <> 14){
            return false;
        }
        $calcular = 0;
        $calcularDois = 0;
        for ($i = 0, $x = 5; $i <= 11; $i++, $x--) {
            $x = ($x < 2) ? 9 : $x;
            $number = substr($cnpj, $i, 1);
            $calcular += $number * $x;
        }
        for ($i = 0, $x = 6; $i <= 12; $i++, $x--) {
            $x = ($x < 2) ? 9 : $x;
            $numberDois = substr($cnpj, $i, 1);
            $calcularDois += $numberDois * $x;
        }
 
        $digitoUm = (($calcular % 11) < 2) ? 0 : 11 - ($calcular % 11);
        $digitoDois = (($calcularDois % 11) < 2) ? 0 : 11 - ($calcularDois % 11);
 
        if ($digitoUm <> substr($cnpj, 12, 1) || $digitoDois <> substr($cnpj, 13, 1)) {
            return false;
        }
        return true;
    }
    
    /**
     * http://rafaelcouto.com.br/validar-com-expressoes-regulares-no-php/
     */
    public static function isCEP($CEP){
    	return preg_match("/^[0-9]{5}-[0-9]{3}$/", $CEP);
    }
    
    /**
     * http://stackoverflow.com/questions/3314493/check-for-valid-email-address
     */
    public static function isEmail($email){
    	return preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $email); 
    }
    
    /**
     * http://rafaelcouto.com.br/validar-com-expressoes-regulares-no-php/
     */
    public static function isDate($date){
    	return preg_match("/^[0-9]{2}/[0-9]{2}/[0-9]{4}$/i", $date);
    }
    
    /**
     * http://rafaelcouto.com.br/validar-com-expressoes-regulares-no-php/
     */
    public static function isPhone($phone){
    	$result1 = preg_match("/^[0-9]{11}$/", $phone); // DDD33333333
    	$result2 = preg_match("/^[0-9]{4}-[0-9]{4}$/", $phone); // 3333-3333
    	$result3 = preg_match("/^\([0-9]{3}\) [0-9]{4}-[0-9]{4}$/", $phone); // (DDD) 3333-3333
    	return ($result1 || $result2 || $result3); 
    }
    
    /**
     * http://rafaelcouto.com.br/validar-com-expressoes-regulares-no-php/
     */
    public static function isURL($URL){
    	return preg_match("|^http(s)?://[a-z0-9-]+(\.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $URL);
    }
    
    /**
     * http://crisp.tweakblogs.net/blog/2031/ipv6-validation-(and-caveats).html
     */
    public static function isIPv4($IP) {	
	    return $IP == long2ip(ip2long($IP));
	}
	
	 /**
     * http://crisp.tweakblogs.net/blog/2031/ipv6-validation-(and-caveats).html
     */
	public static function isIPv6($IP){ 
	    // fast exit for localhost 
	    if (strlen($IP) < 3){
	        return $IP == '::';
	    } 
	
	    // Check if part is in IPv4 format 
	    if (strpos($IP, '.')){ 
	        $lastcolon = strrpos($IP, ':'); 
	        if (!($lastcolon && self::isIPv4(substr($IP, $lastcolon + 1)))){
	            return false; 
	        }
	        // replace IPv4 part with dummy 
	        $IP = substr($IP, 0, $lastcolon).':0:0'; 
	    }
	
	    // check uncompressed 
	    if (strpos($IP, '::') === false){ 
	        return preg_match('/^(?:[a-f0-9]{1,4}:){7}[a-f0-9]{1,4}$/i', $IP); 
	    }
	
	    // check colon-count for compressed format 
	    if (substr_count($IP, ':') < 8){ 
	        return preg_match('/^(?::|(?:[a-f0-9]{1,4}:)+):(?:(?:[a-f0-9]{1,4}:)*[a-f0-9]{1,4})?$/i', $IP); 
	    }
	    return false; 
	}
}
?>