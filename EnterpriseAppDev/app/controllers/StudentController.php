<?php
class StudentController 
{
	private $slimApp;
	private $model;
	private $requestBody;
	
	public function __construct($model, $action = null, $slimApp, $parameteres = null) 
	{
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode($this->slimApp->request->getBody(), true ); // this must contain the representation of the new user
		
		
		if (! empty($parameteres["nation"]))
		{
			$nationality = $parameteres["nation"];
		}
		
		//switch according to action
		switch ($action) 
		{
			case ACTION_GET_STATS :
				//get students stats
				$this->getStudents();
				break;
			case ACTION_GET_STUDENTS:
				//get students by nationality
				$this->getStudent($nationality);
				break;
			case null :
				$this->slimApp->response ()->setStatus ( HTTPSTATUS_BADREQUEST );
				$Message = array (
						GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR 
				);
				$this->model->apiResponse = $Message;
				break;
		}
	}
	
	private function getStudents() 
	{
		//count of all students
		$ageCount = 0;
		$overallAge;
		$average;
		
		$studentAges = $this->model->getStudents();
		
		foreach($studentAges as $ages)
		{
			$ageCount++;
			
			$totalAge = intval($ages['age']);
			//get total age
			$overallAge = $overallAge + $totalAge;
			
		}
		
		//get average
		$average = $overallAge / count($studentAges);
		$ages = 0;
		
		foreach($studentAges as $ages)
		{		
			$ages++;
			$totalAge = intval($ages['age']);
			$delt = $totalAge - $average;
			
			$average = $average + $delt/$ages;
			//standard deviation
			$totalSquared = $totalSquared + $delt*($totalAge - $average);	
		}
		
		$variance = $totalSquared / ($ages - 1);
		$sd = sqrt($fVariance);
		
		//create array to be printed
		$avg = array('Average' => $average, "Standard Dev" => $sd);
		
		if ($avg != null) 
		{
			$this->slimApp->response ()->setStatus (HTTPSTATUS_OK);
			$this->model->apiResponse = $avg;
		} 
		else 
		{
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			
			$Message = array 
			(
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			
			$this->model->apiResponse = $Message;
		}
	}
	
	private function getStudent($nationality) 
	{
		
		$answer = $this->model->getStudent($nationality);
		
		if ($answer != null) 
		{
			$this->slimApp->response ()->setStatus (HTTPSTATUS_OK);
			$this->model->apiResponse = $answer;
		} 
		else 
		{
			
			$this->slimApp->response ()->setStatus (HTTPSTATUS_NOCONTENT);
			
			$Message = array 
			(
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			$this->model->apiResponse = $Message;
		}
	}
}
?>