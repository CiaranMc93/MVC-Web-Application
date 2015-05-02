<?php

//require_once "functionality/Functionality.php";

class TaskController
{
	private $slimApp;
	private $model;
	private $requestBody;
	//private $functionality;

	public function __construct($model, $action = null, $slimApp, $parameteres = null)
	{
		$this->model = $model;
		$this->slimApp = $slimApp;
		$this->requestBody = json_decode($this->slimApp->request->getBody(), true ); // this must contain the representation of the new user

		//switch according to action
		switch ($action)
		{
			case ACTION_GET_TASKS :
				//get students stats
				$this->getTasks();
				break;
			case null :
				$this->slimApp->response()->setStatus(HTTPSTATUS_BADREQUEST);

				$Message = array (GENERAL_MESSAGE_LABEL => GENERAL_CLIENT_ERROR );

				$this->model->apiResponse = $Message;
				break;
		}
	}

	private function getTasks()
	{
		//get the array back from the model
		$tasks = $this->model->getTasks();

		//take the values from the class
		//$avg = $this->functionality->getAverage($studentAges);
		//$sd = $this->functionality->standardDev($studentAges);

		//count of all students
		$taskCount = 0;
		$overallTask;
		$average;

		//calculate the average
		foreach($tasks as $task)
		{
			$taskCount++;

			$totalTask = intval($task['duration_mins']);
			//get total age
			$overallTask = $overallTask + $totalTask;
		}

		//get average
		$average = $overallTask / count($tasks);

		$numTasks = 0;
		$mean = 0;
		$M2 = 0;

		//loop through each student to calculate standard dev
		foreach($tasks as $x)
		{
			//count students
			$numTasks++;
			//get current students age
			$currTask = intval($x["duration_mins"]);
			$delta = $currTask - $mean;
			//calculate the mean
			$mean = $mean + $delta/$numTasks;
			//calculate m2
			$M2 = $M2 + $delta*($currTask - $mean);
		}

		//get the variance
		$variance = $M2/($numTasks - 1);
		//get standard deviation
		$standDev = sqrt($variance);

		//create array to be printed
		$avgSDOutput = array('Number of Tasks' => $numTasks, 'Average Duration' => $average, 'Standard Dev' => $standDev);

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