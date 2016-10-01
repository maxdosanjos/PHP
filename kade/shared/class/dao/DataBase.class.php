<?php
/**
 * DataBase
 * Classe para criar inst�ncias de conex�o com o banco de dados
 * Obs.: Antigamente esta classe era singleton
 */
class DataBase extends PDO {
	//private function __construct(){}
	/**
	 * Instancia DataBase
	 * propriedade para a implementacao do design pattern singleton
	 *
	 * @var DataBase
	 * @static
	 */
	private static $_instance = null;
	
	/**
	 * Destrutor
	 * Quando o objeto for destruido a conexao e fechada
	 *
	 * @param void
	 * @return void
	 */
	public function  __destruct() {
	
		self::$_instance  = null;
	}
	/**
	 * Retorna DataBase
	 * Esse metodo verifica se ja existe na memoria uma instancia
	 * da classe de DataBase
	 * Se existir apenas retorna
	 * se nao instancia
	 *
	 * @param void
	 * @return DataBase
	 */
	/**
	 * Cria e retorna um objeto database (PDO)
	 * Retorna uma inst�ncia da conex�o com o banco de dados. Este m�todo era
	 * singleton por�m o WebMax possui algumas transa��es que usando conex�es
	 * diferentes simultaneamente.
	 *
	 * @param DBConfig $config Configura��o do banco de dados
	 * @return DataBase
	 */
	public static function getInstance(DBConfig $config,$useSSL=false){	
		$option = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
		);
		
		
		// SSL com PDO MySQL s� funciona a partir da vers�o 5.3.7.
		/*if($useSSL){
			$keyFolder = "/home/cpd/security/";
			$MYSQL_ATTR_SSL_KEY = 1007;
			$MYSQL_ATTR_SSL_CERT = 1008;
			$MYSQL_ATTR_SSL_CA = 1009;
			
			$option[$MYSQL_ATTR_SSL_KEY] = $keyFolder."mysql-ssl-client-key";
			$option[$MYSQL_ATTR_SSL_CERT] = $keyFolder."mysql-ssl-client-cert.pem";
			$option[$MYSQL_ATTR_SSL_CA] = $keyFolder."mysql-ssl-ca-cert.pem";
		}*/
		return new self($config->getStrConnection(),$config->getUser(),$config->getPassword(),$option);
		/*if(self::$_instance===null){
			$option = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
			var_dump($config->getStrConnection());
			self::$_instance = new self($config->getStrConnection(),$config->getUser(),$config->getPassword(),$option);
		}
		return self::$_instance;*/	
		}
	
	/**
	 * Imprime os drivers dispon�veis no servidor
	 */
	public function viewDrivers(){
		foreach(parent::getAvailableDrivers() AS $driver){
			echo $driver."<br />";
		}
	}
	
}
?>