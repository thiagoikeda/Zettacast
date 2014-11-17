<?php

/**
 * @brief 
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
class Auth {

	/*
	 * Inclusão de contrato Singleton. Este contrato
	 * implementa o padrão Singleton que permite a existência
	 * de uma e apenas uma instância do objeto.
	 */
	use Singleton;
	
	protected $logged;
	private $data = [];

	/**
	 * Inicialização e construção de instância de classe.
	 * Método responsável por gerenciar, administrar e
	 * executar todas as ações do objeto.
	 * @brief Constrói e inicializa uma nova instância.
	 * @retval Auth
	 */
	protected function __construct() {
		
		$s	= $this->fromsession();
		$c	= !$s ? $this->fromcookie() : false;

		$this->logged = ($s or $c);
				
	}
	
	public static function active() {
		
		return self::i()->logged;
		
	}
	
	public static function get($name) {
		
		if(isset(self::i()->data[$name])):
			return self::i()->data[$name];
		else:
			return null;
		endif;
		
	}
	
	private function fromsession() {
		
		return (bool)($this->data = Session::get('user'));
		
	}
	
	private function fromcookie() {
		
		$data = @unserialize(base64_decode(Cookie::get('user')));
		return $data ? $this->checkcookie($data) : false;
		
	}
	
	private function checkcookie(array $data) {
		
		$sql = DB::prepare("call check_user(:login, :email, :uid)");
		$sql->bindParam(":login", $data['login'], PDO::PARAM_STR);
		$sql->bindParam(":email", $data['email'], PDO::PARAM_STR);
		$sql->bindParam(":uid", $data['uid'], PDO::PARAM_STR);
		$ret = (bool)($sql->execute() and $sql->rowCount());
		
		if($ret):
			$this->data = array_merge($data, $sql->fetch(PDO::FETCH_ASSOC));
			Session::set('user', $this->data);
		else:
			Cookie::delete('user');
		endif;
		
		return $ret;
		
	}
	
}