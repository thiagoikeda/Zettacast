<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Log{

	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;
	
	/**
	 * @var array Arquivos de log abertos.
	 */
	private $files = [];
	
	/**
	 * @var bool Log está ativado?
	 */
	protected $active;
	
	/**
	 * @var string Nível de relatório mínimo ativado.
	 */
	protected $level;

	/**
	 * @defgroup LevelConst Constantes de nível de relatório.
	 * @{
	 */
	const emergency = 0x080;
	const alert     = 0x040;
	const critical  = 0x020;
	const error     = 0x010;
	const warning   = 0x008;
	const notice    = 0x004;
	const info      = 0x002;
	const debug     = 0x001;
	/**@}*/
	
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Log
	 */
	protected function __construct() {
		
		Config::load('log');
		$this->active = Config::get('log.active');
		$this->level = constant('self::'.Config::get('log.level')) ?: 0xFFFF;
		
	}
	
	/**
	 * Desconstrução e finalização de objetos instanciados
	 * durante o tempo de vida dessa classe.
	 * @brief Desconstrói e encerra instâncias.
	 */
	public function __destruct() {
		
		foreach($this->files as $file):
			fclose($file);
		endforeach;
	
	}
	
	/**
	 * @brief
	 * @param string $name Nível de relatório.
	 * @param array $arguments Argumentos do novo relatório.
	 * @retval null
	 */
	public static function __callStatic($name, $arguments) {

		list($fn, $string) = $arguments;
		
		if((constant('self::'.$name) ?: 0x000) < self::i()->level):
			return;
		endif;
		
		if(!array_key_exists($fn, self::i()->files)):
			self::i()->files[$fn] = @fopen(LOG."/{$fn}.log", 'a');
		endif;
		
		$content = sprintf("[%s][%s] %s\n", date(Config::get('log.date.format')), strtoupper($name), $string);
		fwrite(self::i()->files[$fn], $content);
		
	}
	
}
