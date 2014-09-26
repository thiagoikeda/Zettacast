<?php

/**
 * Objeto de conexão e transições com o banco de dados. Classe
 * responsável pelo encapsulamento de todas as interações com
 * o banco de dados.
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class DB {
	
	/**
	 * Instância singleton do objeto de banco de dados.
	 * Todas as transações realizadas no banco conectado
	 * passarão por essa instância.
	 * @var DB Objeto singleton do banco de dados.
	 */
	private static $connection;
	
	/**
	 * Inicialização e construção de instância de classe.
	 * MÃ©todo responsável por gerenciar, administrar e executar
	 * todas as ações do objeto.
	 * @return DB
	 */
	public function __construct() {
		if(!self::$connection):
			try {
				$dsn = 'mysql:host='.App::dbhost.';dbname='.App::dbname.';charset=utf8';
				self::$connection = new PDO($dsn, App::dbuser, App::dbpass);
			}

			catch(PDOException $e) {
				Log::error('db', 'connection to db failed');
				require ERROR.'/500.php';
			}
		endif;
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function beginTransaction() {
		return self::$connection->beginTransaction();
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function commit() {
		return self::$connection->commit();
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function errorCode() {
		return self::$connection->errorCode();
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function errorInfo() {
		return self::$connection->errorInfo();
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function exec($statement) {
		return self::$connection->exec($statement);
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function getAttribute($attribute) {
		return self::$connection->getAttribute($attribute);
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function inTransaction() {
		return self::$connection->inTransaction();
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function lastInsertId($name = NULL) {
		return self::$connection->lastInsertId($name);
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function prepare($statement, array $driver_options = []) {
		return self::$connection->prepare($statement, $driver_options);
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function query($statement) {
		return self::$connection->query($statement);
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function quote($string, $parameter_type = PDO::PARAM_STR) {
		return self::$connection->quote($string, $parameter_type);
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function rollBack() {
		return self::$connection->rollBack();
	}
	
	/**
	 * @todo Documentação.
	 */
	public static function setAttribute($attribute, $value) {
		return self::$connection->setAttribute($attribute, $value);
	}
	
}
