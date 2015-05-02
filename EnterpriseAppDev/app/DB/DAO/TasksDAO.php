<?php
class TasksDAO
{
	private $dbManager;

	function TasksDAO($DBMngr)
	{
		$this->dbManager = $DBMngr;
	}

	//create a select statement
	public function get()
	{
		//select statement
		$sql = "SELECT duration_mins ";
		$sql .= "FROM tasks ";
		
		//prepare the query
		$stmt = $this->dbManager->prepareQuery ($sql);
		$this->dbManager->bindValue ($stmt, 1, $nationality, $this->dbManager->INT_TYPE);
		$this->dbManager->executeQuery($stmt);
		$rows = $this->dbManager->fetchResults ($stmt);

		return ($rows);
	}
}
?>