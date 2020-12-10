<?php

session_start();

require_once 'app/Core/Core.php';
require_once 'vendor/autoload.php';

require_once 'lib/Database/Connection.php';

require_once 'app/Controller/HomeController.php';
require_once 'app/Controller/ErroController.php';
require_once 'app/Controller/FaturaController.php';
require_once 'app/Controller/ClienteController.php';

require_once 'app/Model/Model_cliente.php';
require_once 'app/Model/Model_fatura.php';

$template = file_get_contents('app/Template/estrutura.html');

ob_start();
	$core = new Core; 
	$core->start($_GET);
	$saida = ob_get_contents();
ob_end_clean();

$tplPronto = str_replace('{{ area_dinamica }}', $saida, $template);

echo $tplPronto;