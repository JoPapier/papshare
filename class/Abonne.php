<?php

class Abonne implements Databasable {

	public $id_abonne;
	public $email;
	public $pseudo;
	public $mdp;
	public $nom;
	public $prenom;
	public $date_creation;

	public function __construct($id_abonne = null, $email = null, $pseudo = null, $mdp = null, $nom = null, $prenom = null, $date_creation = null) {

		$this->id_abonne = $id_abonne;
		$this->email = $email;
		$this->pseudo = $pseudo;
		$this->mdp = $mdp;
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->date_creation = $date_creation;
	}

	public function charger() {
		if (!$this->id_abonne)
			return false;
		$req = "SELECT * FROM abonne WHERE id_abonne={$this->id_abonne}";
		return Connexion::getInstance()->xeq($req)->ins($this);
	}

	public function sauver() {
		$cnx = Connexion::getInstance();
		if ($this->id_abonne) {
			$req = "UPDATE abonne SET email = {$cnx->esc($this->email)}, pseudo = {$cnx->esc($this->pseudo)}, mdp = {$cnx->esc($this->mdp)},nom = {$cnx->esc($this->nom)},prenom = {$cnx->esc($this->prenom)},date_creation= {$cnx->esc($this->date_creation)} WHERE id_abonne = {$this->id_abonne}";
			$cnx->xeq($req);
		} else {
			$req = "INSERT INTO abonne VALUES(DEFAULT,{$cnx->esc($this->email)},{$cnx->esc($this->pseudo)},{$cnx->esc($this->mdp)},{$cnx->esc($this->nom)},{$cnx->esc($this->prenom)},{$cnx->esc($this->date_creation)})";
			$this->id_abonne = $cnx->xeq($req)->pk();
		}
		return $this;
	}

	public function supprimer() {
		if (!$this->id_abonne)
			return false;
		$req = "DELETE FROM abonne WHERE id_abonne = {$this->id_abonne}";
		return (bool) Connexion::getInstance()->xeq($req)->nb();
	}

	public static function tab($where = 1, $orderBy = 1, $limit = null) {
		$req = "SELECT * FROM abonne WHERE {$where} ORDER BY {$orderBy}" . ($limit ? " LIMIT {$limit}" : '');
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function login() {
		$_SESSION['id_abonne'] = null;
		if (!($this->pseudo || $this->mdp))
			return false;
		$mdp = $this->mdp;
		$cnx = Connexion::getInstance();
		$req = "SELECT * FROM abonne WHERE pseudo={$cnx->esc($this->pseudo)}";
		if (!$cnx->xeq($req)->ins($this))
			return false;
		if (!password_verify($mdp, $this->mdp))
			return false;
		$_SESSION['id_abonne'] = $this->id_abonne;

		return true;
	}

	public static function getUserSession() {
		if (empty($_SESSION['id_abonne']))
			return null;
		$abonne = new Abonne($_SESSION['id_abonne']);
		return $abonne->charger() ? $abonne : null;
	}

	public function getAbonne() {
		return (new Abonne($this->id_abonne))->charger();
	}

	public function getAlbum() {
		if (!$this->id_abonne)
			return null;
		$req = "SELECT id_album AS album FROM album WHERE id_abonne={$this->id_abonne}";
		return Connexion::getInstance()->xeq($req)->prem()->album; // on met pas __CLASS__ car on veut pas les infos de la class en cours mais celle de rencontre
	}

	public function toutePhoto() {
		return Photo::tab("id_abonne={$this->id_abonne}", "id_photo");
	}

	public static function tous() {
		return Abonne::tab(1, 'pseudo');
	}

	public function afficherProfil() {
		if (!$this->id_abonne)
			return null;
		$req = " SELECT * FROM abonne WHERE NOT id_abonne = {$this->id_abonne}";
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function dashboard() {
		if (!$this->id_abonne)
			return null;
		$req = "SELECT * FROM abonne WHERE id_abonne={$this->id_abonne} ORDER BY id_abonne DESC LIMIT 1";
		return Connexion::getInstance()->xeq($req)->prem('id_abonne');
	}

	public function nouveauAbonne() {
		if (!$this->id_abonne)
			return false;
		$req = "SELECT * FROM Abonne JOIN abonne_album USING (id_abonne) WHERE id_album = {$this->id_abonne} AND NOT id_abonne = {$this->id_abonne}  AND ok= 0";
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function verifierAlbum() {
		if (!$this->id_abonne)
			return null;
		$req = "SELECT * FROM abonne INNER JOIN photo ON photo.id_album=abonne.id_abonne INNER JOIN abonne_album on abonne_album.id_album = photo.id_abonne "
				. "WHERE abonne_album.id_abonne = {$this->id_abonne} AND ok=1 ";
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function afficherAbonnement() {
		if (!$this->id_abonne)
			return null;
		$req = "SELECT DISTINCT * FROM abonne INNER JOIN album ON album.id_abonne = abonne.id_abonne INNER JOIN abonne_album ON abonne_album.id_album = abonne.id_abonne "
				. "WHERE abonne_album.id_album AND abonne_album.id_abonne = {$this->id_abonne}  AND ok = 1";
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

	public function compterAbonnement() {
		if (!$this->id_abonne)
			return false;
		$req = "SELECT COUNT(id_album) as nb FROM abonne_album WHERE id_abonne ={$this->id_abonne} AND ok = 1";
		return Connexion::getInstance()->xeq($req)->prem()->nb;
	}

	public function afficherAbonne() {
		if (!$this->id_abonne)
			return false;
		$req = "SELECT * FROM abonne INNER JOIN abonne_album ON abonne_album.id_abonne = abonne.id_abonne WHERE abonne_album.id_album = {$this->id_abonne} AND ok=1";
		return Connexion::getInstance()->xeq($req)->tab(__CLASS__);
	}

}
