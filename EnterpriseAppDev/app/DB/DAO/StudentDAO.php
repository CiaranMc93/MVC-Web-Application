<?php
class StudentDAO 
{
	private $dbManager;
	
	function StudentDAO($DBMngr) 
	{
		$this->dbManager = $DBMngr;
	}
	
	//create a select statement
	public function get($nationality) 
	{
		//select statement
		$sql = "SELECT * ";
		$sql .= "FROM students ";
		
		if ($nationality != null)
		{
			$sql .= "WHERE students.id_nationality=? ";
		}
		
		//prepare the query
		$stmt = $this->dbManager->prepareQuery ($sql);
		$this->dbManager->bindValue ($stmt, 1, $nationality, $this->dbManager->INT_TYPE);
		$this->dbManager->executeQuery($stmt);
		$rows = $this->dbManager->fetchResults ($stmt);
		
		return ($rows);
	}
}
?>
