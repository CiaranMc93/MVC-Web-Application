<?php
class StudentDAO 
{
	private $dbManager;
	
	function StudentDAO($DBMngr) 
	{
		$this->dbManager = $DBMngr;
	}
	
	//create a select statement
	public function get($nationality = null) 
	{
		//if there is a nationality passed in
		if($nationality == null)
		{
			//select statement
			$sql = "SELECT age ";
			$sql .= "FROM students ";
		}
		else 
		{
			$sql = "SELECT age, id_nationality, description ";
			$sql .= "FROM enterpriseAppDev.students ";
			$sql .= "JOIN enterpriseAppDev.nationalities ON students.id_nationality = nationalities.id ";
			$sql .= "WHERE description = ?";
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
