<?php
/* database constants */
define("DB_HOST", "mysql.lucalongo.eu" ); 		// set database host
define("DB_USER", "enterpriseAppDev" ); 			// set database user
define("DB_PASS", "luca20142015" ); 				// set database password
define("DB_PORT", 3306);				// set database port
define("DB_NAME", "enterpriseAppDev" ); 			// set database name
define("DB_CHARSET", "utf8" ); 			// set database charset
define("DB_DEBUGMODE", true ); 			// set database charset


/* actions for the USERS REST resource */
define("ACTION_GET_USER", 33);
define("ACTION_GET_USERS", 44);
define("ACTION_CREATE_USER", 55);
define("ACTION_UPDATE_USER", 66);
define("ACTION_DELETE_USER", 77);
define("ACTION_SEARCH_USERS", 88);
define("ACTION_GET_STATS", 99);
define("ACTION_GET_STUDENTS", 111);

//define username and password for authentication
define("USERNAME",CiaranMc93);
define("PASSWORD",C11354741);

/* HTTP status codes 2xx*/
define("HTTPSTATUS_OK", 200);
define("HTTPSTATUS_CREATED", 201);
define("HTTPSTATUS_NOCONTENT", 204);

/* HTTP status codes 3xx (with slim the output is not produced i.e. echo statements are not processed) */
define("HTTPSTATUS_NOTMODIFIED", 304);


/* HTTP status codes 4xx */
define("HTTPSTATUS_BADREQUEST", 400);
define("HTTPSTATUS_UNAUTHORIZED", 401);
define("HTTPSTATUS_FORBIDDEN", 403);
define("HTTPSTATUS_NOTFOUND", 404);
define("HTTPSTATUS_REQUESTTIMEOUT", 408);
define("HTTPSTATUS_TOKENREQUIRED", 499);

/* HTTP status codes 5xx */
define("HTTPSTATUS_INTSERVERERR", 500);

define("TIMEOUT_PERIOD", 120);

/* general message */
define("GENERAL_MESSAGE_LABEL", "message");
define("GENERAL_SUCCESS_MESSAGE", "success");
define("GENERAL_ERROR_MESSAGE", "error");
define("GENERAL_NOCONTENT_MESSAGE", "no-content");
define("GENERAL_NOTMODIFIED_MESSAGE", "not modified");
define("GENERAL_INTERNALAPPERROR_MESSAGE", "internal app error");
define("GENERAL_CLIENT_ERROR", "client error: modify the request");
define("GENERAL_INVALIDTOKEN_ERROR", "Invalid token");
define("GENERAL_APINOTEXISTING_ERROR", "Api is not existing");
define("GENERAL_RESOURCE_CREATED", "Resource has been created");
define("GENERAL_RESOURCE_UPDATED", "Resource has been updated");
define("GENERAL_RESOURCE_DELETED", "Resource has been deleted");

define("GENERAL_FORBIDDEN", "Request is ok but action is forbidden");
define("GENERAL_INVALIDBODY", "Request is ok but transmitted body is invalid");

define("GENERAL_WELCOME_MESSAGE", "Welcome to MSc dissertation API");

?>