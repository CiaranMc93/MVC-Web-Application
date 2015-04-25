<html>
<body>
<h1>Students age and standard deviation of age</h1>
<h2><a href="index.php/statistics/students">Get all students</a></h2>

<?php
require_once "../Slim/Slim.php";
Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim (); // slim run-time object

require_once "conf/config.inc.php";

//get all students 
$app->map ( "/statistics/students", function ($string = null) use($app) 
{
	$action = ACTION_GET_STATS;
	return new loadRunMVCComponents ( "StudentModel", "StudentController", "jsonView", $action, $app, $string);
} )->via ( "GET" );

//get all students by nationality
$app->map ( "/statistics/students:nationality", function ($nationality = null) use($app)
{
	$parameters["nationality"] = $nationality;
	$action = ACTION_GET_STATS;
	return new loadRunMVCComponents ( "StudentModel", "StudentController", "jsonView", $action, $app, $parameters );
} )->via ("GET");


//search users by string
$app->map ( "/users/search/:string", function ($string = null) use($app) {
	$parameters ["SearchingString"] = $string;
	$action = ACTION_GET_STATS;
	return new loadRunMVCComponents ( "UserModel", "UserController", "jsonView", $action, $app, $parameters );
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
		$this->view->output (); // this returns the response to the requesting client
	}
}
?>
</body>
</html>

