<?php
/** @package    MICHAT::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/Friendship.php");
require_once("Model/User.php");

/**
 * FriendshipController is the controller class for the Friendship object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package MICHAT::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class FriendshipController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		//$this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of Friendship objects
	 */
	public function ListView()
	{
		$this->RequirePermission(ExampleUser::$PERMISSION_ADMIN, 
				'SecureExample.LoginForm', 
				'Login is required to access this page',
				'Admin permission is required to access this page');
		
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','friendships');
		$this->Render();
	}

	/**
	 * API Method queries for Friendship records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new FriendshipCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,SourceUserId,TargetUserId,Accepted,Mutual'
				, '%'.$filter.'%')
			);

			// Filter all the users that can be viewed by the current user
			$user = $this->GetCurrentUser();

			// ESPECIAL FILTER FOR THE USERS -> FILTER ONLY FRIENDSHIPS WHERE THE USER IS INCLUDED
			// TODO: Future improvement, show only the "accepted" relationships.
			if ($user->Username !== "admin")
			{
				// Obtain the Id of the User searching by name.
				$critUser = new UserCriteria();
				$critUser->Username_Equals = $user->Username;
				$trueUser = $this->Phreezer->Query('User',$critUser)->toObjectArray(); //Take the info of the User
                $id = $trueUser[0]->Id;

                $critFsh = new FriendshipCriteria();
                $critFsh->SourceUserId_Equals = $id;

                $critTarget = new FriendshipCriteria();
				$critTarget->TargetUserId_Equals = $id;

				// Obtain the messages with user source ID or target is the current user ID.
				$criteria->AddOr( $critFsh );
				$criteria->AddOr( $critTarget );
			}

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$friendships = $this->Phreezer->Query('Friendship',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $friendships->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $friendships->TotalResults;
				$output->totalPages = $friendships->TotalPages;
				$output->pageSize = $friendships->PageSize;
				$output->currentPage = $friendships->CurrentPage;
			}
			else
			{
				// return all results
				$friendships = $this->Phreezer->Query('Friendship',$criteria);
				$output->rows = $friendships->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single Friendship record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$friendship = $this->Phreezer->Get('Friendship',$pk);
			$this->RenderJSON($friendship, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new Friendship record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$friendship = new Friendship($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $friendship->Id = $this->SafeGetVal($json, 'id');

			$friendship->SourceUserId = $this->SafeGetVal($json, 'sourceUserId');
			$friendship->TargetUserId = $this->SafeGetVal($json, 'targetUserId');
			$friendship->Accepted = $this->SafeGetVal($json, 'accepted');
			$friendship->Mutual = $this->SafeGetVal($json, 'mutual');

			$friendship->Validate();
			$errors = $friendship->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$friendship->Save();
				$this->RenderJSON($friendship, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing Friendship record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$friendship = $this->Phreezer->Get('Friendship',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $friendship->Id = $this->SafeGetVal($json, 'id', $friendship->Id);

			$friendship->SourceUserId = $this->SafeGetVal($json, 'sourceUserId', $friendship->SourceUserId);
			$friendship->TargetUserId = $this->SafeGetVal($json, 'targetUserId', $friendship->TargetUserId);
			$friendship->Accepted = $this->SafeGetVal($json, 'accepted', $friendship->Accepted);
			$friendship->Mutual = $this->SafeGetVal($json, 'mutual', $friendship->Mutual);

			$friendship->Validate();
			$errors = $friendship->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$friendship->Save();
				$this->RenderJSON($friendship, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing Friendship record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$friendship = $this->Phreezer->Get('Friendship',$pk);

			$friendship->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
