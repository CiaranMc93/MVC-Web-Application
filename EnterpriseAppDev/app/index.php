<?php
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

function authenticate()
{	
	$response;
	
	//put all headers into manageable array
	$headers = getAllHeaders();
	
	//take out the username and password passed in
	$password = $headers['Password'];
	$username = $headers['Username'];
	
	//get username and password
	$confPass = PASSWORD;
	$confUser = USERNAME;
	
	//compare strings to the copnstants
	if(strcmp($password, $confPass) == 0 && strcmp($username, $confUser) == 0)
	{
		//access is ok
		//$this->slimApp->response()->setStatus(HTTPSTATUS_OK);
		print_r('Success');
	}
	else 
	{
		//unathorized response
		//$this->slimApp->response()->setStatus(HTTPSTATUS_UNAUTHORIZED);
		print_r('Failure');
	}
}

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

