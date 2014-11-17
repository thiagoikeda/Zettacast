<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Cookie {

	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;
	
	/**
	 * @var array Jarra de cookies.
	 */
	private $cookiejar = [];

	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Cookie
	 */
	protected function __construct() {
		
		$this->cookiejar = &$_COOKIE;
		unset($_COOKIE);
				
	}
	
	/**
	 * @brief
	 * @param string $name Nome do cookie a ser resgatado.
	 * @param mixed $default Valor padrão de retorno.
	 * @retval mixed
	 */
	public static function get($name, $default = null) {
		
		if(isset(self::i()->cookiejar[$name])):
			return self::i()->cookiejar[$name];
		else:
			return $default;
		endif;
		
	}
	
	/**
	 * @brief
	 * @param string $name Nome do cookie a ser criado ou modificado.
	 * @param mixed $value Valor a ser armazenado.
	 * @param int $expire Tempo de duração do cookie.
	 * @param string $path Caminhos de atuação do cookie.
	 * @param string $domain Domínios de atuação do cookie.
	 * @param bool $secure Disponibilidade apenas em conexões seguras?
	 * @param bool $httponly Disponibilidade apenas em HTTP?
	 * @retval null
	 */
	public static function set($name, $value, $expire = null, $path = null, $domain = null, $secure = null, $httponly = null) {
		
		self::i()->cookiejar[$name] = $value;
		
		setcookie(
			$name, $value,
			$expire   ?: Config::get('cookie.expire'),
			$path     ?: Config::get('cookie.path'),
			$domain   ?: Config::get('cookie.domain'),
			$secure   ?: Config::get('cookie.secure'),
			$httponly ?: Config::get('cookie.httponly')
		);
		
	}

	/**
	 * @brief
	 * @param string $name Nome do cookie a ser excluído.
	 * @param string $path Caminhos de atuação do cookie.
	 * @param string $domain Domínios de atuação do cookie.
	 * @param bool $secure Disponibilidade apenas em conexões seguras?
	 * @param bool $httponly Disponibilidade apenas em HTTP?
	 * @retval null
	 */
	public static function delete($name, $path = null, $domain = null, $secure = null, $httponly = null) {
		
		self::set($name, "", -86400, $path, $domain, $secure, $httponly);
		unset(self::i()->cookiejar[$name]);
		
	}
	
	/**
	 * @brief
	 * @yields array Nome e conteúdo do cookie.
	 */
	public static function iterator(){
		
		foreach(self::i()->cookiejar as $name => $value):
			yield [$name => $value];
		endforeach;
		
	}
	
}