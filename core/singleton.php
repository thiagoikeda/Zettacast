<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
trait Singleton {
	
	/**
	 * Instância singleton do objeto com o contrato.
	 * Todas as operações realizadas no objeto que
	 * utiliza esse contrato passarão por essa propriedade.
	 * @var object Instância singleton de objeto.
	 */
	protected static $instance;

	/**
	 * @brief
	 * @retval object Instância singleton de objeto.
	 */
	protected static function &i() {
		
		if(!isset(static::$instance)):
			static::$instance = new static;
		endif;
		
		return static::$instance;
		
	}
	
}