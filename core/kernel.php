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
	 * Propriedade responsável por listar todas os módulos
	 * carregados e em uso pela aplicação.
	 * @var array Lista de módulos carregados.
	 */
	public $modules = [];
	
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e executar
	 * todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Kernel
	 */
	public function __construct() {
		
		spl_autoload_register([$this, "__load"]);
				
	}
	
	/**
	 * Carrega objetos não existentes na execução automaticamente.
	 * Isso permite que não haja preocupações relacionadas à
	 * existência ou não de um objeto.
	 * @brief Carrega objetos automaticamente.
	 * @param string $name Nome do objeto a ser carregado.
	 * @retval boolean Objeto carregado com sucesso?
	 */
	public function __load($name){
		
		$fn = strtolower($name);
		
		if(file_exists(CORE."/{$fn}.php")):
			$this->modules[] = $fn;
			require CORE."/{$fn}.php";
			return true;
		endif;
		
		return false;
		
	}
		
}