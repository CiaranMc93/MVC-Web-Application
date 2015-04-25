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
				$this->getStudents($nationality);
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
	
	private function getStudents($nationality) 
	{
		$answer = $this->model->getStudents($nationality);
		
		if ($answer != null) 
		{
			$this->slimApp->response ()->setStatus (HTTPSTATUS_OK);
			$this->model->apiResponse = $answer;
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