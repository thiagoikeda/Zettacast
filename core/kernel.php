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
	 * Propriedade estática responsável pelo armazenamento
	 * temporário de dados da aplicação.
	 * @todo Remover essa propriedade.
	 * @var array Lista com dados da aplicação.
	 */
	public static $data = [];
	
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e executar
	 * todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Kernel
	 */
	public function __construct() {
		
		spl_autoload_register([$this, "__load"]);
		date_default_timezone_set(Config::get('app.timezone'));

		$page = URI::segment(1) ?: 'main';
		$this->addpage($page);
		
	}
	
	/**
	 * Carrega objetos não existentes na execução automaticamente.
	 * Isso permite que não haja preocupações relacionadas à
	 * existência ou não de um objeto.
	 * @brief Carrega objetos automaticamente.
	 * @param string $name Nome do objeto a ser carregado.
	 * @retval boolean Objeto carregado com sucesso?
	 */
	public function __load($name) {
		
		$fn = strtolower($name);
		
		if(file_exists(CORE."/{$fn}.php")):
			$this->modules[] = $fn;
			require CORE."/{$fn}.php";
			return true;
		endif;
		
		return false;
		
	}
	
	private function addpage($pgname) {
		
		$fn = PAGE."/{$pgname}/controller.php";
		file_exists($fn) ?: include ERROR.'/404.php';
		
		require FUNC.'/basic.php';
		Basic\addcss('global', 'all');
		Basic\addjs('jquery');
		
		require $fn;
		
	}
		
}