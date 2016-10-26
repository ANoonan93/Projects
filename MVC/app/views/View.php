<?php
class View {
	private $model;
	private $controller;
	public function __construct($controller, $model) {
		$this->controller = $controller;
		$this->model = $model;
	}
	public function output() {
		// set variables up from the model (for the template)
		$appName = $this->model->appName;
		$introMessage = $this->model->introMessage;
		$newUserErrorMessage = $this->model->newUserErrorMessage;
		$deleteSongErrorMessage= $this->model->deleteSongErrorMessage;
		
		$loginBox = "";
		$authenticationErrorMessage = "";
		$leftBox = "";
		$rightBox = "";
		
		if ($this->model->loginStatusString != null) {
			$loginBox = "<a href='index.php?action=logout'>" . $this->model->loginStatusString . "</a>";
			// list of options available to logged in user
			
			$insertMusicForm = file_get_contents("./templates/insert_new_music_form.php");
			$rightBox = $insertMusicForm;
			
			$leftBox = $this->model->getTableList();
			
			if (! isset ( $this->model->hasRegistrationFailed )) {
				$rightBox = $insertMusicForm;
			}else if ( $this->model->hasRegistrationFailed) {
				$rightBox = $deleteSongErrorMessage . $insertMusicForm;
			}else if ($this->model->hasRegistrationFailed == false) {
				$insertMusicConfirm = "<div class='alert alert-success'>" . $this->model->MusicConfirm . "</div>";
				$rightBox = $insertMusicConfirm . $insertMusicForm;
			} 
			
		} else {
			$authenticationErrorMessage = "";
			if ($this->model->hasAuthenticationFailed)
				$authenticationErrorMessage = $this->model->authenticationErrorMessage;
			
			$loginBox = file_get_contents ( "templates/login_form.php", FILE_USE_INCLUDE_PATH );
			$rightBox = $this->model->rightBox;
			
			$registrationForm = file_get_contents ( './templates/insert_new_user_form.php' );
			
			$confirmationMessage = "";
			if (! isset ( $this->model->hasRegistrationFailed )) {
				$rightBox = $registrationForm;
			} else if ($this->model->hasRegistrationFailed) {
				$rightBox = $newUserErrorMessage . $registrationForm;
			} else if ($this->model->hasRegistrationFailed == false) {
				$confirmationMessage = "<div class='alert alert-success'>" . $this->model->signUpConfirmation . "</div>";
				$rightBox = $confirmationMessage;
			}
		}
		
		include_once ("templates/template_index.php");
	}
}
?>