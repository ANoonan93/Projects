<?php
include_once './conf/config.inc.php';
include_once './db/DAO_factory.php';
include_once 'validation_factory.php';
include_once 'authentication_factory.php';
class Model {
	public $DAO_Factory, $validationFactory, $authenticationFactory; // factories
	private $usersDAO, $songDAO; // DAOs
	public $appName = "", $introMessage = "", $loginStatusString = "", $rightBox = "", $signUpConfirmation="", $MusicConfirm="", $deleteConfirm=""; // strings
	public $newUserErrorMessage = "", $authenticationErrorMessage = "", $newSongErrorMessage="", $deleteSongErrorMessage="", $updateSongErrorMessage="";	//error messages
	public $hasAuthenticationFailed = false, $hasInsertMusicFailed = null, $hasDeleteMusicFailed = null, $hasRegistrationFailed=null;	//control variables
	
	
	public function __construct() {
		$this->DAO_Factory = new DAO_Factory ();
		$this->DAO_Factory->initDBResources ();
		$this->usersDAO = $this->DAO_Factory->getUsersDAO ();
		$this->songDAO = $this->DAO_Factory->getSongDAO();
		$this->authenticationFactory = new authentication_factory ( $this->usersDAO, $this->songDAO );
		$this->validationFactory = new validation_factory ();
		$this->appName = APP_NAME;
	}
	public function loginUser($userID, $username) {
		$this->authenticationFactory->loginUser ( $userID, $username );
	}
	public function getUserPasswordDigest($username) {
		return ($this->usersDAO->getUserPasswordDigest ( $username ));
	}
	public function getUserID($username) {
		return ($this->usersDAO->getUserId ( $username ));
	}
	public function prepareIntroMessage() {
		$this->introMessage = INDEX_INTRO_MESSAGE_STR;
	}
	
	public function getTableList() {
		return ($this->songDAO->getTableList());
	}
	public function hasInsertMusicFailed( $parameters ){
		$this->hasInsertMusicFailed = $parameters;
	}
	public function setUpNewUserError($errorString) {
		$this->newUserErrorMessage = "<div class='alert alert-error'>" . $errorString . "</div>";
	}
	public function setUpNewSongError($errorString){
		$this->newSongErrorMessage = "<div class='alert alert-error'>" . $errorString . "</div>";
	}
	public function setUpDeleteMusicError($errorString){
		$this->deleteSongErrorMessage = "<div class='alert alert-error'>" . $errorString . "</div>";
	}
	public function setUpdateMusicError($errorString){
		$this->updateSongErrorMessage = "<div class='alert alert-error'>" . $errorString . "</div>";
	}
	public function updateLoginStatus() {
		$this->loginStatusString = LOGIN_USER_FORM_WELCOME_STR . " " . $this->authenticationFactory->getUsernameLoggedIn () . " | " . LOGIN_USER_FORM_LOGOUT_STR;
		$this->authenticationErrorMessage = "";
	}
	public function updateLoginErrorMessage() {
		$this->authenticationErrorMessage = LOGIN_USER_FORM_AUTHENTICATION_ERROR;
		$this->loginStatusString = "";
	}
	public function setConfirmationMessage( $parameter ){
		$this->MusicConfirm = $parameter;
	}
	public function setInsertMusicMessage( $insertMusicConfirm ){
		$this->insertMusicConfirm = $insertMusicConfirm;
	}
	public function setDeleteMusicMessage( $deleteConfirm ){
		$this->deleteConfirm = $deleteConfirm;
	}
	public function insertNewUser($username, $hashedPassword) {
		return ($this->songDAO->insertNewUser ( $username, $hashedPassword ));
	}
	public function insertNewMusic($artist, $song, $comment, $genre){
		return ($this->songDAO->insertNewMusic($artist, $song, $comment, $genre));
	}
	public function deleteMusic($artist, $song){
		return ($this->songDAO->deleteMusic($artist, $song));
	}
	
	public function updateMusic($artist, $song, $comment, $genre){
		return ($this->songDAO->updateMusic($artist, $song, $comment, $genre));
	}
	public function logoutUser() {
		$this->authenticationFactory->logoutUser ();
		$this->loginStatusString = null;
		$this->authenticationErrorMessage = "";
	}
	public function isUserLoggedIn() {
		return ($this->authenticationFactory->isUserLoggedIn ());
	}
	public function __destruct() {
		$this->DAO_Factory->clearDBResources ();
	}
}
?>