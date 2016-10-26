 <?php
	class Controller {
		private $model;
		public function __construct($model, $action = null, $parameters) {
			$this->model = $model;
			switch ($action) {
				case "insertNewUser" :
					$this->insertNewUser ( $parameters );
					break;
				case "loginUser" :
					$this->loginUser ( $parameters );
					break;
				case "logout" :
					$this->logoutUser ();
					break;
				case "insertNewMusic" :
					$this->insertNewMusic ( $parameters );
					break;
				case "deleteMusic" :
					$this->deleteMusic ( $parameters );
					break;
				case "updateMusic" :
					$this->updateMusic ( $parameters );
				default :
					break;
			}
			
			$this->model->prepareIntroMessage ();
			$this->updateHeader ();
		}
		
		/**
		 * Validate the input parameters, and if successful, and user does not exist,
		 * insert the new user in the database
		 *
		 * @param : $parameters
		 *        	- array containing the parameters to be validated
		 */
		function insertNewUser($parameters) {
			$email = $parameters ["fEmail"];
			$username = $parameters ["fUsername"];
			$password = $parameters ["fPassword"];
			
			if (! empty ( $username ) && ! empty ( $password ) && ! empty ( $email )) {
				if ($this->model->validationFactory->isLengthStringValid ( $username, NEW_USER_FORM_MAX_USERNAME_LENGTH ) && $this->model->validationFactory->isLengthStringValid ( $password, NEW_USER_FORM_MAX_PASSWORD_LENGTH ) && $this->model->validationFactory->isEmailValid ( $email )) {
					
					if (! $this->model->authenticationFactory->isUserExisting ( $username )) {
						$hashedPassword = $this->model->authenticationFactory->getHashValue ( $password );
						if ($this->model->insertNewUser ( $username, $hashedPassword )) {
							$this->model->hasRegistrationFailed = false;
							$this->model->setConfirmationMessage(NEW_USER_FORM_REGISTRATION_CONFIRMATION_STR);
							return (true);
						}
					} else
						$this->model->setUpNewUserError ( NEW_USER_FORM_EXISTING_ERROR_STR );
				} else
					$this->model->setUpNewUserError ( NEW_USER_FORM_ERRORS_STR );
			} else
				$this->model->setUpNewUserError ( NEW_USER_FORM_ERRORS_COMPULSORY_STR );
			
			$this->model->hasRegistrationFailed = true;
			$this->model->updateLoginErrorMessage ();
			return (false);
		}
		
		function insertNewMusic($parameters){
			$artist = $parameters ["fArtist"];
			$song = $parameters ["fSong"];
			$comment = $parameters ["fComment"];
			$genre = $parameters ["fGenre"];
			
			if(! empty ($artist) && ! empty ($song) && ! empty ($genre)){
				if($this->model->validationFactory->isLengthStringValid($comment, NEW_SONG_FORM_MAX_COMMENT_LENGHT)){
					if(! $this->model->authenticationFactory->isSongExisting($artist, $song)){
						if($this->model->insertNewMusic($artist, $song, $comment, $genre)){
							$this->model->hasRegistrationFailed = false;
							$this->model->setConfirmationMessage( NEW_SONG_FORM_INSERT_CONFIRMATION_STR );
							return(true);
						}
					}else if($this->model->authenticationFactory->isSongExisting($artist, $song)){
						$this->model->setUpNewSongError( NEW_SONG_FORM_EXISTING_ERROR_STR);}
				}else
					$this->model->setUpNewSongError( NEW_SONG_FORM_ERRORS_STR );
			}else
				$this->model->setUpNewSongError( NEW_SONG_FORM_ERRORS_COMPULSORY_STR );
			
			$this->model->hasRegistrationFailed = true;
			return (false);
		}
		
		function deleteMusic($parameters){
			$artist = $parameters ["fArtist"];
			$song = $parameters ["fSong"];
			
			if(! empty ($artist) && ! empty ($song)){
				if($this->model->authenticationFactory->isSongExisting($artist, $song)){
					if($this->model->deleteMusic($artist, $song)){
						$this->model->hasRegistrationFailed = false;
						$this->model->setConfirmationMessage( DELETE_SONG_FORM_DELETE_CONFIRM_STR );
						return(true);	
					}
				}else
					$this->model->setUpDeleteMusicError( DELETE_SONG_FORM_NO_SONG_ERROR_STR );
			}else
				$this->model->setUpDeleteMusicError( DELETE_SONG_FORM_ERRORS_COMPULSORY_STR );
			
			$this->model->hasRegistrationFailed = true;
			return (false);
		}
		
		function updateMusic($parameters){
			$artist = $parameters ["fArtist"];
			$song = $parameters ["fSong"];
			$comment = $parameters ["fComment"];
			$genre = $parameters ["fGenre"];
			
			if(! empty ($artist) && ! empty ($song) && ! empty ($genre)){
				if($this->model->authenticationFactory->isSongExisting($artist, $song)){
					if($this->model->updateMusic($artist, $song, $comment, $genre)){
						$this->model->hasRegistrationFailed = false;
						$this->model->setConfirmationMessage( UPDATE_SONG_FORM_CONFIRM_STR );
						return(true);
					}
				}else
					$this->model->setUpdateMusicError( UPDATE_SONG_FORM_NO_SONG_ERROR_STR );
			}else
				$this->model->setUpdateMusicError( UPDATE_SONG_FORM_ERRORS_COMPULSORY_STR );
		}
		/**
		 * Validate the input parameters, and if successful, authenticate the user.
		 * If authentication process is ok, login the user.
		 *
		 * @param : $parameters
		 *        	- array containing the parameters to be validated. 
		 *        This is the $_REQUEST super global array.
		 */
		function loginUser($parameters) {
			$username = $parameters ["fUser"];
			$password = $parameters ["fPassword"];
			
			if (! (empty ( $username ) && empty ( $password ))) {
				if ($this->model->validationFactory->isLengthStringValid ( $username, NEW_USER_FORM_MAX_USERNAME_LENGTH ) && $this->model->validationFactory->isLengthStringValid ( $password, NEW_USER_FORM_MAX_PASSWORD_LENGTH )) {
					
					$databaseHashedPassword = $this->model->getUserPasswordDigest ( $username );
					$userHashedPassword = $this->model->authenticationFactory->getHashValue ( $password );
					if ($databaseHashedPassword == $userHashedPassword) {
						$userId = $this->model->getUserId ( $username );
						$this->model->loginUser ( $userId, $username );
						$this->model->updateLoginStatus ();
						$this->model->hasAuthenticationFailed = false;
						return;
					}
				}
			}
			$this->model->updateLoginErrorMessage ();
			$this->model->hasAuthenticationFailed = true;
			return;
		}
		function logoutUser() {
			$this->model->logoutUser ();
		}
		function updateHeader() {
			if ($this->model->isUserLoggedIn ())
				$this->model->updateLoginStatus ();
		}	
	}
	?>