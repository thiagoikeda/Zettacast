<?php

/**
 * Constantes de nomes de diretórios. As constantes
 * definidas nesse grupo, tem como objetivo, auxiliar
 * na inclusão de arquivos que encontram-se em muitos
 * diretórios diferentes.
 * @defgroup DirConst Constantes de Diretórios.
 * @{
 */
define('ROOT', getcwd());
define('CONFIG', ROOT.'/config');
define('ERROR', ROOT.'/error');
define('CORE', ROOT.'/core');
define('PAGE', ROOT.'/page');
define('FUNC', ROOT.'/func');
define('LOG', ROOT.'/log');
/**@}*/

/*
 * Inclusão de arquivos iniciais para permitir o
 * início de execução da aplicação.
 */
require CONFIG.'/app.php';
require CORE.'/kernel.php';

/*
 * Inicializa a execução da requisição e geração de
 * uma resposta ao cliente. O objeto instanciado será
 * responsável por executar, renderizar e retornar a
 * resposta da requisição feita pelo usuário.
 */
new Kernel;
