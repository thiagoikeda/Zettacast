<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Session {

	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;
	
	/**
	 * @var array Variáveis de sessão.
	 */
	private $sessvar = [];

	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Session
	 */
	protected function __construct() {
		
		session_set_cookie_params(
			Config::get('session.lifetime'),
			Config::get('session.path'),
			Config::get('session.domain'),
			Config::get('session.secure'),
			Config::get('session.httponly')
		);
				
		session_name(Config::get('session.name', 'sess'));
		session_start();
		
		$this->sessvar = &$_SESSION;
		unset($_SESSION);
				
	}
	
	/**
	 * @brief
	 * @param string $name Nome da variável a ser resgatada.
	 * @param mixed $default Valor padrão de retorno.
	 * @retval mixed
	 */
	public static function get($name = null, $default = null) {
		
		if($name === null):
			return self::i()->sessvar;
		elseif(isset(self::i()->sessvar[$name])):
			return self::i()->sessvar[$name];
		else:
			return $default;
		endif;
		
	}
	
	/**
	 * @brief
	 * @param string|array $var Uma ou mais Variáveis a serem criadas ou modificadas.
	 * @param mixed $value Valor a ser armazenado.
	 * @retval null
	 */
	public static function set($var, $value = null) {
				
		$variable = is_array($var) ? $var : [$var => $value];
		
		foreach($variable as $name => $val):
			self::i()->sessvar[$name] = $val;
		endforeach;
				
	}

	/**
	 * @brief
	 * @param string $name Nome da variável a ser excluída.
	 * @retval null
	 */
	public static function delete($name) {
		
		if(isset(self::i()->sessvar[$name])):
			unset(self::i()->sessvar[$name]);
		endif;
				
	}
	
	/**
	 * @brief Destrói a sessão atual.
	 * @retval null
	 */
	public static function destroy() {
		
		self::i();
		session_destroy();
		
	}
	
	/**
	 * @brief
	 * @yields array Nome e conteúdo da variável de sessão.
	 */
	public static function iterator() {
		
		foreach(self::i()->sessvar as $name => $value):
			yield [$name => $value];
		endforeach;
		
	}

}