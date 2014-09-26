<?php

/**
 * Núcleo de execução de aplicação. Classe responsável por
 * organizar, controlar e executar toda a lógica da
 * aplicação e apresentar os dados ou a visão requisitada
 * pelo usuário.
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Kernel {
	
	/**
	 * Instância de conexão de banco de dados, responsável
	 * por encapsular todas as transações com o banco de dados.
	 * @var DB Objeto de conexão ao banco de dados.
	 */
	public static $db;
		
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e executar
	 * todas as ações do objeto.
	 * @return Kernel
	 */
	public function __construct() {
		date_default_timezone_set(App::timezone);
		session_name('sess');
		session_start();
		
		require CORE.'/db.php';
		self::$db = new DB;
				
	}
	
}