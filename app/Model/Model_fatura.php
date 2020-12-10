<?php

class Model_fatura
{
	public static function listar()
	{
		$con = Connection::getConn();

		$sql = "SELECT fatura.id, fatura.valor, fatura.vencimento, fatura.cliente_id, cliente.nome AS cliente_nome FROM fatura INNER JOIN cliente ON (fatura.cliente_id = cliente.id) ORDER BY fatura.id DESC";
		$sql = $con->prepare($sql);
		$sql->execute();

		$resultado = array();

		while ($row = $sql->fetchObject('Model_fatura')) {
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

		$sql = "SELECT fatura.id, fatura.valor, fatura.vencimento, fatura.cliente_id, cliente.nome as cliente_nome FROM fatura INNER JOIN cliente ON (fatura.cliente_id = cliente.id) WHERE fatura.id = :id";
		$sql = $con->prepare($sql);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->execute();

		$resultado = array();

		while ($row = $sql->fetchObject('Model_fatura')) {
			$resultado[] = $row;
		}

		if (!$resultado) {
			throw new Exception("Nenhum registro encontrado!");
		}

		return $resultado;
	}

	public static function inserir($data)
	{
		if(empty($data['valor']) || empty($data['vencimento']) || empty($data['cliente_id'])) {
			throw new Exception("Preencha todos os campos!");
			return false;
		}

		$con = Connection::getConn();

		$sql = "INSERT INTO fatura (valor, vencimento, cliente_id) VALUES (:valor, :vencimento, :cliente_id)";
		$sql = $con->prepare($sql);
		$sql->bindValue(':valor', $data['valor'], PDO::PARAM_INT);
		$sql->bindValue(':vencimento', $data['vencimento']);
		$sql->bindValue(':cliente_id', $data['cliente_id'], PDO::PARAM_INT);
		$resultado = $sql->execute();

		if ($resultado == 0) {
			throw new Exception("Falha ao inserir dados!");

			return false;			
		}
		return true;
	}

	public static function alterar($data, $id)
	{
		if(empty($data['valor']) || empty($data['vencimento'])) {
			throw new Exception("Preencha todos os campos!");

			return false;
		}

		$con = Connection::getConn();

		$sql = "UPDATE fatura SET valor = :valor, vencimento = :vencimento WHERE id=:id";
		$sql = $con->prepare($sql);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);
		$sql->bindValue(':valor', $data['valor'], PDO::PARAM_INT);
		$sql->bindValue(':vencimento', $data['vencimento']);

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

		$sql = "DELETE FROM fatura WHERE id = :id";
		$sql = $con->prepare($sql);
		$sql->bindValue(':id', $id, PDO::PARAM_INT);

		$resultado = $sql->execute();

		if ($resultado == 0) {
			throw new Exception("Falha ao deletar fatura!");
			return false;			
		}	

		return true;
	}
}