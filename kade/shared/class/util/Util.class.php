<?
class Util {
	public static function bigIntval($value) {
		$value = trim ( $value );
		if (ctype_digit ( $value )) {
			return $value;
		}
		$value = preg_replace ( "/[^0-9](.*)$/", '', $value );
		if (ctype_digit ( $value )) {
			return $value;
		}
		return 0;
	}
	public static function getClientIP() {
		if (array_key_exists ( 'HTTP_CLIENT_IP', $_SERVER )) {
			$ip = trim ( $_SERVER ['HTTP_CLIENT_IP'] );
			if (self::validateIP ( $ip )) {
				return $ip;
			}
		}
		if (array_key_exists ( 'HTTP_X_FORWARDED_FOR', $_SERVER )) {
			$ip = trim ( $_SERVER ['HTTP_X_FORWARDED_FOR'] );
			if (self::validateIP ( $ip )) {
				return $ip;
			} elseif (strpos ( $ip, ',' ) !== false) {
				$ips = explode ( ',', $ip );
				foreach ( $ips as $ip ) {
					$ip = trim ( $ip );
					if (self::validateIP ( $ip )) {
						return $ip;
					}
				}
			} elseif (strpos ( $ip, ';' ) !== false) {
				$ips = explode ( ';', $ip );
				foreach ( $ips as $ip ) {
					$ip = trim ( $ip );
					if (self::validateIP ( $ip )) {
						return $ip;
					}
				}
			}
		}
		if (array_key_exists ( 'REMOTE_ADDR', $_SERVER )) {
			$ip = trim ( $_SERVER ['REMOTE_ADDR'] );
			if (self::validateIP ( $ip )) {
				return $ip;
			}
		}
		
		return '0.0.0.0';
	}
	
	/**
	 * Valida um IP v4
	 * 
	 * @param string $ip:
	 *        	IP a ser validado
	 * @return bool
	 * @see http://rubsphp.blogspot.com.br/2010/12/obter-o-ip-do-cliente.html
	 */
	public static function validateIP($ip) {
		// IPv4
		$vetor = explode ( '.', $ip );
		if (count ( $vetor ) != 4) {
			return false;
		}
		foreach ( $vetor as $i ) {
			if (! is_numeric ( $i ) || $i < 0 || $i > 255) {
				return false;
			}
		}
		return true;
	}
	public static function mask($val, $mask) {
		$maskared = '';
		$k = 0;
		for($i = 0; $i <= strlen ( $mask ) - 1; $i ++) {
			if ($mask [$i] == '#') {
				if (isset ( $val [$k] ))
					$maskared .= $val [$k ++];
			} else {
				if (isset ( $mask [$i] ))
					$maskared .= $mask [$i];
			}
		}
		return $maskared;
	}
}
?>