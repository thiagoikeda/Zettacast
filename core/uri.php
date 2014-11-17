<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class URI {

	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;
	
	/**
	 * @var array Variáveis ENV da requisição.
	 */
	private $env;

	/**
	 * @var array Valores passados por GET à requisição.
	 */
	private $get;

	/**
	 * @var array Valores passados por POST à requisição.
	 */
	private $post;

	/**
	 * @future class Upload
	 * @var array Variáveis FILE passadas à requisição.
	 */
	private $files;

	/**
	 * @future class Server
	 * @var array Variáveis Server da requisição.
	 */
	private $server;

	/**
	 * @future class Request
	 * @var array Variáveis FILE passadas à requisição.
	 */
	private $request;
	
	/**
	 * @var string Base da URI dessa requisição.
	 */
	private $base;
	
	/**
	 * @var array Segmentos da URI atual.
	 */
	private $segments;
	
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval URI
	 */
	protected function __construct() {
		
		$this->env     = &$_ENV;
		$this->get     = &$_GET;
		$this->post    = &$_POST;
		$this->files   = &$_FILES;
		$this->server  = &$_SERVER;
		$this->request = &$_REQUEST;
		unset($_ENV, $_GET, $_POST, $_FILES, $_SERVER, $_REQUEST);
		unset($GLOBALS);
		
		$full = $this->server['SERVER_NAME'] . $this->server['REQUEST_URI'];
		$https = isset($this->server['HTTPS']) and $this->server['HTTPS'] != 'off';
		
		@list($request) = explode('?', $full, 2);
		list($base, $segments) = explode('/', $request, 2);
				
		$this->base = ($https ? 'https' : 'http') . "://{$base}/";
		$this->segments = explode('/', $segments);
				
	}
	
	/**
	 * @brief
	 * @return string Base da URI requisitada.
	 */
	public static function base() {
		
		return self::i()->base;
		
	}
	
	/**
	 * @brief
	 * @return string Requisição atual completa.
	 */
	public static function current() {
		
		return self::i()->base . implode('/', self::i()->segments);
		
	}
	
	/**
	 * @brief
	 * @param int $index Índice do segmento a ser acessado.
	 * @return string|bool
	 */
	public static function segment($index = null) {
		
		if(is_int($index) and count(self::i()->segments) > $index):
			return self::i()->segments[$index];
		endif;
		
		return false;
		
	}
		
	//public static function create($uri = null, $vars = [], $get = [], $secure = false) {}
	
	/**
	 * @brief
	 * @param string $name Nome da variável GET a ser resgatada.
	 * @param mixed $default Valor padrão de retorno.
	 * @retval mixed
	 */
	public static function get($name = null, $default = null) {
		
		if($name === null):
			return self::i()->get;
		elseif(isset(self::i()->get[$name])):
			return self::i()->get[$name];
		else:
			return $default;
		endif;
		
	}
	
	/**
	 * @brief
	 * @param string $name Nome da variável POST a ser resgatada.
	 * @param mixed $default Valor padrão de retorno.
	 * @retval mixed
	 */
	public static function post($name = null, $default = null) {
		
		if($name === null):
			return self::i()->post;
		elseif(isset(self::i()->post[$name])):
			return self::i()->post[$name];
		else:
			return $default;
		endif;
		
	}

}