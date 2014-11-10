<?php

/**
 * @brief Núcleo de controle e execução da aplicação.
 * Núcleo de execução de aplicação. Classe responsável por
 * organizar, controlar e executar toda a lógica da
 * aplicação e apresentar os dados ou a visão requisitada
 * pelo usuário.
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Kernel {
	
	/**
	 * @defgroup KernelVars Instâncias de objetos.
	 * Variáveis estáticas que referenciam as instâncias
	 * dos objetos globais inicializados com o núcleo
	 * da execução da aplicação.
	 * @{
	 */
	public static $config;
	public static $log;
	public static $db;
	public static $url;
	public static $user;
	/**@}*/
	
	/**
	 * @brief Constrói e inicializa uma nova instância.
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e executar
	 * todas as ações do objeto.
	 * @retval Kernel
	 */
	public function __construct() {
		session_name('sess');
		session_start();
		
		require CORE.'/config.php';
	#	require CORE.'/log.php';
		require CORE.'/db.php';
	#	require CORE.'/url.php';
	#	require CORE.'/user.php';
		
		self::$config = new Config;
	#	self::$log = new Log;		
		self::$db = new DB;
	#	self::$url = new URL;
	#	self::$user = new User;
								
	}
	
}