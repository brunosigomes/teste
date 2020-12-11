<?php

class HomeController
{
	public function index()
	{
		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('home/index.html');

		$params = array();

		$conteudo = $template->render($params);
		echo $conteudo;
	}
}