<?php
//not working
//require_once "functionality/Functionality.php";

class StudentController 
{
	private $slimApp;
	private $model;
	private $requestBody;
	private $nationality;
	private $studentNat;
	//private $functionality;
	
	public function __construct($model, $action = null, $slimApp, $parameteres = null) 
	{
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode($this->slimApp->request->getBody(), true ); // this must contain the representation of the new user
		
		if (!empty($parameteres["nationality"]))
		{
			$nationality = $parameteres["nationality"];
		}
		
		//switch according to action
		switch ($action) 
		{
			case ACTION_GET_STATS :
				//get students stats
				$this->getStudents();
				break;
			case ACTION_GET_NAT:
				//get students by nationality
				$this->getStudent($nationality);
				break;
			case null :
				$this->slimApp->response()->setStatus(HTTPSTATUS_BADREQUEST);
				
				$Message = array (GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR );
				
				$this->model->apiResponse = $Message;
				break;
		}
	}
	
	private function getStudents() 
	{
		//get the array back from the model
		$studentAges = $this->model->getStudents();
		
		//take the values from the class
		//$avg = $this->functionality->getAverage($studentAges);
		//$sd = $this->functionality->standardDev($studentAges);
		
		//count of all students
		$ageCount = 0;
		$overallAge;
		$average;
		
		//calculate the average
		foreach($studentAges as $ages)
		{
			$ageCount++;
		
			$totalAge = intval($ages['age']);
			//get total age
			$overallAge = $overallAge + $totalAge;
		}
		
		//get average
		$average = $overallAge / count($studentAges);
		
		$numStudents = 0;
		$mean = 0;
		$M2 = 0;
		
		//loop through each student to calculate standard dev
		foreach($studentAges as $x)
		{
			//count students
			$numStudents++;
			//get current students age
			$currAge = intval($x["age"]);
			$delta = $currAge - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numStudents;
			//calculate m2
			$M2 = $M2 + $delta*($currAge - $mean);
		}
		
		//get the variance
		$variance = $M2/($numStudents - 1);
		//get standard deviation
		$standDev = sqrt($variance);
		
		//create array to be printed
		$avgSDOutput = array('Average' => $average, "Standard Dev" => $standDev);
		
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
	private function getStudent($nationality) 
	{
		// student nationality array
		$studentNat = $this->model->getStudent ( $nationality );
		
		if ($studentNat != null) 
		{
			if (count ( $studentNat ) == 1) 
			{
				//there is only 1 value available for this route so there is no average or standard deviation?
				var_dump ( $studentNat );
			} 
			else 
			{
				// count of all students
				$natCount = 0;
				$overallNat;
				$average;
				
				foreach ( $studentNat as $nationalities ) 
				{
					$natCount ++;
					
					$totalNat = intval ( $nationalities ['age'] );
					// get total age
					$overallNat = $overallNat + $totalNat;
				}
				
				// get average
				$average = $overallNat / count ( $studentNat );
				
				$numNats = 0;
				$mean = 0;
				$M2 = 0;
				
				// loop through each student
				foreach ( $studentNat as $x ) 
				{
					// count students
					$numNats ++;
					// get current students age
					$currNat = intval ( $x ["age"] );
					$delta = $currNat - $mean;
					// calculate the mean
					$mean = $mean + $delta / $numNats;
					// calculate m2
					$M2 = $M2 + $delta * ($currNat - $mean);
				}
				
				// get the variance
				$variance = $M2 / ($numNats - 1);
				// get standard deviation
				$standDev = sqrt ( $variance );
				
				// create array to be printed
				$natSDOutput = array (
						'Nation' => $nationality,
						'Average' => $average,
						"Standard Dev" => $standDev 
				);
				
				if ($natSDOutput != null) {
					$this->slimApp->response ()->setStatus ( HTTPSTATUS_OK );
					$this->model->apiResponse = $natSDOutput;
				} else {
					
					$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
					
					$Message = array (
							GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE 
					);
					$this->model->apiResponse = $Message;
				}
			}
		} 
		else 
		{
			$this->slimApp->response ()->setStatus ( HTTPSTATUS_NOCONTENT );
			
			$Message = array (GENERAL_MESSAGE_LABEL => GENERAL_NOCONTENT_MESSAGE );
			
			$this->model->apiResponse = $Message;
		}
	}
}
?>