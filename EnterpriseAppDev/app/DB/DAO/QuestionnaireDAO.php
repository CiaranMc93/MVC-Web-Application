<?php
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
		//if there is a task passed in
		if($task = null)
		{
			//select statement
			$sql = "SELECT MWL_Total, RSME ";
			$sql .= "FROM questionnaire students ";
		}
		else 
		{
			$sql = "SELECT MWL_Total, RSME, task_number, intrusiveness ";
			$sql .= "FROM enterpriseAppDev.questionnaire ";
			$sql .= "WHERE task_number = ?";
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
