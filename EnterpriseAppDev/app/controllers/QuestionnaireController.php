<?php

//require_once "functionality/Functionality.php";

class QuestionnaireController
{
	private $slimApp;
	private $model;
	private $requestBody;
	private $task;
	private $questionnaireArray;
	//private $functionality;
	
	public function __construct($model, $action = null, $slimApp, $parameteres = null) 
	{
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode($this->slimApp->request->getBody(), true ); // this must contain the representation of the new user
		
		//switch according to action
		switch ($action) 
		{
			case ACTION_GET_QUESTIONNAIRES :
				//get students stats
				$this->getQuestionnaires();
				break;
				/*
			case ACTION_GET_QUESTIONNAIRES_BY_TASK:
				//get students by nationality
				$this->getQuestionnaire($tasks);
				break;
				*/
			case null :
				$this->slimApp->response()->setStatus(HTTPSTATUS_BADREQUEST);
				
				$Message = array (GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR );
				
				$this->model->apiResponse = $Message;
				break;
		}
	}
	
	private function getQuestionnaires() 
	{
		//get the array back from the model
		$questionnaires = $this->model->getQuestionnaires();
		
		//take the values from the class
		//$avg = $this->functionality->getAverage($studentAges);
		//$sd = $this->functionality->standardDev($studentAges);
		
		//count of all questionnaires
		$questionnaireCount = 0;
		$overallQuestionnaires = 0;
		$MWLaverage;
		
		//calculate the average
		foreach($questionnaires as $questions)
		{
			$questionnaireCount++;
		
			$totalQuestionnaires = intval($questions['MWL_Total']);
			//get total age
			$overallQuestionnaires = $overallQuestionnaires + $totalQuestionnaires;
		}
		
		//get average
		$MWLaverage = $overallQuestionnaires / count($questionnaires);
		
		//RMSE values average
		//count of all questionnaires
		$questionnaireCount = 0;
		$overallQuestionnaires = 0;
		$RMSEaverage;
		
		//calculate the average
		foreach($questionnaires as $questions)
		{
			$questionnaireCount++;
		
			$totalQuestionnaires = intval($questions['RSME']);
			//get total age
			$overallQuestionnaires = $overallQuestionnaires + $totalQuestionnaires;
		}
		
		//get average
		$RMSEaverage = $overallQuestionnaires / count($questionnaires);
		
		//MWL SD
		$numQuestionnaires = 0;
		$mean = 0;
		$M2 = 0;
		
		//loop through each student to calculate standard dev
		foreach($questionnaires as $x)
		{
			//count students
			$numQuestionnaires++;
			//get current students age
			$currQuestion = intval($x["MWL_Total"]);
			$delta = $currQuestion - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numQuestionnaires;
			//calculate m2
			$M2 = $M2 + $delta*($currQuestion - $mean);
		}
		
		//get the variance
		$variance = $M2/($numQuestionnaires - 1);
		//get standard deviation
		$MWLstandDev = sqrt($variance);
		
		//RMSE SD
		$numQuestionnaires = 0;
		$mean = 0;
		$M2 = 0;
		
		//loop through each student to calculate standard dev
		foreach($questionnaires as $x)
		{
			//count students
			$numQuestionnaires++;
			//get current students age
			$currQuestion = intval($x["RSME"]);
			$delta = $currQuestion - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numQuestionnaires;
			//calculate m2
			$M2 = $M2 + $delta*($currQuestion - $mean);
		}
		
		//get the variance
		$variance = $M2/($numQuestionnaires - 1);
		//get standard deviation
		$RMSEstandDev = sqrt($variance);
		
		//create array to be printed
		$avgSDOutput = array('Number of Questionnaires' => $numQuestionnaires,'Average MWL_Total' => $MWLaverage, "Standard Dev of MWL_Total" => $MWLstandDev,'Average RMSE' => $RMSEaverage, "Standard Dev of RMSE" => $RMSEstandDev);
		
		if ($avgSDOutput != null) 
		{
			$this->slimApp->response ()->setStatus (HTTPSTATUS_OK);
			$this->model->apiResponse = $avgSDOutput;
		} 
		else 
		{
			$this->slimApp->response ()->setStatus(HTTPSTATUS_NOCONTENT);
			
			$Message = array 
			(
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			//send message
			$this->model->apiResponse = $Message;
		}
	}
		
	
	// get the students by nationality
	private function getQuestionnaire($task) 
	{
		//get the array back from the model
		$questionnaireArray = $this->model->getQuestionnaire($task);
		
		var_dump($questionnaireArray);
		
		//take the values from the class
		//$avg = $this->functionality->getAverage($studentAges);
		//$sd = $this->functionality->standardDev($studentAges);
		
		//count of all questionnaires
		$questionnaireCount = 0;
		$overallQuestionnaires = 0;
		$MWLaverage;
		
		//calculate the average
		foreach($questionnaireArray as $questions)
		{
			$questionnaireCount++;
		
			$totalQuestionnaires = intval($questions['MWL_Total']);
			//get total age
			$overallQuestionnaires = $overallQuestionnaires + $totalQuestionnaires;
		}
		
		//get average
		$MWLaverage = $overallQuestionnaires / count($questionnaireArray);
		
		//RMSE values average
		//count of all questionnaires
		$questionnaireCount = 0;
		$overallQuestionnaires = 0;
		$RMSEaverage;
		
		//calculate the average
		foreach($questionnaireArray as $questions)
		{
			$questionnaireCount++;
		
			$totalQuestionnaires = intval($questions['RSME']);
			//get total age
			$overallQuestionnaires = $overallQuestionnaires + $totalQuestionnaires;
		}
		
		//get average
		$RMSEaverage = $overallQuestionnaires / count($questionnaireArray);
		
		//MWL SD
		$numQuestionnaires = 0;
		$mean = 0;
		$M2 = 0;
		
		//loop through each student to calculate standard dev
		foreach($questionnaireArray as $x)
		{
			//count students
			$numQuestionnaires++;
			//get current students age
			$currQuestion = intval($x["MWL_Total"]);
			$delta = $currQuestion - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numQuestionnaires;
			//calculate m2
			$M2 = $M2 + $delta*($currQuestion - $mean);
		}
		
		//get the variance
		$variance = $M2/($numQuestionnaires - 1);
		//get standard deviation
		$MWLstandDev = sqrt($variance);
		
		//RMSE SD
		$numQuestionnaires = 0;
		$mean = 0;
		$M2 = 0;
		
		//loop through each student to calculate standard dev
		foreach($questionnaireArray as $x)
		{
			//count students
			$numQuestionnaires++;
			//get current students age
			$currQuestion = intval($x["RSME"]);
			$delta = $currQuestion - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numQuestionnaires;
			//calculate m2
			$M2 = $M2 + $delta*($currQuestion - $mean);
		}
		
		//get the variance
		$variance = $M2/($numQuestionnaires - 1);
		//get standard deviation
		$RMSEstandDev = sqrt($variance);
		
		//create array to be printed
		$avgSDOutput = array('Number of Questionnaires' => $numQuestionnaires,'Average MWL_Total' => $MWLaverage, "Standard Dev of MWL_Total" => $MWLstandDev,'Average RMSE' => $RMSEaverage, "Standard Dev of RMSE" => $RMSEstandDev);
		
		if ($avgSDOutput != null) 
		{
			$this->slimApp->response ()->setStatus (HTTPSTATUS_OK);
			$this->model->apiResponse = $avgSDOutput;
		} 
		else 
		{
			$this->slimApp->response ()->setStatus(HTTPSTATUS_NOCONTENT);
			
			$Message = array 
			(
					GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
			);
			//send message
			$this->model->apiResponse = $Message;
		}
	}
	
}
?>