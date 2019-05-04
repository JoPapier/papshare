<?php

class Album implements Databasable {

	public $id_album;
	public $id_abonne;

	public function __construct($id_album = null, $id_abonne = null) {
		$this->id_album = $id_album;
		$this->id_abonne = $id_abonne;
	}

	public function getTabPhoto() {
		return Photo::tab("id_photo={$this->id_album}", 'date_time');
	}

	public static function tous() {
		return Album::tab(1, 'id_abonne');
	}

	public function charger() {
		if (!$this->id_album)
			return false;
		$req = "SELECT * FROM album WHERE id_album = {$this->id_album}";
		return Connexion::getInstance()->xeq($req)->ins($this);
	}

	public function sauver() {
		$cnx = Connexion::getInstance();
		if ($this->id_album) {
			$req = "UPDATE album SET id_abonne={$this->id_abonne} "
							. "WHERE id_album={$this->id_album}";
			$cnx->xeq($req);
		} else {
			$req = "INSERT INTO album (id_album,id_abonne) "
							. "VALUES ({$this->id_abonne}, {$this->id_abonne})";
		 $cnx->xeq($req)->pk();
		}
		return $this;
	}

	public function supprimer() {
		if (!$this->id_album)
			return false;
		$req = "DELETE FROM album WHERE id_album = {$this->id_album}";
		return (bool) Connexion::getInstance()->xeq($req)->nb();
	}

	public static function tab($where = 1, $orderBy = 1, $limit = null) {

		$req = "SELECT * FROM album WHERE {$where} ORDER BY {$orderBy}" . ($limit ? " LIMIT {$limit}" : '');
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function lastAbonne() {
		if (!$this->id_abonne)
			return false;
		$req = "SELECT COUNT(id_album) as nb FROM abonne_album WHERE id_album={$this->id_album} AND ok = 0 ";
		return Connexion::getInstance()->xeq($req)->prem()->nb;
	}

}
