<?php

class Photo implements Databasable {

	public $id_photo;
	public $id_album;
	public $id_abonne;
	public $date_time;
	public $legende;
	public $latitude;
	public $longitude;

	public function __construct($id_photo = null, $id_album = null, $id_abonne = null, $date_time = null, $legende = null, $latitude = null, $longitude = null) {

		$this->id_photo = $id_photo;
		$this->id_album = $id_album;
		$this->id_abonne = $id_abonne;
		$this->date_time = $date_time;
		$this->legende = $legende;
		$this->latitude = $latitude;
		$this->longitude = $longitude;
	}

	public static function tous() {
		return Photo::tab(1, 'date_time');
	}

	public function charger() {
		if (!$this->id_photo)
			return false;
		$req = "SELECT * FROM photo WHERE id_photo={$this->id_photo}";
		return Connexion::getInstance()->xeq($req)->ins($this);
	}

	public function sauver() {
		$cnx = Connexion::getInstance();
		if ($this->id_photo) {
			$req = "UPDATE photo SET date_time= {$cnx->esc($this->date_time)}, legende ={$cnx->esc($this->legende)},longitude={$cnx->esc($this->longitude)},latitude={$cnx->esc($this->latitude)} WHERE id_photo= {$this->id_photo}";
			$cnx->xeq($req);
		} else {
			$req = "INSERT INTO photo VALUES(DEFAULT, {$this->id_album}, {$this->id_abonne},{$cnx->esc($this->date_time)},{$cnx->esc($this->legende)},{$cnx->esc($this->latitude)},{$cnx->esc($this->longitude)})";
			$this->id_photo = $cnx->xeq($req)->pk();
		}
		return $this;
	}

	public function supprimer() {
		if (!$this->id_photo)
			return false;
		$req = "DELETE FROM photo WHERE id_photo = {$this->id_photo}";
		return (bool) Connexion::getInstance()->xeq($req)->nb();
	}

	public static function tab($where = 1, $orderBy = 1, $limit = null) {
		$req = "SELECT * FROM photo WHERE {$where} ORDER BY {$orderBy}" . ($limit ? " LIMIT {$limit}" : '');
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function getTabPhoto() {
		return Photo::tab("id_abonne={$this->id_abonne}", 'date_time');
	}

	public function compterAime() {
		if (!$this->id_abonne)
			return false;
		$req = "SELECT COUNT(DISTINCT id_photo)as nb FROM aime WHERE id_photo = {$this->id_photo}";
		return Connexion::getInstance()->xeq($req)->prem()->nb;
	}

	public function detailPhoto() {
		if (!$this->id_photo)
			return false;
		$req = "SELECT * FROM photo INNER JOIN abonne ON abonne.id_abonne = photo.id_abonne WHERE id_photo ={$this->id_photo}";
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

}
