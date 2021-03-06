<?php

class Connexion {

	private static $instance; // Instance unique de Connexion.
	private static $DSN; // DSN.
	private static $log; // Identifiant utilisateur.
	private static $mdp; // Mot de passe utilisateur.
	private static $opt = [
			PDO::MYSQL_ATTR_INIT_COMMAND =>
			"SET NAMES 'utf8mb4'",
			PDO::ATTR_ERRMODE =>
			PDO::ERRMODE_EXCEPTION];
	private $db; // Instance de PDO.
	private $jeu; // Recordset après une requête SELECT.
	private $nb; // Nombre de lignes affectées par la dernière requête.

	private function __construct() {
		if (!self::$DSN)
			exit(I18n::get('DB_ERR_DSN_UNDEFINED'));
		try {
			$this->db = new PDO(self::$DSN, self::$log, self::$mdp, self::$opt);
		} catch (PDOException $e) {
			echo I18n::get('DB_ERR_CONNECTION_FAILED');
			exit(" : {$e->getMessage()}");
		}
	}

	public static function getInstance() {
		if (!self::$instance)
			self::$instance = new Connexion();
		return self::$instance;
	}

	public static function setDSN($dbName, $log, $mdp, $host = 'localhost') {
		if (self::$DSN)
			exit(I18n::get('DB_ERR_DSN_ALREADY_SET'));
		self::$DSN = "mysql:dbname={$dbName};host={$host};charset=utf8mb4";
		self::$log = $log;
		self::$mdp = $mdp;
	}

	public function esc($val) {
		return $val === null ? 'NULL' : $this->db->quote($val);
	}

	public function xeq($req) {
		try {
			if (mb_stripos(trim($req), 'SELECT') === 0) {
				$this->jeu = $this->db->query($req);
				$this->nb = $this->jeu->rowCount();
			} else {
				$this->jeu = null;
				$this->nb = $this->db->exec($req);
			}
		} catch (PDOException $e) {
			echo I18n::get('DB_ERR_BAD_REQUEST');
			exit(" : {$req} ({$e->getMessage()})");
		}
		return $this;
	}

	public function nb() {
		return $this->nb;
	}

	public function tab($classe = 'stdClass') {
		if (!$this->jeu)
			return [];
		$this->jeu->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $classe);
		return $this->jeu->fetchAll();
	}

	public function prem($classe = 'stdClass') {
		if (!$this->jeu)
			return null;
		$this->jeu->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, $classe);
		return $this->jeu->fetch();
	}

	public function ins($obj) {
		if (!$this->jeu)
			return false;
		$this->jeu->setFetchMode(PDO::FETCH_INTO, $obj);
		return $this->jeu->fetch();
	}

	public function pk() {
		return $this->db->lastInsertId();
	}

	public function start() {
		return $this->db->beginTransaction();
	}

	public function savepoint($label) {
		$req = "SAVEPOINT {$label}";
		return $this->xeq($req);
	}

	public function rollback($label = null) {
		return $label ? $this->db->rollBackTo($label) : $this->db->rollBack();
	}

	public function commit() {
		return $this->db->commit();
	}

}
