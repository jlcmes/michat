<?php
/** @package    Michat::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");

/**
 * FriendshipMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the FriendshipDAO to the friendship datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Michat::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class FriendshipMap implements IDaoMap
{
	/**
	 * Returns a singleton array of FieldMaps for the Friendship object
	 *
	 * @access public
	 * @return array of FieldMaps
	 */
	public static function GetFieldMaps()
	{
		static $fm = null;
		if ($fm == null)
		{
			$fm = Array();
			$fm["Id"] = new FieldMap("Id","friendship","f_id",true,FM_TYPE_INT,15,null,true);
			$fm["SourceUserId"] = new FieldMap("SourceUserId","friendship","f_source_user_id",false,FM_TYPE_INT,11,null,false);
			$fm["TargetUserId"] = new FieldMap("TargetUserId","friendship","f_target_user_id",false,FM_TYPE_INT,11,null,false);
			$fm["Accepted"] = new FieldMap("Accepted","friendship","f_accepted",false,FM_TYPE_TINYINT,1,"1",false);
			$fm["Mutual"] = new FieldMap("Mutual","friendship","f_mutual",false,FM_TYPE_TINYINT,1,"1",false);
		}
		return $fm;
	}

	/**
	 * Returns a singleton array of KeyMaps for the Friendship object
	 *
	 * @access public
	 * @return array of KeyMaps
	 */
	public static function GetKeyMaps()
	{
		static $km = null;
		if ($km == null)
		{
			$km = Array();
			$km["f_FK_sourceUser"] = new KeyMap("f_FK_sourceUser", "SourceUserId", "User", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			$km["f_FK_targetUser"] = new KeyMap("f_FK_targetUser", "TargetUserId", "User", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return $km;
	}

}

?>