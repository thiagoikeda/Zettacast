<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Config {
	
	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;

	/**
	 * @var array Lista de dados de configurações.
	 */
	protected $data = [];
	
	/**
	 * @var array Lista de arquivos já lidos.
	 */
	protected $files = [];
	
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Config
	 */
	protected function __construct() {
		
		self::$instance = $this;
		self::load('general', false);
				
	}
		
	/**
	 * @brief
	 * @param string $element Configuração a ser buscada.
	 * @param mixed $default Opção retornada caso configuração não exista.
	 * @retval mixed
	 * @see set
	 */
	public static function get($element, $default = null) {

		$found = self::find($element, false);		
		return $found instanceof Config ? $default : $found;
						
	}
	
	/**
	 * @brief
	 * @param string $element Configuração a ser adicionada.
	 * @param string $value Valor da configuração adicionada.
	 * @retval null
	 * @see get
	 */
	public static function set($element, $value) {
		
		$found = &self::find($element, true);
		$found = $value;
		
	}

	/**
	 * @brief
	 * @param string $target Configuração a ser encontrada.
	 * @param bool $build Construir árvore de configuração não existente.
	 * @retval &mixed Seção ou configuração encontrada.
	 * @see get, set
	 */
	protected static function &find($target, $build){
		
		$cpath = explode('.', $target);
		$select = &self::i()->data;
			
		foreach($cpath as $pth):
			if(is_array($select) and isset($select[$pth])):
				$select = &$select[$pth];
			elseif(is_array($select) and $build):
				$select[$pth] = [];
				$select = &$select[$pth];
			elseif($build):
				$select = [$pth => []];
				$select = &$select[$pth];
			else:
				return self::i();
			endif;
		endforeach;
				
		return $select;
			
	}
	
	/**
	 * @brief
	 * @param string $file Arquivo a ser lido.
	 * @param string|bool $group Definição de grupo.
	 * @param bool $reload Recarregar arquivo já aberto?
	 * @retval bool O arquivo foi aberto e lido?
	 */
	public static function load($file, $group = true, $reload = false) {
		
		if( (!$reload and in_array($file, self::i()->files))
			or !file_exists(CONFIG."/{$file}.php")
		):
			return false;
			
		endif;
		
		$data = include CONFIG."/{$file}.php";
		self::i()->files[] = $file;
		
		if(is_string($group)):
			self::i()->data[$group] = $data;
		elseif(!$group):
			self::i()->data = array_merge(self::i()->data, $data);
		else:
			self::i()->data[$file] = $data;
		endif;
		
		return true;
		
	}
	
	/**
	 * @brief
	 * @param string $group Grupo a ser salvo.
	 * @param string|null $file Arquivo de destino.
	 * @retval bool Houve sucesso ao salvar?
	 */
	public static function save($group, $file = null){
		
		$g = self::find($group, false);
		$data = str_replace('  ', "\t", var_export($g, true));
		$content = "<?php\n\nreturn {$data};\n";
		$fname = $file ?: str_replace('.', '/', $group);
		
		if($g instanceof Config):
			return false;
		endif;
		
		return (bool)file_put_contents(CONFIG."/{$fname}.php", $content);
				
	}
	
}
