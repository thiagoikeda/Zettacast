<?php

/**
 * Núcleo de execução de aplicação. Classe responsável por
 * organizar, controlar e executar toda a lógica da
 * aplicação e apresentar os dados ou a visão requisitada
 * pelo usuário.
 * @brief Núcleo de controle e execução da aplicação.
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Kernel {
		
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e executar
	 * todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Kernel
	 */
	public function __construct() {
		session_name('sess');
		session_start();
	
		require CORE.'/singleton.php';
		require CORE.'/config.php';
		require CORE.'/log.php';
		require CORE.'/db.php';
	#	require CORE.'/url.php';
	#	require CORE.'/user.php';
		
	}
	
}