<?php

class HomeController
{
	public function index()
	{
		try {
			// $postagens = Postagem::selecionaTodos();

			$loader = new \Twig\Loader\FilesystemLoader('app/View');
			$twig = new \Twig\Environment($loader);
			$template = $twig->load('home/index.html');

			$params = array();
			// $params['postagens'] = $postagens;

			$conteudo = $template->render($params);
			echo $conteudo;
			
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}