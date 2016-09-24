<?php

	// First enable session
	// Set default timezone
	session_start();
	date_default_timezone_set("Europe/London");

	include ("mvc_settings.php");
	$MVC_DEBUG_OUTPUT = CMVC_SETS_DEBUG_HANDLER;

	/* Require all the libraries */ {
	// Classes (1/1)
		// Storage (1/1)
			require_once ("data/classes/Storage/Database.php");
			require_once ("data/classes/Storage/Templates.php");
		// Authentication (1/2)
			require_once ("data/classes/Authentication/Settings.php");
			require_once ("data/classes/Authentication/Status.php");
			require_once ("data/classes/Authentication/AReqHandler.php");
		// User (1/1)
			require_once ("data/classes/User/Account.php");

	// MVC (1/1)
		require_once ("data/mvc/MVCHandler.php");
		require_once ("data/mvc/MVCResult.php");
		require_once ("data/mvc/MVCController.php");
		require_once ("data/mvc/MVCExecutor.php");
	}

	function alterSpacesToDashes($string) {
		//Lower case everything
		$string = strtolower($string);
		//Convert whitespaces and underscore to dash
		$string = preg_replace("/[\s_]/", "-", $string);
		return $string;
	}

	function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

	function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}

	$mvcExec = new \CommonMVC\MVC\MVCExecutor();


	if($MVC_DEBUG_OUTPUT) echo "<pre>";

	$VirtualPath = "";

	/* Check if the current request contains a page */ {
		if (empty($_GET['mvc_path'])) {
			if(CommonMVC\Classes\Authentication\Status::isLoggedIn())
				 $VirtualPath = CMVC_PRJ_VIRTPATH_DEFAULT_AUTHED;
			else $VirtualPath = CMVC_PRJ_VIRTPATH_DEFAULT_NOAUTH;
		} else {
			$VirtualPath = $_GET['mvc_path'];
		}
	}

	// Remove any spaces from the string and replace them with
	if($MVC_DEBUG_OUTPUT) echo '$VirtualPath (Before Dashes): '. $VirtualPath. "\n";
	$VirtualPath = alterSpacesToDashes($VirtualPath);
	if($MVC_DEBUG_OUTPUT) echo '$VirtualPath (After  Dashes): '. $VirtualPath. "\n";

	// Clean up the Path so each word start is capitalised
	$VirtualPath = implode('/', array_map('ucfirst', explode('/', $VirtualPath)));
	if($MVC_DEBUG_OUTPUT) echo '$VirtualPath (Capitalised  ): '. $VirtualPath. "\n\n";

	/* Attempt to find the controller! */ {
		$Path 		= CMVC_PRJ_DIRECTORY_CONTROLLERS;
		$Namespace 	= CMVC_PRJ_NAMESPACE_CONTROLLERS;
		$Controller = "";
		$Action 	= "";
		$Arr 		= explode("/", $VirtualPath);
		$ArrLen 	= count($Arr)-1;

		if($MVC_DEBUG_OUTPUT) echo '$arr (len:'. $ArrLen. ') = ';
		print_r($Arr); echo "\n";

		if ($ArrLen == 0) {
			// [0] = Controller

			$Controller = $Arr[0];
			$Action = "Index";
		}
		else if ($ArrLen >= 2) {
			// [0-(Len-2)] 	Path
			// [Len-1] 		Controller
			// [Len]		Action

			$PathCount = $ArrLen-2;
			$tmpNamespace = "";

			for($x = 0; $x <= $PathCount; $x++)
				$tmpNamespace .= $Arr[$x]. "/";

			$tmpNamespace = rtrim($tmpNamespace,"/");

			$Path     .= $tmpNamespace;
			$Namespace = str_replace($tmpNamespace, "/", "\\");

			$Controller = $Arr[$ArrLen-1];
			$Action = $Arr[$ArrLen];
		}
		else {
			// [0] = Controller
			// [1] = Action

			$Controller = $Arr[0];
			$Action 	= $Arr[1];
		}

		if($Action == "") $Action = "Index";

		$Namespace 	   = trim($Namespace, "\\");
		$ControllerRaw = $Controller. "Controller";
		$Controller   .= "Controller.php";

		if($MVC_DEBUG_OUTPUT) echo '$Path: '. 		$Path . "\n";
		if($MVC_DEBUG_OUTPUT) echo '$Namespace: '. 	$Namespace. "\n";
		if($MVC_DEBUG_OUTPUT) echo '$Controller: '. $Controller. "\n";
		if($MVC_DEBUG_OUTPUT) echo '$Action: '. 	$Action. "\n";
	}

	if($MVC_DEBUG_OUTPUT) "\n";

	/* Check if controller exists */ {

		$mvcCtx = new \CommonMVC\MVC\MVCContext();


		$filePath = $Path;
		$filePath .= "/". $Controller;
		$filePath = str_replace("//", "/", $filePath);

		if($MVC_DEBUG_OUTPUT) echo '$filePath: '. 	$filePath. "\n";

		if(file_exists($filePath)) {
			if ($MVC_DEBUG_OUTPUT) echo '$filePath: File Exists' . "\n";

			// Attempt to load the controller
			require_once ($filePath);

			$class = $Namespace. '\\'. $ControllerRaw;
			if ($MVC_DEBUG_OUTPUT) echo '$class: '. $class. "\n";

			/**
			 * @var \CommonMVC\MVC\MVCController $mvc
			 */
			$mvc = new $class();

			if ($MVC_DEBUG_OUTPUT) echo '$mvc->getControllerName(): '. $mvc->getControllerName(). "\n";

			// Check if the controller contains the Action

			if(method_exists($mvc, $Action)) {
				if($MVC_DEBUG_OUTPUT) "Method Exists";

				// By default we redirect so lets get our
				// MVCResult and then check if it is a redirect

				/**
				 * @var \CommonMVC\MVC\MVCResult $mvcRes
				 */
				$mvcRes = $mvc->$Action();

				if($MVC_DEBUG_OUTPUT) echo "Executing MVC's Result \n";

				$mvcExec->ExecuteMVC($mvcRes);
			} else {
				if($MVC_DEBUG_OUTPUT) echo "Method Does not exit\n";
			}
		} else {
			if ($MVC_DEBUG_OUTPUT) echo '$filePath: File Does Not Exist'. "\n";

			$filePath = CMVC_PRJ_DIRECTORY_CONTROLLERS_ERRORS;
			$filePath .= "/MvcController.php";

			if(!file_exists($filePath)) {
				if (!$MVC_DEBUG_OUTPUT) ob_get_clean();
				die("Cannot find the MvcController for Errors ($filePath)");
				exit;
			}

			// Load the file
			require_once ($filePath);

			$class = CMVC_PRJ_NAMESPACE_CONTROLLERS_ERRORS. "\\MvcController";

			/**
			 * @var \CommonMVC\MVC\MVCController $mvc
			 */
			$mvc = new $class();
			if ($MVC_DEBUG_OUTPUT) echo '$mvc->getControllerName(): '. $mvc->getControllerName(). "\n";

			$Action = "ControllerNotFound";

			if(method_exists($mvc, $Action)) {
				if($MVC_DEBUG_OUTPUT) "Method Exists";

				// By default we redirect so lets get our
				// MVCResult and then check if it is a redirect

				/**
				 * @var \CommonMVC\MVC\MVCResult $mvcRes
				 */
				$mvcRes = $mvc->$Action();

				if($MVC_DEBUG_OUTPUT) echo "Executing MVC's Result \n";



				$mvcExec->ExecuteMVC($mvcRes);
			} else {
				if (!$MVC_DEBUG_OUTPUT) ob_get_clean();
				die ("CANNOT FIND THE 'ControllerNotFound' FUNCTION IN 'MvcErrors\\MvcController' controller located in ($filePath).  \n");
				exit;
			}
		}
	}