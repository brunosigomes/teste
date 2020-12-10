<?php

class FaturaController
{
	public function index()
	{
		$parametros = array();

		try {
			$parametros['faturas'] = Model_fatura::listar();
		} catch (Exception $e) {
			$parametros['mensagem'] = $e->getMessage();
		}
		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('fatura/index.html');

		$conteudo = $template->render($parametros);
		echo $conteudo;
	}

	public function cadastrar() 
	{
		try {
			$parametros['clientes'] = Model_cliente::listar();			
		} catch (Exception $e) {
			$parametros['clientes'] = array();
		}
		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('fatura/create.html');

		if ($_POST) {
			if( strtotime($_POST['vencimento']) < strtotime('now') ) {
				echo '<p class="alert alert-danger">Selecione uma data posterior a hoje!</p>';
				return;
			}
			Model_fatura::inserir($_POST);
			header("Location: index");
		}

		$conteudo = $template->render($parametros);
		echo $conteudo;
	}

	public function editar($id = null) {
		try {
			$parametros['fatura'] = Model_fatura::listarApenasUm($id)[0];
		} catch (Exception $e) {
			$parametros['mensagem'] = $e->getMessage();
		}
		$loader = new \Twig\Loader\FilesystemLoader('app/View');
		$twig = new \Twig\Environment($loader);
		$template = $twig->load('fatura/edit.html');

		if ($_POST) {
			if( strtotime($_POST['vencimento']) < strtotime('now') ) {
				echo '<p class="alert alert-danger">Informe pelo menos um dia de diferença.</p>';
				return;
			}
			Model_fatura::alterar($_POST, $_POST['id']);
			header("Location: index");
		}

		$conteudo = $template->render($parametros);
		echo $conteudo;
	}

	public function deletar($id = null) {
		if(!is_null($id)) {
			try {
				Model_fatura::deletar($id);
				header("Location: /teste/fatura/index");
			} catch (Exception $e) {
				$parametros['mensagem'] = $e->getMessage();
			}
		}
	}
}