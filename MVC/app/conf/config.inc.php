<?php
/* database constants */
define("DB_HOST", "localhost" ); 		
define("DB_USER", "root" ); 			
define("DB_PASS", "" ); 		
define("DB_PORT", 3306);				
define("DB_NAME", "dit" ); 		

/* application constants */
define("APP_NAME", "Personal Music Library" ); 		

/* new user form constants */
define("NEW_USER_FORM_ERRORS_STR", "Errors exist in the form");
define("NEW_USER_FORM_ERRORS_COMPULSORY_STR", "All the fields are compulsory");
define("NEW_USER_FORM_EXISTING_ERROR_STR", "Another user already exists in the system with the same username");
define("NEW_USER_FORM_MAX_USERNAME_LENGTH", 30);	
define("NEW_USER_FORM_MAX_PASSWORD_LENGTH", 20); 
define("NEW_USER_FORM_REGISTRATION_CONFIRMATION_STR", "You have registered successfully");
define("NEW_USER_FORM_SYSTEM_ERROR_STR", "Something went wrong during registration");

/* login user form constants */
define("LOGIN_USER_FORM_MAX_USERNAME_LENGTH", 30);	
define("LOGIN_USER_FORM_MAX_PASSWORD_LENGTH", 20); 	
define("LOGIN_USER_FORM_WELCOME_STR", "Welcome");
define("LOGIN_USER_FORM_AUTHENTICATION_ERROR", "Error");
define("LOGIN_USER_FORM_LOGOUT_STR", "Logout");

/* new song form constants */
define("NEW_SONG_FORM_ERRORS_STR", "Errors exist in the form");
define("NEW_SONG_FORM_ERRORS_COMPULSORY_STR", "These fields are compulsory");
define("NEW_SONG_FORM_EXISTING_ERROR_STR", "Another song already exists in the system with the same name");
define("NEW_SONG_FORM_MAX_ARTIST_LENGTH", 30);	
define("NEW_SONG_FORM_MAX_SONG_LENGTH", 35);
define("NEW_SONG_FORM_MAX_COMMENT_LENGHT", 100);
define("NEW_SONG_FORM_INSERT_CONFIRMATION_STR", "You have entered the song successfully");
define("NEW_SONG_FORM_SYSTEM_ERROR_STR", "Something went wrong while entering music");

/* delete song form constants */
define("DELETE_SONG_FORM_DELETE_CONFIRM_STR", "Song was deleted successfully");
define("DELETE_SONG_FORM_NO_SONG_ERROR_STR", "This song does not exist in your library and cannot be deleted");
define("DELETE_SONG_FORM_SYSTEM_ERROR_STR", "Something went wrong while attempting to delete music");
define("DELETE_SONG_FORM_ERRORS_COMPULSORY_STR", "These fields are compulsory");

define("UPDATE_SONG_FORM_CONFIRM_STR", "Song was updated successfully");
define("UPDATE_SONG_FORM_NO_SONG_ERROR_STR", "This song does not exist in your library and cannot be update");
define("UPDATE_SONG_FORM_SYSTEM_ERROR_STR", "Something went wrong while attempting to update music");
define("UPDATE_SONG_FORM_ERRORS_COMPULSORY_STR", "These fields are compulsory");

/* misc */
define("INDEX_INTRO_MESSAGE_STR", "Add your favorite music to your personal library with " . APP_NAME);
define("LOGGED_IN_USER_MENU", "<ul><li>option 1</li><li>option 2 </li></li>");
?>