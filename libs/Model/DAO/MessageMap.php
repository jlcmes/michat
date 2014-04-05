<?php
/** @package    Michat::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");

/**
 * MessageMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the MessageDAO to the message datastore.
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
class MessageMap implements IDaoMap
{
	/**
	 * Returns a singleton array of FieldMaps for the Message object
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
			$fm["Id"] = new FieldMap("Id","message","m_id",true,FM_TYPE_INT,18,null,true);
			$fm["Contents"] = new FieldMap("Contents","message","m_contents",false,FM_TYPE_VARCHAR,127,null,false);
			$fm["TimeStamp"] = new FieldMap("TimeStamp","message","m_time_stamp",false,FM_TYPE_DATETIME,null,null,false);
			$fm["SourceUserId"] = new FieldMap("SourceUserId","message","m_source_user_id",false,FM_TYPE_INT,11,null,false);
			$fm["SourceTargetId"] = new FieldMap("SourceTargetId","message","m_source_target_id",false,FM_TYPE_INT,11,null,false);
			$fm["Read"] = new FieldMap("Read","message","m_read",false,FM_TYPE_TINYINT,1,null,false);
		}
		return $fm;
	}

	/**
	 * Returns a singleton array of KeyMaps for the Message object
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
			$km["m_FK_source"] = new KeyMap("m_FK_source", "SourceUserId", "User", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			$km["m_FK_target"] = new KeyMap("m_FK_target", "SourceTargetId", "User", "Id", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return $km;
	}

}

?>