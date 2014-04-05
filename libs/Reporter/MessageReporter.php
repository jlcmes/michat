<?php
/** @package    Michat::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the Message object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Michat::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class MessageReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `message` table
	public $CustomFieldExample;

	public $Id;
	public $Contents;
	public $TimeStamp;
	public $SourceUserId;
	public $SourceTargetId;
	public $Read;

	/*
	* GetCustomQuery returns a fully formed SQL statement.  The result columns
	* must match with the properties of this reporter object.
	*
	* @see Reporter::GetCustomQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`message`.`m_id` as Id
			,`message`.`m_contents` as Contents
			,`message`.`m_time_stamp` as TimeStamp
			,`message`.`m_source_user_id` as SourceUserId
			,`message`.`m_source_target_id` as SourceTargetId
			,`message`.`m_read` as Read
		from `message`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	/*
	* GetCustomCountQuery returns a fully formed SQL statement that will count
	* the results.  This query must return the correct number of results that
	* GetCustomQuery would, given the same criteria
	*
	* @see Reporter::GetCustomCountQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `message`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>