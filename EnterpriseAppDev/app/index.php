<?php

require_once "conf/config.inc.php";

require "../Slim/Middleware.php";
require "../Slim/Middleware/BasicAuth.php";
require_once "../Slim/Slim.php";

Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim(); // slim run-time object

$app->add(new \BasicAuth(USERNAME,PASSWORD));

/*
//authentication function
function authenticate()
{	
	$array = getallheaders();
	
	//take out the username and password passed in
	$password = $array['Password'];
	$username = $array['Username'];
	
	//get username and password
	$confPass = PASSWORD;
	$confUser = USERNAME;
	
	$auth = $confUser . ":" . $confPass;
	
	$auth1 = base64_encode($auth);
	
	print_r($auth1);
	
	//compare strings to the copnstants
	if(strcmp($password, $confPass) == 0 && strcmp($username, $confUser) == 0)
	{
		//$this->slimApp->response()->setStatus(HTTPSTATUS_OK);
	}
	else
	{
		//$this->slimApp->response()->setStatus(HTTPSTATUS_UNAUTHORIZED);
	}
}
*/

//get all students 
$app->map ("/statistics/students", function () use($app) 
{
	$action = ACTION_GET_STATS;
	return new loadRunMVCComponents ( "StudentModel", "StudentController", "jsonView", $action, $app, $string);
} )->via ( "GET" );


//get all students by nationality
$app->map ("/statistics/students(/:nationality)", function ($nationality = null) use($app)
{
	$httpMethod = $app->request->getMethod();
	$action = ACTION_GET_NAT;
	$parameters["nationality"] = $nationality;
	return new loadRunMVCComponents ("StudentModel", "StudentController", "jsonView", $action, $app, $parameters);
} )->via ("GET");

//get all students
$app->map ("/statistics/tasks", function() use($app)
{
	$action = ACTION_GET_TASKS;
	return new loadRunMVCComponents ( "TaskModel", "TaskController", "jsonView", $action, $app, $string);
} )->via ( "GET" );

//get all questionnaires
$app->map ("/statistics/questionnaires", function($string = null) use($app)
{
	$action = ACTION_GET_QUESTIONNAIRES;
	return new loadRunMVCComponents ( "QuestionnaireModel", "QuestionnaireController", "jsonView", $action, $app, $string);
} )->via ( "GET" );


//get questionnaires by task
$app->map ("/statistics/questionnaires(/:task)", function($task = null) use($app)
{
	$httpMethod = $app->request->getMethod();
	$action = ACTION_GET_QUESTIONNAIRES_BY_TASK;
	$parameters["task"] = $task;
	return new loadRunMVCComponents ( "QuestionnaireModel", "QuestionnaireController", "jsonView", $action, $app, $parameters);
} )->via ( "GET" );

$app->run ();

class loadRunMVCComponents 
{
	public $model, $controller, $view;
	
	public function __construct($modelName, $controllerName, $viewName, $action, $app, $parameters = null) 
	{
		include_once "models/" . $modelName . ".php";
		include_once "controllers/" . $controllerName . ".php";
		include_once "views/" . $viewName . ".php";
		
		$this->model = new $modelName (); // common model
		$this->controller = new $controllerName ( $this->model, $action, $app, $parameters );
		$this->view = new $viewName ( $this->controller, $this->model, $app ); // common view
		$this->view->output(); // this returns the response to the requesting client
	}
}
?>

