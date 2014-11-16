<?php

/**
 * Objeto de conexão e transições com o banco de dados. Classe
 * responsável pelo encapsulamento de todas as interações com
 * o banco de dados.
 * @brief Operações e transações com banco de dados.
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class DB {
	
	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;
	
	/**
	 * Objeto de conexão de banco de dados.
	 * Todas as operações realizadas no banco conectado
	 * serão realizadas através dessa propriedade.
	 * @var DB Objeto de conexão do banco de dados.
	 */
	private $conn;
	
	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval DB
	 */
	public function __construct() {
		
		try {
			$dsn = sprintf(
				"%s:host=%s;dbname=%s;charset=%s",
				Config::get('db.driver'), App::dbhost, App::dbname,
				Config::get('db.charset')
			);
			
			$this->conn = new PDO($dsn, App::dbuser, App::dbpass);
			
		}
		
		catch (PDOException $e) {
			Log::error('connection to db failed');
			require ERROR.'/500.php';
			
		}
		
	}
	
	/**
	 * Desconstrução e finalização de objetos instanciados
	 * durante o tempo de vida dessa classe.
	 * @brief Desconstrói e encerra instâncias.
	 */
	public function __destruct() {
		
		$this->conn = null;
	
	}
	
	/**
	 * Inicializa uma transação com o banco de dados, o que
	 * permite a execução de várias operações de forma segura.
	 * A transação somente é consolidada no banco de dados após
	 * cometimento. Caso necessário, as alterações podem ser
	 * desfeitas, ao bel-prazer, com um comando de reversão. A
	 * transação é finalizada em ambos os casos e as próximas
	 * operações enviadas ao banco de dados terão cometimentos
	 * realizados automaticamente, assim como o padrão inicial.
	 * @brief Inicializa transação de operações.
	 * @retval bool Houve sucesso na inicialização da transação?
	 * @see inblock, commit, rollback
	 */
	public static function transaction() {
		return self::i()->conn->beginTransaction();
	}
	
	/**
	 * Verifica se há, no momento, alguma transação ativa
	 * no banco de dados que ainda não foi cometida ou defeita.
	 * @brief Verifica se há uma transação ativa.
	 * @retval bool Há uma transação ativa?
	 * @see transaction, commit
	 */
	public static function inblock() {
		return self::i()->conn->inTransaction();
	}
	
	/**
	 * Executa cometimento na transação de instruções inicializada.
	 * Após o cometimento da transação, as operações realizadas
	 * subsequentemente terão cometimentos realizados de forma
	 * automática, dispensando, assim, o uso desse método para
	 * todas as operações seguintes com o banco de dados.
	 * @brief Finaliza uma transação de operações.
	 * @retval bool Houve sucesso no cometimento da transação?
	 * @see transaction, inblock, rollback
	 */
	public static function commit() {
		return self::i()->conn->commit();
	}
	
	/**
	 * Desfaz todas as operações realizadas pela transação
	 * ativa atualmente. Após a executação desse método,
	 * as operações retornarão ao modo de cometimento automático.
	 * @brief Desfaz a trasação atualmente ativa.
	 * @throw PDOException Não há transação ativa.
	 * @retval bool A trasação foi desfeita com sucesso?
	 * @see transaction, inblock, commit
	 */
	public static function rollback() {
		return self::i()->conn->rollBack();
	}
	
	/**
	 * Busca e retorna o código de erro gerado pela última
	 * operação realizada incorretamente no banco de dados.
	 * @brief Captura o código de erro da última operação.
	 * @retval mixed Código alfanumérico do erro encontrado.
	 */
	public static function errorcode() {
		return self::i()->conn->errorCode();
	}
	
	/**
	 * Busca e retorna as informações sobre o erro gerado
	 * pela última operação realizada incorretamente pelo
	 * banco de dados.
	 * @brief Captura o erro da última operação.
	 * @retval array Lista de informações do erro encontrado.
	 */
	public static function errorinfo() {
		return self::i()->conn->errorInfo();
	}
	
	/**
	 * Executa uma operação no banco de dados através de uma
	 * única chamada de função retornando o número de linhas
	 * afetadas. Essa função não retorna os resultados de
	 * uma operação de seleção.
	 * @brief Executa uma operação no banco de dados.
	 * @param string $statement Comando a ser executado.
	 * @retval int Número de linhas afetadas pela operação.
	 * @see prepare
	 */
	public static function execute($statement) {
		return self::i()->conn->exec($statement);
	}
			
	/**
	 * Prepara um comando a ser executado. O comando pode
	 * conter zero ou mais parâmetros nomeados ou anônimos
	 * cujos valores reais serão alterados quando o comando
	 * for executado. Não é possível misturar parâmetros
	 * nomeados (:nome) e anônimos (?) em um mesmo comando
	 * preparado.
	 * @brief Prepara um comando a ser executado.
	 * @param string $statement Comando a ser preparado.
	 * @param array $driver_options Opções de driver.
	 * @retval PDOStatement Objeto de comando preparado.
	 */
	public static function prepare($statement, array $driver_options = []) {
		return self::i()->conn->prepare($statement, $driver_options);
	}
	
	/**
	 * Executa um comando de banco de dados direta e rapidamente
	 * sem nenhum preparo, pré-processamento ou precauções, como
	 * higienização, que visam aumentar a segurança do banco de
	 * dados. É necessário cautela ao utilizar esse método.
	 * @brief Executa um comando do banco de dados.
	 * @warning O uso desse método pode, por vezes, ser inseguro.
	 * @param string $statement Comando a ser executado.
	 * @retval PDOStatement Objeto de comando executado.
	 * @see prepare, quote
	 */
	public static function query($statement) {
		return self::i()->conn->query($statement);
	}
		
	/**
	 * Adiciona aspas ao comando inserido, se necessário,
	 * e escapa caracteres especiais dentro do comando.
	 * Hipoteticamente, essa função torna o comando seguro
	 * para execuções diretas ao banco de dados.
	 * @brief Higieniza um comando de banco de dados.
	 * @param string $string Comando a ser higienizado.
	 * @param int $ptype Dica de tipo dos parâmetros.
	 * @retval string Comando higienizado hipoteticamente seguro.
	 * @see prepare
	 */
	public static function quote($string, $ptype = PDO::PARAM_STR) {
		return self::i()->conn->quote($string, $ptype);
	}
			
}
