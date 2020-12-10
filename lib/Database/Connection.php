<?php

abstract class Connection
{
	private static $conn;

	public static function getConn()
	{
		if(self::$conn == null) {
			try {
				self::$conn = new PDO('mysql: host=localhost; dbname=teste', 'root', '');
			} catch(PDOException $e) {
				echo 'ERROR: ' . $e->getMessage();
			}
		}

		return self::$conn;
	}
}