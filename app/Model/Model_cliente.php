<?php

class Model_cliente
{
	public static function listar()
	{
		$con = Connection::getConn();

		$sql = "SELECT * FROM cliente ORDER BY id DESC";
		$sql = $con->prepare($sql);
		$sql->execute();

		$resultado = array();

		while ($row = $sql->fetchObject('Model_cliente')) {
			$resultado[] = $row;
		}

		if (!$resultado) {
			throw new Exception("Nenhum registro encontrado!");
		}

		return $resultado;
	}

	public static function listarApenasUm($id = null)
	{
		$con = Connection::getConn();

		$sql = "SELECT * FROM cliente WHERE id = :id";
		$sql = $con->prepare($sql);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->execute();

		$resultado = array();

		while ($row = $sql->fetchObject('Model_cliente')) {
			$resultado[] = $row;
		}

		if (!$resultado) {
			throw new Exception("Nenhum registro encontrado!");
		}

		return $resultado;
	}

	public static function inserir($data)
	{
		if(empty($data['nome']) || empty($data['cpf']) || empty($data['idade'])) {
			throw new Exception("Preencha todos os campos!");
			return false;
		}

		$con = Connection::getConn();

		$sql = "INSERT INTO cliente (nome, cpf, idade) VALUES (:nome, :cpf, :idade)";
		$sql = $con->prepare($sql);
		$sql->bindValue(':nome', $data['nome']);
		$sql->bindValue(':cpf', $data['cpf']);
		$sql->bindValue(':idade', $data['idade'], PDO::PARAM_INT);
		$resultado = $sql->execute();

		if ($resultado == 0) {
			throw new Exception("Falha ao inserir dados!");

			return false;			
		}
		return true;
	}

	public static function alterar($data, $id)
	{
		if(empty($data['nome']) || empty($data['cpf']) || empty($data['idade'])) {
			throw new Exception("Preencha todos os campos!");

			return false;
		}

		$con = Connection::getConn();

		$sql = "UPDATE cliente SET nome = :nome, cpf = :cpf, idade = :idade WHERE id=:id";
		$sql = $con->prepare($sql);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->bindValue(':nome', $data['nome']);
		$sql->bindValue(':cpf', $data['cpf']);
		$sql->bindValue(':idade', $data['idade'], PDO::PARAM_INT);

		$resultado = $sql->execute();

		if ($resultado == 0) {
			throw new Exception("Falha ao alterar dados!");

			return false;			
		}
		return true;
	}

	public static function deletar($id)
	{
		if(empty($id)) {
			throw new Exception("id inválido!");
			return false;
		}

		$con = Connection::getConn();

		$sql = "DELETE FROM cliente WHERE id = :id";
		$sql = $con->prepare($sql);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);

		$resultado = $sql->execute();

		if ($resultado == 0) {
			throw new Exception("<p class='alert alert-danger'>Falha ao deletar. Cliente possui fatura!</p>");
			return false;			
		}	

		return true;
	}
}