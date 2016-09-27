<?php

/**
 * User: Callum Carmicheal
 * Date: 27/09/2016
 * Time: 19:37
 */


namespace ExampleProject\Controllers;



	use CommonMVC\Classes\Authentication\AuthStatus;
	use CommonMVC\MVC\MVCController;
	use CommonMVC\MVC\MVCResult;
	use CommonMVC\MVC\MVCResultEnums;

	// Note this is a just a dummy controller
	//   it will redirect the user to their default place
	//   of home
	//
	// Although this can be used just like any other controller
	//   to server content
	class HomeController extends MVCController {



		public function __construct() {
			$this->ControllerName 	= "SecureArea/Home";
			$this->Enabled 			= true;
			$this->AuthRequired 	= false;
		}

		/**
		 * Redirect to the login by default
		 * @return MVCResult
		 */
		public function Index() {

			// Redirect to dashboard
			// if the user is logged in
			if (AuthStatus::isLoggedIn()) {
				return MVCResult::Redirect(
					"SecureArea/Home/Index",
					MVCResultEnums::$REDIRECT_MVC);
			}

			// Redirect to login if the user is not
			// logged in
			return MVCResult::Redirect(
				"Auth/Login",
				MVCResultEnums::$REDIRECT_MVC
			);
		}
	}