<?php

class Connection {

	private $servername = "localhost";
	private $username = "root";
	private $password = "";
	private $dbname = "login";

	//prisijungiame prie DB
	protected function connect(){

		$dsn = 'mysql:host=' . $this->servername . ';dbname=' . $this->dbname;
		$pdo = new PDO($dsn, $this->username, $this->password);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		return $pdo;

	}
}
