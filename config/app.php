<?php

/**
 * @brief Variáveis de configuração e conexão da aplicação.
 * Interface de armazenamento de variáveis de configuração
 * da aplicação. Dados confidenciais como acesso ao banco de
 * dados, além de outros dados importantes são armazenados aqui.
 * @author Rodrigo Siqueira <rodriados@gmail.com>
 * @since 0.1
 */
interface App {
	
	/**
	 * Servidor de banco de dados. Essa diretiva informa o endereço
	 * do servidor em que o banco de dados está hospedado.
	 * @var string Servidor de banco de dados.
	 */
	const dbhost = 'localhost';
	
	/**
	 * Nome do banco de dados. Um servidor pode armazenar vários
	 * bancos de dados, e cada banco de dados é identificado por um nome.
	 * @var string Nome do banco de dados a ser conectado.
	 */
	const dbname = 'rootcms';
	
	/**
	 * Nome de usuário para acesso ao banco de dados. Informe seu nome
	 * ou identificação de usuário para acesso ao banco de dados em 
	 * modo de produção.
	 * @var string Nome de usuário para conexão ao banco de dados.
	 */
	const dbuser = 'root';
	
	/**
	 * Senha de acesso ao banco de dados. Em conjunto com o nome de
	 * usuário, permite acessar um banco de dados no servidor.
	 * @var string Senha de autenticação de conexão ao banco de dados.
	 */
	const dbpass = '';
			
}