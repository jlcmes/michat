<?php
/** @package Cargo::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("App/ExampleUser.php");
require_once("Model/User.php");

/**
 * SecureExampleController is a sample controller to demonstrate
 * one approach to authentication in a Phreeze app
 *
 * @package Cargo::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class SecureExampleController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
	}
	
	/**
	 * This page requires ExampleUser::$PERMISSION_USER to view
	 */
	public function UserPage()
	{
		$this->RequirePermission(ExampleUser::$PERMISSION_USER, 
				'SecureExample.LoginForm', 
				'Login is required to access the secure user page',
				'You do not have permission to access the secure user page');
		
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','userpage');
		$this->Render("SecureExample");
	}
	
	/**
	 * This page requires ExampleUser::$PERMISSION_ADMIN to view
	 */
	public function AdminPage()
	{
		$this->RequirePermission(ExampleUser::$PERMISSION_ADMIN, 
				'SecureExample.LoginForm', 
				'Login is required to access this page',
				'Admin permission is required to access this page');
		
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','adminpage');
		$this->Render("SecureExample");
	}
	
	/**
	 * Display the login form
	 */
	public function LoginForm()
	{
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','login');
		$this->Render("SecureExample");
	}
	
	/**
	 * Process the login, create the user session and then redirect to 
	 * the appropriate page
	 */
	public function Login()
	{
		$user = new ExampleUser();

		$username = RequestUtil::Get('username');
		$password = RequestUtil::Get('password');
		
		/*
		// No hardcoded users permited
		if ($user->Login($username, $password))
		{
			// Admin (or hardcoded user) login
			$this->SetCurrentUser($user);
			$this->Redirect('SecureExample.UserPage');
		}
		else
		{
		*/

		// DB user login
		require_once('Model/UserCriteria.php');
		
		// Generate MD5 from the password and compare.
		$password = md5($password);

		// Create criteria to compare username and password
		$criteriaUser = new UserCriteria();
		$cf = new CriteriaFilter('Username', $username);
		$cf2 = new CriteriaFilter('Password', $password);
		$criteriaUser->AddFilter($cf);
		$criteriaUser->AddFilter($cf2);

		$list = $this->Phreezer->Query('User', $criteriaUser)->toObjectArray();

		if ($list)
		{
			// User found!
			$user->Username = $username;
            $user->IdUser = $list[0]->Id;
            $this->SetCurrentUser($user);
            $this->Redirect("SecureExample.LoginForm");
		}
		else
		{
			// login failed
			$this->Redirect('SecureExample.LoginForm','Unknown username/password combination');
		}
		
		//}
	}
	
	/**
	 * Clear the user session and redirect to the login page
	 */
	public function Logout()
	{
		$this->ClearCurrentUser();
		$this->Redirect("SecureExample.LoginForm","You are now logged out");
	}

}
?>