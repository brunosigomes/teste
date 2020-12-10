<?php

class ClienteController
{
	public function index()
	{
		$parametros = array();

		try {
			$parametros['clientes'] = Model_cliente::listar();
		} catch (Exception $e) {
			$parametros['mensagem'] = $e->getMessage();
		}

		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('cliente/index.html');

		$conteudo = $template->render($parametros);
		echo $conteudo;
	}

	public function cadastrar() {
		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('cliente/create.html');

		if ($_POST) {
			Model_cliente::inserir($_POST);
			header("Location: index");
		}

		$conteudo = $template->render();
		echo $conteudo;
	}

	public function editar($id = null) {
		try {
			$parametros['cliente'] = Model_cliente::listarApenasUm($id)[0];
		} catch (Exception $e) {
			$parametros['mensagem'] = $e->getMessage();
		}
		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('cliente/edit.html');

		if ($_POST) {
			Model_cliente::alterar($_POST, $_POST['id']);
			header("Location: index");
		}

		$conteudo = $template->render($parametros);
		echo $conteudo;
	}


	public function deletar($id = null) {
		if(!is_null($id)) {
			try {
				Model_cliente::deletar($id);
				header("Location: /teste/cliente/index");
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
	}
}