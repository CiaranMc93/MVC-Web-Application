<?php

//sql part
class QuestionnaireDAO 
{
	private $dbManager;
	
	function QuestionnaireDAO($DBMngr) 
	{
		$this->dbManager = $DBMngr;
	}
	
	//create a select statement
	public function get($task = null) 
	{
		/*
		//if there is a task passed in
		if($task == null)
		{
			//select statement
			$sql = "SELECT MWL_Total, RSME ";
			$sql .= " FROM questionnaire ";
		}
		else 
		{
			$sql = "SELECT MWL_Total, RSME, task_number, intrusiveness ";
			$sql .= "FROM questionnaire ";
			$sql .= "WHERE task_number = ?";
		}
	  	*/
		
		$sql = "SELECT MWL_Total, RSME ";
		$sql .= " FROM questionnaire ";
		
		
		//prepare the query
		$stmt = $this->dbManager->prepareQuery ($sql);
		$this->dbManager->bindValue ($stmt, 1, $task, $this->dbManager->INT_TYPE);
		$this->dbManager->executeQuery($stmt);
		$rows = $this->dbManager->fetchResults ($stmt);
		
		return($rows);
	}
}
?>
