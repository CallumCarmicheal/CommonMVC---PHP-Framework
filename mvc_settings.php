<?php
/**
 * User: Callum Carmicheal
 * Date: 24/09/2016
 * Time: 18:35
 */

	//
	//
	// MVC -> Settings
	//
		/**
		 * Enables Debugging on the MVC Handler (MVC Loader)
		 */
		define ("CMVC_SETS_DEBUG_HANDLER", true);

	//
	//
	// Project -> Setup
	//
		/**
		 * The directory to use as project root
		 */
		define ("CMVC_PRJ_DIRECTORY", "example");

		/**
		 * The project namespace (Default namespace used for the project)
		 */
		define ("CMVC_PRJ_NAMESPACE", "ExampleProject");

		/**
		 * The directory to use as the controller root
		 *
		 * Default: CMVC_PRJ_NAMESPACE. "/Controllers"
		 */
		define ("CMVC_PRJ_DIRECTORY_CONTROLLERS", CMVC_PRJ_DIRECTORY. "/controllers");

		/**
		 * Controller namespace.
		 * 		This is the namespace that will be used when
		 * 		calling a controller
		 *
		 * Default: CMVC_PRJ_NAMESPACE. "/Controllers"
		 *
		 * Note:
		 * 		This can be completely different from the project namespace
		 * 		this can really be anything you want!
		 *
		 * 		Use 2 backslashes for a single backslash to escape the string!
		 */
		define ("CMVC_PRJ_NAMESPACE_CONTROLLERS", CMVC_PRJ_NAMESPACE. "\\Controllers");

	//
	//
	// Project -> Include
	//
		// Here store the location of every file that will be loaded
		// Into the framework before calling a MVC Controller
		//		This allows you to write your own classes or
		//		required functions without having to modify or tamper
		// 		with the mvc_handler and potentially breaking something.
		// Example:
		//		$CMVC_PRJ_EXTRA_INCLUDED_CLASSES[] = "example/classes/PastebinAPI.php";
		$CMVC_PRJ_EXTRA_INCLUDED_CLASSES = array();


	//
	//
	// Controllers -> Errors
	//
		/**
		 * The directory to use as the controller root
		 *
		 * Default: CMVC_PRJ_DIRECTORY_CONTROLLERS. "/MvcErrors"
		 */
		define ("CMVC_PRJ_DIRECTORY_CONTROLLERS_ERRORS", CMVC_PRJ_DIRECTORY_CONTROLLERS. "/Mvc");

		/**
		 * Controller errors namespace.
		 * 		This is the namespace that will be used when
		 * 		a error occurs in the framework
		 *
		 * Default: CMVC_PRJ_NAMESPACE_CONTROLLERS. "/MvcErrors"
		 *
		 * Note:
		 * 		Please get a copy of the example error controllers at
		 * 			https://github.com/
		 * 		and modify them.
		 *		* TO ENSURE THERE IS NO ERRORS
		 *
		 * 		Use 2 backslashes for a single backslash to escape the string!
		 */
		define ("CMVC_PRJ_NAMESPACE_CONTROLLERS_ERRORS", CMVC_PRJ_NAMESPACE_CONTROLLERS. "\\Mvc");


	//
	//
	// VirtualPaths -> Defaults
	//
		/**
		 * This is the default page when a used loads the website
		 * 		This is for when the user is logged in
		 *
		 * Note:
		 * 		This is displayed as a VIRTUAL PATH NOT CONTROLLER
		 */
		define ("CMVC_PRJ_VIRTPATH_DEFAULT_AUTHED", "Home/Index");

		/**
		 * This is the default page when a used loads the website
		 * 		This is for when the user is not logged in
		 *
		 * Note:
		 * 		This is displayed as a VIRTUAL PATH NOT CONTROLLER
		 */
		define ("CMVC_PRJ_VIRTPATH_DEFAULT_NOAUTH", "Auth/Login");

		/**
		 * If the user tries to use a controller that requires auth
		 *		The user will be redirected to this page
		 *
		 * Note:
		 * 		This is displayed as a VIRTUAL PATH NOT CONTROLLER
		 */
		define ("CMVC_PRJ_VIRTPATH_REDIRECT_NOAUTH", "Auth/Login");

		/**
		 * If a requested document tries to access another path due to
		 *   being a virtual path ../ to the browser will just go back and
		 *   cause issues, instead use the specified to access the root
		 *
		 * Example:
		 *   Accessing /Ajax/Test/Action from /Home/Dashboard/Area
		 *     RESOLVED TO: /Home/Dashboard/Ajax/Test/Action
		 *
		 *   * Using ../ will tell the browser to physically go back a page
		 *
		 * 	 But instead using $root/Ajax/Test/Action this tells the framework to
		 *     access he root directory instead
		 *
		 *     RESOLVED TO: /Home/Dashboard/$root/Ajax/Test/Action
		 *     Viewed as: /Ajax/Test/Action
		 *
		 * Note: Please use a special character when doing this, that ensures
		 *       that any and all controllers or pages wont have the identifier
		 *       in them, that would cause the controller or action to be viewed
		 *       as the root identifier.
		 *
		 *       WHEN USING THE ROOT IDENTIFIER THE LAST SEGMENT WILL BE USED
		 *          EG: TEST/$root/HOME/INDEX/<--/AUTH/LOGIN
		 *              AUTH/LOGIN WILL BE SELECTED INSTEAD OF THE OTHERS
		 *              BECAUSE IT IS THE FINAL SELECTION BEHIND THE $root IDENTIFIER
		 *
		 * 		 You can format your url like "$rootPath/Controller/Action" or
		 * 		  "$root/Path/Controller/Action"
		 *
		 * 		* IN THE EXAMPLES REPLACE $root WITH YOUR SELECTED IDENTIFIER!
		 */
		define ("CMVC_PRJ_VIRTPATH_ROOT_SPECIFIER", '$root');


	//
	//
	// Storage -> Database
	//
		/**
		 * Database host, usually localhost or 127.0.0.1
		 */
		define ("CMVC_PRJ_STORAGE_DB_HOST", 	"localhost");

		/**
		 * Database username, usually root
		 */
		define ("CMVC_PRJ_STORAGE_DB_USER", 	"root");

		/**
		 * Database password, usually a-s3c|_|r3-p4$$w0rd
		 */
		define ("CMVC_PRJ_STORAGE_DB_PASS", 	"");

		/**
		 * Database database,
		 */
		define ("CMVC_PRJ_STORAGE_DB_DB",   	"CMVC_Database");


		/**
		 * Database datanase, usually localhost
		 */
		define ("CMVC_PRJ_STORAGE_DB_CHARSET", 	"utf8");