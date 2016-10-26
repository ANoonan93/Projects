<?php
require_once("dao.php");
class songDAO extends BaseDAO {
	function messagesDAO($dbMng) {
		parent::BaseDAO($dbMng);
	}
	
	public function getTableList(){
		$sqlQuery = "SELECT * FROM library";
		$result = $this->getDbManager()->executeQuery($sqlQuery);
		return $result;
	}
	
	public function isSongExisting($artist, $song){
		$sqlQuery = "SELECT count(*) as isExisting ";
		$sqlQuery .= "FROM library ";
		$sqlQuery .= "WHERE artist='$artist' AND song='$song' ";
		$result = $this->getDbManager()->executeSelectQuery($sqlQuery);
		
		if ($result[0]["isExisting"] == 1) return (true);
		else return (false);
	}
	
	public function insertNewMusic($artist, $song, $comment, $genre){
		$sqlQuery = "INSERT INTO library (artist, song, comment, genre) ";
		$sqlQuery .= "VALUES ('$artist', '$song', '$comment', '$genre') ";
		$result = $this->getDbManager()->executeQuery($sqlQuery);
		return $result;
	}
	
	public function deleteMusic($artist, $song){
		$sqlQuery = "DELETE ";
		$sqlQuery .= "FROM library ";
		$sqlQuery .= "WHERE artist = '$artist' AND song = '$song'";
		$result = $this->getDbManager()->executeQuery($sqlQuery);
		return $result;
	}
	
	public function updateMusic($artist, $song, $comment, $genre){
		$sqlQuery = "UPDATE library SET ";
		$sqlQuery .= "comment = '$comment', genre = '$genre' ";
		$sqlQuery .= "WHERE artist = '$artist' AND song = '$song' ";
		$result = $this->getDbManager()->executeQuery($sqlQuery);
		return $result;
	}
}
?>