<?php

/**
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
	 */
	const dbhost = 'localhost';
	
	/**
	 * Nome do banco de dados. Um servidor pode armazenar vários
	 * bancos de dados, e cada banco de dados é identificado por um nome.
	 */
	const dbname = 'rootcms';
	
	/**
	 * Nome de usuário para acesso ao banco de dados. Informe seu nome
	 * ou identificação de usuário para acesso ao banco de dados em 
	 * modo de produção.
	 */
	const dbuser = 'root';
	
	/**
	 * Senha de acesso ao banco de dados. Em conjunto com o nome de
	 * usuário, permite acessar um banco de dados no servidor.
	 */
	const dbpass = '';
	
	/**
	 * Fuso-horário da aplicação. Regulamenta e sincroniza todos os
	 * horários exibidos na aplicação de acordo com um fuso-horário.
	 */
	const timezone = 'America/Sao_Paulo';
		
}