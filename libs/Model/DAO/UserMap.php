<?php
/** @package    Michat::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");

/**
 * UserMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the UserDAO to the user datastore.
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
class UserMap implements IDaoMap
{
	/**
	 * Returns a singleton array of FieldMaps for the User object
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
			$fm["Id"] = new FieldMap("Id","user","u_id",true,FM_TYPE_INT,11,null,true);
			$fm["Username"] = new FieldMap("Username","user","u_username",false,FM_TYPE_VARCHAR,127,null,false);
			$fm["Password"] = new FieldMap("Password","user","u_password",false,FM_TYPE_VARCHAR,256,null,false);
			$fm["LastSeen"] = new FieldMap("LastSeen","user","u_last_seen",false,FM_TYPE_DATETIME,null,null,false);
			$fm["Connected"] = new FieldMap("Connected","user","u_connected",false,FM_TYPE_TINYINT,1,null,false);
			$fm["PublicProfile"] = new FieldMap("PublicProfile","user","u_public_profile",false,FM_TYPE_TINYINT,1,"1",false);
			$fm["PublicKey"] = new FieldMap("PublicKey","user","u_public_key",false,FM_TYPE_VARCHAR,8,null,false);
		}
		return $fm;
	}

	/**
	 * Returns a singleton array of KeyMaps for the User object
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
			$km["f_FK_sourceUser"] = new KeyMap("f_FK_sourceUser", "Id", "Friendship", "SourceUserId", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			$km["f_FK_targetUser"] = new KeyMap("f_FK_targetUser", "Id", "Friendship", "TargetUserId", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			$km["m_FK_source"] = new KeyMap("m_FK_source", "Id", "Message", "SourceUserId", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
			$km["m_FK_target"] = new KeyMap("m_FK_target", "Id", "Message", "SourceTargetId", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return $km;
	}

}

?>