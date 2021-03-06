<?php
/**
 * @author Luca
 * definition of the DAO factory
 */
include_once 'simple_db_manager.php';

class DAO_Factory {
	private $dbManager;

	function getDbManager() {
		if($this->dbManager == null)
			throw new Exception("No persistence storage link");
		return $this->dbManager;
	}

	/**
	 * init resources: connect to the database
	 */
	function initDBResources() {
		$this->dbManager = new dbmanager(DB_NAME);
		$this->dbManager->openConnection();
	}

	/**
	 * release resources: close the database link
	 */
	function clearDBResources() {
		if($this->dbManager != null)
			$this->dbManager->closeConnection();
	}

	/**
	 * return the reference of the Users DAO
	 */
	function getUsersDAO() {
		require_once("dao/usersDAO.php");
		return new usersDAO($this->getDbManager());
	}
	
	function getSongDAO(){
		require_once("dao/songDAO.php");
		return new songDAO($this->getDbManager());
	}
}


