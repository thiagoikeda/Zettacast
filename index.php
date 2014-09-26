<?php

/**
 * @what Criação de constantes de auxílio de diretórios.
 * @why Facilitar a inclusão de  arquivos.
 */
define('ROOT', getcwd());
define('CONFIG', ROOT.'/config');
define('ERROR', ROOT.'/error');
define('CORE', ROOT.'/core');
define('LOG', ROOT.'/log');

/**
 * @what Inclusão de arquivos iniciais.
 * @why Permitir inicio de execução.
 */
require CONFIG.'/app.php';
require CORE.'/kernel.php';

/**
 * @what Inicialização de execução da requisição.
 * @why Executar, renderizar e exibir a requisição.
 */
new Kernel;