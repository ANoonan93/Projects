<?php
class authentication_factory {
	private $usersDAO, $songDAO;
	public function __construct($usersDAO, $songDAO) {
		$this->usersDAO = $usersDAO;
		$this->songDAO = $songDAO;
	}
	public function isUserExisting($username) {
		return ($this->usersDAO->isUserExisting ( $username ));
	}
	public function isSongExisting($artist, $song){
		return ($this->songDAO->isSongExisting ($artist, $song));
	}
	public function insertNewUser($username, $password) {
		$hashedPassword = hash ( "sha1", $password );
		return ($this->usersDAO->insertNewUser ( $username, $hashedPassword ));
	}
	public function insertNewMusic($artist, $song, $comment, $genre){
		return ($this->songDAO->insertNewMusic ($artist, $song, $comment, $genre));
	}
	public function getHashValue($string) {
		return (hash ( "sha1", $string ));
	}
	public function loginUser($userId, $username) {
		$_SESSION ['user_id'] = $userId;
		$_SESSION ['username'] = $username;
	}
	public function isUserLoggedIn() {
		return (! empty ( $_SESSION ['user_id'] ));
	}
	public function getUsernameLoggedIn() {
		if ($this->isUserLoggedIn ())
			return $_SESSION ['username'];
		
		return (null);
	}
	public function logoutUser() {
		unset ( $_SESSION ['user_id'] );
		unset ( $_SESSION ['username'] );
		session_destroy ();
	}
}
?>