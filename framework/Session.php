<?php

class Session implements databasable, SessionHandlerInterface {

	public $sid; // PHPSESSID.
	public $data; // Données ( sérialisé automatiquement par PHP ).
	public $date_maj; // Date de mise à jour ( auto ).
	private $timeout; // Timeout ( s ), aucun si null.

	public function __construct($timeout = null) {
		$this->timeout = $timeout;
	}

	public function charger() {
		$cnx = Connexion::getInstance();
		$req = "SELECT * FROM session WHERE sid = {$cnx->esc($this->sid)}" . ($this->timeout ? " AND TIMESTAMPDIFF(SECOND, date_maj, NOW()) < {$this->timeout}" : '');
		return $cnx->xeq($req)->ins($this);
	}

	public function sauver() {
		$cnx = Connexion::getInstance();
		$req = "INSERT INTO session VALUES({$cnx->esc($this->sid)}, {$cnx->esc($this->data)},DEFAULT) ON DUPLICATE KEY UPDATE data ={$cnx->esc($this->data)}, date_maj=DEFAULT";
		$cnx->xeq($req);
		return $this;
	}

	public function supprimer() {
		$cnx = Connexion::getInstance();
		$req = "DELETE FROM session WHERE sid = {$cnx->esc($this->sid)}";
		return (bool) $cnx->xeq($req)->nb();
	}

	public static function tab($where = 1, $orderBy = 1, $limit = null) {
		// inutile ici
		return[];
	}

	public function close() {
		return true;
	}

	public function destroy($session_id) {
		$this->sid = $session_id;
		return $this->supprimer();
	}

	public function gc($maxlifetime) {
		if (!$this->timeout)
			return true;
		$req = "DELETE FROM session WHERE TIMESTAMPDIFF(SECOND, date_maj, NOW()) > {$this->timeout}";
		return (bool) Connexion::getInstance()->xeq($req)->nb();
	}

	public function open($save_path, $name) {
		return true;
	}

	public function read($session_id) {
		$this->sid = $session_id;
		return $this->charger() ? $this->data : '';
	}

	public function write($session_id, $session_data) {
		$this->sid = $session_id;
		$this->data = $session_data;
		$this->sauver();
		return true;
	}

}
